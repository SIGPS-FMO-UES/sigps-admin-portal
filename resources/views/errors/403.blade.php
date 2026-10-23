<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F8F9FA]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso No Autorizado | SIGPS - UES</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#F8F9FA] flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl border border-gray-200/80 p-8 sm:p-10 text-center">
        <!-- Icono de Seguridad / Prohibido -->
        <div class="w-20 h-20 rounded-3xl bg-red-50 text-[#8B1D2D] mx-auto flex items-center justify-center mb-6 border border-red-100 shadow-2xs">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-800 tracking-wider uppercase mb-2">
            Error 403 &bull; Acceso Restringido
        </span>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
            Acceso No Autorizado
        </h1>

        <p class="text-xs sm:text-sm text-gray-500 mt-2.5 leading-relaxed">
            Tu rol y permisos actuales no te permiten ingresar a esta sección o recurso administrativo del sistema.
        </p>

        @auth
            <div class="mt-4 p-3 bg-gray-50 rounded-2xl border border-gray-100 text-xs text-gray-600 inline-block text-left w-full">
                <p><span class="font-bold text-gray-700">Usuario:</span> {{ auth()->user()->nombre_completo }}</p>
                <p><span class="font-bold text-gray-700">Rol asignado:</span> {{ auth()->user()->roles->pluck('name')->join(', ') ?: 'Sin rol específico' }}</p>
            </div>
        @endauth

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            @role('Estudiante')
                <a
                    href="{{ route('estudiante.proyecto') }}"
                    class="w-full sm:w-auto px-6 py-2.5 bg-[#8B1D2D] hover:bg-[#721523] active:bg-[#5E101D] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all inline-flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span>Ir a Mi Proyecto</span>
                </a>
            @endrole

            <a
                href="{{ route('dashboard') }}"
                class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 text-gray-800 text-xs sm:text-sm font-semibold rounded-xl transition-colors inline-flex items-center justify-center gap-2 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Volver al Dashboard</span>
            </a>
        </div>
    </div>

</body>
</html>
