<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Rol;
use App\Models\RolesUsuario;
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
                $q->where('nombre_rol', 'Estudiante');
            })
            ->with(['proyectosComoAlumno', 'roles']);

        // Filtro por término de búsqueda (Carnet o Nombre)
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_completo', 'ilike', "%{$search}%");
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
            'password' => ['nullable', 'string', 'min:6'],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El carnet o nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este carnet o nombre de usuario ya se encuentra registrado.',
            'nombre_usuario.regex' => 'El carnet sólo puede contener letras, números, guiones y puntos.',
            'nombre_completo.required' => 'El nombre completo del estudiante es obligatorio.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.',
            'id_proyecto.exists' => 'El proyecto seleccionado no existe.',
        ]);

        $passwordRaw = $validated['password'] ?? 'password123';

        // 1. Crear el usuario en la tabla `usuarios`
        $usuario = Usuario::create([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'password' => Hash::make($passwordRaw),
            'activo' => $request->boolean('activo', true),
        ]);

        // 2. Asignar el rol de 'Estudiante' en `roles_usuario`
        $rolEstudiante = Rol::where('nombre_rol', 'Estudiante')->first();
        if ($rolEstudiante) {
            RolesUsuario::firstOrCreate([
                'id_usuario' => $usuario->id_usuario,
                'id_rol' => $rolEstudiante->id_rol,
            ]);
        }

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
}
