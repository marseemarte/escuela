<?php
namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HorariosController extends Controller
{
    public function index(Request $request)
    {
        // Días: clave = código en la DB, valor = etiqueta visible
        $dias = [
            'LUN' => 'LUNES',
            'MAR' => 'MARTES',
            'MIE' => 'MIÉRCOLES',
            'JUE' => 'JUEVES',
            'VIE' => 'VIERNES',
        ];

        // Traer las horas activas ordenadas por hora de inicio (hd)
        $horas = DB::table('horas')
            ->where('activo', 1)
            ->orderBy('hd')
            ->get();

        // Base query para registros
        $query = DB::table('horarios')
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
                'cupof.cupof as cupof_id'
            )
            ->where('horarios.estado', 'A')
            ->where('horas.activo', 1);

        // Intento detectar tabla persona(s) y columna en cupof para hacer join profesor
        $personaTables = ['personas', 'persona'];
        $personaTable = null;
        foreach ($personaTables as $pt) {
            if (Schema::hasTable($pt)) {
                $personaTable = $pt;
                break;
            }
        }

        if ($personaTable) {
            // nombres de columnas posibles en cupof que apuntan a persona
            $possibleCols = ['id_persona', 'id_docente', 'id_personal', 'id_personas', 'persona_id', 'docente_id'];
            foreach ($possibleCols as $col) {
                if (Schema::hasColumn('cupof', $col) && Schema::hasColumn($personaTable, 'id')) {
                    // hacemos left join dinámico y seleccionamos nombre completo del docente
                    $query->leftJoin($personaTable, 'cupof.' . $col, '=', $personaTable . '.id')
                          ->addSelect(DB::raw("CONCAT(COALESCE({$personaTable}.apellido,''),' ',COALESCE({$personaTable}.nombre,'')) as profesor"));
                    break;
                }
            }
        }

        $registros = $query->get();

        // Construir la estructura: 'horaLabel' => ['LUN' => [...], 'MAR' => null, ...]
        $horarios = [];

        // Inicializo filas a partir de las horas (uso hd-hh si no existe nombre)
        foreach ($horas as $h) {
            $label = trim($h->nombre) ?: (trim($h->hd) . ' - ' . trim($h->hh));
            $horarios[$label] = array_fill_keys(array_keys($dias), null);
        }

        // Relleno con los registros obtenidos
        foreach ($registros as $r) {
            $label = trim($r->hora_nombre) ?: (trim($r->hd) . ' - ' . trim($r->hh));
            $dia = strtoupper(trim($r->dia)); // LUN/MAR/...

            if (!array_key_exists($label, $horarios)) {
                $horarios[$label] = array_fill_keys(array_keys($dias), null);
            }

            $info = [
                'titulo' => $r->materia ?? null,
                'abreviatura' => $r->materia_abrev ?? null,
                'salon' => $r->salon_numero ?? null,
                'cupof' => $r->cupof_id ?? null,
                'profesor' => $r->profesor ?? null, // puede venir o no
            ];

            if (array_key_exists($dia, $horarios[$label])) {
                $horarios[$label][$dia] = $info;
            }
        }

        return view('profesores.horarios', compact('dias', 'horarios'));
    }
}
