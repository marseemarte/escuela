<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener las materias desde el modelo y pasarlas a la vista
        $materias = []; // Reemplaza esto con la lógica para obtener las materias

        return view('materias.index', compact('materias'));
    }
}
