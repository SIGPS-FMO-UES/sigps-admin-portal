<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control | SIGPS - Portal Administrativo UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    <!-- BARRA DE NAVEGACIÓN SUPERIOR -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Marca SIGPS -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#8B1D2D] text-white flex items-center justify-center font-bold text-base shadow-sm">
                        U
                    </div>
                    <div>
                        <span class="text-base font-bold text-gray-900 tracking-tight">SIGPS</span>
                        <span class="hidden sm:inline-block text-xs text-gray-500 ml-1.5 font-medium border-l border-gray-200 pl-2">
                            Portal Administrativo UPS &bull; UES
                        </span>
                    </div>
                </div>

                <!-- Usuario y botón de cerrar sesión -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-800 leading-tight">
                            {{ $usuario->nombre_completo }}
                        </p>
                        <p class="text-[11px] text-[#8B1D2D] font-semibold">
                            {{ $usuario->roles->pluck('nombre_rol')->join(', ') ?: 'Sin Rol' }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="px-3.5 py-1.5 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-[#8B1D2D] border border-gray-200 hover:border-red-200 rounded-lg text-xs font-semibold transition-all duration-150 cursor-pointer flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL DEL DASHBOARD -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Banner de Bienvenida -->
        <div class="bg-gradient-to-r from-[#8B1D2D] via-[#9E1B32] to-[#721523] rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-[#8B1D2D]/15 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <span class="inline-block px-2.5 py-0.5 bg-white/20 text-white text-[11px] font-bold rounded-full uppercase tracking-wider mb-2">
                    Sesión Iniciada con Éxito
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    ¡Bienvenido, {{ $usuario->nombre_completo }}!
                </h1>
                <p class="text-sm text-white/80 mt-1 max-w-xl">
                    Has ingresado con el usuario <code class="bg-white/20 px-1.5 py-0.5 rounded text-white font-mono">{{ $usuario->nombre_usuario }}</code> al Sistema de Gestión de Proyección Social.
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm px-4 py-3 rounded-2xl border border-white/20 text-right">
                <span class="block text-xs text-white/70">Estado de cuenta</span>
                <span class="text-sm font-bold text-white flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    {{ $usuario->activo ? 'Cuenta Activa' : 'Inactiva' }}
                </span>
            </div>
        </div>

        <!-- Tarjetas de Resumen Rápido -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tus Roles</span>
                <p class="text-xl font-bold text-gray-900 mt-2">
                    {{ $usuario->roles->count() }}
                </p>
                <p class="text-xs text-gray-500 mt-1 truncate">
                    {{ $usuario->roles->pluck('nombre_rol')->join(', ') ?: 'Ninguno' }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Como Tutor</span>
                <p class="text-xl font-bold text-[#8B1D2D] mt-2">
                    {{ $usuario->proyectosComoTutor->count() }} proyectos
                </p>
                <p class="text-xs text-gray-500 mt-1">Proyectos bajo tu tutoría</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Como Alumno</span>
                <p class="text-xl font-bold text-emerald-700 mt-2">
                    {{ $usuario->proyectosComoAlumno->count() }} proyectos
                </p>
                <p class="text-xs text-gray-500 mt-1">Participación activa</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Permisos</span>
                <p class="text-xl font-bold text-gray-900 mt-2">
                    {{ $usuario->roles->flatMap->permisos->unique('id_permiso')->count() }} asignados
                </p>
                <p class="text-xs text-gray-500 mt-1">Capacidades del sistema</p>
            </div>
        </div>

        <!-- Proyectos Registrados en la Base de Datos -->
        @php
            $todosProyectos = \App\Models\Proyecto::with(['tutor', 'alumnos', 'documentos'])->orderBy('codigo_proyecto')->get();
        @endphp

        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 tracking-tight">
                        Proyectos en el Sistema (Base de Datos)
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Listado completo cargado desde PostgreSQL según la especificación DB_Coordinadores
                    </p>
                </div>
                <span class="text-xs font-semibold bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                    Total: {{ $todosProyectos->count() }} proyectos
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5">Código</th>
                            <th class="px-6 py-3.5">Nombre del Proyecto</th>
                            <th class="px-6 py-3.5">Estado</th>
                            <th class="px-6 py-3.5">Docente Tutor</th>
                            <th class="px-6 py-3.5">Alumnos</th>
                            <th class="px-6 py-3.5">Documentos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($todosProyectos as $proyecto)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-xs text-gray-700">
                                    #{{ $proyecto->codigo_proyecto }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $proyecto->nombre_proyecto }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = match ($proyecto->estado) {
                                            'solicitado' => 'bg-amber-50 text-amber-800 border-amber-200',
                                            'en_inscripcion' => 'bg-blue-50 text-blue-800 border-blue-200',
                                            'en_proceso' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                                            'en_finalizacion' => 'bg-purple-50 text-purple-800 border-purple-200',
                                            'finalizado' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $badgeColor }}">
                                        {{ str_replace('_', ' ', ucfirst($proyecto->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ $proyecto->tutor ? $proyecto->tutor->nombre_completo : 'Sin asignar' }}
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-gray-700">
                                    {{ $proyecto->alumnos->count() }} alumnos
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $proyecto->documentos->count() }} archivos
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    No hay proyectos registrados en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
            &copy; 2026 Universidad de El Salvador &bull; Facultad Multidisciplinaria Oriental &bull; Unidad de Proyección Social (UPS)
        </div>
    </footer>
</body>
</html>
