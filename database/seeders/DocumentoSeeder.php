<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentos = [
            [
                'nombre_documento' => 'Formato Solicitud de Proyecto Social',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/solicitud_formato.pdf',
                'tipo' => 'solicitud',
                'estado_revision' => 'auditado_ups',
                'observaciones' => 'Sellos de facultad y firmas en tinta azul verificadas correctamente.',
                'fecha_dictamen' => now()->subDays(10),
            ],
            [
                'nombre_documento' => 'Ficha de Inscripción de Alumnos',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/ficha_inscripcion.pdf',
                'tipo' => 'inscripcion',
                'estado_revision' => 'aval_carrera',
                'observaciones' => 'Aval emitido por Coordinación de Escuela de Sistemas.',
                'fecha_dictamen' => now()->subDays(5),
            ],
            [
                'nombre_documento' => 'Perfil y Anteproyecto de Proyección',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/anteproyecto_guia.pdf',
                'tipo' => 'anteproyecto',
                'estado_revision' => 'pendiente_tutor',
                'observaciones' => null,
                'fecha_dictamen' => null,
            ],
            [
                'nombre_documento' => 'Informe de Mitad de Proyecto (50%)',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/informe_mitad.pdf',
                'tipo' => 'mitad_proyecto',
                'estado_revision' => 'aprobado_tutor',
                'observaciones' => 'Cronograma cotejado con éxito según formato F3.',
                'fecha_dictamen' => now()->subDays(2),
            ],
            [
                'nombre_documento' => 'Memoria Final y Liquidación de Horas',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/memoria_final.pdf',
                'tipo' => 'memoria',
                'estado_revision' => 'aval_carrera',
                'observaciones' => 'Aprobado por tutor y respaldado con aval institucional de carrera.',
                'fecha_dictamen' => now()->subDay(),
            ],
            [
                'nombre_documento' => 'Certificado Oficial de Servicio Social - UES',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/certificado_oficial.pdf',
                'tipo' => 'otro',
                'estado_revision' => 'certificado_emitido',
                'observaciones' => 'Certificación completa de 500 horas reglamentarias.',
                'fecha_dictamen' => now(),
                'folio' => 'UES-UPS-2026-0042',
            ],
        ];

        foreach ($documentos as $doc) {
            Documento::updateOrCreate(
                ['nombre_documento' => $doc['nombre_documento']],
                [
                    'url_documento' => $doc['url_documento'],
                    'tipo' => $doc['tipo'],
                    'estado_revision' => $doc['estado_revision'],
                    'observaciones' => $doc['observaciones'] ?? null,
                    'fecha_dictamen' => $doc['fecha_dictamen'] ?? null,
                    'folio' => $doc['folio'] ?? null,
                ]
            );
        }
    }
}
