<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Módulo de Auditoría y Trazabilidad del Sistema - Registro inmutable de eventos, dictámenes y cambios de roles de la UES">
    <title>Auditoría y Trazabilidad del Sistema | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'auditoria'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: AUDITORÍA Y TRAZABILIDAD (SOLO ADMIN)        -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA INSTITUCIONAL -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                        <span>Seguridad & Gobernanza</span>
                        <span>•</span>
                        <span class="text-[#8B1D2D]">COO-E04 / COO-HU-11</span>
                        <span>•</span>
                        <span class="bg-purple-100 text-purple-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-purple-200">Exclusivo Administrador</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                        <span>Auditoría y Trazabilidad del Sistema</span>
                        <span class="text-xs sm:text-sm font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-full border border-gray-200" title="Total de eventos registrados">
                            {{ number_format($totalEventos) }} registros
                        </span>
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-3xl">
                        Bitácora cronológica inmutable de acciones, dictámenes, observaciones, cambios de estado y accesos de todos los roles del sistema.
                    </p>
                </div>

                <!-- Selector de Vista: Línea de Tiempo vs Tabla -->
                <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-xl border border-gray-200 self-start sm:self-auto">
                    <a
                        href="{{ request()->fullUrlWithQuery(['vista' => 'timeline']) }}"
                        id="btn-vista-timeline"
                        class="px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1.5 transition-all {{ $modoVista === 'timeline' ? 'bg-white text-gray-900 shadow-xs border border-gray-200/70' : 'text-gray-500 hover:text-gray-900' }}"
                        title="Ver eventos en formato de línea de tiempo cronológica"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Línea de Tiempo</span>
                    </a>
                    <a
                        href="{{ request()->fullUrlWithQuery(['vista' => 'tabla']) }}"
                        id="btn-vista-tabla"
                        class="px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1.5 transition-all {{ $modoVista === 'tabla' ? 'bg-white text-gray-900 shadow-xs border border-gray-200/70' : 'text-gray-500 hover:text-gray-900' }}"
                        title="Ver eventos en formato de tabla tabular detallada"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 4h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Tabla</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- ========================================================= -->
            <!-- 1. TARJETAS DE MÉTRICAS RÁPIDAS (KPIS)                    -->
            <!-- ========================================================= -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- KPI 1: Total Eventos -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Eventos Auditados</span>
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center border border-purple-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ number_format($totalEventos) }}</div>
                    <p class="text-[11px] text-gray-400 mt-1">Registros en el filtro actual</p>
                </div>

                <!-- KPI 2: Aprobaciones y Avales -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Aprobaciones / Avales</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-emerald-800">{{ number_format($totalAprobaciones) }}</div>
                    <p class="text-[11px] text-emerald-600 mt-1">Dictámenes favorables y avales</p>
                </div>

                <!-- KPI 3: Observaciones y Rechazos -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-700">Observaciones Realizadas</span>
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center border border-rose-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-rose-800">{{ number_format($totalObservaciones) }}</div>
                    <p class="text-[11px] text-rose-600 mt-1">Historial preservado sin sobreescritura</p>
                </div>

                <!-- KPI 4: Usuarios / Roles Participantes -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Usuarios Auditados</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center border border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-blue-800">{{ number_format($usuariosAuditados) }}</div>
                    <p class="text-[11px] text-blue-600 mt-1">Cuentas con actividad registrada</p>
                </div>
            </div>

            <!-- ========================================================= -->
            <!-- 2. PANEL DE FILTROS AVANZADOS Y TEMPORALES                -->
            <!-- ========================================================= -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs space-y-4">
                <form id="form-filtros-auditoria" method="GET" action="{{ route('auditoria.index') }}" class="space-y-4">
                    <input type="hidden" name="vista" value="{{ $modoVista }}">

                    <!-- Fila 1: Búsqueda y Dropdowns principales -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- Buscador por texto libre -->
                        <div class="sm:col-span-2">
                            <label for="input-search" class="block text-xs font-bold text-gray-700 mb-1">
                                Buscar por usuario, nombre, documento o detalle:
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="input-search"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Ej: carnet 2024, Juan Pérez, Aprobado, Plan de Trabajo..."
                                    class="w-full pl-9 pr-4 py-2 bg-gray-50/70 border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#8B1D2D] focus:border-[#8B1D2D] transition-colors"
                                />
                            </div>
                        </div>

                        <!-- Filtro por Rol -->
                        <div>
                            <label for="select-rol" class="block text-xs font-bold text-gray-700 mb-1">
                                Rol del responsable:
                            </label>
                            <select
                                id="select-rol"
                                name="rol"
                                class="w-full px-3 py-2 bg-gray-50/70 border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#8B1D2D] focus:border-[#8B1D2D] transition-colors"
                            >
                                <option value="">Todos los Roles</option>
                                <option value="Administrador" {{ $rolSeleccionado === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="Docente Tutor" {{ $rolSeleccionado === 'Docente Tutor' ? 'selected' : '' }}>Docente Tutor</option>
                                <option value="Coordinador de Carrera" {{ $rolSeleccionado === 'Coordinador de Carrera' ? 'selected' : '' }}>Coordinador de Carrera</option>
                                <option value="Coordinador UPS" {{ $rolSeleccionado === 'Coordinador UPS' ? 'selected' : '' }}>Coordinador UPS</option>
                                <option value="Auxiliar UPS" {{ $rolSeleccionado === 'Auxiliar UPS' ? 'selected' : '' }}>Auxiliar UPS</option>
                                <option value="Estudiante" {{ $rolSeleccionado === 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Sistema" {{ $rolSeleccionado === 'Sistema' ? 'selected' : '' }}>Sistema Automatizado</option>
                            </select>
                        </div>

                        <!-- Filtro por Acción -->
                        <div>
                            <label for="select-accion" class="block text-xs font-bold text-gray-700 mb-1">
                                Tipo de acción:
                            </label>
                            <select
                                id="select-accion"
                                name="accion"
                                class="w-full px-3 py-2 bg-gray-50/70 border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-[#8B1D2D] focus:border-[#8B1D2D] transition-colors"
                            >
                                <option value="">Todas las Acciones</option>
                                <option value="aprobacion_tutor" {{ $accionSeleccionada === 'aprobacion_tutor' ? 'selected' : '' }}>Aprobación de Tutor</option>
                                <option value="observacion_tutor" {{ $accionSeleccionada === 'observacion_tutor' ? 'selected' : '' }}>Observación de Tutor</option>
                                <option value="aval_coordinador" {{ $accionSeleccionada === 'aval_coordinador' ? 'selected' : '' }}>Aval de Coordinador</option>
                                <option value="observacion_carrera" {{ $accionSeleccionada === 'observacion_carrera' ? 'selected' : '' }}>Observación de Carrera</option>
                                <option value="auditoria_ups" {{ $accionSeleccionada === 'auditoria_ups' ? 'selected' : '' }}>Auditoría UPS (Sellos)</option>
                                <option value="emision_certificado" {{ $accionSeleccionada === 'emision_certificado' ? 'selected' : '' }}>Emisión de Certificado</option>
                                <option value="asignacion_tutor" {{ $accionSeleccionada === 'asignacion_tutor' ? 'selected' : '' }}>Asignación de Tutor</option>
                                <option value="reasignacion_tutor" {{ $accionSeleccionada === 'reasignacion_tutor' ? 'selected' : '' }}>Reasignación de Tutor</option>
                                <option value="subida_documento" {{ $accionSeleccionada === 'subida_documento' ? 'selected' : '' }}>Subida de Documento</option>
                                <option value="creacion_usuario" {{ $accionSeleccionada === 'creacion_usuario' ? 'selected' : '' }}>Creación de Usuario</option>
                                <option value="actualizacion_roles" {{ $accionSeleccionada === 'actualizacion_roles' ? 'selected' : '' }}>Actualización de Roles</option>
                                <option value="inicio_sesion" {{ $accionSeleccionada === 'inicio_sesion' ? 'selected' : '' }}>Inicio de Sesión</option>
                                <option value="cierre_sesion" {{ $accionSeleccionada === 'cierre_sesion' ? 'selected' : '' }}>Cierre de Sesión</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fila 2: Períodos Rápidos y Rango de Fechas Personalizado -->
                    <div class="pt-3 border-t border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Chips de Períodos Rápidos -->
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="text-xs font-bold text-gray-500 mr-1">Período:</span>
                            <button
                                type="button"
                                onclick="setPeriodo('')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-colors cursor-pointer {{ empty($periodoSeleccionado) && empty($fechaDesde) ? 'bg-[#8B1D2D] text-white border-[#8B1D2D]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                            >
                                Todo el tiempo
                            </button>
                            <button
                                type="button"
                                onclick="setPeriodo('hoy')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-colors cursor-pointer {{ $periodoSeleccionado === 'hoy' ? 'bg-[#8B1D2D] text-white border-[#8B1D2D]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                            >
                                Hoy
                            </button>
                            <button
                                type="button"
                                onclick="setPeriodo('7dias')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-colors cursor-pointer {{ $periodoSeleccionado === '7dias' ? 'bg-[#8B1D2D] text-white border-[#8B1D2D]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                            >
                                Últimos 7 días
                            </button>
                            <button
                                type="button"
                                onclick="setPeriodo('30dias')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-colors cursor-pointer {{ $periodoSeleccionado === '30dias' ? 'bg-[#8B1D2D] text-white border-[#8B1D2D]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                            >
                                Últimos 30 días
                            </button>
                            <button
                                type="button"
                                onclick="setPeriodo('este_mes')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-colors cursor-pointer {{ $periodoSeleccionado === 'este_mes' ? 'bg-[#8B1D2D] text-white border-[#8B1D2D]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}"
                            >
                                Este Mes
                            </button>
                            <input type="hidden" id="input-periodo" name="periodo" value="{{ $periodoSeleccionado }}">
                        </div>

                        <!-- Fechas Desde / Hasta Personalizadas -->
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="flex items-center gap-1.5">
                                <label for="input-fecha-desde" class="text-xs font-bold text-gray-600">Desde:</label>
                                <input
                                    type="date"
                                    id="input-fecha-desde"
                                    name="fecha_desde"
                                    value="{{ $fechaDesde }}"
                                    class="px-2.5 py-1 bg-gray-50/70 border border-gray-300 rounded-lg text-xs text-gray-800 focus:bg-white focus:ring-1 focus:ring-[#8B1D2D]"
                                />
                            </div>
                            <div class="flex items-center gap-1.5">
                                <label for="input-fecha-hasta" class="text-xs font-bold text-gray-600">Hasta:</label>
                                <input
                                    type="date"
                                    id="input-fecha-hasta"
                                    name="fecha_hasta"
                                    value="{{ $fechaHasta }}"
                                    class="px-2.5 py-1 bg-gray-50/70 border border-gray-300 rounded-lg text-xs text-gray-800 focus:bg-white focus:ring-1 focus:ring-[#8B1D2D]"
                                />
                            </div>

                            <!-- Botones Aplicar y Limpiar -->
                            <div class="flex items-center gap-2 ml-auto sm:ml-0">
                                <button
                                    type="submit"
                                    id="btn-aplicar-filtros"
                                    class="px-4 py-1.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs font-bold rounded-lg shadow-2xs transition-colors cursor-pointer flex items-center gap-1"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    <span>Filtrar</span>
                                </button>
                                <a
                                    href="{{ route('auditoria.index') }}"
                                    id="btn-limpiar-filtros"
                                    class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-colors"
                                    title="Restablecer todos los filtros"
                                >
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ========================================================= -->
            <!-- 3. CONTENIDO: LÍNEA DE TIEMPO VISUAL O TABLA              -->
            <!-- ========================================================= -->
            @if ($auditorias->isEmpty())
                <!-- Estado Vacío -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-12 text-center shadow-2xs">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">No se encontraron eventos de auditoría</h3>
                    <p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto mb-5">
                        No hay registros que coincidan con los criterios de búsqueda o filtros temporales seleccionados.
                    </p>
                    <a
                        href="{{ route('auditoria.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors"
                    >
                        <span>Restablecer filtros</span>
                    </a>
                </div>
            @elseif ($modoVista === 'timeline')
                <!-- ===================================================== -->
                <!-- VISTA 1: TIMELINE CRONOLÓGICO VISUAL                  -->
                <!-- ===================================================== -->
                <div class="relative pl-6 sm:pl-8 space-y-6 before:content-[''] before:absolute before:left-3 sm:before:left-4 before:top-3 before:bottom-3 before:w-0.5 before:bg-gray-200">
                    @foreach ($auditorias as $evento)
                        @php
                            // Configuración de color e icono según acción
                            $isAprobacion = in_array($evento->accion, ['aprobacion', 'aprobacion_tutor', 'aval', 'aval_coordinador', 'emision_certificado', 'auditoria_ups']);
                            $isObservacion = in_array($evento->accion, ['observacion', 'observacion_tutor', 'observacion_carrera', 'rechazo']);
                            $isReasignacion = in_array($evento->accion, ['asignacion_tutor', 'reasignacion_tutor']);
                            $isSubida = $evento->accion === 'subida_documento';
                            $isUserRole = in_array($evento->accion, ['creacion_usuario', 'actualizacion_roles']);
                            $isLogin = in_array($evento->accion, ['inicio_sesion', 'cierre_sesion']);

                            $nodeBg = match(true) {
                                $isAprobacion => 'bg-emerald-600 ring-4 ring-emerald-50 text-white',
                                $isObservacion => 'bg-rose-600 ring-4 ring-rose-50 text-white',
                                $isReasignacion => 'bg-blue-600 ring-4 ring-blue-50 text-white',
                                $isSubida => 'bg-indigo-600 ring-4 ring-indigo-50 text-white',
                                $isUserRole => 'bg-purple-600 ring-4 ring-purple-50 text-white',
                                $isLogin => 'bg-teal-600 ring-4 ring-teal-50 text-white',
                                default => 'bg-gray-700 ring-4 ring-gray-100 text-white',
                            };
                        @endphp

                        <!-- Elemento de la Línea de Tiempo -->
                        <div class="relative group">
                            <!-- Nodo Circular en la Línea -->
                            <div class="absolute -left-6 sm:-left-8 top-4 w-6 h-6 rounded-full {{ $nodeBg }} flex items-center justify-center text-xs shadow-xs z-10 transition-transform group-hover:scale-110">
                                @if ($isAprobacion)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                @elseif ($isObservacion)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01" /></svg>
                                @elseif ($isReasignacion)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                @elseif ($isSubida)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                @elseif ($isLogin)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </div>

                            <!-- Tarjeta de Contenido del Evento -->
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs hover:shadow-xs transition-all hover:border-gray-300 space-y-3">
                                <!-- Cabecera del Evento -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2.5 border-b border-gray-100">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <!-- Badge de Acción -->
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $evento->getAccionBadgeClass() }}">
                                            {{ strtoupper(str_replace('_', ' ', $evento->accion)) }}
                                        </span>

                                        <!-- Badge de Módulo -->
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            Módulo: <strong class="text-gray-900">{{ ucfirst($evento->modulo) }}</strong>
                                        </span>

                                        @if ($evento->id_entidad)
                                            <span class="text-[11px] font-mono font-semibold text-gray-500">
                                                ID: #{{ $evento->id_entidad }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Marca Temporal -->
                                    <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span title="{{ $evento->created_at?->format('Y-m-d H:i:s') }}">
                                            {{ $evento->created_at?->format('d/m/Y H:i:s') }}
                                        </span>
                                        <span class="text-gray-300">•</span>
                                        <span class="text-gray-400 text-[11px]">
                                            {{ $evento->created_at?->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Responsable y Título -->
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-3">
                                    <!-- Datos del Responsable -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 text-gray-700 font-extrabold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($evento->nombre_persona ?? 'S', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold text-gray-900 leading-tight">
                                                    {{ $evento->nombre_persona ?? 'Sistema' }}
                                                </span>
                                                <span class="text-xs font-mono text-gray-500">
                                                    ({{ '@' . ($evento->nombre_usuario ?? 'sistema') }})
                                                </span>
                                            </div>
                                            <div class="mt-0.5">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $evento->getRolBadgeClass() }}">
                                                    {{ $evento->rol ?? 'Sistema' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transición de Estado (si aplica) -->
                                    @if ($evento->estado_anterior || $evento->estado_nuevo)
                                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200 self-start">
                                            <span class="text-[11px] font-medium text-gray-500">Transición:</span>
                                            @if ($evento->estado_anterior)
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-gray-700 border border-gray-300">
                                                    {{ $evento->estado_anterior }}
                                                </span>
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                            @endif
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#8B1D2D]/10 text-[#8B1D2D] border border-[#8B1D2D]/20">
                                                {{ $evento->estado_nuevo ?? 'Actualizado' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Título Principal del Evento -->
                                <div class="text-sm font-extrabold text-gray-900">
                                    {{ $evento->titulo }}
                                </div>

                                <!-- Detalles / Observación Registrada (Preservada sin sobreescritura) -->
                                @if ($evento->detalles)
                                    <div class="p-3.5 rounded-xl text-xs leading-relaxed {{ $isObservacion ? 'bg-rose-50/80 border border-rose-200 text-rose-900 font-medium' : ($isAprobacion ? 'bg-emerald-50/80 border border-emerald-200 text-emerald-900' : 'bg-gray-50 border border-gray-200 text-gray-700') }}">
                                        <div class="flex items-start gap-2">
                                            @if ($isObservacion)
                                                <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                <div>
                                                    <strong class="font-bold text-rose-800">Observaciones Técnicas Registradas:</strong>
                                                    <p class="mt-0.5 whitespace-pre-line">{{ $evento->detalles }}</p>
                                                </div>
                                            @else
                                                <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>
                                                    <p class="whitespace-pre-line">{{ $evento->detalles }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Pie Técnico: IP, Navegador y Metadatos JSON (Desplegable) -->
                                <div class="pt-2 flex flex-wrap items-center justify-between gap-2 text-[11px] text-gray-400 border-t border-gray-50">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center gap-1 font-mono">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                            IP: {{ $evento->ip_address ?? '127.0.0.1' }}
                                        </span>
                                        @if ($evento->user_agent)
                                            <span class="truncate max-w-xs text-gray-400" title="{{ $evento->user_agent }}">
                                                {{ Str::limit($evento->user_agent, 45) }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($evento->metadatos && count($evento->metadatos) > 0)
                                        <details class="group/meta">
                                            <summary class="cursor-pointer text-[#8B1D2D] hover:underline font-semibold flex items-center gap-1 select-none">
                                                <span>Ver Metadatos</span>
                                                <svg class="w-3 h-3 transition-transform group-open/meta:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                            </summary>
                                            <div class="mt-2 p-2.5 bg-gray-900 text-emerald-400 font-mono text-[11px] rounded-lg overflow-x-auto max-w-full">
                                                <pre>{{ json_encode($evento->metadatos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        </details>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- ===================================================== -->
                <!-- VISTA 2: TABLA DETALLADA TABULAR                      -->
                <!-- ===================================================== -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider text-[11px]">
                                    <th class="py-3.5 px-4">Fecha / Hora</th>
                                    <th class="py-3.5 px-4">Usuario Responsable</th>
                                    <th class="py-3.5 px-4">Rol</th>
                                    <th class="py-3.5 px-4">Módulo / Acción</th>
                                    <th class="py-3.5 px-4">Título y Observaciones</th>
                                    <th class="py-3.5 px-4">Transición</th>
                                    <th class="py-3.5 px-4 text-right">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-normal">
                                @foreach ($auditorias as $evento)
                                    <tr class="hover:bg-gray-50/60 transition-colors">
                                        <!-- Fecha / Hora -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900">{{ $evento->created_at?->format('d/m/Y') }}</div>
                                            <div class="text-[11px] font-mono text-gray-400">{{ $evento->created_at?->format('H:i:s') }}</div>
                                        </td>

                                        <!-- Usuario Responsable -->
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-gray-900">{{ $evento->nombre_persona ?? 'Sistema' }}</div>
                                            <div class="text-[11px] font-mono text-gray-500">{{ '@' . ($evento->nombre_usuario ?? 'sistema') }}</div>
                                        </td>

                                        <!-- Rol -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $evento->getRolBadgeClass() }}">
                                                {{ $evento->rol ?? 'Sistema' }}
                                            </span>
                                        </td>

                                        <!-- Módulo / Acción -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $evento->getAccionBadgeClass() }}">
                                                {{ str_replace('_', ' ', $evento->accion) }}
                                            </span>
                                            <div class="text-[11px] text-gray-500 font-medium mt-0.5">
                                                {{ ucfirst($evento->modulo) }} @if($evento->id_entidad)#{{ $evento->id_entidad }}@endif
                                            </div>
                                        </td>

                                        <!-- Título y Observaciones -->
                                        <td class="py-3.5 px-4 max-w-md">
                                            <div class="font-bold text-gray-900 mb-0.5">{{ $evento->titulo }}</div>
                                            @if ($evento->detalles)
                                                <div class="text-[11px] text-gray-600 line-clamp-2" title="{{ $evento->detalles }}">
                                                    {{ $evento->detalles }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Transición -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            @if ($evento->estado_anterior || $evento->estado_nuevo)
                                                <div class="flex items-center gap-1.5 text-[11px]">
                                                    <span class="text-gray-500">{{ $evento->estado_anterior ?? '—' }}</span>
                                                    <span class="text-gray-400 font-bold">➔</span>
                                                    <span class="font-bold text-[#8B1D2D]">{{ $evento->estado_nuevo ?? '—' }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-[11px]">—</span>
                                            @endif
                                        </td>

                                        <!-- IP -->
                                        <td class="py-3.5 px-4 whitespace-nowrap text-right font-mono text-[11px] text-gray-400">
                                            {{ $evento->ip_address ?? '127.0.0.1' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- ========================================================= -->
            <!-- 4. CONTROLES DE PAGINACIÓN                                -->
            <!-- ========================================================= -->
            @if ($auditorias->hasPages())
                <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-2xs flex items-center justify-between">
                    {{ $auditorias->links() }}
                </div>
            @endif
        </main>
    </div>

    <!-- Script de soporte para filtros dinámicos de períodos -->
    <script>
        function setPeriodo(valor) {
            document.getElementById('input-periodo').value = valor;
            if (valor !== '') {
                document.getElementById('input-fecha-desde').value = '';
                document.getElementById('input-fecha-hasta').value = '';
            }
            document.getElementById('form-filtros-auditoria').submit();
        }
    </script>
</body>
</html>
