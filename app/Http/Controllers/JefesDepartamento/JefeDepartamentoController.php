<?php

namespace App\Http\Controllers\JefesDepartamento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JefeDepartamentoController extends Controller
{
    public function index(Request $request)
    {
        return view('jefes-departamento.inicio');
    }
}
