<?php

namespace App\Models;

use Database\Factories\DocumentosProyectoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentosProyecto extends Model
{
    /** @use HasFactory<DocumentosProyectoFactory> */
    use HasFactory;

    /**
     * Nombre de la tabla intermedia asociada.
     *
     * @var string
     */
    protected $table = 'documentos_proyecto';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'id_documento_proyecto';

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
        'id_proyecto',
        'id_documento',
    ];

    /**
     * Proyecto vinculado al documento.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Documento vinculado al proyecto.
     */
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class, 'id_documento', 'id_documento');
    }
}
