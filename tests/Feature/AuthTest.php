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
}
