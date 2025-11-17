<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $id_asignacionesalumnos
 * @property \App\Models\Cupof $cupof
 * @property \Illuminate\Support\Carbon $fecha
 * @property string $turno
 * @property string $estado
 * @property string $justificado
 * @property int $dni_personal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personas\AsignacionAlumno $asignacionAlumno
 * @property-read mixed $es_justificada
 * @property-read mixed $estado_descriptivo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia justificadas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia noJustificadas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia porEstado($estado)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia porFecha($fecha)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia porTurno($turno)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereCupof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereDniPersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereIdAsignacionesalumnos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereJustificado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereTurno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereUpdatedAt($value)
 */
	class Asistencia extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $cupof
 * @property string $turno
 * @property int $hsmodcar
 * @property int $id_materias
 * @property int $id_cursos
 * @property int $id_grupos
 * @property string $estado
 * @property string $funcion
 * @property string $cargo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asistencia> $asistencias
 * @property-read int|null $asistencias_count
 * @property-read \App\Models\Cursos\Curso $curso
 * @property-read \App\Models\Cursos\Grupo $grupo
 * @property-read \App\Models\Materia $materia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Proyecto> $proyectos
 * @property-read int|null $proyectos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revista> $revistas
 * @property-read int|null $revistas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof activos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof porDescripcion($descripcion)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereCupof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereFuncion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereHsmodcar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereIdCursos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereIdGrupos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereIdMaterias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereTurno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cupof whereUpdatedAt($value)
 */
	class Cupof extends \Eloquent {}
}

namespace App\Models\Cursos{
/**
 * @property int $id
 * @property string $division
 * @property int $ano
 * @property string $turno
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cursos\CursoCicloLectivo> $ciclosLectivos
 * @property-read int|null $ciclos_lectivos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cupof> $cupof
 * @property-read int|null $cupof_count
 * @property-read mixed $nombre_completo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cursos\Grupo> $grupos
 * @property-read int|null $grupos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Materia> $materias
 * @property-read int|null $materias_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso porAno($ano)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso porDivision($division)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso porTurno($turno)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereAno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereTurno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Curso whereUpdatedAt($value)
 */
	class Curso extends \Eloquent {}
}

namespace App\Models\Cursos{
/**
 * @property int $id
 * @property int $id_cursos
 * @property int $ciclolectivo
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personas\AsignacionAlumno> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read \App\Models\Cursos\Curso $curso
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo activos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo porCiclo($ciclo)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereCiclolectivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereIdCursos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CursoCicloLectivo whereUpdatedAt($value)
 */
	class CursoCicloLectivo extends \Eloquent {}
}

namespace App\Models\Cursos{
/**
 * @property int $id
 * @property int $nombre
 * @property int $id_cursos
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personas\AsignacionAlumno> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cupof> $cupof
 * @property-read int|null $cupof_count
 * @property-read \App\Models\Cursos\Curso $curso
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereIdCursos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grupo whereUpdatedAt($value)
 */
	class Grupo extends \Eloquent {}
}

namespace App\Models\Cursos{
/**
 * @property int $id
 * @property string $nombre
 * @property string $titulo
 * @property string $color
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cursos\Curso> $cursos
 * @property-read int|null $cursos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Materia> $materias
 * @property-read int|null $materias_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orientacion whereUpdatedAt($value)
 */
	class Orientacion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_asignacionesalumnos
 * @property int $cupof
 * @property int $dni_personal
 * @property \Illuminate\Support\Carbon $fecha
 * @property numeric $nota
 * @property int $periodo
 * @property-read \App\Models\Cupof $cupofRelation
 * @property-read \App\Models\Personas\Persona $profesor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo porCupof($cupof)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo porPeriodo($periodo)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo porProfesor($dni)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereCupof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereDniPersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereIdAsignacionesalumnos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo whereNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformePeriodo wherePeriodo($value)
 */
	class InformePeriodo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_jefe
 * @property int $id_materia
 * @property \Illuminate\Support\Carbon $fecha_asignacion
 * @property string $estado A=Activo, I=Inactivo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $dias_desde_asignacion
 * @property-read string|null $email_jefe
 * @property-read string $nombre_jefe
 * @property-read string $nombre_materia
 * @property-read string|null $telefono_jefe
 * @property-read string|null $tipo_jefe
 * @property-read \App\Models\Personas\TipoUsuario $jefe
 * @property-read \App\Models\Materia $materia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria activas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria conRelaciones()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria deJefe($idJefe)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria deMateria($idMateria)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria inactivas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria recientes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereFechaAsignacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereIdJefe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereIdMateria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JefeDepartamentoMateria whereUpdatedAt($value)
 */
	class JefeDepartamentoMateria extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string $abreviatura
 * @property string $estado
 * @property string $resumen
 * @property int|null $orientacion_id
 * @property int|null $anio
 * @property string $tipo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JefeDepartamentoMateria> $asignacionesJefes
 * @property-read int|null $asignaciones_jefes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cupof> $cupof
 * @property-read int|null $cupof_count
 * @property-read mixed $jefes_activos
 * @property-read mixed $primer_jefe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personas\TipoUsuario> $jefes
 * @property-read int|null $jefes_count
 * @property-read \App\Models\Cursos\Orientacion|null $orientacion
 * @property-read \App\Models\Planificacion|null $planificacionActual
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Planificacion> $planificaciones
 * @property-read int|null $planificaciones_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia deshabilitadas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia habilitadas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereOrientacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereResumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia withoutTrashed()
 */
	class Materia extends \Eloquent {}
}

namespace App\Models\Personas{
/**
 * @property int $id
 * @property int $id_cursosciclolectivo
 * @property int $id_tipousuario
 * @property int $id_grupos
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asistencia> $asistencias
 * @property-read int|null $asistencias_count
 * @property-read \App\Models\Cursos\CursoCicloLectivo $cursoCicloLectivo
 * @property-read mixed $es_activo
 * @property-read mixed $tipo_usuario_id
 * @property-read \App\Models\Cursos\Grupo $grupo
 * @property-read \App\Models\Personas\TipoUsuario $tipoUsuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno activos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno deCurso($cursoCicloId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno deGrupo($grupoId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno deTipoUsuario($tipoUsuarioId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno inactivos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereIdCursosciclolectivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereIdGrupos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereIdTipousuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionAlumno whereUpdatedAt($value)
 */
	class AsignacionAlumno extends \Eloquent {}
}

namespace App\Models\Personas{
/**
 * @property int $id
 * @property int $dni
 * @property string $apellido
 * @property string $nombre
 * @property \Illuminate\Support\Carbon $fechan
 * @property string $sexo
 * @property string $domicilio
 * @property int $id_localidad
 * @property string $pass
 * @property string $telefono
 * @property string $mail
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $estado
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dni_formatted
 * @property mixed $email
 * @property-read mixed $name
 * @property-read mixed $nombre_completo
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personas\TipoUsuario> $tiposUsuario
 * @property-read int|null $tipos_usuario_count
 * @method static \Database\Factories\PersonaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereDomicilio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereFechan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereIdLocalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Persona whereUpdatedAt($value)
 */
	class Persona extends \Eloquent {}
}

namespace App\Models\Personas{
/**
 * @property int $id
 * @property string $tipo
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JefeDepartamentoMateria> $asignacionesJefe
 * @property-read int|null $asignaciones_jefe_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personas\TipoUsuario> $tiposUsuario
 * @property-read int|null $tipos_usuario_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona porTipo($tipo)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoPersona whereUpdatedAt($value)
 */
	class TipoPersona extends \Eloquent {}
}

namespace App\Models\Personas{
/**
 * @property int $id
 * @property int $id_persona
 * @property int $id_tipopersona
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personas\AsignacionAlumno|null $asignaciones
 * @property-read mixed $materias_activas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Materia> $materiasComoJefe
 * @property-read int|null $materias_como_jefe_count
 * @property-read \App\Models\Personas\Persona $persona
 * @property-read \App\Models\Personas\TipoPersona $tipoPersona
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario porPersona($idPersona)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario porTipo($tipo)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereIdPersona($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereIdTipopersona($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereUpdatedAt($value)
 */
	class TipoUsuario extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tamanio
 * @property string $nombre_archivo
 * @property string $ruta_archivo
 * @property int $id_materia
 * @property int $id_revista
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $extension
 * @property-read mixed $tamanio_formateado
 * @property-read mixed $url_archivo
 * @property-read \App\Models\Materia $materia
 * @property-read \App\Models\Revista $revista
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion masRecientes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion porMateria($materiaId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion porRevista($revistaId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereIdMateria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereIdRevista($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereNombreArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereRutaArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereTamanio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planificacion whereUpdatedAt($value)
 */
	class Planificacion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string $abreviatura
 * @property string $estado
 * @property string $resumen
 * @property int|null $orientacion_id
 * @property int|null $anio
 * @property string $tipo
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion porAnio($anio)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereOrientacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereResumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programacion whereUpdatedAt($value)
 */
	class Programacion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tamanio
 * @property string $nombre_archivo
 * @property string $ruta_archivo
 * @property int $id_revista
 * @property \App\Models\Cupof $cupof
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $color_badge
 * @property-read mixed $extension
 * @property-read mixed $icono
 * @property-read mixed $info_materia
 * @property-read mixed $nombre_profesor
 * @property-read mixed $ruta_completa
 * @property-read mixed $tamanio_formateado
 * @property-read \App\Models\Personas\Persona|null $profesor
 * @property-read \App\Models\Revista $revista
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto buscarPorTitulo($termino)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto masRecientes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto porCupof($cupof)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto porExtension($extension)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto porProfesor($dni)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto porRevista($revistaId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereCupof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereIdRevista($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereNombreArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereRutaArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereTamanio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proyecto whereUpdatedAt($value)
 */
	class Proyecto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \App\Models\Cupof $cupof
 * @property int $id_tipousuario
 * @property \Illuminate\Support\Carbon $fd
 * @property \Illuminate\Support\Carbon $fh
 * @property int $secuencia
 * @property string $situacion
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Planificacion|null $planificacionActual
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Planificacion> $planificaciones
 * @property-read int|null $planificaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Proyecto> $proyectos
 * @property-read int|null $proyectos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tarea> $tareas
 * @property-read int|null $tareas_count
 * @property-read \App\Models\Personas\TipoUsuario $tipoUsuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereCupof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereFd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereFh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereIdTipousuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereSecuencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereSituacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revista whereUpdatedAt($value)
 */
	class Revista extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string $abreviatura
 * @property string $estado
 * @property string $resumen
 * @property int|null $orientacion_id
 * @property int|null $anio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cursos\Orientacion|null $orientacion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller deshabilitados()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller habilitados()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereOrientacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereResumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taller whereUpdatedAt($value)
 */
	class Taller extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $tamanio
 * @property string $nombre_archivo
 * @property string $ruta_archivo
 * @property string $tipo
 * @property \Illuminate\Support\Carbon $fecha_subida
 * @property \Illuminate\Support\Carbon|null $fecha_entrega
 * @property int $id_revista
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TareaAlumno> $entregas
 * @property-read int|null $entregas_count
 * @property-read mixed $es_modulo
 * @property-read mixed $es_tarea
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TareaNota> $notas
 * @property-read int|null $notas_count
 * @property-read \App\Models\Revista $revista
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea delProfesor($profesorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea modulos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea tareasConEntrega()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereFechaEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereFechaSubida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereIdRevista($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereNombreArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereRutaArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereTamanio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarea whereUpdatedAt($value)
 */
	class Tarea extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_tarea
 * @property int $id_asignacionesalumnos
 * @property \Illuminate\Support\Carbon $fecha
 * @property string $nombre_archivo
 * @property string|null $ruta_archivo
 * @property int $borrado_fisico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personas\AsignacionAlumno $asignacionAlumno
 * @property-read \App\Models\Tarea $tarea
 * @property-read \App\Models\TareaNota|null $tarea_nota
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereBorradoFisico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereIdAsignacionesalumnos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereIdTarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereNombreArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereRutaArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaAlumno whereUpdatedAt($value)
 */
	class TareaAlumno extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_tarea
 * @property int $id_asignacionesalumnos
 * @property string $nota
 * @property string|null $devolucion
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property-read \App\Models\Personas\AsignacionAlumno $asignacionAlumno
 * @property-read \App\Models\Tarea $tarea
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereDevolucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereIdAsignacionesalumnos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereIdTarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TareaNota whereUpdatedAt($value)
 */
	class TareaNota extends \Eloquent {}
}

