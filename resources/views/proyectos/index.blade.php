<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'proyectos'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: SECCIÓN PROYECTOS -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO Y BOTÓN NUEVO -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Proyectos de Proyección Social
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Control general de proyectos activos, finalizados y asignaciones de tutores.
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

            <!-- BARRA DE FILTROS (Search, Estado, Tutor) -->
            <form method="GET" action="{{ route('proyectos.index') }}" class="bg-white rounded-2xl border border-gray-200/80 p-3 sm:p-4 shadow-2xs flex flex-col md:flex-row items-center gap-3">
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
                        placeholder="Search código o nombre de proyecto..."
                        class="w-full pl-9 pr-4 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Dropdown Estado -->
                <div class="w-full md:w-56">
                    <select
                        name="estado"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Estado del Proyecto</option>
                        @foreach ($estados as $key => $label)
                            <option value="{{ $key }}" @selected($estadoSeleccionado === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Tutor -->
                <div class="w-full md:w-64">
                    <select
                        name="tutor_id"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Docente Tutor</option>
                        @foreach ($tutores as $t)
                            <option value="{{ $t->id_usuario }}" @selected((string)$tutorSeleccionado === (string)$t->id_usuario)>
                                {{ $t->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($search || $estadoSeleccionado || $tutorSeleccionado)
                    <a
                        href="{{ route('proyectos.index') }}"
                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors"
                    >
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- TARJETA: LISTA DE PROYECTOS -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800">
                        Lista de Proyectos
                    </h2>
                    <span class="text-xs text-gray-400 font-medium">
                        Total en BD: {{ $proyectos->total() }} proyectos
                    </span>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold bg-transparent">
                                <th class="py-3 px-4 font-bold text-gray-800">Código</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Nombre del Proyecto</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Estado</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Docente Tutor</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Estudiantes</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse ($proyectos as $pry)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- Código -->
                                    <td class="py-3.5 px-4 font-bold text-gray-900 whitespace-nowrap">
                                        #{{ $pry->codigo_proyecto }}
                                    </td>

                                    <!-- Nombre -->
                                    <td class="py-3.5 px-4 font-medium text-gray-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#8B1D2D] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                            <span class="truncate max-w-xs sm:max-w-md">{{ $pry->nombre_proyecto }}</span>
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @php
                                            $estadoClasses = [
                                                'solicitado' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'en_inscripcion' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'en_proceso' => 'bg-amber-50 text-amber-800 border-amber-200',
                                                'en_finalizacion' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'finalizado' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            ];
                                            $badgeStyle = $estadoClasses[$pry->estado] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeStyle }}">
                                            {{ $estados[$pry->estado] ?? ucfirst($pry->estado) }}
                                        </span>
                                    </td>

                                    <!-- Tutor -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($pry->tutor)
                                            <span class="text-gray-800 font-medium">
                                                {{ $pry->tutor->nombre_completo }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">
                                                Sin tutor asignado
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Estudiantes Asignados -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                            </svg>
                                            {{ $pry->alumnos->count() }} alumnos
                                        </span>
                                    </td>

                                    <!-- Acción: Botón con Panel Pequeño Flotante (Ver, Editar, Borrar) -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <button
                                            type="button"
                                            class="action-menu-btn px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs hover:border-gray-300 inline-flex items-center gap-1.5"
                                            data-id="{{ $pry->id_proyecto }}"
                                            data-nombre="[{{ $pry->codigo_proyecto }}] {{ $pry->nombre_proyecto }}"
                                            data-show-url="{{ route('proyectos.show', $pry) }}"
                                            data-edit-url="{{ route('proyectos.edit', $pry) }}"
                                            data-delete-url="{{ route('proyectos.destroy', $pry) }}"
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
                                    <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                        No se encontraron proyectos registrados con los criterios seleccionados.
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
                            Pagina {{ str_pad((string) $proyectos->currentPage(), 2, '0', STR_PAD_LEFT) }} - {{ str_pad((string) max(1, $proyectos->lastPage()), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 font-medium">
                        <a
                            href="{{ $proyectos->url(1) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($proyectos->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &laquo;
                        </a>
                        <a
                            href="{{ $proyectos->previousPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($proyectos->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &lsaquo;
                        </a>

                        @for ($page = 1; $page <= min(5, $proyectos->lastPage()); $page++)
                            <a
                                href="{{ $proyectos->url($page) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors @if($proyectos->currentPage() === $page) bg-[#8B1D2D] text-white font-bold @else hover:bg-gray-100 text-gray-600 @endif"
                            >
                                {{ $page }}
                            </a>
                        @endfor

                        <a
                            href="{{ $proyectos->nextPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$proyectos->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &rsaquo;
                        </a>
                        <a
                            href="{{ $proyectos->url($proyectos->lastPage()) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$proyectos->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &raquo;
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL NUEVO PROYECTO -->
    <div
        id="nuevoProyectoModal"
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">
                        Registrar Nuevo Proyecto
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Almacena el proyecto en PostgreSQL y asigna el docente tutor.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('proyectos.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="codigo_proyecto" class="block text-xs font-semibold text-gray-700 mb-1">
                        Código Único del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="codigo_proyecto"
                        name="codigo_proyecto"
                        value="{{ old('codigo_proyecto') }}"
                        placeholder="Ej. 106"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div>
                    <label for="nombre_proyecto" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_proyecto"
                        name="nombre_proyecto"
                        value="{{ old('nombre_proyecto') }}"
                        placeholder="Ej. Plataforma de Alfabetización Comunitaria"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div>
                    <label for="estado" class="block text-xs font-semibold text-gray-700 mb-1">
                        Estado Inicial <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="estado"
                        name="estado"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        @foreach ($estados as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('estado', 'solicitado') === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tutor_id_modal" class="block text-xs font-semibold text-gray-700 mb-1">
                        Docente Tutor Responsable (Opcional)
                    </label>
                    <select
                        id="tutor_id_modal"
                        name="tutor_id"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        <option value="">-- Sin tutor asignado por ahora --</option>
                        @foreach ($tutores as $t)
                            <option value="{{ $t->id_usuario }}" @selected(old('tutor_id') == $t->id_usuario)>
                                {{ $t->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
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
                        <span>Guardar Proyecto</span>
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
    <!-- MODAL CONFIRMACIÓN: BORRAR PROYECTO                               -->
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
                        Esta acción removerá el proyecto y desvinculará a los estudiantes asociados.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3.5 mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Proyecto:</p>
                <p id="deleteModalProjectName" class="text-xs sm:text-sm font-bold text-gray-800 break-words"></p>
            </div>

            <form id="deleteProjectForm" method="POST" action="">
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

    <script>
        // Modal Crear Proyecto
        const modal = document.getElementById('nuevoProyectoModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const input = document.getElementById('codigo_proyecto');
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

        let currentSelectedProject = null;

        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();

                const rect = btn.getBoundingClientRect();
                currentSelectedProject = {
                    id: btn.getAttribute('data-id'),
                    nombre: btn.getAttribute('data-nombre'),
                    showUrl: btn.getAttribute('data-show-url'),
                    editUrl: btn.getAttribute('data-edit-url'),
                    deleteUrl: btn.getAttribute('data-delete-url')
                };

                verLink.href = currentSelectedProject.showUrl;
                editarLink.href = currentSelectedProject.editUrl;

                // Posicionar el panel pequeño flotante cerca del botón
                actionMenu.style.top = `${rect.bottom + 6}px`;
                actionMenu.style.left = `${Math.max(12, rect.right - 176)}px`;
                actionMenu.classList.remove('hidden');
            });
        });

        // Ocultar panel flotante al hacer clic afuera o scroll
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
        const deleteForm = document.getElementById('deleteProjectForm');
        const deleteModalProjectName = document.getElementById('deleteModalProjectName');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        if (borrarBtn) {
            borrarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (!currentSelectedProject) return;

                if (actionMenu) actionMenu.classList.add('hidden');

                deleteModalProjectName.textContent = currentSelectedProject.nombre;
                deleteForm.action = currentSelectedProject.deleteUrl;

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

        // Tecla Escape para cerrar modales o popovers
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
