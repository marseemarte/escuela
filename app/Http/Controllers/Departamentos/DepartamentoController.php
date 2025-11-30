<?php

namespace App\Http\Controllers\Departamentos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Proyecto;
use App\Models\Revista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartamentoController extends Controller
{
    public function index()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        if (!$tipoUsuario) {
            abort(403, 'No tiene permisos de Profesor');
        }

        // Obtener departamento donde este profesor es jefe
        $departamento = Departamento::where('id_tipousuario', $tipoUsuario->id)
            ->with(['materias.orientacion', 'materias.cupof', 'materias.planificacionActual'])
            ->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        $materias = $departamento->materias;

        return view('departamento.inicio', compact('departamento', 'materias'));
    }

    public function materias()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        $departamento = Departamento::where('id_tipousuario', $tipoUsuario->id)
            ->with(['materias.orientacion', 'materias.cupof.grupo.curso'])
            ->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        $materias = $departamento->materias;

        return view('departamento.materias', compact('departamento', 'materias'));
    }

    public function profesores()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        $departamento = Departamento::where('id_tipousuario', $tipoUsuario->id)->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        // Obtener profesores que imparten materias del departamento
        $materias = $departamento->materias->pluck('id');

        $profesores = Revista::whereHas('cupof', function ($query) use ($materias) {
            $query->whereIn('id_materias', $materias);
        })
            ->with(['tipoUsuario.persona', 'cupof.materia', 'cupof.grupo.curso'])
            ->get()
            ->groupBy('id_tipo_usuario');

        return view('departamento.profesores', compact('departamento', 'profesores'));
    }

    public function proyectos()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        $departamento = Departamento::where('id_tipousuario', $tipoUsuario->id)->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        $materias = $departamento->materias->pluck('id');

        $proyectos = Proyecto::whereHas('revista.cupof', function ($query) use ($materias) {
            $query->whereIn('id_materias', $materias);
        })
            ->with(['revista.cupof.materia', 'revista.cupof.grupo.curso', 'revista.tipoUsuario.persona'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('departamento.proyectos', compact('departamento', 'proyectos'));
    }
}
