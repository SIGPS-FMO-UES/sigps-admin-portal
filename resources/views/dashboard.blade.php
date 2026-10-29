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
                        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#8B1D2D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900 tracking-tight">
                                        Expedientes para Auditoría de Sellos y Emisión de Certificado (UPS)
                                    </h2>
                                    <p class="text-[11px] text-gray-400">Control normativo RF-UPS-07 (sellos y firma azul) y HU-33 (folio oficial)</p>
                                </div>
                            </div>
                            <a href="{{ route('certificados.index') }}" class="text-xs font-bold text-[#8B1D2D] hover:underline flex items-center gap-1 transition-all">
                                <span>Ver todos</span>
                                <span>&rarr;</span>
                            </a>
                        </div>

                        <!-- Contenedor responsivo con scroll horizontal para móviles -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-gray-100 text-gray-400 font-semibold bg-gray-50/40">
                                        <th class="py-3 px-4 w-10 text-center">#</th>
                                        <th class="py-3 px-4">Carnet / Estudiante</th>
                                        <th class="py-3 px-4">Proyecto & Tutor</th>
                                        <th class="py-3 px-4">Documento / Tipo</th>
                                        <th class="py-3 px-4">Estado</th>
                                        <th class="py-3 px-4 text-center">Acciones Operativas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    @forelse ($documentosAuditoria as $doc)
                                        @php
                                            $proyecto = $doc->proyectos->first();
                                            $alumno = $proyecto?->alumnos->first();
                                        @endphp
                                        <tr class="hover:bg-gray-50/70 transition-colors">
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
                                                <div class="flex flex-col">
                                                    <span class="font-semibold text-gray-800">{{ $doc->nombre_documento }}</span>
                                                    <span class="text-[10px] text-gray-400 font-mono uppercase">{{ $doc->tipo }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                <div class="flex flex-col gap-1 items-start">
                                                    {!! $doc->estado_revision_badge !!}
                                                    @if($doc->folio)
                                                        <span class="text-[10px] font-mono font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                                                            {{ $doc->folio }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <!-- Ver PDF -->
                                                    @if($doc->url_archivo)
                                                        <a
                                                            href="{{ $doc->url_archivo }}"
                                                            target="_blank"
                                                            class="p-1.5 text-gray-400 hover:text-[#8B1D2D] hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                                            title="Visualizar documento PDF escaneado"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                    @endif

                                                    <!-- Botón Auditar Sellos (Tinta Azul) para Aval Carrera o Pendiente Tutor -->
                                                    @if(in_array($doc->estado_revision, ['aval_carrera', 'pendiente_tutor', 'aprobado_tutor']))
                                                        <form action="{{ route('ups.auditar', $doc->id_documento) }}" method="POST" class="inline" onsubmit="return confirm('¿Confirmar auditoría visual de sellos y firmas en tinta azul conforme a RF-UPS-07?');">
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="px-2.5 py-1 bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white border border-amber-200 rounded-md font-semibold text-[11px] transition-all cursor-pointer flex items-center gap-1 shadow-2xs"
                                                                title="Auditar Sellos y Firmas en Tinta Azul (RF-UPS-07)"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span>Auditar Sellos</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Botón Emitir Certificado si ya fue auditado -->
                                                    @if($doc->estado_revision === 'auditado_ups')
                                                        <form action="{{ route('ups.emitirCertificado', $doc->id_documento) }}" method="POST" class="inline" onsubmit="return confirm('¿Emitir certificación oficial institucional con Folio Único para este estudiante?');">
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md font-semibold text-[11px] transition-all cursor-pointer flex items-center gap-1 shadow-2xs"
                                                                title="Emitir Certificado Oficial con Folio (HU-33)"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span>Emitir Certificado</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Indicador de Finalizado / Certificado Emitido -->
                                                    @if($doc->estado_revision === 'certificado_emitido')
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-md font-bold text-[10px]">
                                                            <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span>Emitido</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-8 text-center text-gray-400">
                                                No hay documentos pendientes de auditoría o certificación en este momento.
                                            </td>
                                        </tr>
                                    @endforelse
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

</body>
</html>
