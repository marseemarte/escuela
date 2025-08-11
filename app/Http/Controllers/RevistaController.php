<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevistaController extends Controller
{
    public function index($cupof)
    {
        // Obtener información del cupof
        $cupo = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->where('cupof.cupof', $cupof)
            ->select(
                'cupof.cupof',
                'cupof.turno',
                'cupof.hsmodcar',
                'cupof.funcion',
                'cupof.cargo',
                'materias.nombre as materia_nombre',
                'cursos.ano as curso_ano',
                'cursos.division as curso_division'
            )
            ->first();

        // Obtener profesores asociados al cupof
        $profesores = DB::table('revista')
            ->join('persona', 'revista.fd', '=', 'persona.id')
            ->join('tipopersona', 'revista.id_tipousuario', '=', 'tipopersona.id')
            ->where('revista.cupof', $cupof)
            ->select(
                'persona.id',
                'persona.dni',
                'persona.nombre',
                'persona.apellido',
                'revista.situacion',
                'revista.fd as f_desde',
                'revista.fh as f_hasta',
                'revista.secuencia',
                'tipopersona.tipo as tipo_usuario'
            )
            ->orderBy('revista.secuencia', 'asc')
            ->get();

        return view('revista.index', compact('profesores', 'cupo'));
    }

    public function listarCupofs()
    {
        $cupofs = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->select(
                'cupof.cupof',
                'cupof.turno',
                'cupof.funcion',
                'cupof.cargo',
                'materias.nombre as materia_nombre',
                'cursos.ano as curso_ano',
                'cursos.division as curso_division'
            )
            ->orderBy('cupof.cupof', 'asc')
            ->get();

        return view('revista.listar', compact('cupofs'));
    }
}
