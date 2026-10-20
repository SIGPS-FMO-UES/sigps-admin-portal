<?php

namespace App\Models;

use Database\Factories\PermisoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permiso extends Model
{
    /** @use HasFactory<PermisoFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'permisos';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_permiso';

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
        'nombre_permiso',
    ];

    /**
     * Relación N:M con roles mediante la tabla permisos_rol.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Rol::class,
            'permisos_rol',
            'id_permiso',
            'id_rol',
            'id_permiso',
            'id_rol'
        )->withPivot('id_permisos_rol');
    }

    /**
     * Registros de asignación en permisos_rol.
     */
    public function permisosRol(): HasMany
    {
        return $this->hasMany(PermisosRol::class, 'id_permiso', 'id_permiso');
    }
}
