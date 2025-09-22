<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HorariosController extends Controller
{
    public function create()
    {
        // puedes pasar datos para selects si quieres (por ejemplo dias y turnos)
        $dias = ['LUN','MAR','MIE','JUE','VIE','SAB','DOM'];
        $turnos = ['D' => 'Diurno', 'T' => 'Tarde', 'N' => 'Nocturno'];
        return view('horarios.create', compact('dias','turnos'));
    }

    public function store(Request $request)
    {
        // Validación básica (puedes extenderla)
        $request->validate([
            'horas' => 'array',
            'horas.*.nombre' => 'required|string',
            'horas.*.turno' => 'required|string|size:1',
            'horas.*.hd' => 'required|date_format:H:i:s',
            'horas.*.hh' => 'required|date_format:H:i:s',
            'horas.*.activo' => 'nullable|in:0,1',

            'materias' => 'array',
            'materias.*.nombre' => 'required|string',
            'materias.*.abreviatura' => 'required|string',
            'materias.*.estado' => 'nullable|string',
            'materias.*.resumen' => 'nullable|string',

            'salones' => 'array',
            'salones.*.piso' => 'required|integer',
            'salones.*.numero' => 'required',
            'salones.*.tipo' => 'nullable|string',
            'salones.*.capacidad' => 'nullable|integer',
            'salones.*.corriente' => 'nullable|string',
            'salones.*.televisor' => 'nullable|string',
            'salones.*.pizarron' => 'nullable|string',
            'salones.*.ubicacion' => 'nullable|string',
            'salones.*.activo' => 'nullable|in:0,1',

            'curso.division' => 'required|string',
            'curso.ano' => 'required|integer',
            'curso.turno' => 'required|string|size:1',

            'grupos' => 'array|nullable',
            'grupos.*.nombre' => 'required',

            'cupof' => 'array|nullable', // lista de abreviaturas a vincular
            'cupof.*' => 'string',

            'horarios' => 'array|nullable',
            'horarios.*.dia' => 'required|string',
            'horarios.*.hora' => 'required|string',
            'horarios.*.salon' => 'required',
            'horarios.*.materia' => 'required|string',

            'persona.dni' => 'nullable|numeric',
            'persona.apellido' => 'nullable|string',
            'persona.nombre' => 'nullable|string',
            'persona.fechan' => 'nullable|date',
            'persona.sexo' => 'nullable|string',
            'persona.domicilio' => 'nullable|string',
            'persona.id_localidad' => 'nullable|integer',
            'persona.pass' => 'nullable|string',
            'persona.telefono' => 'nullable|string',
            'persona.mail' => 'nullable|email',
        ]);

        DB::transaction(function() use ($request) {
            $now = Carbon::now();

            // 1) Horas
            $horas = $request->input('horas', []);
            foreach ($horas as $h) {
                $data = [
                    'nombre' => $h['nombre'],
                    'turno' => $h['turno'],
                    'hd' => $h['hd'],
                    'hh' => $h['hh'],
                    'activo' => isset($h['activo']) ? $h['activo'] : 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                if (!DB::table('horas')->where('nombre', $data['nombre'])->exists()) {
                    DB::table('horas')->insert($data);
                }
            }

            // 2) Materias
            $materias = $request->input('materias', []);
            foreach ($materias as $m) {
                $data = [
                    'nombre' => $m['nombre'],
                    'abreviatura' => $m['abreviatura'],
                    'estado' => $m['estado'] ?? 'H',
                    'resumen' => $m['resumen'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                if (!DB::table('materias')->where('abreviatura', $data['abreviatura'])->exists()) {
                    DB::table('materias')->insert($data);
                }
            }

            // 3) Salones
            $salones = $request->input('salones', []);
            foreach ($salones as $s) {
                $data = [
                    'piso' => $s['piso'],
                    'numero' => $s['numero'],
                    'tipo' => $s['tipo'] ?? null,
                    'capacidad' => $s['capacidad'] ?? null,
                    'corriente' => $s['corriente'] ?? null,
                    'televisor' => $s['televisor'] ?? 'No',
                    'pizarron' => $s['pizarron'] ?? null,
                    'ubicacion' => $s['ubicacion'] ?? null,
                    'activo' => isset($s['activo']) ? $s['activo'] : 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                if (!DB::table('salones')->where('numero', $data['numero'])->exists()) {
                    DB::table('salones')->insert($data);
                }
            }

            // 4) Cursos y Grupos (único ejemplo: se asume un curso por formulario)
            $cursoInput = $request->input('curso');
            $cursoId = DB::table('cursos')->where([
                ['division', $cursoInput['division']],
                ['ano', $cursoInput['ano']],
                ['turno', $cursoInput['turno']],
            ])->value('id');

            if (!$cursoId) {
                $cursoId = DB::table('cursos')->insertGetId([
                    'division' => $cursoInput['division'],
                    'ano' => $cursoInput['ano'],
                    'turno' => $cursoInput['turno'],
                    'estado' => 'A',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // grupos: si envías varios, se crearán y vincularán al curso
            $grupoId = null;
            $grupos = $request->input('grupos', []);
            if (!empty($grupos)) {
                // creamos el primero (o el que quieras)
                $g = $grupos[0];
                $grupoId = DB::table('grupos')->where('id_cursos', $cursoId)->value('id');
                if (!$grupoId) {
                    $grupoId = DB::table('grupos')->insertGetId([
                        'nombre' => $g['nombre'],
                        'id_cursos' => $cursoId,
                        'estado' => 'A',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            } else {
                // fallback: si ya existe un grupo para el curso, lo tomamos
                $grupoId = DB::table('grupos')->where('id_cursos', $cursoId)->value('id');
            }

            // 5) Cupof (vincula materia + curso + grupo)
            $cupofMaterias = $request->input('cupof', []);
            foreach ($cupofMaterias as $abre) {
                $materiaId = DB::table('materias')->where('abreviatura', $abre)->value('id');
                if (!$materiaId) continue;

                $exists = DB::table('cupof')->where([['id_materias', $materiaId], ['id_cursos', $cursoId], ['id_grupos', $grupoId]])->exists();
                if (!$exists) {
                    $nextCup = DB::table('cupof')->max('cupof');
                    $nextCup = $nextCup ? $nextCup + 1 : 1;

                    DB::table('cupof')->insert([
                        'cupof' => $nextCup,
                        'turno' => in_array($abre, ['MOD-SIS','PDI-SYS']) ? 'N' : 'D',
                        'hsmodcar' => 4,
                        'id_materias' => $materiaId,
                        'id_cursos' => $cursoId,
                        'id_grupos' => $grupoId,
                        'estado' => 'A',
                        'funcion' => '0',
                        'cargo' => 'PF',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            // 6) Horarios (resolviendo ids)
            $getHoraId = function($nombre) {
                return DB::table('horas')->where('nombre', $nombre)->value('id');
            };
            $getSalonId = function($numero) {
                return DB::table('salones')->where('numero', $numero)->value('id');
            };
            $getCupofByAbre = function($abre) use ($cursoId, $grupoId) {
                $matId = DB::table('materias')->where('abreviatura', $abre)->value('id');
                if (!$matId) return null;
                return DB::table('cupof')->where([['id_materias', $matId], ['id_cursos', $cursoId], ['id_grupos', $grupoId]])->value('cupof');
            };

            $horarios = $request->input('horarios', []);
            foreach ($horarios as $h) {
                $idHora = $getHoraId($h['hora']);
                $idSalon = $getSalonId($h['salon']);
                $cupId = $getCupofByAbre($h['materia']);
                if (!$idHora || !$idSalon || !$cupId) continue;

                $exists = DB::table('horarios')->where([['dia', $h['dia']], ['id_horas', $idHora], ['id_salones', $idSalon], ['cupof', $cupId]])->exists();
                if (!$exists) {
                    DB::table('horarios')->insert([
                        'dia' => $h['dia'],
                        'id_horas' => $idHora,
                        'id_salones' => $idSalon,
                        'cupof' => $cupId,
                        'estado' => 'A',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            // ----- Tipopersona, persona, tipousuario, revista -----
            $persona = $request->input('persona', []);
            if (!empty($persona) && isset($persona['dni'])) {
                $tipopersonaId = DB::table('tipopersona')->where('tipo','DOCENTE')->value('id');
                if (!$tipopersonaId) {
                    $tipopersonaId = DB::table('tipopersona')->insertGetId([
                        'tipo' => 'DOCENTE',
                        'estado' => 'A',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                $personaExists = DB::table('persona')->where('dni', $persona['dni'])->exists();
                if (!$personaExists) {
                    $personaId = DB::table('persona')->insertGetId([
                        'dni' => $persona['dni'],
                        'apellido' => $persona['apellido'] ?? 'PEREZ',
                        'nombre' => $persona['nombre'] ?? 'JUAN',
                        'fechan' => $persona['fechan'] ?? '1980-01-01',
                        'sexo' => $persona['sexo'] ?? 'M',
                        'domicilio' => $persona['domicilio'] ?? 'Calle Falsa 123',
                        'id_localidad' => $persona['id_localidad'] ?? 1,
                        'pass' => $persona['pass'] ?? 'changeme',
                        'telefono' => $persona['telefono'] ?? '123456789',
                        'mail' => $persona['mail'] ?? 'juan.perez@example.com',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                } else {
                    $personaId = DB::table('persona')->where('dni', $persona['dni'])->value('id');
                }

                if (!DB::table('tipousuario')->where('id_persona', $personaId)->exists()) {
                    $tipousuarioId = DB::table('tipousuario')->insertGetId([
                        'id_persona' => $personaId,
                        'id_tipopersona' => $tipopersonaId,
                        'estado' => 'A',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                } else {
                    $tipousuarioId = DB::table('tipousuario')->where('id_persona', $personaId)->value('id');
                }

                // ponemos en revista el primer cupof de la tabla horarios (si hay)
                $primerCupEnHorarios = DB::table('horarios')->distinct()->pluck('cupof')->first();
                if ($primerCupEnHorarios) {
                    DB::table('revista')->insert([
                        'cupof' => $primerCupEnHorarios,
                        'id_tipousuario' => $tipousuarioId,
                        'fd' => Carbon::now()->toDateString(),
                        'fh' => Carbon::now()->toDateString(),
                        'secuencia' => 1,
                        'situacion' => 'DOCENTE TITULAR',
                        'estado' => 'A',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

        }); // transaction

        return redirect()->route('horarios.create')->with('success', 'Datos cargados correctamente (si no existían).');
    }
}
