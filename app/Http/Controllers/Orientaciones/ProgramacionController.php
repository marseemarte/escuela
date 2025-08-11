<?php

namespace App\Http\Controllers\Orientaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramacionController extends Controller
{
    public function index()
    {
        return view('orientaciones.programacion.index');
    }

    public function edit()
    {
        // Datos de ejemplo para la vista de edición
        $programacion = (object) [
            'id' => 1,
            'division' => 'A',
            'ano' => 4,
            'turno' => 'Mañana'
        ];
        
        $orientaciones = [
            (object) ['id' => 1, 'nombre' => 'Programación'],
            (object) ['id' => 2, 'nombre' => 'MMO'],
            (object) ['id' => 3, 'nombre' => 'Turismo']
        ];

        return view('orientaciones.programacion.edit', compact('programacion', 'orientaciones'));
    }

    public function update(Request $request, $id)
    {
        // Aquí iría la lógica para actualizar en la base de datos
        return redirect()->route('programacion.index')->with('success', 'Plan de estudio actualizado correctamente');
    }
}
