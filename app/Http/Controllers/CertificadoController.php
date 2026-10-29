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

        // Si es Docente Tutor, filtrar únicamente documentos de sus proyectos tutelados (HU-65)
        if ($currentUser->hasRole('Docente Tutor')) {
            $query->whereHas('proyectos', function ($q) use ($currentUser): void {
                $q->where('tutor_id', $currentUser->id_usuario);
            });
        }

        $documentos = $query->orderBy('id_documento', 'asc')->paginate(10)->withQueryString();

        $proyectosQuery = Proyecto::query();
        if ($currentUser->hasRole('Docente Tutor')) {
            $proyectosQuery->where('tutor_id', $currentUser->id_usuario);
        }
        $proyectos = $proyectosQuery->orderBy('nombre_proyecto')->get();

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
            'estado_revision' => 'pendiente_tutor',
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

    /**
     * Muestra la vista de detalles del certificado (Ver).
     */
    public function show(Documento $certificado): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $certificado->load(['proyectos.documentos', 'proyectos.tutor', 'proyectos.alumnos']);
        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        $proyectoVinculado = $certificado->proyectos->first();
        $trazabilidad = $proyectoVinculado ? $proyectoVinculado->calcularFasesProceso() : null;
        $fases = $trazabilidad['fases'] ?? [];
        $faseActual = $trazabilidad['faseActual'] ?? 1;
        $documentosProyecto = $proyectoVinculado ? $proyectoVinculado->documentos : collect();
        $docsValidosProyecto = $documentosProyecto->filter(fn ($d) => $d->isAprobado());

        $tipos = [
            'solicitud' => 'Solicitud de Proyecto',
            'inscripcion' => 'Ficha de Inscripción',
            'anteproyecto' => 'Anteproyecto Aprobado',
            'mitad_proyecto' => 'Informe Mitad de Proyecto',
            'memoria' => 'Memoria y Certificación Final',
            'otro' => 'Otro Documento',
        ];

        return view('certificados.detalles', [
            'currentUser' => $currentUser,
            'certificado' => $certificado,
            'proyectos' => $proyectos,
            'proyectoVinculado' => $proyectoVinculado,
            'fases' => $fases,
            'faseActual' => $faseActual,
            'documentosProyecto' => $documentosProyecto,
            'docsValidosProyecto' => $docsValidosProyecto,
            'tipos' => $tipos,
            'mode' => 'ver',
        ]);
    }

    /**
     * Muestra la misma vista con campos habilitados para edición.
     */
    public function edit(Documento $certificado): View
    {
        /** @var Usuario $currentUser */
        $currentUser = Auth::user();

        $certificado->load(['proyectos.documentos', 'proyectos.tutor', 'proyectos.alumnos']);
        $proyectos = Proyecto::orderBy('nombre_proyecto')->get();

        $proyectoVinculado = $certificado->proyectos->first();
        $trazabilidad = $proyectoVinculado ? $proyectoVinculado->calcularFasesProceso() : null;
        $fases = $trazabilidad['fases'] ?? [];
        $faseActual = $trazabilidad['faseActual'] ?? 1;
        $documentosProyecto = $proyectoVinculado ? $proyectoVinculado->documentos : collect();
        $docsValidosProyecto = $documentosProyecto->filter(fn ($d) => $d->isAprobado());

        $tipos = [
            'solicitud' => 'Solicitud de Proyecto',
            'inscripcion' => 'Ficha de Inscripción',
            'anteproyecto' => 'Anteproyecto Aprobado',
            'mitad_proyecto' => 'Informe Mitad de Proyecto',
            'memoria' => 'Memoria y Certificación Final',
            'otro' => 'Otro Documento',
        ];

        return view('certificados.detalles', [
            'currentUser' => $currentUser,
            'certificado' => $certificado,
            'proyectos' => $proyectos,
            'proyectoVinculado' => $proyectoVinculado,
            'fases' => $fases,
            'faseActual' => $faseActual,
            'documentosProyecto' => $documentosProyecto,
            'docsValidosProyecto' => $docsValidosProyecto,
            'tipos' => $tipos,
            'mode' => 'editar',
        ]);
    }

    /**
     * Modifica los datos del certificado y su proyecto asociado.
     */
    public function update(Request $request, Documento $certificado): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_documento' => ['required', 'string', 'max:255'],
            'url_documento' => ['nullable', 'string', 'max:500'],
            'tipo' => ['required', 'string', 'in:solicitud,inscripcion,anteproyecto,mitad_proyecto,memoria,otro'],
            'id_proyecto' => ['nullable', 'integer', 'exists:proyectos,id_proyecto'],
            'estado_revision' => ['nullable', 'string', 'in:pendiente_tutor,aprobado_tutor,observado_tutor,aval_carrera,observado_carrera,auditado_ups,certificado_emitido'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'nombre_documento.required' => 'El título o nombre del documento es obligatorio.',
            'tipo.required' => 'El tipo de documento es obligatorio.',
            'id_proyecto.exists' => 'El proyecto seleccionado no existe.',
        ]);

        $url = $request->filled('url_documento')
            ? trim((string) $validated['url_documento'])
            : $certificado->url_documento;

        $estadoAnterior = $certificado->estado_revision;
        $nuevoEstado = $request->filled('estado_revision') ? $validated['estado_revision'] : $certificado->estado_revision;
        $observaciones = $request->has('observaciones') ? trim((string) ($validated['observaciones'] ?? '')) : $certificado->observaciones;

        $updateData = [
            'nombre_documento' => trim($validated['nombre_documento']),
            'url_documento' => $url,
            'tipo' => $validated['tipo'],
            'estado_revision' => $nuevoEstado,
            'observaciones' => $observaciones,
        ];

        if ($request->filled('estado_revision') && $nuevoEstado !== $estadoAnterior) {
            $updateData['fecha_dictamen'] = now();
            if (in_array($nuevoEstado, ['observado_tutor', 'observado_carrera'], true)) {
                $updateData['motivo_rechazo'] = $observaciones;
            } else {
                $updateData['motivo_rechazo'] = null;
            }
        }

        $certificado->update($updateData);

        // Sincronizar proyecto asociado
        if (! empty($validated['id_proyecto'])) {
            $certificado->proyectos()->sync([(int) $validated['id_proyecto']]);
        } else {
            $certificado->proyectos()->detach();
        }

        if ($request->filled('estado_revision') && $nuevoEstado !== $estadoAnterior) {
            $certificado->load('proyectos');
            foreach ($certificado->proyectos as $proy) {
                $proy->actualizarEstadoAutomatico();
            }

            \App\Models\Auditoria::registrar([
                'modulo' => 'documentos',
                'id_entidad' => $certificado->id_documento,
                'tipo_entidad' => 'Documento',
                'accion' => 'cambio_estado',
                'titulo' => "Cambio de Estado de Revisión: '{$certificado->nombre_documento}'",
                'detalles' => "Estado actualizado de '{$estadoAnterior}' a '{$nuevoEstado}'." . ($observaciones ? " Observaciones: {$observaciones}" : ''),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $nuevoEstado,
            ]);
        }

        return redirect()->route('certificados.show', $certificado)->with(
            'success',
            "Documento '{$certificado->nombre_documento}' actualizado exitosamente."
        );
    }

    /**
     * Auditoría documental visual de sellos y firmas en tinta azul por la UPS (RF-UPS-07, UI-02).
     */
    public function auditarSellos(Request $request, Documento $certificado): RedirectResponse
    {
        $estadoAnterior = $certificado->estado_revision;
        $obs = $request->input('observaciones') ?: 'Auditoría visual completada con éxito. Sellos institucionales de facultad y firmas en tinta azul verificadas conforme a la normativa.';

        $certificado->update([
            'estado_revision' => 'auditado_ups',
            'fecha_dictamen' => now(),
            'observaciones' => $obs,
        ]);

        // Registrar auditoría permanente (COO-HU-11)
        \App\Models\Auditoria::registrar([
            'modulo' => 'certificados',
            'id_entidad' => $certificado->id_documento,
            'tipo_entidad' => 'Certificado',
            'accion' => 'auditoria_ups',
            'titulo' => "Auditoría de Sellos y Firmas UPS: '{$certificado->nombre_documento}'",
            'detalles' => $obs,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => 'auditado_ups',
        ]);

        return back()->with(
            'success',
            "Auditoría visual completada para '{$certificado->nombre_documento}'. Sellos y firmas en tinta azul verificadas satisfactoriamente (RF-UPS-07)."
        );
    }

    /**
     * Emisión oficial de certificado con número de folio único por la UPS (HU-33, HU-34, RF-UPS-09).
     */
    public function emitirCertificado(Request $request, Documento $certificado): RedirectResponse
    {
        $estadoAnterior = $certificado->estado_revision;
        $num = str_pad((string) $certificado->id_documento, 4, '0', STR_PAD_LEFT);
        $folio = "UES-UPS-2026-{$num}";

        $certificado->update([
            'estado_revision' => 'certificado_emitido',
            'folio' => $folio,
            'fecha_dictamen' => now(),
            'observaciones' => 'Certificación oficial de servicio social emitida y registrada en el libro de folios de la UPS.',
        ]);

        // Registrar auditoría permanente (COO-HU-11)
        \App\Models\Auditoria::registrar([
            'modulo' => 'certificados',
            'id_entidad' => $certificado->id_documento,
            'tipo_entidad' => 'Certificado',
            'accion' => 'emision_certificado',
            'titulo' => "Certificado Oficial Emitido (Folio #{$folio}): '{$certificado->nombre_documento}'",
            'detalles' => "Emisión reglamentaria de certificado con Folio #{$folio} por la Unidad de Proyección Social.",
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => 'certificado_emitido',
            'metadatos' => ['folio' => $folio],
        ]);

        return back()->with(
            'success',
            "Certificado oficial emitido exitosamente con Folio #{$folio} para '{$certificado->nombre_documento}' (HU-33)."
        );
    }

    /**
     * Elimina el certificado de la base de datos previa confirmación.
     */
    public function destroy(Documento $certificado): RedirectResponse
    {
        $nombre = $certificado->nombre_documento;

        $certificado->proyectos()->detach();
        $certificado->delete();

        return redirect()->route('certificados.index')->with(
            'success',
            "Certificado '{$nombre}' eliminado exitosamente de la base de datos."
        );
    }
}
