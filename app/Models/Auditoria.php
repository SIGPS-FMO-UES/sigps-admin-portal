<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditorias';
    protected $primaryKey = 'id_auditoria';

    protected $fillable = [
        'id_usuario',
        'nombre_usuario',
        'nombre_persona',
        'rol',
        'modulo',
        'id_entidad',
        'tipo_entidad',
        'accion',
        'titulo',
        'detalles',
        'estado_anterior',
        'estado_nuevo',
        'ip_address',
        'user_agent',
        'metadatos',
    ];

    protected $casts = [
        'metadatos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Usuario que ejecutó la acción auditada.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Registra un nuevo evento de auditoría en el sistema de manera centralizada.
     *
     * @param array<string, mixed> $datos
     */
    public static function registrar(array $datos, ?Usuario $usuario = null): self
    {
        /** @var Usuario|null $user */
        $user = $usuario ?? Auth::user();

        // Determinar el rol principal del usuario que ejecuta la acción
        $rol = $datos['rol'] ?? null;
        if (! $rol && $user) {
            $rol = $user->roles->first()?->name
                ?? $user->roles->first()?->nombre_rol
                ?? ($user->rol ?? 'Usuario');
        }

        return static::create([
            'id_usuario' => $datos['id_usuario'] ?? $user?->id_usuario,
            'nombre_usuario' => $datos['nombre_usuario'] ?? $user?->nombre_usuario ?? 'sistema',
            'nombre_persona' => $datos['nombre_persona'] ?? $user?->nombre_completo ?? 'Sistema Automatizado',
            'rol' => $rol ?? 'Sistema',
            'modulo' => $datos['modulo'] ?? 'general',
            'id_entidad' => $datos['id_entidad'] ?? null,
            'tipo_entidad' => $datos['tipo_entidad'] ?? null,
            'accion' => $datos['accion'] ?? 'registro',
            'titulo' => $datos['titulo'] ?? 'Evento registrado en el sistema',
            'detalles' => $datos['detalles'] ?? null,
            'estado_anterior' => $datos['estado_anterior'] ?? null,
            'estado_nuevo' => $datos['estado_nuevo'] ?? null,
            'ip_address' => $datos['ip_address'] ?? (app()->runningInConsole() ? '127.0.0.1' : request()->ip()),
            'user_agent' => $datos['user_agent'] ?? (app()->runningInConsole() ? 'Console/Seeder' : substr((string) request()->userAgent(), 0, 500)),
            'metadatos' => $datos['metadatos'] ?? null,
        ]);
    }

    /**
     * Obtiene la clase CSS para el badge del rol.
     */
    public function getRolBadgeClass(): string
    {
        return match (trim((string) $this->rol)) {
            'Administrador' => 'bg-purple-100 text-purple-900 border-purple-200',
            'Docente Tutor' => 'bg-emerald-100 text-emerald-900 border-emerald-200',
            'Coordinador de Carrera' => 'bg-blue-100 text-blue-900 border-blue-200',
            'Coordinador UPS' => 'bg-amber-100 text-amber-900 border-amber-200',
            'Auxiliar UPS' => 'bg-cyan-100 text-cyan-900 border-cyan-200',
            'Estudiante' => 'bg-rose-100 text-rose-900 border-rose-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Obtiene la clase CSS para el badge del tipo de acción.
     */
    public function getAccionBadgeClass(): string
    {
        return match ($this->accion) {
            'aprobacion', 'aprobacion_tutor', 'aval', 'aval_coordinador', 'emision_certificado', 'auditoria_ups' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'observacion', 'observacion_tutor', 'observacion_carrera', 'rechazo' => 'bg-rose-50 text-rose-800 border-rose-200',
            'asignacion_tutor', 'reasignacion_tutor' => 'bg-blue-50 text-blue-800 border-blue-200',
            'subida_documento' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
            'cambio_estado', 'creacion' => 'bg-amber-50 text-amber-800 border-amber-200',
            'eliminacion' => 'bg-red-50 text-red-800 border-red-200',
            'inicio_sesion', 'login' => 'bg-teal-50 text-teal-800 border-teal-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    }
}
