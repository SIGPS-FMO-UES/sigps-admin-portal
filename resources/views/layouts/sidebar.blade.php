@props(['active' => 'dashboard'])

@php
    $usuario = Auth::user();
@endphp

<!-- ================================================================= -->
<!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA CON ICONOS VERTICALES) -->
<!-- ================================================================= -->
<aside class="w-full lg:w-20 bg-white border-b lg:border-b-0 lg:border-r border-gray-200/80 shrink-0 flex lg:flex-col justify-between items-center py-3 px-4 lg:py-6 lg:px-0 sticky top-0 z-40 lg:h-screen">
    <!-- Logo UES Superior -->
    <div class="flex lg:flex-col items-center gap-4">
        <a href="{{ route('dashboard') }}" class="group block p-1 transition-transform hover:scale-105" title="Universidad de El Salvador">
            <!-- Emblema oficial UES -->
            <img
                src="/images/logo.png"
                alt="Logo UES"
                class="w-10 h-10 object-contain drop-shadow-xs"
            />
        </a>

        <!-- Menú de Iconos de Navegación (Desktop vertical, Mobile horizontal) -->
        <nav class="flex lg:flex-col items-center gap-2 lg:gap-4 lg:mt-6">
            <!-- 1. Dashboard -->
            <a
                href="{{ route('dashboard') }}"
                class="p-2.5 rounded-xl transition-all {{ $active === 'dashboard' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Dashboard Operativo"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V4zM3 12a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm10 0a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                </svg>
            </a>

            <!-- 2. Estudiantes -->
            <a
                href="{{ route('estudiantes.index') }}"
                class="p-2.5 rounded-xl transition-all {{ $active === 'estudiantes' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Estudiantes"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>

            <!-- 3. Certificaciones / Documentos -->
            <a
                href="{{ route('certificados.index') }}"
                class="p-2.5 rounded-xl transition-all {{ $active === 'certificados' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Certificaciones y Documentos"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </a>

            <!-- 4. Carpetas / Proyectos -->
            <a
                href="{{ route('proyectos.index') }}"
                class="p-2.5 rounded-xl transition-all {{ $active === 'proyectos' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Proyectos y Carpetas"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </a>

            <!-- 5. Responsables / Docentes Tutores -->
            <a
                href="{{ route('tutores.index') }}"
                class="p-2.5 rounded-xl transition-all {{ $active === 'tutores' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Docentes Tutores"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>

            <!-- 6. Administrador / Grupos -->
            <a
                href="{{ route('dashboard') }}#admin"
                class="p-2.5 rounded-xl transition-all {{ $active === 'admin' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100' }}"
                title="Administración de Roles"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
        </nav>
    </div>

    <!-- Usuario inferior y botón Cerrar sesión -->
    <div class="flex items-center gap-2 lg:flex-col lg:gap-3">
        <form method="POST" action="{{ route('logout') }}" title="Cerrar sesión">
            @csrf
            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Cerrar sesión">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>

        <div class="w-9 h-9 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center text-xs font-bold text-gray-700 shadow-2xs" title="{{ $usuario?->nombre_completo }}">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </div>
    </div>
</aside>
