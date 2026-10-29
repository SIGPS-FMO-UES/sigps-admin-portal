<?php

namespace Tests\Feature;

use App\Models\Auditoria;
use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditoriaTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    }

    /**
     * Un usuario sin autenticar es redirigido a login al intentar acceder a auditoría.
     */
    public function test_invitado_es_redirigido_a_login(): void
    {
        $response = $this->get(route('auditoria.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Un estudiante recibe 403 Forbidden al intentar acceder al módulo de auditoría.
     */
    public function test_estudiante_recibe_403_en_auditoria(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $this->assertNotNull($estudiante);

        $response = $this->actingAs($estudiante)->get(route('auditoria.index'));
        $response->assertStatus(403);
    }

    /**
     * Un Docente Tutor recibe 403 Forbidden al intentar acceder al módulo de auditoría.
     */
    public function test_docente_tutor_recibe_403_en_auditoria(): void
    {
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $this->assertNotNull($tutor);

        $response = $this->actingAs($tutor)->get(route('auditoria.index'));
        $response->assertStatus(403);
    }

    /**
     * El Administrador puede acceder al módulo de auditoría (200 OK) y ver el menú en el sidebar.
     */
    public function test_administrador_accede_exitosamente_a_auditoria(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('auditoria.index'));
        $response->assertStatus(200);
        $response->assertSee('Auditoría y Trazabilidad del Sistema');
        $response->assertSee('COO-E04 / COO-HU-11');
        $response->assertSee('Exclusivo Administrador');
        $response->assertSee('sidebar-nav-auditoria');
    }

    /**
     * Filtro por rol y búsqueda por término en la bitácora de auditoría.
     */
    public function test_filtro_por_rol_y_busqueda(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        // Filtro por rol Docente Tutor
        $response = $this->actingAs($admin)->get(route('auditoria.index', ['rol' => 'Docente Tutor']));
        $response->assertStatus(200);
        $response->assertSee('Docente Tutor');

        // Filtro por término de búsqueda específico
        $responseSearch = $this->actingAs($admin)->get(route('auditoria.index', ['search' => 'Roberto López']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Roberto López');
    }

    /**
     * Cambio de vista entre timeline y tabla detallada.
     */
    public function test_alternar_vista_timeline_y_tabla(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        // Vista Línea de tiempo
        $responseTimeline = $this->actingAs($admin)->get(route('auditoria.index', ['vista' => 'timeline']));
        $responseTimeline->assertStatus(200);
        $responseTimeline->assertSee('btn-vista-timeline');

        // Vista Tabla
        $responseTabla = $this->actingAs($admin)->get(route('auditoria.index', ['vista' => 'tabla']));
        $responseTabla->assertStatus(200);
        $responseTabla->assertSee('btn-vista-tabla');
        $responseTabla->assertSee('Usuario Responsable');
    }

    /**
     * COO-HU-11: Las observaciones y dictámenes de tutor quedan registrados inmutablemente en la tabla auditorias
     * sin sobreescribir la historia previa.
     */
    public function test_observaciones_de_tutor_se_registran_en_auditoria_sin_sobreescribirse(): void
    {
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $doc = Documento::first();
        $this->assertNotNull($doc);

        $this->actingAs($tutor)->get(route('dashboard'));

        // 1. Tutor emite primera observación
        $response = $this->actingAs($tutor)->from(route('dashboard'))->post(route('tutor.dictamen', $doc->id_documento), [
            '_token' => session('_token'),
            'accion' => 'observar',
            'observaciones' => 'Primera observación: falta firma de la contraparte.',
        ]);
        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('auditorias', [
            'id_entidad' => $doc->id_documento,
            'accion' => 'observacion_tutor',
            'detalles' => 'Primera observación: falta firma de la contraparte.',
        ]);

        // 2. Posteriormente el tutor emite aprobación (la observación anterior NO se borra de auditorias)
        $this->actingAs($tutor)->from(route('dashboard'))->post(route('tutor.dictamen', $doc->id_documento), [
            '_token' => session('_token'),
            'accion' => 'aprobar',
            'observaciones' => 'Segunda revisión: Documento subsanado y aprobado.',
        ]);

        // Verificar que AMBOS registros coexisten en la base de datos de auditoría
        $this->assertDatabaseHas('auditorias', [
            'id_entidad' => $doc->id_documento,
            'accion' => 'observacion_tutor',
            'detalles' => 'Primera observación: falta firma de la contraparte.',
        ]);

        $this->assertDatabaseHas('auditorias', [
            'id_entidad' => $doc->id_documento,
            'accion' => 'aprobacion_tutor',
        ]);

        $totalRegistrosDoc = Auditoria::where('id_entidad', $doc->id_documento)->count();
        $this->assertGreaterThanOrEqual(2, $totalRegistrosDoc);
    }

    /**
     * COO-HU-04: Reasignación de tutor conserva en el historial el tutor anterior y nuevo tutor.
     */
    public function test_reasignacion_tutor_conserva_historial(): void
    {
        $coord = Usuario::where('nombre_usuario', 'coord_ing')->first();
        $tutorNuevo = Usuario::where('nombre_usuario', 'tutor_garcia')->first();
        $proyecto = Proyecto::first();

        $this->actingAs($coord)->post(route('coordinador.asignarTutor', $proyecto->id_proyecto), [
            'tutor_id' => $tutorNuevo->id_usuario,
        ]);

        $this->assertDatabaseHas('auditorias', [
            'id_entidad' => $proyecto->id_proyecto,
            'tipo_entidad' => 'proyecto',
            'accion' => 'reasignacion_tutor',
        ]);
    }
}
