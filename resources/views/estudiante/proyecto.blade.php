<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'Subir Documento' : 'Mi Proyecto' }} de Proyección Social | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL (SIDEBAR DE NAVEGACIÓN) -->
    @include('layouts.sidebar', ['active' => $active ?? 'mi-proyecto'])

    <!-- ================================================================= -->
    <!-- ÁREA DE CONTENIDO PRINCIPAL                                       -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA PRINCIPAL (TOP BAR) -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <!-- BREADCRUMB -->
                    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-1 font-medium">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-600 transition-colors">Inicio</a>
                        <span>/</span>
                        <span class="text-gray-700 font-semibold">{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'Subir Documento' : 'Mi Proyecto' }}</span>
                    </nav>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'Subir Documento de Proyección Social' : 'Mi Trámite de Proyección Social' }}
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        {{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'Adjunta tus expedientes y formatos oficiales requeridos exclusivamente en formato PDF.' : 'Consulta el estado de tu proyecto y sube tus documentos oficiales exclusivamente en formato PDF.' }}
                    </p>
                </div>

                <!-- Perfil del Estudiante -->
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

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col gap-6">

            <!-- ALERTA DE MENSAJES DE ÉXITO O ERROR -->
            @if (session('success'))
                <div class="order-0 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm flex items-start gap-3 shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <span class="font-bold">¡Operación exitosa!</span>
                        <p class="mt-0.5 text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="order-0 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm flex items-start gap-3 shadow-2xs">
                    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <span class="font-bold">Se encontraron errores:</span>
                        <ul class="list-disc list-inside mt-1 text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- TARJETA DEL PROYECTO ASIGNADO -->
            @if ($proyecto)
                <div id="seccion-proyecto" class="{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'order-3' : 'order-1' }} bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-6 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-md rounded-md text-[11px] font-bold tracking-wide uppercase">
                                    Proyecto #{{ $proyecto->codigo_proyecto }}
                                </span>
                                @php
                                    $estadoClases = [
                                        'solicitado' => 'bg-amber-400 text-amber-950',
                                        'en_inscripcion' => 'bg-blue-400 text-blue-950',
                                        'en_proceso' => 'bg-emerald-400 text-emerald-950',
                                        'finalizado' => 'bg-purple-400 text-purple-950',
                                    ];
                                    $estadoNombres = [
                                        'solicitado' => 'Solicitud Registrada',
                                        'en_inscripcion' => 'En Inscripción',
                                        'en_proceso' => 'En Ejecución (Activo)',
                                        'finalizado' => 'Finalizado / Aprobado',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-extrabold {{ $estadoClases[$proyecto->estado] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ $estadoNombres[$proyecto->estado] ?? ucfirst($proyecto->estado) }}
                                </span>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold tracking-tight text-white">
                                {{ $proyecto->nombre_proyecto }}
                            </h2>
                            <p class="text-xs text-gray-300 mt-1">
                                Área: <span class="text-white font-medium">{{ $proyecto->area }}</span>
                            </p>
                        </div>

                        <!-- Badge Tutor Asignado -->
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 shrink-0">
                            <p class="text-[11px] uppercase tracking-wider text-gray-300 font-semibold mb-1">Docente Tutor Asignado</p>
                            <p class="text-sm font-bold text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $proyecto->tutor?->nombre_completo ?? 'Pendiente de asignación' }}
                            </p>
                            @if ($proyecto->tutor)
                                <p class="text-[11px] text-gray-300 mt-0.5">Usuario: {{ $proyecto->tutor->nombre_usuario }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Detalles Complementarios -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 bg-gray-50/60 p-4 sm:p-5 text-xs text-gray-600">
                        <div class="px-3 py-2">
                            <p class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Fecha de Inicio</p>
                            <p class="text-gray-800 font-bold mt-0.5 text-sm">{{ $proyecto->fecha_inicio }}</p>
                        </div>
                        <div class="px-3 py-2">
                            <p class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Fecha Estimada de Finalización</p>
                            <p class="text-gray-800 font-bold mt-0.5 text-sm">{{ $proyecto->fecha_fin }}</p>
                        </div>
                        <div class="px-3 py-2">
                            <p class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Subcoordinador Encargado</p>
                            <p class="text-gray-800 font-bold mt-0.5 text-sm">{{ $proyecto->subcoordinador }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Sin proyecto asignado -->
                <div id="seccion-proyecto" class="{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'order-3' : 'order-1' }} bg-amber-50 border border-amber-200 rounded-3xl p-6 sm:p-8 text-center text-amber-900 shadow-2xs">
                    <div class="w-12 h-12 bg-amber-100 rounded-2xl mx-auto flex items-center justify-center text-amber-700 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold">No tienes un proyecto de proyección social asignado</h3>
                    <p class="text-xs text-amber-700 mt-1 max-w-md mx-auto">
                        Comunícate con el Coordinador de Carrera o con la Unidad de Proyección Social (UPS) para formalizar la inscripción de tu proyecto.
                    </p>
                </div>
            @endif

            <!-- ============================================================= -->
            <!-- SECCIÓN: SUBIR DOCUMENTO (EXCLUSIVAMENTE PDF)                  -->
            <!-- ============================================================= -->
            <div id="subir-pdf" class="{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'order-1' : 'order-2' }} bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6 sm:p-7">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                                Subir Entrega de Documento
                            </h3>
                            <p class="text-xs text-gray-500">
                                Adjunta tus expedientes y formatos oficiales requeridos para el avance de tus horas sociales.
                            </p>
                        </div>
                    </div>

                    <!-- Badge informativo exclusivo PDF -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200/80 text-red-700 rounded-xl text-xs font-semibold self-start sm:self-auto">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <span>Exclusivo: Formato PDF (.pdf) &bull; Máx. 20 MB</span>
                    </div>
                </div>

                <!-- Formulario de Subida -->
                <form
                    action="{{ route('estudiante.subirDocumento') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="subirPdfForm"
                    class="mt-6 space-y-5"
                >
                    @csrf
                    @if ($proyecto)
                        <input type="hidden" name="id_proyecto" value="{{ $proyecto->id_proyecto }}">
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Campo 1: Tipo de Documento -->
                        <div>
                            <label for="tipo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="tipo"
                                name="tipo"
                                required
                                class="w-full px-3.5 py-2.5 bg-gray-50/70 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:bg-white focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                            >
                                <option value="" disabled selected>Selecciona el tipo de entrega...</option>
                                @foreach ($tipos as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('tipo') === $val ? 'selected' : '' }}>
                                        {{ $lbl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo 2: Título o Nombre del Documento -->
                        <div>
                            <label for="nombre_documento" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Título del Documento <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nombre_documento"
                                name="nombre_documento"
                                value="{{ old('nombre_documento') }}"
                                required
                                placeholder="Ej: Anteproyecto de Servicio Social - Versión Final"
                                class="w-full px-3.5 py-2.5 bg-gray-50/70 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:bg-white focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                            />
                        </div>
                    </div>

                    <!-- Campo 3: Área de Selección y Arrastre de Archivo PDF -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Archivo PDF a Subir <span class="text-red-500">*</span>
                        </label>

                        <div
                            id="dropZone"
                            class="relative border-2 border-dashed border-gray-200 hover:border-[#8B1D2D]/60 rounded-3xl p-6 sm:p-8 text-center bg-gray-50/50 hover:bg-red-50/20 transition-all cursor-pointer group"
                        >
                            <input
                                type="file"
                                id="archivo_pdf"
                                name="archivo_pdf"
                                accept=".pdf,application/pdf"
                                required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            />

                            <div class="flex flex-col items-center justify-center pointer-events-none">
                                <div class="w-14 h-14 rounded-2xl bg-red-100/70 text-red-600 flex items-center justify-center mb-3 group-hover:scale-105 group-hover:bg-red-100 transition-all">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-xs sm:text-sm font-bold text-gray-800">
                                    Haz clic para examinar o arrastra y suelta tu archivo PDF aquí
                                </p>
                                <p class="text-[11px] text-gray-400 mt-1">
                                    Únicamente archivos con extensión <span class="font-bold text-red-600">.PDF</span> de hasta 20 MB.
                                </p>

                                <!-- Información del archivo seleccionado -->
                                <div id="fileSelectedInfo" class="hidden mt-4 inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-medium">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="fileNameDisplay" class="font-bold"></span>
                                    <span id="fileSizeDisplay" class="text-gray-500 font-normal"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Envío -->
                    <div class="flex items-center justify-end pt-2">
                        <button
                            type="submit"
                            id="submitUploadBtn"
                            class="px-6 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all cursor-pointer flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span>Guardar y Subir Archivo PDF</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ============================================================= -->
            <!-- SECCIÓN: DOCUMENTOS DEL PROYECTO Y EXPEDIENTE                 -->
            <!-- ============================================================= -->
            <div id="seccion-expedientes" class="{{ ($active ?? 'mi-proyecto') === 'subir-documento' ? 'order-2' : 'order-3' }} bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight flex items-center gap-2">
                            <span>Documentos Registrados en tu Expediente</span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                {{ $documentos->count() }}
                            </span>
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Archivos PDF alojados localmente con URL directa para visualización y revisión.
                        </p>
                    </div>
                </div>

                <!-- Tabla de Documentos -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/70 text-gray-400 uppercase text-[11px] tracking-wider">
                                <th class="py-3 px-4 font-bold">Documento</th>
                                <th class="py-3 px-4 font-bold">Tipo</th>
                                <th class="py-3 px-4 font-bold">URL Generada</th>
                                <th class="py-3 px-4 font-bold">Estado</th>
                                <th class="py-3 px-4 font-bold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600 bg-white">
                            @forelse ($documentos as $doc)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <!-- Nombre del Documento -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 leading-tight">
                                                    {{ $doc->nombre_documento }}
                                                </p>
                                                <p class="text-[11px] text-gray-400 mt-0.5 font-mono">
                                                    ID: #{{ $doc->id_documento }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Tipo -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @php
                                            $tipoBadgeClases = [
                                                'solicitud' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'inscripcion' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'anteproyecto' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'mitad_proyecto' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                                'memoria' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'otro' => 'bg-gray-50 text-gray-700 border-gray-200',
                                            ];
                                        @endphp
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $tipoBadgeClases[$doc->tipo] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                            {{ $tipos[$doc->tipo] ?? ucfirst($doc->tipo) }}
                                        </span>
                                    </td>

                                    <!-- URL Generada -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-1.5 max-w-xs sm:max-w-sm">
                                            <code class="text-[11px] text-gray-600 bg-gray-50 border border-gray-200 rounded-md px-2 py-1 truncate font-mono" title="{{ $doc->url_documento }}">
                                                {{ $doc->url_documento }}
                                            </code>
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Disponible</span>
                                        </span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <!-- Ver PDF en Navegador (Pestaña Nueva) -->
                                            <a
                                                href="{{ $doc->url_documento }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="btn-ver-pdf px-3 py-1.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-lg text-xs font-semibold transition-all inline-flex items-center gap-1.5 shadow-2xs cursor-pointer"
                                                title="Abrir y visualizar PDF en el navegador"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                <span>Ver PDF</span>
                                            </a>

                                            <!-- Previsualizar en Modal -->
                                            <button
                                                type="button"
                                                class="preview-pdf-btn px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-medium transition-colors cursor-pointer inline-flex items-center gap-1"
                                                data-pdf-url="{{ $doc->url_documento }}"
                                                data-pdf-title="{{ $doc->nombre_documento }}"
                                                title="Previsualizar aquí"
                                            >
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Preview</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="font-bold text-gray-700 text-sm">No hay documentos subidos todavía</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                Utiliza el formulario de arriba para subir tu primer entregable en formato PDF.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL DE PREVISUALIZACIÓN DE PDF INTEGRADA                        -->
    <!-- ================================================================= -->
    <div
        id="pdfPreviewModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-6 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-4xl h-[85vh] bg-white rounded-3xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
            <!-- Barra superior del modal -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="truncate">
                        <h4 id="previewModalTitle" class="text-sm font-bold text-gray-900 truncate">Vista Previa del Documento</h4>
                        <p class="text-[11px] text-gray-400">Visor PDF embebido</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        id="openInNewTabBtn"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl text-xs font-semibold transition-colors flex items-center gap-1 cursor-pointer"
                    >
                        <span>Abrir en pestaña</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    <button
                        type="button"
                        id="closePreviewModalBtn"
                        class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition-colors cursor-pointer"
                        title="Cerrar vista previa"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenedor del Visor -->
            <div class="flex-1 bg-gray-900 w-full h-full relative">
                <iframe
                    id="pdfPreviewIframe"
                    src=""
                    class="w-full h-full border-0"
                    title="Visor PDF"
                ></iframe>
            </div>
        </div>
    </div>

    <!-- SCRIPT DE VALIDACIÓN EXCLUSIVA PDF Y MANEJO DEL MODAL -->
    <script>
        const fileInput = document.getElementById('archivo_pdf');
        const fileSelectedInfo = document.getElementById('fileSelectedInfo');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileSizeDisplay = document.getElementById('fileSizeDisplay');
        const dropZone = document.getElementById('dropZone');

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) {
                    fileSelectedInfo.classList.add('hidden');
                    return;
                }

                // Validación estricta: Extensión y tipo MIME deben ser PDF
                const isPdfExtension = file.name.toLowerCase().endsWith('.pdf');
                const isPdfMime = file.type === 'application/pdf' || file.type === '';

                if (!isPdfExtension) {
                    alert('Error: Formato no permitido. Debes seleccionar exclusivamente un archivo con extensión .PDF.');
                    this.value = '';
                    fileSelectedInfo.classList.add('hidden');
                    return;
                }

                // Validación de tamaño (Máximo 20 MB = 20 * 1024 * 1024 bytes)
                const maxSize = 20 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Error: El archivo excede el tamaño máximo permitido de 20 MB.');
                    this.value = '';
                    fileSelectedInfo.classList.add('hidden');
                    return;
                }

                // Mostrar información del archivo seleccionado
                fileNameDisplay.textContent = file.name;
                const sizeInMb = (file.size / (1024 * 1024)).toFixed(2);
                fileSizeDisplay.textContent = `(${sizeInMb} MB)`;
                fileSelectedInfo.classList.remove('hidden');
            });
        }

        // Modal de Previsualización PDF
        const previewModal = document.getElementById('pdfPreviewModal');
        const previewIframe = document.getElementById('pdfPreviewIframe');
        const previewModalTitle = document.getElementById('previewModalTitle');
        const openInNewTabBtn = document.getElementById('openInNewTabBtn');
        const closePreviewModalBtn = document.getElementById('closePreviewModalBtn');

        document.querySelectorAll('.preview-pdf-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const url = btn.getAttribute('data-pdf-url');
                const title = btn.getAttribute('data-pdf-title');

                if (previewModalTitle) previewModalTitle.textContent = title;
                if (openInNewTabBtn) openInNewTabBtn.href = url;
                if (previewIframe) previewIframe.src = url;

                if (previewModal) {
                    previewModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        function closePreviewModal() {
            if (previewModal) {
                previewModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            if (previewIframe) {
                previewIframe.src = '';
            }
        }

        if (closePreviewModalBtn) closePreviewModalBtn.addEventListener('click', closePreviewModal);

        if (previewModal) {
            previewModal.addEventListener('click', (e) => {
                if (e.target === previewModal) closePreviewModal();
            });
        }

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePreviewModal();
        });
    </script>

</body>
</html>
