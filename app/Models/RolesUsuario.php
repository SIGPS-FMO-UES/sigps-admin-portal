<?php

namespace App\Models;

use Database\Factories\RolesUsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolesUsuario extends Model
{
    /** @use HasFactory<RolesUsuarioFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla intermedia asociada.
     *
     * @var string
     */
    protected $table = 'roles_usuario';

    /**
     * Clave primaria personalizada de la tabla intermedia.
     *
     * @var string
     */
    protected $primaryKey = 'id_roles_usuario';

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
        'id_usuario',
        'id_rol',
    ];

    /**
     * Usuario vinculado en la asignación de rol.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Rol vinculado en la asignación.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
}
