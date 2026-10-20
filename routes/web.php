<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

// Ruta principal: muestra el formulario de inicio de sesión como primera pantalla
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
});
