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

    public function create()
    {
        // Si tienes orientaciones, pásalas a la vista para el select
        $orientaciones = \App\Models\Cursos\Orientacion::all();
        return view('materias.create', compact('orientaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'resumen' => 'nullable|string',
            'orientacion_id' => 'required|exists:orientaciones,id',
            'anio' => 'required|integer|min:1|max:7',
            'tipo' => 'required|in:materia,taller'
        ]);

        Materia::create($request->only(['nombre', 'resumen', 'orientacion_id', 'anio', 'tipo']));

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
            'nombre' => 'required|string|max:255',
            'resumen' => 'nullable|string',
            'orientacion_id' => 'required|exists:orientaciones,id',
            'anio' => 'required|integer|min:1|max:7',
            'tipo' => 'required|in:materia,taller'
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($request->only(['nombre', 'resumen', 'orientacion_id', 'anio', 'tipo']));

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }
}
