<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EstudiantePortalController extends Controller
{
    /**
     * Dashboard personalizado del estudiante: muestra el avance del proceso,
     * horas acumuladas, fase actual, plazos y accesos a sus actividades.
     */
    public function dashboard(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['roles', 'proyectosComoAlumno.tutor', 'proyectosComoAlumno.documentos', 'proyectosComoAlumno.alumnos']);

        $proyecto = $usuario->proyectosComoAlumno()->with([
            'tutor',
            'documentos' => fn ($q) => $q->orderBy('id_documento', 'desc'),
            'alumnos',
        ])->first();

        // Si es administrador o coordinador navegando a esta vista para pruebas, usar el primer proyecto existente
        if (! $proyecto && ($usuario->hasRole('Administrador') || $usuario->can('crear_proyectos'))) {
            $proyecto = Proyecto::with([
                'tutor',
                'documentos' => fn ($q) => $q->orderBy('id_documento', 'desc'),
                'alumnos',
            ])->first();
        }

        // Fases del proceso de Proyección Social en la UES
        $fases = [
            1 => [
                'numero' => 1,
                'nombre' => 'Inscripción y Solicitud',
                'codigo_formato' => 'F1 / F2',
                'descripcion' => 'Registro de datos personales y validación inicial de la solicitud.',
                'tipo_doc' => 'solicitud',
            ],
            2 => [
                'numero' => 2,
                'nombre' => 'Anteproyecto Aprobado',
                'codigo_formato' => 'F3',
                'descripcion' => 'Plan de trabajo, objetivos y cronograma consensuado con el tutor.',
                'tipo_doc' => 'anteproyecto',
            ],
            3 => [
                'numero' => 3,
                'nombre' => 'Ejecución y Control 50%',
                'codigo_formato' => 'F4 / F5',
                'descripcion' => 'Registro de asistencias y entrega de informe de avance al 50%.',
                'tipo_doc' => 'mitad_proyecto',
            ],
            4 => [
                'numero' => 4,
                'nombre' => 'Memoria Final y Evaluación',
                'codigo_formato' => 'F6 / F7 / F8',
                'descripcion' => 'Memoria técnica, evaluación de contraparte y finiquito de horas.',
                'tipo_doc' => 'memoria',
            ],
            5 => [
                'numero' => 5,
                'nombre' => 'Certificación Emitida',
                'codigo_formato' => 'Certificado UPS',
                'descripcion' => 'Aprobación definitiva y entrega de constancia oficial por la UPS.',
                'tipo_doc' => 'certificado',
            ],
        ];

        if ($proyecto) {
            $proyecto->actualizarEstadoAutomatico();
        }

        $documentos = $proyecto ? $proyecto->documentos : collect();
        $tiposSubidos = $documentos->pluck('tipo')->all();

        // Determinar documentos por etapa
        $docFase1 = $documentos->first(fn ($d) => in_array($d->tipo, ['solicitud', 'inscripcion'], true));
        $docFase2 = $documentos->firstWhere('tipo', 'anteproyecto');
        $docFase3 = $documentos->firstWhere('tipo', 'mitad_proyecto');
        $docFase4 = $documentos->firstWhere('tipo', 'memoria');
        $docFase5 = $documentos->first(fn ($d) => $d->tipo === 'certificado' || $d->folio !== null);

        $estadoProy = $proyecto?->estado ?? 'solicitado';

        $fase1Completada = ($docFase1 && $docFase1->isAprobado())
            || in_array($estadoProy, ['en_proceso', 'en_finalizacion', 'finalizado'], true)
            || ($docFase2 && $docFase2->isAprobado());

        $fase2Completada = ($docFase2 && $docFase2->isAprobado())
            || in_array($estadoProy, ['en_finalizacion', 'finalizado'], true)
            || ($docFase3 && $docFase3->isAprobado());

        $fase3Completada = ($docFase3 && $docFase3->isAprobado())
            || in_array($estadoProy, ['en_finalizacion', 'finalizado'], true)
            || ($docFase4 && $docFase4->isAprobado());

        $fase4Completada = ($docFase4 && $docFase4->isAprobado())
            || $estadoProy === 'finalizado'
            || ($docFase5 && in_array($docFase5->estado_revision, ['certificado_emitido', 'auditado_ups'], true));

        $fase5Completada = $estadoProy === 'finalizado'
            || ($docFase5 && in_array($docFase5->estado_revision, ['certificado_emitido', 'auditado_ups'], true));

        $completadas = [
            1 => $fase1Completada,
            2 => $fase2Completada,
            3 => $fase3Completada,
            4 => $fase4Completada,
            5 => $fase5Completada,
        ];

        // Determinar fase actual (primera fase que no está completada)
        $faseActual = 1;
        foreach ($completadas as $num => $isComp) {
            if (! $isComp) {
                $faseActual = $num;
                break;
            }
            $faseActual = 5;
        }

        // Si la fase 5 ya está completada, el proyecto está finalizado
        if ($fase5Completada) {
            $faseActual = 5;
        }

        // Calcular horas acumuladas y avance reglamentario
        $horasAcumuladas = 0;
        $horasRequeridas = 500;

        if ($fase5Completada || $estadoProy === 'finalizado') {
            $horasAcumuladas = 500;
        } elseif ($fase4Completada || $estadoProy === 'en_finalizacion') {
            $horasAcumuladas = 450;
        } elseif ($fase3Completada) {
            $horasAcumuladas = 250;
        } elseif ($fase2Completada || $estadoProy === 'en_proceso') {
            $horasAcumuladas = 150;
        } elseif ($fase1Completada || $estadoProy === 'en_inscripcion') {
            $horasAcumuladas = 50;
        } else {
            $horasAcumuladas = 0;
        }

        $porcentajeAvance = min(100, (int) round(($horasAcumuladas / $horasRequeridas) * 100));

        // Enriquecer el array de fases con el estado real de avance para la visualización del alumno
        $faseDocs = [
            1 => $docFase1,
            2 => $docFase2,
            3 => $docFase3,
            4 => $docFase4,
            5 => $docFase5,
        ];

        foreach ($fases as $num => &$fase) {
            $fase['completada'] = $completadas[$num];
            $fase['actual'] = ($num === $faseActual && ! ($num === 5 && $fase5Completada));
            $docAsoc = $faseDocs[$num];
            $fase['doc'] = $docAsoc;

            if ($fase['completada']) {
                $fase['badge_estado'] = 'Completada';
                $fase['badge_tipo'] = 'completada';
            } elseif ($fase['actual']) {
                if ($docAsoc && $docAsoc->isObservado()) {
                    $fase['badge_estado'] = 'Observado - Corrección';
                    $fase['badge_tipo'] = 'observado';
                } elseif ($docAsoc && $docAsoc->isPendiente()) {
                    $fase['badge_estado'] = 'En Revisión Tutor';
                    $fase['badge_tipo'] = 'pendiente';
                } else {
                    $fase['badge_estado'] = 'Fase Actual';
                    $fase['badge_tipo'] = 'actual';
                }
            } else {
                $fase['badge_estado'] = 'Pendiente';
                $fase['badge_tipo'] = 'inactiva';
            }
        }
        unset($fase);

        // Plazos estimados del proceso
        $plazosEstudiante = [
            [
                'actividad' => 'Entrega de Informe de Avance (50% de Horas)',
                'fecha_limite' => '15 de Mayo de 2026',
                'estado' => $fase3Completada ? 'Completado' : (in_array('mitad_proyecto', $tiposSubidos, true) ? 'En Revisión' : 'Pendiente'),
                'dias_restantes' => 12,
            ],
            [
                'actividad' => 'Cierre de Horas y Entrega de Memoria Final',
                'fecha_limite' => $proyecto?->fecha_fin ?? '30 de Julio de 2026',
                'estado' => $fase4Completada ? 'Completado' : (in_array('memoria', $tiposSubidos, true) ? 'En Revisión' : 'Pendiente'),
                'dias_restantes' => 45,
            ],
        ];

        return view('estudiante.dashboard', [
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'fases' => $fases,
            'faseActual' => $faseActual,
            'horasAcumuladas' => $horasAcumuladas,
            'horasRequeridas' => $horasRequeridas,
            'porcentajeAvance' => $porcentajeAvance,
            'documentos' => $documentos,
            'tiposSubidos' => $tiposSubidos,
            'plazosEstudiante' => $plazosEstudiante,
        ]);
    }

    /**
     * Muestra la vista de Mi Proyecto y expedientes para el estudiante autenticado.
     */
    public function miProyecto(Request $request): View
    {
        return $this->cargarDatosProyectoView($request, 'mi-proyecto');
    }

    /**
     * Muestra la vista dedicada a Subir Documento para el estudiante autenticado.
     */
    public function subirDocumentoView(Request $request): View
    {
        return $this->cargarDatosProyectoView($request, 'subir-documento');
    }

    /**
     * Obtiene los datos del proyecto y documentos para renderizar la vista de estudiante.
     */
    private function cargarDatosProyectoView(Request $request, string $active): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['roles', 'proyectosComoAlumno.tutor', 'proyectosComoAlumno.documentos']);

        $proyecto = $usuario->proyectosComoAlumno()->with(['tutor', 'documentos', 'alumnos'])->first();

        if (! $proyecto && ($usuario->hasRole('Administrador') || $usuario->can('crear_proyectos'))) {
            $proyecto = Proyecto::with(['tutor', 'documentos', 'alumnos'])->first();
        }

        $documentos = $proyecto
            ? $proyecto->documentos()->orderBy('id_documento', 'desc')->get()
            : collect();

        $tipos = [
            'solicitud' => 'Solicitud de Proyecto',
            'inscripcion' => 'Ficha de Inscripción',
            'anteproyecto' => 'Anteproyecto Aprobado',
            'mitad_proyecto' => 'Informe Mitad de Proyecto (50%)',
            'memoria' => 'Memoria Final de Horas Sociales',
            'otro' => 'Otro Documento / Anexo',
        ];

        return view('estudiante.proyecto', [
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'documentos' => $documentos,
            'tipos' => $tipos,
            'active' => $active,
        ]);
    }

    /**
     * Muestra los formatos y guías oficiales institucionales (F1 a F8) para su descarga y consulta.
     */
    public function formatos(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        $formatos = [
            [
                'codigo' => 'F1',
                'nombre' => 'Ficha de Solicitud e Inscripción de Proyecto',
                'descripcion' => 'Formato oficial para postularse e inscribir formalmente el proyecto de servicio social ante la coordinación.',
                'fase' => 'Fase 1: Inscripción',
                'archivo' => 'F1-Solicitud-Inscripcion.pdf',
            ],
            [
                'codigo' => 'F2',
                'nombre' => 'Carta de Aceptación Institucional',
                'descripcion' => 'Modelo formal expedido por la institución contraparte que acoge al estudiante para sus horas sociales.',
                'fase' => 'Fase 1: Inscripción',
                'archivo' => 'F2-Carta-Aceptacion.pdf',
            ],
            [
                'codigo' => 'F3',
                'nombre' => 'Plan de Trabajo y Cronograma de Actividades',
                'descripcion' => 'Matriz de metas semanales, entregables y cronograma acordado con el docente tutor asignado.',
                'fase' => 'Fase 2: Anteproyecto',
                'archivo' => 'F3-Plan-Trabajo-Cronograma.pdf',
            ],
            [
                'codigo' => 'F4',
                'nombre' => 'Hoja de Control de Asistencia y Registro de Horas',
                'descripcion' => 'Bitácora oficial de registro diario de horas con firma y sello del responsable supervisor en campo.',
                'fase' => 'Fase 3: Ejecución',
                'archivo' => 'F4-Control-Asistencia-Horas.pdf',
            ],
            [
                'codigo' => 'F5',
                'nombre' => 'Informe de Avance del 50 % de Horas Sociales',
                'descripcion' => 'Plantilla estructurada para reportar las actividades y evidencias acumuladas al alcanzar 250 horas.',
                'fase' => 'Fase 3: Ejecución',
                'archivo' => 'F5-Informe-Avance-50.pdf',
            ],
            [
                'codigo' => 'F6',
                'nombre' => 'Evaluación de Desempeño del Tutor Institucional',
                'descripcion' => 'Rúbrica de evaluación emitida por la contraparte institucional al finalizar el servicio.',
                'fase' => 'Fase 4: Finalización',
                'archivo' => 'F6-Evaluacion-Desempeno.pdf',
            ],
            [
                'codigo' => 'F7',
                'nombre' => 'Constancia de Finiquito y Cierre de Horas',
                'descripcion' => 'Constancia formal que acredita el cumplimiento satisfactorio del 100% de las horas requeridas.',
                'fase' => 'Fase 4: Finalización',
                'archivo' => 'F7-Finiquito-Horas.pdf',
            ],
            [
                'codigo' => 'F8',
                'nombre' => 'Guía de Estructura de Memoria Final de Servicio Social',
                'descripcion' => 'Directrices oficiales de formato, capítulos, anexos y empaste digital de la memoria final consolidada.',
                'fase' => 'Fase 4: Finalización',
                'archivo' => 'F8-Guia-Memoria-Final.pdf',
            ],
        ];

        return view('estudiante.formatos', [
            'usuario' => $usuario,
            'formatos' => $formatos,
        ]);
    }

    /**
     * Muestra el historial de dictámenes, observaciones y revisiones emitidas por el tutor o coordinador.
     */
    public function observaciones(): View
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load(['proyectosComoAlumno.tutor', 'proyectosComoAlumno.documentos']);

        $proyecto = $usuario->proyectosComoAlumno()->with([
            'tutor',
            'documentos' => fn ($q) => $q->orderBy('id_documento', 'desc'),
        ])->first();

        if (! $proyecto && ($usuario->hasRole('Administrador') || $usuario->can('crear_proyectos'))) {
            $proyecto = Proyecto::with([
                'tutor',
                'documentos' => fn ($q) => $q->orderBy('id_documento', 'desc'),
            ])->first();
        }

        return view('estudiante.observaciones', [
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'documentos' => $proyecto ? $proyecto->documentos : collect(),
        ]);
    }

    /**
     * Procesa la subida de un archivo exclusivamente en formato PDF.
     * Guarda el archivo en almacenamiento local público y genera la URL para visualización en navegador.
     */
    public function subirDocumento(Request $request): RedirectResponse
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        $validated = $request->validate([
            'nombre_documento' => ['required', 'string', 'max:255'],
            'tipo' => [
                'required',
                'string',
                'in:solicitud,inscripcion,anteproyecto,mitad_proyecto,memoria,otro',
            ],
            'archivo_pdf' => [
                'required',
                'file',
                'mimes:pdf',
                'mimetypes:application/pdf',
                'max:20480', // Máx 20MB
            ],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
        ], [
            'nombre_documento.required' => 'El título o nombre del documento es obligatorio.',
            'tipo.required' => 'Debes seleccionar el tipo de documento.',
            'tipo.in' => 'El tipo de documento seleccionado no es válido.',
            'archivo_pdf.required' => 'Debes adjuntar un archivo para subir.',
            'archivo_pdf.file' => 'El archivo proporcionado no es válido.',
            'archivo_pdf.mimes' => 'El archivo debe ser exclusivamente en formato PDF (.pdf).',
            'archivo_pdf.mimetypes' => 'El archivo debe ser un documento PDF válido.',
            'archivo_pdf.max' => 'El archivo PDF no debe exceder los 20 megabytes (MB).',
        ]);

        $proyecto = null;
        if (! empty($validated['id_proyecto'])) {
            $proyecto = Proyecto::find($validated['id_proyecto']);
        }

        if (! $proyecto) {
            $proyecto = $usuario->proyectosComoAlumno()->first();
        }

        if (! $proyecto && ($usuario->hasRole('Administrador') || $usuario->can('crear_proyectos'))) {
            $proyecto = Proyecto::first();
        }

        if (! $proyecto) {
            return back()->withErrors([
                'archivo_pdf' => 'No tienes un proyecto de proyección social asociado para subir documentos.',
            ]);
        }

        $file = $request->file('archivo_pdf');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanSlug = Str::slug($originalName);
        $filename = time().'_'.($cleanSlug ?: 'documento').'.pdf';

        $storedPath = $file->storeAs('documentos', $filename, 'public');

        $urlGenerada = Storage::disk('public')->url($storedPath);

        // Calcular la versión correlativa del documento para este tipo dentro del proyecto
        $versionActual = $proyecto->documentos()->where('tipo', $validated['tipo'])->count() + 1;

        $documento = Documento::create([
            'nombre_documento' => trim($validated['nombre_documento']),
            'url_documento' => $urlGenerada,
            'tipo' => $validated['tipo'],
            'version' => $versionActual,
            'fecha_entrega' => now(),
            'estado_revision' => 'pendiente_tutor',
            'observaciones' => null,
            'motivo_rechazo' => null,
        ]);

        DocumentosProyecto::firstOrCreate([
            'id_proyecto' => $proyecto->id_proyecto,
            'id_documento' => $documento->id_documento,
        ]);

        $proyecto->actualizarEstadoAutomatico();

        return redirect()->route('estudiante.proyecto')->with(
            'success',
            "El archivo PDF '{$documento->nombre_documento}' (Versión {$versionActual}) fue subido con éxito y ya está disponible para visualización y dictamen del tutor."
        );
    }
}
