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
    public function index()
    {
        // Verificar autenticación
        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return redirect()->route('login');
        }

        // Obtener materias asignadas al profesor
        $materias = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
            ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
            ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
            ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
            ->where('persona.id', $usuarioId)
            ->where('cupof.estado', 'A')
            ->where('revista.situacion', 'A') // Solo asignaciones activas
            ->select(
                'cupof.cupof',
                'materias.id as materia_id',
                'materias.nombre as materia_nombre',
                'cursos.division',
                'cursos.ano',
                'grupos.nombre as grupo_nombre',
                'cupof.turno'
            )
            ->distinct()
            ->get();

        return view('profesores.tareas.index', compact('materias'));
    }

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

        // Obtener módulos (tareas sin fecha de entrega) para este CUPOF específico
        $modulos = Tarea::where('id_revista', $revista->id)
            ->whereNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function ($tarea) use ($cupofModel) {
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

                return [
                    'id' => $tarea->id,
                    'titulo' => $tarea->titulo,
                    'curso' => $curso,
                    'materia' => $materia,
                    'fecha_subida' => $tarea->fecha_subida ? $tarea->fecha_subida->format('d/m/Y') : date('d/m/Y'),
                    'archivo' => $tarea->nombre_archivo,
                    'vistos' => 0 // Temporal, implementar después
                ];
            });

        // Obtener tareas (con fecha de entrega) para este CUPOF específico
        $tareas = Tarea::where('id_revista', $revista->id)
            ->whereNotNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function ($tarea) use ($cupofModel) {
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

                return [
                    'id' => $tarea->id,
                    'titulo' => $tarea->titulo,
                    'curso' => $curso,
                    'materia' => $materia,
                    'fecha_subida' => $tarea->fecha_subida ? $tarea->fecha_subida->format('d/m/Y') : date('d/m/Y'),
                    'fecha_entrega' => $tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : '-',
                    'archivo' => $tarea->nombre_archivo,
                    'entregas' => 0, // Temporal
                    'vistos' => 0 // Temporal
                ];
            });

        return view('profesores.tareas.cargar', compact('cursos', 'modulos', 'tareas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'cupof' => 'required|integer|exists:cupof,cupof',
            'archivo' => 'required|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png',
            'fecha_entrega' => 'nullable|date|after:today'
        ]);

        // Obtener la revista activa del profesor para este CUPOF
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
                    ->map(function($alumno) use ($tarea) {
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

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);

        // Verificar permisos
        $this->verificarPermisos($tarea);

        // Eliminar archivo físico
        if ($tarea->ruta_archivo && Storage::disk('local')->exists($tarea->ruta_archivo)) {
            Storage::disk('local')->delete($tarea->ruta_archivo);
        }

        $tarea->delete();

        return response()->json(['success' => true, 'message' => 'Tarea eliminada correctamente.']);
    }

    public function descargar($id)
    {
        $tarea = Tarea::findOrFail($id);
        $this->verificarPermisos($tarea);

        if (!Storage::disk('local')->exists($tarea->ruta_archivo)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->download(
            storage_path('app/' . $tarea->ruta_archivo),
            $tarea->nombre_archivo
        );
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