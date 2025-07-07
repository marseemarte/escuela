<?php

namespace App\Http\Controllers\Orientaciones;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrientacionesController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener las orientaciones desde el modelo y pasarlas a la vista
        $orientaciones = []; // Reemplaza esto con la lógica para obtener las orientaciones

        return view('orientaciones.index', compact('orientaciones'));
    }
}
