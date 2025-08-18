<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorariosController extends Controller
{
    public function index(Request $request)
    {
        return view('profesores.horarios');
    }
}
