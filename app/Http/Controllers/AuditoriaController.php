<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Rol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditoriaController extends Controller
{
    /**
     * Muestra la bitácora cronológica e interactiva de auditoría del sistema.
     * Exclusivo para el rol Administrador.
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = $request->user();

        // Verificación estricta de rol Administrador
        if (! $usuario || ! $usuario->hasRole('Administrador')) {
            abort(403, 'Acceso restringido: El módulo de Auditoría y Trazabilidad es exclusivo para Administradores del Sistema.');
        }

        $query = Auditoria::query()->with('usuario');

        // 1. Filtro de búsqueda general (persona, usuario, título, detalles)
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_persona', 'ilike', "%{$search}%")
                    ->orWhere('titulo', 'ilike', "%{$search}%")
                    ->orWhere('detalles', 'ilike', "%{$search}%")
                    ->orWhere('accion', 'ilike', "%{$search}%")
                    ->orWhere('modulo', 'ilike', "%{$search}%");
            });
        }

        // 2. Filtro por Rol
        if ($request->filled('rol')) {
            $rol = trim((string) $request->input('rol'));
            $query->where('rol', $rol);
        }

        // 3. Filtro por Módulo
        if ($request->filled('modulo')) {
            $modulo = trim((string) $request->input('modulo'));
            $query->where('modulo', $modulo);
        }

        // 4. Filtro por Tipo de Acción
        if ($request->filled('accion')) {
            $accion = trim((string) $request->input('accion'));
            $query->where('accion', $accion);
        }

        // 5. Filtro por Período de Tiempo
        $periodo = $request->input('periodo', '');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');

        if ($periodo === 'hoy') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($periodo === '7dias') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7)->startOfDay());
        } elseif ($periodo === '30dias') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30)->startOfDay());
        } elseif ($periodo === 'este_mes') {
            $query->where('created_at', '>=', Carbon::now()->startOfMonth());
        } elseif ($fechaDesde || $fechaHasta) {
            if ($fechaDesde) {
                $query->where('created_at', '>=', Carbon::parse($fechaDesde)->startOfDay());
            }
            if ($fechaHasta) {
                $query->where('created_at', '<=', Carbon::parse($fechaHasta)->endOfDay());
            }
        }

        // Métricas rápidas para KPIs superiores
        $totalEventos = (clone $query)->count();
        $totalAprobaciones = (clone $query)->whereIn('accion', [
            'aprobacion', 'aprobacion_tutor', 'aval', 'aval_coordinador', 'emision_certificado', 'auditoria_ups'
        ])->count();
        $totalObservaciones = (clone $query)->whereIn('accion', [
            'observacion', 'observacion_tutor', 'observacion_carrera', 'rechazo'
        ])->count();
        $usuariosAuditados = (clone $query)->distinct('id_usuario')->count('id_usuario');

        // Paginación cronológica descendente (lo más reciente primero)
        $auditorias = $query->orderBy('created_at', 'desc')
            ->orderBy('id_auditoria', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Listas dinámicas para filtros
        $rolesDisponibles = Auditoria::query()
            ->whereNotNull('rol')
            ->distinct()
            ->orderBy('rol')
            ->pluck('rol');

        $modulosDisponibles = Auditoria::query()
            ->whereNotNull('modulo')
            ->distinct()
            ->orderBy('modulo')
            ->pluck('modulo');

        $accionesDisponibles = Auditoria::query()
            ->whereNotNull('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion');

        $modoVista = $request->input('vista', 'timeline'); // 'timeline' o 'tabla'

        return view('auditoria.index', [
            'auditorias' => $auditorias,
            'totalEventos' => $totalEventos,
            'totalAprobaciones' => $totalAprobaciones,
            'totalObservaciones' => $totalObservaciones,
            'usuariosAuditados' => $usuariosAuditados,
            'rolesDisponibles' => $rolesDisponibles,
            'modulosDisponibles' => $modulosDisponibles,
            'accionesDisponibles' => $accionesDisponibles,
            'search' => $request->input('search', ''),
            'rolSeleccionado' => $request->input('rol', ''),
            'moduloSeleccionado' => $request->input('modulo', ''),
            'accionSeleccionada' => $request->input('accion', ''),
            'periodoSeleccionado' => $periodo,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'modoVista' => $modoVista,
        ]);
    }
}
