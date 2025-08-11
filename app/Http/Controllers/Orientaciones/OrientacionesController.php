<?php

namespace App\Http\Controllers\Orientaciones;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Orientacion;
use App\Models\Materia;
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
        $materias = Materia::porOrientacion($id)->get();
        return view('orientaciones.show', compact('materias', 'orientacion'));
    }


}
