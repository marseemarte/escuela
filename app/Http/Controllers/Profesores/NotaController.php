<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Materia;
use App\Models\InformePeriodo;
use App\Models\Personas\Persona;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        // Verificar si el usuario es profesor
        $usuario = Auth::user();

        // Verificar que el usuario es una instancia de Persona y es profesor
        if ($usuario instanceof Persona && $usuario->isProfesor()) {
            // Lógica para profesores - obtener materias asignadas
            $materias = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
                ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->where('persona.dni', $usuario->dni)
                ->where('cupof.estado', 'A')
                ->where('revista.situacion', 'A') // Solo asignaciones activas
                ->select(
                    'cupof.cupof',
                    'materias.id as materia_id',
                    'materias.nombre as materia_nombre',
                    'cursos.division',
                    'cursos.ano',
                    'grupos.nombre as grupo_nombre',
                    'cupof.turno'
                )
                ->distinct()
                ->get();

            return view('profesores.notas.index', compact('materias'));
        } else {
            // Lógica para estudiantes/padres - mostrar notas del alumno
            // Por ahora, redirigir al dashboard
            return redirect()->route('dashboard')->with('info', 'Vista de notas para estudiantes en desarrollo');
        }
    }

    public function cargar(Request $request, $cupof)
    {
        // Debug temporal para ver si llega aquí
        if ($request->has('debug')) {
            $usuario = Auth::user();
            return response()->json([
                'mensaje' => 'Método cargar ejecutado correctamente',
                'cupof' => $cupof,
                'usuario' => $usuario ? [
                    'id' => $usuario->id,
                    'dni' => $usuario->dni,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido
                ] : 'No autenticado',
                'timestamp' => now()
            ]);
        }

        try {
            // Debug: Agregar logs para ver dónde falla
            Log::info('NotaController::cargar - INICIO', ['cupof' => $cupof, 'user' => Auth::id()]);

            // Verificar autenticación
            if (!Auth::check()) {
                Log::warning('NotaController::cargar - Usuario no autenticado');
                return redirect()->route('login')->with('error', 'Debe estar autenticado');
            }

            $usuario = Auth::user();
            Log::info('NotaController::cargar - Usuario autenticado', ['user_id' => $usuario->id, 'user_type' => get_class($usuario)]);

            if (!($usuario instanceof Persona && $usuario->isProfesor())) {
                Log::warning('NotaController::cargar - Usuario no es profesor', ['user_id' => $usuario->id]);
                return redirect()->route('dashboard')->with('error', 'Acceso denegado');
            }

            // Obtener información del CUPOF y verificar que pertenece al profesor
            Log::info('NotaController::cargar - Buscando CUPOF', ['cupof' => $cupof, 'dni_usuario' => $usuario->dni]);

            $cupofInfo = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
                ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->where('cupof.cupof', $cupof)
                ->where('persona.dni', $usuario->dni)
                ->where('cupof.estado', 'A')
                ->where('revista.situacion', 'A')
                ->select(
                    'cupof.cupof',
                    'cupof.id_cursos',
                    'cupof.id_grupos',
                    'materias.nombre as materia_nombre',
                    'cursos.division',
                    'cursos.ano',
                    'grupos.nombre as grupo_nombre',
                    'cupof.turno'
                )
                ->first();

            Log::info('NotaController::cargar - Resultado CUPOF', ['found' => $cupofInfo ? 'SI' : 'NO', 'cupof_info' => $cupofInfo]);

            if (!$cupofInfo) {
                Log::warning('NotaController::cargar - CUPOF no encontrado', ['cupof' => $cupof, 'dni' => $usuario->dni]);
                return redirect()->route('profesores.notas.index')
                    ->with('error', 'CUPOF no encontrado o no tiene permisos para acceder');
            }

            Log::info('NotaController::cargar - Iniciando consulta de alumnos', ['id_cursos' => $cupofInfo->id_cursos, 'id_grupos' => $cupofInfo->id_grupos]);

            // Obtener alumnos del curso y grupo con sus notas existentes
            try {
                // Consulta simplificada primero para ver si encuentra alumnos
                $alumnos = DB::table('persona')
                    ->join('tipousuario', 'persona.id', '=', 'tipousuario.id_persona')
                    ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
                    ->join('asignacionesalumnos', 'tipousuario.id', '=', 'asignacionesalumnos.id_tipousuario')
                    ->leftJoin('informe_periodo', function ($join) use ($cupof) {
                        $join->on('asignacionesalumnos.id', '=', 'informe_periodo.id_asignacionesalumnos')
                            ->where('informe_periodo.cupof', $cupof);
                    })
                    ->where('tipopersona.tipo', 'Alumno')
                    ->where('asignacionesalumnos.id_grupos', $cupofInfo->id_grupos)
                    ->where('asignacionesalumnos.estado', 'A')
                    ->select(
                        'persona.id',
                        'persona.nombre',
                        'persona.apellido',
                        'persona.dni',
                        'asignacionesalumnos.id as asignacion_id',
                        'asignacionesalumnos.id_cursosciclolectivo',
                        'informe_periodo.nota',
                        'informe_periodo.periodo'
                    )
                    ->orderBy('persona.apellido')
                    ->orderBy('persona.nombre')
                    ->get();

                Log::info('NotaController::cargar - Consulta de alumnos exitosa', ['cantidad_alumnos' => count($alumnos)]);
            } catch (\Exception $e) {
                Log::error('NotaController::cargar - Error en consulta de alumnos', ['error' => $e->getMessage()]);
                return redirect()->route('profesores.notas.index')
                    ->with('error', 'Error al obtener lista de alumnos: ' . $e->getMessage());
            }

            // Agrupar notas por alumno
            $alumnosConNotas = [];
            foreach ($alumnos as $alumno) {
                $key = $alumno->asignacion_id;
                if (!isset($alumnosConNotas[$key])) {
                    $alumnosConNotas[$key] = [
                        'id' => $alumno->id,
                        'nombre' => $alumno->nombre,
                        'apellido' => $alumno->apellido,
                        'dni' => $alumno->dni,
                        'asignacion_id' => $alumno->asignacion_id,
                        'nota_periodo_1' => '',  // 1° Informe
                        'nota_periodo_2' => '',  // 1° Cuatrimestre
                        'nota_periodo_3' => '',  // 2° Informe
                        'nota_periodo_4' => ''   // 2° Cuatrimestre
                    ];
                }

                // Agregar nota al periodo correspondiente
                if ($alumno->periodo && $alumno->nota !== null) {
                    switch ($alumno->periodo) {
                        case 1:
                            $alumnosConNotas[$key]['nota_periodo_1'] = $alumno->nota;
                            break;
                        case 2:
                            $alumnosConNotas[$key]['nota_periodo_2'] = $alumno->nota;
                            break;
                        case 3:
                            $alumnosConNotas[$key]['nota_periodo_3'] = $alumno->nota;
                            break;
                        case 4:
                            $alumnosConNotas[$key]['nota_periodo_4'] = $alumno->nota;
                            break;
                    }
                }
            }

            Log::info('NotaController::cargar - Procesamiento exitoso', ['total_alumnos_procesados' => count($alumnosConNotas)]);
            Log::info('NotaController::cargar - Renderizando vista');

            return view('profesores.notas.cargar', compact('cupofInfo', 'alumnosConNotas', 'cupof'));
        } catch (\Exception $e) {
            Log::error('NotaController::cargar - Error general', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('profesores.notas.index')
                ->with('error', 'Error al cargar la vista: ' . $e->getMessage());
        }
    }

    public function totales(Request $request, $cupof)
    {
        try {
            // Verificar autenticación
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Debe estar autenticado');
            }

            $usuario = Auth::user();
            if (!($usuario instanceof Persona && $usuario->isProfesor())) {
                return redirect()->route('dashboard')->with('error', 'Acceso denegado');
            }

            // Obtener información del CUPOF
            $cupofInfo = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
                ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->where('cupof.cupof', $cupof)
                ->where('persona.dni', $usuario->dni)
                ->where('cupof.estado', 'A')
                ->where('revista.situacion', 'A')
                ->select(
                    'cupof.cupof',
                    'cupof.id_cursos',
                    'cupof.id_grupos',
                    'materias.nombre as materia_nombre',
                    'cursos.division',
                    'cursos.ano',
                    'grupos.nombre as grupo_nombre',
                    'cupof.turno'
                )
                ->first();

            if (!$cupofInfo) {
                return redirect()->route('profesores.notas.index')
                    ->with('error', 'CUPOF no encontrado o no tiene permisos para acceder');
            }

            // Obtener estadísticas de notas (datos de ejemplo por ahora)
            $estadisticas = [
                [
                    'id' => 1,
                    'nombre' => 'Federico',
                    'apellido' => 'Sosa',
                    'dni' => '12345678',
                    '1er_informe' => 8,
                    '1er_cuatrimestre' => 7,
                    '2do_informe' => 9,
                    '2do_cuatrimestre' => 8,
                    'cierre' => 8,
                    'diciembre' => null,
                    'febrero' => null,
                    'promedio' => 8.0
                ],
                [
                    'id' => 2,
                    'nombre' => 'María',
                    'apellido' => 'González',
                    'dni' => '87654321',
                    '1er_informe' => 6,
                    '1er_cuatrimestre' => 5,
                    '2do_informe' => 7,
                    '2do_cuatrimestre' => 6,
                    'cierre' => 6,
                    'diciembre' => null,
                    'febrero' => null,
                    'promedio' => 6.0
                ]
            ];

            return view('profesores.notas.totales', compact('cupofInfo', 'estadisticas', 'cupof'));
        } catch (\Exception $e) {
            return redirect()->route('profesores.notas.index')
                ->with('error', 'Error al cargar estadísticas: ' . $e->getMessage());
        }
    }

    public function guardarNotas(Request $request)
    {
        try {
            // Verificar autenticación
            if (!Auth::check()) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            $usuario = Auth::user();
            if (!($usuario instanceof Persona && $usuario->isProfesor())) {
                return response()->json(['error' => 'Acceso denegado'], 403);
            }

            $cupof = $request->input('cupof');
            $notas = $request->input('notas', []);

            // Validar que se envió el CUPOF
            if (!$cupof) {
                return response()->json(['error' => 'CUPOF requerido'], 400);
            }

            // Verificar que el CUPOF pertenece al profesor
            $cupofInfo = DB::table('cupof')
                ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
                ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->where('cupof.cupof', $cupof)
                ->where('persona.dni', $usuario->dni)
                ->where('cupof.estado', 'A')
                ->where('revista.situacion', 'A')
                ->first();

            if (!$cupofInfo) {
                return response()->json(['error' => 'CUPOF no encontrado o sin permisos'], 404);
            }

            // Procesar las notas y guardar en la base de datos
            $notasGuardadas = 0;
            foreach ($notas as $asignacionId => $notasAlumno) {
                foreach ($notasAlumno as $periodo => $nota) {
                    if (!empty($nota) && is_numeric($nota) && $nota >= 1 && $nota <= 10) {
                        // Buscar si ya existe una nota para este alumno, cupof y periodo
                        $existingNota = InformePeriodo::where('id_asignacionesalumnos', $asignacionId)
                            ->where('cupof', $cupof)
                            ->where('periodo', $periodo)
                            ->first();

                        if ($existingNota) {
                            // Actualizar nota existente
                            $existingNota->update([
                                'nota' => $nota,
                                'dni_personal' => $usuario->dni,
                                'fecha' => now()
                            ]);
                        } else {
                            // Crear nueva nota
                            InformePeriodo::create([
                                'id_asignacionesalumnos' => $asignacionId,
                                'cupof' => $cupof,
                                'dni_personal' => $usuario->dni,
                                'fecha' => now(),
                                'nota' => $nota,
                                'periodo' => $periodo
                            ]);
                        }
                        $notasGuardadas++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Se guardaron {$notasGuardadas} notas correctamente",
                'notas_guardadas' => $notasGuardadas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar las notas: ' . $e->getMessage()
            ], 500);
        }
    }
}
