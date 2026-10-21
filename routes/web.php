<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Ruta principal: muestra el formulario de inicio de sesión como primera pantalla
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // 1. Módulo Estudiantes
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('/estudiantes/{estudiante}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/estudiantes/{estudiante}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/estudiantes/{estudiante}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::delete('/estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');

    // 2. Módulo Certificados / Documentos
    Route::get('/certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');
    Route::get('/certificados/{certificado}', [CertificadoController::class, 'show'])->name('certificados.show');
    Route::get('/certificados/{certificado}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit');
    Route::put('/certificados/{certificado}', [CertificadoController::class, 'update'])->name('certificados.update');
    Route::delete('/certificados/{certificado}', [CertificadoController::class, 'destroy'])->name('certificados.destroy');

    // 3. Módulo Proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
    Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
    Route::get('/proyectos/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('proyectos.edit');
    Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
    Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

    // 4. Módulo Tutores
    Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
    Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
    Route::get('/tutores/{tutor}', [TutorController::class, 'show'])->name('tutores.show');
    Route::get('/tutores/{tutor}/edit', [TutorController::class, 'edit'])->name('tutores.edit');
    Route::put('/tutores/{tutor}', [TutorController::class, 'update'])->name('tutores.update');
    Route::delete('/tutores/{tutor}', [TutorController::class, 'destroy'])->name('tutores.destroy');

    // 5. Módulo Administración de Usuarios y Roles
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{usuario}/roles', [UsuarioController::class, 'updateRoles'])->name('usuarios.updateRoles');
});
