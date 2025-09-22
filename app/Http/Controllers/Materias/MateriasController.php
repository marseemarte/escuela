<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use App\Models\Taller;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre')->get();
        return view('materias.index', compact('materias'));
    }
    
    public function cambiarOrientacion(Request $request, $id)
    {
        \Log::info('Datos recibidos en cambiarOrientacion', [
            'materia_id' => $id,
            'orientacion_id' => $request->orientacion_id,
            'anio' => $request->anio,
            'tipo' => $request->tipo
        ]);
        
        try {

            $request->validate([
                'orientacion_id' => 'required|exists:orientaciones,id',
                'anio' => 'required|integer|min:1|max:7',
                'tipo' => 'required|in:materia,taller'
            ]);

            $materia = Materia::findOrFail($id);
            
            // Si el tipo es 'taller', crear un registro en la tabla talleres
            if ($request->tipo === 'taller') {
                \Log::info('Creando taller desde MateriasController', [
                    'materia_id' => $materia->id,
                    'nombre' => $materia->nombre,
                    'orientacion_id' => $request->orientacion_id,
                    'anio' => $request->anio,
                    'tipo' => $request->tipo
                ]);
                
                $taller = Taller::create([
                    'nombre' => $materia->nombre,
                    'abreviatura' => $materia->abreviatura,
                    'estado' => $materia->estado,
                    'resumen' => $materia->resumen,
                    'orientacion_id' => $request->orientacion_id,
                    'anio' => $request->anio,
                ]);
                
                \Log::info('Taller creado desde MateriasController', ['taller_id' => $taller->id]);
                
                // Eliminar la materia de la tabla materias
                $materia->delete();
                
                \Log::info('Materia eliminada desde MateriasController', ['materia_id' => $materia->id]);
                
                return redirect()->route('orientaciones.show', $request->orientacion_id)
                    ->with('success', 'Taller agregado correctamente a la orientación.');
            } else {
                // Si es materia, actualizar normalmente
                $materia->orientacion_id = $request->orientacion_id;
                $materia->anio = $request->anio;
                $materia->tipo = $request->tipo;
                $materia->save();
                
                $mensaje = $request->orientacion_id == 5 ? 
                    'Materia movida a Sin clasificar correctamente.' : 
                    'Materia actualizada correctamente.';
                
                return redirect()->route('orientaciones.show', $request->orientacion_id)
                    ->with('success', $mensaje);
            }
        } catch (\Exception $e) {
            \Log::error('Error en cambiarOrientacion', [
                'error' => $e->getMessage(),
                'materia_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    public function create()
    {
        // Si tienes orientaciones, pásalas a la vista para el select
        $orientaciones = \App\Models\Cursos\Orientacion::all();
        return view('materias.create', compact('orientaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:70',
            'abreviatura' => 'required|string|max:15',
            'estado' => 'required|in:A,I',
            'resumen' => 'required|string|max:50',
            'orientacion_id' => 'required|exists:orientaciones,id',
            'anio' => 'required|integer|min:1|max:7',
            'tipo' => 'required|in:materia,taller'
        ]);

        Materia::create($request->only(['nombre', 'abreviatura', 'estado', 'resumen', 'orientacion_id', 'anio', 'tipo']));

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        $orientaciones = \App\Models\Cursos\Orientacion::all();
        return view('materias.edit', compact('materia', 'orientaciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:70',
            'abreviatura' => 'required|string|max:15',
            'estado' => 'required|in:A,I',
            'resumen' => 'required|string|max:50',
            'orientacion_id' => 'required|exists:orientaciones,id',
            'anio' => 'required|integer|min:1|max:7',
            'tipo' => 'required|in:materia,taller'
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($request->only(['nombre', 'abreviatura', 'estado', 'resumen', 'orientacion_id', 'anio', 'tipo']));

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }
}
