<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use App\Models\Cursos\Curso;

use App\Models\Cursos\Orientacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $cursos = Curso::all();
        $orientaciones = Orientacion::all();
        return view('cursos.create', compact('cursos', 'orientaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division' => 'required|string|max:255',
            'ano'      => 'required|integer',
            'turno'    => 'required|string|max:255',
            // Solo valida orientación si corresponde
            'id_orientacion' => 'nullable|integer|exists:orientaciones,id',
        ]);

        // Crear el curso
        $curso = Curso::create($request->only(['division', 'ano', 'turno']));

        // Si el año es 4 o más y se seleccionó orientación, crea el registro en ciclo_superior
        if ($curso->ano >= 4 && $curso->ano <= 7 && $request->filled('id_orientacion')) {
            DB::table('ciclo_superior')->insert([
                'id_cursos' => $curso->id,
                'id_orientaciones' => $request->id_orientacion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        $orientaciones = Orientacion::all();
        return view('cursos.edit', compact('curso', 'orientaciones'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'division' => 'required|string|max:255',
            'ano'      => 'required|integer',
            'turno'    => 'required|string|max:255',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
}
