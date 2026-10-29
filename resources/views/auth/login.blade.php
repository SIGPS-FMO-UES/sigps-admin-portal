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
                <div class="flex items-center gap-2.5">
                    <img src="/images/logo.png" alt="Logo UES" class="w-8 h-8 object-contain drop-shadow" />
                    <span class="text-xs uppercase tracking-widest text-white/90 font-semibold drop-shadow-sm">
                        &copy; 2026 UES
                    </span>
                </div>

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
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <img src="/images/logo.png" alt="Logo UES" class="w-7 h-7 object-contain" />
                        <span class="text-xs font-bold uppercase tracking-wider text-[#8B1D2D]">SIGPS &bull; UES</span>
                    </div>

                    <!-- Encabezado Modo Login -->
                    <div id="loginHeader">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                            Bienvenido de nuevo
                        </h2>
                        <p class="text-sm text-gray-500 mt-1.5">
                            Ingresa tus datos para continuar.
                        </p>
                    </div>

                    <!-- Encabezado Modo Registro -->
                    <div id="registerHeader" class="hidden">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                            Crear cuenta
                        </h2>
                        <p class="text-sm text-gray-500 mt-1.5">
                            Ingresa tus datos para registrarte en el sistema.
                        </p>
                    </div>
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

                <!-- ================= VISTA DE LOGIN ================= -->
                <div id="loginSection">
                    <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        <!-- Campo Correo electrónico / Usuario -->
                        <div>
                            <label for="login" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Correo electrónico o carnet
                            </label>
                            <input
                                type="text"
                                id="login"
                                name="login"
                                value="{{ old('login') }}"
                                placeholder="carnet@ues.edu.sv o carnet"
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

                        <!-- Enlace Crear cuenta -->
                        <p class="text-center text-xs text-gray-500 pt-2">
                            &iquest;A&uacute;n no tienes cuenta?
                            <a href="#registro" id="createAccountLink" onclick="showRegisterForm(); return false;" class="text-[#15803D] hover:text-[#166534] font-semibold hover:underline ml-1 cursor-pointer">
                                Crear una cuenta
                            </a>
                        </p>
                    </form>

                    <!-- ACCESO RÁPIDO PARA TESTING (DESPLEGABLE AL PRESIONAR LA BARRA DIVISORIA) -->
                    <div class="mt-8">
                        <!-- Barra divisoria interactiva para testing -->
                        <button
                            type="button"
                            id="toggleTestRolesBtn"
                            onclick="toggleTestRoles()"
                            class="w-full flex items-center justify-center py-2 group cursor-pointer border-none bg-transparent focus:outline-none"
                            title="Opciones de testing"
                            aria-expanded="false"
                            aria-controls="testRolesContainer"
                        >
                            <div class="h-px bg-gray-200 group-hover:bg-gray-400 flex-1 transition-colors"></div>
                            <span class="mx-3 w-8 h-1 bg-gray-200 group-hover:bg-gray-400 rounded-full transition-colors"></span>
                            <div class="h-px bg-gray-200 group-hover:bg-gray-400 flex-1 transition-colors"></div>
                        </button>

                        <!-- Contenedor desplegable (oculto por defecto para pruebas) -->
                        <div id="testRolesContainer" class="hidden pt-3 transition-all duration-200">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <!-- 1. Estudiante -->
                                <button
                                    type="button"
                                    onclick="setCredentials('2024-0185', 'password123')"
                                    class="py-2.5 px-3 bg-emerald-50/70 hover:bg-emerald-100/90 border border-emerald-200/80 hover:border-emerald-300 rounded-xl text-center text-xs font-medium text-emerald-800 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Estudiante
                                </button>

                                <!-- 2. Docente Tutor -->
                                <button
                                    type="button"
                                    onclick="setCredentials('tutor_lopez', 'password123')"
                                    class="py-2.5 px-3 bg-blue-50/70 hover:bg-blue-100/90 border border-blue-200/80 hover:border-blue-300 rounded-xl text-center text-xs font-medium text-blue-800 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Docente Tutor
                                </button>

                                <!-- 3. Coordinador de Carrera -->
                                <button
                                    type="button"
                                    onclick="setCredentials('coord_ing', 'password123')"
                                    class="py-2.5 px-3 bg-indigo-50/70 hover:bg-indigo-100/90 border border-indigo-200/80 hover:border-indigo-300 rounded-xl text-center text-xs font-medium text-indigo-800 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Coord. Carrera
                                </button>

                                <!-- 4. Coordinador UPS -->
                                <button
                                    type="button"
                                    onclick="setCredentials('coord_ups', 'password123')"
                                    class="py-2.5 px-3 bg-rose-50/70 hover:bg-rose-100/90 border border-rose-200/80 hover:border-rose-300 rounded-xl text-center text-xs font-medium text-[#8B1D2D] transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Coord. UPS
                                </button>

                                <!-- 5. Auxiliar UPS -->
                                <button
                                    type="button"
                                    onclick="setCredentials('aux_ups', 'password123')"
                                    class="py-2.5 px-3 bg-amber-50/70 hover:bg-amber-100/90 border border-amber-200/80 hover:border-amber-300 rounded-xl text-center text-xs font-medium text-amber-900 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Auxiliar UPS
                                </button>

                                <!-- 6. Administrador -->
                                <button
                                    type="button"
                                    onclick="setCredentials('admin', 'password123')"
                                    class="py-2.5 px-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 rounded-xl text-center text-xs font-medium text-gray-800 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                                >
                                    Administrador
                                </button>
                            </div>
                        </div>
                    </div>
            </div><!-- /#loginSection -->

            <!-- ================= VISTA DE REGISTRO ================= -->
            <div id="registerSection" class="hidden">
                <form id="registerForm" method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Campo Carnet o Usuario -->
                    <div>
                        <label for="reg_nombre_usuario" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Carnet institucional o usuario <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="reg_nombre_usuario"
                            name="nombre_usuario"
                            value="{{ old('nombre_usuario') }}"
                            placeholder="ej. AB24001"
                            required
                            autocomplete="username"
                            class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                        />
                    </div>

                    <!-- Campo Nombre Completo -->
                    <div>
                        <label for="reg_nombre_completo" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="reg_nombre_completo"
                            name="nombre_completo"
                            value="{{ old('nombre_completo') }}"
                            placeholder="ej. Juan Carlos López Pérez"
                            required
                            class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                        />
                    </div>

                    <!-- Campo Correo Electrónico -->
                    <div>
                        <label for="reg_correo" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="reg_correo"
                            name="correo"
                            value="{{ old('correo') }}"
                            placeholder="ej. usuario@ues.edu.sv"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                        />
                    </div>

                    <!-- Campos Contraseñas en Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="reg_password" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="reg_password"
                                    name="password"
                                    placeholder="Mín. 6 caracteres"
                                    required
                                    autocomplete="new-password"
                                    class="w-full px-3.5 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all pr-9"
                                />
                                <button
                                    type="button"
                                    id="toggleRegPasswordBtn"
                                    aria-label="Alternar contraseña"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer p-0.5"
                                >
                                    <svg id="eyeRegIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label for="reg_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Confirmar <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="password"
                                id="reg_password_confirmation"
                                name="password_confirmation"
                                placeholder="Repite la clave"
                                required
                                autocomplete="new-password"
                                class="w-full px-3.5 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                            />
                        </div>
                    </div>

                    <!-- Botón Registrarse -->
                    <button
                        type="submit"
                        class="w-full py-3.5 px-4 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white font-semibold text-sm rounded-xl shadow-md shadow-[#8B1D2D]/20 hover:shadow-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 mt-2"
                    >
                        <span>Crear cuenta e iniciar sesión</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    <!-- Enlace volver a Login -->
                    <p class="text-center text-xs text-gray-500 pt-3">
                        &iquest;Ya tienes una cuenta creada?
                        <a href="#login" onclick="showLoginForm(); return false;" class="text-[#8B1D2D] hover:text-[#721523] font-semibold hover:underline ml-1 cursor-pointer">
                            Iniciar sesión
                        </a>
                    </p>
                </form>
            </div><!-- /#registerSection -->
        </main>
    </div>
</div>

    <!-- Scripts interactivos -->
    <script>
        function showRegisterForm() {
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('registerSection').classList.remove('hidden');
            document.getElementById('loginHeader').classList.add('hidden');
            document.getElementById('registerHeader').classList.remove('hidden');
            history.replaceState(null, '', '#registro');
            const regCarnet = document.getElementById('reg_nombre_usuario');
            if (regCarnet) regCarnet.focus();
        }

        function showLoginForm() {
            document.getElementById('registerSection').classList.add('hidden');
            document.getElementById('loginSection').classList.remove('hidden');
            document.getElementById('registerHeader').classList.add('hidden');
            document.getElementById('loginHeader').classList.remove('hidden');
            history.replaceState(null, '', '#login');
            const loginInput = document.getElementById('login');
            if (loginInput) loginInput.focus();
        }

        // Detectar si debe abrir en modo registro por URL o por errores de validación de registro
        document.addEventListener('DOMContentLoaded', function () {
            const hasRegisterHash = window.location.hash === '#registro';
            const isModoRegistro = '{{ $modo ?? "" }}' === 'registro';
            const hasRegisterErrors = {{ $errors->has('nombre_usuario') || $errors->has('nombre_completo') || $errors->has('correo') || ($errors->has('password') && old('nombre_usuario')) ? 'true' : 'false' }};
            
            if (hasRegisterHash || isModoRegistro || hasRegisterErrors) {
                showRegisterForm();
            }
        });

        function toggleTestRoles() {
            const container = document.getElementById('testRolesContainer');
            const btn = document.getElementById('toggleTestRolesBtn');
            if (container) {
                const isHidden = container.classList.toggle('hidden');
                if (btn) {
                    btn.setAttribute('aria-expanded', !isHidden);
                }
            }
        }

        function setCredentials(username, pass, autoSubmit = true) {
            const loginInput = document.getElementById('login');
            const passInput = document.getElementById('password');
            const form = document.getElementById('loginForm');
            if (loginInput && passInput) {
                loginInput.value = username;
                passInput.value = pass;
                if (autoSubmit && form) {
                    form.submit();
                } else {
                    loginInput.focus();
                }
            }
        }

        // Alternar visibilidad de contraseña en login
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passInput.getAttribute('type') === 'password';
                passInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.setAttribute('opacity', isPassword ? '0.5' : '1');
            });
        }

        // Alternar visibilidad de contraseña en registro
        const toggleRegBtn = document.getElementById('toggleRegPasswordBtn');
        const regPassInput = document.getElementById('reg_password');
        const eyeRegIcon = document.getElementById('eyeRegIcon');

        if (toggleRegBtn && regPassInput) {
            toggleRegBtn.addEventListener('click', function () {
                const isPassword = regPassInput.getAttribute('type') === 'password';
                regPassInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeRegIcon.setAttribute('opacity', isPassword ? '0.5' : '1');
            });
        }
    </script>
</body>
</html>
