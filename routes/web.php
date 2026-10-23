<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EstudiantePortalController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Ruta principal: muestra el formulario de inicio de sesión como primera pantalla
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // 1. Módulo Estudiantes (Inscripción para personal administrativo; consulta para tutores con revisar_documentos)
    Route::middleware('permission:inscribir_alumnos|revisar_documentos')->group(function (): void {
        Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
        Route::get('/estudiantes/{estudiante}', [EstudianteController::class, 'show'])->name('estudiantes.show');

        Route::middleware('permission:inscribir_alumnos')->group(function (): void {
            Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
            Route::get('/estudiantes/{estudiante}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
            Route::put('/estudiantes/{estudiante}', [EstudianteController::class, 'update'])->name('estudiantes.update');
            Route::delete('/estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');
        });
    });

    // 2. Módulo Certificados / Documentos (Solo usuarios con permiso de revisar documentos)
    Route::middleware('permission:revisar_documentos')->group(function (): void {
        Route::get('/certificados', [CertificadoController::class, 'index'])->name('certificados.index');
        Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');
        Route::get('/certificados/{certificado}', [CertificadoController::class, 'show'])->name('certificados.show');
        Route::get('/certificados/{certificado}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit');
        Route::put('/certificados/{certificado}', [CertificadoController::class, 'update'])->name('certificados.update');
        Route::delete('/certificados/{certificado}', [CertificadoController::class, 'destroy'])->name('certificados.destroy');

        // Acciones específicas de flujo de revisión por roles
        Route::post('/tutor/documentos/{documento}/dictamen', [\App\Http\Controllers\TutorPortalController::class, 'dictamen'])->name('tutor.dictamen');
        Route::post('/coordinador/documentos/{documento}/aval', [\App\Http\Controllers\CoordinadorPortalController::class, 'emitirAval'])->name('coordinador.aval');
        Route::post('/ups/documentos/{certificado}/auditar', [CertificadoController::class, 'auditarSellos'])->name('ups.auditar');
    });

    // 3. Módulo Proyectos - Gestión Administrativa y Asignación de Tutores
    Route::middleware('permission:crear_proyectos|revisar_documentos')->group(function (): void {
        Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
        Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
        Route::get('/proyectos/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('proyectos.edit');
        Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
        Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

        // Asignación y reasignación de tutor por Coordinador de Carrera (HU-61, HU-62)
        Route::post('/coordinador/proyectos/{proyecto}/asignar-tutor', [\App\Http\Controllers\CoordinadorPortalController::class, 'asignarTutor'])->name('coordinador.asignarTutor');
    });

    // 4. Módulo Tutores (Solo con permiso de asignar tutores)
    Route::middleware('permission:asignar_tutor')->group(function (): void {
        Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
        Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
        Route::get('/tutores/{tutor}', [TutorController::class, 'show'])->name('tutores.show');
        Route::get('/tutores/{tutor}/edit', [TutorController::class, 'edit'])->name('tutores.edit');
        Route::put('/tutores/{tutor}', [TutorController::class, 'update'])->name('tutores.update');
        Route::delete('/tutores/{tutor}', [TutorController::class, 'destroy'])->name('tutores.destroy');
    });

    // 5. Emisión de Certificado Oficial UPS (HU-33, HU-34)
    Route::middleware('permission:finalizar_proyectos')->group(function (): void {
        Route::post('/ups/documentos/{certificado}/emitir-certificado', [CertificadoController::class, 'emitirCertificado'])->name('ups.emitirCertificado');
    });

    // 6. Módulo Administración de Usuarios y Roles (Solo administradores)
    Route::middleware('permission:gestionar_usuarios')->group(function (): void {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}/roles', [UsuarioController::class, 'updateRoles'])->name('usuarios.updateRoles');
    });

    // 7. Portal Estudiante: Mi Proyecto, Subida PDF, Formatos y Observaciones
    Route::middleware('permission:subir_documentos')->group(function (): void {
        Route::get('/mi-proyecto', [EstudiantePortalController::class, 'miProyecto'])->name('estudiante.proyecto');
        Route::post('/mi-proyecto/documentos', [EstudiantePortalController::class, 'subirDocumento'])->name('estudiante.subirDocumento');
        Route::get('/formatos-guias', [EstudiantePortalController::class, 'formatos'])->name('estudiante.formatos');
        Route::get('/observaciones', [EstudiantePortalController::class, 'observaciones'])->name('estudiante.observaciones');
    });
});
