<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutorLopez = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $tutorRodriguez = Usuario::where('nombre_usuario', 'tutor_rodriguez')->first();
        $tutorGarcia = Usuario::where('nombre_usuario', 'tutor_garcia')->first();

        $alumnos = Usuario::where('nombre_usuario', 'like', 'alumno_%')
            ->orWhere('nombre_usuario', 'like', '2024-%')
            ->orderBy('id_usuario')
            ->get();

        $docs = Documento::all()->keyBy('tipo');

        // 1. Proyecto en estado "solicitado" (sin tutor aún)
        $p1 = Proyecto::firstOrCreate(
            ['codigo_proyecto' => 101],
            [
                'nombre_proyecto' => 'Digitalización de Archivo Histórico Municipal',
                'estado' => 'solicitado',
                'tutor_id' => null,
            ]
        );
        if ($alumnos->count() >= 2) {
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[0]->id_usuario, 'id_proyecto' => $p1->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[1]->id_usuario, 'id_proyecto' => $p1->id_proyecto]);
        }
        if (isset($docs['solicitud'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p1->id_proyecto, 'id_documento' => $docs['solicitud']->id_documento]);
        }

        // 2. Proyecto en estado "en_inscripcion"
        $p2 = Proyecto::firstOrCreate(
            ['codigo_proyecto' => 102],
            [
                'nombre_proyecto' => 'Capacitación en Alfabetización Digital para Adultos Mayores',
                'estado' => 'en_inscripcion',
                'tutor_id' => $tutorLopez?->id_usuario,
            ]
        );
        if ($alumnos->count() >= 3) {
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[1]->id_usuario, 'id_proyecto' => $p2->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[2]->id_usuario, 'id_proyecto' => $p2->id_proyecto]);
        }
        if (isset($docs['solicitud'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p2->id_proyecto, 'id_documento' => $docs['solicitud']->id_documento]);
        }
        if (isset($docs['inscripcion'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p2->id_proyecto, 'id_documento' => $docs['inscripcion']->id_documento]);
        }

        // 3. Proyecto en estado "en_proceso"
        $p3 = Proyecto::firstOrCreate(
            ['codigo_proyecto' => 103],
            [
                'nombre_proyecto' => 'Mantenimiento Preventivo de Equipos en Escuelas Rurales',
                'estado' => 'en_proceso',
                'tutor_id' => $tutorRodriguez?->id_usuario,
            ]
        );
        if ($alumnos->count() >= 6) {
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[3]->id_usuario, 'id_proyecto' => $p3->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[4]->id_usuario, 'id_proyecto' => $p3->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[5]->id_usuario, 'id_proyecto' => $p3->id_proyecto]);
        }
        if (isset($docs['solicitud'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p3->id_proyecto, 'id_documento' => $docs['solicitud']->id_documento]);
        }
        if (isset($docs['anteproyecto'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p3->id_proyecto, 'id_documento' => $docs['anteproyecto']->id_documento]);
        }

        // 4. Proyecto en estado "en_finalizacion"
        $p4 = Proyecto::firstOrCreate(
            ['codigo_proyecto' => 104],
            [
                'nombre_proyecto' => 'Sistema de Gestión de Inventario para Centro de Salud',
                'estado' => 'en_finalizacion',
                'tutor_id' => $tutorGarcia?->id_usuario,
            ]
        );
        if ($alumnos->count() >= 8) {
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[6]->id_usuario, 'id_proyecto' => $p4->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[7]->id_usuario, 'id_proyecto' => $p4->id_proyecto]);
        }
        if (isset($docs['mitad_proyecto'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p4->id_proyecto, 'id_documento' => $docs['mitad_proyecto']->id_documento]);
        }

        // 5. Proyecto en estado "finalizado"
        $p5 = Proyecto::firstOrCreate(
            ['codigo_proyecto' => 105],
            [
                'nombre_proyecto' => 'Taller de Robótica Educativa para Jóvenes de Instituto Nacional',
                'estado' => 'finalizado',
                'tutor_id' => $tutorLopez?->id_usuario,
            ]
        );
        if ($alumnos->count() >= 10) {
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[8]->id_usuario, 'id_proyecto' => $p5->id_proyecto]);
            ProyectosAlumno::firstOrCreate(['id_alumno' => $alumnos[9]->id_usuario, 'id_proyecto' => $p5->id_proyecto]);
        }
        if (isset($docs['memoria'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p5->id_proyecto, 'id_documento' => $docs['memoria']->id_documento]);
        }
        if (isset($docs['otro'])) {
            DocumentosProyecto::firstOrCreate(['id_proyecto' => $p5->id_proyecto, 'id_documento' => $docs['otro']->id_documento]);
        }
    }
}
