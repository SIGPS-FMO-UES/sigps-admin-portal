<?php

namespace Tests\Feature;

use App\Models\Documento;
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
     * Verifica que se pueda ver la vista de detalles del certificado.
     */
    public function test_authenticated_user_can_view_certificado_detalles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $documento = Documento::first();
        $this->assertNotNull($documento);

        $response = $this->actingAs($admin)->get(route('certificados.show', $documento));

        $response->assertOk();
        $response->assertSee('Certificados/Detalles');
        $response->assertSee('Detalles del documento / certificado');
        $response->assertSee('Regresar');
        $response->assertSee('Modificar');
    }

    /**
     * Verifica que se pueda actualizar un certificado existente.
     */
    public function test_authenticated_user_can_update_certificado(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $documento = Documento::first();
        $this->assertNotNull($documento);

        $this->actingAs($admin)->get(route('certificados.show', $documento));

        $response = $this->actingAs($admin)->put(route('certificados.update', $documento), [
            '_token' => session('_token'),
            'nombre_documento' => 'Acta Actualizada de Servicio 2026',
            'tipo' => 'memoria',
            'url_documento' => 'https://sigps.ues.edu.sv/storage/acta-actualizada.pdf',
        ]);

        $response->assertRedirect(route('certificados.show', $documento));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('documentos', [
            'id_documento' => $documento->id_documento,
            'nombre_documento' => 'Acta Actualizada de Servicio 2026',
        ]);
    }

    /**
     * Verifica que se pueda eliminar un certificado de la base de datos.
     */
    public function test_authenticated_user_can_delete_certificado(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $documento = Documento::create([
            'nombre_documento' => 'Documento Temporal Para Eliminar',
            'url_documento' => 'https://sigps.ues.edu.sv/temp.pdf',
            'tipo' => 'otro',
        ]);

        $this->actingAs($admin)->get(route('certificados.index'));

        $response = $this->actingAs($admin)->delete(route('certificados.destroy', $documento), [
            '_token' => session('_token'),
        ]);

        $response->assertRedirect(route('certificados.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('documentos', [
            'id_documento' => $documento->id_documento,
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
     * Verifica que se pueda ver la vista de detalles del proyecto.
     */
    public function test_authenticated_user_can_view_proyecto_detalles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $proyecto = Proyecto::first();
        $this->assertNotNull($proyecto);

        $response = $this->actingAs($admin)->get(route('proyectos.show', $proyecto));

        $response->assertOk();
        $response->assertSee('Proyectos/Detalles');
        $response->assertSee('Detalles del proyecto');
        $response->assertSee('Estudiante Asociados');
        $response->assertSee('Modificar');
        $response->assertSee('Regresar');
    }

    /**
     * Verifica que se pueda modificar un proyecto existente.
     */
    public function test_authenticated_user_can_update_proyecto(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $proyecto = Proyecto::first();
        $this->assertNotNull($proyecto);

        $this->actingAs($admin)->get(route('proyectos.show', $proyecto));

        $response = $this->actingAs($admin)->put(route('proyectos.update', $proyecto), [
            '_token' => session('_token'),
            'nombre_proyecto' => 'Nombre Actualizado del Proyecto 2026',
            'estado' => 'en_proceso',
        ]);

        $response->assertRedirect(route('proyectos.show', $proyecto));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('proyectos', [
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre_proyecto' => 'Nombre Actualizado del Proyecto 2026',
            'estado' => 'en_proceso',
        ]);
    }

    /**
     * Verifica que se pueda eliminar un proyecto de la base de datos.
     */
    public function test_authenticated_user_can_delete_proyecto(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $proyecto = Proyecto::create([
            'codigo_proyecto' => 77777,
            'nombre_proyecto' => 'Proyecto Temporal para Eliminación',
            'estado' => 'solicitado',
        ]);

        $this->actingAs($admin)->get(route('proyectos.index'));

        $response = $this->actingAs($admin)->delete(route('proyectos.destroy', $proyecto), [
            '_token' => session('_token'),
        ]);

        $response->assertRedirect(route('proyectos.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('proyectos', [
            'id_proyecto' => $proyecto->id_proyecto,
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

        // Verificar asignación del rol 'Docente Tutor' con Spatie
        $this->assertTrue($nuevoTutor->fresh()->hasRole('Docente Tutor'));
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $nuevoTutor->id_usuario,
            'role_id' => Rol::where('name', 'Docente Tutor')->first()->id,
        ]);
    }

    /**
     * Verifica que se pueda ver la vista de detalles del docente tutor.
     */
    public function test_authenticated_user_can_view_tutor_detalles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $this->assertNotNull($tutor);

        $response = $this->actingAs($admin)->get(route('tutores.show', $tutor));

        $response->assertOk();
        $response->assertSee('Tutores/Detalles');
        $response->assertSee('Detalles del tutor');
        $response->assertSee('tutor_lopez');
        $response->assertSee('Regresar');
        $response->assertSee('Modificar');
    }

    /**
     * Verifica que se puedan actualizar los datos de un docente tutor.
     */
    public function test_authenticated_user_can_update_tutor(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $tutor = Usuario::where('nombre_usuario', 'tutor_lopez')->first();
        $this->assertNotNull($tutor);

        $this->actingAs($admin)->get(route('tutores.show', $tutor));

        $response = $this->actingAs($admin)->put(route('tutores.update', $tutor), [
            '_token' => session('_token'),
            'nombre_usuario' => 'tutor_lopez',
            'nombre_completo' => 'Dr. Fernando López Actualizado',
            'activo' => '1',
        ]);

        $response->assertRedirect(route('tutores.show', $tutor));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'id_usuario' => $tutor->id_usuario,
            'nombre_completo' => 'Dr. Fernando López Actualizado',
        ]);
    }

    /**
     * Verifica que se pueda eliminar un docente tutor.
     */
    public function test_authenticated_user_can_delete_tutor(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $tutor = Usuario::create([
            'nombre_usuario' => 'tutor_temp_del',
            'nombre_completo' => 'Tutor para Eliminar',
            'password' => bcrypt('password123'),
            'activo' => true,
        ]);

        $this->actingAs($admin)->get(route('tutores.index'));

        $response = $this->actingAs($admin)->delete(route('tutores.destroy', $tutor), [
            '_token' => session('_token'),
        ]);

        $response->assertRedirect(route('tutores.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('usuarios', [
            'id_usuario' => $tutor->id_usuario,
        ]);
    }
}
