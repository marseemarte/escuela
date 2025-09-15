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

        // 2) Registros de horarios (sin subconsulta profesor)
        $registros = DB::table('horarios')
            ->join('horas', 'horarios.id_horas', '=', 'horas.id')
            ->leftJoin('cupof', 'horarios.cupof', '=', 'cupof.cupof')
            ->leftJoin('materias', 'cupof.id_materias', '=', 'materias.id')
            ->leftJoin('salones', 'horarios.id_salones', '=', 'salones.id')
            ->select(
                'horas.nombre as hora_nombre',
                'horas.hd',
                'horas.hh',
                'horarios.dia',
                'materias.nombre as materia',
                'materias.abreviatura as materia_abrev',
                'salones.numero as salon_numero',
                'salones.id as salon_id',
                'cupof.cupof as cupof_id'
            )
            ->where('horarios.estado', 'A')
            ->where('horas.activo', 1)
            ->get();

        // 3) Extraer cupof únicos
        $cupofs = collect($registros)->pluck('cupof_id')->filter()->unique()->values()->all();

        // 4) Mapear cupof => profesor (última revista activa por cupof)
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

            // Tomamos la primera fila por cupof (ya ordenado por secuencia,id desc)
            foreach ($rows as $row) {
                $cup = $row->cupof;
                if (!isset($profesoresMap[$cup])) {
                    $profesoresMap[$cup] = $row->profesor;
                }
            }
        }

        // 5) Construir la estructura final $horarios
        $horarios = [];
        foreach ($horas as $h) {
            $label = trim($h->nombre) ?: (trim($h->hd) . ' - ' . trim($h->hh));
            $horarios[$label] = array_fill_keys(array_keys($dias), null);
        }

        foreach ($registros as $r) {
            $label = trim($r->hora_nombre) ?: (trim($r->hd) . ' - ' . trim($r->hh));
            $dia = strtoupper(trim($r->dia)); // debe ser LUN/MAR/...

            if (!array_key_exists($label, $horarios)) {
                $horarios[$label] = array_fill_keys(array_keys($dias), null);
            }

            $cup = $r->cupof_id;
            $info = [
                'titulo' => $r->materia ?? null,
                'abreviatura' => $r->materia_abrev ?? null,
                'salon' => $r->salon_numero ?? null,
                'salon_id' => $r->salon_id ?? null,
                'cupof' => $cup ?? null,
                'profesor' => $cup && isset($profesoresMap[$cup]) ? $profesoresMap[$cup] : null,
            ];

            if (array_key_exists($dia, $horarios[$label])) {
                $horarios[$label][$dia] = $info;
            }
        }

        return view('profesores.horarios', compact('dias', 'horarios'));
    }
}
