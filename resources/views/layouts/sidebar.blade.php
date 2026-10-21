@props(['active' => 'dashboard'])

@php
    $usuario = Auth::user();
@endphp

<!-- ================================================================= -->
<!-- BARRA LATERAL DE NAVEGACIÓN (BLANCA, COLAPSABLE / DESPLEGABLE)    -->
<!-- ================================================================= -->
<aside
    id="mainSidebar"
    class="w-full lg:w-20 bg-white border-b lg:border-b-0 lg:border-r border-gray-200/80 shrink-0 flex flex-col justify-between py-3 px-4 lg:py-6 lg:px-3 sticky top-0 z-40 lg:h-screen transition-all duration-300 ease-in-out select-none"
    aria-label="Navegación principal"
>
    <!-- Script de inicialización inmediata para evitar parpadeos visuales (FOUC) -->
    <script>
        (function() {
            try {
                if (localStorage.getItem('sigps_sidebar_expanded') === 'true' && window.innerWidth >= 1024) {
                    document.getElementById('mainSidebar')?.classList.add('is-expanded');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Contenedor Superior: Logo UES con '>' muy pequeño y largo estático (sin bordes) -->
    <div class="flex flex-col gap-2">
        <div class="sidebar-top-wrapper">
            <!-- Bloque de Identidad / Logo UES y Chevron '>' -->
            <div class="flex items-center gap-1.5 overflow-hidden min-w-0">
                <!-- En estado contraído, pulsar el icono o el chevron abre el menú sin ningún borde -->
                <button
                    id="sidebarLogoToggleBtn"
                    type="button"
                    class="sidebar-toggle-trigger group flex items-center gap-1.5 p-0 border-0 bg-transparent cursor-pointer focus:outline-none focus:ring-0 shadow-none hover:bg-transparent"
                    title="Desplegar menú lateral"
                    aria-label="Desplegar menú lateral"
                >
                    <img
                        src="/images/logo.png"
                        alt="Logo UES"
                        class="w-10 h-10 object-contain drop-shadow-xs transition-transform group-hover:scale-105 shrink-0"
                    />
                    <!-- '>' muy pequeño y largo estático al lado del icono -->
                    <svg
                        id="sidebarStaticChevron"
                        class="w-2.5 h-6 text-gray-400 group-hover:text-[#8B1D2D] transition-colors shrink-0"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 10 24"
                        aria-hidden="true"
                    >
                        <path d="M2 4l6 8-6 8" />
                    </svg>
                </button>

                <!-- Texto de marca institucional UES (visible al expandir) -->
                <a href="{{ route('dashboard') }}" class="sidebar-brand-info flex flex-col min-w-0 hover:opacity-80 transition-opacity" title="Ir al Dashboard">
                    <span class="font-black text-sm text-gray-900 tracking-tight leading-tight">SIGPS - UES</span>
                    <span class="text-[10px] font-bold text-[#8B1D2D] uppercase tracking-wider">Proyección Social</span>
                </a>
            </div>

            <!-- Botón para plegar el menú en estado expandido (sin bordes, con '<' estilizado) -->
            <button
                id="sidebarFoldBtn"
                type="button"
                class="sidebar-toggle-trigger sidebar-fold-btn p-1.5 text-gray-400 hover:text-[#8B1D2D] transition-colors cursor-pointer border-0 bg-transparent focus:outline-none focus:ring-0 shadow-none"
                title="Plegar menú lateral"
                aria-label="Plegar menú lateral"
            >
                <svg
                    class="w-2.5 h-6 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    viewBox="0 0 10 24"
                >
                    <path d="M8 4l-6 8 6 8" />
                </svg>
            </button>
        </div>

        <!-- Menú de Enlaces de Navegación (Desktop vertical, Mobile desplegable) -->
        <nav id="mobileNavMenu" class="hidden lg:flex lg:flex-col items-stretch w-full gap-2 lg:gap-3 lg:mt-6">
            <!-- 1. Dashboard -->
            <a
                href="{{ route('dashboard') }}"
                class="sidebar-nav-link {{ $active === 'dashboard' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Dashboard Operativo"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V4zM3 12a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm10 0a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Dashboard</span>
            </a>

            <!-- 2. Estudiantes -->
            <a
                href="{{ route('estudiantes.index') }}"
                class="sidebar-nav-link {{ $active === 'estudiantes' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Estudiantes"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Estudiantes</span>
            </a>

            <!-- 3. Certificaciones / Documentos -->
            <a
                href="{{ route('certificados.index') }}"
                class="sidebar-nav-link {{ $active === 'certificados' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Certificados y Documentos"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Certificados y Documentos</span>
            </a>

            <!-- 4. Carpetas / Proyectos -->
            <a
                href="{{ route('proyectos.index') }}"
                class="sidebar-nav-link {{ $active === 'proyectos' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Proyectos"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Proyectos</span>
            </a>

            <!-- 5. Responsables / Docentes Tutores -->
            <a
                href="{{ route('tutores.index') }}"
                class="sidebar-nav-link {{ $active === 'tutores' ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Docentes Tutores"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Docentes Tutores</span>
            </a>

            <!-- 6. Administrador / Usuarios y Roles -->
            <a
                href="{{ route('usuarios.index') }}"
                class="sidebar-nav-link {{ in_array($active, ['admin', 'usuarios']) ? 'bg-[#8B1D2D] text-white shadow-sm shadow-[#8B1D2D]/25 font-semibold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }}"
                title="Usuarios y Roles"
            >
                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="sidebar-link-text text-sm">Usuarios y Roles</span>
            </a>
        </nav>
    </div>

    <!-- Pie inferior: Usuario autenticado y botón Cerrar sesión -->
    <div class="sidebar-user-wrapper pt-4 border-t border-gray-100">
        <div class="flex items-center gap-3 overflow-hidden min-w-0">
            <div class="w-9 h-9 shrink-0 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center text-xs font-bold text-gray-700 shadow-2xs" title="{{ $usuario?->nombre_completo }}">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
            <div class="sidebar-user-text flex flex-col min-w-0">
                <span class="text-xs font-bold text-gray-900 truncate leading-tight">{{ $usuario?->nombre_completo ?? 'Usuario' }}</span>
                <span class="text-[11px] text-gray-500 truncate leading-tight font-mono">{{ $usuario?->nombre_usuario ?? 'admin' }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" title="Cerrar sesión" class="shrink-0">
            @csrf
            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Cerrar sesión">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Lógica JavaScript para desplegar / plegar menú con animación y persistencia -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('mainSidebar');
            const logoToggleBtn = document.getElementById('sidebarLogoToggleBtn');
            const foldBtn = document.getElementById('sidebarFoldBtn');
            const mobileMenu = document.getElementById('mobileNavMenu');

            if (!sidebar) return;

            function updateTitles(expanded) {
                if (logoToggleBtn) {
                    logoToggleBtn.setAttribute('title', expanded ? 'Ir al Dashboard' : 'Desplegar menú lateral');
                    logoToggleBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                }
            }

            function setSidebarState(expanded) {
                if (expanded) {
                    sidebar.classList.add('is-expanded');
                } else {
                    sidebar.classList.remove('is-expanded');
                }
                try {
                    localStorage.setItem('sigps_sidebar_expanded', expanded ? 'true' : 'false');
                } catch (err) {}

                updateTitles(expanded);

                // Soporte para menú desplegable en pantallas móviles
                if (mobileMenu && window.innerWidth < 1024) {
                    if (expanded) {
                        mobileMenu.classList.remove('hidden');
                    } else {
                        mobileMenu.classList.add('hidden');
                    }
                }
            }

            // Inicializar según estado actual
            updateTitles(sidebar.classList.contains('is-expanded'));

            // Click en logo o chevron estático en estado contraído: abre el menú
            logoToggleBtn?.addEventListener('click', function (e) {
                if (!sidebar.classList.contains('is-expanded')) {
                    e.preventDefault();
                    setSidebarState(true);
                } else if (window.innerWidth < 1024) {
                    // En móvil, pulsar de nuevo cierra
                    e.preventDefault();
                    setSidebarState(false);
                }
            });

            // Click en botón de plegar en estado expandido: cierra el menú
            foldBtn?.addEventListener('click', function (e) {
                e.preventDefault();
                setSidebarState(false);
            });
        });
    </script>
</aside>
