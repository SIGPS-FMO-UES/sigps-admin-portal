<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Verifica que la pantalla de inicio de sesión se renderice correctamente en la raíz.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Bienvenido de nuevo');
        $response->assertSee('Sistema de Proyección Social');
        $response->assertSee('minerva.jpg');
    }

    /**
     * Verifica que un usuario pueda autenticarse con su nombre de usuario.
     */
    public function test_users_can_authenticate_using_username(): void
    {
        $this->get('/'); // Inicializa la sesión y token CSRF

        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => 'password123',
            '_token' => session('_token'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Verifica que un usuario pueda autenticarse ingresando formato de correo institucional.
     */
    public function test_users_can_authenticate_using_email_format(): void
    {
        $this->get('/');

        $response = $this->post('/login', [
            'login' => 'admin@ues.edu.sv',
            'password' => 'password123',
            '_token' => session('_token'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Verifica que falle la autenticación con contraseña incorrecta.
     */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $this->get('/');

        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => 'wrong-password',
            '_token' => session('_token'),
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('login');
    }

    /**
     * Verifica que un usuario autenticado pueda cerrar sesión.
     */
    public function test_users_can_logout(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $this->actingAs($admin)->get('/dashboard');

        $response = $this->actingAs($admin)->post('/logout', [
            '_token' => session('_token'),
        ]);

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Verifica que el dashboard requiera autenticación.
     */
    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/');
    }

    /**
     * Verifica que un usuario autenticado pueda acceder al dashboard.
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Operativo UPS');
        $response->assertSee('Administrador General UPS');
    }

    /**
     * Verifica que la pantalla de registro se renderice correctamente.
     */
    public function test_register_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Crear cuenta');
        $response->assertSee('Ingresa tus datos para registrarte en el sistema.');
        $response->assertSee('Correo electrónico');
    }

    /**
     * Verifica que un nuevo usuario pueda registrarse con correo y se le asigne el rol de Estudiante.
     */
    public function test_student_can_register_and_automatically_receives_estudiante_role(): void
    {
        $this->get('/register');

        $response = $this->post('/register', [
            '_token' => session('_token'),
            'nombre_usuario' => '2024-9999',
            'nombre_completo' => 'María Elena Gómez',
            'correo' => 'maria.gomez@ues.edu.sv',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');

        $usuario = Usuario::where('nombre_usuario', '2024-9999')->first();
        $this->assertNotNull($usuario);
        $this->assertEquals('María Elena Gómez', $usuario->nombre_completo);
        $this->assertEquals('maria.gomez@ues.edu.sv', $usuario->correo);
        $this->assertTrue($usuario->hasRole('Estudiante'));
    }

    /**
     * Verifica que el registro falle si las contraseñas no coinciden.
     */
    public function test_registration_fails_if_password_confirmation_does_not_match(): void
    {
        $this->get('/register');

        $response = $this->post('/register', [
            '_token' => session('_token'),
            'nombre_usuario' => '2024-8888',
            'nombre_completo' => 'Pedro Alvarado',
            'correo' => 'pedro.alvarado@ues.edu.sv',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('usuarios', ['nombre_usuario' => '2024-8888']);
    }

    /**
     * Verifica que un usuario pueda autenticarse directamente con su correo institucional.
     */
    public function test_users_can_authenticate_using_seeded_correo(): void
    {
        $this->get('/');

        $response = $this->post('/login', [
            'login' => 'coord_ups@ues.edu.sv',
            'password' => 'password123',
            '_token' => session('_token'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}
