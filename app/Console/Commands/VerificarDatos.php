<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerificarDatos extends Command
{
    protected $signature = 'verificar:datos';
    protected $description = 'Verificar datos en la base de datos';

    public function handle()
    {
        $this->info('Verificando CUPOF disponibles...');

        // Verificar cupof disponibles
        $cupofs = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
            ->where('cupof.estado', 'A')
            ->select(
                'cupof.cupof',
                'materias.nombre as materia_nombre',
                'cursos.division',
                'cursos.ano',
                'grupos.nombre as grupo_nombre',
                'cupof.turno'
            )
            ->get();

        $this->info("CUPOFs disponibles:");
        foreach ($cupofs as $cupof) {
            $this->info("- CUPOF {$cupof->cupof}: {$cupof->materia_nombre} - {$cupof->ano}°{$cupof->division} - Grupo {$cupof->grupo_nombre}");
        }

        return 0;
    }
}
