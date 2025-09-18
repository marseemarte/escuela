<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\TareaAlumno;
use App\Models\TareaNota;

class CorregirTareaController extends Controller
{
    // Mostrar lista de alumnos con sus tareas
    public function index($tareaId)
    {
        $tarea = Tarea::findOrFail($tareaId);

        $respuestas = TareaAlumno::where('id_tarea', $tareaId)
            ->with('alumno') // asumir relación en modelo TareaAlumno
            ->get();

        return view('profesores.corregir', compact('tarea', 'respuestas'));
    }

    // Guardar nota y devolución
    public function guardar(Request $request, $tareaAlumnoId)
    {
        $request->validate([
            'nota' => 'required|numeric|min:1|max:10',
            'devolucion' => 'nullable|string|max:200'
        ]);

        $tareaAlumno = TareaAlumno::findOrFail($tareaAlumnoId);

        TareaNota::updateOrCreate(
            ['id_tarea' => $tareaAlumno->id_tarea, 'id_asignacionesalumnos' => $tareaAlumno->id_asignacionesalumnos],
            ['nota' => $request->nota]
        );

        return redirect()->back()->with('success', 'Nota guardada correctamente.');
    }
}
