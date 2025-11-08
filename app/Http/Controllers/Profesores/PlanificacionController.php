<?php

namespace App\Http\Controllers\Profesores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cupof;
use Illuminate\Support\Facades\Auth;

class PlanificacionController extends Controller
{
    public function index()
    {
        // Verificar si el usuario es profesor
        $usuario = Auth::user();

        // Obtener materias asignadas al profesor de forma optimizada
        $materias = Cupof::query()
            ->where('estado', 'A')
            ->whereHas('revistas', function ($query) use ($usuario) {
                $query->where('situacion', 'A')
                    ->whereHas('tipousuario.persona', function ($personaQuery) use ($usuario) {
                        $personaQuery->where('dni', $usuario->dni);
                    });
            })
            ->with([
                'materia:id,nombre',
                'curso:id,division,ano',
                'grupo:id,nombre',
            ])
            ->select('cupof', 'id_materias', 'id_cursos', 'id_grupos', 'turno')
            ->distinct()
            ->orderBy('id_materias')
            ->get();

        return view('profesores.planificaciones.index', compact('materias'));
    }

    public function cargar($cupof)
    {
        // Lógica para cargar las planificaciones de la materia específica
        // Puedes obtener las planificaciones desde la base de datos según el cupof



        return view('profesores.planificaciones.cargar');
    }
}
