<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuarioRolesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_usuario_no_autenticado_es_redirigido_al_login(): void
    {
        $response = $this->get(route('usuarios.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_usuario_autenticado_puede_ver_listado_de_usuarios_y_sus_roles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('usuarios.index'));

        $response->assertOk();
        $response->assertSee('Usuarios y Roles');
        $response->assertSee('admin');
        $response->assertSee('Administrador');
    }

    public function test_puede_crear_un_nuevo_usuario_con_roles_especificos(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $this->actingAs($admin)->get(route('usuarios.index'));

        $payload = [
            '_token' => session('_token'),
            'nombre_usuario' => 'coordinador_ups1',
            'nombre_completo' => 'Ing. Juan Pérez',
            'password' => 'secret1234',
            'roles' => [2, 3], // Coordinador UPS + Coordinador Carrera
            'activo' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('usuarios.store'), $payload);

        $response->assertRedirect(route('usuarios.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'nombre_usuario' => 'coordinador_ups1',
            'nombre_completo' => 'Ing. Juan Pérez',
            'activo' => true,
        ]);

        $nuevoUsuario = Usuario::where('nombre_usuario', 'coordinador_ups1')->first();
        $this->assertNotNull($nuevoUsuario);
        $this->assertTrue(Hash::check('secret1234', $nuevoUsuario->password));

        // Verificar asignación en roles_usuario
        $rolesAsignados = $nuevoUsuario->roles->pluck('id_rol')->toArray();
        $this->assertEqualsCanonicalizing([2, 3], $rolesAsignados);
    }

    public function test_validacion_al_crear_usuario_requiere_roles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $this->actingAs($admin)->get(route('usuarios.index'));

        $response = $this->actingAs($admin)->post(route('usuarios.store'), [
            '_token' => session('_token'),
            'nombre_usuario' => 'invalido',
            'nombre_completo' => 'Usuario Sin Roles',
            'roles' => [],
        ]);

        $response->assertSessionHasErrors(['roles']);
    }

    public function test_puede_actualizar_los_roles_de_un_usuario_existente(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $usuario = Usuario::factory()->create([
            'nombre_usuario' => 'usuario_roles',
            'activo' => true,
        ]);
        $usuario->roles()->sync([5]); // Inicialmente sólo Estudiante

        $this->assertEqualsCanonicalizing([5], $usuario->fresh()->roles->pluck('id_rol')->toArray());

        $this->actingAs($admin)->get(route('usuarios.index'));

        // Actualizar asignándole Docente Tutor (4) y Coordinador de Carrera (3)
        $response = $this->actingAs($admin)->put(route('usuarios.updateRoles', $usuario), [
            '_token' => session('_token'),
            'roles' => [3, 4],
            'activo' => '1',
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $response->assertSessionHas('success');

        $this->assertEqualsCanonicalizing([3, 4], $usuario->fresh()->roles->pluck('id_rol')->toArray());
    }

    public function test_puede_desactivar_usuario_al_actualizar_roles(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $usuario = Usuario::factory()->create([
            'nombre_usuario' => 'usuario_activo',
            'activo' => true,
        ]);
        $usuario->roles()->sync([4]);

        $this->actingAs($admin)->get(route('usuarios.index'));

        // Enviar sin 'activo' (checkbox desmarcado)
        $response = $this->actingAs($admin)->put(route('usuarios.updateRoles', $usuario), [
            '_token' => session('_token'),
            'roles' => [4],
            // 'activo' no enviado
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertFalse((bool) $usuario->fresh()->activo);
    }

    public function test_filtrado_por_rol_funciona(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $docente = Usuario::factory()->create(['nombre_usuario' => 'docente_filter']);
        $docente->roles()->sync([4]);

        $response = $this->actingAs($admin)->get(route('usuarios.index', ['rol_id' => 4]));

        $response->assertOk();
        $response->assertSee('docente_filter');
        $response->assertDontSee('admin_ups');
    }
}
