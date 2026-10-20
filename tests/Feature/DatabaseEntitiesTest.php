<?php

namespace Tests\Feature;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Permiso;
use App\Models\PermisosRol;
use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Rol;
use App\Models\RolesUsuario;
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
        $this->assertDatabaseHas('roles', ['nombre_rol' => 'Administrador']);
        $this->assertDatabaseHas('roles', ['nombre_rol' => 'Estudiante']);

        $this->assertDatabaseHas('permisos', ['nombre_permiso' => 'gestionar_usuarios']);
        $this->assertDatabaseHas('permisos', ['nombre_permiso' => 'subir_documentos']);

        $this->assertDatabaseHas('usuarios', ['nombre_usuario' => 'admin', 'activo' => true]);
        $this->assertDatabaseHas('usuarios', ['nombre_usuario' => 'tutor_lopez']);

        $this->assertDatabaseHas('documentos', ['tipo' => 'solicitud']);
        $this->assertDatabaseHas('documentos', ['tipo' => 'memoria']);

        $this->assertDatabaseHas('proyectos', ['codigo_proyecto' => 101, 'estado' => 'solicitado']);
        $this->assertDatabaseHas('proyectos', ['codigo_proyecto' => 105, 'estado' => 'finalizado']);
    }

    /**
     * Verifica la relación N:M entre Usuario y Rol.
     */
    public function test_usuario_rol_relationship(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->roles->contains('nombre_rol', 'Administrador'));

        $rolAdmin = Rol::where('nombre_rol', 'Administrador')->first();
        $this->assertNotNull($rolAdmin);
        $this->assertTrue($rolAdmin->usuarios->contains('nombre_usuario', 'admin'));
    }

    /**
     * Verifica la relación N:M entre Rol y Permiso.
     */
    public function test_rol_permiso_relationship(): void
    {
        $adminRol = Rol::where('nombre_rol', 'Administrador')->first();
        $this->assertNotNull($adminRol);
        $this->assertTrue($adminRol->permisos->contains('nombre_permiso', 'gestionar_usuarios'));

        $permiso = Permiso::where('nombre_permiso', 'gestionar_usuarios')->first();
        $this->assertNotNull($permiso);
        $this->assertTrue($permiso->roles->contains('nombre_rol', 'Administrador'));
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
        $rol = Rol::factory()->create();
        $permiso = Permiso::factory()->create();

        $rolesUsuario = RolesUsuario::factory()->create([
            'id_usuario' => $usuario->id_usuario,
            'id_rol' => $rol->id_rol,
        ]);
        $this->assertDatabaseHas('roles_usuario', [
            'id_roles_usuario' => $rolesUsuario->id_roles_usuario,
            'id_usuario' => $usuario->id_usuario,
            'id_rol' => $rol->id_rol,
        ]);

        $permisosRol = PermisosRol::factory()->create([
            'id_permiso' => $permiso->id_permiso,
            'id_rol' => $rol->id_rol,
        ]);
        $this->assertDatabaseHas('permisos_rol', [
            'id_permisos_rol' => $permisosRol->id_permisos_rol,
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
