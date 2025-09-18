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
        $usuarioId = Auth::id();
        
        if (!$usuarioId) {
            return redirect()->route('login');
        }
        
        // Primero, obtengamos las revistas sin eager loading para debug
        $revistas = Revista::whereHas('tipoUsuario.persona', function($q) use ($usuarioId) {
                $q->where('id', $usuarioId);
            })
            ->where('estado', 'A')
            ->get();

        if ($revistas->isEmpty()) {
            return view('profesores.tareas', [
                'cursos' => collect(),
                'modulos' => collect(), 
                'tareas' => collect()
            ])->with('info', 'No tienes cargos docentes asignados.');
        }

        // Ahora carga las relaciones manualmente para cada revista
        $cursos = collect();
        foreach($revistas as $revista) {
            $cupofModel = Cupof::with(['materia', 'curso'])->find($revista->cupof);
            
            if ($cupofModel && $cupofModel->curso) {
                $cursos->push([
                    'id' => $cupofModel->cupof,
                    'nombre' => $cupofModel->curso->ano . '°' . $cupofModel->curso->division,
                    'materia' => $cupofModel->materia->nombre ?? 'Sin materia'
                ]);
            }
        }
        
        $cursos = $cursos->unique('id')->values();

        // Para módulos y tareas, usemos queries más simples
        $modulos = Tarea::whereIn('id_revista', $revistas->pluck('id'))
            ->whereNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function($tarea) {
                // Obtener info del curso de forma manual
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

        $tareas = Tarea::whereIn('id_revista', $revistas->pluck('id'))
            ->whereNotNull('fecha_entrega')
            ->orderByDesc('fecha_subida')
            ->get()
            ->map(function($tarea) {
                // Obtener info del curso de forma manual
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

        return view('profesores.tareas', compact('cursos', 'modulos', 'tareas'));
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
        $revista = Revista::whereHas('tipoUsuario.persona', function($q) {
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

            return redirect()->route('profesores.tareas.index')
                ->with('success', 'Archivo subido correctamente.');
        } catch (\Exception $e) {
            // Si falla, eliminar el archivo subido
            if (Storage::disk('local')->exists($ruta)) {
                Storage::disk('local')->delete($ruta);
            }
            
            return back()->withErrors(['error' => 'Error al guardar la tarea: ' . $e->getMessage()]);
        }
    }

    public function seguimiento($tareaId)
    {
        $tarea = Tarea::with([
            'revista.cupof.curso',
            'revista.cupof.materia'
        ])->findOrFail($tareaId);

        // Verificar que el profesor tiene permisos sobre esta tarea
        $this->verificarPermisos($tarea);

        // Obtener información básica de la tarea
        $curso = 'Sin asignar';
        $materia = 'Sin materia';
        
        if ($tarea->revista && $tarea->revista->cupof) {
            if ($tarea->revista->cupof->curso) {
                $curso = $tarea->revista->cupof->curso->ano . '°' . $tarea->revista->cupof->curso->division;
            }
            if ($tarea->revista->cupof->materia) {
                $materia = $tarea->revista->cupof->materia->nombre;
            }
        }

        // Obtener todos los alumnos del curso (usando query builder por simplicidad)
        $alumnos = collect(); // Por ahora devolver vacío hasta resolver las relaciones
        
        if ($tarea->revista && $tarea->revista->cupof && $tarea->revista->cupof->curso) {
            $alumnos = DB::table('asignacionesalumnos as aa')
                ->join('cursociclolectivo as ccl', 'aa.id_cursosciclolectivo', '=', 'ccl.id')
                ->join('tipousuario as tu', 'aa.id_tipousuario', '=', 'tu.id')
                ->join('persona as p', 'tu.id_persona', '=', 'p.id')
                ->where('ccl.id_cursos', $tarea->revista->cupof->curso->id)
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
                    // Por simplicidad, devolver estados básicos
                    return [
                        'id' => $alumno->id,
                        'nombre_completo' => $alumno->apellido . ', ' . $alumno->nombre,
                        'dni' => $alumno->dni,
                        'visto' => rand(0,1) == 1, // Temporal
                        'entrego' => rand(0,1) == 1, // Temporal
                        'nota' => null,
                        'estado' => 'Visto' // Temporal
                    ];
                });
        }

        return response()->json([
            'tarea' => [
                'titulo' => $tarea->titulo,
                'curso' => $curso,
                'materia' => $materia,
                'es_tarea' => !is_null($tarea->fecha_entrega)
            ],
            'alumnos' => $alumnos
        ]);
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
        $tienePermiso = Revista::whereHas('tipoUsuario.persona', function($q) use ($usuarioId) {
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