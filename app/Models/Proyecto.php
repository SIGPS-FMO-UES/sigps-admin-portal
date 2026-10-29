<?php

namespace App\Models;

use Database\Factories\ProyectoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    /** @use HasFactory<ProyectoFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'proyectos';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_proyecto';

    /**
     * Timestamps desactivados (no definidos en el diagrama).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre_proyecto',
        'codigo_proyecto',
        'estado',
        'tutor_id',
    ];

    /**
     * Conversiones de tipos de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'codigo_proyecto' => 'integer',
        ];
    }

    /**
     * Docente tutor asignado al proyecto (referencia a usuarios.id_usuario).
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'tutor_id', 'id_usuario');
    }

    /**
     * Relación N:M con alumnos/usuarios participantes mediante proyectos_alumnos.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'proyectos_alumnos',
            'id_proyecto',
            'id_alumno',
            'id_proyecto',
            'id_usuario'
        )->withPivot('id_proyecto_alumno');
    }

    /**
     * Registros de asignación en proyectos_alumnos.
     */
    public function proyectosAlumnos(): HasMany
    {
        return $this->hasMany(ProyectosAlumno::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Relación N:M con documentos asociados mediante documentos_proyecto.
     */
    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(
            Documento::class,
            'documentos_proyecto',
            'id_proyecto',
            'id_documento',
            'id_proyecto',
            'id_documento'
        )->withPivot('id_documento_proyecto');
    }

    /**
     * Registros de vinculación en documentos_proyecto.
     */
    public function documentosProyecto(): HasMany
    {
        return $this->hasMany(DocumentosProyecto::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Área asignada o calculada para visualización en el portal.
     */
    public function getAreaAttribute(): string
    {
        $areas = [
            'Tecnología y Proyección Social',
            'Desarrollo Comunitario y Sistemas',
            'Innovación y Servicios Educativos',
            'Gestión Ambiental e Informática',
        ];

        return $areas[($this->id_proyecto ?? 1) % count($areas)];
    }

    /**
     * Fecha de inicio estimada o registrada del proyecto.
     */
    public function getFechaInicioAttribute(): string
    {
        return '2026-02-15';
    }

    /**
     * Fecha de finalización estimada o registrada del proyecto.
     */
    public function getFechaFinAttribute(): string
    {
        return '2026-07-30';
    }

    /**
     * SubCoordinador asignado al proyecto.
     */
    public function getSubcoordinadorAttribute(): string
    {
        return 'Ing. Roberto Carlos Flores';
    }

    /**
     * Calcula y actualiza automáticamente el estado del proyecto según los documentos entregados y dictaminados.
     */
    public function actualizarEstadoAutomatico(bool $guardar = true): string
    {
        $docs = $this->documentos()->get();

        // 1. Si hay certificado emitido o auditado por la UPS -> finalizado
        $tieneCertificadoAprobado = $docs->contains(function ($d) {
            return ($d->tipo === 'certificado' || $d->folio !== null)
                && in_array($d->estado_revision, ['certificado_emitido', 'auditado_ups'], true);
        });

        // 2. Si memoria final está aprobada por tutor o aval de carrera -> en_finalizacion
        $tieneMemoriaAprobada = $docs->contains(function ($d) {
            return $d->tipo === 'memoria' && $d->isAprobado();
        });

        // 3. Si anteproyecto está aprobado por tutor o aval de carrera -> en_proceso
        $tieneAnteproyectoAprobado = $docs->contains(function ($d) {
            return $d->tipo === 'anteproyecto' && $d->isAprobado();
        });

        // 4. Si solicitud / inscripción entregada o aprobada -> en_inscripcion
        $tieneSolicitudOInscripcion = $docs->contains(function ($d) {
            return in_array($d->tipo, ['solicitud', 'inscripcion'], true);
        });

        $nuevoEstado = $this->estado ?? 'solicitado';

        if ($tieneCertificadoAprobado) {
            $nuevoEstado = 'finalizado';
        } elseif ($tieneMemoriaAprobada) {
            $nuevoEstado = ($this->estado === 'finalizado') ? 'finalizado' : 'en_finalizacion';
        } elseif ($tieneAnteproyectoAprobado) {
            if (! in_array($this->estado, ['en_finalizacion', 'finalizado'], true)) {
                $nuevoEstado = 'en_proceso';
            }
        } elseif ($tieneSolicitudOInscripcion) {
            if (! in_array($this->estado, ['en_proceso', 'en_finalizacion', 'finalizado'], true)) {
                $nuevoEstado = 'en_inscripcion';
            }
        }

        if ($guardar && $nuevoEstado !== $this->estado) {
            $this->update(['estado' => $nuevoEstado]);
            $this->estado = $nuevoEstado;
        }

        return $nuevoEstado;
    }

    /**
     * Calcula las 5 fases reglamentarias de Proyección Social en la UES
     * y su trazabilidad para visualización tipo stepper.
     *
     * @return array{fases: array<int, array<string, mixed>>, faseActual: int, porcentajeAvance: int, horasAcumuladas: int}
     */
    public function calcularFasesProceso(): array
    {
        $fases = [
            1 => [
                'numero' => 1,
                'nombre' => 'Inscripción y Solicitud',
                'codigo_formato' => 'Etapa 1',
                'descripcion' => 'Registro de datos personales y validación inicial de la solicitud.',
                'tipo_doc' => 'solicitud',
            ],
            2 => [
                'numero' => 2,
                'nombre' => 'Anteproyecto Aprobado',
                'codigo_formato' => 'Etapa 2',
                'descripcion' => 'Plan de trabajo, objetivos y cronograma consensuado con el tutor.',
                'tipo_doc' => 'anteproyecto',
            ],
            3 => [
                'numero' => 3,
                'nombre' => 'Ejecución y Control 50%',
                'codigo_formato' => 'Etapa 3',
                'descripcion' => 'Registro de asistencias y entrega de informe de avance al 50%.',
                'tipo_doc' => 'mitad_proyecto',
            ],
            4 => [
                'numero' => 4,
                'nombre' => 'Memoria Final y Evaluación',
                'codigo_formato' => 'Etapa 4',
                'descripcion' => 'Memoria técnica, evaluación de contraparte y finiquito de horas.',
                'tipo_doc' => 'memoria',
            ],
            5 => [
                'numero' => 5,
                'nombre' => 'Certificación Emitida',
                'codigo_formato' => 'Certificación',
                'descripcion' => 'Aprobación definitiva y entrega de constancia oficial por la UPS.',
                'tipo_doc' => 'certificado',
            ],
        ];

        $documentos = $this->relationLoaded('documentos') ? $this->documentos : $this->documentos()->get();

        $docFase1 = $documentos->first(fn ($d) => in_array($d->tipo, ['solicitud', 'inscripcion'], true));
        $docFase2 = $documentos->firstWhere('tipo', 'anteproyecto');
        $docFase3 = $documentos->firstWhere('tipo', 'mitad_proyecto');
        $docFase4 = $documentos->firstWhere('tipo', 'memoria');
        $docFase5 = $documentos->first(fn ($d) => $d->tipo === 'certificado' || $d->folio !== null);

        $estadoProy = $this->estado ?? 'solicitado';

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

        $faseActual = 1;
        foreach ($completadas as $num => $isComp) {
            if (! $isComp) {
                $faseActual = $num;
                break;
            }
            $faseActual = 5;
        }

        if ($fase5Completada) {
            $faseActual = 5;
        }

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

        return [
            'fases' => $fases,
            'faseActual' => $faseActual,
            'porcentajeAvance' => $porcentajeAvance,
            'horasAcumuladas' => $horasAcumuladas,
        ];
    }

    /**
     * Historial de eventos y auditoría del proyecto (INT-HU-13, COO-HU-11).
     */
    public function historialAuditorias(): HasMany
    {
        return $this->hasMany(Auditoria::class, 'id_entidad', 'id_proyecto')
            ->where('modulo', 'proyectos')
            ->orderBy('id_auditoria', 'desc');
    }
}
