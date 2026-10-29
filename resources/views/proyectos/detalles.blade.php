<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'proyectos'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: DETALLES DEL PROYECTO                        -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO, SUBTÍTULO Y BOTÓN REGRESAR -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Proyectos
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Proyectos/Detalles
                    </p>
                </div>

                <!-- Botón Regresar en Guinda UES -->
                <div>
                    <a
                        href="{{ route('proyectos.index') }}"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all cursor-pointer inline-flex items-center gap-1.5"
                    >
                        <span>Regresar</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- MENSAJES DE ESTADO FLASH (ÉXITO O ERROR) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Actualización exitosa</p>
                        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
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

            <!-- CONTENEDOR PRINCIPAL BLANCO REDONDEADO (SEGÚN LA IMAGEN DE DISEÑO) -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6 sm:p-10 space-y-6">

                <!-- ENCABEZADO DEL DETALLE: ID DEL PROYECTO -->
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Detalles del proyecto
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Id #{{ $proyecto->codigo_proyecto }}-{{ str_pad((string) $proyecto->id_proyecto, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <!-- FORMULARIO DE DETALLES Y EDICIÓN -->
                <form method="POST" action="{{ route('proyectos.update', $proyecto) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Fila 1: Titulo -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_titulo" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Titulo
                        </label>
                        <input
                            type="text"
                            name="nombre_proyecto"
                            id="campo_titulo"
                            required
                            value="{{ old('nombre_proyecto', $proyecto->nombre_proyecto) }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                        />
                    </div>

                    <!-- Fila 2: Area -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_area" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Area
                        </label>
                        <input
                            type="text"
                            name="area"
                            id="campo_area"
                            value="{{ old('area', $proyecto->area ?? 'Tecnología y Proyección Social') }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                        />
                    </div>

                    <!-- Fila 3: Fecha de Inicio & Fecha de finalización -->
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Fecha de Inicio -->
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_fecha_inicio" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Fecha de Inicio:
                            </label>
                            <input
                                type="text"
                                name="fecha_inicio"
                                id="campo_fecha_inicio"
                                value="{{ old('fecha_inicio', $proyecto->fecha_inicio ?? '2026-02-15') }}"
                                placeholder="Type here..."
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                            />
                        </div>

                        <!-- Fecha de finalización -->
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label for="campo_fecha_fin" class="w-full sm:w-48 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Fecha de finalización
                            </label>
                            <input
                                type="text"
                                name="fecha_fin"
                                id="campo_fecha_fin"
                                value="{{ old('fecha_fin', $proyecto->fecha_fin ?? '2026-07-30') }}"
                                placeholder="Type here..."
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                            />
                        </div>
                    </div>

                    <!-- Fila 4: SubCoordinador -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_subcoordinador" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            SubCoordinador
                        </label>
                        <input
                            type="text"
                            name="subcoordinador"
                            id="campo_subcoordinador"
                            value="{{ old('subcoordinador', $proyecto->subcoordinador ?? 'Ing. Roberto Carlos Flores') }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                        />
                    </div>

                    <!-- Fila 5: Tutor -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_tutor" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Tutor
                        </label>
                        <div class="w-full relative">
                            <select
                                name="tutor_id"
                                id="campo_tutor"
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                            >
                                <option value="">Type here... (Seleccione docente tutor)</option>
                                @foreach ($tutores as $tutor)
                                    <option value="{{ $tutor->id_usuario }}" @selected(old('tutor_id', $proyecto->tutor_id) == $tutor->id_usuario)>
                                        {{ $tutor->nombre_completo }} ({{ $tutor->nombre_usuario }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Fila 6: Estado del Proyecto -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_estado" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Estado del Proyecto
                        </label>
                        <div class="w-full">
                            <select
                                name="estado"
                                id="campo_estado"
                                class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer font-semibold"
                            >
                                <option value="solicitado" @selected(old('estado', $proyecto->estado) === 'solicitado')>
                                    Solicitud Registrada (Fase 1: Inicial)
                                </option>
                                <option value="en_inscripcion" @selected(old('estado', $proyecto->estado) === 'en_inscripcion')>
                                    En Inscripción (Fase 1: Registro e Inscripción)
                                </option>
                                <option value="en_proceso" @selected(old('estado', $proyecto->estado) === 'en_proceso')>
                                    En Ejecución / Activo (Fase 2 y 3: Anteproyecto y Avance 50%)
                                </option>
                                <option value="en_finalizacion" @selected(old('estado', $proyecto->estado) === 'en_finalizacion')>
                                    En Finalización / Cierre (Fase 4: Memoria Técnica Final)
                                </option>
                                <option value="finalizado" @selected(old('estado', $proyecto->estado) === 'finalizado')>
                                    Finalizado (Fase 5: Certificación Oficial Emitida)
                                </option>
                            </select>
                            <p class="text-[11px] text-gray-400 mt-1">
                                El estado avanza automáticamente con la entrega y aprobación de documentos reglamentarios, pero puedes modificarlo manualmente.
                            </p>
                        </div>
                    </div>

                    <!-- Fila 7: Expediente Documental del Proyecto -->
                    @php
                        $docsValidos = $proyecto->documentos->filter(fn ($d) => $d->isAprobado());
                    @endphp
                    <div class="pt-5 border-t border-gray-100 space-y-3.5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <label class="text-xs sm:text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#8B1D2D]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Documentos Válidos del Expediente</span>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $docsValidos->count() }} {{ $docsValidos->count() === 1 ? 'válido' : 'válidos' }}
                                    </span>
                                </label>
                                <p class="text-[11px] text-gray-400 mt-0.5">
                                    Documentos reglamentarios vigentes y aprobados en el sistema. Doble clic para abrir revisión documental.
                                </p>
                            </div>
                        </div>

                        <!-- Tarjetas Visuales de Documentos Válidos -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @forelse ($docsValidos as $doc)
                                <div
                                    class="group p-3.5 bg-gray-50/80 hover:bg-white border border-gray-200/90 hover:border-[#8B1D2D]/40 rounded-2xl shadow-2xs hover:shadow-xs transition-all flex flex-col justify-between cursor-pointer"
                                    ondblclick="window.location.href='{{ route('certificados.show', $doc) }}'"
                                    title="Doble clic para abrir la vista de revisión documental"
                                >
                                    <div class="flex items-start justify-between gap-2 mb-2.5">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-xl bg-red-100/80 text-red-700 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-gray-900 truncate leading-tight group-hover:text-[#8B1D2D] transition-colors" title="{{ $doc->nombre_documento }}">
                                                    {{ $doc->nombre_documento }}
                                                </p>
                                                <span class="text-[10px] text-gray-400 font-medium">
                                                    {{ ucfirst($doc->tipo) }} &bull; ID #{{ $doc->id_documento }}
                                                </span>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                            Válido
                                        </span>
                                    </div>

                                    <!-- Botones de Acción: Ver y Descargar (Sin opción de borrar, sin docx) -->
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 gap-1.5">
                                        <div class="flex items-center gap-1.5">
                                            <!-- Botoncito Ver -->
                                            <a
                                                href="{{ $doc->url_documento }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                onclick="event.stopPropagation();"
                                                class="px-2.5 py-1 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-[11px] font-semibold transition-all inline-flex items-center gap-1 shadow-2xs"
                                                title="Ver documento en el navegador"
                                            >
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Ver</span>
                                            </a>

                                            <!-- Botoncito Descargar -->
                                            <a
                                                href="{{ $doc->url_documento }}"
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

                                        <!-- Botón Revisión Documental -->
                                        <a
                                            href="{{ route('certificados.show', $doc) }}"
                                            onclick="event.stopPropagation();"
                                            class="px-2.5 py-1 bg-red-50 hover:bg-[#8B1D2D] text-[#8B1D2D] hover:text-white rounded-lg text-[11px] font-bold transition-all inline-flex items-center gap-1"
                                            title="Ir a revisión documental detallada"
                                        >
                                            <span>Revisar</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900 text-xs flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <p class="font-medium">
                                            No hay documentos marcados como aprobados o válidos aún en este proyecto.
                                        </p>
                                    </div>
                                    <span class="text-[11px] text-amber-700 font-semibold hidden sm:inline">Despliega el historial abajo para consultar entregas</span>
                                </div>
                            @endforelse
                        </div>

                        <!-- Opción Desplegable para ver todos los documentos y estados -->
                        @if ($proyecto->documentos->isNotEmpty())
                            <div class="pt-1">
                                <button
                                    type="button"
                                    onclick="toggleExpedienteDesplegable()"
                                    id="btnToggleExpediente"
                                    class="w-full flex items-center justify-between p-3 bg-gray-50/90 hover:bg-gray-100 border border-gray-200/90 rounded-2xl transition-all cursor-pointer text-left group"
                                    aria-expanded="false"
                                >
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-800 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="text-xs font-bold text-gray-800">
                                            Historial completo de documentos subidos ({{ $proyecto->documentos->count() }})
                                        </span>
                                        <span class="text-[11px] text-gray-400 font-normal hidden sm:inline">
                                            &bull; Aprobados, en revisión y pendientes
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-semibold text-gray-500 group-hover:text-gray-800" id="textoToggleExpediente">
                                            Mostrar todos
                                        </span>
                                        <svg id="iconToggleExpediente" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>

                                <!-- Contenedor Desplegable Compacto -->
                                <div id="contenedorExpedienteCompleto" class="hidden mt-2 rounded-2xl border border-gray-200 overflow-hidden bg-white shadow-2xs transition-all">
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
                                                @foreach ($proyecto->documentos as $docItem)
                                                    <tr
                                                        class="hover:bg-gray-50/80 transition-colors cursor-pointer"
                                                        ondblclick="window.location.href='{{ route('certificados.show', $docItem) }}'"
                                                        title="Doble clic para abrir revisión documental"
                                                    >
                                                        <!-- Documento -->
                                                        <td class="py-2.5 px-3.5 font-bold text-gray-900 whitespace-nowrap">
                                                            <div class="flex items-center gap-2">
                                                                <span class="text-red-600 font-mono text-[10px] font-bold px-1 py-0.2 rounded bg-red-50 border border-red-100">PDF</span>
                                                                <span>{{ $docItem->nombre_documento }}</span>
                                                            </div>
                                                        </td>

                                                        <!-- Tipo -->
                                                        <td class="py-2.5 px-3 text-gray-600 whitespace-nowrap">
                                                            {{ ucfirst($docItem->tipo) }}
                                                        </td>

                                                        <!-- Estado -->
                                                        <td class="py-2.5 px-3 whitespace-nowrap">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $docItem->estado_revision_badge }}">
                                                                {{ $docItem->estado_revision_texto }}
                                                            </span>
                                                        </td>

                                                        <!-- Observaciones -->
                                                        <td class="py-2.5 px-3 text-gray-500 max-w-xs truncate">
                                                            {{ $docItem->observaciones ?: ($docItem->motivo_rechazo ?: 'Sin observaciones') }}
                                                        </td>

                                                        <!-- Acciones -->
                                                        <td class="py-2.5 px-3 text-right whitespace-nowrap">
                                                            <div class="inline-flex items-center gap-1.5" onclick="event.stopPropagation();">
                                                                <a
                                                                    href="{{ $docItem->url_documento }}"
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
                                                                    href="{{ $docItem->url_documento }}"
                                                                    download
                                                                    class="p-1 text-gray-500 hover:text-gray-900 rounded hover:bg-gray-100 transition-colors"
                                                                    title="Descargar documento"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                    </svg>
                                                                </a>

                                                                <a
                                                                    href="{{ route('certificados.show', $docItem) }}"
                                                                    class="px-2 py-0.5 bg-gray-100 hover:bg-[#8B1D2D] text-gray-700 hover:text-white rounded text-[10px] font-bold transition-all"
                                                                    title="Abrir revisión documental"
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

                    <!-- ========================================================= -->
                    <!-- SUB-SECCIÓN: ESTUDIANTE ASOCIADOS                         -->
                    <!-- ========================================================= -->
                    <div class="pt-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">
                            Estudiante Asociados
                        </h3>

                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-800 font-bold bg-transparent">
                                        <th class="py-3 px-4 font-bold">Carnet</th>
                                        <th class="py-3 px-4 font-bold">Nombre</th>
                                        <th class="py-3 px-4 font-bold">Carrera</th>
                                        <th class="py-3 px-4 font-bold">Proyecto</th>
                                        <th class="py-3 px-4 font-bold text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600 bg-white">
                                    @forelse ($proyecto->alumnos as $alumno)
                                        <tr class="hover:bg-gray-50/60 transition-colors">
                                            <!-- Carnet -->
                                            <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                                {{ $alumno->nombre_usuario }}
                                            </td>

                                            <!-- Nombre -->
                                            <td class="py-3.5 px-4 font-medium text-gray-800">
                                                {{ $alumno->nombre_completo }}
                                            </td>

                                            <!-- Carrera -->
                                            <td class="py-3.5 px-4 text-gray-600">
                                                {{ $alumno->carrera }}
                                            </td>

                                            <!-- Proyecto -->
                                            <td class="py-3.5 px-4 text-gray-600">
                                                {{ $proyecto->nombre_proyecto }}
                                            </td>

                                            <!-- Acción Button -->
                                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                                <button
                                                    type="button"
                                                    class="action-menu-btn px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs hover:border-gray-300 inline-flex items-center gap-1.5"
                                                    data-id="{{ $alumno->id_usuario }}"
                                                    data-nombre="{{ $alumno->nombre_completo }} ({{ $alumno->nombre_usuario }})"
                                                    data-tipo="Estudiante"
                                                    data-show-url="{{ route('estudiantes.show', $alumno) }}"
                                                    data-edit-url="{{ route('estudiantes.edit', $alumno) }}"
                                                    data-delete-url="{{ route('estudiantes.destroy', $alumno) }}"
                                                >
                                                    <span>Acción</span>
                                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                                No hay estudiantes asociados a este proyecto actualmente.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- BOTÓN MODIFICAR (INFERIOR DERECHO, SEGÚN DISEÑO) -->
                    <div class="flex items-center justify-end pt-6">
                        <button
                            type="submit"
                            class="px-8 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all cursor-pointer"
                        >
                            Modificar
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

    <!-- ================================================================= -->
    <!-- PANEL FLOTANTE DESPLEGABLE: ACCIONES DEL ESTUDIANTE RELACIONADO   -->
    <!-- ================================================================= -->
    <div
        id="actionDropdownMenu"
        class="fixed z-50 w-44 bg-white rounded-xl shadow-xl border border-gray-100 py-1 text-xs hidden"
    >
        <!-- Opción Ver -->
        <a
            id="dropdownVerLink"
            href="#"
            class="flex items-center gap-2.5 px-3.5 py-2 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium"
        >
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span>Ver</span>
        </a>

        <!-- Opción Editar -->
        <a
            id="dropdownEditarLink"
            href="#"
            class="flex items-center gap-2.5 px-3.5 py-2 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium"
        >
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Editar</span>
        </a>

        <div class="border-t border-gray-100 my-1"></div>

        <!-- Opción Borrar -->
        <button
            type="button"
            id="dropdownBorrarBtn"
            class="flex w-full items-center gap-2.5 px-3.5 py-2 text-red-600 hover:bg-red-50 transition-colors text-left font-medium cursor-pointer"
        >
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span>Borrar</span>
        </button>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL CONFIRMACIÓN: BORRAR ESTUDIANTE RELACIONADO                 -->
    <!-- ================================================================= -->
    <div
        id="confirmDeleteModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 sm:p-7">
            <div class="flex items-center gap-3.5 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        ¿Está seguro que quieres eliminar?
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5" id="deleteModalSubtitle">
                        Esta acción removerá el registro seleccionado del sistema.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3.5 mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1" id="deleteModalType">Estudiante:</p>
                <p id="deleteModalItemName" class="text-xs sm:text-sm font-bold text-gray-800 break-words"></p>
            </div>

            <form id="deleteItemForm" method="POST" action="">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-end gap-3">
                    <button
                        type="button"
                        id="cancelDeleteBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-xl text-xs font-semibold transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Sí, eliminar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT CONTROLADOR DE ACCIONES Y MODAL -->
    <script>
        function toggleExpedienteDesplegable() {
            const cont = document.getElementById('contenedorExpedienteCompleto');
            const texto = document.getElementById('textoToggleExpediente');
            const icon = document.getElementById('iconToggleExpediente');
            const btn = document.getElementById('btnToggleExpediente');
            if (cont) {
                const isHidden = cont.classList.toggle('hidden');
                if (btn) btn.setAttribute('aria-expanded', !isHidden);
                if (texto) texto.textContent = isHidden ? 'Mostrar todos' : 'Ocultar expediente';
                if (icon) icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        const actionMenu = document.getElementById('actionDropdownMenu');
        const verLink = document.getElementById('dropdownVerLink');
        const editarLink = document.getElementById('dropdownEditarLink');
        const borrarBtn = document.getElementById('dropdownBorrarBtn');

        let currentSelectedItem = null;

        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();

                const rect = btn.getBoundingClientRect();
                currentSelectedItem = {
                    id: btn.getAttribute('data-id'),
                    nombre: btn.getAttribute('data-nombre'),
                    tipo: btn.getAttribute('data-tipo') || 'Estudiante',
                    showUrl: btn.getAttribute('data-show-url'),
                    editUrl: btn.getAttribute('data-edit-url'),
                    deleteUrl: btn.getAttribute('data-delete-url')
                };

                verLink.href = currentSelectedItem.showUrl;
                editarLink.href = currentSelectedItem.editUrl;

                // Posicionar el panel flotante cerca del botón
                actionMenu.style.top = `${rect.bottom + 6}px`;
                actionMenu.style.left = `${Math.max(12, rect.right - 176)}px`;
                actionMenu.classList.remove('hidden');
            });
        });

        // Ocultar panel flotante al hacer clic afuera o scroll
        window.addEventListener('click', () => {
            if (actionMenu) actionMenu.classList.add('hidden');
        });

        window.addEventListener('scroll', () => {
            if (actionMenu && !actionMenu.classList.contains('hidden')) {
                actionMenu.classList.add('hidden');
            }
        }, true);

        // Modal de Confirmación de Borrado
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteItemForm');
        const deleteModalItemName = document.getElementById('deleteModalItemName');
        const deleteModalType = document.getElementById('deleteModalType');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        if (borrarBtn) {
            borrarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (!currentSelectedItem) return;

                if (actionMenu) actionMenu.classList.add('hidden');

                if (deleteModalItemName) deleteModalItemName.textContent = currentSelectedItem.nombre;
                if (deleteModalType) deleteModalType.textContent = (currentSelectedItem.tipo || 'Estudiante') + ':';
                if (deleteForm) deleteForm.action = currentSelectedItem.deleteUrl;

                if (deleteModal) {
                    deleteModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            });
        }

        function closeDeleteModal() {
            if (deleteModal) {
                deleteModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);

        if (deleteModal) {
            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) closeDeleteModal();
            });
        }

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (actionMenu) actionMenu.classList.add('hidden');
                closeDeleteModal();
            }
        });
    </script>

</body>
</html>
