<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turnos = ['Mañana', 'Tarde', 'Vespertino'];
        $divisiones = ['A', 'B', 'C'];
        
        foreach ([4, 5, 6, 7] as $ano) {
            foreach ($turnos as $turno) {
                foreach ($divisiones as $division) {
                    DB::table('cursos')->insert([
                        'division' => $division,
                        'ano' => $ano,
                        'turno' => $turno,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
