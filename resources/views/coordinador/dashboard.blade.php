<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinación de Carrera | Sistema de Proyección Social - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex flex-col lg:flex-row min-h-screen">

    <!-- BARRA LATERAL (SIDEBAR DE NAVEGACIÓN COMÚN) -->
    @include('layouts.sidebar', ['active' => 'dashboard'])

    <!-- ================================================================= -->
    <!-- ÁREA DE CONTENIDO PRINCIPAL                                       -->
    <!-- ================================================================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- CABECERA INSTITUCIONAL DE COORDINACIÓN DE CARRERA -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-indigo-50 border border-indigo-200 text-indigo-800 rounded-full text-[10px] font-extrabold tracking-wide uppercase">
                            Supervisión Académica &bull; SYS-02
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Coordinación de Carrera / Escuela</span>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Panel de Asignación de Tutores y Aval Académico
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Asigna y reasigna tutores a proyectos, revisa documentos validados y emite avales antes de remitir a la UPS.
                    </p>
                </div>

                <!-- Perfil del Coordinador Autenticado -->
                <div class="flex items-center gap-3 bg-gray-50/80 border border-gray-200/80 rounded-2xl px-4 py-2 self-start md:self-auto">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 font-bold text-sm flex items-center justify-center border border-indigo-200 shrink-0">
                        {{ strtoupper(substr($usuario->nombre_completo ?? 'CC', 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800 leading-tight">
                            {{ $usuario->nombre_completo }}
                        </p>
                        <p class="text-[11px] text-gray-500 font-medium">
                            Coordinador &bull; <span class="font-mono text-gray-700 font-bold">{{ $usuario->nombre_usuario }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- MENSAJES FLASH DE ESTADO -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Operación completada</p>
                        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Observaciones enviadas</p>
                        <p class="text-amber-700 font-medium">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            <!-- 1. TARJETAS KPI DE COORDINACIÓN DE CARRERA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- KPI 1: Total Proyectos -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyectos de Carrera</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ $totalProyectos }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Bajo la coordinación</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 2: Tutores Activos -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Docentes Tutores</p>
                        <p class="text-3xl font-black text-[#8B1D2D] mt-1">{{ $totalTutores }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Planta docente habilitada</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 text-[#8B1D2D] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 3: Expedientes Listos para Aval -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Listos para Aval</p>
                        <p class="text-3xl font-black text-emerald-600 mt-1">{{ $pendientesAval }}</p>
                        <span class="text-[11px] text-emerald-600 font-medium">Segundo nivel (HU-69)</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 4: Proyectos sin Tutor -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sin Tutor Asignado</p>
                        <p class="text-3xl font-black {{ $proyectosSinTutor > 0 ? 'text-amber-600' : 'text-gray-400' }} mt-1">{{ $proyectosSinTutor }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Requieren asignación (HU-61)</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. BANDEJA DE ASIGNACIÓN Y REASIGNACIÓN DE TUTORES (HU-61, HU-62, RF-ACA-01) -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">
                                Asignación y Reasignación de Docentes Tutores (HU-61, HU-62)
                            </h2>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Asigna un docente tutor a cada proyecto o reasigna conservando la trazabilidad de revisiones técnicas anteriores.
                        </p>
                    </div>
                    <span class="text-xs font-bold text-gray-400 font-mono">
                        {{ $proyectos->count() }} proyectos activos
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Código</th>
                                <th class="py-3 px-4">Proyecto</th>
                                <th class="py-3 px-4">Estudiantes Inscritos</th>
                                <th class="py-3 px-4">Tutor Actual</th>
                                <th class="py-3 px-4">Asignar / Reasignar Tutor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach ($proyectos as $proy)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#8B1D2D] whitespace-nowrap">
                                        #{{ $proy->codigo_proyecto }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">
                                        {{ $proy->nombre_proyecto }}
                                        <div class="text-[11px] text-gray-400 font-normal mt-0.5">
                                            Estado: <span class="font-semibold text-gray-600">{{ ucfirst(str_replace('_', ' ', $proy->estado)) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        {{ $proy->alumnos->pluck('nombre_completo')->join(', ') ?: 'Sin estudiantes' }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($proy->tutor)
                                            <span class="font-bold text-gray-800">{{ $proy->tutor->nombre_completo }}</span>
                                            <div class="text-[10px] text-emerald-600 font-semibold">Tutor Activo</div>
                                        @else
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded text-[10px] font-bold">
                                                Sin tutor asignado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <!-- Formulario de Asignación / Reasignación Directa -->
                                        <form method="POST" action="{{ route('coordinador.asignarTutor', $proy) }}" class="flex items-center gap-2">
                                            @csrf
                                            <select
                                                name="tutor_id"
                                                class="text-xs bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-[#8B1D2D] text-gray-800"
                                                required
                                            >
                                                <option value="" disabled {{ ! $proy->tutor_id ? 'selected' : '' }}>Seleccionar tutor...</option>
                                                @foreach ($tutores as $t)
                                                    <option value="{{ $t->id_usuario }}" {{ $proy->tutor_id === $t->id_usuario ? 'selected' : '' }}>
                                                        {{ $t->nombre_completo }} ({{ $t->proyectos_como_tutor_count }} tutelados)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 bg-[#8B1D2D] hover:bg-[#721523] text-white font-bold text-[11px] rounded-lg transition-colors cursor-pointer shadow-2xs"
                                                title="{{ $proy->tutor_id ? 'Reasignar tutor al proyecto' : 'Asignar tutor al proyecto' }}"
                                            >
                                                {{ $proy->tutor_id ? 'Reasignar' : 'Asignar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. BANDEJA DE REVISIÓN ACADÉMICA DE SEGUNDO NIVEL Y AVAL (HU-69, RF-ACA-05, HU-72) -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">
                                Expedientes para Aval Académico y Envío a UPS (HU-69, RF-ACA-05)
                            </h2>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Revisa los documentos con visto bueno del tutor. Emite el aval institucional que traslada el expediente a Proyección Social.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Documento</th>
                                <th class="py-3 px-4">Proyecto</th>
                                <th class="py-3 px-4">Docente Tutor</th>
                                <th class="py-3 px-4">Estado Actual</th>
                                <th class="py-3 px-4">Dictamen de Tutor</th>
                                <th class="py-3 px-4 text-center">Acciones de Coordinación</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($documentosSegundoNivel as $doc)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate max-w-xs" title="{{ $doc->nombre_documento }}">{{ $doc->nombre_documento }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($doc->proyectos->isNotEmpty())
                                            #{{ $doc->proyectos->first()->codigo_proyecto }} &bull; {{ Str::limit($doc->proyectos->first()->nombre_proyecto, 28) }}
                                        @else
                                            <span class="text-gray-400 italic">Sin proyecto</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        {{ $doc->proyectos->first()?->tutor?->nombre_completo ?? 'Sin tutor asignado' }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $doc->estado_revision_badge }}">
                                            {{ $doc->estado_revision_texto }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-500 max-w-xs text-[11px]">
                                        {{ $doc->observaciones ?: 'Aprobado favorablemente por el tutor.' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Ver PDF -->
                                            <a
                                                href="{{ $doc->url_documento }}"
                                                target="_blank"
                                                class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-[11px] rounded-lg transition-colors inline-flex items-center gap-1"
                                                title="Visualizar documento"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Ver</span>
                                            </a>

                                            <!-- Emitir Aval y Enviar a UPS (RF-ACA-05, HU-72) -->
                                            <form method="POST" action="{{ route('coordinador.aval', $doc) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="accion" value="aval">
                                                <button
                                                    type="submit"
                                                    class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-[11px] rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1 shadow-2xs"
                                                    title="Emitir Aval Digital y Remitir a la UPS"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Emitir Aval &rarr; UPS</span>
                                                </button>
                                            </form>

                                            <!-- Devolver con observaciones (HU-71) -->
                                            <button
                                                type="button"
                                                onclick="openCoordObservarModal({{ $doc->id_documento }}, '{{ addslashes($doc->nombre_documento) }}')"
                                                class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-semibold text-[11px] rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1"
                                                title="Devolver con observaciones de carrera"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>Devolver</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        <p class="font-bold text-gray-600">No hay expedientes pendientes de aval académico</p>
                                        <p class="text-xs mt-1">Los tutores deben aprobar primero los documentos para habilitar la emisión de aval de carrera.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. BALANCE DE CARGA DE TUTORES DEL DEPARTAMENTO -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 tracking-tight">
                            Carga Académica de Tutores &bull; Escuela de Ingeniería
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Monitoreo de tutorados activos para asegurar una distribución equitativa de proyectos.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($tutores as $t)
                        <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/60 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <p class="text-xs font-bold text-gray-900">{{ $t->nombre_completo }}</p>
                                <p class="text-[11px] text-gray-400 font-mono">{{ $t->nombre_usuario }}</p>
                            </div>
                            <span class="px-2.5 py-1 bg-white border border-gray-200 text-gray-800 rounded-xl text-xs font-bold font-mono shadow-2xs">
                                {{ $t->proyectos_como_tutor_count }} proyectos
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL DE DEVOLUCIÓN CON OBSERVACIONES (HU-71) -->
    <div id="coordObservarModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xl max-w-lg w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900">Devolución de Expediente (HU-71)</h3>
                        <p class="text-[11px] text-gray-500" id="coordObservarDocTitulo">Documento</p>
                    </div>
                </div>
                <button type="button" onclick="closeCoordObservarModal()" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="coordObservarForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="accion" value="observar">

                <div>
                    <label for="coordObservacionesTextarea" class="block text-xs font-bold text-gray-700 mb-1">
                        Observaciones académicas de coordinación <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="coordObservacionesTextarea"
                        name="observaciones"
                        rows="4"
                        required
                        placeholder="Describe los motivos por los cuales no se otorga el aval institucional..."
                        class="w-full p-3 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button
                        type="button"
                        onclick="closeCoordObservarModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-[#8B1D2D] hover:bg-[#721523] text-white font-bold text-xs rounded-xl shadow-sm transition-all cursor-pointer"
                    >
                        Confirmar Devolución
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT PARA EL MODAL -->
    <script>
        function openCoordObservarModal(docId, docTitulo) {
            const modal = document.getElementById('coordObservarModal');
            const form = document.getElementById('coordObservarForm');
            const titulo = document.getElementById('coordObservarDocTitulo');

            form.action = `/coordinador/documentos/${docId}/aval`;
            titulo.textContent = docTitulo;
            modal.classList.remove('hidden');
        }

        function closeCoordObservarModal() {
            document.getElementById('coordObservarModal').classList.add('hidden');
        }
    </script>
</body>
</html>
