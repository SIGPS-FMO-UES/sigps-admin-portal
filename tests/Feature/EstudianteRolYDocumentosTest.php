<?php

namespace Tests\Feature;

use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EstudianteRolYDocumentosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        Storage::fake('public');
    }

    /**
     * Verifica que un usuario con rol 'Estudiante' tenga bloqueado el acceso a módulos administrativos (HTTP 403).
     */
    public function test_estudiante_cannot_access_modulos_administrativos(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $this->assertNotNull($estudiante);
        $this->assertTrue($estudiante->hasRole('Estudiante'));

        // Intento de acceder a /estudiantes -> 403
        $response = $this->actingAs($estudiante)->get('/estudiantes');
        $response->assertForbidden();

        // Intento de acceder a /tutores -> 403
        $response = $this->actingAs($estudiante)->get('/tutores');
        $response->assertForbidden();

        // Intento de acceder a /certificados -> 403
        $response = $this->actingAs($estudiante)->get('/certificados');
        $response->assertForbidden();

        // Intento de acceder a /proyectos (gestión global) -> 403
        $response = $this->actingAs($estudiante)->get('/proyectos');
        $response->assertForbidden();

        // Intento de acceder a /usuarios -> 403
        $response = $this->actingAs($estudiante)->get('/usuarios');
        $response->assertForbidden();
    }

    /**
     * Verifica que el estudiante vea su dashboard personalizado de proceso y NO el dashboard operativo del sistema.
     */
    public function test_estudiante_dashboard_shows_own_process_and_no_admin_data(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();

        $response = $this->actingAs($estudiante)->get(route('dashboard'));
        $response->assertOk();

        // Debe ver los datos de su propio proceso
        $response->assertSee('Mi Avance de Proyección Social');
        $response->assertSee('Ruta del Proceso de Servicio Social');
        $response->assertSee('Horas de Servicio Social');
        $response->assertSee('Entregables Reglamentarios del Proyecto');
        $response->assertSee('2024-0185');

        // NO debe ver datos operativos administrativos del sistema
        $response->assertDontSee('Dashboard Operativo UPS');
        $response->assertDontSee('Expedientes pendientes');
        $response->assertDontSee('Trámites en alerta');
    }

    /**
     * Verifica que el menú lateral (sidebar) muestre únicamente las opciones de actividades del estudiante,
     * ocultando los módulos administrativos a los que no tiene permiso.
     */
    public function test_sidebar_displays_only_student_options_for_estudiante(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();

        $response = $this->actingAs($estudiante)->get(route('dashboard'));
        $response->assertOk();

        // Debe ver sus accesos específicos de estudiante
        $response->assertSee('Mi Avance');
        $response->assertSee('Mi Proyecto');
        $response->assertSee('Subir Documento');
        $response->assertSee('Formatos y Guías');
        $response->assertSee('Observaciones');

        // NO debe ver enlaces de gestión administrativa
        $response->assertDontSee('Usuarios y Roles');
        $response->assertDontSee('Docentes Tutores');
        $response->assertDontSee('Dashboard Operativo');
    }

    /**
     * Verifica que el estudiante pueda acceder a la sección de formatos oficiales y observaciones.
     */
    public function test_estudiante_can_access_formatos_and_observaciones(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();

        // Formatos oficiales (F1 - F8)
        $resFormatos = $this->actingAs($estudiante)->get(route('estudiante.formatos'));
        $resFormatos->assertOk();
        $resFormatos->assertSee('Formatos y Plantillas Oficiales (F1 - F8)');
        $resFormatos->assertSee('F1');
        $resFormatos->assertSee('F8');

        // Observaciones y dictámenes
        $resObs = $this->actingAs($estudiante)->get(route('estudiante.observaciones'));
        $resObs->assertOk();
        $resObs->assertSee('Revisiones y Observaciones de Entregables');
    }

    /**
     * Verifica que el estudiante pueda consultar la pantalla de 'Mi Proyecto'.
     */
    public function test_estudiante_can_view_mi_proyecto(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();

        $response = $this->actingAs($estudiante)->get(route('estudiante.proyecto'));

        $response->assertOk();
        $response->assertSee('Mi Trámite de Proyección Social');
        $response->assertSee('2024-0185');
        $response->assertSee('Subir Entrega de Documento');
        $response->assertSee('Exclusivo: Formato PDF');
        // Mi Proyecto debe estar activo con bg-[#8B1D2D] en el menú lateral
        $html = $response->getContent();
        $this->assertMatchesRegularExpression('/id="sidebar-nav-mi-proyecto"[^>]*bg-\[#8B1D2D\]/', $html);
        $this->assertDoesNotMatchRegularExpression('/id="sidebar-nav-subir-documento"[^>]*bg-\[#8B1D2D\]/', $html);
    }

    /**
     * Verifica que el estudiante pueda consultar la pantalla de 'Subir Documento'
     * y que el menú lateral resalte 'Subir Documento' como activo y no 'Mi Proyecto'.
     */
    public function test_estudiante_can_view_subir_documento_and_sidebar_highlights_it(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();

        $response = $this->actingAs($estudiante)->get(route('estudiante.subirView'));

        $response->assertOk();
        $response->assertSee('Subir Documento de Proyección Social');
        $response->assertSee('Subir Entrega de Documento');
        $response->assertSee('Exclusivo: Formato PDF');

        // Subir Documento debe estar activo con bg-[#8B1D2D] y Mi Proyecto inactivo
        $html = $response->getContent();
        $this->assertMatchesRegularExpression('/id="sidebar-nav-subir-documento"[^>]*bg-\[#8B1D2D\]/', $html);
        $this->assertDoesNotMatchRegularExpression('/id="sidebar-nav-mi-proyecto"[^>]*bg-\[#8B1D2D\]/', $html);
    }

    /**
     * Verifica que el estudiante pueda subir un archivo exclusivamente PDF,
     * se almacene localmente en storage/app/public/documentos y se genere una URL accesible.
     */
    public function test_estudiante_can_upload_pdf_document_and_generates_valid_url(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $proyecto = $estudiante->proyectosComoAlumno()->first();
        $this->assertNotNull($proyecto);

        $fakePdf = UploadedFile::fake()->create('anteproyecto_social_2026.pdf', 1500, 'application/pdf');

        $this->actingAs($estudiante)->get(route('estudiante.proyecto'));

        $response = $this->actingAs($estudiante)->post(route('estudiante.subirDocumento'), [
            '_token' => session('_token'),
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre_documento' => 'Anteproyecto Aprobado - Versión 1.0',
            'tipo' => 'anteproyecto',
            'archivo_pdf' => $fakePdf,
        ]);

        $response->assertRedirect(route('estudiante.proyecto'));
        $response->assertSessionHas('success');

        // Verificar registro en la tabla 'documentos'
        $this->assertDatabaseHas('documentos', [
            'nombre_documento' => 'Anteproyecto Aprobado - Versión 1.0',
            'tipo' => 'anteproyecto',
        ]);

        $documento = Documento::where('nombre_documento', 'Anteproyecto Aprobado - Versión 1.0')->first();
        $this->assertNotNull($documento);

        // Verificar que la URL generada apunte al storage público local
        $this->assertStringContainsString('/storage/documentos/', $documento->url_documento);

        // Extraer ruta relativa en el disco público y verificar que el archivo fue guardado localmente
        $filename = basename($documento->url_documento);
        Storage::disk('public')->assertExists('documentos/'.$filename);

        // Verificar que se vinculó a la tabla pivote documentos_proyecto
        $this->assertDatabaseHas('documentos_proyecto', [
            'id_proyecto' => $proyecto->id_proyecto,
            'id_documento' => $documento->id_documento,
        ]);

        // Verificar que al volver a cargar la pantalla se muestre el documento y el botón de Ver PDF
        $viewResponse = $this->actingAs($estudiante)->get(route('estudiante.proyecto'));
        $viewResponse->assertSee('Anteproyecto Aprobado - Versión 1.0');
        $viewResponse->assertSee($documento->url_documento);
        $viewResponse->assertSee('Ver PDF');
    }

    /**
     * Verifica que la subida rechace estrictamente archivos que no sean PDF (ej. Word, imágenes, texto).
     */
    public function test_upload_strictly_rejects_non_pdf_files(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $proyecto = $estudiante->proyectosComoAlumno()->first();

        // 1. Archivo Word (.docx)
        $fakeDocx = UploadedFile::fake()->create('documento.docx', 500, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $this->actingAs($estudiante)->get(route('estudiante.proyecto'));

        $response = $this->actingAs($estudiante)->post(route('estudiante.subirDocumento'), [
            '_token' => session('_token'),
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre_documento' => 'Intento de Word',
            'tipo' => 'anteproyecto',
            'archivo_pdf' => $fakeDocx,
        ]);

        $response->assertSessionHasErrors(['archivo_pdf']);
        $this->assertDatabaseMissing('documentos', [
            'nombre_documento' => 'Intento de Word',
        ]);

        // 2. Archivo de Imagen (.png)
        $fakePng = UploadedFile::fake()->image('captura.png');

        $responsePng = $this->actingAs($estudiante)->post(route('estudiante.subirDocumento'), [
            '_token' => session('_token'),
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre_documento' => 'Intento de Imagen',
            'tipo' => 'memoria',
            'archivo_pdf' => $fakePng,
        ]);

        $responsePng->assertSessionHasErrors(['archivo_pdf']);
        $this->assertDatabaseMissing('documentos', [
            'nombre_documento' => 'Intento de Imagen',
        ]);
    }

    /**
     * Verifica que se rechacen archivos que superen los 20 MB.
     */
    public function test_upload_rejects_pdf_exceeding_max_size(): void
    {
        $estudiante = Usuario::where('nombre_usuario', '2024-0185')->first();
        $proyecto = $estudiante->proyectosComoAlumno()->first();

        // 25 MB en KB = 25600 KB
        $hugePdf = UploadedFile::fake()->create('archivo_pesado.pdf', 25600, 'application/pdf');

        $this->actingAs($estudiante)->get(route('estudiante.proyecto'));

        $response = $this->actingAs($estudiante)->post(route('estudiante.subirDocumento'), [
            '_token' => session('_token'),
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre_documento' => 'PDF Demasiado Pesado',
            'tipo' => 'memoria',
            'archivo_pdf' => $hugePdf,
        ]);

        $response->assertSessionHasErrors(['archivo_pdf']);
    }

    /**
     * Verifica que el Administrador mantenga acceso total a todos los módulos y pueda visitar el portal del estudiante.
     */
    public function test_administrador_maintains_full_access(): void
    {
        $admin = Usuario::where('nombre_usuario', 'admin')->first();

        $this->actingAs($admin)->get('/estudiantes')->assertOk();
        $this->actingAs($admin)->get('/tutores')->assertOk();
        $this->actingAs($admin)->get('/certificados')->assertOk();
        $this->actingAs($admin)->get('/proyectos')->assertOk();
        $this->actingAs($admin)->get('/usuarios')->assertOk();
        $this->actingAs($admin)->get('/mi-proyecto')->assertOk();
    }
}
