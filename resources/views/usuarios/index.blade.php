<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios y Roles | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'usuarios'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: SECCIÓN USUARIOS Y ROLES                     -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO Y BOTÓN NUEVO -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                        <span>Seguridad & Control de Acceso</span>
                        <span>•</span>
                        <span class="text-[#8B1D2D]">Roles de Sistema</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Usuarios y Roles
                    </h1>
                </div>

                <!-- Botón Nuevo + (Abre el Modal para crear usuario con roles) -->
                <div>
                    <button
                        type="button"
                        id="openCreateModalBtn"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all duration-150 flex items-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nuevo Usuario +</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- MENSAJES DE ESTADO FLASH (ÉXITO O ERROR) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Operación completada</p>
                        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-xs sm:text-sm shadow-2xs">
                    <div class="flex items-center gap-2 mb-2 font-bold text-red-900">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Se encontraron los siguientes problemas:</span>
                    </div>
                    <ul class="list-disc pl-7 space-y-0.5 text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TARJETAS DE RESUMEN KPI -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Usuarios -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Usuarios</p>
                        <p class="text-2xl font-black text-gray-900 mt-1">{{ $usuarios->total() }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Registrados en la BD</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gray-50 border border-gray-100 text-gray-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Roles Disponibles -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles Definidos</p>
                        <p class="text-2xl font-black text-[#8B1D2D] mt-1">{{ $roles->count() }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Roles configurados</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 text-[#8B1D2D] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>

                <!-- Administradores -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Admins & Coords</p>
                        <p class="text-2xl font-black text-indigo-700 mt-1">
                            {{ $usuarios->getCollection()->filter(fn($u) => $u->roles->contains(fn($r) => in_array($r->nombre_rol, ['Administrador', 'Coordinador UPS'])))->count() }}
                        </p>
                        <span class="text-[11px] text-gray-400 font-medium">En esta página</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Estado del Sistema -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Seguridad</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1">Activa</p>
                        <span class="text-[11px] text-gray-400 font-medium">Bcrypt + RBAC</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- BARRA DE FILTROS (Search, Rol, Estado) -->
            <form method="GET" action="{{ route('usuarios.index') }}" class="bg-white rounded-2xl border border-gray-200/80 p-3 sm:p-4 shadow-2xs flex flex-col md:flex-row items-center gap-3">
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
                        placeholder="Buscar por nombre de usuario o nombre completo..."
                        class="w-full pl-9 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Dropdown Rol -->
                <div class="w-full md:w-56">
                    <select
                        name="rol_id"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Todos los Roles</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}" @selected($rolSeleccionado == $rol->id_rol)>
                                {{ $rol->nombre_rol }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Estado -->
                <div class="w-full md:w-44">
                    <select
                        name="estado"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Todos los Estados</option>
                        <option value="1" @selected($estadoSeleccionado === '1')>Activo</option>
                        <option value="0" @selected($estadoSeleccionado === '0')>Inactivo</option>
                    </select>
                </div>

                @if ($search || $rolSeleccionado || $estadoSeleccionado !== '')
                    <a
                        href="{{ route('usuarios.index') }}"
                        class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors"
                    >
                        Limpiar Filtros
                    </a>
                @endif
            </form>

            <!-- TARJETA: TABLA DE USUARIOS Y ROLES -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-3 border-b border-gray-100 gap-2">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900">
                            Directorio de Usuarios y Roles Asignados
                        </h2>
                        <p class="text-xs text-gray-400">
                            Asigne, modifique o revoque roles a cada cuenta del sistema
                        </p>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">
                        Mostrando {{ $usuarios->count() }} de {{ $usuarios->total() }} usuarios
                    </span>
                </div>

                <!-- Tabla de usuarios -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold bg-transparent">
                                <th class="py-3 px-4 font-bold text-gray-800">Usuario</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Nombre Completo</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Correo Electrónico</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Roles Asignados</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-center">Estado</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse ($usuarios as $usuarioItem)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- Usuario / Identificador -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ substr($usuarioItem->nombre_usuario, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">
                                                    {{ $usuarioItem->nombre_usuario }}
                                                </div>
                                                <div class="text-[11px] text-gray-400">
                                                    ID #{{ $usuarioItem->id_usuario }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Nombre Completo -->
                                    <td class="py-3.5 px-4 font-medium text-gray-800">
                                        {{ $usuarioItem->nombre_completo }}
                                    </td>

                                    <!-- Correo Electrónico -->
                                    <td class="py-3.5 px-4 whitespace-nowrap text-xs text-gray-600">
                                        @if ($usuarioItem->correo)
                                            <div class="flex items-center gap-1.5 font-medium text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $usuarioItem->correo }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">Sin correo</span>
                                        @endif
                                    </td>

                                    <!-- Roles Asignados (Badges) -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @forelse ($usuarioItem->roles as $rol)
                                                @php
                                                    $badgeClasses = match($rol->nombre_rol) {
                                                        'Administrador' => 'bg-red-50 text-red-800 border-red-200/80',
                                                        'Coordinador UPS' => 'bg-indigo-50 text-indigo-800 border-indigo-200/80',
                                                        'Coordinador de Carrera' => 'bg-sky-50 text-sky-800 border-sky-200/80',
                                                        'Docente Tutor' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80',
                                                        'Estudiante' => 'bg-amber-50 text-amber-800 border-amber-200/80',
                                                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeClasses }}">
                                                    {{ $rol->nombre_rol }}
                                                </span>
                                            @empty
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs text-gray-400 italic bg-gray-50 border border-gray-200/50">
                                                    Sin roles asignados
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        @if ($usuarioItem->activo)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Acciones: Administrar Roles -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <button
                                            type="button"
                                            class="open-edit-modal-btn inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-red-50 text-gray-700 hover:text-[#8B1D2D] border border-gray-200 hover:border-red-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs"
                                            data-id="{{ $usuarioItem->id_usuario }}"
                                            data-username="{{ $usuarioItem->nombre_usuario }}"
                                            data-fullname="{{ $usuarioItem->nombre_completo }}"
                                            data-activo="{{ $usuarioItem->activo ? '1' : '0' }}"
                                            data-roles="{{ $usuarioItem->roles->pluck('id_rol')->implode(',') }}"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            <span>Administrar Roles</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                        No se encontraron usuarios que coincidan con la búsqueda.
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
                            Pagina {{ str_pad((string) $usuarios->currentPage(), 2, '0', STR_PAD_LEFT) }} - {{ str_pad((string) max(1, $usuarios->lastPage()), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 font-medium">
                        <a
                            href="{{ $usuarios->url(1) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($usuarios->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &laquo;
                        </a>
                        <a
                            href="{{ $usuarios->previousPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($usuarios->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &lsaquo;
                        </a>

                        @for ($page = 1; $page <= min(5, $usuarios->lastPage()); $page++)
                            <a
                                href="{{ $usuarios->url($page) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors @if($usuarios->currentPage() === $page) bg-[#8B1D2D] text-white font-bold @else hover:bg-gray-100 text-gray-600 @endif"
                            >
                                {{ $page }}
                            </a>
                        @endfor

                        <a
                            href="{{ $usuarios->nextPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$usuarios->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &rsaquo;
                        </a>
                        <a
                            href="{{ $usuarios->url($usuarios->lastPage()) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$usuarios->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &raquo;
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL 1: REGISTRAR NUEVO USUARIO CON ROLES                        -->
    <!-- ================================================================= -->
    <div
        id="nuevoUsuarioModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 sm:p-8">
            <button
                type="button"
                id="closeCreateModalBtn"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-red-50 text-[#8B1D2D] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">
                        Registrar Nuevo Usuario
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Crea una cuenta en PostgreSQL y asígnale uno o varios roles para el sistema.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-4">
                @csrf

                <!-- Nombre de Usuario -->
                <div>
                    <label for="create_nombre_usuario" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre de Usuario / Carnet <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nombre_usuario"
                        id="create_nombre_usuario"
                        required
                        value="{{ old('nombre_usuario') }}"
                        placeholder="Ej: coord_sistemas o GO18001"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                    <p class="text-[11px] text-gray-400 mt-1">Identificador único con el que iniciará sesión en el portal.</p>
                </div>

                <!-- Nombre Completo -->
                <div>
                    <label for="create_nombre_completo" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nombre_completo"
                        id="create_nombre_completo"
                        required
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ej: Licda. Carmen Elena Morales"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Correo Electrónico -->
                <div>
                    <label for="create_correo" class="block text-xs font-semibold text-gray-700 mb-1">
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        name="correo"
                        id="create_correo"
                        value="{{ old('correo') }}"
                        placeholder="Ej: usuario@ues.edu.sv"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                    <p class="text-[11px] text-gray-400 mt-1">Correo institucional o personal para notificaciones y acceso.</p>
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="create_password" class="block text-xs font-semibold text-gray-700 mb-1">
                        Contraseña Inicial <span class="text-gray-400 text-[11px] font-normal">(Opcional, por defecto: password123)</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="create_password"
                        placeholder="Mínimo 6 caracteres"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Selección de Roles (Checkboxes) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Roles del Sistema a Asignar <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 bg-gray-50 rounded-2xl border border-gray-200/80 max-h-48 overflow-y-auto">
                        @foreach ($roles as $rol)
                            <label class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-gray-200/60 hover:border-[#8B1D2D]/40 transition-colors cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $rol->id_rol }}"
                                    class="w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]/30"
                                    @checked(is_array(old('roles')) && in_array($rol->id_rol, old('roles')))
                                />
                                <div class="text-xs">
                                    <span class="font-bold text-gray-800">{{ $rol->nombre_rol }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Puede asignar uno o múltiples roles al usuario.</p>
                </div>

                <!-- Estado Activo -->
                <div class="pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            checked
                            class="w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]/30"
                        />
                        <span class="text-xs font-semibold text-gray-700">Usuario Activo (Permite iniciar sesión inmediatamente)</span>
                    </label>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button
                        type="button"
                        id="cancelCreateBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-xl text-xs font-semibold transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Crear Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL 2: ADMINISTRAR ROLES DE UN USUARIO EXISTENTE                -->
    <!-- ================================================================= -->
    <div
        id="editRolesModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 sm:p-8">
            <button
                type="button"
                id="closeEditModalBtn"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Encabezado del modal de edición -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">
                        Administrar Roles del Usuario
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Actualice las autorizaciones y estado de actividad en el sistema.
                    </p>
                </div>
            </div>

            <!-- Resumen de cuenta del usuario seleccionado -->
            <div class="mb-5 p-3.5 bg-gray-50 border border-gray-200/80 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-800 flex items-center justify-center font-bold text-sm shrink-0 shadow-2xs">
                    <span id="editUserInitials">US</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h4 id="editUserFullName" class="text-sm font-bold text-gray-900 truncate">
                        Nombre de Usuario
                    </h4>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 mt-0.5">
                        <span class="font-mono text-gray-700" id="editUserName">@usuario</span>
                        <span>•</span>
                        <span id="editUserId" class="text-gray-400">ID #0</span>
                    </p>
                </div>
            </div>

            <form id="editRolesForm" method="POST" action="" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Checkboxes de Roles para el usuario -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                        Seleccione los roles asignados:
                    </label>
                    <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                        @foreach ($roles as $rol)
                            <label class="flex items-center justify-between p-3 rounded-xl bg-white border border-gray-200 hover:border-[#8B1D2D]/40 transition-colors cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $rol->id_rol }}"
                                        id="edit_rol_{{ $rol->id_rol }}"
                                        class="edit-role-checkbox w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]/30"
                                    />
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $rol->nombre_rol }}</p>
                                        <p class="text-[11px] text-gray-400">
                                            @if($rol->nombre_rol === 'Administrador')
                                                Acceso total y configuración de todo el portal
                                            @elseif($rol->nombre_rol === 'Coordinador UPS')
                                                Supervisión de proyectos y aprobaciones de UPS
                                            @elseif($rol->nombre_rol === 'Coordinador de Carrera')
                                                Gestión académica y asignación por especialidad
                                            @elseif($rol->nombre_rol === 'Docente Tutor')
                                                Asesoría directa y seguimiento de estudiantes
                                            @else
                                                Ejecución de horas y entrega de documentación
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-gray-300">#{{ $rol->id_rol }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Estado del Usuario -->
                <div class="pt-2 border-t border-gray-100">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            id="edit_user_activo"
                            class="w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]/30"
                        />
                        <span class="text-xs font-semibold text-gray-700">Cuenta Activa (Habilita inicio de sesión)</span>
                    </label>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button
                        type="button"
                        id="cancelEditBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-xl text-xs font-semibold transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- JAVASCRIPT: CONTROLADORES DE MODALES Y SELECCIÓN DE ROLES        -->
    <!-- ================================================================= -->
    <script>
        // Modal Crear Usuario
        const createModal = document.getElementById('nuevoUsuarioModal');
        const openCreateBtn = document.getElementById('openCreateModalBtn');
        const closeCreateBtn = document.getElementById('closeCreateModalBtn');
        const cancelCreateBtn = document.getElementById('cancelCreateBtn');

        function openCreateModal() {
            if (createModal) {
                createModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const input = document.getElementById('create_nombre_usuario');
                    if (input) input.focus();
                }, 100);
            }
        }

        function closeCreateModal() {
            if (createModal) {
                createModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (openCreateBtn) openCreateBtn.addEventListener('click', openCreateModal);
        if (closeCreateBtn) closeCreateBtn.addEventListener('click', closeCreateModal);
        if (cancelCreateBtn) cancelCreateBtn.addEventListener('click', closeCreateModal);

        // Modal Administrar Roles
        const editModal = document.getElementById('editRolesModal');
        const editForm = document.getElementById('editRolesForm');
        const closeEditBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');

        function openEditRolesModal(user) {
            if (!editModal || !editForm) return;

            // Establecer action dinámicamente en /usuarios/{id}/roles
            editForm.action = `/usuarios/${user.id_usuario}/roles`;

            // Actualizar datos de texto
            const initials = (user.nombre_usuario || 'US').substring(0, 2).toUpperCase();
            document.getElementById('editUserInitials').textContent = initials;
            document.getElementById('editUserFullName').textContent = user.nombre_completo || '';
            document.getElementById('editUserName').textContent = '@' + (user.nombre_usuario || '');
            document.getElementById('editUserId').textContent = 'ID #' + user.id_usuario;

            // Estado activo
            const activoCheckbox = document.getElementById('edit_user_activo');
            if (activoCheckbox) {
                activoCheckbox.checked = Boolean(user.activo);
            }

            // Marcar checkboxes de roles
            const roleIds = user.role_ids || [];
            document.querySelectorAll('.edit-role-checkbox').forEach(cb => {
                const val = parseInt(cb.value, 10);
                cb.checked = roleIds.includes(val);
            });

            // Mostrar modal
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            if (editModal) {
                editModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (closeEditBtn) closeEditBtn.addEventListener('click', closeEditModal);
        if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);

        // Vincular todos los botones de la tabla para abrir el modal de edición
        document.querySelectorAll('.open-edit-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const username = btn.getAttribute('data-username');
                const fullname = btn.getAttribute('data-fullname');
                const activo = btn.getAttribute('data-activo') === '1';
                const rolesStr = btn.getAttribute('data-roles') || '';
                const roleIds = rolesStr ? rolesStr.split(',').map(r => parseInt(r.trim(), 10)) : [];

                openEditRolesModal({
                    id_usuario: id,
                    nombre_usuario: username,
                    nombre_completo: fullname,
                    activo: activo,
                    role_ids: roleIds
                });
            });
        });

        // Eventos de teclado y click fuera de modales
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
            }
        });

        if (createModal) {
            createModal.addEventListener('click', (e) => {
                if (e.target === createModal) closeCreateModal();
            });
        }

        if (editModal) {
            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) closeEditModal();
            });
        }

        // Si hubo errores de validación al crear, reabrir modal
        @if ($errors->any())
            openCreateModal();
        @endif
    </script>

</body>
</html>
