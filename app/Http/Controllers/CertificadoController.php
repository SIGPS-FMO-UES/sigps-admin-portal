<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CertificadoController extends Controller
{
    /**
     * Listado de certificados y documentos registrados en la base de datos.
     */
    public function index(Request $request): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $tipos = [
            'solicitud' => 'Solicitud de Proyecto',
            'inscripcion' => 'Ficha de Inscripción',
            'anteproyecto' => 'Anteproyecto Aprobado',
            'mitad_proyecto' => 'Informe Mitad de Proyecto',
            'memoria' => 'Memoria y Certificación Final',
            'otro' => 'Otro Documento',
        ];

        $query = Documento::query()->with('proyectos');

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('nombre_documento', 'ilike', "%{$search}%")
                    ->orWhere('url_documento', 'ilike', "%{$search}%");
            });
        }

        // Filtro por tipo de documento
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        // Filtro por proyecto vinculado
        if ($request->filled('id_proyecto')) {
            $idProyecto = (int) $request->input('id_proyecto');
            $query->whereHas('proyectos', function ($q) use ($idProyecto): void {
                $q->where('proyectos.id_proyecto', $idProyecto);
            });
        }

        $documentos = $query->orderBy('id_documento', 'asc')->paginate(10)->withQueryString();

        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        return view('certificados.index', [
            'currentUser' => $currentUser,
            'documentos' => $documentos,
            'proyectos' => $proyectos,
            'tipos' => $tipos,
            'search' => $request->input('search', ''),
            'tipoSeleccionado' => $request->input('tipo', ''),
            'proyectoSeleccionado' => $request->input('id_proyecto', ''),
        ]);
    }

    /**
     * Registra un nuevo certificado o documento en la base de datos y lo asocia opcionalmente a un proyecto.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_documento' => ['required', 'string', 'max:255'],
            'url_documento' => ['nullable', 'string', 'max:500'],
            'tipo' => [
                'required',
                'string',
                'in:solicitud,inscripcion,anteproyecto,mitad_proyecto,memoria,otro',
            ],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
        ], [
            'nombre_documento.required' => 'El nombre del certificado o documento es obligatorio.',
            'tipo.required' => 'El tipo de documento es obligatorio.',
            'tipo.in' => 'El tipo de documento seleccionado no es válido.',
            'id_proyecto.exists' => 'El proyecto seleccionado no existe.',
        ]);

        $url = $request->filled('url_documento')
            ? trim((string) $validated['url_documento'])
            : 'https://sigps.ues.edu.sv/storage/certificados/'.Str::slug($validated['nombre_documento']).'-'.time().'.pdf';

        $documento = Documento::create([
            'nombre_documento' => trim($validated['nombre_documento']),
            'url_documento' => $url,
            'tipo' => $validated['tipo'],
        ]);

        if (! empty($validated['id_proyecto'])) {
            DocumentosProyecto::firstOrCreate([
                'id_documento' => $documento->id_documento,
                'id_proyecto' => (int) $validated['id_proyecto'],
            ]);
        }

        return redirect()->route('certificados.index')->with(
            'success',
            "Certificado '{$documento->nombre_documento}' registrado exitosamente en la base de datos."
        );
    }
}
