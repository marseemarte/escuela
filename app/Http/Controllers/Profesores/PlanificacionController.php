<?php

namespace App\Http\Controllers\Profesores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cupof;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Planificacion;
use App\Models\Revista;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PlanificacionController extends Controller
{
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

        return view('profesores.planificaciones.index', compact('materias'));
    }

    public function cargar($cupof)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Debe estar autenticado');
            }

            $usuario = Auth::user();

            // Obtener información del CUPOF
            $cupofInfo = Cupof::where('cupof', $cupof)
                ->where('estado', 'A')
                ->with([
                    'materia:id,nombre',
                    'curso:id,division,ano',
                    'grupo:id,nombre',
                ])
                ->first();

            if (!$cupofInfo) {
                return redirect()->route('profesores.planificaciones.index')
                    ->with('error', 'Materia no encontrada');
            }

            // Obtener la revista del profesor actual para esta materia
            $miRevista = Revista::whereHas('tipousuario.persona', function ($query) use ($usuario) {
                $query->where('dni', $usuario->dni);
            })
                ->where('cupof', $cupof)
                ->where('situacion', 'A')
                ->first();

            if (!$miRevista) {
                return redirect()->route('profesores.planificaciones.index')
                    ->with('error', 'No tiene asignación activa para esta materia');
            }

            // Obtener MI planificación (del profesor actual)
            $miPlanificacion = Planificacion::where('id_materia', $cupofInfo->id_materias)
                ->where('id_revista', $miRevista->id)
                ->with(['revista.tipoUsuario.persona'])
                ->first();

            // Obtener planificaciones de OTROS profesores de la misma materia y año
            $otrasPlanificaciones = Planificacion::where('id_materia', $cupofInfo->id_materias)
                ->where('id_revista', '!=', $miRevista->id) // Excluir la mía
                ->whereHas('revista', function ($query) use ($cupofInfo) {
                    // Solo de profesores con la misma materia del mismo año
                    $query->where('situacion', 'A')
                        ->whereHas('cupof', function ($cupofQuery) use ($cupofInfo) {
                            $cupofQuery->whereHas('curso', function ($cursoQuery) use ($cupofInfo) {
                                $cursoQuery->where('ano', $cupofInfo->curso->ano);
                            });
                        });
                })
                ->with(['revista.tipoUsuario.persona', 'revista.cupof.curso', 'revista.cupof.grupo'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('profesores.planificaciones.cargar', compact(
                'cupofInfo',
                'miRevista',
                'miPlanificacion',
                'otrasPlanificaciones'
            ));
        } catch (\Exception $e) {
            return redirect()->route('profesores.planificaciones.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function guardar(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
                'id_materia' => 'required|exists:materias,id',
                'id_revista' => 'required|exists:revista,id',
            ], [
                'archivo.required' => 'Debe seleccionar un archivo',
                'archivo.mimes' => 'El archivo debe ser PDF, Word, Excel o PowerPoint',
                'archivo.max' => 'El archivo no debe superar los 10 MB',
            ]);

            DB::beginTransaction();

            $usuario = Auth::user();

            // Verificar que el profesor tenga permiso
            $revista = Revista::where('id', $request->id_revista)
                ->whereHas('tipousuario.persona', function ($query) use ($usuario) {
                    $query->where('dni', $usuario->dni);
                })
                ->first();

            if (!$revista) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para esta acción'
                ], 403);
            }

            // Verificar si ya existe una planificación
            $planificacionExistente = Planificacion::where('id_materia', $request->id_materia)
                ->where('id_revista', $request->id_revista)
                ->first();

            if ($planificacionExistente) {
                // Eliminar el archivo anterior
                if (Storage::disk('private')->exists($planificacionExistente->ruta_archivo)) {
                    Storage::disk('private')->delete($planificacionExistente->ruta_archivo);
                }
            }

            // Procesar el nuevo archivo
            $archivo = $request->file('archivo');
            $nombreOriginal = $archivo->getClientOriginalName();
            $tamanio = $archivo->getSize();
            $extension = $archivo->getClientOriginalExtension();

            $nombreArchivo = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME))
                . '_' . time()
                . '.' . $extension;

            $rutaDirectorio = "planificaciones/{$request->id_materia}/{$request->id_revista}";
            $rutaArchivo = $archivo->storeAs($rutaDirectorio, $nombreArchivo, 'private');

            // Crear o actualizar la planificación
            $planificacion = Planificacion::updateOrCreate(
                [
                    'id_materia' => $request->id_materia,
                    'id_revista' => $request->id_revista
                ],
                [
                    'tamanio' => $tamanio,
                    'nombre_archivo' => $nombreOriginal,
                    'ruta_archivo' => $rutaArchivo,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $planificacionExistente
                    ? 'Planificación actualizada exitosamente'
                    : 'Planificación guardada exitosamente',
                'data' => [
                    'id' => $planificacion->id,
                    'nombre' => $planificacion->nombre_archivo,
                    'tamanio' => $planificacion->tamanio_formateado,
                    'fecha' => $planificacion->created_at->format('d/m/Y H:i'),
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($rutaArchivo) && Storage::disk('private')->exists($rutaArchivo)) {
                Storage::disk('private')->delete($rutaArchivo);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();

            $planificacion = Planificacion::findOrFail($id);
            $usuario = Auth::user();

            // Verificar permisos
            $revista = Revista::where('id', $planificacion->id_revista)
                ->whereHas('tipousuario.persona', function ($query) use ($usuario) {
                    $query->where('dni', $usuario->dni);
                })
                ->first();

            if (!$revista) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para eliminar esta planificación'
                ], 403);
            }

            // Eliminar archivo físico
            if (Storage::disk('private')->exists($planificacion->ruta_archivo)) {
                Storage::disk('private')->delete($planificacion->ruta_archivo);
            }

            $planificacion->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Planificación eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function descargar($id)
    {
        try {
            $planificacion = Planificacion::findOrFail($id);
            $rutaCompleta = storage_path('app/private/' . $planificacion->ruta_archivo);

            if (!file_exists($rutaCompleta)) {
                return redirect()->back()->with('error', 'El archivo no existe');
            }

            return response()->download($rutaCompleta, $planificacion->nombre_archivo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar: ' . $e->getMessage());
        }
    }
}
