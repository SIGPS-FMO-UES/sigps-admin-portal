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
                            <div class="p-6 hover:bg-gray-50/50 transition-colors">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900 leading-snug">
                                                {{ $doc->nombre_documento }}
                                            </h4>
                                            <p class="text-[11px] text-gray-400 font-mono mt-0.5">
                                                Tipo: <strong class="uppercase text-gray-600">{{ $doc->tipo }}</strong> &bull; Registrado en expediente
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 self-start md:self-auto shrink-0">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Documento Recibido y Válido</span>
                                        </span>

                                        <a
                                            href="{{ $doc->url_documento }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-colors flex items-center gap-1 cursor-pointer"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            <span>Ver PDF</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Cuadro de Retroalimentación del Tutor -->
                                <div class="bg-gray-50/80 rounded-2xl p-4 border border-gray-100 text-xs text-gray-600">
                                    <div class="flex items-center gap-2 mb-1 text-[11px] font-bold text-gray-500">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span>Dictamen del Tutor:</span>
                                    </div>
                                    <p class="leading-relaxed text-gray-700">
                                        El documento ha sido cargado en el expediente oficial y cuenta con URL de acceso institucional activa. Cumple con la estructura base del reglamento. Recuerda mantener al día las firmas de la institución contraparte.
                                    </p>
                                </div>
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
