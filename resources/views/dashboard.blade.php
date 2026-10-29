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

                    @if(session('status'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                <span>{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- FILA DE 3 TARJETAS DE ESTADÍSTICAS (KPIs) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- KPI 1: Expedientes pendientes de auditoría -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#FFF1F2] text-[#8B1D2D] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none">{{ $totalPendientesAuditoria ?? 0 }}</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Expedientes en auditoría</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Pendientes de sellos y firmas</p>
                            </div>
                        </div>

                        <!-- KPI 2: Proyectos Activos -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#FFF5F2] text-[#E05238] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none">{{ $totalProyectosActivos ?? 0 }}</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Proyectos activos</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">En ejecución o trámite</p>
                            </div>
                        </div>

                        <!-- KPI 3: Certificaciones listas -->
                        <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xs transition-shadow flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-emerald-700 tracking-tight leading-none">{{ $totalCertificadosListos ?? 0 }}</p>
                                <p class="text-xs font-bold text-gray-800 mt-1">Certificados emitidos</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Con folio UES oficial</p>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA: EXPEDIENTES EN ESPERA DE AUDITORÍA -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden">
                        <!-- Cabecera de la sección -->
                        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900 tracking-tight">
                                        Expedientes para Auditoría de Sellos y Emisión de Certificado (UPS)
                                    </h2>
                                    <p class="text-[11px] text-gray-400">Control normativo RF-UPS-07 (sellos y firma azul) y HU-33 (folio oficial)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ $documentosListosUPS->count() }} {{ $documentosListosUPS->count() === 1 ? 'pendiente de trámite' : 'pendientes de trámite' }}
                                </span>
                                <a href="{{ route('certificados.index') }}" class="text-xs font-bold text-[#8B1D2D] hover:underline flex items-center gap-1 transition-all">
                                    <span>Ver todos</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- A. TABLA PRINCIPAL PRIORIDAD 1: ENVIADOS POR COORDINACIÓN (LISTOS PARA AUDITAR SELLOS O EMITIR CERTIFICADO) -->
                        <div>
                            <div class="px-5 py-3 bg-amber-50/40 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-950 flex items-center gap-1.5 uppercase tracking-wider">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Prioridad 1: Enviados por Coordinación &bull; Listos para Auditar Sellos o Emitir Certificado
                                </span>
                                <span class="text-[11px] text-amber-700 font-semibold hidden sm:inline">Acción inmediata requerida</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                            <th class="py-3 px-4 w-10 text-center">#</th>
                                            <th class="py-3 px-4">Carnet / Estudiante</th>
                                            <th class="py-3 px-4">Proyecto & Tutor</th>
                                            <th class="py-3 px-4">Documento / Tipo</th>
                                            <th class="py-3 px-4">Estado</th>
                                            <th class="py-3 px-4 text-center">Acciones Operativas UPS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-gray-700">
                                        @forelse ($documentosListosUPS as $doc)
                                            @php
                                                $proyecto = $doc->proyectos->first();
                                                $alumno = $proyecto?->alumnos->first();
                                            @endphp
                                            <tr
                                                class="hover:bg-amber-50/30 transition-colors cursor-pointer group"
                                                ondblclick="window.location.href='{{ route('certificados.show', $doc) }}'"
                                                title="Doble clic para abrir revisión documental"
                                            >
                                                <td class="py-3.5 px-4 text-center text-gray-400 font-medium">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="py-3.5 px-4 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        <span class="font-bold text-gray-900 font-mono">{{ $alumno?->carnet ?? $alumno?->nombre_usuario ?? 'UES-EXP' }}</span>
                                                        <span class="text-[11px] text-gray-500 max-w-[150px] truncate" title="{{ $alumno?->nombre_completo ?? 'Estudiante' }}">{{ $alumno?->nombre_completo ?? 'Estudiante Inscrito' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 whitespace-nowrap">
                                                    <div class="flex flex-col max-w-[190px]">
                                                        <span class="font-semibold text-gray-900 truncate" title="{{ $proyecto?->nombre_proyecto ?? 'Sin proyecto' }}">
                                                            {{ $proyecto?->nombre_proyecto ?? 'Sin proyecto' }}
                                                        </span>
                                                        <span class="text-[10px] text-gray-400 truncate">
                                                            Tutor: {{ $proyecto?->tutor?->nombre_completo ?? 'Por asignar' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-lg bg-red-50 text-[#8B1D2D] flex items-center justify-center shrink-0 font-mono text-[10px] font-bold">
                                                            PDF
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span class="font-semibold text-gray-800 truncate max-w-[170px]" title="{{ $doc->nombre_documento }}">{{ $doc->nombre_documento }}</span>
                                                            <span class="text-[10px] text-gray-400 font-mono uppercase">{{ $doc->tipo }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 whitespace-nowrap">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $doc->estado_revision_badge }}">
                                                        {{ $doc->estado_revision_texto }}
                                                    </span>
                                                </td>
                                                <td class="py-3.5 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                                    <div class="flex items-center justify-center gap-1.5">
                                                        <!-- Si tiene Aval de Carrera: Botón Auditar Sellos -->
                                                        @if($doc->estado_revision === 'aval_carrera')
                                                            <form action="{{ route('ups.auditar', $doc->id_documento) }}" method="POST" class="inline" onsubmit="return confirm('¿Confirmar auditoría visual de sellos y firmas en tinta azul conforme a RF-UPS-07?');">
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white border border-amber-200 rounded-lg font-bold text-[11px] transition-all cursor-pointer flex items-center gap-1 shadow-2xs"
                                                                    title="Auditar Sellos y Firmas en Tinta Azul (RF-UPS-07)"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    <span>Auditar Sellos</span>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <!-- Si ya fue auditado: Botón Emitir Certificado con Folio y Botón Retractar -->
                                                        @if($doc->estado_revision === 'auditado_ups')
                                                            <form action="{{ route('ups.emitirCertificado', $doc->id_documento) }}" method="POST" class="inline" onsubmit="return confirm('¿Emitir certificación oficial institucional con Folio Único para este estudiante?');">
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-[11px] transition-all cursor-pointer flex items-center gap-1 shadow-2xs"
                                                                    title="Emitir Certificado Oficial con Folio (HU-33)"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                    <span>Emitir Certificado</span>
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('ups.auditar', $doc->id_documento) }}" method="POST" class="inline" onsubmit="return confirm('¿Retractar auditoría de sellos y devolver a Aval de Carrera?');">
                                                                @csrf
                                                                <input type="hidden" name="accion" value="retractar">
                                                                <button
                                                                    type="submit"
                                                                    class="px-2 py-1.5 bg-white hover:bg-gray-100 text-gray-600 border border-gray-200 rounded-lg font-semibold text-[11px] transition-colors cursor-pointer"
                                                                    title="Retractar auditoría y devolver a Aval de Carrera"
                                                                >
                                                                    Retractar
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <!-- Ver PDF -->
                                                        @if($doc->url_documento)
                                                            <a
                                                                href="{{ $doc->url_documento }}"
                                                                target="_blank"
                                                                class="p-1.5 text-gray-500 hover:text-[#8B1D2D] hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors cursor-pointer inline-flex items-center"
                                                                title="Visualizar documento PDF"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </a>

                                                            <!-- Descargar PDF -->
                                                            <a
                                                                href="{{ $doc->url_documento }}"
                                                                download
                                                                class="p-1.5 text-gray-500 hover:text-[#8B1D2D] hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors cursor-pointer inline-flex items-center"
                                                                title="Descargar documento PDF"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                            </a>
                                                        @endif

                                                        <!-- Revisar -->
                                                        <a
                                                            href="{{ route('certificados.show', $doc) }}"
                                                            class="px-2 py-1.5 bg-red-50 hover:bg-[#8B1D2D] text-[#8B1D2D] hover:text-white rounded-lg font-bold text-[11px] transition-all cursor-pointer inline-flex items-center"
                                                            title="Abrir revisión documental detallada"
                                                        >
                                                            Revisar
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="p-6 text-center text-gray-400 bg-white">
                                                    <p class="font-bold text-gray-600 text-xs">No hay expedientes pendientes de auditoría o certificación en este momento</p>
                                                    <p class="text-[11px] text-gray-400 mt-0.5">Los coordinadores de carrera deben emitir primero el aval institucional para trasladar los expedientes a UPS.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- B. TABLA PRIORIDAD 2: EXPEDIENTES EN SEGUIMIENTO (EN ETAPAS PREVIAS DE LA CARRERA) -->
                        @if ($documentosEnSeguimiento->isNotEmpty())
                            <div class="border-t border-gray-100">
                                <div class="px-5 py-3 bg-blue-50/40 border-b border-gray-100 flex items-center justify-between">
                                    <span class="text-xs font-bold text-blue-950 flex items-center gap-1.5 uppercase tracking-wider">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Prioridad 2: Expedientes en Seguimiento &bull; En Etapas Previas ({{ $documentosEnSeguimiento->count() }})
                                    </span>
                                    <span class="text-[11px] text-blue-700 font-semibold hidden sm:inline">En trámite de tutor o coordinación de carrera</span>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead>
                                            <tr class="border-b border-gray-100 bg-gray-50/40 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                                <th class="py-2.5 px-4">Carnet / Estudiante</th>
                                                <th class="py-2.5 px-4">Proyecto & Tutor</th>
                                                <th class="py-2.5 px-4">Documento</th>
                                                <th class="py-2.5 px-4">Estado Actual</th>
                                                <th class="py-2.5 px-4">Dictamen / Observaciones</th>
                                                <th class="py-2.5 px-4 text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                                            @foreach ($documentosEnSeguimiento as $docSeg)
                                                @php
                                                    $proySeg = $docSeg->proyectos->first();
                                                    $alumnoSeg = $proySeg?->alumnos->first();
                                                @endphp
                                                <tr
                                                    class="hover:bg-gray-50/60 transition-colors cursor-pointer"
                                                    ondblclick="window.location.href='{{ route('certificados.show', $docSeg) }}'"
                                                    title="Doble clic para abrir revisión documental"
                                                >
                                                    <td class="py-3 px-4 whitespace-nowrap">
                                                        <div class="flex flex-col">
                                                            <span class="font-bold text-gray-900 font-mono">{{ $alumnoSeg?->carnet ?? $alumnoSeg?->nombre_usuario ?? 'UES-EXP' }}</span>
                                                            <span class="text-[11px] text-gray-500 max-w-[130px] truncate" title="{{ $alumnoSeg?->nombre_completo ?? 'Estudiante' }}">{{ $alumnoSeg?->nombre_completo ?? 'Estudiante' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 whitespace-nowrap">
                                                        <div class="flex flex-col max-w-[180px]">
                                                            <span class="font-medium text-gray-800 truncate" title="{{ $proySeg?->nombre_proyecto ?? 'Sin proyecto' }}">{{ $proySeg?->nombre_proyecto ?? 'Sin proyecto' }}</span>
                                                            <span class="text-[10px] text-gray-400 truncate">Tutor: {{ $proySeg?->tutor?->nombre_completo ?? 'Por asignar' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 whitespace-nowrap">
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="text-gray-400 font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-gray-100">PDF</span>
                                                            <span class="font-semibold text-gray-800 max-w-[150px] truncate" title="{{ $docSeg->nombre_documento }}">{{ $docSeg->nombre_documento }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 whitespace-nowrap">
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $docSeg->estado_revision_badge }}">
                                                            {{ $docSeg->estado_revision_texto }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 px-4 text-gray-500 max-w-xs text-[11px] truncate">
                                                        {{ $docSeg->observaciones ?: ($docSeg->motivo_rechazo ?: 'En espera de dictamen técnico o aval de carrera.') }}
                                                    </td>
                                                    <td class="py-3 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                                        <div class="flex items-center justify-center gap-1.5">
                                                            @if($docSeg->url_documento)
                                                                <a
                                                                    href="{{ $docSeg->url_documento }}"
                                                                    target="_blank"
                                                                    class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                                    title="Ver PDF"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a>
                                                                <a
                                                                    href="{{ $docSeg->url_documento }}"
                                                                    download
                                                                    class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                                    title="Descargar PDF"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                    </svg>
                                                                </a>
                                                            @endif
                                                            <a
                                                                href="{{ route('certificados.show', $docSeg) }}"
                                                                class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-[11px] rounded-lg transition-colors"
                                                                title="Revisar expediente"
                                                            >
                                                                Revisar
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- C. DESPLEGABLE OCULTO: EXPEDIENTES YA CERTIFICADOS POR LA UPS (VER MÁS) -->
                        @if ($documentosCertificadosUPS->isNotEmpty())
                            <div class="border-t border-gray-100 bg-gray-50/50">
                                <button
                                    type="button"
                                    onclick="toggleCertificadosUPS()"
                                    id="btnToggleCertificadosUPS"
                                    class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-100/70 transition-colors cursor-pointer group"
                                    aria-expanded="false"
                                >
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">
                                            ✓
                                        </span>
                                        <div>
                                            <span class="text-xs font-bold text-gray-800 group-hover:text-emerald-950">
                                                Ver más: Expedientes con Certificación Emitida y Folio UES ({{ $documentosCertificadosUPS->count() }})
                                            </span>
                                            <p class="text-[11px] text-gray-400">Expedientes finalizados con folio oficial registrado en el libro de Proyección Social</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-gray-500 group-hover:text-gray-800" id="textoToggleCertificadosUPS">
                                            Mostrar certificados
                                        </span>
                                        <svg id="iconToggleCertificadosUPS" class="w-4 h-4 text-gray-400 group-hover:text-gray-700 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                <div id="contenedorCertificadosUPS" class="hidden border-t border-gray-200/80 bg-white">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse text-xs">
                                            <thead>
                                                <tr class="border-b border-gray-100 bg-emerald-50/30 text-emerald-900 font-semibold uppercase tracking-wider text-[10px]">
                                                    <th class="py-2.5 px-4">Folio Oficial</th>
                                                    <th class="py-2.5 px-4">Carnet / Estudiante</th>
                                                    <th class="py-2.5 px-4">Proyecto</th>
                                                    <th class="py-2.5 px-4">Documento</th>
                                                    <th class="py-2.5 px-4">Estado</th>
                                                    <th class="py-2.5 px-4 text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                                @foreach ($documentosCertificadosUPS as $docCert)
                                                    @php
                                                        $proyCert = $docCert->proyectos->first();
                                                        $alumnoCert = $proyCert?->alumnos->first();
                                                    @endphp
                                                    <tr
                                                        class="hover:bg-emerald-50/20 transition-colors cursor-pointer"
                                                        ondblclick="window.location.href='{{ route('certificados.show', $docCert) }}'"
                                                        title="Doble clic para abrir revisión documental"
                                                    >
                                                        <td class="py-3 px-4 whitespace-nowrap font-mono font-bold text-emerald-800">
                                                            <span class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-[11px]">
                                                                {{ $docCert->folio ?? 'FOLIO-PEND' }}
                                                            </span>
                                                        </td>
                                                        <td class="py-3 px-4 whitespace-nowrap">
                                                            <div class="flex flex-col">
                                                                <span class="font-bold text-gray-900 font-mono">{{ $alumnoCert?->carnet ?? $alumnoCert?->nombre_usuario ?? 'UES-EXP' }}</span>
                                                                <span class="text-[11px] text-gray-500 max-w-[130px] truncate" title="{{ $alumnoCert?->nombre_completo ?? 'Estudiante' }}">{{ $alumnoCert?->nombre_completo ?? 'Estudiante' }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="py-3 px-4 whitespace-nowrap text-gray-700">
                                                            <span class="truncate max-w-[180px] inline-block" title="{{ $proyCert?->nombre_proyecto ?? 'Sin proyecto' }}">{{ $proyCert?->nombre_proyecto ?? 'Sin proyecto' }}</span>
                                                        </td>
                                                        <td class="py-3 px-4 whitespace-nowrap">
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-emerald-700 font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-50">PDF</span>
                                                                <span class="font-semibold text-gray-800 max-w-[160px] truncate" title="{{ $docCert->nombre_documento }}">{{ $docCert->nombre_documento }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="py-3 px-4 whitespace-nowrap">
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span>Certificado Emitido</span>
                                                            </span>
                                                        </td>
                                                        <td class="py-3 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                                            <div class="flex items-center justify-center gap-1.5">
                                                                @if($docCert->url_documento)
                                                                    <a
                                                                        href="{{ $docCert->url_documento }}"
                                                                        target="_blank"
                                                                        class="p-1.5 bg-white hover:bg-emerald-50 text-emerald-800 border border-gray-200 rounded-lg transition-colors inline-flex items-center"
                                                                        title="Ver PDF Certificado"
                                                                    >
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                    </a>
                                                                    <a
                                                                        href="{{ $docCert->url_documento }}"
                                                                        download
                                                                        class="p-1.5 bg-white hover:bg-emerald-50 text-emerald-800 border border-gray-200 rounded-lg transition-colors inline-flex items-center"
                                                                        title="Descargar PDF"
                                                                    >
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                        </svg>
                                                                    </a>
                                                                @endif
                                                                <a
                                                                    href="{{ route('certificados.show', $docCert) }}"
                                                                    class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-[11px] rounded-lg transition-colors"
                                                                    title="Revisar expediente"
                                                                >
                                                                    Revisar
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                            <h3 class="text-xs font-bold text-gray-900 tracking-tight">Alertas de plazo normativo</h3>
                        </div>

                        <!-- Lista de Alertas -->
                        <div class="space-y-3 divide-y divide-gray-100">
                            @foreach ($alertas as $alerta)
                                <div class="pt-2.5 first:pt-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold text-[#8B1D2D] leading-tight">
                                            {{ $alerta['codigo'] }}
                                        </p>
                                        @if(isset($alerta['norma']))
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                {{ $alerta['norma'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] @if($alerta['dias'] <= 5) text-red-600 font-semibold @else text-gray-500 @endif mt-0.5">
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

    <script>
        function toggleCertificadosUPS() {
            const contenedor = document.getElementById('contenedorCertificadosUPS');
            const icon = document.getElementById('iconToggleCertificadosUPS');
            const texto = document.getElementById('textoToggleCertificadosUPS');
            const btn = document.getElementById('btnToggleCertificadosUPS');

            if (!contenedor) return;

            const isHidden = contenedor.classList.contains('hidden');
            if (isHidden) {
                contenedor.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
                if (texto) texto.innerText = 'Ocultar certificados';
                if (btn) btn.setAttribute('aria-expanded', 'true');
            } else {
                contenedor.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
                if (texto) texto.innerText = 'Mostrar certificados';
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        }
    </script>
</body>
</html>
