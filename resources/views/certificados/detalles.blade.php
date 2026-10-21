<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Documento / Certificado | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'certificados'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: DETALLES DEL DOCUMENTO                       -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO, SUBTÍTULO Y BOTÓN REGRESAR -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Certificados y Documentos
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Certificados/Detalles
                    </p>
                </div>

                <!-- Botón Regresar en Guinda UES -->
                <div>
                    <a
                        href="{{ route('certificados.index') }}"
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

            <!-- CONTENEDOR PRINCIPAL BLANCO REDONDEADO -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6 sm:p-10 space-y-6">

                <!-- ENCABEZADO DEL DETALLE: ID DEL DOCUMENTO -->
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Detalles del documento / certificado
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Id #DOC-{{ str_pad((string) $certificado->id_documento, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <!-- FORMULARIO DE DETALLES Y EDICIÓN -->
                <form method="POST" action="{{ route('certificados.update', $certificado) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Fila 1: Nombre del Documento -->
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
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
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
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
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
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                        >
                            <option value="">Type here... (Sin proyecto asociado)</option>
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
                            URL / Enlace
                        </label>
                        <input
                            type="text"
                            name="url_documento"
                            id="campo_url"
                            value="{{ old('url_documento', $certificado->url_documento) }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all font-mono"
                        />
                    </div>

                    <!-- Fila 5: Documento digital y adjuntos -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 pt-1">
                        <label class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Documento
                        </label>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#8B1D2D] text-white rounded-md text-xs font-medium shadow-2xs">
                                <span>{{ $certificado->nombre_documento }}.pdf</span>
                                <button type="button" class="hover:text-red-200 ml-1 font-bold cursor-pointer" title="Remover documento">✕</button>
                            </span>

                            <button
                                type="button"
                                onclick="alert('Seleccione un documento digital (.docx o .pdf) para adjuntarlo al expediente del certificado.');"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 rounded-md text-xs font-semibold shadow-2xs transition-colors cursor-pointer"
                            >
                                <span>Agregar docx</span>
                                <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- SUB-SECCIÓN: PROYECTOS VINCULADOS                         -->
                    <!-- ========================================================= -->
                    <div class="pt-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">
                            Proyectos Vinculados
                        </h3>

                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-800 font-bold bg-transparent">
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
                                                    class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all shadow-2xs hover:border-gray-300 inline-block"
                                                >
                                                    Button
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                                No hay proyectos vinculados a este certificado actualmente.
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

</body>
</html>
