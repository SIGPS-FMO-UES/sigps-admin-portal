<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TutorPortalController extends Controller
{
    /**
     * Muestra el dashboard del Docente Tutor con sus estudiantes asignados,
     * expedientes pendientes de dictamen y trazabilidad de acompañamiento técnico.
     */
    public function dashboard(?Request $request = null): View
    {
        $request = $request ?? request();

        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['roles', 'proyectosComoTutor.alumnos', 'proyectosComoTutor.documentos']);

        $search = trim((string) $request->input('search', ''));

        // Proyectos bajo la tutela formal de este docente
        $proyectosQuery = Proyecto::query()
            ->where('tutor_id', $usuario->id_usuario)
            ->with(['alumnos', 'documentos'])
            ->orderBy('codigo_proyecto', 'asc');

        if ($search !== '') {
            $proyectosQuery->where(function ($q) use ($search): void {
                $q->where('nombre_proyecto', 'ilike', "%{$search}%")
                    ->orWhere('codigo_proyecto', 'like', "%{$search}%")
                    ->orWhereHas('alumnos', function ($qa) use ($search): void {
                        $qa->where('nombre_completo', 'ilike', "%{$search}%")
                            ->orWhere('nombre_usuario', 'ilike', "%{$search}%")
                            ->orWhere('correo', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('documentos', function ($qd) use ($search): void {
                        $qd->where('nombre_documento', 'ilike', "%{$search}%")
                            ->orWhere('tipo', 'ilike', "%{$search}%");
                    });
            });
        }

        $proyectos = $proyectosQuery->get();

        // Estudiantes formalmente asignados al tutor
        $estudiantesIds = [];
        $estudiantes = collect();

        foreach ($proyectos as $proyecto) {
            foreach ($proyecto->alumnos as $alumno) {
                if (! in_array($alumno->id_usuario, $estudiantesIds, true)) {
                    $estudiantesIds[] = $alumno->id_usuario;
                    // Adjuntar datos de visualización del proyecto asignado
                    $alumno->proyecto_asignado = $proyecto;
                    $estudiantes->push($alumno);
                }
            }
        }

        // Documentos de los proyectos tutelados para revisión y dictamen (HU-65, RF-ACA-02)
        $proyectoIds = $proyectos->pluck('id_proyecto')->all();

        $documentosPendientes = Documento::query()
            ->whereHas('proyectos', function ($q) use ($proyectoIds): void {
                $q->whereIn('proyectos.id_proyecto', $proyectoIds);
            })
            ->with('proyectos')
            ->orderBy('id_documento', 'desc')
            ->get();

        // Categorizar documentos por proyecto: los que falta aprobar vs otros (aprobados u observados)
        foreach ($proyectos as $proyecto) {
            $proyecto->documentos_pendientes = $proyecto->documentos->filter(function ($doc) {
                return in_array($doc->estado_revision, ['pendiente_tutor', 'pendiente', null], true);
            })->sortByDesc('id_documento')->values();

            $proyecto->documentos_otros = $proyecto->documentos->filter(function ($doc) {
                return ! in_array($doc->estado_revision, ['pendiente_tutor', 'pendiente', null], true);
            })->sortByDesc('id_documento')->values();
        }

        // Ordenar proyectos: aquellos con documentos "Por Dictaminar" aparecen primero en la fila con el ícono amarillo;
        // una vez resueltos (0 pendientes), regresan a su orden natural por código de proyecto.
        $proyectos = $proyectos->sort(function ($a, $b) {
            $aPend = $a->documentos_pendientes->count() > 0 ? 1 : 0;
            $bPend = $b->documentos_pendientes->count() > 0 ? 1 : 0;

            if ($aPend !== $bPend) {
                return $bPend <=> $aPend;
            }

            return $a->codigo_proyecto <=> $b->codigo_proyecto;
        })->values();

        // Estadísticas KPI del Tutor
        $totalEstudiantes = $estudiantes->count();
        $totalProyectos = $proyectos->count();
        $totalPendientes = $proyectos->sum(fn ($p) => $p->documentos_pendientes->count());
        $horasValidadas = $proyectos->where('estado', 'finalizado')->count() * 500
            + $proyectos->where('estado', 'en_proceso')->count() * 250;

        return view('tutor.dashboard', [
            'usuario' => $usuario,
            'proyectos' => $proyectos,
            'estudiantes' => $estudiantes,
            'documentosPendientes' => $documentosPendientes,
            'totalEstudiantes' => $totalEstudiantes,
            'totalProyectos' => $totalProyectos,
            'totalPendientes' => $totalPendientes,
            'horasValidadas' => $horasValidadas,
            'search' => $search,
        ]);
    }

    /**
     * Emite dictamen técnico sobre un documento de expediente (HU-66, HU-67).
     * - Aprobar: lo valida y traslada a Coordinación de Carrera para su aval académico.
     * - Observar / Rechazar: registra observaciones obligatorias y lo devuelve al estudiante.
     * - Retractar: retira el dictamen emitido y regresa el documento a estado pendiente de revisión.
     */
    public function dictamen(Request $request, Documento $documento): RedirectResponse
    {
        $validated = $request->validate([
            'accion' => ['required', 'string', 'in:aprobar,observar,retractar,pendiente'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'accion.required' => 'Debe seleccionar una acción de dictamen.',
            'accion.in' => 'La acción seleccionada no es válida.',
        ]);

        $estadoAnterior = $documento->estado_revision;

        // Retractarse / Revertir dictamen a pendiente
        if (in_array($validated['accion'], ['retractar', 'pendiente'], true)) {
            $obs = $validated['observaciones'] ?? 'Dictamen técnico retirado por el docente tutor. Documento reabierto en estado pendiente de revisión.';

            $documento->update([
                'estado_revision' => 'pendiente_tutor',
                'observaciones' => $obs,
                'motivo_rechazo' => null,
                'fecha_dictamen' => null,
            ]);

            $documento->load('proyectos');

            \App\Models\Auditoria::registrar([
                'modulo' => 'documentos',
                'id_entidad' => $documento->id_documento,
                'tipo_entidad' => 'Documento',
                'accion' => 'retractar_dictamen_tutor',
                'titulo' => "Dictamen Retractado: '{$documento->nombre_documento}'",
                'detalles' => $obs,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'pendiente_tutor',
                'metadatos' => [
                    'version' => $documento->version,
                    'tipo' => $documento->tipo,
                    'proyectos' => $documento->proyectos->pluck('codigo_proyecto')->all(),
                ],
            ]);

            foreach ($documento->proyectos as $proy) {
                $proy->actualizarEstadoAutomatico();
            }

            return back()->with(
                'success',
                "Se ha retractado el dictamen técnico para '{$documento->nombre_documento}'. El documento vuelve al estado Pendiente de Revisión."
            );
        }

        if ($validated['accion'] === 'aprobar') {
            $obs = $validated['observaciones'] ?? 'Dictamen técnico favorable emitido por el docente tutor. Cumple con los requisitos normativos.';

            $documento->update([
                'estado_revision' => 'aprobado_tutor',
                'observaciones' => $obs,
                'motivo_rechazo' => null,
                'fecha_dictamen' => now(),
            ]);

            $documento->load('proyectos');

            // Registrar auditoría permanente (COO-HU-11)
            \App\Models\Auditoria::registrar([
                'modulo' => 'documentos',
                'id_entidad' => $documento->id_documento,
                'tipo_entidad' => 'Documento',
                'accion' => 'aprobacion_tutor',
                'titulo' => "Dictamen Técnico Favorable: '{$documento->nombre_documento}'",
                'detalles' => $obs,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'aprobado_tutor',
                'metadatos' => [
                    'version' => $documento->version,
                    'tipo' => $documento->tipo,
                    'proyectos' => $documento->proyectos->pluck('codigo_proyecto')->all(),
                ],
            ]);

            // Avanzar automáticamente el estado del proyecto según los entregables aprobados
            foreach ($documento->proyectos as $proy) {
                $proy->actualizarEstadoAutomatico();
            }

            return back()->with(
                'success',
                "Dictamen favorable registrado para '{$documento->nombre_documento}'. Trasladado a Coordinación de Carrera para su aval académico (HU-66)."
            );
        }

        // Observar / Rechazar
        $request->validate([
            'observaciones' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'observaciones.required' => 'Debe indicar el motivo u observaciones para devolver el documento.',
            'observaciones.min' => 'El motivo de observación debe contener al menos 5 caracteres.',
        ]);

        $motivo = trim((string) $request->input('observaciones'));

        $documento->update([
            'estado_revision' => 'observado_tutor',
            'observaciones' => $motivo,
            'motivo_rechazo' => $motivo,
            'fecha_dictamen' => now(),
        ]);

        $documento->load('proyectos');

        // Registrar auditoría permanente (COO-HU-11)
        \App\Models\Auditoria::registrar([
            'modulo' => 'documentos',
            'id_entidad' => $documento->id_documento,
            'tipo_entidad' => 'Documento',
            'accion' => 'observacion_tutor',
            'titulo' => "Documento Observado en Dictamen: '{$documento->nombre_documento}'",
            'detalles' => $motivo,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => 'observado_tutor',
            'metadatos' => [
                'version' => $documento->version,
                'tipo' => $documento->tipo,
                'proyectos' => $documento->proyectos->pluck('codigo_proyecto')->all(),
            ],
        ]);

        // Sincronizar el estado del proyecto tras emitir dictamen
        foreach ($documento->proyectos as $proy) {
            $proy->actualizarEstadoAutomatico();
        }

        return back()->with(
            'warning',
            "Documento '{$documento->nombre_documento}' devuelto con observaciones al estudiante para su correspondiente subsanación (HU-67)."
        );
    }
}
