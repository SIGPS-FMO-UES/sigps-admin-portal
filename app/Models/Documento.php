<?php

namespace App\Models;

use Database\Factories\DocumentoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documento extends Model
{
    /** @use HasFactory<DocumentoFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'documentos';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_documento';

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
        'nombre_documento',
        'url_documento',
        'tipo',
    ];

    /**
     * Relación N:M con proyectos asociados mediante documentos_proyecto.
     */
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(
            Proyecto::class,
            'documentos_proyecto',
            'id_documento',
            'id_proyecto',
            'id_documento',
            'id_proyecto'
        )->withPivot('id_documento_proyecto');
    }

    /**
     * Registros de vinculación en documentos_proyecto.
     */
    public function documentosProyecto(): HasMany
    {
        return $this->hasMany(DocumentosProyecto::class, 'id_documento', 'id_documento');
    }
}
