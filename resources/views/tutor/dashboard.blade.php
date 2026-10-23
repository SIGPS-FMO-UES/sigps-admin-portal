<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Docente Tutor | Sistema de Proyección Social - UES</title>

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

        <!-- CABECERA INSTITUCIONAL DEL TUTOR -->
        <header class="bg-white border-b border-gray-200/80 px-4 sm:px-8 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-blue-50 border border-blue-200 text-blue-800 rounded-full text-[10px] font-extrabold tracking-wide uppercase">
                            Acompañamiento Técnico &bull; SYS-02
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Docente Tutor UES</span>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Panel de Seguimiento y Dictamen Técnico
                    </h1>
                    <p class="text-xs sm:text-[13px] text-gray-500 mt-0.5">
                        Supervisa el avance de tus estudiantes tutorados, valida cronogramas y emite dictámenes de primer nivel.
                    </p>
                </div>

                <!-- Perfil del Docente Tutor Autenticado -->
                <div class="flex items-center gap-3 bg-gray-50/80 border border-gray-200/80 rounded-2xl px-4 py-2 self-start md:self-auto">
                    <div class="w-10 h-10 rounded-xl bg-[#8B1D2D]/10 text-[#8B1D2D] font-bold text-sm flex items-center justify-center border border-[#8B1D2D]/20 shrink-0">
                        {{ strtoupper(substr($usuario->nombre_completo ?? 'DT', 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800 leading-tight">
                            {{ $usuario->nombre_completo }}
                        </p>
                        <p class="text-[11px] text-gray-500 font-medium">
                            {{ $usuario->departamento }} &bull; <span class="font-mono text-gray-700 font-bold">{{ $usuario->nombre_usuario }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- CUERPO PRINCIPAL DEL DASHBOARD -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- MENSAJES FLASH DE ACCIÓN (ÉXITO O ADVERTENCIA) -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Acción registrada con éxito</p>
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
                        <p class="font-bold">Observación aplicada</p>
                        <p class="text-amber-700 font-medium">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            <!-- 1. TARJETAS KPI DE TUTORÍA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- KPI 1: Estudiantes a cargo -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estudiantes Asignados</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">{{ $totalEstudiantes }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Bandeja de tutela (HU-63)</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 2: Proyectos en Tutela -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyectos en Tutela</p>
                        <p class="text-3xl font-black text-[#8B1D2D] mt-1">{{ $totalProyectos }}</p>
                        <span class="text-[11px] text-gray-400 font-medium">Asignados formalmente</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 text-[#8B1D2D] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 3: Documentos Pendientes de Dictamen -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Por Dictaminar</p>
                        <p class="text-3xl font-black text-amber-600 mt-1">{{ $totalPendientes }}</p>
                        <span class="text-[11px] text-amber-600 font-medium">Primer nivel (HU-65)</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <!-- KPI 4: Plazo Normativo -->
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Plazo de Revisión</p>
                        <p class="text-3xl font-black text-emerald-600 mt-1">15 d</p>
                        <span class="text-[11px] text-gray-400 font-medium">Hábiles según RN-02</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. BANDEJA DE EXPEDIENTES Y DICTAMEN DOCUMENTAL (HU-65, HU-66, HU-67) -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">
                                Expedientes Pendientes de Dictamen Técnico (HU-65)
                            </h2>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Revisa el contenido de los documentos enviados por tus tutorados y emite tu aprobación o devolución justificada.
                        </p>
                    </div>
                    <span class="text-xs font-bold text-gray-400 font-mono">
                        {{ $documentosPendientes->count() }} documentos vinculados
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Documento</th>
                                <th class="py-3 px-4">Tipo</th>
                                <th class="py-3 px-4">Proyecto / Tutorados</th>
                                <th class="py-3 px-4">Estado de Revisión</th>
                                <th class="py-3 px-4">Observaciones / Dictamen</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($documentosPendientes as $doc)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <!-- Documento -->
                                    <td class="py-3.5 px-4 font-bold text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate max-w-xs" title="{{ $doc->nombre_documento }}">{{ $doc->nombre_documento }}</span>
                                        </div>
                                    </td>

                                    <!-- Tipo -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 bg-gray-100 rounded text-[10px] font-bold text-gray-700 uppercase">
                                            {{ $doc->tipo }}
                                        </span>
                                    </td>

                                    <!-- Proyecto vinculado -->
                                    <td class="py-3.5 px-4">
                                        @if ($doc->proyectos->isNotEmpty())
                                            @php $proy = $doc->proyectos->first(); @endphp
                                            <p class="font-bold text-gray-900 leading-tight">#{{ $proy->codigo_proyecto }} &bull; {{ Str::limit($proy->nombre_proyecto, 30) }}</p>
                                            <p class="text-[11px] text-gray-400">
                                                {{ $proy->alumnos->pluck('nombre_completo')->join(', ') ?: 'Sin estudiantes asociados' }}
                                            </p>
                                        @else
                                            <span class="text-gray-400 italic">Sin proyecto</span>
                                        @endif
                                    </td>

                                    <!-- Estado de Revisión -->
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $doc->estado_revision_badge }}">
                                            {{ $doc->estado_revision_texto }}
                                        </span>
                                    </td>

                                    <!-- Observaciones -->
                                    <td class="py-3.5 px-4 text-gray-500 max-w-xs text-[11px]">
                                        {{ $doc->observaciones ?: 'Sin observaciones registradas' }}
                                    </td>

                                    <!-- Acciones de Dictamen -->
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Ver / Descargar PDF -->
                                            <a
                                                href="{{ $doc->url_documento }}"
                                                target="_blank"
                                                class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-[11px] rounded-lg transition-colors inline-flex items-center gap-1"
                                                title="Ver PDF en navegador"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>Ver</span>
                                            </a>

                                            <!-- Formulario Aprobar (HU-66) -->
                                            <form method="POST" action="{{ route('tutor.dictamen', $doc) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="accion" value="aprobar">
                                                <button
                                                    type="submit"
                                                    class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[11px] rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1 shadow-2xs"
                                                    title="Aprobar documento y enviar a Coordinación de Carrera"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Aprobar</span>
                                                </button>
                                            </form>

                                            <!-- Botón Modal Observar (HU-67) -->
                                            <button
                                                type="button"
                                                onclick="openObservarModal({{ $doc->id_documento }}, '{{ addslashes($doc->nombre_documento) }}')"
                                                class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-semibold text-[11px] rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1"
                                                title="Observar o rechazar con motivo justificado"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>Observar</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        <p class="font-bold text-gray-600">No hay documentos pendientes de revisión</p>
                                        <p class="text-xs mt-1">Todos los expedientes de tus proyectos tutelados se encuentran dictaminados o en etapa posterior.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. BANDEJA DE ESTUDIANTES ASIGNADOS (HU-63) -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xs overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">
                                Bandeja de Estudiantes Formalmente Asignados (HU-63)
                            </h2>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Consulta la nómina de estudiantes bajo tu supervisión directa, avance de horas y proyectos vinculados.
                        </p>
                    </div>
                    <span class="text-xs font-bold text-gray-400 font-mono">
                        {{ $estudiantes->count() }} alumnos asignados
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Carnet</th>
                                <th class="py-3 px-4">Nombre del Alumno</th>
                                <th class="py-3 px-4">Carrera</th>
                                <th class="py-3 px-4">Proyecto Asignado</th>
                                <th class="py-3 px-4">Estado del Proceso</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($estudiantes as $est)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#8B1D2D] whitespace-nowrap">
                                        {{ $est->nombre_usuario }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">
                                        {{ $est->nombre_completo }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600">
                                        {{ $est->carrera }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($est->proyecto_asignado)
                                            <span class="font-bold text-gray-800">#{{ $est->proyecto_asignado->codigo_proyecto }}</span>
                                            <span class="text-gray-500">&bull; {{ Str::limit($est->proyecto_asignado->nombre_proyecto, 35) }}</span>
                                        @else
                                            <span class="text-gray-400 italic">Sin proyecto</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @php
                                            $estado = $est->proyecto_asignado?->estado ?? 'en_proceso';
                                            $badgeClass = match($estado) {
                                                'finalizado' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'en_proceso' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'en_inscripcion' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                default => 'bg-amber-50 text-amber-700 border-amber-200',
                                            };
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $estado)) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        @if ($est->proyecto_asignado)
                                            <a
                                                href="{{ route('proyectos.show', $est->proyecto_asignado) }}"
                                                class="px-3 py-1 bg-gray-100 hover:bg-[#8B1D2D] hover:text-white text-gray-700 rounded-lg text-[11px] font-semibold transition-colors cursor-pointer inline-flex items-center gap-1"
                                                title="Ver expediente del proyecto"
                                            >
                                                <span>Expediente</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        <p class="font-bold text-gray-600">No hay estudiantes asignados formalmente</p>
                                        <p class="text-xs mt-1">El Coordinador de Carrera aún no ha vinculado estudiantes bajo tu tutela.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. GUÍAS Y FORMATOS OFICIALES PARA EL TUTOR (RF-ACA-04) -->
            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-3xl p-6 text-white shadow-md">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-0.5 bg-white/10 rounded-md text-[10px] font-bold tracking-wide uppercase text-rose-200">
                            Reglamento de Proyección Social UES
                        </span>
                        <h3 class="text-base font-bold text-white mt-1">
                            Plantillas y Formatos Oficiales de Supervisión (F1 a F8)
                        </h3>
                        <p class="text-xs text-gray-300 max-w-2xl mt-0.5">
                            Coteja los planes de trabajo, informes de avance al 50% y memorias finales con los formatos normativos institucionales.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a
                            href="{{ route('estudiante.formatos') }}"
                            class="px-4 py-2 bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs rounded-xl transition-colors cursor-pointer inline-flex items-center gap-1.5 shadow-sm"
                        >
                            <svg class="w-4 h-4 text-[#8B1D2D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Descargar Formatos F1-F8</span>
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL INTERACTIVO PARA OBSERVAR DOCUMENTO (HU-67) -->
    <div id="observarModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-2xl max-w-lg w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900">Registrar Observaciones (HU-67)</h3>
                        <p class="text-[11px] text-gray-500" id="observarDocTitulo">Documento</p>
                    </div>
                </div>
                <button type="button" onclick="closeObservarModal()" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="observarForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="accion" value="observar">

                <div>
                    <label for="observacionesTextarea" class="block text-xs font-bold text-gray-700 mb-1">
                        Motivo de observación / Correcciones requeridas <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="observacionesTextarea"
                        name="observaciones"
                        rows="4"
                        required
                        placeholder="Describe los aspectos técnicos, cronograma o formularios que el alumno debe corregir antes de aprobar..."
                        class="w-full p-3 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-[#8B1D2D] focus:ring-1 focus:ring-[#8B1D2D]/30"
                    ></textarea>
                    <p class="text-[11px] text-gray-400 mt-1">El alumno recibirá esta notificación directamente en su portal de observaciones.</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button
                        type="button"
                        onclick="closeObservarModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-[#8B1D2D] hover:bg-[#721523] text-white font-bold text-xs rounded-xl shadow-sm transition-all cursor-pointer"
                    >
                        Confirmar y Devolver Documento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT PARA EL MODAL DE OBSERVACIONES -->
    <script>
        function openObservarModal(docId, docTitulo) {
            const modal = document.getElementById('observarModal');
            const form = document.getElementById('observarForm');
            const titulo = document.getElementById('observarDocTitulo');

            form.action = `/tutor/documentos/${docId}/dictamen`;
            titulo.textContent = docTitulo;
            modal.classList.remove('hidden');
        }

        function closeObservarModal() {
            document.getElementById('observarModal').classList.add('hidden');
        }
    </script>
</body>
</html>
