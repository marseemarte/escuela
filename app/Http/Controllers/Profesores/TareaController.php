<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index(Request $request)
    {
        return view('profesores.tareas');
    }
    public function corregir()
    {
        return view('profesores.corregir');
    }
}

?>
