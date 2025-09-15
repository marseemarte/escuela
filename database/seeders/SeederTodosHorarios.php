<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SeederTodosHorarios extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // 1) Horas
            $horas = [
                ['nombre' => '07:20-08:20', 'turno' => 'D', 'hd' => '07:20:00', 'hh' => '08:20:00', 'activo' => 1],
                ['nombre' => '08:20-09:20', 'turno' => 'D', 'hd' => '08:20:00', 'hh' => '09:20:00', 'activo' => 1],
                ['nombre' => '09:50-10:50', 'turno' => 'D', 'hd' => '09:50:00', 'hh' => '10:50:00', 'activo' => 1],
                ['nombre' => '10:50-11:50', 'turno' => 'D', 'hd' => '10:50:00', 'hh' => '11:50:00', 'activo' => 1],
                ['nombre' => '13:00-15:00', 'turno' => 'T', 'hd' => '13:00:00', 'hh' => '15:00:00', 'activo' => 1],
                ['nombre' => '20:00-21:00', 'turno' => 'N', 'hd' => '20:00:00', 'hh' => '21:00:00', 'activo' => 1],
            ];

            foreach ($horas as $h) {
                $h['created_at'] = $now;
                $h['updated_at'] = $now;
                if (!DB::table('horas')->where('nombre', $h['nombre'])->exists()) {
                    DB::table('horas')->insert($h);
                }
            }

            // 2) Materias
            $materias = [
                ['nombre' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'abreviatura' => 'PP-SI', 'estado' => 'H', 'resumen' => 'Practicas sector informatico'],
                ['nombre' => 'SISTEMAS OPERATIVOS', 'abreviatura' => 'SO', 'estado' => 'H', 'resumen' => 'Sistemas Operativos'],
                ['nombre' => 'PROYECTO DE IMPLEMENTACION DE SITIOS WEB DINAMICOS', 'abreviatura' => 'PROY-SW', 'estado' => 'H', 'resumen' => 'Proyecto sitios web'],
                ['nombre' => 'PROYECTO DE DESARROLLO SOFTWARE PARA PLATAFORMAS MOVILES', 'abreviatura' => 'PROY-MOB', 'estado' => 'H', 'resumen' => 'Proyecto moviles'],
                ['nombre' => 'ORGANIZACION Y METODOS', 'abreviatura' => 'ORG-MET', 'estado' => 'H', 'resumen' => 'Organizacion y metodos'],
                ['nombre' => 'MODELOS Y SISTEMAS', 'abreviatura' => 'MOD-SIS', 'estado' => 'H', 'resumen' => 'Modelos y sistemas'],
                ['nombre' => 'PROYECTO, DISEÑO E IMPLEMENTACION DE SISTEMAS', 'abreviatura' => 'PDI-SYS', 'estado' => 'H', 'resumen' => 'Proyecto diseño implementación'],
            ];

            foreach ($materias as $m) {
                $m['created_at'] = $now;
                $m['updated_at'] = $now;
                if (!DB::table('materias')->where('abreviatura', $m['abreviatura'])->exists()) {
                    DB::table('materias')->insert($m);
                }
            }

            // 3) Salones
            $salones = [
                ['piso' => 1, 'numero' => 101, 'tipo' => 'Aula', 'capacidad' => 30, 'corriente' => '220V', 'televisor' => 'No', 'pizarron' => 'Tiza', 'ubicacion' => 'Piso 1', 'activo' => 1],
                ['piso' => 1, 'numero' => 102, 'tipo' => 'Laboratorio', 'capacidad' => 20, 'corriente' => '220V', 'televisor' => 'Si', 'pizarron' => 'Marcador', 'ubicacion' => 'Piso 1', 'activo' => 1],
                ['piso' => 0, 'numero' => 1, 'tipo' => 'Auditorio', 'capacidad' => 100, 'corriente' => '220V', 'televisor' => 'Si', 'pizarron' => 'Marcador', 'ubicacion' => 'Planta Baja', 'activo' => 1],
            ];

            foreach ($salones as $s) {
                $s['created_at'] = $now;
                $s['updated_at'] = $now;
                if (!DB::table('salones')->where('numero', $s['numero'])->exists()) {
                    DB::table('salones')->insert($s);
                }
            }

            // 4) Cursos y Grupos
            if (!DB::table('cursos')->where([['division','A'],['ano',5],['turno','D']])->exists()) {
                $cursoId = DB::table('cursos')->insertGetId([
                    'division' => 'A',
                    'ano' => 5,
                    'turno' => 'D',
                    'estado' => 'A',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                $cursoId = DB::table('cursos')->where([['division','A'],['ano',5],['turno','D']])->value('id');
            }

            if (!DB::table('grupos')->where('id_cursos', $cursoId)->exists()) {
                $grupoId = DB::table('grupos')->insertGetId([
                    'nombre' => 1,
                    'id_cursos' => $cursoId,
                    'estado' => 'A',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                $grupoId = DB::table('grupos')->where('id_cursos', $cursoId)->value('id');
            }

            // 5) Cupof (vincula materia + curso + grupo)
            $cupofMaterias = ['PP-SI','SO','PROY-SW','PROY-MOB','ORG-MET','MOD-SIS','PDI-SYS'];

            foreach ($cupofMaterias as $abre) {
                $materiaId = DB::table('materias')->where('abreviatura', $abre)->value('id');
                if (!$materiaId) continue;

                $exists = DB::table('cupof')->where([['id_materias', $materiaId], ['id_cursos', $cursoId], ['id_grupos', $grupoId]])->exists();
                if (!$exists) {
                    // Calculamos un valor seguro para la columna PK `cupof` si hace falta
                    $nextCup = DB::table('cupof')->max('cupof');
                    $nextCup = $nextCup ? $nextCup + 1 : 1;

                    DB::table('cupof')->insert([
                        'cupof' => $nextCup,
                        'turno' => ($abre === 'MOD-SIS' || $abre === 'PDI-SYS') ? 'N' : 'D',
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

            // 6) Horarios
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

            $horarios = [
                ['dia'=>'LUN','hora'=>'07:20-08:20','salon'=>101,'materia'=>'PP-SI'],
                ['dia'=>'LUN','hora'=>'08:20-09:20','salon'=>101,'materia'=>'PP-SI'],
                ['dia'=>'MAR','hora'=>'13:00-15:00','salon'=>102,'materia'=>'SO'],
                ['dia'=>'MIE','hora'=>'09:50-10:50','salon'=>101,'materia'=>'PP-SI'],
                ['dia'=>'JUE','hora'=>'13:00-15:00','salon'=>102,'materia'=>'PROY-MOB'],
                ['dia'=>'VIE','hora'=>'13:00-15:00','salon'=>1,'materia'=>'ORG-MET'],
                ['dia'=>'LUN','hora'=>'20:00-21:00','salon'=>1,'materia'=>'MOD-SIS'],
            ];

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

            $primerCupEnHorarios = DB::table('horarios')->distinct()->pluck('cupof')->first();

            $tipopersonaId = DB::table('tipopersona')->where('tipo','DOCENTE')->value('id');
            if (!$tipopersonaId) {
                $tipopersonaId = DB::table('tipopersona')->insertGetId([
                    'tipo' => 'DOCENTE',
                    'estado' => 'A',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $personaExists = DB::table('persona')->where('dni', 99999999)->exists();
            if (!$personaExists) {
                $personaId = DB::table('persona')->insertGetId([
                    'dni' => 99999999,
                    'apellido' => 'PEREZ',
                    'nombre' => 'JUAN',
                    'fechan' => '1980-01-01',
                    'sexo' => 'M',
                    'domicilio' => 'Calle Falsa 123',
                    'id_localidad' => 1,
                    'pass' => 'changeme',
                    'telefono' => '123456789',
                    'mail' => 'juan.perez@example.com',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                $personaId = DB::table('persona')->where('dni', 99999999)->value('id');
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

        }); // transaction

        $this->command->info('SeederTodosHorarios: datos insertados (si no existían).');
    }
}
