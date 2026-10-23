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
    public function dashboard(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['roles', 'proyectosComoTutor.alumnos', 'proyectosComoTutor.documentos']);

        // Proyectos bajo la tutela formal de este docente
        $proyectos = Proyecto::query()
            ->where('tutor_id', $usuario->id_usuario)
            ->with(['alumnos', 'documentos'])
            ->orderBy('codigo_proyecto', 'asc')
            ->get();

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

        // Estadísticas KPI del Tutor
        $totalEstudiantes = $estudiantes->count();
        $totalProyectos = $proyectos->count();
        $totalPendientes = $documentosPendientes->where('estado_revision', 'pendiente_tutor')->count();
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
        ]);
    }

    /**
     * Emite dictamen técnico sobre un documento de expediente (HU-66, HU-67).
     * - Aprobar: lo valida y traslada a Coordinación de Carrera para su aval académico.
     * - Observar / Rechazar: registra observaciones obligatorias y lo devuelve al estudiante.
     */
    public function dictamen(Request $request, Documento $documento): RedirectResponse
    {
        $validated = $request->validate([
            'accion' => ['required', 'string', 'in:aprobar,observar'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'accion.required' => 'Debe seleccionar una acción de dictamen.',
            'accion.in' => 'La acción seleccionada no es válida.',
        ]);

        if ($validated['accion'] === 'aprobar') {
            $documento->update([
                'estado_revision' => 'aprobado_tutor',
                'observaciones' => $validated['observaciones'] ?? 'Dictamen técnico favorable emitido por el docente tutor. Cumple con los requisitos normativos.',
                'fecha_dictamen' => now(),
            ]);

            return back()->with(
                'success',
                "Dictamen favorable registrado para '{$documento->nombre_documento}'. Trasladado a Coordinación de Carrera para su aval académico (HU-66)."
            );
        }

        // Observar / Rechazar
        $request->validate([
            'observaciones' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'observaciones.required' => 'Debe indicar el motivo u observaciones para devolver el documento.',
            'observaciones.min' => 'El motivo de observación debe contener al menos 10 caracteres.',
        ]);

        $documento->update([
            'estado_revision' => 'observado_tutor',
            'observaciones' => trim((string) $request->input('observaciones')),
            'fecha_dictamen' => now(),
        ]);

        return back()->with(
            'warning',
            "Documento '{$documento->nombre_documento}' devuelto con observaciones al estudiante para su correspondiente subsanación (HU-67)."
        );
    }
}
