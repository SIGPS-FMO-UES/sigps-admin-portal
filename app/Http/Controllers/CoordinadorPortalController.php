<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CoordinadorPortalController extends Controller
{
    /**
     * Muestra el dashboard del Coordinador de Carrera con supervisión de proyectos,
     * asignación/reasignación de tutores y emisión de aval académico de segundo nivel.
     */
    public function dashboard(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('roles');

        // Proyectos de la escuela o carrera
        $proyectos = Proyecto::query()
            ->with(['tutor', 'alumnos', 'documentos'])
            ->orderBy('codigo_proyecto', 'asc')
            ->get();

        // Docentes Tutores disponibles en la escuela / departamento
        $tutores = Usuario::query()
            ->whereHas('roles', function ($q): void {
                $q->where('name', 'Docente Tutor')->orWhere('nombre_rol', 'Docente Tutor');
            })
            ->withCount('proyectosComoTutor')
            ->orderBy('nombre_completo', 'asc')
            ->get();

        // Expedientes listos para revisión académica de segundo nivel (aprobados por tutor o en revisión)
        $documentosSegundoNivel = Documento::query()
            ->with('proyectos.tutor')
            ->whereIn('estado_revision', ['aprobado_tutor', 'aval_carrera', 'observado_carrera'])
            ->orWhere(function ($q): void {
                $q->whereIn('tipo', ['anteproyecto', 'mitad_proyecto', 'memoria'])
                    ->whereIn('estado_revision', ['aprobado_tutor', 'pendiente_tutor']);
            })
            ->orderBy('id_documento', 'desc')
            ->get();

        // Estadísticas KPI de la Coordinación de Carrera
        $totalProyectos = $proyectos->count();
        $totalTutores = $tutores->count();
        $pendientesAval = $documentosSegundoNivel->where('estado_revision', 'aprobado_tutor')->count();
        $proyectosSinTutor = $proyectos->whereNull('tutor_id')->count();

        return view('coordinador.dashboard', [
            'usuario' => $usuario,
            'proyectos' => $proyectos,
            'tutores' => $tutores,
            'documentosSegundoNivel' => $documentosSegundoNivel,
            'totalProyectos' => $totalProyectos,
            'totalTutores' => $totalTutores,
            'pendientesAval' => $pendientesAval,
            'proyectosSinTutor' => $proyectosSinTutor,
        ]);
    }

    /**
     * Asigna o reasigna un docente tutor a un proyecto (HU-61, HU-62, RF-ACA-01).
     */
    public function asignarTutor(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $validated = $request->validate([
            'tutor_id' => ['required', 'integer', 'exists:usuarios,id_usuario'],
        ], [
            'tutor_id.required' => 'Debe seleccionar un docente tutor.',
            'tutor_id.exists' => 'El tutor seleccionado no existe en el sistema.',
        ]);

        $tutor = Usuario::findOrFail($validated['tutor_id']);
        $tutorAnterior = $proyecto->tutor;

        $proyecto->update([
            'tutor_id' => $tutor->id_usuario,
        ]);

        $esReasignacion = $tutorAnterior && $tutorAnterior->id_usuario !== $tutor->id_usuario;

        // Registrar auditoría e historial de asignación (COO-HU-04, COO-HU-11)
        \App\Models\Auditoria::registrar([
            'modulo' => 'proyectos',
            'id_entidad' => $proyecto->id_proyecto,
            'tipo_entidad' => 'Proyecto',
            'accion' => $esReasignacion ? 'reasignacion_tutor' : 'asignacion_tutor',
            'titulo' => $esReasignacion
                ? "Reasignación de Tutor en Proyecto #{$proyecto->codigo_proyecto}"
                : "Asignación de Tutor en Proyecto #{$proyecto->codigo_proyecto}",
            'detalles' => $esReasignacion
                ? "Tutor anterior: {$tutorAnterior->nombre_completo} ({$tutorAnterior->nombre_usuario}). Nuevo tutor: {$tutor->nombre_completo} ({$tutor->nombre_usuario})."
                : "Docente tutor asignado: {$tutor->nombre_completo} ({$tutor->nombre_usuario}).",
            'metadatos' => [
                'tutor_anterior_id' => $tutorAnterior?->id_usuario,
                'tutor_anterior_nombre' => $tutorAnterior?->nombre_completo,
                'nuevo_tutor_id' => $tutor->id_usuario,
                'nuevo_tutor_nombre' => $tutor->nombre_completo,
                'codigo_proyecto' => $proyecto->codigo_proyecto,
            ],
        ]);

        $mensaje = $esReasignacion
            ? "Tutor reasignado con éxito a '{$tutor->nombre_completo}' para el proyecto #{$proyecto->codigo_proyecto} (HU-62)."
            : "Docente tutor '{$tutor->nombre_completo}' asignado exitosamente al proyecto #{$proyecto->codigo_proyecto} (HU-61).";

        return back()->with('success', $mensaje);
    }

    /**
     * Emite el Aval Académico de segundo nivel o devuelve con observaciones (RF-ACA-05, HU-70, HU-71, HU-72).
     */
    public function emitirAval(Request $request, Documento $documento): RedirectResponse
    {
        $validated = $request->validate([
            'accion' => ['required', 'string', 'in:aval,observar,retractar'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'accion.required' => 'Debe indicar una acción de revisión.',
            'accion.in' => 'La acción seleccionada no es válida.',
        ]);

        $estadoAnterior = $documento->estado_revision;

        if ($validated['accion'] === 'retractar') {
            $obs = $validated['observaciones'] ?? 'Aval Académico retirado por la Coordinación de Carrera. Expediente devuelto a aprobación de tutor.';

            $documento->update([
                'estado_revision' => 'aprobado_tutor',
                'observaciones' => $obs,
                'fecha_dictamen' => now(),
            ]);

            $documento->load('proyectos');

            \App\Models\Auditoria::registrar([
                'modulo' => 'documentos',
                'id_entidad' => $documento->id_documento,
                'tipo_entidad' => 'Documento',
                'accion' => 'retractar_aval_coordinador',
                'titulo' => "Aval Académico Retractado: '{$documento->nombre_documento}'",
                'detalles' => $obs,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'aprobado_tutor',
                'metadatos' => [
                    'version' => $documento->version,
                    'tipo' => $documento->tipo,
                ],
            ]);

            foreach ($documento->proyectos as $proy) {
                $proy->actualizarEstadoAutomatico();
            }

            return back()->with(
                'success',
                "Se ha retirado el aval académico para '{$documento->nombre_documento}'. El expediente regresa al estado Aprobado por Tutor."
            );
        }

        if ($validated['accion'] === 'aval') {
            // Validación rígida: requiere dictamen favorable previo del tutor (COO-HU-10)
            if (! in_array($documento->estado_revision, ['aprobado_tutor', 'aval_carrera'], true)) {
                return back()->with(
                    'error',
                    "No se puede emitir el Aval Académico: el documento '{$documento->nombre_documento}' debe contar previamente con la aprobación del Docente Tutor (COO-HU-10)."
                );
            }

            $obs = $validated['observaciones'] ?? 'Aval Académico institucional emitido por la Coordinación de Carrera. Remitido a la Unidad de Proyección Social (UPS) para auditoría final.';

            $documento->update([
                'estado_revision' => 'aval_carrera',
                'observaciones' => $obs,
                'fecha_dictamen' => now(),
            ]);

            // Registrar auditoría permanente (COO-HU-11)
            \App\Models\Auditoria::registrar([
                'modulo' => 'documentos',
                'id_entidad' => $documento->id_documento,
                'tipo_entidad' => 'Documento',
                'accion' => 'aval_coordinador',
                'titulo' => "Aval Académico Emitido: '{$documento->nombre_documento}'",
                'detalles' => $obs,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'aval_carrera',
                'metadatos' => [
                    'version' => $documento->version,
                    'tipo' => $documento->tipo,
                ],
            ]);

            return back()->with(
                'success',
                "Aval Académico emitido exitosamente para '{$documento->nombre_documento}'. Expediente remitido formalmente a la Unidad de Proyección Social (UPS) (RF-ACA-05, HU-72)."
            );
        }

        // Devolver con observaciones
        $request->validate([
            'observaciones' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'observaciones.required' => 'Debe ingresar las observaciones técnicas que justifican la devolución.',
            'observaciones.min' => 'El motivo de observación debe contener al menos 5 caracteres.',
        ]);

        $motivo = trim((string) $request->input('observaciones'));

        $documento->update([
            'estado_revision' => 'observado_carrera',
            'observaciones' => $motivo,
            'fecha_dictamen' => now(),
        ]);

        // Registrar auditoría permanente (COO-HU-11)
        \App\Models\Auditoria::registrar([
            'modulo' => 'documentos',
            'id_entidad' => $documento->id_documento,
            'tipo_entidad' => 'Documento',
            'accion' => 'observacion_carrera',
            'titulo' => "Devolución con Observaciones por Carrera: '{$documento->nombre_documento}'",
            'detalles' => $motivo,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => 'observado_carrera',
            'metadatos' => [
                'version' => $documento->version,
                'tipo' => $documento->tipo,
            ],
        ]);

        return back()->with(
            'warning',
            "Expediente '{$documento->nombre_documento}' devuelto con observaciones académicas para corrección (HU-71)."
        );
    }
}
