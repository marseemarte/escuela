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
        // Verificar si el usuario es profesor
        $usuario = Auth::user();

        if ($usuario instanceof Persona && $usuario->isProfesor()) {
            // Lógica para profesores
            $materias = Cupof::query()
                ->whereHas('revistas', function ($query) use ($usuario) {
                    $query->where('situacion', 'A')
                        ->whereHas('tipousuario.persona', function ($personaQuery) use ($usuario) {
                            $personaQuery->where('dni', $usuario->dni);
                        });
                })
                ->where('estado', 'A')
                ->with(['materia:id,nombre', 'curso:id,division,ano', 'grupo:id,nombre'])
                ->select('cupof', 'id_materias', 'id_cursos', 'id_grupos', 'turno')
                ->distinct()
                ->get();

            return view('profesores.asistencias.index', compact('materias'));
        }
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

            // Obtener asistencias de hoy
            $hoy = now()->format('Y-m-d');

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

        try {
            // Verificar autenticación
            if (!Auth::check()) {
                return response()->json(['error' => 'No autenticado'], 401);
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
                return response()->json(['error' => 'CUPOF no encontrado'], 404);
            }

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

            if ($alumnos->isEmpty()) {
                return response()->json([
                    'cupof_info' => $cupofInfo,
                    'alumnos' => []
                ]);
            }

            // Obtener asistencias de hoy
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

            return response()->json([
                'cupof_info' => $cupofInfo,
                'alumnos' => $alumnos,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage(),
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
                'all_input' => $request->all(),
                'asistencias_raw' => $request->input('asistencias')
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

            foreach ($asistenciasData as $index => $asistenciaData) {
                Log::info("Procesando asistencia $index:", [
                    'asignacion_id' => $asistenciaData['asignacion_id'],
                    'estado' => $asistenciaData['estado'],
                    'justificado' => $asistenciaData['justificado'],
                    'justificado_type' => gettype($asistenciaData['justificado']),
                    'justificado_var_dump' => var_export($asistenciaData['justificado'], true)
                ]);

                // VALIDACIÓN DEL SERVIDOR: Justificado solo permitido para Ausente (A) o Tarde (T)
                $justificadoFinal = false;
                if ($asistenciaData['justificado'] && ($asistenciaData['estado'] === 'A' || $asistenciaData['estado'] === 'T')) {
                    $justificadoFinal = true;
                } elseif ($asistenciaData['justificado'] && $asistenciaData['estado'] === 'P') {
                    Log::warning("Intento de marcar justificado con estado Presente - rechazado:", [
                        'asignacion_id' => $asistenciaData['asignacion_id'],
                        'estado' => $asistenciaData['estado']
                    ]);
                }

                Log::info("Valor justificado final calculado:", [
                    'asignacion_id' => $asistenciaData['asignacion_id'],
                    'estado' => $asistenciaData['estado'],
                    'justificado_original' => $asistenciaData['justificado'],
                    'justificado_final' => $justificadoFinal
                ]);

                // Verificar si ya existe un registro de asistencia para hoy
                $asistencia = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $asistenciaData['asignacion_id'])
                    ->where('cupof', $cupof)
                    ->where('fecha', $hoy)
                    ->first();

                if ($asistencia) {
                    // Actualizar registro existente
                    $justificadoValue = $justificadoFinal ? '1' : '0';
                    Log::info("Actualizando registro existente:", [
                        'id' => $asistencia->id,
                        'nuevo_estado' => $asistenciaData['estado'],
                        'nuevo_justificado' => $justificadoValue,
                        'valor_original_justificado' => $asistencia->justificado
                    ]);

                    // Test: Verificar valor antes del update
                    $antesUpdate = DB::table('inasistenciasalumnos')->where('id', $asistencia->id)->value('justificado');
                    Log::info("Valor antes del UPDATE:", ['id' => $asistencia->id, 'justificado_antes' => $antesUpdate]);

                    $resultadoUpdate = DB::table('inasistenciasalumnos')
                        ->where('id', $asistencia->id)
                        ->update([
                            'estado' => $asistenciaData['estado'],
                            'justificado' => $justificadoValue,
                            'dni_personal' => $profesor->dni,
                            'updated_at' => now()
                        ]);

                    // Test: Verificar valor después del update
                    $despuesUpdate = DB::table('inasistenciasalumnos')->where('id', $asistencia->id)->value('justificado');
                    Log::info("Resultado del UPDATE:", [
                        'id' => $asistencia->id,
                        'filas_afectadas' => $resultadoUpdate,
                        'justificado_despues' => $despuesUpdate,
                        'update_exitoso' => $despuesUpdate === $justificadoValue
                    ]);

                    $actualizados++;
                } else {
                    // Crear nuevo registro
                    $justificadoValue = $justificadoFinal ? '1' : '0';
                    Log::info("Creando nuevo registro:", [
                        'asignacion_id' => $asistenciaData['asignacion_id'],
                        'estado' => $asistenciaData['estado'],
                        'justificado' => $justificadoValue
                    ]);

                    DB::table('inasistenciasalumnos')->insert([
                        'id_asignacionesalumnos' => $asistenciaData['asignacion_id'],
                        'cupof' => $cupof,
                        'fecha' => $hoy,
                        'turno' => $turno,
                        'estado' => $asistenciaData['estado'],
                        'justificado' => $justificadoValue,
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

            // Calcular estadísticas de asistencia por alumno con lógica de justificaciones
            // REGLAS DEL SISTEMA:
            // 1. Ausencias justificadas: Se muestran pero NO afectan el porcentaje
            // 2. Tardanzas justificadas: Se muestran pero NO afectan el porcentaje
            // 3. Tardanzas NO justificadas: cada 2 tardanzas = 1 ausencia
            // 4. Porcentajes se calculan sobre total de días registrados
            $estadisticas = [];
            foreach ($alumnos as $alumno) {
                // Obtener todos los registros de asistencia para este alumno
                $registrosAsistencia = DB::table('inasistenciasalumnos')
                    ->where('id_asignacionesalumnos', $alumno->asignacion_id)
                    ->where('cupof', $cupof)
                    ->select('estado', 'justificado')
                    ->get();

                $totalDias = $registrosAsistencia->count();

                // Contar por categorías
                $presentes = $registrosAsistencia->where('estado', 'P')->count();

                // Ausencias: solo las NO justificadas cuentan como ausencias
                $ausenciasNoJustificadas = $registrosAsistencia
                    ->where('estado', 'A')
                    ->where('justificado', '0')
                    ->count();

                $ausenciasJustificadas = $registrosAsistencia
                    ->where('estado', 'A')
                    ->where('justificado', '1')
                    ->count();

                // Tardanzas: solo las NO justificadas cuentan (cada 2 = 1 ausencia)
                $tardanzasNoJustificadas = $registrosAsistencia
                    ->where('estado', 'T')
                    ->where('justificado', '0')
                    ->count();

                $tardanzasJustificadas = $registrosAsistencia
                    ->where('estado', 'T')
                    ->where('justificado', '1')
                    ->count();

                // Calcular ausencias efectivas: ausencias reales + (tardanzas no justificadas / 2)
                $ausenciasEfectivas = $ausenciasNoJustificadas + floor($tardanzasNoJustificadas / 2);

                // Calcular porcentajes sobre días totales
                $porcentajePresente = $totalDias > 0 ? round(($presentes / $totalDias) * 100, 1) : 0;
                $porcentajeAusencia = $totalDias > 0 ? round(($ausenciasEfectivas / $totalDias) * 100, 1) : 0;

                $estadisticas[] = [
                    'alumno' => $alumno,
                    'total_dias' => $totalDias,
                    'presentes' => $presentes,
                    'ausencias_no_justificadas' => $ausenciasNoJustificadas,
                    'ausencias_justificadas' => $ausenciasJustificadas,
                    'tardanzas_no_justificadas' => $tardanzasNoJustificadas,
                    'tardanzas_justificadas' => $tardanzasJustificadas,
                    'ausencias_efectivas' => $ausenciasEfectivas,
                    'porcentaje_presente' => $porcentajePresente,
                    'porcentaje_ausencia' => $porcentajeAusencia,
                    // Para compatibilidad con la vista
                    'ausencias' => $ausenciasNoJustificadas,
                    'tardanzas' => $tardanzasNoJustificadas
                ];
            }

            return view('profesores.asistencias.totales', compact('cupofInfo', 'estadisticas'));
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
