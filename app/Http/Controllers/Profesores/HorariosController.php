<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorariosController extends Controller
{
    public function index(Request $request)
    {
        // Días: clave = código que guarda la base (LUN/MAR/...) ; etiqueta = lo que se muestra
        $dias = [
            'LUN' => 'LUNES',
            'MAR' => 'MARTES',
            'MIE' => 'MIÉRCOLES',
            'JUE' => 'JUEVES',
            'VIE' => 'VIERNES',
        ];

        // 1) Horas activas (crea las filas)
        $horas = DB::table('horas')
            ->where('activo', 1)
            ->orderBy('hd')
            ->get();

        // 2) Registros: traemos horarios + materia + salon + metadata del curso/grupo via cursos/grupos
        $registros = DB::table('horarios')
            ->join('horas', 'horarios.id_horas', '=', 'horas.id')
            ->leftJoin('cupof', 'horarios.cupof', '=', 'cupof.cupof')
            ->leftJoin('materias', 'cupof.id_materias', '=', 'materias.id')
            ->leftJoin('salones', 'horarios.id_salones', '=', 'salones.id')
            ->leftJoin('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->leftJoin('grupos', 'cupof.id_grupos', '=', 'grupos.id')
            ->select(
                'horas.nombre as hora_nombre',
                'horas.hd',
                'horas.hh',
                'horarios.dia',
                'materias.nombre as materia',
                'materias.abreviatura as materia_abrev',
                'salones.numero as salon_numero',
                'salones.id as salon_id',
                'cupof.cupof as cupof_id',
                'cupof.turno as cupof_turno',
                // metadata traída desde cursos/grupos (evita columnas inexistentes en cupof)
                'cursos.ano as cupof_anio',
                'cursos.division as cupof_division',
                'grupos.nombre as cupof_grupo'
            )
            ->where('horarios.estado', 'A')
            ->where('horas.activo', 1)
            ->get();

        // 3) Extraer cupof únicos (filtramos null/empty)
        $cupofs = collect($registros)->pluck('cupof_id')->filter()->unique()->values()->all();

        // 4) Fallback: si no obtuvimos cupofs desde la consulta (vacío), extraerlos directamente de horarios
        if (empty($cupofs)) {
            $cupofs = DB::table('horarios')
                ->distinct()
                ->pluck('cupof')
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        // 5) Obtener metadata de cupof -> cursos -> grupos (por si faltó en $registros)
        $cursosMeta = [];
        if (!empty($cupofs)) {
            $cupofRows = DB::table('cupof')
                ->leftJoin('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->leftJoin('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->whereIn('cupof.cupof', $cupofs)
                ->select(
                    'cupof.cupof',
                    'cupof.turno',
                    'cursos.ano as cupof_anio',
                    'cursos.division as cupof_division',
                    'grupos.nombre as cupof_grupo'
                )
                ->get();

            foreach ($cupofRows as $row) {
                $cursosMeta[$row->cupof] = [
                    'cupof' => $row->cupof,
                    'anio' => $row->cupof_anio ?? null,
                    'division' => $row->cupof_division ?? null,
                    'grupo_nombre' => $row->cupof_grupo ?? null,
                    'turno' => $row->turno ?? null,
                ];
            }
        }

        // 6) Mapear cupof => profesor (última revista activa por cupof)
        $profesoresMap = [];
        if (!empty($cupofs)) {
            $rows = DB::table('revista as r')
                ->join('tipousuario as t', 'r.id_tipousuario', '=', 't.id')
                ->join('persona as p', 't.id_persona', '=', 'p.id')
                ->select('r.cupof', 'r.secuencia', 'r.id as revista_id', DB::raw("CONCAT(p.apellido,' ',p.nombre) as profesor"))
                ->whereIn('r.cupof', $cupofs)
                ->where('r.estado', 'A')
                ->orderBy('r.cupof')
                ->orderBy('r.secuencia', 'desc')
                ->orderBy('r.id', 'desc')
                ->get();

            foreach ($rows as $row) {
                $cup = $row->cupof;
                if (!isset($profesoresMap[$cup])) {
                    $profesoresMap[$cup] = $row->profesor;
                }
            }
        }

        // 7) Estructura base de franjas (fila por hora)
        $horariosBase = [];
        foreach ($horas as $h) {
            $label = trim($h->nombre) ?: (trim($h->hd) . ' - ' . trim($h->hh));
            $horariosBase[$label] = array_fill_keys(array_keys($dias), null);
        }

        // 8) Si $registros vino vacío, reconsultar limitando a cupofs detectados (ayuda si hubo problemas en el leftJoin)
        if ((empty($registros) || count($registros) === 0) && !empty($cupofs)) {
            $registros = DB::table('horarios')
                ->join('horas', 'horarios.id_horas', '=', 'horas.id')
                ->leftJoin('cupof', 'horarios.cupof', '=', 'cupof.cupof')
                ->leftJoin('materias', 'cupof.id_materias', '=', 'materias.id')
                ->leftJoin('salones', 'horarios.id_salones', '=', 'salones.id')
                ->leftJoin('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->leftJoin('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->select(
                    'horas.nombre as hora_nombre',
                    'horas.hd',
                    'horas.hh',
                    'horarios.dia',
                    'materias.nombre as materia',
                    'materias.abreviatura as materia_abrev',
                    'salones.numero as salon_numero',
                    'salones.id as salon_id',
                    'cupof.cupof as cupof_id',
                    'cupof.turno as cupof_turno',
                    'cursos.ano as cupof_anio',
                    'cursos.division as cupof_division',
                    'grupos.nombre as cupof_grupo'
                )
                ->where('horarios.estado', 'A')
                ->where('horas.activo', 1)
                ->whereIn('horarios.cupof', $cupofs)
                ->get();
        }

        // 9) Construir horarios por curso (cupof) y lista de cursos
        $horariosPorCurso = [];
        $cursos = [];

        foreach ($registros as $r) {
            $cup = $r->cupof_id ?? null;
            if (!$cup) {
                continue;
            }

            // Metadata del curso: preferimos la que venga en el registro, si no usamos cursosMeta
            if (!isset($cursos[$cup])) {
                $cursos[$cup] = [
                    'cupof' => $cup,
                    'anio' => $r->cupof_anio ?? ($cursosMeta[$cup]['anio'] ?? null),
                    'division' => $r->cupof_division ?? ($cursosMeta[$cup]['division'] ?? null),
                    'grupo_nombre' => $r->cupof_grupo ?? ($cursosMeta[$cup]['grupo_nombre'] ?? null),
                    'turno' => $r->cupof_turno ?? ($cursosMeta[$cup]['turno'] ?? null),
                ];
            }

            // Inicializar la matriz de franjas para este cupof (clonando la base)
            if (!isset($horariosPorCurso[$cup])) {
                $horariosPorCurso[$cup] = [];
                foreach ($horariosBase as $label => $v) {
                    $horariosPorCurso[$cup][$label] = array_fill_keys(array_keys($dias), null);
                }
            }

            $label = trim($r->hora_nombre) ?: (trim($r->hd) . ' - ' . trim($r->hh));
            $dia = strtoupper(trim($r->dia)); // LUN/MAR/...

            $info = [
                'titulo' => $r->materia ?? null,
                'abreviatura' => $r->materia_abrev ?? null,
                'salon' => $r->salon_numero ?? null,
                'salon_id' => $r->salon_id ?? null,
                'cupof' => $cup,
                'profesor' => $cup && isset($profesoresMap[$cup]) ? $profesoresMap[$cup] : null,
            ];

            if (!array_key_exists($label, $horariosPorCurso[$cup])) {
                $horariosPorCurso[$cup][$label] = array_fill_keys(array_keys($dias), null);
            }

            if (array_key_exists($dia, $horariosPorCurso[$cup][$label])) {
                $horariosPorCurso[$cup][$label][$dia] = $info;
            }
        }

        // 10) Reconstruir $horarios global (compatibilidad con la vista original)
        $horarios = $horariosBase;
        foreach ($registros as $r) {
            $label = trim($r->hora_nombre) ?: (trim($r->hd) . ' - ' . trim($r->hh));
            $dia = strtoupper(trim($r->dia));
            $cup = $r->cupof_id;
            $info = [
                'titulo' => $r->materia ?? null,
                'abreviatura' => $r->materia_abrev ?? null,
                'salon' => $r->salon_numero ?? null,
                'salon_id' => $r->salon_id ?? null,
                'cupof' => $cup ?? null,
                'profesor' => $cup && isset($profesoresMap[$cup]) ? $profesoresMap[$cup] : null,
            ];
            if (!array_key_exists($label, $horarios)) {
                $horarios[$label] = array_fill_keys(array_keys($dias), null);
            }
            if (array_key_exists($dia, $horarios[$label])) {
                $horarios[$label][$dia] = $info;
            }
        }

        // Convertir cursos a lista ordenada para la vista
        $cursosList = array_values($cursos);

        // Si querés depurar, sacá estas líneas temporalmente para ver los arrays:
        // dd($cupofs, $cursosList, array_keys($horariosBase), array_keys($registros->toArray()));

        return view('profesores.horarios', compact('dias', 'horarios', 'cursosList', 'horariosPorCurso'));
    }
}
