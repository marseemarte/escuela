<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Materia;

class NotaController extends Controller
{
    public function index(Request $request)
    {
       $materias = Materia::all();

        return view('profesores.notas' , compact('materias'));
    }
    public function lista()
    {
        return view('profesores.notaslista');
    }

}
