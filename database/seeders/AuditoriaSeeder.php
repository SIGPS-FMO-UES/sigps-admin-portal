<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AuditoriaSeeder extends Seeder
{
    /**
     * Puebla la tabla de auditoría con eventos históricos representativos de todos los roles.
     */
    public function run(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $coordIng = Usuario::where('nombre_usuario', 'coord_ing')->first();
        $coordUps = Usuario::where('nombre_usuario', 'coord_ups')->first();
        $tutorLopez = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $tutorRodriguez = Usuario::where('nombre_usuario', 'tutor_rodriguez')->first();
        $alumno1 = Usuario::where('nombre_usuario', '2024-0185')->first();
        $alumno2 = Usuario::where('nombre_usuario', '2024-0192')->first();

        $proyecto = Proyecto::first();
        $doc = Documento::first();

        $docId = $doc?->id_documento ?? 1;
        $proyId = $proyecto?->id_proyecto ?? 1;

        $eventos = [
            // Evento 1: Hace 10 días - Inicio de sesión del Administrador
            [
                'id_usuario' => $admin?->id_usuario,
                'nombre_usuario' => $admin?->nombre_usuario ?? 'admin',
                'nombre_persona' => $admin?->nombre_completo ?? 'Administrador General UPS',
                'rol' => 'Administrador',
                'modulo' => 'autenticacion',
                'id_entidad' => $admin?->id_usuario,
                'tipo_entidad' => 'usuario',
                'accion' => 'inicio_sesion',
                'titulo' => 'Inicio de sesión administrativo',
                'detalles' => 'Autenticación exitosa en consola central con rol Administrador.',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at' => Carbon::now()->subDays(10)->setHour(8)->setMinute(15),
            ],

            // Evento 2: Hace 9 días - Admin crea nuevo usuario docente
            [
                'id_usuario' => $admin?->id_usuario,
                'nombre_usuario' => $admin?->nombre_usuario ?? 'admin',
                'nombre_persona' => $admin?->nombre_completo ?? 'Administrador General UPS',
                'rol' => 'Administrador',
                'modulo' => 'usuarios',
                'id_entidad' => $tutorLopez?->id_usuario ?? 4,
                'tipo_entidad' => 'usuario',
                'accion' => 'creacion_usuario',
                'titulo' => 'Creación de cuenta docente: tutor_lopez',
                'detalles' => 'Se dio de alta al usuario Roberto López con rol Docente Tutor y correo tutor_lopez@ues.edu.sv.',
                'estado_nuevo' => 'activo',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'metadatos' => ['roles' => ['Docente Tutor'], 'activo' => true],
                'created_at' => Carbon::now()->subDays(9)->setHour(9)->setMinute(30),
            ],

            // Evento 3: Hace 8 días - Coordinador de Carrera asigna tutor inicial al proyecto
            [
                'id_usuario' => $coordIng?->id_usuario,
                'nombre_usuario' => $coordIng?->nombre_usuario ?? 'coord_ing',
                'nombre_persona' => $coordIng?->nombre_completo ?? 'Ing. Carlos Martínez',
                'rol' => 'Coordinador de Carrera',
                'modulo' => 'proyectos',
                'id_entidad' => $proyId,
                'tipo_entidad' => 'proyecto',
                'accion' => 'asignacion_tutor',
                'titulo' => "Asignación de tutor inicial en Proyecto #{$proyId}",
                'detalles' => "Se asignó como tutor responsable a Dra. María Rodríguez para la supervisión técnica.",
                'estado_anterior' => 'sin_tutor',
                'estado_nuevo' => 'con_tutor',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => ['tutor_id' => $tutorRodriguez?->id_usuario, 'tutor_nombre' => 'Dra. María Rodríguez'],
                'created_at' => Carbon::now()->subDays(8)->setHour(10)->setMinute(0),
            ],

            // Evento 4: Hace 7 días - Estudiante sube primera entrega (F2 - Plan de Trabajo)
            [
                'id_usuario' => $alumno1?->id_usuario,
                'nombre_usuario' => $alumno1?->nombre_usuario ?? '2024-0185',
                'nombre_persona' => $alumno1?->nombre_completo ?? 'Ana Beatriz Mendoza Solís',
                'rol' => 'Estudiante',
                'modulo' => 'documentos',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'subida_documento',
                'titulo' => 'Subida de Plan de Trabajo (F2) - Versión 1',
                'detalles' => 'El estudiante cargó el archivo PDF "Plan_Trabajo_v1.pdf" para revisión del tutor.',
                'estado_nuevo' => 'pendiente_tutor',
                'ip_address' => '190.86.102.44',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => ['archivo' => 'Plan_Trabajo_v1.pdf', 'version' => 1, 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(7)->setHour(14)->setMinute(22),
            ],

            // Evento 5: Hace 6 días - Tutor emite OBSERVACIÓN (No se sobreescribe, queda en bitácora) - COO-HU-11
            [
                'id_usuario' => $tutorRodriguez?->id_usuario,
                'nombre_usuario' => $tutorRodriguez?->nombre_usuario ?? 'tutor_rodriguez',
                'nombre_persona' => $tutorRodriguez?->nombre_completo ?? 'Dra. María Rodríguez',
                'rol' => 'Docente Tutor',
                'modulo' => 'documentos',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'observacion_tutor',
                'titulo' => "Dictamen con Observaciones: Plan de Trabajo (Doc #{$docId})",
                'detalles' => "OBSERVACIONES OBLIGATORIAS:\n1. Falta detallar el cronograma en semanas pares según formato reglamentario.\n2. La firma del responsable de la institución beneficiaria debe ser legible y con sello de agua.\n3. Corregir los objetivos específicos 2 y 3 para alinearlos con el plan de estudios.",
                'estado_anterior' => 'pendiente_tutor',
                'estado_nuevo' => 'observado',
                'ip_address' => '192.168.1.22',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'metadatos' => ['version' => 1, 'dictamen' => 'observado', 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(6)->setHour(11)->setMinute(45),
            ],

            // Evento 6: Hace 5 días - Coordinador de Carrera REASIGNA tutor conservando historial (COO-HU-04)
            [
                'id_usuario' => $coordIng?->id_usuario,
                'nombre_usuario' => $coordIng?->nombre_usuario ?? 'coord_ing',
                'nombre_persona' => $coordIng?->nombre_completo ?? 'Ing. Carlos Martínez',
                'rol' => 'Coordinador de Carrera',
                'modulo' => 'proyectos',
                'id_entidad' => $proyId,
                'tipo_entidad' => 'proyecto',
                'accion' => 'reasignacion_tutor',
                'titulo' => "Reasignación de tutor en Proyecto #{$proyId}",
                'detalles' => "Tutor anterior: Dra. María Rodríguez ➔ Nuevo tutor: Ing. Roberto López por reestructuración de carga horaria departamental.",
                'estado_anterior' => 'tutor_rodriguez',
                'estado_nuevo' => 'tutor_lopez',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => [
                    'tutor_anterior_id' => $tutorRodriguez?->id_usuario,
                    'tutor_anterior_nombre' => 'Dra. María Rodríguez',
                    'nuevo_tutor_id' => $tutorLopez?->id_usuario,
                    'nuevo_tutor_nombre' => 'Ing. Roberto López',
                ],
                'created_at' => Carbon::now()->subDays(5)->setHour(16)->setMinute(10),
            ],

            // Evento 7: Hace 4 días - Estudiante sube versión corregida atendiendo observaciones
            [
                'id_usuario' => $alumno1?->id_usuario,
                'nombre_usuario' => $alumno1?->nombre_usuario ?? '2024-0185',
                'nombre_persona' => $alumno1?->nombre_completo ?? 'Ana Beatriz Mendoza Solís',
                'rol' => 'Estudiante',
                'modulo' => 'documentos',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'subida_documento',
                'titulo' => 'Subida de Plan de Trabajo (F2) Corregido - Versión 2',
                'detalles' => 'El estudiante atendió observaciones de cronograma y sello institucional, subiendo "Plan_Trabajo_v2_Corregido.pdf".',
                'estado_anterior' => 'observado',
                'estado_nuevo' => 'pendiente_tutor',
                'ip_address' => '190.86.102.44',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => ['archivo' => 'Plan_Trabajo_v2_Corregido.pdf', 'version' => 2, 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(4)->setHour(15)->setMinute(50),
            ],

            // Evento 8: Hace 3 días - Nuevo Tutor APROBADO 1er nivel técnico
            [
                'id_usuario' => $tutorLopez?->id_usuario,
                'nombre_usuario' => $tutorLopez?->nombre_usuario ?? 'tutor_lopez',
                'nombre_persona' => $tutorLopez?->nombre_completo ?? 'Ing. Roberto López',
                'rol' => 'Docente Tutor',
                'modulo' => 'documentos',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'aprobacion_tutor',
                'titulo' => "Aprobación Técnica de Tutor: Plan de Trabajo (Doc #{$docId})",
                'detalles' => "Dictamen favorable emitido satisfactoriamente. Se verificaron las correcciones de cronograma, sellos y firmas institucionales reglamentarias.",
                'estado_anterior' => 'pendiente_tutor',
                'estado_nuevo' => 'aprobado_tutor',
                'ip_address' => '192.168.1.30',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => ['version' => 2, 'dictamen' => 'aprobado', 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(3)->setHour(9)->setMinute(20),
            ],

            // Evento 9: Hace 2 días - Coordinador de Carrera emite AVAL ACADÉMICO (COO-HU-10)
            [
                'id_usuario' => $coordIng?->id_usuario,
                'nombre_usuario' => $coordIng?->nombre_usuario ?? 'coord_ing',
                'nombre_persona' => $coordIng?->nombre_completo ?? 'Ing. Carlos Martínez',
                'rol' => 'Coordinador de Carrera',
                'modulo' => 'documentos',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'aval_coordinador',
                'titulo' => "Emisión de Aval Académico de Carrera (Doc #{$docId})",
                'detalles' => "Aval de Escuela de Ingeniería otorgado conforme al dictamen favorable del tutor y cumplimiento del reglamento de proyección social.",
                'estado_anterior' => 'aprobado_tutor',
                'estado_nuevo' => 'aval_carrera',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadatos' => ['aval_oficial' => true, 'carrera' => 'Ingeniería en Sistemas', 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(2)->setHour(14)->setMinute(10),
            ],

            // Evento 10: Ayer - Auditoría y Sellos Oficiales de la UPS (HU-33)
            [
                'id_usuario' => $coordUps?->id_usuario,
                'nombre_usuario' => $coordUps?->nombre_usuario ?? 'coord_ups',
                'nombre_persona' => $coordUps?->nombre_completo ?? 'Lic. Juan Pérez',
                'rol' => 'Coordinador UPS',
                'modulo' => 'certificados',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'auditoria_ups',
                'titulo' => "Auditoría Documental y Cotejo de Sellos UPS (Doc #{$docId})",
                'detalles' => "Revisión final de firmas autorizadas y sellos de agua de la Unidad de Proyección Social completada con éxito.",
                'estado_anterior' => 'aval_carrera',
                'estado_nuevo' => 'certificado_listo',
                'ip_address' => '192.168.1.40',
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64)',
                'metadatos' => ['verificacion_sellos' => true, 'proyecto_id' => $proyId],
                'created_at' => Carbon::now()->subDays(1)->setHour(11)->setMinute(0),
            ],

            // Evento 11: Hoy - Emisión de Certificado Oficial con Folio Institucional
            [
                'id_usuario' => $coordUps?->id_usuario,
                'nombre_usuario' => $coordUps?->nombre_usuario ?? 'coord_ups',
                'nombre_persona' => $coordUps?->nombre_completo ?? 'Lic. Juan Pérez',
                'rol' => 'Coordinador UPS',
                'modulo' => 'certificados',
                'id_entidad' => $docId,
                'tipo_entidad' => 'documento',
                'accion' => 'emision_certificado',
                'titulo' => "Emisión de Certificado Oficial de Servicio Social #{$docId}",
                'detalles' => "Generación de Certificado Oficial con Folio UPS-2026-0042 y registro en libro de actas institucionales.",
                'estado_anterior' => 'certificado_listo',
                'estado_nuevo' => 'certificado_emitido',
                'ip_address' => '192.168.1.40',
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64)',
                'metadatos' => ['folio' => 'UPS-2026-0042', 'libro' => 14, 'acta' => 88],
                'created_at' => Carbon::now()->subHours(2),
            ],
        ];

        foreach ($eventos as $eventoData) {
            Auditoria::create($eventoData);
        }
    }
}
