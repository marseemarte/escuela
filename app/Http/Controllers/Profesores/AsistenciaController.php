<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use App\Models\Cupof;
use App\Models\Personas\AsignacionAlumno;
use App\Models\Personas\Persona;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener materias del profesor logueado
        $profesor = Auth::user();

        $materias = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
            ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
            ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
            ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
            ->where('persona.dni', $profesor->dni)
            ->where('cupof.estado', 'A')
            ->where('revista.situacion', 'A') // Solo asignaciones activas
            ->select(
                'cupof.cupof',
                'materias.nombre as materia_nombre',
                'cursos.division',
                'cursos.ano',
                'grupos.nombre as grupo_nombre',
                'cupof.turno'
            )
            ->distinct()
            ->get();

        return view('profesores.asistencias.index', compact('materias'));
    }

    public function tomar(Request $request, $cupof)
    {
        try {
            // Verificar autenticación
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Debe estar autenticado');
            }

            // Obtener información del CUPOF
            $cupofInfo = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->where('cupof.cupof', $cupof)
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
                return redirect()->route('profesores.asistencias.index')
                    ->with('error', 'CUPOF no encontrado');
            }

            // Consulta de alumnos
            $alumnos = DB::table('asignacionesalumnos')
                ->join('tipousuario', 'asignacionesalumnos.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
                ->where('asignacionesalumnos.estado', 'A')
                ->where('asignacionesalumnos.id_grupos', $cupofInfo->id_grupos)
                ->where('tipopersona.tipo', 'Alumno')
                ->select(
                    'asignacionesalumnos.id as asignacion_id',
                    'persona.dni',
                    'persona.nombre',
                    'persona.apellido',
                    'asignacionesalumnos.id_cursosciclolectivo'
                )
                ->orderBy('persona.apellido')
                ->orderBy('persona.nombre')
                ->get();

            // Obtener asistencias de hoy (sin zona horaria para evitar problemas de fecha)
            $hoy = now()->format('Y-m-d');
            Log::info('Fecha utilizada para consulta:', ['fecha' => $hoy, 'now' => now()]);

            $asistenciasHoy = DB::table('inasistenciasalumnos')
                ->whereIn('id_asignacionesalumnos', $alumnos->pluck('asignacion_id'))
                ->where('cupof', $cupof)
                ->where('fecha', $hoy)
                ->get()
                ->keyBy('id_asignacionesalumnos');

            // Agregar estado de asistencia a cada alumno
            $asistenciasEncontradas = 0;
            $alumnos = $alumnos->map(function ($alumno) use ($asistenciasHoy, &$asistenciasEncontradas) {
                $asistencia = $asistenciasHoy->get($alumno->asignacion_id);
                $alumno->estado_asistencia = $asistencia ? $asistencia->estado : 'P';
                $alumno->justificado = $asistencia ? $asistencia->justificado : '0';

                if ($asistencia) {
                    $asistenciasEncontradas++;
                }

                return $alumno;
            });

            Log::info('Asistencias cargadas para tomar:', [
                'cupof' => $cupof,
                'total_alumnos' => $alumnos->count(),
                'asistencias_existentes' => $asistenciasEncontradas,
                'fecha' => $hoy
            ]);

            // Pasar información adicional a la vista
            $datosAsistencia = [
                'total_alumnos' => $alumnos->count(),
                'asistencias_existentes' => $asistenciasEncontradas,
                'fecha' => $hoy
            ];

            return view('profesores.asistencias.tomar', compact('cupofInfo', 'alumnos', 'datosAsistencia'));
        } catch (\Exception $e) {
            Log::error("Error en tomar asistencias", [
                'cupof' => $cupof,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('profesores.asistencias.index')
                ->with('error', 'Error al cargar la página de asistencias');
        }
    }

    public function obtenerAlumnos(Request $request, $cupof)
    {
        $debug = [];
        $debug[] = "METODO EJECUTADO - CUPOF: " . $cupof;

        try {
            $debug[] = "Paso 1: Verificando autenticación";

            // Verificar autenticación
            if (!Auth::check()) {
                $debug[] = "Usuario no autenticado";
                return response()->json(['error' => 'No autenticado', 'debug' => $debug], 401);
            }

            $debug[] = "Paso 2: Usuario autenticado, verificando CUPOF";

            // Obtener información del CUPOF
            $cupofInfo = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->where('cupof.cupof', $cupof)
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
                $debug[] = "CUPOF no encontrado: " . $cupof;
                return response()->json(['error' => 'CUPOF no encontrado', 'debug' => $debug], 404);
            }

            $debug[] = "Paso 3: CUPOF encontrado - Grupo: " . $cupofInfo->id_grupos . ", Curso: " . $cupofInfo->id_cursos;

            // Consulta de alumnos simplificada
            $debug[] = "Paso 4: Ejecutando consulta de alumnos...";

            $alumnos = DB::table('asignacionesalumnos')
                ->join('tipousuario', 'asignacionesalumnos.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
                ->where('asignacionesalumnos.estado', 'A')
                ->where('asignacionesalumnos.id_grupos', $cupofInfo->id_grupos)
                ->where('tipopersona.tipo', 'Alumno')
                ->select(
                    'asignacionesalumnos.id as asignacion_id',
                    'persona.dni',
                    'persona.nombre',
                    'persona.apellido',
                    'asignacionesalumnos.id_cursosciclolectivo'
                )
                ->orderBy('persona.apellido')
                ->orderBy('persona.nombre')
                ->get();

            $debug[] = "Paso 5: Consulta ejecutada, total alumnos: " . $alumnos->count();

            if ($alumnos->isEmpty()) {
                $debug[] = "No se encontraron alumnos para el CUPOF: " . $cupof;
                return response()->json([
                    'cupof_info' => $cupofInfo,
                    'alumnos' => [],
                    'debug' => $debug
                ]);
            }

            // Obtener asistencias de hoy
            $debug[] = "Paso 6: Obteniendo asistencias de hoy...";
            $hoy = now()->format('Y-m-d');
            $asistenciasHoy = DB::table('inasistenciasalumnos')
                ->whereIn('id_asignacionesalumnos', $alumnos->pluck('asignacion_id'))
                ->where('cupof', $cupof)
                ->where('fecha', $hoy)
                ->get()
                ->keyBy('id_asignacionesalumnos');

            // Agregar estado de asistencia a cada alumno
            $alumnos = $alumnos->map(function ($alumno) use ($asistenciasHoy) {
                $asistencia = $asistenciasHoy->get($alumno->asignacion_id);
                $alumno->estado_asistencia = $asistencia ? $asistencia->estado : 'P';
                $alumno->justificado = $asistencia ? $asistencia->justificado : '0';
                return $alumno;
            });

            $debug[] = "Paso 7: Alumnos procesados con asistencias - Total final: " . $alumnos->count();

            return response()->json([
                'cupof_info' => $cupofInfo,
                'alumnos' => $alumnos,
                'debug' => $debug
            ]);
        } catch (\Exception $e) {
            $debug[] = "ERROR en obtenerAlumnos: " . $e->getMessage();
            $debug[] = "TRACE: " . $e->getTraceAsString();

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage(),
                'debug' => $debug
            ], 500);
        }
    }

    public function guardarAsistencia(Request $request)
    {
        try {
            // Log de debugging mejorado
            Log::info('Recibiendo request de asistencias:', [
                'method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
                'csrf_token_header' => $request->header('X-CSRF-TOKEN'),
                'csrf_token_body' => $request->input('_token'),
                'user_authenticated' => Auth::check(),
                'user_id' => Auth::id(),
                'session_token' => session()->token(),
                'request_data_keys' => array_keys($request->all()),
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'all_input' => $request->all()
            ]);

            // Verificar autenticación
            if (!Auth::check()) {
                Log::warning('Usuario no autenticado intentando guardar asistencias');
                return response()->json([
                    'success' => false,
                    'error' => 'Usuario no autenticado'
                ], 401);
            }

            // Para Laravel 12, manejar asistencias que pueden venir como string JSON
            $asistenciasData = $request->input('asistencias');
            if (is_string($asistenciasData)) {
                $asistenciasData = json_decode($asistenciasData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Error al decodificar JSON de asistencias:', [
                        'error' => json_last_error_msg(),
                        'data' => $asistenciasData
                    ]);
                    return response()->json([
                        'success' => false,
                        'error' => 'Formato de datos inválido'
                    ], 422);
                }
            }

            // Agregar asistencias procesadas al request para validación
            $request->merge(['asistencias' => $asistenciasData]);

            try {
                $request->validate([
                    'cupof' => 'required|integer',
                    'asistencias' => 'required|array|min:1',
                    'asistencias.*.asignacion_id' => 'required|integer',
                    'asistencias.*.estado' => 'required|in:P,A,T',
                    'asistencias.*.justificado' => 'required|boolean'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Error de validación:', [
                    'errors' => $e->errors(),
                    'input' => $request->all()
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Datos de entrada inválidos',
                    'validation_errors' => $e->errors()
                ], 422);
            }

            $profesor = Auth::user();
            $hoy = now()->format('Y-m-d');
            $cupof = $request->cupof;

            Log::info('Iniciando guardado de asistencias:', [
                'cupof' => $cupof,
                'profesor_dni' => $profesor->dni,
                'cantidad_asistencias' => count($asistenciasData),
                'fecha' => $hoy
            ]);

            // Verificar que el CUPOF existe
            $turno = DB::table('cupof')->where('cupof', $cupof)->value('turno');
            if (!$turno) {
                Log::error('CUPOF no encontrado:', ['cupof' => $cupof]);
                return response()->json([
                    'success' => false,
                    'error' => 'CUPOF no encontrado'
                ], 404);
            }

            DB::beginTransaction();

            $actualizados = 0;
            $creados = 0;

            foreach ($asistenciasData as $asistenciaData) {
                // Verificar si ya existe un registro de asistencia para hoy
                $asistencia = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $asistenciaData['asignacion_id'])
                    ->where('cupof', $cupof)
                    ->where('fecha', $hoy)
                    ->first();

                if ($asistencia) {
                    // Actualizar registro existente
                    DB::table('inasistenciasalumnos')
                        ->where('id', $asistencia->id)
                        ->update([
                            'estado' => $asistenciaData['estado'],
                            'justificado' => $asistenciaData['justificado'] ? '1' : '0',
                            'dni_personal' => $profesor->dni,
                            'updated_at' => now()
                        ]);
                    $actualizados++;
                } else {
                    // Crear nuevo registro
                    DB::table('inasistenciasalumnos')->insert([
                        'id_asignacionesalumnos' => $asistenciaData['asignacion_id'],
                        'cupof' => $cupof,
                        'fecha' => $hoy,
                        'turno' => $turno,
                        'estado' => $asistenciaData['estado'],
                        'justificado' => $asistenciaData['justificado'] ? '1' : '0',
                        'dni_personal' => $profesor->dni,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $creados++;
                }
            }

            DB::commit();

            Log::info('Asistencias guardadas exitosamente:', [
                'cupof' => $cupof,
                'creados' => $creados,
                'actualizados' => $actualizados,
                'total' => $creados + $actualizados
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Asistencias guardadas correctamente',
                'data' => [
                    'creados' => $creados,
                    'actualizados' => $actualizados,
                    'total' => $creados + $actualizados
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en asistencias:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error de validación: ' . collect($e->errors())->flatten()->implode(', ')
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al guardar asistencias:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'cupof' => $request->cupof ?? 'N/A',
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor al guardar las asistencias'
            ], 500);
        }
    }

    public function totales(Request $request, $cupof)
    {
        try {
            // Verificar autenticación
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Debe estar autenticado');
            }

            // Obtener información del CUPOF
            $cupofInfo = DB::table('cupof')
                ->join('materias', 'cupof.id_materias', '=', 'materias.id')
                ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
                ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
                ->where('cupof.cupof', $cupof)
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
                return redirect()->route('profesores.asistencias.index')
                    ->with('error', 'CUPOF no encontrado');
            }

            // Obtener alumnos del grupo
            $alumnos = DB::table('asignacionesalumnos')
                ->join('tipousuario', 'asignacionesalumnos.id_tipousuario', '=', 'tipousuario.id')
                ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
                ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
                ->where('asignacionesalumnos.estado', 'A')
                ->where('asignacionesalumnos.id_grupos', $cupofInfo->id_grupos)
                ->where('tipopersona.tipo', 'Alumno')
                ->select(
                    'asignacionesalumnos.id as asignacion_id',
                    'persona.dni',
                    'persona.nombre',
                    'persona.apellido'
                )
                ->orderBy('persona.apellido')
                ->orderBy('persona.nombre')
                ->get();

            // Calcular estadísticas de asistencia por alumno
            $estadisticas = [];
            foreach ($alumnos as $alumno) {
                // Contar total de días con registro de asistencias para esta materia
                $totalDias = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $alumno->asignacion_id)
                    ->where('cupof', $cupof)
                    ->count();

                // Contar presentes
                $presentes = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $alumno->asignacion_id)
                    ->where('cupof', $cupof)
                    ->where('estado', 'P')
                    ->count();

                // Contar ausencias
                $ausencias = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $alumno->asignacion_id)
                    ->where('cupof', $cupof)
                    ->where('estado', 'A')
                    ->count();

                // Contar tardanzas
                $tardanzas = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $alumno->asignacion_id)
                    ->where('cupof', $cupof)
                    ->where('estado', 'T')
                    ->count();

                // Calcular porcentajes
                $porcentajePresente = $totalDias > 0 ? round(($presentes / $totalDias) * 100, 1) : 0;
                $porcentajeAusencia = $totalDias > 0 ? round(($ausencias / $totalDias) * 100, 1) : 0;
                $porcentajeTardanza = $totalDias > 0 ? round(($tardanzas / $totalDias) * 100, 1) : 0;

                $estadisticas[] = [
                    'alumno' => $alumno,
                    'total_dias' => $totalDias,
                    'presentes' => $presentes,
                    'ausencias' => $ausencias,
                    'tardanzas' => $tardanzas,
                    'porcentaje_presente' => $porcentajePresente,
                    'porcentaje_ausencia' => $porcentajeAusencia,
                    'porcentaje_tardanza' => $porcentajeTardanza
                ];
            }

            return view('profesores.asistencias.porcentajes', compact('cupofInfo', 'estadisticas'));
        } catch (\Exception $e) {
            Log::error("Error en porcentajes de asistencias", [
                'cupof' => $cupof,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('profesores.asistencias.index')
                ->with('error', 'Error al cargar los porcentajes de asistencia');
        }
    }
}
