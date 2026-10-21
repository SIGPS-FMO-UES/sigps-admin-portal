<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory, Notifiable;

    use HasRoles {
        assignRole as traitAssignRole;
        syncRoles as traitSyncRoles;
    }

    /**
     * Normaliza los roles para que identificadores numéricos en string (ej. '4')
     * se conviertan a enteros y Spatie los resuelva por ID y no por nombre.
     *
     * @param  mixed  ...$roles
     */
    public function assignRole(...$roles): static
    {
        $normalized = collect($roles)
            ->flatten()
            ->map(fn ($role) => is_numeric($role) ? (int) $role : $role)
            ->all();

        return $this->traitAssignRole($normalized);
    }

    /**
     * Normaliza los roles para que identificadores numéricos en string (ej. '4')
     * se conviertan a enteros y Spatie los resuelva por ID y no por nombre.
     *
     * @param  mixed  ...$roles
     */
    public function syncRoles(...$roles): static
    {
        $normalized = collect($roles)
            ->flatten()
            ->map(fn ($role) => is_numeric($role) ? (int) $role : $role)
            ->all();

        return $this->traitSyncRoles($normalized);
    }

    /**
     * Guard utilizado por Spatie para permisos y roles.
     *
     * @var string
     */
    protected $guard_name = 'web';

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

    /**
     * Carrera asignada o calculada para efectos de visualización en el portal.
     */
    public function getCarreraAttribute(): string
    {
        $carreras = [
            'Ingeniería de Sistemas Informáticos',
            'Licenciatura en Computación',
            'Ingeniería Industrial',
            'Ingeniería Civil',
            'Ingeniería Eléctrica',
            'Licenciatura en Educación',
        ];

        return $carreras[($this->id_usuario ?? 1) % count($carreras)];
    }

    /**
     * Departamento asignado o calculado para efectos de visualización en el portal.
     */
    public function getDepartamentoAttribute(): string
    {
        $departamentos = [
            'Escuela de Ingeniería de Sistemas',
            'Escuela de Ingeniería Industrial',
            'Departamento de Ciencias Básicas',
            'Escuela de Ingeniería Civil',
        ];

        return $departamentos[($this->id_usuario ?? 1) % count($departamentos)];
    }
}
