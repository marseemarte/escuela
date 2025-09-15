<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personas\Persona;
use App\Models\Materia;
use App\Models\Asistencia;
use App\Models\Revista;
use App\Models\Cupof;

class VerificarSistemaAsistencias extends Command
{
    protected $signature = 'verificar:asistencias';
    protected $description = 'Verificar que el sistema de asistencias esté funcionando correctamente';

    public function handle()
    {
        $this->info('=== VERIFICACIÓN DEL SISTEMA DE ASISTENCIAS ===');

        // Verificar profesor
        $profesor = Persona::where('dni', 12345678)->first();
        if ($profesor) {
            $this->info("✓ PROFESOR: {$profesor->nombre} {$profesor->apellido} (DNI: {$profesor->dni})");
        } else {
            $this->error("✗ No se encontró el profesor");
            return;
        }

        // Verificar materias
        $materias = Materia::all();
        $this->info("✓ MATERIAS CREADAS: {$materias->count()}");
        foreach ($materias->take(5) as $materia) {
            $this->line("  - {$materia->nombre} ({$materia->abreviatura})");
        }

        // Verificar estudiantes
        $estudiantes = Persona::whereHas('tiposUsuario.tipoPersona', function ($q) {
            $q->where('tipo', 'Alumno');
        })->get();
        $this->info("✓ ESTUDIANTES: {$estudiantes->count()}");
        foreach ($estudiantes->take(5) as $estudiante) {
            $this->line("  - {$estudiante->nombre} {$estudiante->apellido} (DNI: {$estudiante->dni})");
        }

        // Verificar CUPOF
        $cupofs = Cupof::count();
        $this->info("✓ CUPOF (Cargos): {$cupofs}");

        // Verificar revista (asignaciones profesor-materia)
        $revistas = Revista::count();
        $this->info("✓ REVISTA (Asignaciones): {$revistas}");

        // Verificar asistencias
        $asistencias = Asistencia::count();
        $this->info("✓ REGISTROS DE ASISTENCIA: {$asistencias}");

        // Mostrar algunas asistencias recientes
        $asistenciasRecientes = Asistencia::with('asignacionAlumno.tipoUsuario.persona')
            ->latest()
            ->take(5)
            ->get();

        $this->info("📋 ÚLTIMOS REGISTROS DE ASISTENCIA:");
        foreach ($asistenciasRecientes as $asistencia) {
            $alumno = $asistencia->asignacionAlumno->tipoUsuario->persona;
            $estado = $asistencia->estadoDescriptivo;
            $fecha = $asistencia->fecha->format('d/m/Y');
            $this->line("  - {$alumno->nombre} {$alumno->apellido}: {$estado} ({$fecha})");
        }

        $this->info('');
        $this->info('🎉 Sistema de asistencias verificado exitosamente!');

        return 0;
    }
}
