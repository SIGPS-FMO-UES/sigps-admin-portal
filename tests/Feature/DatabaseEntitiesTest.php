<?php

namespace Tests\Feature;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Permiso;
use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseEntitiesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Verifica que los seeders poblen todas las tablas esperadas.
     */
    public function test_seeders_populate_all_tables(): void
    {
        $this->assertDatabaseHas('roles', ['name' => 'Administrador']);
        $this->assertDatabaseHas('roles', ['name' => 'Estudiante']);

        $this->assertDatabaseHas('permissions', ['name' => 'gestionar_usuarios']);
        $this->assertDatabaseHas('permissions', ['name' => 'subir_documentos']);

        $this->assertDatabaseHas('usuarios', ['nombre_usuario' => 'admin', 'activo' => true]);
        $this->assertDatabaseHas('usuarios', ['nombre_usuario' => 'tutor_lopez']);

        $this->assertDatabaseHas('documentos', ['tipo' => 'solicitud']);
        $this->assertDatabaseHas('documentos', ['tipo' => 'memoria']);

        $this->assertDatabaseHas('proyectos', ['codigo_proyecto' => 101, 'estado' => 'solicitado']);
        $this->assertDatabaseHas('proyectos', ['codigo_proyecto' => 105, 'estado' => 'finalizado']);
    }

    /**
     * Verifica la relación N:M entre Usuario y Rol con Spatie.
     */
    public function test_usuario_rol_relationship(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole('Administrador'));
        $this->assertTrue($admin->roles->contains('name', 'Administrador'));

        $rolAdmin = Rol::where('name', 'Administrador')->first();
        $this->assertNotNull($rolAdmin);
        $this->assertTrue($rolAdmin->usuarios->contains('nombre_usuario', 'admin'));
    }

    /**
     * Verifica la relación N:M entre Rol y Permiso con Spatie.
     */
    public function test_rol_permiso_relationship(): void
    {
        $adminRol = Rol::where('name', 'Administrador')->first();
        $this->assertNotNull($adminRol);
        $this->assertTrue($adminRol->hasPermissionTo('gestionar_usuarios'));

        $permiso = Permiso::where('name', 'gestionar_usuarios')->first();
        $this->assertNotNull($permiso);
        $this->assertTrue($permiso->roles->contains('name', 'Administrador'));
    }

    /**
     * Verifica la relación entre Proyecto, Alumnos, Tutor y Documentos.
     */
    public function test_proyecto_relationships(): void
    {
        $proyecto = Proyecto::where('codigo_proyecto', 105)->first();
        $this->assertNotNull($proyecto);

        // Tutor
        $this->assertNotNull($proyecto->tutor);
        $this->assertEquals('tutor_lopez', $proyecto->tutor->nombre_usuario);

        // Alumnos participantes
        $this->assertGreaterThanOrEqual(1, $proyecto->alumnos->count());

        // Documentos asociados
        $this->assertGreaterThanOrEqual(1, $proyecto->documentos->count());
        $this->assertTrue($proyecto->documentos->contains('tipo', 'memoria'));
    }

    /**
     * Verifica que los factories funcionen correctamente para todas las entidades.
     */
    public function test_factories_create_valid_entities(): void
    {
        $usuario = Usuario::factory()->create();
        $rol = Rol::factory()->create(['name' => 'RolFactoryTest']);
        $permiso = Permiso::factory()->create(['name' => 'PermisoFactoryTest']);

        // Asignación de rol con Spatie
        $usuario->assignRole($rol);
        $this->assertTrue($usuario->fresh()->hasRole('RolFactoryTest'));
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $usuario->id_usuario,
            'role_id' => $rol->id,
        ]);

        // Asignación de permiso al rol con Spatie
        $rol->givePermissionTo($permiso);
        $this->assertTrue($rol->fresh()->hasPermissionTo('PermisoFactoryTest'));
        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $rol->id,
            'permission_id' => $permiso->id,
        ]);

        $proyecto = Proyecto::factory()->conTutor($usuario)->create();
        $this->assertEquals($usuario->id_usuario, $proyecto->tutor_id);

        $documento = Documento::factory()->create();
        $this->assertContains($documento->tipo, [
            'solicitud',
            'inscripcion',
            'anteproyecto',
            'mitad_proyecto',
            'memoria',
            'otro',
        ]);

        $proyectoAlumno = ProyectosAlumno::factory()->create([
            'id_alumno' => $usuario->id_usuario,
            'id_proyecto' => $proyecto->id_proyecto,
        ]);
        $this->assertDatabaseHas('proyectos_alumnos', [
            'id_proyecto_alumno' => $proyectoAlumno->id_proyecto_alumno,
        ]);

        $docProyecto = DocumentosProyecto::factory()->create([
            'id_proyecto' => $proyecto->id_proyecto,
            'id_documento' => $documento->id_documento,
        ]);
        $this->assertDatabaseHas('documentos_proyecto', [
            'id_documento_proyecto' => $docProyecto->id_documento_proyecto,
        ]);
    }
}
