<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Avance &bull; Portal del Estudiante | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL (SIDEBAR DE NAVEGACIÓN) -->
    @include('layouts.sidebar', ['active' => 'dashboard'])

    <!-- ================================================================= -->
    <!-- ÁREA DE CONTENIDO PRINCIPAL                                       -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA PRINCIPAL (TOP BAR DEL ESTUDIANTE) -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-rose-50 border border-rose-200/80 text-[#8B1D2D] rounded-full text-[10px] font-extrabold tracking-wide uppercase">
                            Portal del Estudiante
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Horas Sociales UES</span>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Mi Avance de Proyección Social
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Monitorea las fases de tu servicio social, horas acumuladas, dictámenes y entregables en PDF.
                    </p>
                </div>

                <!-- Perfil del Estudiante Autenticado -->
                <div class="flex items-center gap-3 bg-gray-50/80 border border-gray-200/80 rounded-2xl px-4 py-2 self-start md:self-auto">
                    <div class="w-10 h-10 rounded-xl bg-[#8B1D2D]/10 text-[#8B1D2D] font-bold text-sm flex items-center justify-center border border-[#8B1D2D]/20 shrink-0">
                        {{ strtoupper(substr($usuario->nombre_completo ?? 'ES', 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800 leading-tight">
                            {{ $usuario->nombre_completo }}
                        </p>
                        <p class="text-[11px] text-gray-500 font-medium">
                            Carnet: <span class="font-semibold text-gray-700">{{ $usuario->nombre_usuario }}</span> &bull; {{ $usuario->carrera }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL DEL DASHBOARD -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- ============================================================= -->
            <!-- 1. HERO BANNER: ESTADO GENERAL DEL PROYECTO                   -->
            <!-- ============================================================= -->
            @if ($proyecto)
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/80 shadow-2xs relative overflow-hidden">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div class="space-y-2 max-w-2xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-gray-100 rounded-md text-[11px] font-bold font-mono tracking-wide text-gray-700 border border-gray-200/80">
                                    PROYECTO #{{ $proyecto->codigo_proyecto }}
                                </span>
                                @php
                                    $estadoBadge = [
                                        'solicitado' => 'bg-amber-50 text-amber-800 border-amber-200/80',
                                        'en_inscripcion' => 'bg-blue-50 text-blue-800 border-blue-200/80',
                                        'en_proceso' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80',
                                        'en_finalizacion' => 'bg-purple-50 text-purple-800 border-purple-200/80',
                                        'finalizado' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                    ];
                                    $estadoTexto = [
                                        'solicitado' => 'Solicitud Registrada',
                                        'en_inscripcion' => 'En Proceso de Inscripción',
                                        'en_proceso' => 'En Ejecución de Horas',
                                        'en_finalizacion' => 'En Fase de Finalización',
                                        'finalizado' => 'Servicio Social Finalizado',
                                    ];
                                @endphp
                                <span class="px-3 py-0.5 rounded-md text-[11px] font-extrabold border {{ $estadoBadge[$proyecto->estado] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ $estadoTexto[$proyecto->estado] ?? ucfirst($proyecto->estado) }}
                                </span>
                            </div>

                            <h2 class="text-lg sm:text-2xl font-bold tracking-tight text-gray-900 leading-snug">
                                {{ $proyecto->nombre_proyecto }}
                            </h2>

                            <p class="text-xs text-gray-500 flex flex-wrap items-center gap-x-4 gap-y-1">
                                <span>Área: <strong class="text-gray-800 font-semibold">{{ $proyecto->area }}</strong></span>
                                <span class="text-gray-300">&bull;</span>
                                <span>Tutor: <strong class="text-gray-800 font-semibold">{{ $proyecto->tutor?->nombre_completo ?? 'Pendiente de asignación' }}</strong></span>
                            </p>
                        </div>

                        <!-- Botones de Acción Inmediata -->
                        <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-auto shrink-0">
                            <a
                                href="{{ route('estudiante.proyecto') }}"
                                class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-800 font-bold text-xs rounded-xl transition-all shadow-2xs border border-gray-200/90 flex items-center gap-2 cursor-pointer"
                            >
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Ver Mi Proyecto</span>
                            </a>

                            <a
                                href="{{ route('estudiante.subirView') }}"
                                class="px-4 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white font-bold text-xs rounded-xl transition-all shadow-xs flex items-center gap-2 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Subir PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 text-amber-900 shadow-2xs flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-700 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold">Sin proyecto de proyección social asignado</h3>
                        <p class="text-xs text-amber-700 mt-0.5">
                            Actualmente no figuras asignado a ningún proyecto activo. Comunícate con la Unidad de Proyección Social (UPS) para gestionar tu inscripción.
                        </p>
                    </div>
                </div>
            @endif

            <!-- ============================================================= -->
            <!-- 2. STEPPER VISUAL: FASES DEL PROCESO DE PROYECCIÓN SOCIAL      -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 p-6 shadow-2xs">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                            Ruta del Proceso de Servicio Social
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Sigue el avance reglamentario de tus entregables desde la solicitud inicial hasta la certificación.
                        </p>
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold font-mono">
                        Fase {{ $faseActual }} de 5
                    </span>
                </div>

                <!-- Grid de las 5 fases -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach ($fases as $num => $fase)
                        @php
                            $isCompletada = $fase['completada'] ?? ($num < $faseActual);
                            $isActual = $fase['actual'] ?? ($num === $faseActual);
                            $badgeTipo = $fase['badge_tipo'] ?? ($isCompletada ? 'completada' : ($isActual ? 'actual' : 'inactiva'));
                        @endphp
                        <div class="p-4 rounded-2xl border transition-all {{ $isCompletada ? 'bg-emerald-50/40 border-emerald-200' : ($badgeTipo === 'observado' ? 'bg-rose-50/40 border-rose-300 ring-1 ring-rose-300/30 shadow-xs' : ($badgeTipo === 'pendiente' ? 'bg-amber-50/40 border-amber-300 ring-1 ring-amber-300/30 shadow-xs' : ($isActual ? 'bg-red-50/40 border-[#8B1D2D]/40 ring-1 ring-[#8B1D2D]/20 shadow-xs' : 'bg-gray-50/50 border-gray-200/60 opacity-60'))) }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $isCompletada ? 'bg-emerald-600 text-white' : ($badgeTipo === 'observado' ? 'bg-rose-600 text-white' : ($badgeTipo === 'pendiente' ? 'bg-amber-600 text-white' : ($isActual ? 'bg-[#8B1D2D] text-white' : 'bg-gray-200 text-gray-600'))) }}">
                                    @if ($isCompletada)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        {{ $num }}
                                    @endif
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $isCompletada ? 'text-emerald-700' : ($badgeTipo === 'observado' ? 'text-rose-700 font-bold' : ($badgeTipo === 'pendiente' ? 'text-amber-800 font-bold' : ($isActual ? 'text-[#8B1D2D]' : 'text-gray-400'))) }}">
                                    {{ $fase['codigo_formato'] }}
                                </span>
                            </div>

                            <p class="text-xs font-bold text-gray-900 leading-snug">
                                {{ $fase['nombre'] }}
                            </p>
                            <p class="text-[11px] text-gray-500 mt-1 line-clamp-2">
                                {{ $fase['descripcion'] }}
                            </p>

                            <div class="mt-3 pt-2 border-t border-gray-100 flex items-center gap-1 text-[11px] font-semibold">
                                @if ($badgeTipo === 'completada')
                                    <span class="text-emerald-600 flex items-center gap-1 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Completada
                                    </span>
                                @elseif ($badgeTipo === 'observado')
                                    <span class="text-rose-600 flex items-center gap-1 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                                        Observado
                                    </span>
                                @elseif ($badgeTipo === 'pendiente')
                                    <span class="text-amber-700 flex items-center gap-1 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        En Revisión
                                    </span>
                                @elseif ($isActual)
                                    <span class="text-[#8B1D2D] flex items-center gap-1 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#8B1D2D] animate-ping"></span>
                                        Fase Actual
                                    </span>
                                @else
                                    <span class="text-gray-400">Pendiente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- 3. CUERPO DE 2 COLUMNAS: ENTREGABLES Y ASESORÍA               -->
            <!-- ============================================================= -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

                <!-- COLUMNA IZQUIERDA: ESTADO DE ENTREGABLES (8 / 12) -->
                <div class="xl:col-span-8 space-y-6">

                    <!-- TARJETA: ESTADO DE LOS 4 ENTREGABLES OFICIALES -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                                    Entregables Reglamentarios del Proyecto
                                </h3>
                                <p class="text-xs text-gray-500">
                                    Verifica la entrega de tus documentos obligatorios en formato PDF.
                                </p>
                            </div>
                            <a
                                href="{{ route('estudiante.subirView') }}"
                                class="text-xs text-[#8B1D2D] hover:underline font-bold flex items-center gap-1 cursor-pointer"
                            >
                                <span>Subir entregable</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        @php
                            $entregablesChecklist = [
                                [
                                    'tipo' => 'solicitud',
                                    'titulo' => 'Solicitud e Inscripción Inicial (F1/F2)',
                                    'descripcion' => 'Acredita la inscripción formal de tu servicio social.',
                                    'obligatorio' => true,
                                ],
                                [
                                    'tipo' => 'anteproyecto',
                                    'titulo' => 'Documento de Anteproyecto (F3)',
                                    'descripcion' => 'Plan de trabajo, objetivos y justificación avalada por el tutor.',
                                    'obligatorio' => true,
                                ],
                                [
                                    'tipo' => 'mitad_proyecto',
                                    'titulo' => 'Informe de Avance del 50 % (F4/F5)',
                                    'descripcion' => 'Reporte intermedio con evidencias tras completar 250 horas.',
                                    'obligatorio' => true,
                                ],
                                [
                                    'tipo' => 'memoria',
                                    'titulo' => 'Memoria Final y Finiquito (F6/F7/F8)',
                                    'descripcion' => 'Compendio final con las 500 horas completadas para dictamen.',
                                    'obligatorio' => true,
                                ],
                            ];
                        @endphp

                        <div class="space-y-3">
                            @foreach ($entregablesChecklist as $item)
                                @php
                                    $docEntregado = $documentos->firstWhere('tipo', $item['tipo']);
                                    $isObs = $docEntregado && $docEntregado->isObservado();
                                    $isPend = $docEntregado && $docEntregado->isPendiente();
                                    $isAprob = $docEntregado && $docEntregado->isAprobado();
                                @endphp
                                <div class="p-4 rounded-2xl border transition-all {{ $isObs ? 'bg-rose-50/40 border-rose-200' : ($isPend ? 'bg-amber-50/30 border-amber-200/80' : ($isAprob ? 'bg-emerald-50/20 border-emerald-100' : 'bg-gray-50/40 border-gray-100')) }}">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <!-- Ícono según estado -->
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5 {{ $isObs ? 'bg-rose-100 text-rose-600 border border-rose-200' : ($isPend ? 'bg-amber-100 text-amber-700 border border-amber-200' : ($isAprob ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-gray-100 text-gray-400')) }}">
                                                @if ($isObs)
                                                    <!-- Alerta de rechazo/observación (NO check) -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                @elseif ($isPend)
                                                    <!-- Espera / Pendiente de revisión -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @elseif ($isAprob)
                                                    <!-- Check de aprobado -->
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <!-- Sin entregar -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="space-y-1">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <p class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                                        {{ $item['titulo'] }}
                                                    </p>

                                                    <!-- Badge de Estado Específico -->
                                                    @if ($isObs)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                            Rechazado con Observaciones
                                                        </span>
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-white text-gray-700 border border-gray-200">
                                                            v{{ $docEntregado->version ?? 1 }}
                                                        </span>
                                                    @elseif ($isPend)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                            No revisado (En espera de dictamen)
                                                        </span>
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-white text-gray-700 border border-gray-200">
                                                            v{{ $docEntregado->version ?? 1 }}
                                                        </span>
                                                    @elseif ($isAprob)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                            Aprobado por Tutor
                                                        </span>
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-white text-gray-700 border border-gray-200">
                                                            v{{ $docEntregado->version ?? 1 }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-gray-200/80 text-gray-600">
                                                            Pendiente de Entrega
                                                        </span>
                                                    @endif
                                                </div>

                                                <p class="text-[11px] text-gray-500 leading-normal">
                                                    {{ $item['descripcion'] }}
                                                </p>

                                                @if ($docEntregado)
                                                    <p class="text-[10px] text-gray-600 font-mono mt-0.5 flex flex-wrap items-center gap-2">
                                                        <span class="font-semibold text-gray-800">Archivo: {{ $docEntregado->nombre_documento }}</span>
                                                        @if ($docEntregado->fecha_entrega)
                                                            <span class="text-gray-400">&bull; Entregado: {{ $docEntregado->fecha_entrega->format('d/m/Y H:i') }}</span>
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Acciones -->
                                        <div class="self-end sm:self-center shrink-0 flex items-center gap-2">
                                            @if ($isObs)
                                                <a
                                                    href="{{ route('estudiante.subirView') }}"
                                                    class="px-3 py-1.5 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-lg text-xs font-bold transition-colors inline-flex items-center gap-1.5 shadow-2xs cursor-pointer"
                                                    title="Corregir y subir una nueva versión del documento"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                    </svg>
                                                    <span>Corregir y Reenviar</span>
                                                </a>
                                                <a
                                                    href="{{ $docEntregado->url_documento }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="px-2.5 py-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-lg text-xs font-semibold transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                    title="Visualizar versión PDF observada"
                                                >
                                                    <span>Ver PDF</span>
                                                </a>
                                            @elseif ($docEntregado)
                                                <a
                                                    href="{{ $docEntregado->url_documento }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="px-3 py-1.5 {{ $isAprob ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-amber-50 hover:bg-amber-100 text-amber-900 border-amber-200' }} border rounded-lg text-xs font-semibold transition-colors inline-flex items-center gap-1.5 cursor-pointer"
                                                    title="Visualizar documento PDF entregado"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    <span>Ver PDF</span>
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('estudiante.subirView') }}"
                                                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-[#8B1D2D] border border-rose-200 rounded-lg text-xs font-semibold transition-colors inline-flex items-center gap-1.5 cursor-pointer"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                    </svg>
                                                    <span>Subir Entrega</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Retroalimentación / Motivo si fue Rechazado -->
                                    @if ($isObs)
                                        <div class="mt-3 p-3 rounded-xl bg-white/95 border border-rose-200/90 text-xs shadow-2xs">
                                            <div class="flex items-center gap-1.5 font-bold text-rose-800 text-[11px] mb-1">
                                                <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>Motivo del rechazo / Observación del tutor:</span>
                                            </div>
                                            <p class="text-rose-950 text-xs leading-relaxed font-medium bg-rose-50/60 p-2.5 rounded-lg border border-rose-100">
                                                {{ $docEntregado->motivo_feedback ?? 'El documento presenta observaciones normativas y requiere ser corregido.' }}
                                            </p>
                                            <div class="mt-2 flex items-center justify-between text-[11px] text-rose-700">
                                                <span>Revisa los detalles completos en <a href="{{ route('estudiante.observaciones') }}" class="font-bold underline hover:text-rose-900">Dictámenes y Revisiones</a>.</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TARJETA: PRÓXIMAS FECHAS Y PLAZOS DEL ESTUDIANTE -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight mb-1">
                            Cronograma y Plazos del Estudiante
                        </h3>
                        <p class="text-xs text-gray-500 mb-4">
                            Fechas de corte para presentación de informes intermedios y cierre de expediente.
                        </p>

                        <div class="space-y-3">
                            @foreach ($plazosEstudiante as $plazo)
                                <div class="p-3.5 rounded-2xl bg-gray-50/70 border border-gray-100 flex items-center justify-between gap-3 text-xs">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-red-100 text-[#8B1D2D] flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $plazo['actividad'] }}</p>
                                            <p class="text-[11px] text-gray-500">Fecha límite: {{ $plazo['fecha_limite'] }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        @if ($plazo['estado'] === 'Completado')
                                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-[10px] font-bold">
                                                Completado
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 bg-amber-100 text-amber-900 rounded-lg text-[10px] font-bold">
                                                Vence en {{ $plazo['dias_restantes'] }} días
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: ASESORÍA Y REGLAMENTO (4 / 12) -->
                <div class="xl:col-span-4 space-y-6">

                    <!-- TARJETA: TU DOCENTE TUTOR ASIGNADO -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Docente Tutor Asignado
                        </h4>

                        @if ($proyecto && $proyecto->tutor)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-[#8B1D2D]/10 text-[#8B1D2D] font-bold text-base flex items-center justify-center border border-[#8B1D2D]/20 shrink-0">
                                    {{ strtoupper(substr($proyecto->tutor->nombre_completo, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-bold text-gray-900 truncate">
                                        {{ $proyecto->tutor->nombre_completo }}
                                    </p>
                                    <p class="text-[11px] text-gray-500">
                                        Usuario: {{ $proyecto->tutor->nombre_usuario }}
                                    </p>
                                    <p class="text-[11px] text-gray-400">
                                        {{ $proyecto->tutor->departamento }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-600 space-y-1">
                                <p><span class="font-bold text-gray-700">Rol:</span> Asesor de Horas y Revisor de Entregables</p>
                                <p><span class="font-bold text-gray-700">Estado:</span> Activo</p>
                            </div>

                            <div class="mt-4">
                                <a
                                    href="{{ route('estudiante.observaciones') }}"
                                    class="w-full py-2 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-xl text-xs font-semibold border border-gray-200 transition-colors flex items-center justify-center gap-1.5 cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>Ver Observaciones del Tutor</span>
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-gray-500">
                                Tu tutor aún no ha sido designado por la coordinación.
                            </p>
                        @endif
                    </div>

                    <!-- TARJETA: RECORDATORIO DE REGLAMENTO -->
                    <div class="bg-gradient-to-br from-rose-50 to-red-50/40 rounded-3xl border border-rose-200/80 p-5 text-xs text-rose-950">
                        <div class="flex items-center gap-2 mb-2 font-bold text-[#8B1D2D]">
                            <svg class="w-4 h-4 text-[#8B1D2D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Regla de Entrega Digital</span>
                        </div>
                        <p class="leading-relaxed text-gray-600">
                            Todo documento debe ser subido en formato <strong class="text-gray-900">PDF consolidado</strong> con las firmas y sellos correspondientes de la institución contraparte.
                        </p>
                    </div>

                </div>

            </div>

        </main>
    </div>

</body>
</html>
