<?php

namespace App\Models;

use Database\Factories\PermisosRolFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermisosRol extends Model
{
    /** @use HasFactory<PermisosRolFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla intermedia asociada.
     *
     * @var string
     */
    protected $table = 'permisos_rol';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_permisos_rol';

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
        'id_permiso',
        'id_rol',
    ];

    /**
     * Permiso vinculado en la asignación.
     */
    public function permiso(): BelongsTo
    {
        return $this->belongsTo(Permiso::class, 'id_permiso', 'id_permiso');
    }

    /**
     * Rol vinculado en la asignación.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
}
