<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Muestra el listado de usuarios con sus roles asignados y opciones de administración.
     */
    public function index(Request $request): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $query = Usuario::query()->with('roles');

        // Filtro de búsqueda por usuario o nombre
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_completo', 'ilike', "%{$search}%")
                    ->orWhere('correo', 'ilike', "%{$search}%");
            });
        }

        // Filtro por rol específico
        if ($request->filled('rol_id')) {
            $rolId = (int) $request->input('rol_id');
            $query->whereHas('roles', function ($q) use ($rolId): void {
                $q->where('roles.id', $rolId);
            });
        }

        // Filtro por estado activo/inactivo
        if ($request->filled('estado')) {
            $activo = $request->input('estado') === '1';
            $query->where('activo', $activo);
        }

        $usuarios = $query->orderBy('id_usuario', 'asc')->paginate(10)->withQueryString();

        $roles = Rol::orderBy('id', 'asc')->get();

        return view('usuarios.index', [
            'currentUser' => $currentUser,
            'usuarios' => $usuarios,
            'roles' => $roles,
            'search' => $request->input('search', ''),
            'rolSeleccionado' => $request->input('rol_id', ''),
            'estadoSeleccionado' => $request->input('estado', ''),
        ]);
    }

    /**
     * Registra un nuevo usuario en la base de datos asignándole los roles seleccionados.
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
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está registrado en el sistema.',
            'nombre_usuario.regex' => 'El usuario sólo puede contener caracteres alfanuméricos, guiones y puntos.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'correo.email' => 'El formato del correo electrónico ingresado no es válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.',
            'roles.required' => 'Debe seleccionar al menos un rol para el usuario.',
            'roles.min' => 'Debe seleccionar al menos un rol para el usuario.',
            'roles.*.exists' => 'Uno de los roles seleccionados no es válido.',
        ]);

        $passwordRaw = $validated['password'] ?? 'password123';

        $usuario = Usuario::create([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'correo' => ! empty($validated['correo']) ? trim($validated['correo']) : null,
            'password' => Hash::make($passwordRaw),
            'activo' => $request->boolean('activo', true),
        ]);

        // Sincronizar roles en Spatie Permission (asegurando tipos enteros)
        $roleIds = array_map('intval', $validated['roles']);
        $usuario->syncRoles($roleIds);

        return redirect()->route('usuarios.index')->with(
            'success',
            "Usuario '{$usuario->nombre_usuario}' creado exitosamente con sus roles asignados."
        );
    }

    /**
     * Actualiza los roles y el estado de un usuario existente.
     */
    public function updateRoles(Request $request, Usuario $usuario): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'roles.required' => 'Debe seleccionar al menos un rol para el usuario.',
            'roles.min' => 'Debe seleccionar al menos un rol para el usuario.',
            'roles.*.exists' => 'Uno de los roles seleccionados no es válido.',
        ]);

        // Actualizar roles asignados con Spatie (asegurando tipos enteros)
        $roleIds = array_map('intval', $validated['roles']);
        $usuario->syncRoles($roleIds);

        // Actualizar estado si se envió
        $usuario->update([
            'activo' => $request->boolean('activo', false),
        ]);

        return redirect()->route('usuarios.index')->with(
            'success',
            "Roles del usuario '{$usuario->nombre_usuario}' actualizados exitosamente en la base de datos."
        );
    }
}
