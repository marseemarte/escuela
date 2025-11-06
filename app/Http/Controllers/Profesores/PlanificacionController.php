<?php

namespace App\Http\Controllers\Profesores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Revista;
use App\Models\Cupof;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanificacionController extends Controller
{
    public function index()
    {
          // Verificar autenticación
        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return redirect()->route('login');
        }

        // Obtener materias asignadas al profesor
        $materias = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
            ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
            ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
            ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
            ->where('persona.id', $usuarioId)
            ->where('cupof.estado', 'A')
            ->where('revista.situacion', 'A') // Solo asignaciones activas
            ->select(
                'cupof.cupof',
                'materias.id as materia_id',
                'materias.nombre as materia_nombre',
                'cursos.division',
                'cursos.ano',
                'grupos.nombre as grupo_nombre',
                'cupof.turno'
            )
            ->distinct()
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
