<?php

namespace App\Http\Controllers\Orientaciones;

use App\Http\Controllers\Controller;
use App\Models\Programacion;
use Illuminate\Http\Request;

class ProgramacionController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener las orientaciones desde el modelo y pasarlas a la vista
        $programacion = []; // Reemplaza esto con la lógica para obtener las orientaciones

        return view('orientaciones.programacion.index', compact('programacion'));
    }
    public function edit()
    {
        $programacion = Programacion::all();
        return view('orientaciones.programacion.edit', compact('programacion'));
    }

    public function update(Request $request, $id)
    {
        $programacion = Programacion::findOrFail($id);
        $programacion->update($request->all());
        return redirect()->route('programacion.index')->with('success', 'Plan de estudio actualizado correctamente');
    }
}
