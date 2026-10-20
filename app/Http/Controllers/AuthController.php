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

        return redirect()->route('login')->withErrors([
            'login' => 'Las credenciales no son correctas o la cuenta no se encuentra activa.',
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

        $expedientes = [
            ['num' => '001', 'codigo' => '2024-0185', 'area' => 'Capacitación comunitaria', 'profesor' => 'Ana Pérez', 'fecha' => '25/09/2026'],
            ['num' => '002', 'codigo' => '2024-0192', 'area' => 'Alfabetización digital', 'profesor' => 'Luis Alvarez', 'fecha' => '28/09/2026'],
            ['num' => '003', 'codigo' => '2024-0201', 'area' => 'Censo de salud', 'profesor' => 'Dra. López', 'fecha' => '30/09/2026'],
            ['num' => '004', 'codigo' => '2024-0216', 'area' => 'Huerto escolar', 'profesor' => 'Ing. Marta Méndez', 'fecha' => '02/10/2026'],
            ['num' => '005', 'codigo' => '2024-0223', 'area' => 'Apoyo jurídico', 'profesor' => 'Mg. Ricardo Ruiz', 'fecha' => '05/10/2026'],
            ['num' => '006', 'codigo' => '2024-0237', 'area' => 'Ingeniería UES', 'profesor' => 'Arq. Elena Flores', 'fecha' => '08/10/2026'],
            ['num' => '007', 'codigo' => '2024-0244', 'area' => 'Voluntariado ambiental', 'profesor' => 'Ing. Samuel Díaz', 'fecha' => '10/10/2026'],
        ];

        $alertas = [
            ['codigo' => 'Expediente 2024-118', 'plazo' => 'Vence en 5 días', 'dias' => 5],
            ['codigo' => 'Expediente 2024-097', 'plazo' => 'Vence en 8 días', 'dias' => 8],
            ['codigo' => 'Expediente 2024-083', 'plazo' => 'Vence en 12 días', 'dias' => 12],
        ];

        return view('dashboard', [
            'usuario' => $usuario,
            'expedientes' => $expedientes,
            'alertas' => $alertas,
        ]);
    }
}
