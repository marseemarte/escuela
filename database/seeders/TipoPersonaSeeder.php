<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personas\TipoPersona;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['id' => 1, 'tipo' => 'Personal'],
            ['id' => 2, 'tipo' => 'Padre/Tutor'],
            ['id' => 3, 'tipo' => 'Estudiante'],
        ];

        foreach ($tipos as $tipo) {
            TipoPersona::updateOrCreate(
                ['id' => $tipo['id']],
                ['tipo' => $tipo['tipo']]
            );
        }
    }
}
