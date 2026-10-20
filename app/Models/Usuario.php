<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Clave primaria personalizada de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Indica si el modelo debe registrar created_at y updated_at.
     * El diagrama entidad-relación no incluye timestamps.
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
        'nombre_usuario',
        'nombre_completo',
        'password',
        'activo',
    ];

    /**
     * Atributos ocultos para serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones de tipos de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación N:M con roles mediante la tabla intermedia roles_usuario.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Rol::class,
            'roles_usuario',
            'id_usuario',
            'id_rol',
            'id_usuario',
            'id_rol'
        )->withPivot('id_roles_usuario');
    }

    /**
     * Registros en la tabla intermedia roles_usuario asociados al usuario.
     */
    public function rolesUsuario(): HasMany
    {
        return $this->hasMany(RolesUsuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación N:M con proyectos donde el usuario participa como alumno.
     */
    public function proyectosComoAlumno(): BelongsToMany
    {
        return $this->belongsToMany(
            Proyecto::class,
            'proyectos_alumnos',
            'id_alumno',
            'id_proyecto',
            'id_usuario',
            'id_proyecto'
        )->withPivot('id_proyecto_alumno');
    }

    /**
     * Registros en la tabla intermedia proyectos_alumnos donde este usuario es alumno.
     */
    public function proyectosAlumnos(): HasMany
    {
        return $this->hasMany(ProyectosAlumno::class, 'id_alumno', 'id_usuario');
    }

    /**
     * Proyectos donde el usuario figura como docente tutor.
     */
    public function proyectosComoTutor(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'tutor_id', 'id_usuario');
    }
}
