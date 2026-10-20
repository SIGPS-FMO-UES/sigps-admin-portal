<?php

namespace App\Models;

use Database\Factories\RolFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    /** @use HasFactory<RolFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_rol';

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
        'nombre_rol',
    ];

    /**
     * Relación N:M con usuarios mediante roles_usuario.
     */
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'roles_usuario',
            'id_rol',
            'id_usuario',
            'id_rol',
            'id_usuario'
        )->withPivot('id_roles_usuario');
    }

    /**
     * Registros de asignación en roles_usuario.
     */
    public function rolesUsuario(): HasMany
    {
        return $this->hasMany(RolesUsuario::class, 'id_rol', 'id_rol');
    }

    /**
     * Relación N:M con permisos mediante permisos_rol.
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(
            Permiso::class,
            'permisos_rol',
            'id_rol',
            'id_permiso',
            'id_rol',
            'id_permiso'
        )->withPivot('id_permisos_rol');
    }

    /**
     * Registros de asignación en permisos_rol.
     */
    public function permisosRol(): HasMany
    {
        return $this->hasMany(PermisosRol::class, 'id_rol', 'id_rol');
    }
}
