<?php

namespace Tests\Feature;

use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesYFlujoWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    }

    /**
     * 1. Rol Docente Tutor:
     * - Visualiza su bandeja especializada de tutoría (HU-63)
     * - Dictamina aprobación técnica de primer nivel (HU-66)
     * - Dictamina observación con motivo obligatorio (HU-67)
     */
    public function test_docente_tutor_workflow_and_technical_dictamen(): void
    {
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $this->assertNotNull($tutor, 'Docente tutor debe existir.');
        $this->assertTrue($tutor->hasRole('Docente Tutor'));

        // Dashboard del Tutor
        $response = $this->actingAs($tutor)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('Panel de Seguimiento y Dictamen Técnico');
        $response->assertSee('Docente Tutor UES');

        // Documento para dictamen técnico
        $documento = Documento::create([
            'nombre_documento' => 'Anteproyecto Sistema Social - Test',
            'url_documento' => 'storage/documentos/test_anteproyecto.pdf',
            'tipo' => 'anteproyecto',
            'estado_revision' => 'pendiente_tutor',
        ]);

        // Asociar a un proyecto tutelado por este docente
        $proyecto = Proyecto::where('tutor_id', $tutor->id_usuario)->first();
        if ($proyecto) {
            $proyecto->documentos()->attach($documento->id_documento);
        }

        // Dictamen Aprobar (HU-66) -> Traslada a Coordinador de Carrera
        $responseAprobar = $this->actingAs($tutor)->post(route('tutor.dictamen', $documento), [
            '_token' => session('_token'),
            'accion' => 'aprobar',
            'observaciones' => 'Aprobado técnicamente sin objeciones.',
        ]);
        $responseAprobar->assertRedirect();
        $responseAprobar->assertSessionHas('success');

        $documento->refresh();
        $this->assertEquals('aprobado_tutor', $documento->estado_revision);
        $this->assertNotNull($documento->fecha_dictamen);

        // Dictamen Observar (HU-67) -> Requiere comentarios y devuelve a estado observado
        $documento->update(['estado_revision' => 'pendiente_tutor']);

        $responseObservar = $this->actingAs($tutor)->post(route('tutor.dictamen', $documento), [
            '_token' => session('_token'),
            'accion' => 'observar',
            'observaciones' => 'Falta detallar la sección de objetivos específicos.',
        ]);
        $responseObservar->assertRedirect();
        $responseObservar->assertSessionHas('warning');

        $documento->refresh();
        $this->assertEquals('observado_tutor', $documento->estado_revision);
        $this->assertEquals('Falta detallar la sección de objetivos específicos.', $documento->observaciones);
    }

    /**
     * 2. Rol Coordinador de Carrera:
     * - Visualiza supervisión departamental y carga de tutores
     * - Asigna o reasigna docentes tutores a proyectos (HU-61, HU-62)
     * - Emite aval académico institucional remitido a UPS (RF-ACA-05, HU-70, HU-72)
     */
    public function test_coordinador_carrera_tutor_assignment_and_academic_aval(): void
    {
        $coordinador = Usuario::where('nombre_usuario', 'coord_ing')->first();
        $this->assertNotNull($coordinador, 'Coordinador de carrera debe existir.');
        $this->assertTrue($coordinador->hasRole('Coordinador de Carrera'));

        // Dashboard del Coordinador
        $response = $this->actingAs($coordinador)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('Panel de Asignación de Tutores y Aval Académico');
        $response->assertSee('Coordinación de Carrera / Escuela');

        // Asignación de tutor a proyecto (HU-61)
        $proyecto = Proyecto::first();
        $nuevoTutor = Usuario::where('nombre_usuario', 'tutor_rodriguez')->first();

        $responseAsignar = $this->actingAs($coordinador)->post(route('coordinador.asignarTutor', $proyecto), [
            '_token' => session('_token'),
            'tutor_id' => $nuevoTutor->id_usuario,
        ]);
        $responseAsignar->assertRedirect();
        $responseAsignar->assertSessionHas('success');

        $proyecto->refresh();
        $this->assertEquals($nuevoTutor->id_usuario, $proyecto->tutor_id);

        // Emisión de Aval Académico (HU-70, HU-72)
        $documento = Documento::create([
            'nombre_documento' => 'Memoria Técnica Final - Carrera Test',
            'url_documento' => 'storage/documentos/test_memoria.pdf',
            'tipo' => 'memoria',
            'estado_revision' => 'aprobado_tutor',
        ]);

        $responseAval = $this->actingAs($coordinador)->post(route('coordinador.aval', $documento), [
            '_token' => session('_token'),
            'accion' => 'aval',
            'observaciones' => 'Aval académico de escuela otorgado.',
        ]);
        $responseAval->assertRedirect();
        $responseAval->assertSessionHas('success');

        $documento->refresh();
        $this->assertEquals('aval_carrera', $documento->estado_revision);
    }

    /**
     * 3. Rol Coordinador UPS:
     * - Visualiza Dashboard Operativo de Auditoría Visual (RF-UPS-07)
     * - Realiza auditoría de sellos institucionales y firmas en tinta azul
     * - Emite certificación oficial con Folio Único UES (HU-33, RF-UPS-09)
     */
    public function test_coordinador_ups_stamp_audit_and_certificate_emission(): void
    {
        $coordUps = Usuario::where('nombre_usuario', 'coord_ups')->first();
        $this->assertNotNull($coordUps, 'Coordinador UPS debe existir.');
        $this->assertTrue($coordUps->hasRole('Coordinador UPS'));

        // Dashboard Operativo UPS
        $response = $this->actingAs($coordUps)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('Dashboard Operativo UPS');
        $response->assertSee('Auditoría de Sellos y Emisión de Certificado');

        // Documento con aval de carrera listo para auditoría UPS
        $documento = Documento::create([
            'nombre_documento' => 'Expediente F1-F8 Final - Test',
            'url_documento' => 'storage/documentos/test_expediente.pdf',
            'tipo' => 'memoria',
            'estado_revision' => 'aval_carrera',
        ]);

        // 1. Auditoría de sellos y firma en tinta azul (RF-UPS-07)
        $responseAuditar = $this->actingAs($coordUps)->post(route('ups.auditar', $documento), [
            '_token' => session('_token'),
            'observaciones' => 'Sellos de dirección de escuela y firmas en tinta azul verificadas conforme a la norma.',
        ]);
        $responseAuditar->assertRedirect();
        $responseAuditar->assertSessionHas('success');

        $documento->refresh();
        $this->assertEquals('auditado_ups', $documento->estado_revision);

        // 2. Emisión de Certificado con Folio Institucional (HU-33)
        $responseCertificar = $this->actingAs($coordUps)->post(route('ups.emitirCertificado', $documento), [
            '_token' => session('_token'),
        ]);
        $responseCertificar->assertRedirect();
        $responseCertificar->assertSessionHas('success');

        $documento->refresh();
        $this->assertEquals('certificado_emitido', $documento->estado_revision);
        $this->assertNotNull($documento->folio);
        $this->assertStringStartsWith('UES-UPS-2026-', $documento->folio);
    }

    /**
     * 4. Rol Administrador:
     * - Acceso irrestricto a todos los módulos y gobernanza de roles
     */
    public function test_administrador_has_global_access_and_manages_users(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole('Administrador'));

        // Puede acceder a Usuarios y Roles
        $responseUsuarios = $this->actingAs($admin)->get(route('usuarios.index'));
        $responseUsuarios->assertOk();

        // Puede acceder a Proyectos, Estudiantes, Certificados y Tutores
        $this->actingAs($admin)->get(route('proyectos.index'))->assertOk();
        $this->actingAs($admin)->get(route('estudiantes.index'))->assertOk();
        $this->actingAs($admin)->get(route('certificados.index'))->assertOk();
        $this->actingAs($admin)->get(route('tutores.index'))->assertOk();
    }
}
