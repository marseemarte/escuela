<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorariosController extends Controller
{
    public function index(Request $request)
    {
    $dias = ['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'];

    // La es estructura: 'hora' => ['LUNES' => [...], 'MARTES' => null, ...]
    $horarios = [
        '07:20 - 08:20' => [
            'LUNES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MARTES' => null, 'MIERCOLES' => null, 'JUEVES' => null, 'VIERNES' => null,
        ],
        '08:20 - 09:20' => [
            'LUNES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MARTES' => null, 'MIERCOLES' => null, 'JUEVES' => null, 'VIERNES' => null,
        ],
        '09:50 - 10:50' => [
            'LUNES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MIERCOLES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MARTES' => null, 'JUEVES' => null, 'VIERNES' => null,
        ],
        '10:50 - 11:50' => [
            'LUNES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MIERCOLES' => ['titulo' => 'PRACTICAS PROFESIONALIZANTES DEL SECTOR INFORMATICO', 'profesor' => 'GASTON EDUARDO PIERONI'],
            'MARTES' => null, 'JUEVES' => null, 'VIERNES' => null,
        ],
        '13:00 - 15:00' => [
            'LUNES' => ['titulo' => 'SISTEMAS OPERATIVOS', 'profesor' => 'MARTIN GABRIEL BERTONE'],
            'MARTES' => ['titulo' => 'SISTEMAS OPERATIVOS', 'profesor' => 'MARTIN GABRIEL BERTONE'],
            'MIERCOLES' => ['titulo' => 'PROYECTO DE IMPLEMENTACION DE SITIOS WEB DINAMICOS', 'profesor' => 'GASTON FERREYRA'],
            'JUEVES' => ['titulo' => 'PROYECTO DE DESARROLLO SOFTWARE PARA PLATAFORMAS MOVILES', 'profesor' => 'ANDRES ABEL SCHIRO'],
            'VIERNES' => ['titulo' => 'ORGANIZACION Y METODOS', 'profesor' => 'NATALIA PELLEGRINESCHI'],
        ],
        '20:00 - 21:00' => [
            'LUNES' => ['titulo' => 'MODELOS Y SISTEMAS', 'profesor' => 'JUAN REICHERT'],
            'MARTES' => ['titulo' => 'PROYECTO, DISEÑO E IMPLEMENTACION DE SISTEMAS', 'profesor' => 'ERNESTO RAUL LAURITO'],
            'MIERCOLES' => ['titulo' => 'PROYECTO DE IMPLEMENTACION DE SITIOS WEB DINAMICOS', 'profesor' => 'GASTON FERREYRA'],
            'JUEVES' => ['titulo' => 'PROYECTO DE DESARROLLO SOFTWARE PARA PLATAFORMAS MOVILES', 'profesor' => 'ANDRES ABEL SCHIRO'],
            'VIERNES' => ['titulo' => 'ORGANIZACION Y METODOS', 'profesor' => 'NATALIA PELLEGRINESCHI'],
        ],
    ];

    return view('profesores.horarios', compact('dias','horarios'));
}

}
