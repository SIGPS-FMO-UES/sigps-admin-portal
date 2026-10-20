<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificados y Documentos | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'certificados'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: SECCIÓN CERTIFICADOS Y DOCUMENTOS -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO Y BOTÓN NUEVO -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Certificados y Documentos
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Control de memorias, actas de aprobación, constancias e inscripciones registradas.
                    </p>
                </div>

                <!-- Botón Nuevo + -->
                <div>
                    <button
                        type="button"
                        id="openModalBtn"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-150 flex items-center gap-1.5 cursor-pointer"
                    >
                        <span>Nuevo +</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">

            <!-- MENSAJES DE ESTADO FLASH (ÉXITO O ERROR) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs sm:text-sm flex items-center gap-2.5 shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-xs sm:text-sm shadow-2xs">
                    <p class="font-bold mb-1">Por favor verifica los siguientes campos:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- BARRA DE FILTROS (Search, Tipo, Proyecto) -->
            <form method="GET" action="{{ route('certificados.index') }}" class="bg-white rounded-2xl border border-gray-200/80 p-3 sm:p-4 shadow-2xs flex flex-col md:flex-row items-center gap-3">
                <!-- Buscador de texto -->
                <div class="relative flex-1 w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search documento..."
                        class="w-full pl-9 pr-4 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                    />
                </div>

                <!-- Dropdown Tipo de Documento -->
                <div class="w-full md:w-56">
                    <select
                        name="tipo"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Tipo de Documento</option>
                        @foreach ($tipos as $key => $label)
                            <option value="{{ $key }}" @selected($tipoSeleccionado === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Proyecto Vinculado -->
                <div class="w-full md:w-64">
                    <select
                        name="id_proyecto"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-[#F9FAFB] border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:bg-white focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all cursor-pointer"
                    >
                        <option value="">Proyecto Vinculado</option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->id_proyecto }}" @selected((string)$proyectoSeleccionado === (string)$p->id_proyecto)>
                                [{{ $p->codigo_proyecto }}] {{ Str::limit($p->nombre_proyecto, 24) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($search || $tipoSeleccionado || $proyectoSeleccionado)
                    <a
                        href="{{ route('certificados.index') }}"
                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors"
                    >
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- TARJETA: LISTA DE CERTIFICADOS -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800">
                        Lista de Certificados y Documentos
                    </h2>
                    <span class="text-xs text-gray-400 font-medium">
                        Total en BD: {{ $documentos->total() }} registros
                    </span>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold bg-transparent">
                                <th class="py-3 px-4 font-bold text-gray-800">ID / Código</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Nombre del Documento</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Tipo</th>
                                <th class="py-3 px-4 font-bold text-gray-800">Proyecto Vinculado</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse ($documentos as $doc)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- ID / Código -->
                                    <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                        DOC-{{ str_pad((string) $doc->id_documento, 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <!-- Nombre -->
                                    <td class="py-3.5 px-4 font-medium text-gray-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate max-w-xs sm:max-w-md">{{ $doc->nombre_documento }}</span>
                                        </div>
                                    </td>

                                    <!-- Tipo -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @php
                                            $tipoClasses = [
                                                'solicitud' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'inscripcion' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'anteproyecto' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'mitad_proyecto' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'memoria' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'otro' => 'bg-gray-50 text-gray-700 border-gray-200',
                                            ];
                                            $badgeClass = $tipoClasses[$doc->tipo] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeClass }}">
                                            {{ $tipos[$doc->tipo] ?? ucfirst($doc->tipo) }}
                                        </span>
                                    </td>

                                    <!-- Proyecto Vinculado -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($doc->proyectos->isNotEmpty())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-[#8B1D2D] border border-red-100">
                                                {{ Str::limit($doc->proyectos->first()->nombre_proyecto, 32) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">
                                                Sin vincular a proyecto
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Acción -->
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <button
                                            type="button"
                                            onclick="alert('Detalle del Certificado:\nNombre: {{ $doc->nombre_documento }}\nTipo: {{ $doc->tipo }}\nURL: {{ $doc->url_documento }}');"
                                            class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all cursor-pointer shadow-2xs hover:border-gray-300"
                                        >
                                            Button
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm">
                                        No se encontraron certificados ni documentos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINACIÓN INFERIOR (Formato "Pagina 01 - 02") -->
                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                    <div>
                        <span>
                            Pagina {{ str_pad((string) $documentos->currentPage(), 2, '0', STR_PAD_LEFT) }} - {{ str_pad((string) max(1, $documentos->lastPage()), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 font-medium">
                        <a
                            href="{{ $documentos->url(1) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($documentos->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &laquo;
                        </a>
                        <a
                            href="{{ $documentos->previousPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if($documentos->onFirstPage()) text-gray-300 pointer-events-none @endif"
                        >
                            &lsaquo;
                        </a>

                        @for ($page = 1; $page <= min(5, $documentos->lastPage()); $page++)
                            <a
                                href="{{ $documentos->url($page) }}"
                                class="px-2.5 py-1 rounded text-xs transition-colors @if($documentos->currentPage() === $page) bg-[#8B1D2D] text-white font-bold @else hover:bg-gray-100 text-gray-600 @endif"
                            >
                                {{ $page }}
                            </a>
                        @endfor

                        <a
                            href="{{ $documentos->nextPageUrl() }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$documentos->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &rsaquo;
                        </a>
                        <a
                            href="{{ $documentos->url($documentos->lastPage()) }}"
                            class="px-2 py-1 rounded hover:bg-gray-100 @if(!$documentos->hasMorePages()) text-gray-300 pointer-events-none @endif"
                        >
                            &raquo;
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL NUEVO CERTIFICADO -->
    <div
        id="nuevoCertificadoModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 sm:p-8">
            <button
                type="button"
                id="closeModalBtn"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#8B1D2D] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">
                        Registrar Nuevo Certificado o Documento
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Almacena el registro en PostgreSQL y vincula al proyecto correspondiente.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('certificados.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="nombre_documento" class="block text-xs font-semibold text-gray-700 mb-1">
                        Nombre del Documento / Certificado <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_documento"
                        name="nombre_documento"
                        value="{{ old('nombre_documento') }}"
                        placeholder="Ej. Constancia de Finalización - Proyección Social"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div>
                    <label for="tipo_select" class="block text-xs font-semibold text-gray-700 mb-1">
                        Tipo de Documento <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="tipo_select"
                        name="tipo"
                        required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        @foreach ($tipos as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('tipo') === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_proyecto_modal" class="block text-xs font-semibold text-gray-700 mb-1">
                        Vincular a Proyecto (Opcional)
                    </label>
                    <select
                        id="id_proyecto_modal"
                        name="id_proyecto"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    >
                        <option value="">-- Sin vincular por ahora --</option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->id_proyecto }}" @selected(old('id_proyecto') == $p->id_proyecto)>
                                [{{ $p->codigo_proyecto }}] {{ $p->nombre_proyecto }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="url_documento" class="block text-xs font-semibold text-gray-700 mb-1">
                        URL o Ubicación del Archivo <span class="text-gray-400 font-normal">(Opcional, se genera automáticamente si se omite)</span>
                    </label>
                    <input
                        type="text"
                        id="url_documento"
                        name="url_documento"
                        value="{{ old('url_documento') }}"
                        placeholder="https://sigps.ues.edu.sv/storage/certificados/archivo.pdf"
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#8B1D2D]/20 focus:border-[#8B1D2D] transition-all"
                    />
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100">
                    <button
                        type="button"
                        id="cancelBtn"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-md shadow-[#8B1D2D]/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <span>Guardar Certificado</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('nuevoCertificadoModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const input = document.getElementById('nombre_documento');
                    if (input) input.focus();
                }, 100);
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
        }

        @if ($errors->any())
            openModal();
        @endif
    </script>

</body>
</html>
