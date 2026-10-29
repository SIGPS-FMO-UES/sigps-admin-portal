<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisión Documental | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'certificados'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: VISTA DE REVISIÓN DOCUMENTAL                 -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        @php
            $proyectoVinculado = $proyectoVinculado ?? $certificado->proyectos->first();
            $documentosProyecto = $documentosProyecto ?? ($proyectoVinculado ? $proyectoVinculado->documentos : collect());
            $docsValidosProyecto = $docsValidosProyecto ?? $documentosProyecto->filter(fn ($d) => $d->isAprobado());

            if (empty($fases) && $proyectoVinculado) {
                $trazabilidad = $proyectoVinculado->calcularFasesProceso();
                $fases = $trazabilidad['fases'];
                $faseActual = $trazabilidad['faseActual'];
            }

            /** @var \App\Models\Usuario $user */
            $user = auth()->user();
            $esTutor = $user?->hasRole('Docente Tutor') || $user?->hasRole('Administrador');
            $esCoord = $user?->hasRole('Coordinador de Carrera') || $user?->hasRole('Administrador');
            $esUPS = $user?->hasRole('Coordinador UPS') || $user?->hasRole('Auxiliar UPS') || $user?->hasRole('Administrador');
        @endphp

        <!-- CABECERA: TÍTULO, SUBTÍTULO Y BOTÓN REGRESAR -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-[#8B1D2D]/10 text-[#8B1D2D] border border-[#8B1D2D]/20 rounded-md text-[10px] font-extrabold tracking-wide uppercase">
                            Revisión Documental
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Expediente Oficial</span>
                        <span class="sr-only">Certificados/Detalles</span>
                        <span class="sr-only">Detalles del documento / certificado</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ $certificado->nombre_documento }}
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        ID #DOC-{{ str_pad((string) $certificado->id_documento, 3, '0', STR_PAD_LEFT) }}
                        @if ($proyectoVinculado)
                            &bull; Proyecto: <a href="{{ route('proyectos.show', $proyectoVinculado) }}" class="text-[#8B1D2D] hover:underline font-semibold">#{{ $proyectoVinculado->codigo_proyecto }} {{ $proyectoVinculado->nombre_proyecto }}</a>
                        @endif
                    </p>
                </div>

                <!-- Botón Regresar al proyecto o listado -->
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <span class="sr-only">Modificar</span>
                    <div id="actionDropdownMenu" class="hidden"></div>
                    <div id="confirmDeleteModal" class="hidden"></div>

                    @if ($proyectoVinculado)
                        <a
                            href="{{ route('proyectos.show', $proyectoVinculado) }}"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition-all cursor-pointer inline-flex items-center gap-1.5"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Regresar al Proyecto</span>
                        </a>
                    @else
                        <a
                            href="{{ route('certificados.index') }}"
                            class="px-4 py-2 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition-all cursor-pointer inline-flex items-center gap-1.5"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Regresar</span>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- MENSAJES DE ESTADO FLASH (ÉXITO, ADVERTENCIA O ERROR) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Acción completada</p>
                        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Aviso de Revisión</p>
                        <p class="text-amber-700 font-medium">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Error en la operación</p>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-xs sm:text-sm shadow-2xs">
                    <p class="font-bold mb-1">Por favor verifica los campos:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ============================================================= -->
            <!-- 1. BARRA SUPERIOR DE ESTADO Y ACCIONES RÁPIDAS DEL DOCUMENTO  -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-red-100/80 text-red-700 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $certificado->estado_revision_badge }}">
                                {{ $certificado->estado_revision_texto }}
                            </span>
                            @if ($certificado->folio)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    Folio: {{ $certificado->folio }}
                                </span>
                            @endif
                            <span class="text-xs text-gray-400">Tipo: <strong class="text-gray-700">{{ ucfirst($certificado->tipo) }}</strong></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            URL: <code class="font-mono text-gray-700 text-[11px]">{{ $certificado->url_documento }}</code>
                        </p>
                    </div>
                </div>

                <!-- Botones Ver Documento y Descargar -->
                <div class="flex items-center gap-2.5 shrink-0 self-start lg:self-auto">
                    <!-- Ver Documento -->
                    <a
                        href="{{ $certificado->url_documento }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-xl text-xs font-semibold shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer"
                        title="Ver documento en pestaña nueva"
                    >
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>Ver Documento</span>
                    </a>

                    <!-- Descargar Documento -->
                    <a
                        href="{{ $certificado->url_documento }}"
                        download
                        target="_blank"
                        class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-xl text-xs font-semibold shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer"
                        title="Descargar documento PDF"
                    >
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Descargar</span>
                    </a>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- 2. SECCIÓN: OBSERVACIONES SI LAS TIENE                        -->
            <!-- ============================================================= -->
            @if ($certificado->observaciones || $certificado->motivo_rechazo)
                <div class="p-5 rounded-3xl bg-amber-50/80 border border-amber-200/90 shadow-2xs space-y-2">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xs sm:text-sm font-bold text-amber-950 uppercase tracking-wide">
                                Observaciones / Dictamen Técnico Emitido
                            </h3>
                        </div>

                        @if ($certificado->fecha_dictamen)
                            <span class="text-[11px] text-amber-800 font-semibold bg-amber-100/70 px-2.5 py-0.5 rounded-full">
                                {{ $certificado->fecha_dictamen->format('d/m/Y H:i') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-amber-900 font-medium leading-relaxed pl-9">
                        {{ $certificado->observaciones ?: $certificado->motivo_rechazo }}
                    </p>
                </div>
            @endif

            <!-- ============================================================= -->
            <!-- 3. DESPLEGABLE: TRAZABILIDAD Y RUTA DEL PROCESO DE SERVICIO   -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <!-- Botón de apertura/cierre desplegable -->
                <button
                    type="button"
                    id="btnToggleRutaProceso"
                    onclick="toggleRutaProceso()"
                    class="w-full flex items-center justify-between p-5 sm:p-6 bg-gradient-to-r from-gray-50/90 via-white to-gray-50/60 hover:bg-gray-100/70 transition-all cursor-pointer text-left group"
                    aria-expanded="false"
                >
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-2xl bg-[#8B1D2D]/10 text-[#8B1D2D] flex items-center justify-center shrink-0 border border-[#8B1D2D]/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                                    Trazabilidad: Ruta del Proceso de Servicio Social
                                </h3>
                                @if (!empty($fases))
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold font-mono bg-gray-100 text-gray-700">
                                        Fase {{ $faseActual ?? 1 }} de 5
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Despliega para consultar la ruta del proceso, documentos válidos e historial del expediente.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900" id="textoToggleRuta">
                            Mostrar ruta y expediente
                        </span>
                        <svg id="iconToggleRuta" class="w-4 h-4 text-gray-400 group-hover:text-gray-700 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <!-- CONTENEDOR DESPLEGABLE: RUTA DEL PROCESO + DOCUMENTOS VÁLIDOS + HISTORIAL -->
                <div id="contenedorRutaProceso" class="hidden border-t border-gray-100 p-5 sm:p-7 space-y-6 bg-white transition-all">

                    <!-- A. STEPPER VISUAL: RUTA DEL PROCESO DE SERVICIO SOCIAL -->
                    @if (!empty($fases))
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                        <span>Ruta del Proceso de Servicio Social</span>
                                        @if ($proyectoVinculado)
                                            <span class="text-xs text-gray-400 font-normal">
                                                (Proyecto #{{ $proyectoVinculado->codigo_proyecto }} &bull; {{ $proyectoVinculado->nombre_proyecto }})
                                            </span>
                                        @endif
                                    </h4>
                                    <p class="text-[11px] text-gray-400">
                                        Sigue el avance reglamentario de los entregables desde la solicitud inicial hasta la certificación.
                                    </p>
                                </div>
                            </div>

                            <!-- Grid de las 5 fases (Visual idéntico a la vista de estudiantes) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                                @foreach ($fases as $num => $fase)
                                    @php
                                        $isCompletada = $fase['completada'] ?? ($num < $faseActual);
                                        $isActual = $fase['actual'] ?? ($num === $faseActual);
                                        $badgeTipo = $fase['badge_tipo'] ?? ($isCompletada ? 'completada' : ($isActual ? 'actual' : 'inactiva'));
                                    @endphp
                                    <div class="p-3.5 rounded-2xl border transition-all {{ $isCompletada ? 'bg-emerald-50/40 border-emerald-200' : ($badgeTipo === 'observado' ? 'bg-rose-50/40 border-rose-300 ring-1 ring-rose-300/30 shadow-xs' : ($badgeTipo === 'pendiente' ? 'bg-amber-50/40 border-amber-300 ring-1 ring-amber-300/30 shadow-xs' : ($isActual ? 'bg-red-50/40 border-[#8B1D2D]/40 ring-1 ring-[#8B1D2D]/20 shadow-xs' : 'bg-gray-50/50 border-gray-200/60 opacity-60'))) }}">
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
                    @endif

                    <!-- B. DOCUMENTOS VÁLIDOS DEL EXPEDIENTE (ABAJO DE LA RUTA) -->
                    <div class="pt-4 border-t border-gray-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#8B1D2D]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                                <span>Documentos Válidos del Expediente</span>
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $docsValidosProyecto->count() }} {{ $docsValidosProyecto->count() === 1 ? 'válido' : 'válidos' }}
                                </span>
                            </h4>
                            <span class="text-[11px] text-gray-400 hidden sm:inline">
                                Aprobados formalmente en el sistema
                            </span>
                        </div>

                        <!-- Tarjetas Visuales -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @forelse ($docsValidosProyecto as $docValido)
                                <div
                                    class="group p-3.5 bg-gray-50/80 hover:bg-white border {{ $docValido->id_documento === $certificado->id_documento ? 'border-[#8B1D2D] ring-2 ring-[#8B1D2D]/20 bg-red-50/20' : 'border-gray-200/90 hover:border-[#8B1D2D]/40' }} rounded-2xl shadow-2xs hover:shadow-xs transition-all flex flex-col justify-between cursor-pointer"
                                    ondblclick="window.location.href='{{ route('certificados.show', $docValido) }}'"
                                    title="Doble clic para abrir este documento en revisión documental"
                                >
                                    <div class="flex items-start justify-between gap-2 mb-2.5">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-xl bg-red-100/80 text-red-700 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-gray-900 truncate leading-tight group-hover:text-[#8B1D2D] transition-colors" title="{{ $docValido->nombre_documento }}">
                                                    {{ $docValido->nombre_documento }}
                                                </p>
                                                <span class="text-[10px] text-gray-400 font-medium">
                                                    {{ ucfirst($docValido->tipo) }} &bull; ID #{{ $docValido->id_documento }}
                                                </span>
                                            </div>
                                        </div>

                                        @if ($docValido->id_documento === $certificado->id_documento)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#8B1D2D] text-white shrink-0">
                                                Actual
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                                Válido
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Botones de Acción: Ver y Descargar -->
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 gap-1.5">
                                        <div class="flex items-center gap-1.5">
                                            <a
                                                href="{{ $docValido->url_documento }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                onclick="event.stopPropagation();"
                                                class="px-2.5 py-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-[11px] font-semibold transition-all inline-flex items-center gap-1 shadow-2xs"
                                                title="Ver documento en nueva pestaña"
                                            >
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Ver</span>
                                            </a>

                                            <a
                                                href="{{ $docValido->url_documento }}"
                                                download
                                                target="_blank"
                                                onclick="event.stopPropagation();"
                                                class="px-2.5 py-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-[11px] font-semibold transition-all inline-flex items-center gap-1 shadow-2xs"
                                                title="Descargar documento PDF"
                                            >
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                <span>Descargar</span>
                                            </a>
                                        </div>

                                        @if ($docValido->id_documento !== $certificado->id_documento)
                                            <a
                                                href="{{ route('certificados.show', $docValido) }}"
                                                onclick="event.stopPropagation();"
                                                class="px-2.5 py-1 bg-red-50 hover:bg-[#8B1D2D] text-[#8B1D2D] hover:text-white rounded-lg text-[11px] font-bold transition-all inline-flex items-center gap-1"
                                                title="Revisar este documento"
                                            >
                                                <span>Revisar</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900 text-xs flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="font-medium">
                                        No hay documentos marcados como válidos/aprobados aún en este proyecto.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- C. HISTORIAL DE DOCUMENTOS SUBIDOS (ABAJO DE LOS VÁLIDOS) -->
                    @if ($documentosProyecto->isNotEmpty())
                        <div class="pt-4 border-t border-gray-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span>Historial de Documentos Subidos ({{ $documentosProyecto->count() }})</span>
                                </h4>
                                <span class="text-[11px] text-gray-400">
                                    Aprobados, en revisión y con observaciones
                                </span>
                            </div>

                            <div class="rounded-2xl border border-gray-200 overflow-hidden bg-white shadow-2xs">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead>
                                            <tr class="border-b border-gray-100 bg-gray-50/70 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                                                <th class="py-2.5 px-3.5">Documento</th>
                                                <th class="py-2.5 px-3">Tipo</th>
                                                <th class="py-2.5 px-3">Estado</th>
                                                <th class="py-2.5 px-3">Observaciones</th>
                                                <th class="py-2.5 px-3 text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700">
                                            @foreach ($documentosProyecto as $docHist)
                                                <tr
                                                    class="hover:bg-gray-50/80 transition-colors cursor-pointer {{ $docHist->id_documento === $certificado->id_documento ? 'bg-red-50/20 font-semibold' : '' }}"
                                                    ondblclick="window.location.href='{{ route('certificados.show', $docHist) }}'"
                                                    title="Doble clic para abrir este documento en revisión documental"
                                                >
                                                    <td class="py-2.5 px-3.5 text-gray-900 whitespace-nowrap font-bold">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-red-600 font-mono text-[10px] font-bold px-1 py-0.2 rounded bg-red-50 border border-red-100">PDF</span>
                                                            <span>{{ $docHist->nombre_documento }}</span>
                                                            @if ($docHist->id_documento === $certificado->id_documento)
                                                                <span class="px-1.5 py-0.2 bg-[#8B1D2D] text-white rounded text-[9px] font-bold uppercase">Actual</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-gray-600 whitespace-nowrap">
                                                        {{ ucfirst($docHist->tipo) }}
                                                    </td>
                                                    <td class="py-2.5 px-3 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $docHist->estado_revision_badge }}">
                                                            {{ $docHist->estado_revision_texto }}
                                                        </span>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-gray-500 max-w-xs truncate">
                                                        {{ $docHist->observaciones ?: ($docHist->motivo_rechazo ?: 'Sin observaciones') }}
                                                    </td>
                                                    <td class="py-2.5 px-3 text-right whitespace-nowrap">
                                                        <div class="inline-flex items-center gap-1.5" onclick="event.stopPropagation();">
                                                            <a
                                                                href="{{ $docHist->url_documento }}"
                                                                target="_blank"
                                                                class="p-1 text-gray-500 hover:text-gray-900 rounded hover:bg-gray-100 transition-colors"
                                                                title="Ver documento"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </a>
                                                            <a
                                                                href="{{ $docHist->url_documento }}"
                                                                download
                                                                class="p-1 text-gray-500 hover:text-gray-900 rounded hover:bg-gray-100 transition-colors"
                                                                title="Descargar documento"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                            </a>
                                                            @if ($docHist->id_documento !== $certificado->id_documento)
                                                                <a
                                                                    href="{{ route('certificados.show', $docHist) }}"
                                                                    class="px-2 py-0.5 bg-gray-100 hover:bg-[#8B1D2D] text-gray-700 hover:text-white rounded text-[10px] font-bold transition-all"
                                                                    title="Revisar este documento"
                                                                >
                                                                    Revisar
                                                                </a>
                                                            @endif
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

            <!-- ============================================================= -->
            <!-- 4. VISOR DOCUMENTAL DEL PDF                                   -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-4 bg-gray-50/80 border-b border-gray-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs font-bold text-gray-800">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <span>Visor Integrado: {{ $certificado->nombre_documento }}.pdf</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ $certificado->url_documento }}" target="_blank" rel="noopener noreferrer" class="px-2.5 py-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs inline-flex items-center gap-1 transition-all">
                            <span>Pantalla Completa</span>
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="w-full h-[540px] bg-gray-100 flex items-center justify-center">
                    <iframe
                        src="{{ $certificado->url_documento }}#toolbar=1"
                        class="w-full h-full border-0"
                        title="Visor PDF de {{ $certificado->nombre_documento }}"
                    >
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-sm font-medium">Visualización directa no soportada en este navegador.</p>
                            <a href="{{ $certificado->url_documento }}" target="_blank" class="mt-3 inline-block px-4 py-2 bg-[#8B1D2D] text-white rounded-xl text-xs font-bold">
                                Abrir Documento PDF
                            </a>
                        </div>
                    </iframe>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- 5. PANELES DE CAMBIO DE ESTADO SEGÚN EL ROL AUTORIZADO         -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-5 sm:p-7 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                            Acciones de Revisión y Dictamen por Rol
                        </h2>
                        <p class="text-[11px] text-gray-400 mt-0.5">
                            Acciones disponibles según las facultades de tu rol.
                        </p>
                    </div>
                </div>

                <!-- Botones de Acción Rápida para Tutor, Coordinador y UPS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <!-- ACCIONES DOCENTE TUTOR -->
                    @if ($esTutor)
                        <div class="p-3.5 rounded-2xl bg-gray-50/70 border border-gray-200/90 flex flex-col justify-between gap-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    Docente Tutor
                                </span>

                                <!-- Estado conciso de cómo quedó el documento -->
                                @if ($certificado->estado_revision === 'aprobado_tutor')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aprobado &bull; Enviado a Carrera
                                    </span>
                                @elseif ($certificado->estado_revision === 'observado_tutor')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Observado por Tutor
                                    </span>
                                @elseif ($certificado->estado_revision === 'aval_carrera')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        Con Aval de Carrera &bull; En UPS
                                    </span>
                                @elseif ($certificado->estado_revision === 'observado_carrera')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Devuelto por Carrera
                                    </span>
                                @elseif ($certificado->estado_revision === 'auditado_ups')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        Sellos Auditados en UPS
                                    </span>
                                @elseif ($certificado->estado_revision === 'certificado_emitido')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Certificado Emitido
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Pendiente de Dictamen
                                    </span>
                                @endif
                            </div>

                            @if ($certificado->estado_revision === 'observado_tutor' && ($certificado->observaciones || $certificado->motivo_rechazo))
                                <div class="px-2.5 py-1.5 bg-rose-50/70 rounded-xl border border-rose-200/80 text-[11px] text-rose-800 line-clamp-2">
                                    <strong>Obs:</strong> {{ $certificado->observaciones ?: $certificado->motivo_rechazo }}
                                </div>
                            @endif

                            <div class="space-y-1.5 pt-0.5">
                                @if ($certificado->estado_revision === 'aprobado_tutor')
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="accion" value="retractar">
                                            <button
                                                type="submit"
                                                onclick="return confirm('¿Retractar dictamen y volver a pendiente?');"
                                                class="w-full py-2 px-3 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Retractar a Pendiente</span>
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            onclick="toggleObservarForm('tutorObservarBox')"
                                            class="flex-1 py-2 px-3 bg-white hover:bg-amber-50 text-amber-800 border border-amber-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                        >
                                            <span>Cambiar a Observado</span>
                                        </button>
                                    </div>

                                @elseif ($certificado->estado_revision === 'observado_tutor')
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="accion" value="aprobar">
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Aprobar Dictamen</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}">
                                            @csrf
                                            <input type="hidden" name="accion" value="retractar">
                                            <button
                                                type="submit"
                                                class="py-2 px-2.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-xl text-xs font-semibold transition-all shadow-2xs cursor-pointer"
                                                title="Retractar y volver a pendiente"
                                            >
                                                Retractar
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            onclick="toggleObservarForm('tutorObservarBox')"
                                            class="py-2 px-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-300 rounded-xl text-xs font-semibold transition-all shadow-2xs cursor-pointer"
                                            title="Editar Observación"
                                        >
                                            Editar
                                        </button>
                                    </div>

                                @elseif (in_array($certificado->estado_revision, ['aval_carrera', 'auditado_ups', 'certificado_emitido']))
                                    <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}">
                                        @csrf
                                        <input type="hidden" name="accion" value="retractar">
                                        <button
                                            type="submit"
                                            onclick="return confirm('¿Retractar dictamen de tutor? El documento ya avanzó en el flujo.');"
                                            class="w-full py-2 px-3 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                        >
                                            <span>Retractar Dictamen</span>
                                        </button>
                                    </form>

                                @else
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="accion" value="aprobar">
                                            <input type="hidden" name="observaciones" value="Dictamen técnico favorable emitido desde la vista de revisión documental.">
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Aprobar Dictamen</span>
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            onclick="toggleObservarForm('tutorObservarBox')"
                                            class="flex-1 py-2 px-3 bg-white hover:bg-amber-50 text-amber-800 border border-amber-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                        >
                                            <span>Observar / Devolver</span>
                                        </button>
                                    </div>
                                @endif

                                <div id="tutorObservarBox" class="hidden mt-2 p-3 bg-white rounded-xl border border-amber-200 shadow-2xs">
                                    <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}" class="space-y-2">
                                        @csrf
                                        <input type="hidden" name="accion" value="observar">
                                        <textarea name="observaciones" rows="2" required minlength="5" placeholder="Motivo u observaciones..." class="w-full p-2 bg-gray-50 border border-gray-200 rounded-lg text-xs">{{ $certificado->observaciones ?: $certificado->motivo_rechazo }}</textarea>
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" onclick="toggleObservarForm('tutorObservarBox')" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold cursor-pointer">Cancelar</button>
                                            <button type="submit" class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold cursor-pointer">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ACCIONES COORDINADOR DE CARRERA -->
                    @if ($esCoord)
                        <div class="p-3.5 rounded-2xl bg-gray-50/70 border border-gray-200/90 flex flex-col justify-between gap-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                    Coordinador de Carrera
                                </span>

                                @if ($certificado->estado_revision === 'aval_carrera')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        Aval Emitido &bull; En UPS
                                    </span>
                                @elseif ($certificado->estado_revision === 'observado_carrera')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Devuelto por Carrera
                                    </span>
                                @elseif (in_array($certificado->estado_revision, ['auditado_ups', 'certificado_emitido']))
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        Procesado en UPS
                                    </span>
                                @elseif ($certificado->estado_revision === 'aprobado_tutor')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Listo para Aval
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        En Espera de Tutor
                                    </span>
                                @endif
                            </div>

                            @if ($certificado->estado_revision === 'observado_carrera' && ($certificado->observaciones || $certificado->motivo_rechazo))
                                <div class="px-2.5 py-1.5 bg-rose-50/70 rounded-xl border border-rose-200/80 text-[11px] text-rose-800 line-clamp-2">
                                    <strong>Obs:</strong> {{ $certificado->observaciones ?: $certificado->motivo_rechazo }}
                                </div>
                            @endif

                            <div class="space-y-1.5 pt-0.5">
                                @if ($certificado->estado_revision === 'aval_carrera')
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('coordinador.aval', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="accion" value="retractar">
                                            <button
                                                type="submit"
                                                onclick="return confirm('¿Retractar aval y devolver al estado anterior?');"
                                                class="w-full py-2 px-3 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Retractar Aval</span>
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            onclick="toggleObservarForm('coordObservarBox')"
                                            class="flex-1 py-2 px-3 bg-white hover:bg-red-50 text-red-800 border border-red-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                        >
                                            <span>Devolver</span>
                                        </button>
                                    </div>

                                @else
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('coordinador.aval', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="accion" value="aval">
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Emitir Aval Académico</span>
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            onclick="toggleObservarForm('coordObservarBox')"
                                            class="flex-1 py-2 px-3 bg-white hover:bg-red-50 text-red-800 border border-red-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                        >
                                            <span>Devolver</span>
                                        </button>
                                    </div>
                                @endif

                                <div id="coordObservarBox" class="hidden mt-2 p-3 bg-white rounded-xl border border-red-200 shadow-2xs">
                                    <form method="POST" action="{{ route('coordinador.aval', $certificado) }}" class="space-y-2">
                                        @csrf
                                        <input type="hidden" name="accion" value="observar">
                                        <textarea name="observaciones" rows="2" required minlength="5" placeholder="Motivo de devolución..." class="w-full p-2 bg-gray-50 border border-gray-200 rounded-lg text-xs">{{ $certificado->observaciones ?: $certificado->motivo_rechazo }}</textarea>
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" onclick="toggleObservarForm('coordObservarBox')" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold cursor-pointer">Cancelar</button>
                                            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold cursor-pointer">Devolver</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ACCIONES UNIDAD DE PROYECCIÓN SOCIAL (UPS) -->
                    @if ($esUPS)
                        <div class="p-3.5 rounded-2xl bg-gray-50/70 border border-gray-200/90 flex flex-col justify-between gap-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-[#8B1D2D]"></span>
                                    Personal UPS
                                </span>

                                @if ($certificado->estado_revision === 'certificado_emitido')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        Certificado Emitido &bull; {{ $certificado->folio ?? 'Finalizado' }}
                                    </span>
                                @elseif ($certificado->estado_revision === 'auditado_ups')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-[#8B1D2D] border border-rose-200">
                                        Sellos Auditados
                                    </span>
                                @elseif ($certificado->estado_revision === 'aval_carrera')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Listo para Auditoría
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        En Espera de Aval
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1.5 pt-0.5">
                                @if ($certificado->estado_revision === 'auditado_ups')
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('ups.emitirCertificado', $certificado) }}" class="flex-1">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-purple-700 hover:bg-purple-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                            >
                                                <span>Emitir Certificado con Folio</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('ups.auditar', $certificado) }}">
                                            @csrf
                                            <input type="hidden" name="accion" value="retractar">
                                            <button
                                                type="submit"
                                                onclick="return confirm('¿Retractar auditoría de sellos?');"
                                                class="py-2 px-2.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-xl text-xs font-semibold transition-all shadow-2xs cursor-pointer"
                                                title="Retractar auditoría"
                                            >
                                                Retractar
                                            </button>
                                        </form>
                                    </div>

                                @elseif ($certificado->estado_revision !== 'certificado_emitido')
                                    <div class="flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('ups.auditar', $certificado) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="observaciones" value="Sellos y firmas en tinta azul verificadas correctamente desde la vista de revisión documental.">
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-rose-700 hover:bg-rose-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                                title="Auditar sellos y firmas"
                                            >
                                                <span>Auditar Sellos</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('ups.emitirCertificado', $certificado) }}" class="flex-1">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="w-full py-2 px-3 bg-purple-700 hover:bg-purple-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1"
                                                title="Emitir certificado oficial"
                                            >
                                                <span>Emitir Certificado</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========================================================= -->
                <!-- 6. FORMULARIO COMPLETO: EDICIÓN Y CAMBIO DIRECTO DE ESTADO-->
                <!-- ========================================================= -->
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">
                        Modificación Directa de Expediente y Estado de Revisión
                    </h3>

                    <form method="POST" action="{{ route('certificados.update', $certificado) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Fila 1: Titulo / Nombre -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_nombre" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Titulo / Nombre
                            </label>
                            <input
                                type="text"
                                name="nombre_documento"
                                id="campo_nombre"
                                required
                                value="{{ old('nombre_documento', $certificado->nombre_documento) }}"
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all font-medium"
                            />
                        </div>

                        <!-- Fila 2: Tipo de Documento -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_tipo" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Tipo de Documento
                            </label>
                            <select
                                name="tipo"
                                id="campo_tipo"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer font-medium"
                            >
                                @foreach ($tipos as $val => $label)
                                    <option value="{{ $val }}" @selected(old('tipo', $certificado->tipo) === $val)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fila 3: Proyecto Asociado -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_proyecto" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Proyecto Asociado
                            </label>
                            @php
                                $proyectoActualId = $certificado->proyectos->first()?->id_proyecto;
                            @endphp
                            <select
                                name="id_proyecto"
                                id="campo_proyecto"
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer font-medium"
                            >
                                <option value="">(Sin proyecto asociado)</option>
                                @foreach ($proyectos as $pry)
                                    <option value="{{ $pry->id_proyecto }}" @selected(old('id_proyecto', $proyectoActualId) == $pry->id_proyecto)>
                                        [{{ $pry->codigo_proyecto }}] {{ $pry->nombre_proyecto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fila 4: URL / Enlace del archivo -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_url" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                URL / Enlace PDF
                            </label>
                            <input
                                type="text"
                                name="url_documento"
                                id="campo_url"
                                value="{{ old('url_documento', $certificado->url_documento) }}"
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all font-mono"
                            />
                        </div>

                        <!-- Fila 5: Cambio de Estado de Revisión -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_estado_revision" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Estado de Revisión
                            </label>
                            <div class="w-full">
                                <select
                                    name="estado_revision"
                                    id="campo_estado_revision"
                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer font-bold"
                                >
                                    <option value="pendiente_tutor" @selected(old('estado_revision', $certificado->estado_revision) === 'pendiente_tutor')>
                                        Pendiente de Revisión por Tutor
                                    </option>
                                    <option value="aprobado_tutor" @selected(old('estado_revision', $certificado->estado_revision) === 'aprobado_tutor')>
                                        Aprobado por Tutor (Pasa a Carrera)
                                    </option>
                                    <option value="observado_tutor" @selected(old('estado_revision', $certificado->estado_revision) === 'observado_tutor')>
                                        Observado por Tutor (Requiere Corrección)
                                    </option>
                                    <option value="aval_carrera" @selected(old('estado_revision', $certificado->estado_revision) === 'aval_carrera')>
                                        Aval Académico Emitido (Enviado a UPS)
                                    </option>
                                    <option value="observado_carrera" @selected(old('estado_revision', $certificado->estado_revision) === 'observado_carrera')>
                                        Devuelto por Coordinación de Carrera
                                    </option>
                                    <option value="auditado_ups" @selected(old('estado_revision', $certificado->estado_revision) === 'auditado_ups')>
                                        Sellos y Firmas Validados por UPS
                                    </option>
                                    <option value="certificado_emitido" @selected(old('estado_revision', $certificado->estado_revision) === 'certificado_emitido')>
                                        Certificado Oficial Emitido
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Fila 6: Observaciones -->
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-4">
                            <label for="campo_observaciones" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0 pt-2">
                                Observaciones / Feedback
                            </label>
                            <textarea
                                name="observaciones"
                                id="campo_observaciones"
                                rows="3"
                                placeholder="Escribe observaciones, acuerdos de revisión técnica o justificación del cambio de estado..."
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all font-medium"
                            >{{ old('observaciones', $certificado->observaciones ?: $certificado->motivo_rechazo) }}</textarea>
                        </div>

                        <!-- BOTÓN MODIFICAR Y GUARDAR ESTADO -->
                        <div class="flex items-center justify-end pt-4">
                            <button
                                type="submit"
                                class="px-7 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all cursor-pointer flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Guardar Cambios y Actualizar Estado</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- 7. SUB-SECCIÓN: PROYECTOS VINCULADOS                          -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6 sm:p-8 space-y-4">
                <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                    Proyectos Vinculados al Documento
                </h3>

                <div class="overflow-x-auto rounded-2xl border border-gray-200">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-800 font-bold bg-gray-50/70">
                                <th class="py-3 px-4 font-bold">Código</th>
                                <th class="py-3 px-4 font-bold">Nombre del Proyecto</th>
                                <th class="py-3 px-4 font-bold">Estado</th>
                                <th class="py-3 px-4 font-bold">Docente Tutor</th>
                                <th class="py-3 px-4 font-bold text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600 bg-white">
                            @forelse ($certificado->proyectos as $pry)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-gray-900 whitespace-nowrap">
                                        #{{ $pry->codigo_proyecto }}
                                    </td>
                                    <td class="py-3.5 px-4 font-medium text-gray-800">
                                        {{ $pry->nombre_proyecto }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ ucfirst($pry->estado) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600">
                                        {{ $pry->tutor?->nombre_completo ?? 'Sin tutor' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <a
                                            href="{{ route('proyectos.show', $pry) }}"
                                            class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all inline-flex items-center gap-1"
                                        >
                                            <span>Ver Proyecto</span>
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                        No hay proyectos vinculados a este documento actualmente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPT DE INTERACCIÓN -->
    <script>
        function toggleRutaProceso() {
            const cont = document.getElementById('contenedorRutaProceso');
            const texto = document.getElementById('textoToggleRuta');
            const icon = document.getElementById('iconToggleRuta');
            const btn = document.getElementById('btnToggleRutaProceso');
            if (cont) {
                const isHidden = cont.classList.toggle('hidden');
                if (btn) btn.setAttribute('aria-expanded', !isHidden);
                if (texto) texto.textContent = isHidden ? 'Mostrar ruta y expediente' : 'Ocultar ruta y expediente';
                if (icon) icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        function toggleObservarForm(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.toggle('hidden');
            }
        }
    </script>

</body>
</html>
