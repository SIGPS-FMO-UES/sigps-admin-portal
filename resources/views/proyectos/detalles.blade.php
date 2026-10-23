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
                                    En Inscripción (Fase 1: Formatos F1/F2)
                                </option>
                                <option value="en_proceso" @selected(old('estado', $proyecto->estado) === 'en_proceso')>
                                    En Ejecución / Activo (Fase 2 y 3: Anteproyecto F3 y Avance F4/F5)
                                </option>
                                <option value="en_finalizacion" @selected(old('estado', $proyecto->estado) === 'en_finalizacion')>
                                    En Finalización / Cierre (Fase 4: Memoria Final F6/F7/F8)
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

                    <!-- Fila 7: Documento -->
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
