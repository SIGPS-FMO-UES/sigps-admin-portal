<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operativo UPS | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    @include('layouts.sidebar', ['active' => 'dashboard'])

    <!-- ================================================================= -->
    <!-- ÁREA DE CONTENIDO PRINCIPAL -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA PRINCIPAL (TOP BAR) -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Título y subtítulo -->
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Dashboard Operativo UPS
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Resumen general del estado de expedientes, plazos y certificaciones.
                    </p>
                </div>

                <!-- Buscador, Notificación y Perfil de Usuario -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-5">
                    <!-- Buscador estilo píldora -->
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input
                            type="search"
                            placeholder="Buscar expediente..."
                            class="w-full pl-9 pr-3 py-1.5 bg-gray-50/70 border border-gray-200 rounded-full text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:bg-white focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                        />
                    </div>

                    <!-- Campana de notificación -->
                    <button type="button" class="relative p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors" title="Notificaciones">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-[#8B1D2D] rounded-full"></span>
                    </button>

                    <!-- Perfil de Usuario con Avatar -->
                    <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-[#8B1D2D]/10 text-[#8B1D2D] font-bold text-xs flex items-center justify-center border border-[#8B1D2D]/20">
                            {{ strtoupper(substr($usuario->nombre_completo ?? 'Juan Pérez', 0, 2)) }}
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-bold text-gray-800 leading-tight">
                                {{ $usuario->nombre_completo ?? 'Juan Pérez' }}
                            </p>
                            <p class="text-[11px] text-gray-400 font-medium leading-tight">
                                {{ $usuario->roles->first()?->nombre_rol ? ucfirst(str_replace('_', ' ', $usuario->roles->first()->nombre_rol)) : 'Jefe UPS' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Indicador de fecha y hora institucional -->
            <div class="flex justify-end mt-2 pt-2 border-t border-gray-100 text-[11px] text-gray-400 items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Lunes, 28 de septiembre de 2026 &bull; 10:24 h</span>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL DEL DASHBOARD (2 COLUMNAS) -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

                <!-- ========================================================= -->
                <!-- COLUMNA IZQUIERDA (8 / 12 EN DESKTOP) -->
                <!-- ========================================================= -->
                <div class="xl:col-span-8 space-y-6">

                    @hasrole('Estudiante')
                        <!-- Banner informativo para estudiantes -->
                        <div class="bg-gradient-to-r from-[#8B1D2D] to-[#721523] rounded-3xl p-6 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-md rounded-md text-[11px] font-bold tracking-wide uppercase">
                                    Portal del Estudiante
                                </span>
                                <h3 class="text-lg font-bold">¡Bienvenido/a, {{ $usuario->nombre_completo }}!</h3>
                                <p class="text-xs text-rose-100 max-w-xl">
                                    Consulta los datos de tu proyecto asignado, el avance de tus horas sociales y sube tus documentos oficiales exclusivamente en formato PDF.
                                </p>
                            </div>
                            <a
                                href="{{ route('estudiante.proyecto') }}"
                                class="px-5 py-2.5 bg-white text-[#8B1D2D] hover:bg-rose-50 font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0 flex items-center gap-1.5 self-start sm:self-auto cursor-pointer"
                            >
                                <span>Ir a Mi Proyecto</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    @endhasrole

                    <!-- FILA DE 3 TARJETAS DE ESTADÍSTICAS (KPIs) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- KPI 1: Expedientes pendientes -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#FFF1F2] text-[#8B1D2D] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none">18</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Expedientes pendientes</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">6 más que la semana pasada</p>
                            </div>
                        </div>

                        <!-- KPI 2: Trámites en alerta -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#FFF5F2] text-[#E05238] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none">7</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Trámites en alerta</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Próximos a vencer en 10 días</p>
                            </div>
                        </div>

                        <!-- KPI 3: Certificaciones listas -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#FFF1F2] text-[#8B1D2D] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none">24</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Certificaciones listas</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">4 emitidas este mes</p>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA: EXPEDIENTES EN ESPERA DE AUDITORÍA -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden">
                        <!-- Cabecera de la sección -->
                        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h2 class="text-sm font-bold text-gray-900 tracking-tight">
                                    Expedientes en espera de auditoría de sellos y firma azul
                                </h2>
                            </div>
                            <a href="#ver-todos" class="text-xs font-bold text-[#8B1D2D] hover:underline flex items-center gap-1 transition-all">
                                <span>Ver todos</span>
                                <span>&rarr;</span>
                            </a>
                        </div>

                        <!-- Contenedor responsivo con scroll horizontal para móviles -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-gray-100 text-gray-400 font-semibold bg-gray-50/40">
                                        <th class="py-3 px-4 w-12 text-center">#</th>
                                        <th class="py-3 px-4">Carnet / Código</th>
                                        <th class="py-3 px-4">Área de conocimiento</th>
                                        <th class="py-3 px-4">Profesor responsable</th>
                                        <th class="py-3 px-4">Fecha de revisión</th>
                                        <th class="py-3 px-4 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    @foreach ($expedientes as $exp)
                                        <tr class="hover:bg-gray-50/70 transition-colors">
                                            <td class="py-3.5 px-4 text-center text-gray-400 font-medium">
                                                {{ $exp['num'] }}
                                            </td>
                                            <td class="py-3.5 px-4 font-bold text-gray-900 tracking-tight whitespace-nowrap">
                                                {{ $exp['codigo'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                                {{ $exp['area'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-700 whitespace-nowrap">
                                                {{ $exp['profesor'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-500 whitespace-nowrap">
                                                {{ $exp['fecha'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- Icono de ojo sutil -->
                                                    <span class="text-gray-300">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </span>
                                                    <!-- Botón Revisar -->
                                                    <button
                                                        type="button"
                                                        onclick="alert('Expediente {{ $exp['codigo'] }}: Auditoría y revisión de sellos activa.');"
                                                        class="px-3 py-1 bg-[#FFF1F2] hover:bg-[#8B1D2D] text-[#8B1D2D] hover:text-white border border-[#FFE4E6] rounded-md font-semibold text-[11px] transition-all duration-150 cursor-pointer shadow-2xs"
                                                    >
                                                        Revisar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ========================================================= -->
                <!-- COLUMNA DERECHA (4 / 12 EN DESKTOP) -->
                <!-- ========================================================= -->
                <div class="xl:col-span-4 space-y-6">

                    <!-- TARJETA 1: ALERTAS DE PLAZO -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-5 relative overflow-hidden">
                        <!-- Barra roja de acento en el borde derecho (exacto al diseño) -->
                        <div class="absolute right-0 top-1/4 bottom-1/4 w-1 bg-[#8B1D2D] rounded-l-full"></div>

                        <!-- Cabecera Alertas -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-amber-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </span>
                            <h3 class="text-xs font-bold text-gray-900 tracking-tight">Alertas de plazo</h3>
                        </div>

                        <!-- Lista de Alertas -->
                        <div class="space-y-3 divide-y divide-gray-100">
                            @foreach ($alertas as $alerta)
                                <div class="pt-2.5 first:pt-0">
                                    <p class="text-xs font-bold text-[#8B1D2D] leading-tight">
                                        {{ $alerta['codigo'] }}
                                    </p>
                                    <p class="text-[11px] @if($alerta['dias'] <= 5) text-red-600 font-semibold @else text-gray-400 @endif mt-0.5">
                                        {{ $alerta['plazo'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Enlace inferior -->
                        <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                            <a href="#alertas" class="text-xs font-bold text-[#8B1D2D] hover:underline inline-flex items-center gap-1">
                                <span>Ver todas las alertas</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- TARJETA 2: CALENDARIO DE PLAZOS -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold text-gray-900 tracking-tight">Calendario de plazos</h3>
                            <div class="flex items-center gap-1 text-xs font-bold text-[#8B1D2D]">
                                <span>&lsaquo;</span>
                                <span>Sep 2026</span>
                                <span>&rsaquo;</span>
                            </div>
                        </div>

                        <!-- Cuadrícula del Calendario -->
                        <div class="text-center text-xs">
                            <!-- Días de la semana -->
                            <div class="grid grid-cols-7 gap-1 text-[11px] font-semibold text-gray-400 mb-2">
                                <div>L</div>
                                <div>M</div>
                                <div>X</div>
                                <div>J</div>
                                <div>V</div>
                                <div>S</div>
                                <div>D</div>
                            </div>

                            <!-- Días del mes (Septiembre 2026) -->
                            <div class="grid grid-cols-7 gap-1 text-xs font-medium text-gray-700">
                                <!-- Espacios vacíos antes del 1 de septiembre -->
                                <div></div>
                                <div></div>
                                <div></div>
                                <div class="py-1 hover:bg-gray-50 rounded">1</div>
                                <div class="py-1 hover:bg-gray-50 rounded">2</div>
                                <div class="py-1 hover:bg-gray-50 rounded">3</div>
                                <div class="py-1 hover:bg-gray-50 rounded">4</div>

                                <div class="py-1 hover:bg-gray-50 rounded">5</div>
                                <div class="py-1 hover:bg-gray-50 rounded">6</div>
                                <div class="py-1 hover:bg-gray-50 rounded">7</div>
                                <div class="py-1 hover:bg-gray-50 rounded">8</div>
                                <div class="py-1 hover:bg-gray-50 rounded">9</div>
                                <div class="py-1 hover:bg-gray-50 rounded">10</div>
                                <div class="py-1 hover:bg-gray-50 rounded">11</div>

                                <div class="py-1 hover:bg-gray-50 rounded">12</div>
                                <div class="py-1 hover:bg-gray-50 rounded">13</div>
                                <div class="py-1 hover:bg-gray-50 rounded">14</div>
                                <div class="py-1 hover:bg-gray-50 rounded">15</div>
                                <div class="py-1 hover:bg-gray-50 rounded">16</div>
                                <div class="py-1 hover:bg-gray-50 rounded">17</div>
                                <div class="py-1 hover:bg-gray-50 rounded">18</div>

                                <div class="py-1 hover:bg-gray-50 rounded">19</div>
                                <div class="py-1 hover:bg-gray-50 rounded">20</div>
                                <div class="py-1 hover:bg-gray-50 rounded">21</div>
                                <div class="py-1 hover:bg-gray-50 rounded">22</div>
                                <div class="py-1 hover:bg-gray-50 rounded">23</div>
                                <!-- Día 24 destacado en recuadro guinda exacto a la imagen -->
                                <div class="py-1 bg-[#8B1D2D] text-white font-bold rounded-md shadow-2xs">24</div>
                                <div class="py-1 hover:bg-gray-50 rounded">25</div>

                                <div class="py-1 hover:bg-gray-50 rounded">26</div>
                                <div class="py-1 hover:bg-gray-50 rounded">27</div>
                                <div class="py-1 hover:bg-gray-50 rounded">28</div>
                                <div class="py-1 hover:bg-gray-50 rounded">29</div>
                                <div class="py-1 hover:bg-gray-50 rounded">30</div>
                                <div class="py-1 text-gray-300">1</div>
                                <div class="py-1 text-gray-300">2</div>
                            </div>
                        </div>
                    </div>

                    <!-- TARJETA 3: ACCIONES RÁPIDAS -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-5">
                        <h3 class="text-xs font-bold text-gray-900 tracking-tight mb-3">Acciones rápidas</h3>

                        <div class="space-y-2.5">
                            <!-- Acción 1: Registrar certificado (Destacado rosado/guinda) -->
                            <button
                                type="button"
                                onclick="alert('Módulo para registro y certificación de servicio social.');"
                                class="w-full p-3 bg-[#FFF5F6] hover:bg-[#FFEBEF] border border-[#FED7DE] rounded-xl text-left flex items-center gap-3 transition-colors cursor-pointer group shadow-2xs"
                            >
                                <span class="text-[#8B1D2D] group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-semibold text-gray-800">Registrar certificado</span>
                            </button>

                            <!-- Acción 2: Actualizar perfil -->
                            <button
                                type="button"
                                onclick="alert('Actualización de información de perfil del coordinador.');"
                                class="w-full p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-left flex items-center gap-3 transition-colors cursor-pointer group"
                            >
                                <span class="text-gray-400 group-hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-medium text-gray-700">Actualizar perfil</span>
                            </button>

                            <!-- Acción 3: Generar reporte -->
                            <button
                                type="button"
                                onclick="alert('Generación de informe estadístico PDF/Excel.');"
                                class="w-full p-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-left flex items-center gap-3 transition-colors cursor-pointer group"
                            >
                                <span class="text-gray-400 group-hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-medium text-gray-700">Generar reporte</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>

</body>
</html>
