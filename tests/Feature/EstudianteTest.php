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

        // Verificar asignación del rol 'Estudiante'
        $rolEstudiante = Rol::where('nombre_rol', 'Estudiante')->first();
        $this->assertDatabaseHas('roles_usuario', [
            'id_usuario' => $nuevoEstudiante->id_usuario,
            'id_rol' => $rolEstudiante->id_rol,
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
}
