<?php

namespace App\Http\Controllers\Orientaciones;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Orientacion;
use App\Models\Materia;
use App\Models\Taller;
use Illuminate\Http\Request;

class OrientacionesController extends Controller
{
    public function index()
    {
        $orientaciones = Orientacion::all();

        return view('orientaciones.index', compact('orientaciones'));
    }
    
    public function show($id)
    {
        $orientacion = Orientacion::findOrFail($id);
        $materias = Materia::where('orientacion_id', $id)->where('tipo', 'materia')->get();
        $talleres = Taller::where('orientacion_id', $id)->get();
        $materiasDisponibles = Materia::where('orientacion_id', '!=', $id)->orWhereNull('orientacion_id')->get();
        // Pasa todas las materias para el modal
        $allMaterias = Materia::with('orientacion')->get();
        $allTalleres = Taller::with('orientacion')->get();
        return view('orientaciones.show', compact('materias', 'talleres', 'orientacion', 'materiasDisponibles', 'allMaterias', 'allTalleres'));
    }

    public function create()
    {
        return view('orientaciones.create');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);
        $orientacion = Orientacion::create($request->all());
        return redirect()->route('orientaciones.index')->with('success', 'Orientación creada correctamente.');
    }
    /**
     * Obtener todas las materias disponibles
     */
    public function getAllMaterias()
    {
        $materias = Materia::with('orientacion')->get();
        
        return response()->json($materias->map(function($materia) {
            return [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'resumen' => $materia->resumen,
                'orientacion_id' => $materia->orientacion_id,
                'anio' => $materia->anio,
                'tipo' => $materia->tipo,
                'orientacion_nombre' => $materia->orientacion->nombre ?? 'Sin clasificar'
            ];
        }));
    }

    /**
     * Actualizar la orientación de una materia
     */
    public function updateMateriaOrientacion(Request $request)
    {
        try {
            $request->validate([
                'materia_id' => 'required|exists:materias,id',
                'orientacion_id' => 'required|exists:orientaciones,id',
                'anio' => 'required|integer|min:1|max:7',
                'tipo' => 'required|in:materia,taller'
            ]);

            $materia = Materia::findOrFail($request->materia_id);
            
            // Si el tipo es 'taller', crear un registro en la tabla talleres
            if ($request->tipo === 'taller') {
                Taller::create([
                    'nombre' => $materia->nombre,
                    'abreviatura' => $materia->abreviatura,
                    'estado' => $materia->estado,
                    'resumen' => $materia->resumen,
                    'orientacion_id' => $request->orientacion_id,
                    'anio' => $request->anio,
                ]);
                
                // Eliminar la materia de la tabla materias
                $materia->delete();
            } else {
                // Si es materia, actualizar normalmente
                $materia->orientacion_id = $request->orientacion_id;
                $materia->anio = $request->anio;
                $materia->tipo = $request->tipo;
                $materia->save();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Obtener todos los talleres disponibles
     */
    public function getAllTalleres()
    {
        $talleres = Taller::with('orientacion')->get();
        
        return response()->json($talleres->map(function($taller) {
            return [
                'id' => $taller->id,
                'nombre' => $taller->nombre,
                'resumen' => $taller->resumen,
                'orientacion_id' => $taller->orientacion_id,
                'anio' => $taller->anio,
                'tipo' => 'taller',
                'orientacion_nombre' => $taller->orientacion->nombre ?? 'Sin clasificar'
            ];
        }));
    }

    /**
     * Actualizar la orientación de un taller
     */
    public function updateTallerOrientacion(Request $request)
    {
        try {
            $request->validate([
                'taller_id' => 'required|exists:talleres,id',
                'orientacion_id' => 'required|exists:orientaciones,id',
                'anio' => 'required|integer|min:1|max:7',
            ]);

            $taller = Taller::findOrFail($request->taller_id);
            $taller->orientacion_id = $request->orientacion_id;
            $taller->anio = $request->anio;
            $taller->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
