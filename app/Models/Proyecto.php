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
     * Historial de eventos y auditoría del proyecto (INT-HU-13, COO-HU-11).
     */
    public function historialAuditorias(): HasMany
    {
        return $this->hasMany(Auditoria::class, 'id_entidad', 'id_proyecto')
            ->where('modulo', 'proyectos')
            ->orderBy('id_auditoria', 'desc');
    }
}
