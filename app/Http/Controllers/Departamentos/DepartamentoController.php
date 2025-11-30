<?php

namespace App\Http\Controllers\Departamentos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Revista;
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

    public function profesores()
    {
        $tipoUsuario = Auth::user()->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        $departamento = \App\Models\Departamento::where('id_tipousuario', $tipoUsuario->id)->first();

        if (!$departamento) {
            abort(403, 'No es jefe de ningún departamento');
        }

        // Obtener IDs de materias del departamento
        $materiaIds = $departamento->materias->pluck('id');

        // Obtener profesores con sus asignaciones
        $revistas = \App\Models\Revista::where('situacion', 'A')
            ->whereHas('cupof', function ($query) use ($materiaIds) {
                $query->whereIn('id_materias', $materiaIds)
                    ->where('estado', 'A');
            })
            ->with([
                'tipoUsuario.persona',
                'cupof.materia',
                'cupof.curso',
                'cupof.grupo'
            ])
            ->get();

        // Construir array de profesores con verificación de proyectos y planificaciones
        $profesores = $revistas->map(function ($revista) {
            $cupof = $revista->getRelation('cupof');

            return [
                'persona' => $revista->tipoUsuario->persona,
                'materia' => $cupof->materia,
                'curso' => $cupof->curso,
                'grupo' => $cupof->grupo,
                'tiene_proyecto' => \App\Models\Proyecto::where('id_revista', $revista->id)->exists(),
                'tiene_planificacion' => \App\Models\Planificacion::where('id_revista', $revista->id)
                    ->where('id_materia', $cupof->id_materias)
                    ->exists(),
            ];
        })->sortBy(function ($profesor) {
            return $profesor['persona']->apellido;
        });

        return view('departamento.profesores', compact('departamento', 'profesores'));
    }
}
