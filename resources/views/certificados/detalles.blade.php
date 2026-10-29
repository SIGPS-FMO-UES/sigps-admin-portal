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
            $proyectoVinculado = $certificado->proyectos->first();
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
            <!-- 3. VISOR DOCUMENTAL DEL PDF                                   -->
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
            <!-- 4. PANELES DE CAMBIO DE ESTADO SEGÚN EL ROL AUTORIZADO         -->
            <!-- ============================================================= -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Acciones de Revisión y Dictamen por Rol
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Aplica dictámenes técnicos, avales o validaciones de sellos conforme a las facultades de tu rol.
                    </p>
                </div>

                <!-- Botones de Acción Rápida para Tutor, Coordinador y UPS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- ACCIONES DOCENTE TUTOR -->
                    @if ($esTutor)
                        <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200/80 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">
                                    Docente Tutor
                                </span>
                                <h3 class="text-xs font-bold text-gray-900 mt-1">Dictamen Técnico Primer Nivel</h3>
                                <p class="text-[11px] text-gray-500 mt-0.5">Valida el cumplimiento normativo del documento o devuélvelo con observaciones.</p>
                            </div>

                            <div class="space-y-2 pt-2">
                                <!-- Form Aprobar Tutor -->
                                <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}">
                                    @csrf
                                    <input type="hidden" name="accion" value="aprobar">
                                    <input type="hidden" name="observaciones" value="Dictamen técnico favorable emitido desde la vista de revisión documental.">
                                    <button
                                        type="submit"
                                        class="w-full py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                        title="Aprobar técnicamente"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Aprobar Dictamen Tutor</span>
                                    </button>
                                </form>

                                <!-- Form Observar Tutor -->
                                <button
                                    type="button"
                                    onclick="toggleObservarForm('tutorObservarBox')"
                                    class="w-full py-2 px-3 bg-white hover:bg-amber-50 text-amber-800 border border-amber-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Observar / Devolver</span>
                                </button>

                                <div id="tutorObservarBox" class="hidden mt-2 p-3 bg-white rounded-xl border border-amber-200">
                                    <form method="POST" action="{{ route('tutor.dictamen', $certificado) }}" class="space-y-2">
                                        @csrf
                                        <input type="hidden" name="accion" value="observar">
                                        <label class="block text-[10px] font-bold text-gray-700 uppercase">Motivo de Observación:</label>
                                        <textarea name="observaciones" rows="2" required minlength="10" placeholder="Indica detalladamente los ajustes requeridos..." class="w-full p-2 bg-gray-50 border border-gray-200 rounded-lg text-xs"></textarea>
                                        <button type="submit" class="w-full py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold cursor-pointer">Enviar Observación</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ACCIONES COORDINADOR DE CARRERA -->
                    @if ($esCoord)
                        <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-200/80 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase tracking-wider">
                                    Coordinador de Carrera
                                </span>
                                <h3 class="text-xs font-bold text-gray-900 mt-1">Aval Académico Segundo Nivel</h3>
                                <p class="text-[11px] text-gray-500 mt-0.5">Emite el aval académico formal para remitir el expediente a la UPS.</p>
                            </div>

                            <div class="space-y-2 pt-2">
                                <!-- Form Aval Carrera -->
                                <form method="POST" action="{{ route('coordinador.aval', $certificado) }}">
                                    @csrf
                                    <input type="hidden" name="accion" value="aval">
                                    <input type="hidden" name="observaciones" value="Aval Académico institucional emitido desde la vista de revisión documental.">
                                    <button
                                        type="submit"
                                        class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                        title="Emitir aval académico"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Emitir Aval Académico</span>
                                    </button>
                                </form>

                                <!-- Form Devolver Coordinador -->
                                <button
                                    type="button"
                                    onclick="toggleObservarForm('coordObservarBox')"
                                    class="w-full py-2 px-3 bg-white hover:bg-red-50 text-red-800 border border-red-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Devolver con Observaciones</span>
                                </button>

                                <div id="coordObservarBox" class="hidden mt-2 p-3 bg-white rounded-xl border border-red-200">
                                    <form method="POST" action="{{ route('coordinador.aval', $certificado) }}" class="space-y-2">
                                        @csrf
                                        <input type="hidden" name="accion" value="observar">
                                        <label class="block text-[10px] font-bold text-gray-700 uppercase">Motivo de Devolución:</label>
                                        <textarea name="observaciones" rows="2" required minlength="10" placeholder="Indica los motivos institucionales de devolución..." class="w-full p-2 bg-gray-50 border border-gray-200 rounded-lg text-xs"></textarea>
                                        <button type="submit" class="w-full py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold cursor-pointer">Devolver Documento</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ACCIONES UNIDAD DE PROYECCIÓN SOCIAL (UPS) -->
                    @if ($esUPS)
                        <div class="p-4 rounded-2xl bg-rose-50/60 border border-rose-200/80 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-[#8B1D2D] uppercase tracking-wider">
                                    Personal UPS
                                </span>
                                <h3 class="text-xs font-bold text-gray-900 mt-1">Auditoría Final y Certificación</h3>
                                <p class="text-[11px] text-gray-500 mt-0.5">Audita sellos/firmas en tinta azul o emite la certificación oficial de horas.</p>
                            </div>

                            <div class="space-y-2 pt-2">
                                <!-- Form Auditar Sellos -->
                                <form method="POST" action="{{ route('ups.auditar', $certificado) }}">
                                    @csrf
                                    <input type="hidden" name="observaciones" value="Sellos y firmas en tinta azul verificadas correctamente desde la vista de revisión documental.">
                                    <button
                                        type="submit"
                                        class="w-full py-2 px-3 bg-rose-700 hover:bg-rose-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                        title="Auditar sellos y firmas"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span>Auditar Sellos y Firmas</span>
                                    </button>
                                </form>

                                <!-- Form Emitir Certificado Oficial -->
                                <form method="POST" action="{{ route('ups.emitirCertificado', $certificado) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full py-2 px-3 bg-purple-700 hover:bg-purple-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center justify-center gap-1.5"
                                        title="Emitir certificado oficial"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Emitir Certificado con Folio</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========================================================= -->
                <!-- 5. FORMULARIO COMPLETO: EDICIÓN Y CAMBIO DIRECTO DE ESTADO-->
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
            <!-- 6. SUB-SECCIÓN: PROYECTOS VINCULADOS                          -->
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
        function toggleObservarForm(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.toggle('hidden');
            }
        }
    </script>

</body>
</html>
