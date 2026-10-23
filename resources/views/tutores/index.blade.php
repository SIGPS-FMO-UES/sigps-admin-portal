<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docentes Tutores | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'tutores'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: SECCIÓN TUTORES -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO Y BOTÓN NUEVO -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Docentes Tutores
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Cuerpo docente registrado para la asesoría y seguimiento de proyectos de servicio social.
                    </p>
                </div>

                <!-- Botón Nuevo + -->
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

            <!-- BARRA DE FILTROS (Search, Departamento) -->
            <form method="GET" action="{{ route('tutores.index') }}" class="bg-white rounded-2xl border border-gray-200/80 p-3 sm:p-4 shadow-2xs flex flex-col md:flex-row items-center gap-3">
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
                        placeholder="Search docente por nombre o usuario..."
                        class="w-full pl-9 pr-4 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Dropdown Departamento -->
                <div class="w-full md:w-64">
                    <select
                        name="departamento"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Departamento / Escuela</option>
                        @foreach ($departamentos as $depto)
                            <option value="{{ $depto }}" @selected($departamentoSeleccionado === $depto)>
                                {{ $depto }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($search || $departamentoSeleccionado)
                    <a
                        href="{{ route('tutores.index') }}"
                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors"
                    >
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- TARJETA: LISTA DE TUTORES -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800">
                        Lista de Docentes Tutores
                    </h2>
                    <span class="text-xs text-gray-400 font-medium">
                        Total en BD: {{ $tutores->total() }} tutores
                    </span>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold bg-transparent">
                                <th class="py-3 px-4 font-bold text-gray-800">Usuario</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Nombre del Docente</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Correo Electrónico</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Departamento</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Proyectos Asignados</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Estado</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse ($tutores as $tutor)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- Usuario -->
                                    <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                        {{ $tutor->nombre_usuario }}
                                    </td>

                                    <!-- Nombre -->
                                    <td class="py-3.5 px-4 font-medium text-gray-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-red-50 text-[#8B1D2D] font-bold text-xs flex items-center justify-center border border-red-100 shrink-0">
                                                {{ strtoupper(substr($tutor->nombre_completo, 0, 1)) }}
                                            </div>
                                            <span>{{ $tutor->nombre_completo }}</span>
                                        </div>
                                    </td>

                                    <!-- Correo Electrónico -->
                                    <td class="py-3.5 px-4 whitespace-nowrap text-xs text-gray-600">
                                        @if ($tutor->correo)
                                            <div class="flex items-center gap-1.5 font-medium text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $tutor->correo }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">Sin correo</span>
                                        @endif
                                    </td>

                                    <!-- Departamento -->
                                    <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                        {{ $tutor->departamento }}
                                    </td>

                                    <!-- Proyectos Asignados -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($tutor->proyectosComoTutor->isNotEmpty())
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-[#8B1D2D] border border-red-100">
                                                {{ $tutor->proyectosComoTutor->count() }} proyectos activos
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">
                                                Sin proyectos activos
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Estado -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($tutor->activo)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Acción: Botón con Panel Pequeño Flotante (Ver, Editar, Borrar) -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <button
                                            type="button"
                                            class="action-menu-btn px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs hover:border-gray-300 inline-flex items-center gap-1.5"
                                            data-id="{{ $tutor->id_usuario }}"
                                            data-nombre="{{ $tutor->nombre_completo }} ({{ $tutor->nombre_usuario }})"
                                            data-show-url="{{ route('tutores.show', $tutor) }}"
                                            data-edit-url="{{ route('tutores.edit', $tutor) }}"
                                            data-delete-url="{{ route('tutores.destroy', $tutor) }}"
                                        >
                                            <span>Acción</span>
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400 text-sm">
                                        No se encontraron docentes tutores registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINACIÓN INFERIOR (Formato "Pagina 01 - 02") -->
                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                    <div>
                        <span>
                            Pagina {{ str_pad((string) $tutores->currentPage(), 2, '0', STR_PAD_LEFT) }} - {{ str_pad((string) max(1, $tutores->lastPage()), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 font-medium">
                        <a
                            href="{{ $tutores->url(1) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($tutores->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &laquo;
                        </a>
                        <a
                            href="{{ $tutores->previousPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($tutores->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &lsaquo;
                        </a>

                        @for ($page = 1; $page <= min(5, $tutores->lastPage()); $page++)
                            <a
                                href="{{ $tutores->url($page) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors @if($tutores->currentPage() === $page) bg-[#8B1D2D] text-white font-bold @else hover:bg-gray-100 text-gray-600 @endif"
                            >
                                {{ $page }}
                            </a>
                        @endfor

                        <a
                            href="{{ $tutores->nextPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$tutores->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &rsaquo;
                        </a>
                        <a
                            href="{{ $tutores->url($tutores->lastPage()) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$tutores->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &raquo;
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL NUEVO TUTOR -->
    <div
        id="nuevoTutorModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 sm:p-8">
            <button
                type="button"
                id="closeModalBtn"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#8B1D2D] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">
                        Registrar Nuevo Docente Tutor
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Almacena al docente en PostgreSQL y le asigna el rol oficial de Docente Tutor.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('tutores.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="nombre_usuario" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre de Usuario / Código del Docente <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_usuario"
                        name="nombre_usuario"
                        value="{{ old('nombre_usuario') }}"
                        placeholder="Ej. tutor_hernandez"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div>
                    <label for="nombre_completo" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre Completo y Grado Académico <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_completo"
                        name="nombre_completo"
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ej. Ing. Sonia Patricia Hernández"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div>
                    <label for="correo" class="block text-xs font-semibold text-gray-700 mb-1">
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        value="{{ old('correo') }}"
                        placeholder="Ej. tutor@ues.edu.sv"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                    <p class="text-[11px] text-gray-400 mt-1">Correo institucional del docente tutor.</p>
                </div>

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
                        Docente tutor activo para asignación de proyectos
                    </label>
                </div>

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
                        <span>Guardar Tutor</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- PANEL PEQUEÑO FLOTANTE DE ACCIONES (VER, EDITAR, BORRAR)          -->
    <!-- ================================================================= -->
    <div
        id="actionDropdownMenu"
        class="fixed z-50 hidden w-44 bg-white rounded-2xl shadow-xl border border-gray-200/90 py-1.5 text-xs transition-all duration-150"
        role="menu"
    >
        <!-- Opción Ver -->
        <a
            id="dropdownVerLink"
            href="#"
            class="flex items-center gap-2.5 px-3.5 py-2 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium"
        >
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span>Ver</span>
        </a>

        <!-- Opción Editar -->
        <a
            id="dropdownEditarLink"
            href="#"
            class="flex items-center gap-2.5 px-3.5 py-2 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium"
        >
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Editar</span>
        </a>

        <div class="border-t border-gray-100 my-1"></div>

        <!-- Opción Borrar -->
        <button
            type="button"
            id="dropdownBorrarBtn"
            class="flex w-full items-center gap-2.5 px-3.5 py-2 text-red-600 hover:bg-red-50 transition-colors text-left font-medium cursor-pointer"
        >
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span>Borrar</span>
        </button>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL CONFIRMACIÓN: BORRAR DOCENTE TUTOR                          -->
    <!-- ================================================================= -->
    <div
        id="confirmDeleteModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 sm:p-7">
            <div class="flex items-center gap-3.5 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        ¿Está seguro que quieres eliminar?
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Esta acción removerá al docente tutor y desvinculará sus proyectos asignados.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3.5 mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Docente Tutor:</p>
                <p id="deleteModalTutorName" class="text-xs sm:text-sm font-bold text-gray-800 break-words"></p>
            </div>

            <form id="deleteTutorForm" method="POST" action="">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-end gap-3">
                    <button
                        type="button"
                        id="cancelDeleteBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-xl text-xs font-semibold transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Sí, eliminar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script de control del Modal y Panel de Acciones -->
    <script>
        const modal = document.getElementById('nuevoTutorModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const input = document.getElementById('nombre_usuario');
                    if (input) input.focus();
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

        // Panel Flotante Desplegable de Acciones
        const actionMenu = document.getElementById('actionDropdownMenu');
        const verLink = document.getElementById('dropdownVerLink');
        const editarLink = document.getElementById('dropdownEditarLink');
        const borrarBtn = document.getElementById('dropdownBorrarBtn');

        let currentSelectedTutor = null;

        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();

                const rect = btn.getBoundingClientRect();
                currentSelectedTutor = {
                    id: btn.getAttribute('data-id'),
                    nombre: btn.getAttribute('data-nombre'),
                    showUrl: btn.getAttribute('data-show-url'),
                    editUrl: btn.getAttribute('data-edit-url'),
                    deleteUrl: btn.getAttribute('data-delete-url')
                };

                verLink.href = currentSelectedTutor.showUrl;
                editarLink.href = currentSelectedTutor.editUrl;

                // Posicionar panel cerca del botón
                actionMenu.style.top = `${rect.bottom + 6}px`;
                actionMenu.style.left = `${Math.max(12, rect.right - 176)}px`;
                actionMenu.classList.remove('hidden');
            });
        });

        // Ocultar panel al hacer clic afuera o scroll
        window.addEventListener('click', () => {
            if (actionMenu) actionMenu.classList.add('hidden');
        });

        window.addEventListener('scroll', () => {
            if (actionMenu && !actionMenu.classList.contains('hidden')) {
                actionMenu.classList.add('hidden');
            }
        }, true);

        // Modal de Confirmación de Borrado
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteTutorForm');
        const deleteModalTutorName = document.getElementById('deleteModalTutorName');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        if (borrarBtn) {
            borrarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (!currentSelectedTutor) return;

                if (actionMenu) actionMenu.classList.add('hidden');

                deleteModalTutorName.textContent = currentSelectedTutor.nombre;
                deleteForm.action = currentSelectedTutor.deleteUrl;

                deleteModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        function closeDeleteModal() {
            if (deleteModal) {
                deleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);

        if (deleteModal) {
            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) closeDeleteModal();
            });
        }

        // Cerrar con Escape
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (actionMenu) actionMenu.classList.add('hidden');
                closeModal();
                closeDeleteModal();
            }
        });

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        }

        @if ($errors->any())
            openModal();
        @endif
    </script>

</body>
</html>
