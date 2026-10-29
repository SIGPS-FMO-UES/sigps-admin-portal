<?php

namespace App\Models;

use Database\Factories\PermisoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permiso extends SpatiePermission
{
    /** @use HasFactory<PermisoFactory> */
    use HasFactory;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'guard_name',
        'nombre_permiso',
    ];

    protected static function booted(): void
    {
        static::saving(function ($permiso): void {
            if (empty($permiso->guard_name)) {
                $permiso->guard_name = 'web';
            }
            if (! empty($permiso->name)) {
                $permiso->nombre_permiso = $permiso->name;
            }
        });
    }

    /**
     * Accessor para compatibilidad con código que use $permiso->nombre_permiso.
     */
    public function getNombrePermisoAttribute(): string
    {
        return (string) ($this->name ?? $this->attributes['nombre_permiso'] ?? '');
    }

    /**
     * Mutator para compatibilidad cuando se asigne $permiso->nombre_permiso.
     */
    public function setNombrePermisoAttribute(?string $value): void
    {
        if ($value) {
            if (empty($this->attributes['name'])) {
                $this->attributes['name'] = $value;
            }
            $this->attributes['nombre_permiso'] = $value;
        }
    }

    /**
     * Accessor para compatibilidad con código que use $permiso->id_permiso.
     */
    public function getIdPermisoAttribute(): int
    {
        return (int) $this->id;
    }
}
