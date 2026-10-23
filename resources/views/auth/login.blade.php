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
                            onclick="openGoogleModal()"
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
                            <a href="#registro" id="createAccountLink" onclick="showRegisterForm(); return false;" class="text-[#15803D] hover:text-[#166534] font-semibold hover:underline ml-1 cursor-pointer">
                                Crear una cuenta
                            </a>
                        </p>
                    </form>

                    <!-- CAJA DE ACCESO RÁPIDO PARA PRUEBAS (FACILITA LA REVISIÓN DE LOS 6 ROLES) -->
                    <div class="mt-8 pt-5 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                ⚡ Acceso rápido por rol (1 clic)
                            </p>
                            <span class="text-[10px] text-gray-400 font-medium">6 roles configurados</span>
                        </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <!-- 1. Estudiante -->
                        <button
                            type="button"
                            onclick="setCredentials('2024-0185', 'password123')"
                            class="group p-2.5 bg-emerald-50/70 hover:bg-emerald-100/80 border border-emerald-200/80 hover:border-emerald-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Estudiante (Portal de Horas y Subida PDF)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">🎒</span>
                                <span class="text-[9px] font-bold text-emerald-700 uppercase tracking-wider bg-emerald-100 px-1.5 py-0.2 rounded font-mono">SYS-03</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-emerald-800 transition-colors">Estudiante</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">2024-0185</p>
                        </button>

                        <!-- 2. Docente Tutor -->
                        <button
                            type="button"
                            onclick="setCredentials('tutor_lopez', 'password123')"
                            class="group p-2.5 bg-blue-50/70 hover:bg-blue-100/80 border border-blue-200/80 hover:border-blue-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Docente Tutor (Acompañamiento Técnico y Dictámenes)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">👨‍🏫</span>
                                <span class="text-[9px] font-bold text-blue-700 uppercase tracking-wider bg-blue-100 px-1.5 py-0.2 rounded font-mono">SYS-02</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-blue-800 transition-colors">Docente Tutor</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">tutor_lopez</p>
                        </button>

                        <!-- 3. Coordinador de Carrera -->
                        <button
                            type="button"
                            onclick="setCredentials('coord_ing', 'password123')"
                            class="group p-2.5 bg-indigo-50/70 hover:bg-indigo-100/80 border border-indigo-200/80 hover:border-indigo-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Coordinador de Carrera (Asignación de Tutores y Aval)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">🎓</span>
                                <span class="text-[9px] font-bold text-indigo-700 uppercase tracking-wider bg-indigo-100 px-1.5 py-0.2 rounded font-mono">SYS-02</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-indigo-800 transition-colors">Coord. Carrera</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">coord_ing</p>
                        </button>

                        <!-- 4. Coordinador UPS -->
                        <button
                            type="button"
                            onclick="setCredentials('coord_ups', 'password123')"
                            class="group p-2.5 bg-rose-50/70 hover:bg-rose-100/80 border border-rose-200/80 hover:border-rose-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Coordinador UPS (Auditoría de Sellos, Firma Azul y Certificados)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">🏛️</span>
                                <span class="text-[9px] font-bold text-[#8B1D2D] uppercase tracking-wider bg-rose-100 px-1.5 py-0.2 rounded font-mono">SYS-01</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-[#8B1D2D] transition-colors">Coord. UPS</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">coord_ups</p>
                        </button>

                        <!-- 5. Auxiliar UPS / Personal UPS -->
                        <button
                            type="button"
                            onclick="setCredentials('aux_ups', 'password123')"
                            class="group p-2.5 bg-amber-50/70 hover:bg-amber-100/80 border border-amber-200/80 hover:border-amber-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Auxiliar / Secretaría UPS (Gestión y Apoyo Operativo)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">📋</span>
                                <span class="text-[9px] font-bold text-amber-800 uppercase tracking-wider bg-amber-100 px-1.5 py-0.2 rounded font-mono">SYS-01</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-amber-900 transition-colors">Auxiliar UPS</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">aux_ups</p>
                        </button>

                        <!-- 6. Administrador General -->
                        <button
                            type="button"
                            onclick="setCredentials('admin', 'password123')"
                            class="group p-2.5 bg-gray-50 hover:bg-gray-100/90 border border-gray-200 hover:border-gray-300 rounded-xl text-left transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs flex flex-col justify-between"
                            title="Ingresar como Administrador General (Control Global, Usuarios y Roles)"
                        >
                            <div class="flex items-center justify-between w-full mb-1">
                                <span class="text-sm">👑</span>
                                <span class="text-[9px] font-bold text-gray-700 uppercase tracking-wider bg-gray-200/70 px-1.5 py-0.2 rounded font-mono">SYS-01</span>
                            </div>
                            <p class="text-xs font-bold text-gray-900 leading-tight group-hover:text-black transition-colors">Administrador</p>
                            <p class="text-[10px] text-gray-400 font-mono mt-0.5">admin</p>
                        </button>
                    </div>

                    <p class="text-[10px] text-gray-400 text-center mt-2.5">
                        💡 Haz clic en cualquier rol para ingresar automáticamente y verificar sus permisos.
                    </p>
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

                    <!-- Autocompletar con Google -->
                    <div class="relative my-3 flex items-center justify-center">
                        <div class="border-t border-gray-200 w-full"></div>
                        <span class="bg-white px-3 text-[11px] text-gray-400 uppercase tracking-wider shrink-0">
                            o agiliza tu registro con
                        </span>
                        <div class="border-t border-gray-200 w-full"></div>
                    </div>

                    <button
                        type="button"
                        onclick="openGoogleModal(true)"
                        class="w-full py-2.5 px-4 bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-200 rounded-xl text-xs font-medium text-gray-700 shadow-2xs transition-all duration-150 cursor-pointer flex items-center justify-center gap-2.5"
                    >
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                        </svg>
                        <span>Autocompletar formulario con Google UES</span>
                    </button>

                    <!-- Enlace volver a Login -->
                    <p class="text-center text-xs text-gray-500 pt-2">
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

    <!-- Modal institucional de Google Workspace UES -->
    <div id="googleAuthModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 sm:p-7 relative">
            <button
                type="button"
                onclick="closeGoogleModal()"
                class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 leading-tight">Google Workspace UES</h3>
                    <p class="text-xs text-gray-500">Ingreso institucional con correo de la Universidad</p>
                </div>
            </div>

            <p class="text-xs text-gray-600 mb-4 leading-relaxed">
                Ingresa tu correo institucional <strong class="text-gray-800">@ues.edu.sv</strong>. El sistema verificará tu cuenta o te registrará automáticamente con el rol de <strong class="text-emerald-700">Estudiante</strong>.
            </p>

            <form id="googleLoginForm" method="POST" action="{{ route('login.google') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="googleEmailInput" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Correo de Google Workspace UES
                    </label>
                    <input
                        type="email"
                        id="googleEmailInput"
                        name="email"
                        placeholder="tu.nombre@ues.edu.sv"
                        required
                        class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-gray-200 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] rounded-xl text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 transition-all"
                    />
                </div>

                <!-- Chips de prueba rápida -->
                <div>
                    <span class="text-[11px] font-semibold text-gray-500 block mb-1.5">Correos de prueba rápida:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button
                            type="button"
                            onclick="selectQuickGoogle('estudiante.nuevo@ues.edu.sv')"
                            class="text-[11px] px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors cursor-pointer"
                        >
                            estudiante.nuevo@ues.edu.sv
                        </button>
                        <button
                            type="button"
                            onclick="selectQuickGoogle('2024-0185@ues.edu.sv')"
                            class="text-[11px] px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors cursor-pointer"
                        >
                            2024-0185@ues.edu.sv
                        </button>
                    </div>
                </div>

                <div class="pt-2 flex flex-col gap-2">
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-[#8B1D2D] hover:bg-[#721523] text-white font-semibold text-sm rounded-xl shadow-xs transition-colors cursor-pointer flex items-center justify-center gap-2"
                    >
                        <span>Ingresar directamente con Google</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    <button
                        type="button"
                        onclick="autofillRegisterFromGoogle()"
                        class="w-full py-2.5 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold text-xs rounded-xl border border-emerald-200 transition-colors cursor-pointer flex items-center justify-center gap-1.5"
                    >
                        <span>✍️ Rellenar formulario de registro con este correo</span>
                    </button>
                </div>
            </form>
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
            const hasRegisterErrors = {{ $errors->has('nombre_usuario') || $errors->has('nombre_completo') || ($errors->has('password') && old('nombre_usuario')) ? 'true' : 'false' }};
            
            if (hasRegisterHash || isModoRegistro || hasRegisterErrors) {
                showRegisterForm();
            }
        });

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

        // Manejo del Modal de Google Workspace
        function openGoogleModal(forAutofill = false) {
            const modal = document.getElementById('googleAuthModal');
            if (modal) modal.classList.remove('hidden');
            const input = document.getElementById('googleEmailInput');
            if (input) {
                if (!input.value) input.value = 'estudiante.nuevo@ues.edu.sv';
                input.focus();
            }
        }

        function closeGoogleModal() {
            const modal = document.getElementById('googleAuthModal');
            if (modal) modal.classList.add('hidden');
        }

        function selectQuickGoogle(email) {
            const input = document.getElementById('googleEmailInput');
            if (input) input.value = email;
        }

        function autofillRegisterFromGoogle() {
            const emailInput = document.getElementById('googleEmailInput');
            const email = (emailInput?.value || '').trim();
            if (!email) {
                alert('Por favor ingresa un correo de Google o UES.');
                return;
            }
            const username = email.split('@')[0];
            const nameFormatted = username.replace(/[._-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

            closeGoogleModal();
            showRegisterForm();

            const carnetInput = document.getElementById('reg_nombre_usuario');
            const nameInput = document.getElementById('reg_nombre_completo');
            const correoInput = document.getElementById('reg_correo');
            const passInput = document.getElementById('reg_password');
            const passConfInput = document.getElementById('reg_password_confirmation');

            if (carnetInput) carnetInput.value = username;
            if (nameInput) nameInput.value = nameFormatted;
            if (correoInput) correoInput.value = email;
            if (passInput) passInput.value = 'password123';
            if (passConfInput) passConfInput.value = 'password123';
        }
    </script>
</body>
</html>
