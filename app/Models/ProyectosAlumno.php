<?php

namespace App\Models;

use Database\Factories\ProyectosAlumnoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectosAlumno extends Model
{
    /** @use HasFactory<ProyectosAlumnoFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla intermedia asociada.
     *
     * @var string
     */
    protected $table = 'proyectos_alumnos';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_proyecto_alumno';

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
        'id_alumno',
        'id_proyecto',
    ];

    /**
     * Alumno vinculado (referencia a usuarios.id_usuario según el diagrama).
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_alumno', 'id_usuario');
    }

    /**
     * Proyecto al que pertenece la vinculación.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }
}
