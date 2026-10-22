<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstudianteTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Verifica que el listado de estudiantes requiera inicio de sesión.
     */
    public function test_estudiantes_screen_requires_authentication(): void
    {
        $response = $this->get('/estudiantes');
        $response->assertRedirect(route('login'));
    }

    /**
     * Verifica que un usuario autenticado pueda acceder y ver los estudiantes en la base de datos.
     */
    public function test_authenticated_user_can_view_estudiantes_list(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/estudiantes');

        $response->assertStatus(200);
        $response->assertSee('Estudiantes');
        $response->assertSee('Lista de Estudiante');
        $response->assertSee('2024-0185');
        $response->assertSee('Ana Beatriz Mendoza');
    }

    /**
     * Verifica que el buscador filtre adecuadamente por carnet o nombre.
     */
    public function test_search_filters_estudiantes(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $response = $this->actingAs($admin)->get('/estudiantes?search=2024-0192');

        $response->assertStatus(200);
        $response->assertSee('Carlos Eduardo Ramos');
        $response->assertDontSee('Kevin Daniel Salazar');
    }

    /**
     * Verifica que se pueda registrar un nuevo estudiante en la base de datos con rol Estudiante y proyecto.
     */
    public function test_can_create_new_estudiante_in_database(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $proyecto = Proyecto::first();
        $this->assertNotNull($proyecto);

        $this->actingAs($admin)->get('/estudiantes');

        $response = $this->actingAs($admin)->post('/estudiantes', [
            '_token' => session('_token'),
            'nombre_usuario' => '2024-9999',
            'nombre_completo' => 'Estudiante Prueba Nuevo',
            'password' => 'secret1234',
            'id_proyecto' => $proyecto->id_proyecto,
            'activo' => '1',
        ]);

        $response->assertRedirect('/estudiantes');
        $response->assertSessionHas('success');

        // Verificar que el estudiante se guardó en `usuarios`
        $this->assertDatabaseHas('usuarios', [
            'nombre_usuario' => '2024-9999',
            'nombre_completo' => 'Estudiante Prueba Nuevo',
            'activo' => true,
        ]);

        $nuevoEstudiante = Usuario::where('nombre_usuario', '2024-9999')->first();
        $this->assertNotNull($nuevoEstudiante);

        // Verificar asignación del rol 'Estudiante' con Spatie
        $this->assertTrue($nuevoEstudiante->fresh()->hasRole('Estudiante'));
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $nuevoEstudiante->id_usuario,
            'role_id' => Rol::where('name', 'Estudiante')->first()->id,
        ]);

        // Verificar asignación a `proyectos_alumnos`
        $this->assertDatabaseHas('proyectos_alumnos', [
            'id_alumno' => $nuevoEstudiante->id_usuario,
            'id_proyecto' => $proyecto->id_proyecto,
        ]);
    }

    /**
     * Verifica que no se permitan carnets duplicados.
     */
    public function test_cannot_create_estudiante_with_duplicate_carnet(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $this->actingAs($admin)->get('/estudiantes');

        $response = $this->actingAs($admin)->post('/estudiantes', [
            '_token' => session('_token'),
            'nombre_usuario' => '2024-0185', // Carnet ya existente
            'nombre_completo' => 'Otro Nombre Repetido',
        ]);

        $response->assertSessionHasErrors(['nombre_usuario']);
    }

    /**
     * Verifica que se pueda acceder a la pantalla de detalles de un estudiante.
     */
    public function test_can_view_estudiante_detalles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $this->assertNotNull($estudiante);

        $response = $this->actingAs($admin)->get(route('estudiantes.show', $estudiante));

        $response->assertOk();
        $response->assertSee('Estudiantes/Detalles');
        $response->assertSee('Detalles del estudiante');
        $response->assertSee('2024-0185');
        $response->assertSee('Regresar');
        $response->assertSee('Modificar');
        $response->assertSee('actionDropdownMenu');
        $response->assertSee('confirmDeleteModal');
        $response->assertSee('action-menu-btn');
    }

    /**
     * Verifica que se puedan actualizar los datos de un estudiante.
     */
    public function test_can_update_estudiante(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $this->assertNotNull($estudiante);

        $this->actingAs($admin)->get(route('estudiantes.show', $estudiante));

        $response = $this->actingAs($admin)->put(route('estudiantes.update', $estudiante), [
            '_token' => session('_token'),
            'nombre_usuario' => '2024-0185',
            'nombre_completo' => 'Ana Beatriz Mendoza Modificada',
            'activo' => '1',
        ]);

        $response->assertRedirect(route('estudiantes.show', $estudiante));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'id_usuario' => $estudiante->id_usuario,
            'nombre_completo' => 'Ana Beatriz Mendoza Modificada',
        ]);
    }

    /**
     * Verifica que se pueda eliminar un estudiante.
     */
    public function test_can_delete_estudiante(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $estudiante = Usuario::factory()->create([
            'nombre_usuario' => 'estudiante_temp_del',
            'nombre_completo' => 'Alumno para Eliminar',
        ]);

        $this->actingAs($admin)->get(route('estudiantes.index'));

        $response = $this->actingAs($admin)->delete(route('estudiantes.destroy', $estudiante), [
            '_token' => session('_token'),
        ]);

        $response->assertRedirect(route('estudiantes.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('usuarios', [
            'id_usuario' => $estudiante->id_usuario,
        ]);
    }
}
