<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Docente Tutor | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL DE NAVEGACIÓN COMÚN (BLANCA) -->
    @include('layouts.sidebar', ['active' => 'tutores'])

    <!-- ================================================================= -->
    <!-- CONTENIDO PRINCIPAL: DETALLES DEL DOCENTE TUTOR                   -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA: TÍTULO, SUBTÍTULO Y BOTÓN REGRESAR -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Docentes Tutores
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Tutores/Detalles
                    </p>
                </div>

                <!-- Botón Regresar en Guinda UES -->
                <div>
                    <a
                        href="{{ route('tutores.index') }}"
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

                <!-- ENCABEZADO DEL DETALLE: ID DEL TUTOR -->
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Detalles del tutor
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-0.5">
                        Id #{{ $tutor->nombre_usuario }}-{{ str_pad((string) $tutor->id_usuario, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <!-- FORMULARIO DE DETALLES Y EDICIÓN -->
                <form method="POST" action="{{ route('tutores.update', $tutor) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Fila 1: Usuario / Código -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_usuario" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Usuario / Código
                        </label>
                        <input
                            type="text"
                            name="nombre_usuario"
                            id="campo_usuario"
                            required
                            value="{{ old('nombre_usuario', $tutor->nombre_usuario) }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all font-mono"
                        />
                    </div>

                    <!-- Fila 2: Nombre Completo -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                        <label for="campo_nombre" class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Nombre Completo
                        </label>
                        <input
                            type="text"
                            name="nombre_completo"
                            id="campo_nombre"
                            required
                            value="{{ old('nombre_completo', $tutor->nombre_completo) }}"
                            placeholder="Type here..."
                            class="w-full px-3.5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-900 placeholder:text-gray-300 focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30 transition-all"
                        />
                    </div>

                    <!-- Fila 3: Departamento & Especialidad -->
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Departamento -->
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Departamento
                            </label>
                            <input
                                type="text"
                                readonly
                                value="{{ $tutor->departamento }}"
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:outline-none"
                            />
                        </div>

                        <!-- Especialidad -->
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label class="w-full sm:w-48 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                                Especialidad
                            </label>
                            <input
                                type="text"
                                readonly
                                value="Ingeniería y Proyección Social"
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 focus:outline-none"
                            />
                        </div>
                    </div>

                    <!-- Fila 4: Estado -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 pt-1">
                        <label class="w-full sm:w-44 text-xs sm:text-sm font-semibold text-gray-700 shrink-0">
                            Estado
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                class="w-4 h-4 text-[#8B1D2D] border-gray-300 rounded focus:ring-[#8B1D2D]/30"
                                @checked(old('activo', (bool) $tutor->activo))
                            />
                            <span class="text-xs sm:text-sm font-medium text-gray-700">Docente Tutor activo en el sistema</span>
                        </label>
                    </div>

                    <!-- ========================================================= -->
                    <!-- SUB-SECCIÓN: PROYECTOS A CARGO                            -->
                    <!-- ========================================================= -->
                    <div class="pt-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">
                            Proyectos Asignados
                        </h3>

                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-800 font-bold bg-transparent">
                                        <th class="py-3 px-4 font-bold">Código</th>
                                        <th class="py-3 px-4 font-bold">Proyecto</th>
                                        <th class="py-3 px-4 font-bold">Estado</th>
                                        <th class="py-3 px-4 font-bold">Estudiantes a Cargo</th>
                                        <th class="py-3 px-4 font-bold text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600 bg-white">
                                    @forelse ($tutor->proyectosComoTutor as $pry)
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
                                                {{ $pry->alumnos->count() }} alumnos asignados
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
                                                No tiene proyectos de proyección social asignados como tutor actualmente.
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
