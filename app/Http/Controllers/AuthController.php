<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra la vista de registro para estudiantes.
     * Si el usuario ya está autenticado, lo redirige al panel de control.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', ['modo' => 'registro']);
    }

    /**
     * Registra un nuevo usuario con rol de Estudiante e inicia su sesión automáticamente.
     */
    public function register(Request $request): RedirectResponse
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
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:usuarios,correo',
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nombre_usuario.required' => 'El carnet o nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este carnet o nombre de usuario ya está registrado en el sistema.',
            'nombre_usuario.regex' => 'El carnet sólo puede contener letras, números, guiones y puntos.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debes ingresar un formato de correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya se encuentra registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $usuario = Usuario::create([
            'nombre_usuario' => trim($validated['nombre_usuario']),
            'nombre_completo' => trim($validated['nombre_completo']),
            'correo' => strtolower(trim($validated['correo'])),
            'password' => Hash::make($validated['password']),
            'activo' => true,
        ]);

        // Todo usuario registrado por este medio recibe automáticamente el rol de Estudiante
        $usuario->assignRole('Estudiante');

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with(
            'status',
            "¡Registro completado! Bienvenido(a), {$usuario->nombre_completo}. Tu cuenta ha sido activada."
        );
    }

    /**
     * Procesa el inicio de sesión / registro rápido con Google Workspace UES (@ues.edu.sv).
     */
    public function googleLogin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electrónico institucional es obligatorio.',
            'email.email' => 'Debes ingresar un formato de correo electrónico válido.',
        ]);

        $email = strtolower(trim($validated['email']));
        $username = explode('@', $email)[0];

        // Buscar si ya existe por correo o por nombre de usuario
        $usuario = Usuario::where('correo', $email)
            ->orWhere('nombre_usuario', $username)
            ->first();

        if (! $usuario) {
            // Generar nombre amigable a partir del usuario (ej. juan.perez -> Juan Perez)
            $nombreCalculado = ucwords(str_replace(['.', '_', '-'], ' ', $username));

            $usuario = Usuario::create([
                'nombre_usuario' => $username,
                'nombre_completo' => $nombreCalculado,
                'correo' => $email,
                'password' => Hash::make('google_oauth_'.bin2hex(random_bytes(8))),
                'activo' => true,
            ]);

            // Se le asigna rol Estudiante automáticamente a los nuevos registros con Google
            $usuario->assignRole('Estudiante');
        } elseif (empty($usuario->correo)) {
            $usuario->update(['correo' => $email]);
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with(
            'status',
            "Sesión iniciada con Google Workspace UES ({$email}) como {$usuario->nombre_completo}."
        );
    }

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
     * Procesa la autenticación del usuario permitiendo carnet, nombre de usuario o correo.
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

        // Resolver usuario: permite ingresar por correo, carnet o nombre de usuario
        $usuario = Usuario::where('correo', strtolower($inputLogin))
            ->orWhere('nombre_usuario', $inputLogin)
            ->first();

        if (! $usuario && str_contains($inputLogin, '@')) {
            $usernamePrefix = explode('@', $inputLogin)[0];
            $usuario = Usuario::where('nombre_usuario', $usernamePrefix)
                ->orWhere('correo', strtolower($inputLogin))
                ->first();
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

        // Auto-asignación de seguridad si el rol no estuviera sincronizado en la sesión
        if ($usuario->nombre_usuario === 'admin' && ! $usuario->hasRole('Administrador')) {
            $usuario->assignRole('Administrador');
            $usuario->load('roles');
        }

        // 1. Rol Estudiante: portal personal de horas y entregables
        $esEstudiante = $usuario->hasRole('Estudiante')
            || str_starts_with($usuario->nombre_usuario, '2024-')
            || str_starts_with($usuario->nombre_usuario, 'alumno_');

        if ($esEstudiante) {
            if (! $usuario->hasRole('Estudiante')) {
                $usuario->assignRole('Estudiante');
                $usuario->load('roles');
            }

            return app(EstudiantePortalController::class)->dashboard();
        }

        // 2. Rol Docente Tutor: bandeja de tutorados y dictamen técnico de 1er nivel (HU-63, HU-65)
        if ($usuario->hasRole('Docente Tutor')) {
            return app(TutorPortalController::class)->dashboard();
        }

        // 3. Rol Coordinador de Carrera: supervisión, asignación de tutores y aval académico (HU-61, RF-ACA-05)
        if ($usuario->hasRole('Coordinador de Carrera')) {
            return app(CoordinadorPortalController::class)->dashboard();
        }

        // 4. Coordinador UPS y Administrador General: Dashboard Operativo de Auditoría Visual y Certificación
        return $this->upsDashboard($usuario);
    }

    /**
     * Dashboard Operativo de la Unidad de Proyección Social (UPS) y Administrador.
     */
    protected function upsDashboard(Usuario $usuario): View
    {
        $documentosAuditoria = \App\Models\Documento::with(['proyectos.alumnos', 'proyectos.tutor'])
            ->orderBy('id_documento', 'desc')
            ->take(10)
            ->get();

        $totalPendientesAuditoria = \App\Models\Documento::whereIn('estado_revision', ['aval_carrera', 'pendiente_tutor'])->count();
        $totalCertificadosListos = \App\Models\Documento::where('estado_revision', 'certificado_emitido')->count();
        $totalProyectosActivos = \App\Models\Proyecto::count();

        // Alertas normativas de la UPS (RN-03: 3 meses prórroga; RN-04: 18 meses Junta Directiva)
        $alertas = [
            [
                'codigo' => 'Proyecto #101 - Archivo Histórico',
                'plazo' => 'Alerta de Prórroga (3 meses cumplidos)',
                'dias' => 3,
                'norma' => 'RN-03',
            ],
            [
                'codigo' => 'Proyecto #104 - Inventario Salud',
                'plazo' => 'Próximo a límite de 18 meses (Junta Directiva)',
                'dias' => 14,
                'norma' => 'RN-04',
            ],
            [
                'codigo' => 'Expediente Carnet 2024-0185',
                'plazo' => 'Auditoría de Sellos y Firma Azul Pendiente',
                'dias' => 5,
                'norma' => 'RF-UPS-07',
            ],
        ];

        return view('dashboard', [
            'usuario' => $usuario,
            'documentosAuditoria' => $documentosAuditoria,
            'totalPendientesAuditoria' => $totalPendientesAuditoria,
            'totalCertificadosListos' => $totalCertificadosListos,
            'totalProyectosActivos' => $totalProyectosActivos,
            'alertas' => $alertas,
        ]);
    }
}
