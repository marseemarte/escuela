<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Models\Materia;
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
        $request->validate([
            'orientacion_id' => 'required|exists:orientaciones,id',
            'anio' => 'required|integer|min:1|max:7',
            'tipo' => 'required|in:materia,taller'
        ]);

        $materia = Materia::findOrFail($id);
        $materia->orientacion_id = $request->orientacion_id;
        $materia->anio = $request->anio;
        $materia->tipo = $request->tipo;
        $materia->save();

        return redirect()->back()->with('success', 'Materia actualizada correctamente.');
    }
}
