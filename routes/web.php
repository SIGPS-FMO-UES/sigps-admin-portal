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

    // 2. Módulo Certificados / Documentos
    Route::get('/certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');

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

    // 5. Módulo Administración de Usuarios y Roles
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{usuario}/roles', [UsuarioController::class, 'updateRoles'])->name('usuarios.updateRoles');
});
