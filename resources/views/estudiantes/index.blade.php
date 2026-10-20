<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- ================================================================= -->
    <!-- BARRA LATERAL OSCURA (SIGPS - EXACTA A LA IMAGEN) -->
    <!-- ================================================================= -->
    <aside class="w-full lg:w-64 bg-[#182232] text-white shrink-0 flex flex-col justify-between py-5 px-4 lg:py-6 lg:px-5 lg:h-screen sticky top-0 z-40 border-b lg:border-b-0 lg:border-r border-gray-800">
        <div>
            <!-- Encabezado con Logo nuevo UES, Marca SIGPS y botón de colapso -->
            <div class="flex items-center justify-between pb-6 border-b border-gray-700/50">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <img
                        src="/images/logo.png"
                        alt="Logo UES"
                        class="w-8 h-8 object-contain transition-transform group-hover:scale-105"
                    />
                    <span class="text-lg font-bold tracking-wider text-white">
                        SIGPS
                    </span>
                </a>

                <!-- Icono de colapso/expansión -->
                <button
                    type="button"
                    class="p-1 rounded border border-gray-600/70 text-gray-400 hover:text-white hover:border-gray-400 transition-colors cursor-pointer"
                    title="Alternar barra lateral"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>

            <!-- Menú de Navegación Vertical -->
            <nav class="mt-6 space-y-1.5 text-sm">
                <!-- 1. Dashboard -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all"
                >
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V4zM3 12a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm10 0a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- 2. Estudiantes (ACTIVO) -->
                <a
                    href="{{ route('estudiantes.index') }}"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-white bg-white/10 font-semibold shadow-xs transition-all"
                >
                    <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Estudiantes</span>
                </a>

                <!-- 3. Proyectos -->
                <a
                    href="{{ route('dashboard') }}#proyectos"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium">Proyectos</span>
                </a>

                <!-- 4. Certificaciones -->
                <a
                    href="{{ route('dashboard') }}#certificaciones"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span class="font-medium">Certificaciones</span>
                </a>

                <!-- 5. Tutores -->
                <a
                    href="{{ route('dashboard') }}#tutores"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Tutores</span>
                </a>

                <!-- 6. ADMINISTRADOR -->
                <a
                    href="{{ route('dashboard') }}#admin"
                    class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-all"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="font-medium uppercase tracking-wider text-xs">ADMINISTRADOR</span>
                </a>
            </nav>
        </div>

        <!-- Usuario inferior con avatar y cierre de sesión -->
        <div class="pt-4 border-t border-gray-700/50 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-lg bg-white overflow-hidden p-0.5 border border-white/20 shrink-0 flex items-center justify-center">
                    <svg class="w-7 h-7 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate leading-tight">
                        {{ $currentUser->nombre_completo ?? 'Jefe UPS' }}
                    </p>
                    <p class="text-[11px] text-gray-400 truncate leading-tight">
                        {{ $currentUser->nombre_usuario ? $currentUser->nombre_usuario . '@ues.edu.sv' : 'jefeups@gmail.com' }}
                    </p>
                </div>
            </div>

            <!-- Botón salir -->
            <form method="POST" action="{{ route('logout') }}" title="Cerrar sesión">
                @csrf
                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-400 transition-colors cursor-pointer" title="Cerrar sesión">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: SECCIÓN ESTUDIANTES -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO Y BOTÓN NUEVO -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Estudiantes
                    </h1>
                </div>

                <!-- Botón Nuevo + (Abre el Modal para registrar en la BD) -->
                <div>
                    <button
                        type="button"
                        id="openModalBtn"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-150 flex items-center gap-1.5 cursor-pointer"
                    >
                        <span>Nuevo +</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- MENSAJES DE ESTADO FLASH (ÉXITO O ERROR) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs sm:text-sm flex items-center gap-2.5 shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-xs sm:text-sm shadow-2xs">
                    <p class="font-bold mb-1">Por favor verifica los siguientes campos:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- BARRA DE FILTROS (Search, Carrera, Departamento) -->
            <form method="GET" action="{{ route('estudiantes.index') }}" class="bg-white rounded-2xl border border-gray-200/80 p-3 sm:p-4 shadow-2xs flex flex-col md:flex-row items-center gap-3">
                <!-- Buscador de texto -->
                <div class="relative flex-1 w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search..."
                        class="w-full pl-9 pr-4 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Dropdown Carrera -->
                <div class="w-full md:w-56">
                    <select
                        name="carrera"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Carrera</option>
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera }}" @selected($carreraSeleccionada === $carrera)>
                                {{ $carrera }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Departamento -->
                <div class="w-full md:w-56">
                    <select
                        name="departamento"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Departamento</option>
                        @foreach ($departamentos as $depto)
                            <option value="{{ $depto }}" @selected($departamentoSeleccionado === $depto)>
                                {{ $depto }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($search || $carreraSeleccionada || $departamentoSeleccionado)
                    <a
                        href="{{ route('estudiantes.index') }}"
                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors"
                    >
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- TARJETA: LISTA DE ESTUDIANTE -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800">
                        Lista de Estudiante
                    </h2>
                    <span class="text-xs text-gray-400 font-medium">
                        Total en BD: {{ $estudiantes->total() }} estudiantes
                    </span>
                </div>

                <!-- Tabla de estudiantes -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold bg-transparent">
                                <th class="py-3 px-4 font-bold text-gray-800">Carnet</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Nombre</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Carrera</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Proyecto</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse ($estudiantes as $estudiante)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- Carnet -->
                                    <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                        {{ $estudiante->nombre_usuario }}
                                    </td>

                                    <!-- Nombre Completo -->
                                    <td class="py-3.5 px-4 font-medium text-gray-800 whitespace-nowrap">
                                        {{ $estudiante->nombre_completo }}
                                    </td>

                                    <!-- Carrera -->
                                    <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                        {{ $estudiante->carrera }}
                                    </td>

                                    <!-- Proyecto Asignado -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($estudiante->proyectosComoAlumno->isNotEmpty())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-[#8B1D2D] border border-red-100">
                                                {{ Str::limit($estudiante->proyectosComoAlumno->first()->nombre_proyecto, 30) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">
                                                Sin proyecto asignado
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Acción -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <button
                                            type="button"
                                            onclick="alert('Expediente Estudiante: {{ $estudiante->nombre_usuario }}\nNombre: {{ $estudiante->nombre_completo }}\nCarrera: {{ $estudiante->carrera }}\nEstado: {{ $estudiante->activo ? 'Activo' : 'Inactivo' }}');"
                                            class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs hover:border-gray-300"
                                        >
                                            Button
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm">
                                        No se encontraron estudiantes registrados con los criterios seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINACIÓN INFERIOR (EXACTA AL FORMATO "Pagina 01 - 20") -->
                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                    <div>
                        <span>
                            Pagina {{ str_pad((string) $estudiantes->currentPage(), 2, '0', STR_PAD_LEFT) }} - {{ str_pad((string) max(1, $estudiantes->lastPage()), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <!-- Botones de paginación con flechas -->
                    <div class="flex items-center gap-1.5 font-medium">
                        <!-- Primera página -->
                        <a
                            href="{{ $estudiantes->url(1) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($estudiantes->onFirstPage()) text-gray-300 pointer-events-none @endif"
                            title="Primera página"
                        >
                            &laquo;
                        </a>

                        <!-- Anterior -->
                        <a
                            href="{{ $estudiantes->previousPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($estudiantes->onFirstPage()) text-gray-300 pointer-events-none @endif"
                            title="Anterior"
                        >
                            &lsaquo;
                        </a>

                        <!-- Números de página -->
                        @for ($page = 1; $page <= min(5, $estudiantes->lastPage()); $page++)
                            <a
                                href="{{ $estudiantes->url($page) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors @if($estudiantes->currentPage() === $page) bg-[#8B1D2D] text-white font-bold @else hover:bg-gray-100 text-gray-600 @endif"
                            >
                                {{ $page }}
                            </a>
                        @endfor

                        @if ($estudiantes->lastPage() > 5)
                            <span class="px-1 text-gray-400">...</span>
                            <a
                                href="{{ $estudiantes->url($estudiantes->lastPage()) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors hover:bg-gray-100 text-gray-600"
                            >
                                {{ $estudiantes->lastPage() }}
                            </a>
                        @endif

                        <!-- Siguiente -->
                        <a
                            href="{{ $estudiantes->nextPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$estudiantes->hasMorePages()) text-gray-300 pointer-events-none @endif"
                            title="Siguiente"
                        >
                            &rsaquo;
                        </a>

                        <!-- Última página -->
                        <a
                            href="{{ $estudiantes->url($estudiantes->lastPage()) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$estudiantes->hasMorePages()) text-gray-300 pointer-events-none @endif"
                            title="Última página"
                        >
                            &raquo;
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL PARA AGREGAR NUEVO ESTUDIANTE A LA BASE DE DATOS -->
    <!-- ================================================================= -->
    <div
        id="nuevoEstudianteModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        aria-labelledby="modalTitle"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 sm:p-8">
            <!-- Botón cerrar (X) -->
            <button
                type="button"
                id="closeModalBtn"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Encabezado del Modal -->
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#8B1D2D] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-lg font-bold text-gray-900 tracking-tight">
                        Registrar Nuevo Estudiante
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Se registrará en PostgreSQL y se asociará al rol de Estudiante.
                    </p>
                </div>
            </div>

            <!-- Formulario de creación de estudiante -->
            <form method="POST" action="{{ route('estudiantes.store') }}" class="space-y-4">
                @csrf

                <!-- Campo Carnet / Nombre de usuario -->
                <div>
                    <label for="nombre_usuario" class="block text-xs font-semibold text-gray-700 mb-1">
                        Carnet / Nombre de Usuario <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_usuario"
                        name="nombre_usuario"
                        value="{{ old('nombre_usuario') }}"
                        placeholder="Ej. 2024-0185 o GG24001"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <!-- Campo Nombre Completo -->
                <div>
                    <label for="nombre_completo" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre Completo del Estudiante <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_completo"
                        name="nombre_completo"
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ej. Carlos Eduardo Ramos García"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <!-- Campo Carrera (referencia) -->
                <div>
                    <label for="carrera_select" class="block text-xs font-semibold text-gray-700 mb-1">
                        Carrera Universitaria
                    </label>
                    <select
                        id="carrera_select"
                        name="carrera"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera }}">{{ $carrera }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campo Asignación de Proyecto (Opcional) -->
                <div>
                    <label for="id_proyecto" class="block text-xs font-semibold text-gray-700 mb-1">
                        Asignar a Proyecto Inicial (Opcional)
                    </label>
                    <select
                        id="id_proyecto"
                        name="id_proyecto"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        <option value="">-- Sin proyecto asignado por ahora --</option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->id_proyecto }}">
                                [Código: {{ $p->codigo_proyecto }}] {{ $p->nombre_proyecto }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                        Contraseña de Acceso <span class="text-gray-400 font-normal">(Por defecto: password123)</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        value="password123"
                        placeholder="Mínimo 6 caracteres"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <!-- Checkbox Activo -->
                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        id="activo"
                        name="activo"
                        value="1"
                        checked
                        class="w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]"
                    />
                    <label for="activo" class="text-xs font-medium text-gray-700 cursor-pointer">
                        Estudiante activo en el sistema
                    </label>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100">
                    <button
                        type="button"
                        id="cancelBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-md shadow-[#8B1D2D]/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <span>Guardar Estudiante</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script de control del Modal -->
    <script>
        const modal = document.getElementById('nuevoEstudianteModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const carnetInput = document.getElementById('nombre_usuario');
                    if (carnetInput) carnetInput.focus();
                }, 100);
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        // Cerrar modal al presionar Escape o clic fuera
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Si existen errores de validación, abrir modal automáticamente
        @if ($errors->any())
            openModal();
        @endif
    </script>

</body>
</html>
