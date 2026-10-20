<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    /**
     * Listado de proyectos de proyección social registrados en la base de datos.
     */
    public function index(Request $request): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $estados = [
            'solicitado' => 'Solicitado',
            'en_inscripcion' => 'En Inscripción',
            'en_proceso' => 'En Proceso',
            'en_finalizacion' => 'En Finalización',
            'finalizado' => 'Finalizado',
        ];

        $query = Proyecto::query()->with(['tutor', 'alumnos', 'documentos']);

        // Filtro de búsqueda por nombre o código
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_proyecto', 'ilike', "%{$search}%");
                if (is_numeric($search)) {
                    $q->orWhere('codigo_proyecto', (int) $search);
                }
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro por tutor asignado
        if ($request->filled('tutor_id')) {
            $query->where('tutor_id', (int) $request->input('tutor_id'));
        }

        $proyectos = $query->orderBy('codigo_proyecto', 'asc')->paginate(10)->withQueryString();

        $tutores = Usuario::whereHas('roles', function ($q): void {
            $q->where('nombre_rol', 'Docente Tutor');
        })->orderBy('nombre_completo')->get();

        return view('proyectos.index', [
            'currentUser' => $currentUser,
            'proyectos' => $proyectos,
            'tutores' => $tutores,
            'estados' => $estados,
            'search' => $request->input('search', ''),
            'estadoSeleccionado' => $request->input('estado', ''),
            'tutorSeleccionado' => $request->input('tutor_id', ''),
        ]);
    }

    /**
     * Registra un nuevo proyecto en la base de datos con su código único, estado y tutor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'codigo_proyecto' => ['required', 'integer', 'unique:proyectos,codigo_proyecto'],
            'nombre_proyecto' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'in:solicitado,en_inscripcion,en_proceso,en_finalizacion,finalizado'],
            'tutor_id' => ['nullable', 'integer', 'exists:usuarios,id_usuario'],
        ], [
            'codigo_proyecto.required' => 'El código de proyecto es obligatorio.',
            'codigo_proyecto.unique' => 'Este código de proyecto ya se encuentra registrado.',
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'estado.required' => 'El estado inicial del proyecto es obligatorio.',
            'tutor_id.exists' => 'El docente tutor seleccionado no existe.',
        ]);

        $proyecto = Proyecto::create([
            'codigo_proyecto' => (int) $validated['codigo_proyecto'],
            'nombre_proyecto' => trim($validated['nombre_proyecto']),
            'estado' => $validated['estado'],
            'tutor_id' => ! empty($validated['tutor_id']) ? (int) $validated['tutor_id'] : null,
        ]);

        return redirect()->route('proyectos.index')->with(
            'success',
            "Proyecto '[{$proyecto->codigo_proyecto}] {$proyecto->nombre_proyecto}' creado exitosamente en la base de datos."
        );
    }
}
