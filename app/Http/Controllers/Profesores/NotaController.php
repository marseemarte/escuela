<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        return view('profesores.notas');
    }

    public function materias()
    {
        return view('profesores.notasmaterias');
    }
    public function lista()
    {
        return view('profesores.notaslista');
    }

}
