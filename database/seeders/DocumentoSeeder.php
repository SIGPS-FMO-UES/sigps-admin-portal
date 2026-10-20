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
            ],
            [
                'nombre_documento' => 'Ficha de Inscripción de Alumnos',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/ficha_inscripcion.pdf',
                'tipo' => 'inscripcion',
            ],
            [
                'nombre_documento' => 'Perfil y Anteproyecto de Proyección',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/anteproyecto_guia.pdf',
                'tipo' => 'anteproyecto',
            ],
            [
                'nombre_documento' => 'Informe de Mitad de Proyecto (50%)',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/informe_mitad.pdf',
                'tipo' => 'mitad_proyecto',
            ],
            [
                'nombre_documento' => 'Memoria Final y Liquidación de Horas',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/memoria_final.pdf',
                'tipo' => 'memoria',
            ],
            [
                'nombre_documento' => 'Carta de Aceptación Institucional',
                'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/carta_aceptacion.pdf',
                'tipo' => 'otro',
            ],
        ];

        foreach ($documentos as $doc) {
            Documento::firstOrCreate(
                ['nombre_documento' => $doc['nombre_documento']],
                [
                    'url_documento' => $doc['url_documento'],
                    'tipo' => $doc['tipo'],
                ]
            );
        }
    }
}
