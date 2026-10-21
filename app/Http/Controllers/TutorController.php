<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\RolesUsuario;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TutorController extends Controller
{
    /**
     * Listado de docentes tutores registrados en la base de datos.
     */
    public function index(Request $request): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $departamentos = [
            'Escuela de Ingeniería de Sistemas',
            'Escuela de Ingeniería Industrial',
            'Departamento de Ciencias Básicas',
            'Escuela de Ingeniería Civil',
        ];

        $query = Usuario::query()
            ->whereHas('roles', function ($q): void {
                $q->where('nombre_rol', 'Docente Tutor');
            })
            ->with(['roles', 'proyectosComoTutor']);

        // Filtro de búsqueda por nombre o usuario
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_completo', 'ilike', "%{$search}%");
            });
        }

        $tutores = $query->orderBy('id_usuario', 'asc')->paginate(10)->withQueryString();

        return view('tutores.index', [
            'currentUser' => $currentUser,
            'tutores' => $tutores,
            'departamentos' => $departamentos,
            'search' => $request->input('search', ''),
            'departamentoSeleccionado' => $request->input('departamento', ''),
        ]);
    }

    /**
     * Registra un nuevo docente tutor en la base de datos y le asigna el rol correspondiente.
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
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El usuario o código del tutor es obligatorio.',
            'nombre_usuario.unique' => 'Este usuario ya se encuentra registrado.',
            'nombre_usuario.regex' => 'El usuario sólo puede contener letras, números, guiones y puntos.',
            'nombre_completo.required' => 'El nombre completo del docente tutor es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $passwordRaw = $validated['password'] ?? 'password123';

        $usuario = Usuario::create([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'password' => Hash::make($passwordRaw),
            'activo' => $request->boolean('activo', true),
        ]);

        $rolTutor = Rol::where('nombre_rol', 'Docente Tutor')->first();
        if ($rolTutor) {
            RolesUsuario::firstOrCreate([
                'id_usuario' => $usuario->id_usuario,
                'id_rol' => $rolTutor->id_rol,
            ]);
        }

        return redirect()->route('tutores.index')->with(
            'success',
            "Docente Tutor '{$usuario->nombre_completo}' registrado exitosamente en la base de datos."
        );
    }

    /**
     * Muestra la vista de detalles del docente tutor (Ver).
     */
    public function show(Usuario $tutor): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $tutor->load(['proyectosComoTutor.alumnos', 'roles']);

        return view('tutores.detalles', [
            'currentUser' => $currentUser,
            'tutor' => $tutor,
            'mode' => 'ver',
        ]);
    }

    /**
     * Muestra la misma vista con campos habilitados para edición.
     */
    public function edit(Usuario $tutor): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $tutor->load(['proyectosComoTutor.alumnos', 'roles']);

        return view('tutores.detalles', [
            'currentUser' => $currentUser,
            'tutor' => $tutor,
            'mode' => 'editar',
        ]);
    }

    /**
     * Modifica los datos del docente tutor en la base de datos.
     */
    public function update(Request $request, Usuario $tutor): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_usuario' => [
                'required',
                'string',
                'max:50',
                'unique:usuarios,nombre_usuario,'.$tutor->id_usuario.',id_usuario',
                'regex:/^[a-zA-Z0-9_\-\.]+$/',
            ],
            'nombre_completo' => ['required', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El código o usuario del tutor es obligatorio.',
            'nombre_usuario.unique' => 'Este usuario ya está registrado en el sistema.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
        ]);

        $tutor->update([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'activo' => $request->boolean('activo', true),
        ]);

        return redirect()->route('tutores.show', $tutor)->with(
            'success',
            "Docente Tutor '{$tutor->nombre_completo}' modificado exitosamente."
        );
    }

    /**
     * Elimina el docente tutor de la base de datos previa confirmación.
     */
    public function destroy(Usuario $tutor): RedirectResponse
    {
        $nombre = $tutor->nombre_completo;
        $codigo = $tutor->nombre_usuario;

        // Desvincular de los proyectos donde es tutor
        $tutor->proyectosComoTutor()->update(['tutor_id' => null]);
        $tutor->roles()->detach();

        $tutor->delete();

        return redirect()->route('tutores.index')->with(
            'success',
            "Docente Tutor '{$nombre}' ({$codigo}) eliminado exitosamente de la base de datos."
        );
    }
}
