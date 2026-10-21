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

    /**
     * Muestra la vista de detalles del proyecto (Ver).
     */
    public function show(Proyecto $proyecto): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $proyecto->load(['tutor', 'alumnos', 'documentos']);

        $tutores = Usuario::whereHas('roles', function ($q): void {
            $q->where('nombre_rol', 'Docente Tutor');
        })->orderBy('nombre_completo')->get();

        return view('proyectos.detalles', [
            'currentUser' => $currentUser,
            'proyecto' => $proyecto,
            'tutores' => $tutores,
            'mode' => 'ver',
        ]);
    }

    /**
     * Muestra la misma vista con los campos listos para editar.
     */
    public function edit(Proyecto $proyecto): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $proyecto->load(['tutor', 'alumnos', 'documentos']);

        $tutores = Usuario::whereHas('roles', function ($q): void {
            $q->where('nombre_rol', 'Docente Tutor');
        })->orderBy('nombre_completo')->get();

        return view('proyectos.detalles', [
            'currentUser' => $currentUser,
            'proyecto' => $proyecto,
            'tutores' => $tutores,
            'mode' => 'editar',
        ]);
    }

    /**
     * Modifica los datos del proyecto en la base de datos.
     */
    public function update(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_proyecto' => ['required', 'string', 'max:255'],
            'codigo_proyecto' => ['nullable', 'integer', 'unique:proyectos,codigo_proyecto,'.$proyecto->id_proyecto.',id_proyecto'],
            'estado' => ['nullable', 'string', 'in:solicitado,en_inscripcion,en_proceso,en_finalizacion,finalizado'],
            'tutor_id' => ['nullable', 'integer', 'exists:usuarios,id_usuario'],
        ], [
            'nombre_proyecto.required' => 'El título del proyecto es obligatorio.',
            'codigo_proyecto.unique' => 'Este código de proyecto ya se encuentra en uso.',
            'tutor_id.exists' => 'El tutor seleccionado no existe en el sistema.',
        ]);

        $updateData = [
            'nombre_proyecto' => trim($validated['nombre_proyecto']),
        ];

        if (! empty($validated['codigo_proyecto'])) {
            $updateData['codigo_proyecto'] = (int) $validated['codigo_proyecto'];
        }

        if (! empty($validated['estado'])) {
            $updateData['estado'] = $validated['estado'];
        }

        if ($request->has('tutor_id')) {
            $updateData['tutor_id'] = ! empty($validated['tutor_id']) ? (int) $validated['tutor_id'] : null;
        }

        $proyecto->update($updateData);

        return redirect()->route('proyectos.show', $proyecto)->with(
            'success',
            "Proyecto '[{$proyecto->codigo_proyecto}] {$proyecto->nombre_proyecto}' modificado exitosamente."
        );
    }

    /**
     * Elimina el proyecto de la base de datos previa confirmación.
     */
    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $nombre = $proyecto->nombre_proyecto;
        $codigo = $proyecto->codigo_proyecto;

        $proyecto->delete();

        return redirect()->route('proyectos.index')->with(
            'success',
            "Proyecto '[{$codigo}] {$nombre}' eliminado exitosamente de la base de datos."
        );
    }
}
