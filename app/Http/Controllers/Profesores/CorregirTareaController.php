<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\TareaAlumno;
use App\Models\TareaNota;
use App\Models\Revista;
use App\Models\Cupof;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CorregirTareaController extends Controller
{
    // Mostrar página de corrección con todos los alumnos
    public function index($tareaId)
    {
        try {
            $tarea = Tarea::findOrFail($tareaId);
            $this->verificarPermisos($tarea);

            if (is_null($tarea->fecha_entrega)) {
                return redirect()->back()->with('error', 'Los módulos de teoría no requieren corrección.');
            }

            $revista = Revista::find($tarea->id_revista);
            $cupofModel = null;
            $curso = 'Sin asignar';
            $materia = 'Sin materia';

            if ($revista) {
                $cupofModel = Cupof::with(['materia', 'curso'])->find($revista->cupof);
                if ($cupofModel) {
                    if ($cupofModel->curso) {
                        $curso = $cupofModel->curso->ano . '°' . $cupofModel->curso->division;
                    }
                    if ($cupofModel->materia) {
                        $materia = $cupofModel->materia->nombre;
                    }
                }
            }

            $entregas = collect();
            if ($cupofModel && $cupofModel->curso) {
                $entregas = DB::table('asignacionesalumnos as aa')
                    ->join('cursociclolectivo as ccl', 'aa.id_cursosciclolectivo', '=', 'ccl.id')
                    ->join('tipousuario as tu', 'aa.id_tipousuario', '=', 'tu.id')
                    ->join('persona as p', 'tu.id_persona', '=', 'p.id')
                    ->leftJoin('tareas_alumnos as ta', function($join) use ($tarea) {
                        $join->on('aa.id', '=', 'ta.id_asignacionesalumnos')
                             ->where('ta.id_tarea', '=', $tarea->id)
                             ->where('ta.borrado_fisico', '=', 0);
                    })
                    ->leftJoin('tareas_notas as tn', function($join) use ($tarea) {
                        $join->on('aa.id', '=', 'tn.id_asignacionesalumnos')
                             ->where('tn.id_tarea', '=', $tarea->id);
                    })
                    ->where('ccl.id_cursos', $cupofModel->curso->id)
                    ->where('ccl.ciclolectivo', date('Y'))
                    ->where('aa.estado', 'A')
                    ->select([
                        'aa.id as asignacion_id',
                        'p.nombre',
                        'p.apellido',
                        'p.dni',
                        'ta.nombre_archivo',
                        'ta.ruta_archivo',
                        'ta.fecha as fecha_entrega',
                        'ta.id as tarea_alumno_id',
                        'tn.nota',
                        'tn.devolucion'
                    ])
                    ->orderBy('p.apellido')
                    ->orderBy('p.nombre')
                    ->get()
                    ->map(function($entrega) use ($tarea) {
                        $entrego = !is_null($entrega->nombre_archivo);

                        return [
                            'asignacion_id' => $entrega->asignacion_id,
                            'nombre_completo' => $entrega->apellido . ', ' . $entrega->nombre,
                            'dni' => $entrega->dni,
                            'archivo' => $entrega->nombre_archivo, // ya trae la extensión correcta
                            'ruta_archivo' => $entrega->ruta_archivo,
                            'fecha_entrega' => $entrega->fecha_entrega,
                            'tarea_alumno_id' => $entrega->tarea_alumno_id,
                            'nota' => $entrega->nota,
                            'devolucion' => $entrega->devolucion,
                            'entrego' => $entrego,
                            'tiene_nota' => !is_null($entrega->nota),
                            'estado_entrega' => $this->determinarEstadoEntrega($entrego, $entrega->nota, $tarea->fecha_entrega, $entrega->fecha_entrega)
                        ];
                    });
            }

            return view('profesores.tareas.corregir', compact('tarea', 'entregas', 'curso', 'materia'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar la página de corrección: ' . $e->getMessage());
        }
    }

public function descargarRespuesta($tareaAlumnoId)
{
    try {
        // Obtener la entrega del alumno
        $tareaAlumno = DB::table('tareas_alumnos as ta')
            ->where('ta.id', $tareaAlumnoId)
            ->where('ta.borrado_fisico', 0)
            ->first();

        if (!$tareaAlumno) {
            abort(404, 'Respuesta no encontrada');
        }

        // Verificar permisos del profesor
        $tarea = Tarea::findOrFail($tareaAlumno->id_tarea);
        $this->verificarPermisos($tarea);

        // Construir ruta absoluta del archivo en storage
        $rutaArchivo = $tareaAlumno->ruta_archivo ?: 'respuestas_alumnos/' . $tareaAlumno->nombre_archivo;

        if (!Storage::disk('local')->exists($rutaArchivo)) {
            abort(404, 'Archivo de respuesta no encontrado');
        }

        $rutaCompleta = Storage::disk('local')->path($rutaArchivo);

        // Nombre exacto del archivo para la descarga
        $nombreFinal = basename($rutaCompleta);

        // Detectar MIME type automáticamente
        $mimeType = mime_content_type($rutaCompleta) ?: 'application/octet-stream';

        // Abrir PDF en navegador, otros forzar descarga
        $extension = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));
        if ($extension === 'pdf') {
            return response()->file($rutaCompleta, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $nombreFinal . '"'
            ]);
        }

        return response()->download($rutaCompleta, $nombreFinal, [
            'Content-Type' => $mimeType
        ]);

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al abrir/descargar la respuesta: ' . $e->getMessage());
    }
}


    // Guardar corrección (nota y devolución)
    public function guardar(Request $request)
    {
        $request->validate([
            'asignacion_id' => 'required|integer',
            'tarea_id' => 'required|integer|exists:tareas,id',
            'nota' => 'required|numeric|min:1|max:10',
            'devolucion' => 'nullable|string|max:200'
        ]);

        try {
            $tarea = Tarea::findOrFail($request->tarea_id);
            $this->verificarPermisos($tarea);

            DB::table('tareas_notas')->updateOrInsert(
                [
                    'id_tarea' => $request->tarea_id,
                    'id_asignacionesalumnos' => $request->asignacion_id
                ],
                [
                    'nota' => strval($request->nota),
                    'devolucion' => $request->devolucion,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Nota guardada correctamente',
                'has_correction' => true
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar la nota: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar corrección
    public function eliminar(Request $request)
    {
        $request->validate([
            'asignacion_id' => 'required|integer',
            'tarea_id' => 'required|integer|exists:tareas,id'
        ]);

        try {
            $tarea = Tarea::findOrFail($request->tarea_id);
            $this->verificarPermisos($tarea);

            DB::table('tareas_notas')
                ->where('id_tarea', $request->tarea_id)
                ->where('id_asignacionesalumnos', $request->asignacion_id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Corrección eliminada correctamente',
                'has_correction' => false
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la corrección: ' . $e->getMessage()], 500);
        }
    }

    private function determinarEstadoEntrega($entrego, $nota, $fechaLimite, $fechaEntrega)
    {
        if (!$entrego) return 'no_entrego';
        if (!is_null($nota)) return 'corregido';
        if ($fechaLimite && $fechaEntrega && strtotime($fechaEntrega) > strtotime($fechaLimite)) return 'tarde';
        return 'pendiente';
    }

    private function verificarPermisos($tarea)
    {
        $usuarioId = Auth::id();
        $tienePermiso = Revista::whereHas('tipoUsuario.persona', function ($q) use ($usuarioId) {
            $q->where('id', $usuarioId);
        })
        ->where('id', $tarea->id_revista)
        ->exists();

        if (!$tienePermiso) {
            abort(403, 'No tienes permisos para acceder a esta tarea.');
        }
    }
}
