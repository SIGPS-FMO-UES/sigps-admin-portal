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

                    <!-- Fila 6: Documento -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Documento
                        </label>
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Tag Documento.pdf con botón x -->
                            @forelse ($proyecto->documentos as $doc)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#8B1D2D] text-white rounded-md text-xs font-medium shadow-2xs">
                                    <span>{{ $doc->nombre_documento }}.pdf</span>
                                    <button type="button" class="hover:text-red-200 ml-1 font-bold cursor-pointer" title="Remover documento">✕</button>
                                </span>
                            @empty
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#8B1D2D] text-white rounded-md text-xs font-medium shadow-2xs">
                                    <span>Documento.pdf</span>
                                    <button type="button" class="hover:text-red-200 ml-1 font-bold cursor-pointer" title="Remover documento">✕</button>
                                </span>
                            @endforelse

                            <!-- Botón Agregar docx -->
                            <button
                                type="button"
                                onclick="alert('Seleccione un documento digital (.docx o .pdf) para adjuntarlo al expediente del proyecto.');"
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
                                                    onclick="alert('Expediente del estudiante:\nCarnet: {{ $alumno->nombre_usuario }}\nNombre: {{ $alumno->nombre_completo }}\nCarrera: {{ $alumno->carrera }}');"
                                                    class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all shadow-2xs cursor-pointer hover:border-gray-300"
                                                >
                                                    Button
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Muestra datos representativos si el proyecto aún no tiene alumnos asociados -->
                                        <tr class="hover:bg-gray-50/60 transition-colors">
                                            <td class="py-3.5 px-4 font-semibold text-gray-900">2024-0185</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-800">Ana Beatriz Mendoza</td>
                                            <td class="py-3.5 px-4 text-gray-600">Ingeniería de Sistemas Informáticos</td>
                                            <td class="py-3.5 px-4 text-gray-600">{{ $proyecto->nombre_proyecto }}</td>
                                            <td class="py-3.5 px-4 text-right">
                                                <button type="button" class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all shadow-2xs">
                                                    Button
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50/60 transition-colors">
                                            <td class="py-3.5 px-4 font-semibold text-gray-900">2024-0192</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-800">Carlos Eduardo Ramos</td>
                                            <td class="py-3.5 px-4 text-gray-600">Licenciatura en Computación</td>
                                            <td class="py-3.5 px-4 text-gray-600">{{ $proyecto->nombre_proyecto }}</td>
                                            <td class="py-3.5 px-4 text-right">
                                                <button type="button" class="px-3.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-all shadow-2xs">
                                                    Button
                                                </button>
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
