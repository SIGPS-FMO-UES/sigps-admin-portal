<?php

namespace App\Models;

use Database\Factories\RolFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\PermissionRegistrar;

class Rol extends SpatieRole
{
    /** @use HasFactory<RolFactory> */
    use HasFactory;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'guard_name',
        'nombre_rol',
    ];

    protected static function booted(): void
    {
        static::saving(function ($role): void {
            if (empty($role->guard_name)) {
                $role->guard_name = 'web';
            }
            if (! empty($role->name)) {
                $role->nombre_rol = $role->name;
            }
        });
    }

    /**
     * Accessor para compatibilidad con código que use $rol->nombre_rol.
     */
    public function getNombreRolAttribute(): string
    {
        return (string) ($this->name ?? $this->attributes['nombre_rol'] ?? '');
    }

    /**
     * Mutator para compatibilidad cuando se asigne $rol->nombre_rol.
     */
    public function setNombreRolAttribute(?string $value): void
    {
        if ($value) {
            if (empty($this->attributes['name'])) {
                $this->attributes['name'] = $value;
            }
            $this->attributes['nombre_rol'] = $value;
        }
    }

    /**
     * Accessor para compatibilidad con código que use $rol->id_rol.
     */
    public function getIdRolAttribute(): int
    {
        return (int) $this->id;
    }

    /**
     * Relación con usuarios que poseen este rol.
     */
    public function usuarios()
    {
        return $this->morphedByMany(
            Usuario::class,
            'model',
            config('permission.table_names.model_has_roles', 'model_has_roles'),
            app(PermissionRegistrar::class)->pivotRole,
            config('permission.column_names.model_morph_key', 'model_id')
        );
    }

    /**
     * Alias de relación permisos.
     */
    public function permisos()
    {
        return $this->permissions();
    }
}
