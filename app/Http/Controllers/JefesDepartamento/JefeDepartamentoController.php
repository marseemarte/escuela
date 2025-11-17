<?php

namespace App\Http\Controllers\JefesDepartamento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JefeDepartamentoController extends Controller
{
    public function index()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))
            ->first();

        if (!$tipoUsuario) {
            abort(403, 'No tiene permisos de Jefe de Departamento');
        }

        $materias = $tipoUsuario->materiasComoJefe()
            ->with(['orientacion', 'cupof', 'planificacionActual'])
            ->get();

        return view('jefes-departamentos.inicio', compact('materias'));
    }

    public function materias()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))
            ->first();

        $materias = $tipoUsuario->materiasComoJefe()
            ->with(['orientacion', 'cupof.grupo.curso', 'asignacionesJefes'])
            ->get();

        return view('jefes-departamento.materias', compact('materias'));
    }

    public function profesores()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))
            ->first();

        // Obtener profesores que imparten las materias del jefe
        $materias = $tipoUsuario->materiasComoJefe()->pluck('id');

        $profesores = \App\Models\Revista::whereHas('cupof', function ($query) use ($materias) {
            $query->whereIn('id_materias', $materias);
        })
            ->with(['tipoUsuario.persona', 'cupof.materia', 'cupof.grupo.curso'])
            ->get()
            ->groupBy('id_tipo_usuario');

        return view('jefes-departamento.profesores', compact('profesores'));
    }

    public function proyectos()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))
            ->first();

        $materias = $tipoUsuario->materiasComoJefe()->pluck('id');

        $proyectos = \App\Models\Proyecto::whereHas('revista.cupof', function ($query) use ($materias) {
            $query->whereIn('id_materias', $materias);
        })
            ->with(['revista.cupof.materia', 'revista.cupof.grupo.curso', 'revista.tipoUsuario.persona'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('jefes-departamento.proyectos', compact('proyectos'));
    }
}
