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

        $mensaje = $tutorAnterior && $tutorAnterior->id_usuario !== $tutor->id_usuario
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
            'accion' => ['required', 'string', 'in:aval,observar'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'accion.required' => 'Debe indicar una acción de revisión.',
            'accion.in' => 'La acción seleccionada no es válida.',
        ]);

        if ($validated['accion'] === 'aval') {
            $documento->update([
                'estado_revision' => 'aval_carrera',
                'observaciones' => $validated['observaciones'] ?? 'Aval Académico institucional emitido por la Coordinación de Carrera. Remitido a la Unidad de Proyección Social (UPS) para auditoría final.',
                'fecha_dictamen' => now(),
            ]);

            return back()->with(
                'success',
                "Aval Académico emitido exitosamente para '{$documento->nombre_documento}'. Expediente remitido formalmente a la Unidad de Proyección Social (UPS) (RF-ACA-05, HU-72)."
            );
        }

        // Devolver con observaciones
        $request->validate([
            'observaciones' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'observaciones.required' => 'Debe ingresar las observaciones técnicas que justifican la devolución.',
            'observaciones.min' => 'El motivo de observación debe contener al menos 10 caracteres.',
        ]);

        $documento->update([
            'estado_revision' => 'observado_carrera',
            'observaciones' => trim((string) $request->input('observaciones')),
            'fecha_dictamen' => now(),
        ]);

        return back()->with(
            'warning',
            "Expediente '{$documento->nombre_documento}' devuelto con observaciones académicas para corrección (HU-71)."
        );
    }
}
