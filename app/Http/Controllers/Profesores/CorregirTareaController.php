<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorregirTareaController extends Controller
{
    // Pantalla principal de corrección (listado de entregas, por ejemplo)
    public function index()
    {
        return view('profesores.tareas.corregir');
    }

    // Pantalla para corregir una tarea puntual
    public function show($id)
    {
        // Más adelante acá vas a traer la tarea y su entrega
        return view('profesores.tareas.corregir-individual', compact('id'));
    }
}

