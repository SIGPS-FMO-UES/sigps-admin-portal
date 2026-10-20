<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     * Si el usuario ya está autenticado, lo redirige al panel de control.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'El correo o nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $inputLogin = trim($credentials['login']);
        $password = $credentials['password'];

        // Resolver nombre_usuario: permite ingresar "admin", "admin@ues.edu.sv", o carnet
        $usuario = Usuario::where('nombre_usuario', $inputLogin)->first();

        if (! $usuario && str_contains($inputLogin, '@')) {
            $usernamePrefix = explode('@', $inputLogin)[0];
            $usuario = Usuario::where('nombre_usuario', $usernamePrefix)->first();
        }

        $nombreUsuario = $usuario ? $usuario->nombre_usuario : $inputLogin;

        $remember = $request->boolean('remember');

        if (Auth::attempt(['nombre_usuario' => $nombreUsuario, 'password' => $password, 'activo' => true], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'Las credenciales proporcionadas no son válidas o la cuenta no se encuentra activa.',
        ])->withInput($request->only('login'));
    }

    /**
     * Cierra la sesión activa del usuario.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
    }

    /**
     * Muestra el panel de control para el usuario autenticado.
     */
    public function dashboard(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['roles', 'proyectosComoTutor', 'proyectosComoAlumno']);

        return view('dashboard', [
            'usuario' => $usuario,
        ]);
    }
}
