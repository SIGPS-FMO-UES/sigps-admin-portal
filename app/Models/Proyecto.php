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
}
