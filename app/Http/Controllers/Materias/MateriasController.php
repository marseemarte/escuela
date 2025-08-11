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
}
