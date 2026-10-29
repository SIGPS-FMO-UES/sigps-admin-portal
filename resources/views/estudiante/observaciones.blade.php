<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisiones y Observaciones | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL -->
    @include('layouts.sidebar', ['active' => 'observaciones'])

    <!-- ÁREA PRINCIPAL -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-1 font-medium">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-600 transition-colors">Inicio</a>
                        <span>/</span>
                        <span class="text-gray-700 font-semibold">Observaciones</span>
                    </nav>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Revisiones y Observaciones de Entregables
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Consulta los dictámenes, observaciones pedagógicas y el historial de revisiones emitidas por tu tutor y coordinación.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('estudiante.subirView') }}"
                        class="px-4 py-2 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Subir Corrección (PDF)</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

            @if ($proyecto)
                <!-- BANNER DEL TUTOR RESPONSABLE -->
                <div class="bg-white rounded-3xl border border-gray-200/80 p-6 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-[#8B1D2D]/10 text-[#8B1D2D] font-bold text-base flex items-center justify-center border border-[#8B1D2D]/20 shrink-0">
                            {{ strtoupper(substr($proyecto->tutor?->nombre_completo ?? 'TU', 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Revisor Principal Asignado</p>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900">
                                {{ $proyecto->tutor?->nombre_completo ?? 'Pendiente de designación' }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                Docente Tutor &bull; {{ $proyecto->tutor?->departamento ?? 'Facultad Multidisciplinaria Oriental' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl px-4 py-2.5 border border-gray-100 text-xs text-gray-600 self-start sm:self-auto">
                        <span class="font-bold text-gray-800">Proyecto:</span> {{ $proyecto->nombre_proyecto }}
                    </div>
                </div>

                <!-- HISTORIAL DE DICTÁMENES Y OBSERVACIONES -->
                <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 tracking-tight">
                                Dictámenes y Revisiones de Documentos
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Estado de aceptación de cada versión entregada.
                            </p>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse ($documentos as $doc)
                            @php
                                $isObs = $doc->isObservado();
                                $isAprob = $doc->isAprobado();
                                $isPend = $doc->isPendiente();
                            @endphp
                            <div class="p-6 hover:bg-gray-50/50 transition-colors {{ $isObs ? 'bg-rose-50/20' : '' }}">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 border {{ $isObs ? 'bg-rose-100 text-rose-600 border-rose-200' : ($isPend ? 'bg-amber-100 text-amber-700 border-amber-200' : ($isAprob ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-600 border-red-100')) }}">
                                            @if ($isObs)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            @elseif ($isPend)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif ($isAprob)
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h4 class="text-sm font-bold text-gray-900 leading-snug">
                                                    {{ $doc->nombre_documento }}
                                                </h4>
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-white text-gray-700 border border-gray-200">
                                                    Versión v{{ $doc->version ?? 1 }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-gray-400 font-mono mt-0.5 flex flex-wrap items-center gap-2">
                                                <span>Tipo: <strong class="uppercase text-gray-600">{{ $doc->tipo }}</strong></span>
                                                @if ($doc->fecha_entrega)
                                                    <span>&bull; Entregado: {{ $doc->fecha_entrega->format('d/m/Y H:i') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 self-start md:self-auto shrink-0 flex-wrap">
                                        <!-- Badge de Estado Específico -->
                                        @if ($isObs)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                <span>Rechazado con Observaciones</span>
                                            </span>
                                            <a
                                                href="{{ route('estudiante.subirView') }}"
                                                class="px-3 py-1 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                                                title="Subir corrección en formato PDF"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span>Subsanar Entrega</span>
                                            </a>
                                        @elseif ($isPend)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span>No Revisado (En Espera)</span>
                                            </span>
                                        @elseif ($isAprob)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                <span>Revisado y Aprobado</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                <span>{{ ucfirst(str_replace('_', ' ', $doc->estado_revision)) }}</span>
                                            </span>
                                        @endif

                                        <a
                                            href="{{ $doc->url_documento }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1 cursor-pointer border border-gray-200"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            <span>Ver PDF</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Cuadro de Retroalimentación y Dictamen del Revisor -->
                                @if ($isObs)
                                    <div class="bg-rose-50/70 rounded-2xl p-4 border border-rose-200 text-xs text-rose-950">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2 font-bold text-rose-800 text-xs">
                                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>Motivo del Rechazo / Observaciones del Tutor:</span>
                                            </div>
                                            @if ($doc->fecha_dictamen)
                                                <span class="text-[11px] text-rose-700 font-medium">Dictamen: {{ $doc->fecha_dictamen->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                        <div class="bg-white/95 p-3.5 rounded-xl border border-rose-200 text-xs leading-relaxed font-medium text-rose-950 shadow-2xs">
                                            {{ $doc->motivo_feedback ?? $doc->observaciones }}
                                        </div>
                                        <p class="text-[11px] text-rose-700 mt-2 font-medium">
                                            Este documento requiere corrección. Haz clic en "Subsanar Entrega" para cargar una nueva versión en PDF que atienda las observaciones anteriores.
                                        </p>
                                    </div>
                                @elseif ($isAprob)
                                    <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-200 text-xs text-emerald-950">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2 font-bold text-emerald-800 text-xs">
                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Dictamen Favorable del Docente Tutor:</span>
                                            </div>
                                            @if ($doc->fecha_dictamen)
                                                <span class="text-[11px] text-emerald-700 font-medium">Aprobado el: {{ $doc->fecha_dictamen->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                        <div class="bg-white/95 p-3.5 rounded-xl border border-emerald-200 text-xs leading-relaxed font-medium text-emerald-950 shadow-2xs">
                                            {{ $doc->observaciones ?: 'El documento cumple satisfactoriamente con la normativa vigente y los requerimientos pedagógicos del servicio social.' }}
                                        </div>
                                    </div>
                                @elseif ($isPend)
                                    <div class="bg-amber-50/60 rounded-2xl p-4 border border-amber-200 text-xs text-amber-950">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2 font-bold text-amber-800 text-xs">
                                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Estado de la Revisión: No Revisado</span>
                                            </div>
                                            @if ($doc->fecha_entrega)
                                                <span class="text-[11px] text-amber-700 font-medium">Recibido: {{ $doc->fecha_entrega->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                        <p class="leading-relaxed text-amber-900 text-xs">
                                            El archivo fue recibido correctamente y se encuentra a la espera del dictamen técnico del docente tutor asignado. En cuanto sea evaluado, aquí se publicarán las observaciones o aprobación correspondiente.
                                        </p>
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-xs text-gray-600">
                                        <p class="leading-relaxed text-gray-700">
                                            {{ $doc->observaciones ?: 'Documento registrado en el expediente institucional.' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-400">
                                <p class="font-bold text-gray-700 text-sm">Aún no hay entregables para mostrar observaciones</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Cuando subas tus primeros entregables en PDF a tu proyecto, podrás ver aquí los comentarios y dictámenes del docente tutor.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center text-amber-900 shadow-2xs">
                    <p class="font-bold text-sm">No tienes un proyecto de proyección social asignado</p>
                    <p class="text-xs text-amber-700 mt-1">
                        Comunícate con la Unidad de Proyección Social (UPS) para dar de alta tu expediente.
                    </p>
                </div>
            @endif

        </main>
    </div>

</body>
</html>
