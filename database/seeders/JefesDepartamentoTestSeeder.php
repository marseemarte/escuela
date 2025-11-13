<?php
// filepath: database/seeders/JefesDepartamentoTestSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Personas\Persona;
use App\Models\Personas\TipoUsuario;
use App\Models\Personas\TipoPersona;
use App\Models\JefeDepartamentoMateria;
use App\Models\Materia;
use Carbon\Carbon;

class JefesDepartamentoTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando seeder de Jefes de Departamento...');
        $this->command->newLine();

        DB::beginTransaction();

        try {
            // 1. Verificar/Crear tipo de persona "Jefe de Departamento"
            $tipoJefe = TipoPersona::where('tipo', 'Jefe de Departamento')->first();

            if (!$tipoJefe) {
                $this->command->info('📝 Creando tipo de persona: Jefe de Departamento');
                $tipoJefe = TipoPersona::create([
                    'tipo' => 'Jefe de Departamento',
                    'descripcion' => 'Jefe de Departamento a cargo de la gestión de materias',
                ]);
                $this->command->info('✅ Tipo de persona creado con ID: ' . $tipoJefe->id);
            } else {
                $this->command->info('✅ Tipo de persona ya existe: Jefe de Departamento (ID: ' . $tipoJefe->id . ')');
            }
            $this->command->newLine();

            // 2. Obtener materias activas
            $materias = Materia::where('estado', 'H')->get();

            if ($materias->isEmpty()) {
                $this->command->error('❌ No hay materias habilitadas en el sistema');
                $this->command->info('💡 Ejecuta primero: php artisan db:seed --class=MateriasSeeder');
                DB::rollBack();
                return;
            }

            $this->command->info("✅ Encontradas {$materias->count()} materias habilitadas");
            $this->command->newLine();

            // 3. Datos de jefes de departamento de prueba
            $jefesData = [
                [
                    'dni' => '20111222',
                    'cuil' => '20-20111222-3',
                    'nombre' => 'María',
                    'apellido' => 'González',
                    'email' => 'maria.gonzalez@tecnica.edu.ar',
                    'telefono' => '3815551001',
                    'sexo' => 'F',
                    'materias_asignar' => 3,
                ],
                [
                    'dni' => '20222333',
                    'cuil' => '20-20222333-4',
                    'nombre' => 'Roberto',
                    'apellido' => 'Fernández',
                    'email' => 'roberto.fernandez@tecnica.edu.ar',
                    'telefono' => '3815551002',
                    'sexo' => 'M',
                    'materias_asignar' => 4,
                ],
                [
                    'dni' => '20333444',
                    'cuil' => '20-20333444-5',
                    'nombre' => 'Ana',
                    'apellido' => 'Martínez',
                    'email' => 'ana.martinez@tecnica.edu.ar',
                    'telefono' => '3815551003',
                    'sexo' => 'F',
                    'materias_asignar' => 2,
                ],
                [
                    'dni' => '20444555',
                    'cuil' => '20-20444555-6',
                    'nombre' => 'Carlos',
                    'apellido' => 'López',
                    'email' => 'carlos.lopez@tecnica.edu.ar',
                    'telefono' => '3815551004',
                    'sexo' => 'M',
                    'materias_asignar' => 3,
                ],
                [
                    'dni' => '20555666',
                    'cuil' => '20-20555666-7',
                    'nombre' => 'Laura',
                    'apellido' => 'Rodríguez',
                    'email' => 'laura.rodriguez@tecnica.edu.ar',
                    'telefono' => '3815551005',
                    'sexo' => 'F',
                    'materias_asignar' => 2,
                ],
            ];

            $jefesCreados = 0;
            $jefesActualizados = 0;
            $asignacionesCreadas = 0;
            $materiasUsadas = collect();

            // 4. Crear/Actualizar jefes y asignar materias
            foreach ($jefesData as $index => $jefeData) {
                $this->command->info("🔄 Procesando: {$jefeData['nombre']} {$jefeData['apellido']}");

                // Verificar si ya existe la persona
                $persona = Persona::where('dni', $jefeData['dni'])->first();

                if ($persona) {
                    $this->command->warn("   ⚠️  Persona ya existe (ID: {$persona->id})");

                    // Verificar si ya tiene el rol de jefe
                    $tipoUsuario = TipoUsuario::where('id_persona', $persona->id)
                        ->where('id_tipopersona', $tipoJefe->id)
                        ->first();

                    if ($tipoUsuario) {
                        $this->command->warn("   ⚠️  Ya tiene rol de Jefe de Departamento");
                        $jefesActualizados++;
                    } else {
                        // Crear solo el TipoUsuario
                        $tipoUsuario = TipoUsuario::create([
                            'id_persona' => $persona->id,
                            'id_tipopersona' => $tipoJefe->id,
                            'usuario' => $jefeData['dni'],
                            'password' => Hash::make('123456'),
                            'estado' => 'A',
                        ]);
                        $this->command->info("   ✓ Rol de jefe agregado (TipoUsuario ID: {$tipoUsuario->id})");
                        $jefesCreados++;
                    }
                } else {
                    // Crear persona nueva
                    $persona = Persona::create([
                        'dni' => $jefeData['dni'],
                        'cuil' => $jefeData['cuil'],
                        'nombre' => $jefeData['nombre'],
                        'apellido' => $jefeData['apellido'],
                        'email' => $jefeData['email'],
                        'telefono' => $jefeData['telefono'],
                        'fecha_nacimiento' => Carbon::now()->subYears(rand(35, 55))->format('Y-m-d'),
                        'direccion' => 'Av. Educación ' . rand(100, 999),
                        'localidad' => 'San Miguel de Tucumán',
                        'provincia' => 'Tucumán',
                        'codigo_postal' => '4000',
                        'sexo' => $jefeData['sexo'],
                        'estado_civil' => ['Soltero/a', 'Casado/a', 'Divorciado/a'][rand(0, 2)],
                        'nacionalidad' => 'Argentina',
                    ]);

                    // Crear tipo usuario (Jefe de Departamento)
                    $tipoUsuario = TipoUsuario::create([
                        'id_persona' => $persona->id,
                        'id_tipopersona' => $tipoJefe->id,
                        'usuario' => $jefeData['dni'],
                        'password' => Hash::make('123456'),
                        'estado' => 'A',
                    ]);

                    $this->command->info("   ✓ Jefe creado (Persona ID: {$persona->id}, TipoUsuario ID: {$tipoUsuario->id})");
                    $jefesCreados++;
                }

                // Asignar materias (evitar duplicados)
                $cantidadMaterias = min($jefeData['materias_asignar'], $materias->count());

                // Filtrar materias no usadas o con pocos jefes
                $materiasDisponibles = $materias->filter(function ($materia) use ($materiasUsadas) {
                    $vecesUsada = $materiasUsadas->where('id', $materia->id)->count();
                    return $vecesUsada < 2; // Máximo 2 jefes por materia
                });

                if ($materiasDisponibles->isEmpty()) {
                    $materiasDisponibles = $materias;
                }

                $materiasAsignadas = $materiasDisponibles->random(min($cantidadMaterias, $materiasDisponibles->count()));

                foreach ($materiasAsignadas as $materia) {
                    // Verificar si ya existe la asignación
                    $asignacionExistente = JefeDepartamentoMateria::where('id_jefe', $tipoUsuario->id)
                        ->where('id_materia', $materia->id)
                        ->first();

                    if ($asignacionExistente) {
                        if ($asignacionExistente->estado === 'I') {
                            $asignacionExistente->activar();
                            $this->command->info("   → Reactivada asignación: {$materia->nombre}");
                        } else {
                            $this->command->warn("   ⚠️  Ya asignado a: {$materia->nombre}");
                        }
                    } else {
                        JefeDepartamentoMateria::create([
                            'id_jefe' => $tipoUsuario->id,
                            'id_materia' => $materia->id,
                            'fecha_asignacion' => Carbon::now()->subDays(rand(1, 90)),
                            'estado' => 'A',
                        ]);

                        $materiasUsadas->push($materia);
                        $asignacionesCreadas++;
                        $this->command->info("   ✓ Asignado a: {$materia->nombre}");
                    }
                }

                $this->command->newLine();
            }

            DB::commit();

            // Resumen final
            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->info('✅ SEEDER COMPLETADO EXITOSAMENTE');
            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->newLine();

            $this->command->info('📊 RESUMEN:');
            $this->command->info("   • Jefes nuevos creados: {$jefesCreados}");
            $this->command->info("   • Jefes existentes actualizados: {$jefesActualizados}");
            $this->command->info("   • Total jefes procesados: " . ($jefesCreados + $jefesActualizados));
            $this->command->info("   • Asignaciones de materias creadas: {$asignacionesCreadas}");
            $this->command->newLine();

            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->info('💡 CREDENCIALES DE ACCESO:');
            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->newLine();

            foreach ($jefesData as $jefe) {
                $this->command->info("   👤 {$jefe['apellido']}, {$jefe['nombre']}");
                $this->command->info("      Usuario: {$jefe['dni']}");
                $this->command->info("      Email: {$jefe['email']}");
            }

            $this->command->newLine();
            $this->command->info('   🔑 Contraseña para todos: 123456');
            $this->command->info('   🌐 Ruta de acceso: /jefes');
            $this->command->newLine();

            // Verificación de datos
            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->info('🔍 VERIFICACIÓN:');
            $this->command->info('═══════════════════════════════════════════════════════════');
            $this->command->newLine();

            $totalJefes = TipoUsuario::where('id_tipopersona', $tipoJefe->id)
                ->where('estado', 'A')
                ->count();

            $totalAsignaciones = JefeDepartamentoMateria::where('estado', 'A')->count();

            $this->command->info("   ✓ Total de Jefes de Departamento activos: {$totalJefes}");
            $this->command->info("   ✓ Total de asignaciones activas: {$totalAsignaciones}");
            $this->command->newLine();

            // Mostrar distribución de materias
            $this->command->info('📚 DISTRIBUCIÓN DE MATERIAS:');
            $this->command->newLine();

            $distribucion = JefeDepartamentoMateria::with(['jefe.persona', 'materia'])
                ->where('estado', 'A')
                ->get()
                ->groupBy('id_jefe');

            foreach ($distribucion as $idJefe => $asignaciones) {
                $jefe = $asignaciones->first()->jefe;
                $nombreJefe = "{$jefe->persona->apellido}, {$jefe->persona->nombre}";
                $cantidadMaterias = $asignaciones->count();
                $materiasNombres = $asignaciones->pluck('materia.nombre')->implode(', ');

                $this->command->info("   👤 {$nombreJefe} ({$cantidadMaterias} materias)");
                $this->command->info("      → {$materiasNombres}");
            }

            $this->command->newLine();
            $this->command->info('═══════════════════════════════════════════════════════════');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->command->newLine();
            $this->command->error('═══════════════════════════════════════════════════════════');
            $this->command->error('❌ ERROR AL EJECUTAR EL SEEDER');
            $this->command->error('═══════════════════════════════════════════════════════════');
            $this->command->newLine();
            $this->command->error('Mensaje: ' . $e->getMessage());
            $this->command->error('Archivo: ' . $e->getFile());
            $this->command->error('Línea: ' . $e->getLine());
            $this->command->newLine();
            $this->command->error('Stack Trace:');
            $this->command->error($e->getTraceAsString());
            $this->command->newLine();
        }
    }
}
