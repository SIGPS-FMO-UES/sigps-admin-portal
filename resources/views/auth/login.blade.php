<!DOCTYPE html>
<html lang="es" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F9FAFB]">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- BANNER LATERAL CON LA MINERVA (IZQUIERDA EN DESKTOP) -->
        <div class="relative w-full lg:w-1/2 xl:w-5/12 min-h-[280px] lg:min-h-screen bg-gray-900 overflow-hidden flex flex-col justify-between p-6 sm:p-10 lg:p-14">
            <!-- Imagen de fondo -->
            <img
                src="/images/minerva.jpg"
                alt="Estatua de Minerva UES"
                class="absolute inset-0 w-full h-full object-cover object-center lg:object-[center_top] filter brightness-95"
            />

            <!-- Capa de gradiente oscuro para legibilidad -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/30 backdrop-blur-[0.5px]"></div>

            <!-- Cabecera del Banner -->
            <div class="relative z-10 flex items-center justify-between w-full">
                <span class="text-xs uppercase tracking-widest text-white/90 font-semibold drop-shadow-sm">
                    &copy; 2026 UES
                </span>

                <!-- Indicador visual slider con punto rojo -->
                <div class="flex items-center gap-1.5 bg-black/30 backdrop-blur-sm px-3 py-1 rounded-full border border-white/10">
                    <div class="w-8 h-1 bg-white/30 rounded-full overflow-hidden flex justify-end">
                        <div class="w-2.5 h-full bg-[#9E1B32] rounded-full"></div>
                    </div>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#9E1B32] animate-pulse"></span>
                </div>
            </div>

            <!-- Contenido Principal del Banner -->
            <div class="relative z-10 mt-auto pt-10">
                <p class="text-xs font-bold uppercase tracking-widest text-white/90 mb-2 drop-shadow-sm">
                    SISTEMA DE PROYECCIÓN SOCIAL
                </p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight drop-shadow-md">
                    Sistema de<br />Proyeccion Social.
                </h1>
                <p class="text-sm sm:text-base text-gray-200 mt-4 leading-relaxed max-w-md font-normal drop-shadow-sm">
                    Organiza tus proyectos, comparte ideas y avanza con claridad, cada día.
                </p>
            </div>
        </div>

        <!-- FORMULARIO DE INICIO DE SESIÓN (DERECHA) -->
        <div class="w-full lg:w-1/2 xl:w-7/12 flex-1 flex flex-col justify-center items-center p-4 sm:p-8 lg:p-14 bg-[#F9FAFB]">
            <main class="w-full max-w-[440px] bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-6 sm:p-10 my-auto transition-all">
                <!-- Título del formulario -->
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                        Bienvenido de nuevo
                    </h2>
                    <p class="text-sm text-gray-500 mt-1.5">
                        Ingresa tus datos para continuar.
                    </p>
                </div>

                <!-- Alertas de estado / error -->
                @if (session('status'))
                    <div class="mb-5 p-3.5 bg-green-50 border border-green-200 text-green-800 text-xs rounded-xl flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <!-- Campo Correo electrónico / Usuario -->
                    <div>
                        <label for="login" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Correo electrónico
                        </label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="carnet@ues.edu.sv"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full px-4 py-3 bg-[#F9FAFB] border @error('login') border-red-400 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] @enderror rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                        />
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                value=""
                                placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-[#F9FAFB] border @error('password') border-red-400 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] @enderror rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all pr-11"
                            />
                            <!-- Botón para alternar visibilidad de contraseña -->
                            <button
                                type="button"
                                id="togglePasswordBtn"
                                aria-label="Mostrar u ocultar contraseña"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer p-1"
                            >
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Enlace de recuperación de contraseña -->
                        <div class="flex justify-end mt-2">
                            <a href="#recuperar" onclick="alert('Función de recuperación: Contacta al administrador UPS.'); return false;" class="text-xs font-medium text-[#8B1D2D] hover:text-[#721523] hover:underline transition-colors">
                                &iquest;Olvidaste tu contrase&ntilde;a?
                            </a>
                        </div>
                    </div>

                    <!-- Botón de inicio de sesión -->
                    <button
                        type="submit"
                        class="w-full py-3.5 px-4 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white font-semibold text-sm rounded-xl shadow-md shadow-[#8B1D2D]/20 hover:shadow-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2"
                    >
                        <span>Iniciar sesión</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    <!-- Divisor "o continúa con" -->
                    <div class="relative my-6 flex items-center justify-center">
                        <div class="border-t border-gray-200 w-full"></div>
                        <span class="bg-white px-3 text-xs text-gray-400 uppercase tracking-wider shrink-0">
                            o continúa con
                        </span>
                        <div class="border-t border-gray-200 w-full"></div>
                    </div>

                    <!-- Botón Google -->
                    <button
                        type="button"
                        onclick="alert('El inicio de sesión institucional con Google Workspace UES estará disponible próximamente.');"
                        class="w-full py-3 px-4 bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 shadow-xs transition-all duration-150 cursor-pointer flex items-center justify-center gap-3"
                    >
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                        </svg>
                        <span>Continuar con Google</span>
                    </button>

                    <!-- Enlace Crear cuenta -->
                    <p class="text-center text-xs text-gray-500 pt-3">
                        &iquest;A&uacute;n no tienes cuenta?
                        <a href="#registro" onclick="alert('El registro de cuentas de alumnos y docentes es gestionado por la Unidad de Proyección Social.'); return false;" class="text-[#15803D] hover:text-[#166534] font-semibold hover:underline ml-1">
                            Crear una cuenta
                        </a>
                    </p>
                </form>

                <!-- CAJA DE ACCESO RÁPIDO PARA PRUEBAS (FACILITA LA REVISIÓN) -->
                <div class="mt-8 pt-5 border-t border-gray-100">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2.5 text-center">
                        ⚡ Credenciales de prueba disponibles
                    </p>
                    <div class="grid grid-cols-3 gap-2">
                        <button
                            type="button"
                            onclick="setCredentials('admin', 'password123')"
                            class="px-2 py-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg text-[11px] text-gray-700 font-medium text-center transition-all cursor-pointer"
                        >
                            👑 Admin
                        </button>
                        <button
                            type="button"
                            onclick="setCredentials('tutor_lopez', 'password123')"
                            class="px-2 py-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg text-[11px] text-gray-700 font-medium text-center transition-all cursor-pointer"
                        >
                            🎓 Tutor
                        </button>
                        <button
                            type="button"
                            onclick="setCredentials('alumno_01', 'password123')"
                            class="px-2 py-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg text-[11px] text-gray-700 font-medium text-center transition-all cursor-pointer"
                        >
                            🎒 Alumno
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Script interactivo para alternar visibilidad de contraseña y autocompletar prueba -->
    <script>
        function setCredentials(username, pass) {
            const loginInput = document.getElementById('login');
            const passInput = document.getElementById('password');
            if (loginInput && passInput) {
                loginInput.value = username;
                passInput.value = pass;
                loginInput.focus();
            }
        }

        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passInput.getAttribute('type') === 'password';
                passInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        }
    </script>
</body>
</html>
