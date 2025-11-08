<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Revista;
use App\Models\Cupof;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{
    // Mostrar lista de materias asignadas al profesor
    public function index()
    {
        // Verificar si el usuario es profesor
        $usuario = Auth::user();

        // Obtener materias asignadas al profesor de forma optimizada
        $materias = Cupof::query()
            ->where('estado', 'A')
            ->whereHas('revistas', function ($query) use ($usuario) {
                $query->where('situacion', 'A')
                    ->whereHas('tipousuario.persona', function ($personaQuery) use ($usuario) {
                        $personaQuery->where('dni', $usuario->dni);
                    });
            })
            ->with([
                'materia:id,nombre',
                'curso:id,division,ano',
                'grupo:id,nombre',
            ])
            ->select('cupof', 'id_materias', 'id_cursos', 'id_grupos', 'turno')
            ->distinct()
            ->orderBy('id_materias')
            ->get();
        return view('profesores.tareas.index', compact('materias'));
    }

    // Cargar vista para un CUPOF específico
    public function cargar($cupof)
    {
        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return redirect()->route('login');
        }

        // Obtener la revista específica para este CUPOF
        $revista = Revista::whereHas('tipoUsuario.persona', function ($q) use ($usuarioId) {
            $q->where('id', $usuarioId);
        })
            ->where('cupof', $cupof)
            ->where('estado', 'A')
            ->first();

        if (!$revista) {
            return redirect()->route('profesores.tareas.index')
                ->with('error', 'No tienes permisos para este curso/materia.');
        }

        // Obtener información del curso/materia
        $cupofModel = Cupof::with(['materia', 'curso'])->find($cupof);
        $cursos = collect();

        if ($cupofModel && $cupofModel->curso) {
            $cursos->push([
                'id' => $cupofModel->cupof,
                'nombre' => $cupofModel->curso->ano . '°' . $cupofModel->curso->division,
                'materia' => $cupofModel->materia->nombre ?? 'Sin materia'
            ]);
        }

        // Obtener total de alumnos del curso
        $totalAlumnos = $this->obtenerTotalAlumnosCurso($cupofModel);

        // Obtener módulos (tareas sin fecha de entrega) para este CUPOF específico
        $modulos = Tarea::where('id_revista', $revista->id)
            ->whereNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function ($tarea) use ($cupofModel, $totalAlumnos) {
                $curso = 'Sin asignar';
                $materia = 'Sin materia';

                if ($cupofModel) {
                    if ($cupofModel->curso) {
                        $curso = $cupofModel->curso->ano . '°' . $cupofModel->curso->division;
                    }
                    if ($cupofModel->materia) {
                        $materia = $cupofModel->materia->nombre;
                    }
                }

                // Contar alumnos que vieron el módulo
                $vistos = $this->contarAlumnosVisto($tarea->id);

                return [
                    'id' => $tarea->id,
                    'titulo' => $tarea->titulo,
                    'descripcion' => $tarea->descripcion,
                    'curso' => $curso,
                    'materia' => $materia,
                    'fecha_subida' => $tarea->fecha_subida ? $tarea->fecha_subida->format('d/m/Y') : date('d/m/Y'),
                    'archivo' => $tarea->nombre_archivo,
                    'vistos' => $vistos . '/' . $totalAlumnos
                ];
            });

        // Obtener tareas (con fecha de entrega) para este CUPOF específico
        $tareas = Tarea::where('id_revista', $revista->id)
            ->whereNotNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function ($tarea) use ($cupofModel, $totalAlumnos) {
                $curso = 'Sin asignar';
                $materia = 'Sin materia';

                if ($cupofModel) {
                    if ($cupofModel->curso) {
                        $curso = $cupofModel->curso->ano . '°' . $cupofModel->curso->division;
                    }
                    if ($cupofModel->materia) {
                        $materia = $cupofModel->materia->nombre;
                    }
                }

                // Contar entregas realizadas
                $entregas = $this->contarEntregasRealizadas($tarea->id);

                // Contar alumnos que vieron la tarea
                $vistos = $this->contarAlumnosVisto($tarea->id);

                return [
                    'id' => $tarea->id,
                    'titulo' => $tarea->titulo,
                    'descripcion' => $tarea->descripcion,
                    'curso' => $curso,
                    'materia' => $materia,
                    'fecha_subida' => $tarea->fecha_subida ? $tarea->fecha_subida->format('d/m/Y') : date('d/m/Y'),
                    'fecha_entrega' => $tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : '-',
                    'fecha_entrega_carbon' => $tarea->fecha_entrega, // Fecha original para comparaciones
                    'archivo' => $tarea->nombre_archivo,
                    'entregas' => $entregas . '/' . $totalAlumnos,
                    'vistos' => $vistos . '/' . $totalAlumnos
                ];
            });

        return view('profesores.tareas.cargar', compact('cursos', 'modulos', 'tareas'));
    }

    // Método privado para obtener total de alumnos del curso
    private function obtenerTotalAlumnosCurso($cupofModel)
    {
        if (!$cupofModel || !$cupofModel->curso) {
            return 0;
        }

        return DB::table('asignacionesalumnos as aa')
            ->join('cursociclolectivo as ccl', 'aa.id_cursosciclolectivo', '=', 'ccl.id')
            ->where('ccl.id_cursos', $cupofModel->curso->id)
            ->where('ccl.ciclolectivo', date('Y'))
            ->where('aa.estado', 'A')
            ->count();
    }

    // Método privado para contar entregas realizadas
    private function contarEntregasRealizadas($tareaId)
    {
        return DB::table('tareas_alumnos')
            ->where('id_tarea', $tareaId)
            ->where('borrado_fisico', 0)
            ->count();
    }

    // Método privado para contar alumnos que vieron la tarea/módulo
    private function contarAlumnosVisto($tareaId)
    {
        return DB::table('archivos_visto')
            ->where('id_tarea', $tareaId)
            ->where('visto', 1)
            ->distinct('id_asignacionesalumnos')
            ->count();
    }

    // Guardar nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'cupof' => 'required|integer|exists:cupof,cupof',
            'archivo' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,zip,rar,7z,tar,gz',
            'fecha_entrega' => 'nullable|date|after:today'
        ]);

        // Obtener la revista del profesor para este CUPOF
        $revista = Revista::whereHas('tipoUsuario.persona', function ($q) {
            $q->where('id', Auth::id());
        })
            ->where('cupof', $request->cupof)
            ->where('estado', 'A')
            ->first();

        if (!$revista) {
            return back()->withErrors(['cupof' => 'No tienes permisos para este curso/materia.']);
        }

        $file = $request->file('archivo');
        $ruta = $file->store('tareas', 'local');

        try {
            $tarea = new Tarea();
            $tarea->titulo = $request->nombre;
            $tarea->descripcion = $request->descripcion ?? '';
            $tarea->tamanio = $file->getSize();
            $tarea->nombre_archivo = $file->getClientOriginalName();
            $tarea->ruta_archivo = $ruta;
            $tarea->tipo = $file->getClientOriginalExtension();
            $tarea->fecha_subida = now()->toDateString();
            $tarea->fecha_entrega = $request->fecha_entrega;
            $tarea->id_revista = $revista->id;
            $tarea->save();

            return redirect()->route('profesores.tareas.cargar', $request->cupof)
                ->with('success', 'Archivo subido correctamente.');
        } catch (\Exception $e) {
            // Si falla, eliminar el archivo subido
            if (Storage::disk('local')->exists($ruta)) {
                Storage::disk('local')->delete($ruta);
            }

            return back()->withErrors(['error' => 'Error al guardar la tarea: ' . $e->getMessage()]);
        }
    }

    // Seguimiento de tarea
    public function seguimiento($id)
    {
        try {
            // Obtener la tarea
            $tarea = Tarea::findOrFail($id);

            // Verificar permisos
            $this->verificarPermisos($tarea);

            // Obtener información del curso y materia a través de las relaciones correctas
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

            // Obtener alumnos del curso
            $alumnos = collect();

            if ($cupofModel && $cupofModel->curso) {
                $alumnos = DB::table('asignacionesalumnos as aa')
                    ->join('cursociclolectivo as ccl', 'aa.id_cursosciclolectivo', '=', 'ccl.id')
                    ->join('tipousuario as tu', 'aa.id_tipousuario', '=', 'tu.id')
                    ->join('persona as p', 'tu.id_persona', '=', 'p.id')
                    ->where('ccl.id_cursos', $cupofModel->curso->id)
                    ->where('ccl.ciclolectivo', date('Y'))
                    ->where('aa.estado', 'A')
                    ->select([
                        'aa.id',
                        'p.nombre',
                        'p.apellido',
                        'p.dni'
                    ])
                    ->get()
                    ->map(function ($alumno) use ($tarea) {
                        // Verificar si vio la tarea
                        $visto = DB::table('archivos_visto')
                            ->where('id_tarea', $tarea->id)
                            ->where('id_asignacionesalumnos', $alumno->id)
                            ->where('visto', 1)
                            ->exists();

                        // Verificar si entregó (solo para tareas con fecha de entrega)
                        $entrego = false;
                        if (!is_null($tarea->fecha_entrega)) {
                            $entrego = DB::table('tareas_alumnos')
                                ->where('id_tarea', $tarea->id)
                                ->where('id_asignacionesalumnos', $alumno->id)
                                ->where('borrado_fisico', 0)
                                ->exists();
                        }

                        // Obtener nota si existe
                        $nota = DB::table('tareas_notas')
                            ->where('id_tarea', $tarea->id)
                            ->where('id_asignacionesalumnos', $alumno->id)
                            ->value('nota');

                        return [
                            'id' => $alumno->id,
                            'nombre_completo' => $alumno->apellido . ', ' . $alumno->nombre,
                            'dni' => $alumno->dni,
                            'visto' => $visto,
                            'entrego' => $entrego,
                            'nota' => $nota,
                            'estado' => $this->determinarEstado($visto, $entrego, !is_null($tarea->fecha_entrega))
                        ];
                    });
            }

            return response()->json([
                'tarea' => [
                    'id' => $tarea->id,
                    'titulo' => $tarea->titulo,
                    'materia' => $materia,
                    'curso' => $curso,
                    'es_tarea' => !is_null($tarea->fecha_entrega)
                ],
                'alumnos' => $alumnos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Eliminar tarea
    public function destroy($id)
    {
        try {
            $tarea = Tarea::findOrFail($id);

            // Verificar permisos
            $this->verificarPermisos($tarea);

            // Eliminar archivo físico
            if ($tarea->ruta_archivo && Storage::disk('local')->exists($tarea->ruta_archivo)) {
                Storage::disk('local')->delete($tarea->ruta_archivo);
            }

            $tarea->delete();

            return response()->json(['success' => true, 'message' => 'Tarea eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la tarea: ' . $e->getMessage()], 500);
        }
    }

    // Descargar/visualizar archivo de tarea
    public function descargar($id)
    {
        $tarea = Tarea::findOrFail($id);
        $this->verificarPermisos($tarea);

        if (!Storage::disk('local')->exists($tarea->ruta_archivo)) {
            abort(404, 'Archivo no encontrado.');
        }

        $rutaCompleta = Storage::disk('local')->path($tarea->ruta_archivo);
        $extension = strtolower($tarea->tipo);

        // Sanitizar nombre del archivo para headers
        $nombreOriginal = $tarea->nombre_archivo;
        $nombreSinExtension = pathinfo($nombreOriginal, PATHINFO_FILENAME);

        // Sanitizar (sin tocar extensión)
        $nombreSanitizado = preg_replace('/[^\x20-\x7E]/', '', $nombreSinExtension);
        $nombreSanitizado = preg_replace('/\s+/', '_', $nombreSanitizado);
        $nombreSanitizado = trim($nombreSanitizado);

        // Reconstruir con extensión correcta
        $nombreFinal = $nombreSanitizado . '.' . $extension;

        // Si es PDF, mostrarlo en el navegador
        if ($extension === 'pdf') {
            return response()->file($rutaCompleta, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreFinal . '"'
            ]);
        }

        // Para otros archivos, descargar normalmente
        return response()->download($rutaCompleta, $nombreFinal);
    }

    // Verificar permisos del profesor para la tarea
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

    // Determinar estado del alumno respecto a la tarea
    private function determinarEstado($visto, $entrego, $esTarea)
    {
        if (!$visto) {
            return 'No visto';
        }

        if (!$esTarea) {
            return 'Visto';
        }

        return $entrego ? 'Visto y respondido' : 'Visto y no respondido';
    }
}
