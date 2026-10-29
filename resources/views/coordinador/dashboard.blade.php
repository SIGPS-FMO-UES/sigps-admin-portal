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
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden space-y-0">
                <!-- Cabecera de la sección -->
                <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">
                                Expedientes para Aval Académico y Envío a UPS (HU-69, RF-ACA-05)
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $documentosListosParaAval->count() }} {{ $documentosListosParaAval->count() === 1 ? 'listo para enviar a UPS' : 'listos para enviar a UPS' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Revisa los documentos con visto bueno del tutor. Emite el aval institucional que traslada el expediente a Proyección Social.
                        </p>
                    </div>
                </div>

                <!-- A. TABLA PRINCIPAL PRIORITARIA: SOLO DOCUMENTOS APROBADOS POR EL TUTOR (LISTOS PARA AVAL) -->
                <div>
                    <div class="px-5 py-3 bg-emerald-50/40 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-950 flex items-center gap-1.5 uppercase tracking-wider">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Prioridad 1: Aprobados por Tutor &bull; Listos para Emitir Aval y Enviar a UPS
                        </span>
                        <span class="text-[11px] text-emerald-700 font-semibold hidden sm:inline">Acción directa requerida</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                    <th class="py-3 px-4">Documento</th>
                                    <th class="py-3 px-4">Proyecto</th>
                                    <th class="py-3 px-4">Docente Tutor</th>
                                    <th class="py-3 px-4">Estado</th>
                                    <th class="py-3 px-4">Dictamen de Tutor</th>
                                    <th class="py-3 px-4 text-center">Acciones de Coordinación</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                @forelse ($documentosListosParaAval as $doc)
                                    <tr
                                        class="hover:bg-emerald-50/30 transition-colors cursor-pointer group"
                                        ondblclick="window.location.href='{{ route('certificados.show', $doc) }}'"
                                        title="Doble clic para abrir revisión documental"
                                    >
                                        <td class="py-3.5 px-4 font-bold text-gray-900">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-mono text-[10px] font-bold">
                                                    PDF
                                                </div>
                                                <span class="truncate max-w-xs group-hover:text-emerald-900 transition-colors" title="{{ $doc->nombre_documento }}">{{ $doc->nombre_documento }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            @if ($doc->proyectos->isNotEmpty())
                                                #{{ $doc->proyectos->first()->codigo_proyecto }} &bull; {{ Str::limit($doc->proyectos->first()->nombre_proyecto, 26) }}
                                            @else
                                                <span class="text-gray-400 italic">Sin proyecto</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap font-medium text-gray-800">
                                            {{ $doc->proyectos->first()?->tutor?->nombre_completo ?? 'Sin tutor' }}
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1 w-fit">
                                                <span>✓</span> Aprobado por Tutor
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500 max-w-xs text-[11px] truncate">
                                            {{ $doc->observaciones ?: 'Dictamen técnico favorable emitido por el tutor.' }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <!-- Emitir Aval y Enviar a UPS (Cambio de estado directo a aval_carrera) -->
                                                <form method="POST" action="{{ route('coordinador.aval', $doc) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="accion" value="aval">
                                                    <input type="hidden" name="observaciones" value="Aval Académico institucional otorgado. Remitido formalmente a la Unidad de Proyección Social (UPS).">
                                                    <button
                                                        type="submit"
                                                        class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[11px] rounded-xl transition-all shadow-2xs cursor-pointer inline-flex items-center gap-1"
                                                        title="Emitir Aval Académico y trasladar estado a UPS"
                                                    >
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Emitir Aval &rarr; UPS</span>
                                                    </button>
                                                </form>

                                                <!-- Ver PDF -->
                                                <a
                                                    href="{{ $doc->url_documento }}"
                                                    target="_blank"
                                                    class="p-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg transition-colors inline-flex items-center"
                                                    title="Ver documento"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                <!-- Descargar -->
                                                <a
                                                    href="{{ $doc->url_documento }}"
                                                    download
                                                    class="p-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg transition-colors inline-flex items-center"
                                                    title="Descargar documento PDF"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>

                                                <!-- Revisión Documental -->
                                                <a
                                                    href="{{ route('certificados.show', $doc) }}"
                                                    class="px-2 py-1 bg-red-50 hover:bg-[#8B1D2D] hover:text-white text-[#8B1D2D] font-bold text-[11px] rounded-lg transition-all inline-flex items-center gap-1"
                                                    title="Abrir revisión documental detallada"
                                                >
                                                    <span>Revisar</span>
                                                </a>

                                                <!-- Devolver con observaciones -->
                                                <button
                                                    type="button"
                                                    onclick="openCoordObservarModal({{ $doc->id_documento }}, '{{ addslashes($doc->nombre_documento) }}')"
                                                    class="px-2 py-1 bg-white hover:bg-red-50 text-red-700 border border-red-200 font-semibold text-[11px] rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1"
                                                    title="Devolver con observaciones"
                                                >
                                                    <span>Devolver</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-400 bg-white">
                                            <p class="font-bold text-gray-600 text-xs">No hay expedientes pendientes de aval en este momento</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5">Los tutores deben emitir primero su dictamen técnico favorable para habilitar el aval de carrera.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- B. TABLA DE EXPEDIENTES EN SEGUIMIENTO (PENDIENTES DE REVISIÓN DEL TUTOR Y OBSERVADOS) -->
                @if ($documentosEnSeguimiento->isNotEmpty())
                    <div class="border-t border-gray-100">
                        <div class="px-5 py-3 bg-amber-50/40 border-b border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-950 flex items-center gap-1.5 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Prioridad 2: Expedientes en Seguimiento &bull; Pendientes de Revisión del Tutor u Observados ({{ $documentosEnSeguimiento->count() }})
                            </span>
                            <span class="text-[11px] text-amber-800 font-medium hidden sm:inline">Esperando dictamen técnico del tutor antes del aval</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/40 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                        <th class="py-2.5 px-4">Documento</th>
                                        <th class="py-2.5 px-4">Proyecto</th>
                                        <th class="py-2.5 px-4">Docente Tutor</th>
                                        <th class="py-2.5 px-4">Estado</th>
                                        <th class="py-2.5 px-4">Observaciones / Motivo</th>
                                        <th class="py-2.5 px-4 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                                    @foreach ($documentosEnSeguimiento as $docSeg)
                                        <tr
                                            class="hover:bg-gray-50/60 transition-colors cursor-pointer"
                                            ondblclick="window.location.href='{{ route('certificados.show', $docSeg) }}'"
                                            title="Doble clic para abrir revisión documental"
                                        >
                                            <td class="py-3 px-4 font-bold text-gray-900 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-gray-400 font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-gray-100">PDF</span>
                                                    <span>{{ $docSeg->nombre_documento }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 whitespace-nowrap text-gray-600">
                                                @if ($docSeg->proyectos->isNotEmpty())
                                                    #{{ $docSeg->proyectos->first()->codigo_proyecto }} &bull; {{ Str::limit($docSeg->proyectos->first()->nombre_proyecto, 24) }}
                                                @else
                                                    <span class="text-gray-400 italic">Sin proyecto</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 whitespace-nowrap text-gray-700 font-medium">
                                                {{ $docSeg->proyectos->first()?->tutor?->nombre_completo ?? 'Sin tutor asignado' }}
                                            </td>
                                            <td class="py-3 px-4 whitespace-nowrap">
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $docSeg->estado_revision_badge }}">
                                                    {{ $docSeg->estado_revision_texto }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-gray-500 max-w-xs text-[11px] truncate">
                                                {{ $docSeg->observaciones ?: ($docSeg->motivo_rechazo ?: 'En espera de dictamen técnico del tutor.') }}
                                            </td>
                                            <td class="py-3 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <a
                                                        href="{{ $docSeg->url_documento }}"
                                                        target="_blank"
                                                        class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                        title="Ver PDF"
                                                    >
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a
                                                        href="{{ $docSeg->url_documento }}"
                                                        download
                                                        class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                        title="Descargar PDF"
                                                    >
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                    </a>
                                                    <a
                                                        href="{{ route('certificados.show', $docSeg) }}"
                                                        class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-[11px] rounded-lg transition-colors"
                                                        title="Revisar expediente"
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
                @endif

                <!-- C. DESPLEGABLE OCULTO: EXPEDIENTES YA AVALADOS Y ENVIADOS A UPS (VER MÁS) -->
                @if ($documentosAvaladosEnUPS->isNotEmpty())
                    <div class="border-t border-gray-100 bg-gray-50/50">
                        <button
                            type="button"
                            onclick="toggleExpedientesAvalados()"
                            id="btnToggleAvalados"
                            class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-100/70 transition-colors cursor-pointer group"
                            aria-expanded="false"
                        >
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">
                                    ✓
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-gray-800 group-hover:text-indigo-950">
                                        Ver más: Expedientes ya avalados y remitidos a UPS ({{ $documentosAvaladosEnUPS->count() }})
                                    </span>
                                    <p class="text-[11px] text-gray-400">Expedientes con aval académico formal remitidos a la Unidad de Proyección Social</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-gray-500 group-hover:text-gray-800" id="textoToggleAvalados">
                                    Mostrar avalados
                                </span>
                                <svg id="iconToggleAvalados" class="w-4 h-4 text-gray-400 group-hover:text-gray-700 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>

                        <div id="contenedorExpedientesAvalados" class="hidden border-t border-gray-200/80 bg-white">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="border-b border-gray-100 bg-indigo-50/30 text-indigo-900 font-semibold uppercase tracking-wider text-[10px]">
                                            <th class="py-2.5 px-4">Documento</th>
                                            <th class="py-2.5 px-4">Proyecto</th>
                                            <th class="py-2.5 px-4">Tutor</th>
                                            <th class="py-2.5 px-4">Estado en UPS</th>
                                            <th class="py-2.5 px-4">Observaciones Institucionales</th>
                                            <th class="py-2.5 px-4 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-gray-700">
                                        @foreach ($documentosAvaladosEnUPS as $docAval)
                                            <tr
                                                class="hover:bg-gray-50/60 transition-colors cursor-pointer"
                                                ondblclick="window.location.href='{{ route('certificados.show', $docAval) }}'"
                                                title="Doble clic para abrir revisión documental"
                                            >
                                                <td class="py-3 px-4 font-bold text-gray-900 whitespace-nowrap">
                                                    {{ $docAval->nombre_documento }}
                                                </td>
                                                <td class="py-3 px-4 whitespace-nowrap text-gray-600">
                                                    @if ($docAval->proyectos->isNotEmpty())
                                                        #{{ $docAval->proyectos->first()->codigo_proyecto }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 whitespace-nowrap text-gray-600">
                                                    {{ $docAval->proyectos->first()?->tutor?->nombre_completo ?? '-' }}
                                                </td>
                                                <td class="py-3 px-4 whitespace-nowrap">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $docAval->estado_revision_badge }}">
                                                        {{ $docAval->estado_revision_texto }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-gray-500 max-w-xs text-[11px] truncate">
                                                    {{ $docAval->observaciones ?: 'Aval institucional otorgado.' }}
                                                </td>
                                                <td class="py-3 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation();">
                                                    <div class="flex items-center justify-center gap-1.5">
                                                        <a
                                                            href="{{ $docAval->url_documento }}"
                                                            target="_blank"
                                                            class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                            title="Ver PDF"
                                                        >
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        <a
                                                            href="{{ $docAval->url_documento }}"
                                                            download
                                                            class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors inline-flex items-center"
                                                            title="Descargar PDF"
                                                        >
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                        </a>
                                                        <a
                                                            href="{{ route('certificados.show', $docAval) }}"
                                                            class="px-2 py-1 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-semibold text-[11px] rounded-lg transition-colors"
                                                            title="Revisar expediente"
                                                        >
                                                            Revisar
                                                        </a>
                                                        @if ($docAval->estado_revision === 'aval_carrera')
                                                            <form method="POST" action="{{ route('coordinador.aval', $docAval) }}" class="inline">
                                                                @csrf
                                                                <input type="hidden" name="accion" value="retractar">
                                                                <button
                                                                    type="submit"
                                                                    onclick="return confirm('¿Retractar Aval Académico y devolver el documento a aprobación del tutor?');"
                                                                    class="px-2 py-1 bg-white hover:bg-gray-100 text-gray-600 border border-gray-200 rounded-lg text-[11px] font-semibold transition-colors cursor-pointer"
                                                                    title="Retractar aval"
                                                                >
                                                                    Retractar
                                                                </button>
                                                            </form>
                                                        @endif
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

        function toggleExpedientesAvalados() {
            const container = document.getElementById('contenedorExpedientesAvalados');
            const texto = document.getElementById('textoToggleAvalados');
            const icon = document.getElementById('iconToggleAvalados');
            if (container) {
                const isHidden = container.classList.toggle('hidden');
                if (texto) texto.textContent = isHidden ? 'Mostrar avalados' : 'Ocultar avalados';
                if (icon) icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }
    </script>
</body>
</html>
