<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    /**
     * Muestra el listado de estudiantes registrados en la base de datos con filtros y paginación.
     */
    public function index(Request $request): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $carreras = [
            'Ingeniería de Sistemas Informáticos',
            'Ingeniería Industrial',
            'Licenciatura en Computación',
            'Ingeniería Civil',
            'Ingeniería Eléctrica',
            'Licenciatura en Educación',
        ];

        $departamentos = [
            'Escuela de Ingeniería de Sistemas',
            'Escuela de Ingeniería Industrial',
            'Departamento de Ciencias Básicas',
            'Escuela de Ingeniería Civil',
        ];

        $query = Usuario::query()
            ->whereHas('roles', function ($q): void {
                $q->where('name', 'Estudiante')->orWhere('nombre_rol', 'Estudiante');
            })
            ->with(['proyectosComoAlumno', 'roles']);

        // Filtro por término de búsqueda (Carnet o Nombre)
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_completo', 'ilike', "%{$search}%")
                    ->orWhere('correo', 'ilike', "%{$search}%");
            });
        }

        // Si es Docente Tutor, mostrar únicamente los estudiantes bajo su tutela (HU-63)
        if ($currentUser->hasRole('Docente Tutor')) {
            $query->whereHas('proyectosComoAlumno', function ($q) use ($currentUser): void {
                $q->where('tutor_id', $currentUser->id_usuario);
            });
        }

        $estudiantes = $query->orderBy('id_usuario', 'asc')->paginate(10)->withQueryString();

        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        return view('estudiantes.index', [
            'currentUser' => $currentUser,
            'estudiantes' => $estudiantes,
            'proyectos' => $proyectos,
            'carreras' => $carreras,
            'departamentos' => $departamentos,
            'search' => $request->input('search', ''),
            'carreraSeleccionada' => $request->input('carrera', ''),
            'departamentoSeleccionado' => $request->input('departamento', ''),
        ]);
    }

    /**
     * Registra un nuevo estudiante en la base de datos y asigna su rol y proyecto opcional.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_usuario' => [
                'required',
                'string',
                'max:50',
                'unique:usuarios,nombre_usuario',
                'regex:/^[a-zA-Z0-9_\-\.]+$/',
            ],
            'nombre_completo' => ['required', 'string', 'max:255'],
            'correo' => ['nullable', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
            'password' => ['nullable', 'string', 'min:6'],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El carnet o nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este carnet o nombre de usuario ya se encuentra registrado.',
            'nombre_usuario.regex' => 'El carnet sólo puede contener letras, números, guiones y puntos.',
            'nombre_completo.required' => 'El nombre completo del estudiante es obligatorio.',
            'correo.email' => 'El formato del correo electrónico ingresado no es válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.',
            'id_proyecto.exists' => 'El proyecto seleccionado no existe.',
        ]);

        $passwordRaw = $validated['password'] ?? 'password123';

        // 1. Crear el usuario en la tabla `usuarios`
        $usuario = Usuario::create([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'correo' => ! empty($validated['correo']) ? trim($validated['correo']) : null,
            'password' => Hash::make($passwordRaw),
            'activo' => $request->boolean('activo', true),
        ]);

        // 2. Asignar el rol de 'Estudiante' mediante Spatie
        $usuario->assignRole('Estudiante');

        // 3. Si se seleccionó un proyecto, asociarlo en `proyectos_alumnos`
        if (! empty($validated['id_proyecto'])) {
            ProyectosAlumno::firstOrCreate([
                'id_alumno' => $usuario->id_usuario,
                'id_proyecto' => (int) $validated['id_proyecto'],
            ]);
        }

        return redirect()->route('estudiantes.index')->with(
            'success',
            "Estudiante '{$usuario->nombre_completo}' ({$usuario->nombre_usuario}) registrado exitosamente en la base de datos."
        );
    }

    /**
     * Muestra la vista de detalles del estudiante (Ver).
     */
    public function show(Usuario $estudiante): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $estudiante->load(['proyectosComoAlumno', 'roles']);
        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        return view('estudiantes.detalles', [
            'currentUser' => $currentUser,
            'estudiante' => $estudiante,
            'proyectos' => $proyectos,
            'mode' => 'ver',
        ]);
    }

    /**
     * Muestra la misma vista con campos habilitados para edición.
     */
    public function edit(Usuario $estudiante): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $estudiante->load(['proyectosComoAlumno', 'roles']);
        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        return view('estudiantes.detalles', [
            'currentUser' => $currentUser,
            'estudiante' => $estudiante,
            'proyectos' => $proyectos,
            'mode' => 'editar',
        ]);
    }

    /**
     * Modifica los datos del estudiante y su proyecto asociado.
     */
    public function update(Request $request, Usuario $estudiante): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_usuario' => [
                'required',
                'string',
                'max:50',
                'unique:usuarios,nombre_usuario,'.$estudiante->id_usuario.',id_usuario',
                'regex:/^[a-zA-Z0-9_\-\.]+$/',
            ],
            'nombre_completo' => ['required', 'string', 'max:255'],
            'correo' => ['nullable', 'string', 'email', 'max:255', 'unique:usuarios,correo,'.$estudiante->id_usuario.',id_usuario'],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El carnet o nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este carnet o usuario ya se encuentra registrado.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'correo.email' => 'El formato del correo electrónico ingresado no es válido.',
            'correo.unique' => 'Este correo electrónico ya está en uso por otro usuario.',
            'id_proyecto.exists' => 'El proyecto seleccionado no existe.',
        ]);

        $estudiante->update([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'correo' => ! empty($validated['correo']) ? trim($validated['correo']) : null,
            'activo' => $request->boolean('activo', true),
        ]);

        // Sincronizar proyecto asociado
        if (! empty($validated['id_proyecto'])) {
            $estudiante->proyectosComoAlumno()->sync([(int) $validated['id_proyecto']]);
        } else {
            $estudiante->proyectosComoAlumno()->detach();
        }

        return redirect()->route('estudiantes.show', $estudiante)->with(
            'success',
            "Estudiante '{$estudiante->nombre_completo}' modificado exitosamente."
        );
    }

    /**
     * Elimina el estudiante de la base de datos previa confirmación.
     */
    public function destroy(Usuario $estudiante): RedirectResponse
    {
        $nombre = $estudiante->nombre_completo;
        $carnet = $estudiante->nombre_usuario;

        // Desvincular proyectos y roles asignados
        $estudiante->proyectosComoAlumno()->detach();
        $estudiante->roles()->detach();

        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with(
            'success',
            "Estudiante '{$nombre}' ({$carnet}) eliminado exitosamente de la base de datos."
        );
    }
}
