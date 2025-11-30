<?php

namespace App\Http\Controllers\Profesores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cupof;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Revista;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProyectoController extends Controller
{
    public function index()
    {
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
                'proyectos' => function ($query) use ($usuario) {
                    // Solo cargar los proyectos del profesor actual
                    $query->whereHas('revista.tipousuario.persona', function ($q) use ($usuario) {
                        $q->where('dni', $usuario->dni);
                    });
                }
            ])
            ->select('cupof', 'id_materias', 'id_cursos', 'id_grupos', 'turno')
            ->distinct()
            ->orderBy('id_materias')
            ->get()
            ->map(function ($cupof) {
                return [
                    'cupof' => $cupof->cupof,
                    'materia' => $cupof->materia->nombre,
                    'curso' => $cupof->curso->ano . '° ' . $cupof->curso->division,
                    'grupo' => $cupof->grupo->nombre,
                    'turno' => $cupof->turno,
                    'total_proyectos' => $cupof->proyectos->count(),
                    'tiene_proyectos' => $cupof->proyectos->isNotEmpty()
                ];
            });

        return view('profesores.proyectos.index', compact('materias'));
    }

    /**
     * Cargar/ver proyectos de un CUPOF específico
     */
    public function cargar($cupof)
    {
        try {
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
                return redirect()->route('profesores.proyectos.index')
                    ->with('error', 'Materia no encontrada');
            }

            // Obtener la revista del profesor actual para esta materia
            $miRevista = Revista::whereHas('tipousuario.persona', function ($query) use ($usuario) {
                $query->where('dni', $usuario->dni);
            })
                ->where('cupof', $cupof)
                ->where('situacion', 'A')
                ->first();

            // Verificar que el profesor tenga asignación activa
            if (!$miRevista) {
                return redirect()->route('profesores.proyectos.index')
                    ->with('error', 'No tiene asignación activa para esta materia');
            }

            // Obtener MIS proyectos (del profesor actual)
            $misProyectos = Proyecto::where('cupof', $cupof)
                ->where('id_revista', $miRevista->id)
                ->with(['revista.tipoUsuario.persona'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('profesores.proyectos.cargar', compact(
                'cupofInfo',
                'miRevista',
                'misProyectos'
            ));
        } catch (\Exception $e) {
            return redirect()->route('profesores.proyectos.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Guardar un nuevo proyecto
     */
    public function guardar(Request $request)
    {
        try {
            $usuario = Auth::user();

            // Verificar que el profesor tenga permiso sobre esta revista
            $revista = Revista::where('id', $request->id_revista)
                ->where('cupof', $request->cupof)
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

            $request->validate([
                'archivo' => [
                    'required',
                    'file',
                    'max:20480', // 20 MB para proyectos
                ],
                'cupof' => 'required|exists:cupof,cupof',
                'id_revista' => 'required|exists:revista,id',
            ], [
                'archivo.required' => 'Debe seleccionar un archivo',
                'archivo.max' => 'El archivo no debe superar los 20 MB',
            ]);

            // Validación adicional manual del tipo de archivo
            $archivo = $request->file('archivo');
            $extension = strtolower($archivo->getClientOriginalExtension());
            $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar'];

            if (!in_array($extension, $extensionesPermitidas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se permiten archivos PDF, Word, Excel, PowerPoint o comprimidos',
                    'errors' => ['archivo' => ['Tipo de archivo no permitido']]
                ], 422);
            }

            DB::beginTransaction();

            // Procesar el archivo
            $nombreOriginal = $archivo->getClientOriginalName();
            $tamanio = $archivo->getSize();

            $nombreArchivo = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME))
                . '_' . time()
                . '.' . $extension;

            $rutaDirectorio = "proyectos/{$request->cupof}/{$request->id_revista}";
            $rutaArchivo = $archivo->storeAs($rutaDirectorio, $nombreArchivo, 'local');

            // Crear el proyecto con SOLO los campos de la migración
            $proyecto = Proyecto::create([
                'tamanio' => $tamanio,
                'nombre_archivo' => $nombreOriginal,
                'ruta_archivo' => $rutaArchivo,
                'id_revista' => $request->id_revista,
                'cupof' => $request->cupof,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto guardado exitosamente',
                'data' => [
                    'id' => $proyecto->id,
                    'nombre' => $proyecto->nombre_archivo,
                    'tamanio' => number_format($proyecto->tamanio / 1024 / 1024, 2) . ' MB',
                    'fecha' => $proyecto->created_at->format('d/m/Y H:i'),
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

            if (isset($rutaArchivo) && Storage::disk('local')->exists($rutaArchivo)) {
                Storage::disk('local')->delete($rutaArchivo);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un proyecto (solo el profesor propietario)
     */
    public function eliminar($id)
    {
        try {
            DB::beginTransaction();

            $proyecto = Proyecto::findOrFail($id);
            $usuario = Auth::user();

            // Verificar permisos (solo el propietario puede eliminar)
            $revista = Revista::where('id', $proyecto->id_revista)
                ->whereHas('tipousuario.persona', function ($query) use ($usuario) {
                    $query->where('dni', $usuario->dni);
                })
                ->first();

            if (!$revista) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permiso para eliminar este proyecto'
                ], 403);
            }

            // Eliminar archivo físico
            if (Storage::disk('local')->exists($proyecto->ruta_archivo)) {
                Storage::disk('local')->delete($proyecto->ruta_archivo);
            }

            $proyecto->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar un proyecto
     */
    public function descargar($id)
    {
        try {
            $usuario = Auth::user();
            $proyecto = Proyecto::with('cupof')->findOrFail($id);

            // Verificar si es el profesor propietario
            $esPropietario = Revista::where('id', $proyecto->id_revista)
                ->whereHas('tipousuario.persona', function ($query) use ($usuario) {
                    $query->where('dni', $usuario->dni);
                })
                ->exists();

            // Verificar si es jefe del departamento al que pertenece la materia
            $esJefeDepartamento = Departamento::whereHas('materias', function ($query) use ($proyecto) {
                $query->where('materias.id', $proyecto->getRelation('cupof')->id_materias);
            })
                ->whereHas('tipoUsuario.persona', function ($query) use ($usuario) {
                    $query->where('dni', $usuario->dni);
                })
                ->where('estado', 'A')
                ->exists();

            if (!$esPropietario && !$esJefeDepartamento) {
                return redirect()->back()->with('error', 'No tiene permiso para descargar este proyecto');
            }

            $rutaCompleta = storage_path('app/private/' . $proyecto->ruta_archivo);

            if (!file_exists($rutaCompleta)) {
                return redirect()->back()->with('error', 'El archivo no existe');
            }

            return response()->download($rutaCompleta, $proyecto->nombre_archivo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar: ' . $e->getMessage());
        }
    }
}
