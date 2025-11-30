<?php

namespace App\Http\Controllers\Departamentos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    public function index()
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

        return view('departamento.proyectos.index', compact('departamento', 'materias'));
    }

    public function show($materiaId)
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        $departamento = Departamento::where('id_tipousuario', $tipoUsuario->id)->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        $proyectos = Proyecto::whereHas('revista.cupof', function ($query) use ($materiaId) {
            $query->where('id_materias', $materiaId);
        })
            ->with(['revista.cupof.materia', 'revista.cupof.grupo.curso', 'revista.tipoUsuario.persona'])
            ->get()->sortBy(function ($proyecto) {
                return $proyecto->revista->tipoUsuario->persona->apellido;
            });

        $materia = $departamento->materias()->findOrFail($materiaId);

        return view('departamento.proyectos.show', compact('departamento', 'proyectos', 'materia'));
    }
}
