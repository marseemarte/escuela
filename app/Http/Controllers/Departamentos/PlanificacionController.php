<?php

namespace App\Http\Controllers\Departamentos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use App\Models\Planificacion;


class PlanificacionController extends Controller
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

        return view('departamento.planificaciones.index', compact('departamento', 'materias'));
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

        $planificaciones = Planificacion::where('id_materia', $materiaId)
            ->with([
                'materia',
                'revista.cupof.curso',
                'revista.cupof.grupo',
                'revista.tipoUsuario.persona'
            ])
            ->get()->sortBy(function ($planificacion) {
                return $planificacion->revista->tipoUsuario->persona->apellido;
            });

        $materia = $departamento->materias()->findOrFail($materiaId);

        return view('departamento.planificaciones.show', compact('departamento', 'planificaciones', 'materia'));
    }
}
