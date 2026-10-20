<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModulosCrudTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Verifica que el listado de certificados requiera autenticación.
     */
    public function test_certificados_screen_requires_authentication(): void
    {
        $response = $this->get('/certificados');
        $response->assertRedirect(route('login'));
    }

    /**
     * Verifica que un usuario autenticado pueda ver el listado de certificados.
     */
    public function test_authenticated_user_can_view_certificados(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/certificados');

        $response->assertStatus(200);
        $response->assertSee('Certificados y Documentos');
        $response->assertSee('Lista de Certificados');
    }

    /**
     * Verifica que se pueda registrar un nuevo certificado en la base de datos.
     */
    public function test_can_create_new_certificado(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $proyecto = Proyecto::first();

        $this->actingAs($admin)->get('/certificados');

        $response = $this->actingAs($admin)->post('/certificados', [
            '_token' => session('_token'),
            'nombre_documento' => 'Acta de Aprobación de Servicio Social',
            'tipo' => 'memoria',
            'id_proyecto' => $proyecto?->id_proyecto,
            'url_documento' => 'https://sigps.ues.edu.sv/storage/acta-001.pdf',
        ]);

        $response->assertRedirect('/certificados');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('documentos', [
            'nombre_documento' => 'Acta de Aprobación de Servicio Social',
            'tipo' => 'memoria',
        ]);
    }

    /**
     * Verifica que el listado de proyectos requiera autenticación.
     */
    public function test_proyectos_screen_requires_authentication(): void
    {
        $response = $this->get('/proyectos');
        $response->assertRedirect(route('login'));
    }

    /**
     * Verifica que un usuario autenticado pueda ver el listado de proyectos.
     */
    public function test_authenticated_user_can_view_proyectos(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $response = $this->actingAs($admin)->get('/proyectos');

        $response->assertStatus(200);
        $response->assertSee('Proyectos de Proyección Social');
        $response->assertSee('Lista de Proyectos');
    }

    /**
     * Verifica que se pueda crear un nuevo proyecto en la base de datos.
     */
    public function test_can_create_new_proyecto(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();

        $this->actingAs($admin)->get('/proyectos');

        $response = $this->actingAs($admin)->post('/proyectos', [
            '_token' => session('_token'),
            'codigo_proyecto' => 9988,
            'nombre_proyecto' => 'Proyecto Comunitario de Robótica Educativa',
            'estado' => 'solicitado',
            'tutor_id' => $tutor?->id_usuario,
        ]);

        $response->assertRedirect('/proyectos');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('proyectos', [
            'codigo_proyecto' => 9988,
            'nombre_proyecto' => 'Proyecto Comunitario de Robótica Educativa',
            'estado' => 'solicitado',
        ]);
    }

    /**
     * Verifica que el listado de tutores requiera autenticación.
     */
    public function test_tutores_screen_requires_authentication(): void
    {
        $response = $this->get('/tutores');
        $response->assertRedirect(route('login'));
    }

    /**
     * Verifica que un usuario autenticado pueda ver el listado de tutores.
     */
    public function test_authenticated_user_can_view_tutores(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $response = $this->actingAs($admin)->get('/tutores');

        $response->assertStatus(200);
        $response->assertSee('Docentes Tutores');
        $response->assertSee('Lista de Docentes Tutores');
        $response->assertSee('tutor_lopez');
    }

    /**
     * Verifica que se pueda registrar un nuevo docente tutor con su rol en la base de datos.
     */
    public function test_can_create_new_tutor(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $this->actingAs($admin)->get('/tutores');

        $response = $this->actingAs($admin)->post('/tutores', [
            '_token' => session('_token'),
            'nombre_usuario' => 'tutor_valencia',
            'nombre_completo' => 'Ing. Claudia Valencia',
            'password' => 'secret1234',
            'activo' => '1',
        ]);

        $response->assertRedirect('/tutores');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'nombre_usuario' => 'tutor_valencia',
            'nombre_completo' => 'Ing. Claudia Valencia',
            'activo' => true,
        ]);

        $nuevoTutor = Usuario::where('nombre_usuario', 'tutor_valencia')->first();
        $this->assertNotNull($nuevoTutor);

        $rolTutor = Rol::where('nombre_rol', 'Docente Tutor')->first();
        $this->assertDatabaseHas('roles_usuario', [
            'id_usuario' => $nuevoTutor->id_usuario,
            'id_rol' => $rolTutor->id_rol,
        ]);
    }
}
