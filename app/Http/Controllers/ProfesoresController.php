<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfesoresController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return view('profesores.inicio');
    }
}
