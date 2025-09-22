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
            
            // Verificar permisos
            $this->verificarPermisos($tarea);
            
            // Verificar que sea una tarea con fecha de entrega (no un módulo)
            if (is_null($tarea->fecha_entrega)) {
                return redirect()->back()->with('error', 'Los módulos de teoría no requieren corrección.');
            }

            // Obtener información del curso y materia
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

            // Obtener TODOS los alumnos del curso (no solo los que entregaron)
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
                        'ta.fecha as fecha_entrega',  // Cambié de ta.fecha a ta.fecha
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
                            'archivo' => $entrega->nombre_archivo,
                            'ruta_archivo' => $entrega->ruta_archivo,  // AGREGAR ESTE CAMPO
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

    // Descargar respuesta del alumno - CORREGIDO para usar respuestas_alumnos
    public function descargarRespuesta($tareaAlumnoId)
    {
        try {
            $tareaAlumno = DB::table('tareas_alumnos as ta')
                ->join('tareas as t', 'ta.id_tarea', '=', 't.id')
                ->where('ta.id', $tareaAlumnoId)
                ->where('ta.borrado_fisico', 0)
                ->select('ta.*', 't.id_revista')
                ->first();

            if (!$tareaAlumno) {
                abort(404, 'Respuesta no encontrada');
            }

            // Verificar permisos - el profesor debe ser el owner de la tarea
            $tarea = Tarea::findOrFail($tareaAlumno->id_tarea);
            $this->verificarPermisos($tarea);

            // Usar ruta_archivo si existe, sino construir ruta con respuestas_alumnos
            if (!empty($tareaAlumno->ruta_archivo)) {
                $rutaArchivo = $tareaAlumno->ruta_archivo;
            } else {
                // Si no hay ruta_archivo, usar la carpeta respuestas_alumnos
                $rutaArchivo = 'respuestas_alumnos/' . $tareaAlumno->nombre_archivo;
            }
            
            if (!Storage::disk('local')->exists($rutaArchivo)) {
                abort(404, 'Archivo de respuesta no encontrado en: ' . $rutaArchivo);
            }

            $rutaCompleta = Storage::disk('local')->path($rutaArchivo);
            
            return response()->download($rutaCompleta, $tareaAlumno->nombre_archivo);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar la respuesta: ' . $e->getMessage());
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
            $notaString = strval($request->nota);

            // Guardar o actualizar la nota
            DB::table('tareas_notas')->updateOrInsert(
                [
                    'id_tarea' => $request->tarea_id,
                    'id_asignacionesalumnos' => $request->asignacion_id
                ],
                [
                    'nota' => $notaString,
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
    // Método privado para determinar el estado de entrega
    private function determinarEstadoEntrega($entrego, $nota, $fechaLimite, $fechaEntrega)
    {
        if (!$entrego) {
            return 'no_entrego';
        }
        
        if (!is_null($nota)) {
            return 'corregido';
        }
        
        if ($fechaLimite && $fechaEntrega) {
            $limite = strtotime($fechaLimite);
            $entrega = strtotime($fechaEntrega);
            
            if ($entrega > $limite) {
                return 'tarde';
            }
        }
        
        return 'pendiente';
    }

    // Método privado para verificar permisos
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