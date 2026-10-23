<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formatos y Plantillas Oficiales | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL -->
    @include('layouts.sidebar', ['active' => 'formatos'])

    <!-- ÁREA PRINCIPAL -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-1 font-medium">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-600 transition-colors">Inicio</a>
                        <span>/</span>
                        <span class="text-gray-700 font-semibold">Formatos y Guías</span>
                    </nav>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Formatos y Plantillas Oficiales (F1 - F8)
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Descarga las plantillas oficiales vigentes de la Unidad de Proyección Social (UPS) de la Universidad de El Salvador.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('estudiante.proyecto') }}#subir-pdf"
                        class="px-4 py-2 bg-[#8B1D2D] hover:bg-[#721523] text-white rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Subir Entregable PDF</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- AVISO DE REGLAMENTO -->
            <div class="bg-rose-50 border border-rose-200 text-rose-950 p-5 rounded-3xl flex items-start gap-3 shadow-2xs">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-[#8B1D2D] flex items-center justify-center shrink-0 mt-0.5 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-gray-900">Instrucciones para el diligenciamiento de formatos:</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                        Completa la información en cada plantilla, recaba los sellos húmedos y firmas en tinta azul de la institución contraparte y tu docente tutor. Finalmente, escanea o exporta como un <strong class="text-[#8B1D2D]">único archivo PDF</strong> para subirlo a tu expediente.
                    </p>
                </div>
            </div>

            <!-- GRID DE LOS 8 FORMATOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($formatos as $fmt)
                    <div class="bg-white rounded-3xl border border-gray-200/80 p-5 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 bg-red-100/70 text-[#8B1D2D] font-extrabold text-xs rounded-xl font-mono">
                                    {{ $fmt['codigo'] }}
                                </span>
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                                    {{ $fmt['fase'] }}
                                </span>
                            </div>

                            <h3 class="text-sm font-bold text-gray-900 leading-snug">
                                {{ $fmt['nombre'] }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                                {{ $fmt['descripcion'] }}
                            </p>
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] text-gray-400 font-mono flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                                <span>PDF / Plantilla Oficial</span>
                            </span>

                            <button
                                type="button"
                                onclick="alert('Descargando plantilla oficial {{ $fmt['codigo'] }}: {{ $fmt['nombre'] }}.');"
                                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Descargar Formato</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        </main>
    </div>

</body>
</html>
