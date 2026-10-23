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
        'estado_revision',
        'observaciones',
        'fecha_dictamen',
        'folio',
    ];

    /**
     * Casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_dictamen' => 'datetime',
        ];
    }

    /**
     * Etiqueta legible del estado de revisión reglamentario.
     */
    public function getEstadoRevisionTextoAttribute(): string
    {
        return match ($this->estado_revision) {
            'aprobado_tutor' => 'Aprobado por Tutor (Pasa a Carrera)',
            'observado_tutor' => 'Observado por Tutor (Requiere Corrección)',
            'aval_carrera' => 'Aval Académico Emitido (Enviado a UPS)',
            'observado_carrera' => 'Devuelto por Coordinación de Carrera',
            'auditado_ups' => 'Sellos y Firmas Validados por UPS',
            'certificado_emitido' => 'Certificado Oficial Emitido',
            default => 'Pendiente de Revisión por Tutor',
        };
    }

    /**
     * Color del badge en Tailwind según el estado de revisión.
     */
    public function getEstadoRevisionBadgeAttribute(): string
    {
        return match ($this->estado_revision) {
            'aprobado_tutor' => 'bg-blue-50 text-blue-700 border-blue-200',
            'observado_tutor', 'observado_carrera' => 'bg-red-50 text-red-700 border-red-200',
            'aval_carrera' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'auditado_ups' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'certificado_emitido' => 'bg-purple-50 text-purple-700 border-purple-200',
            default => 'bg-amber-50 text-amber-700 border-amber-200',
        };
    }

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
