<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CupofController extends Controller
{
    public function index()
    {
        $cupof = DB::table('cupof')->get();
        $materias = DB::table('materias')->get();
        $cursos = DB::table('cursos')->get();

        return view('cupof.index', compact('cupof', 'materias', 'cursos'));
    }

    public function show($cupof)
    {
        // Obtener información del cupof
        $cupo = DB::table('cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
            ->where('cupof.cupof', $cupof)
            ->select(
                'cupof.cupof',
                'cupof.turno',
                'cupof.hsmodcar',
                'cupof.funcion',
                'cupof.cargo',
                'cupof.estado',
                'cupof.id_grupos',
                'materias.nombre as materia_nombre',
                'cursos.ano as curso_ano',
                'cursos.division as curso_division'
            )
            ->first();

        // Obtener profesores asociados al cupof
        $profesores = DB::table('revista')
            ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
            ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
            ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
            ->where('revista.cupof', $cupof)
            ->select(
                'persona.id',
                'persona.dni',
                'persona.nombre',
                'persona.apellido',
                'revista.situacion',
                'revista.fd as f_desde',
                'revista.fh as f_hasta',
                'revista.secuencia',
                'tipopersona.tipo as tipo_usuario'
            )
            ->orderBy('revista.secuencia', 'asc')
            ->get();

        return view('cupof.show', compact('profesores', 'cupo'));
    }

    public function create()
    {
        $materias = DB::table('materias')->orderBy('nombre')->get();
        $cursos = DB::table('cursos')->orderBy('ano')->orderBy('division')->get();
        $grupos = DB::table('grupos')->orderBy('nombre')->get();

        return view('cupof.create', compact('materias', 'cursos', 'grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_materias' => 'required|exists:materias,id',
            'id_cursos' => 'required|exists:cursos,id',
            'turno' => 'required|string|max:50',
            'hsmodcar' => 'required|integer|min:1',
            'funcion' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'id_grupos' => 'nullable|exists:grupos,id',
            'estado' => 'required|in:h,d'
        ]);

        // Generar el próximo cupof disponible
        $maxCupof = DB::table('cupof')->max('cupof');
        $nuevoCupof = $maxCupof + 1;

        DB::table('cupof')->insert([
            'cupof' => $nuevoCupof,
            'turno' => $request->turno,
            'hsmodcar' => $request->hsmodcar,
            'id_materias' => $request->id_materias,
            'id_cursos' => $request->id_cursos,
            'estado' => $request->estado,
            'funcion' => $request->funcion,
            'cargo' => $request->cargo,
            'id_grupos' => $request->id_grupos
        ]);

        return redirect()->route('cupof.index')->with('success', 'Cupof creado exitosamente.');
    }

    public function edit($cupof)
    {
        $cupo = DB::table('cupof')->where('cupof', $cupof)->first();
        
        if (!$cupo) {
            return redirect()->route('cupof.index')->with('error', 'Cupof no encontrado.');
        }

        $materias = DB::table('materias')->orderBy('nombre')->get();
        $cursos = DB::table('cursos')->orderBy('ano')->orderBy('division')->get();
        $grupos = DB::table('grupos')->orderBy('nombre')->get();

        return view('cupof.edit', compact('cupo', 'materias', 'cursos', 'grupos'));
    }

    public function update(Request $request, $cupof)
    {
        $request->validate([
            'id_materias' => 'required|exists:materias,id',
            'id_cursos' => 'required|exists:cursos,id',
            'turno' => 'required|string|max:50',
            'hsmodcar' => 'required|integer|min:1',
            'funcion' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'id_grupos' => 'nullable|exists:grupos,id',
            'estado' => 'required|in:h,d'
        ]);

        DB::table('cupof')
            ->where('cupof', $cupof)
            ->update([
                'turno' => $request->turno,
                'hsmodcar' => $request->hsmodcar,
                'id_materias' => $request->id_materias,
                'id_cursos' => $request->id_cursos,
                'estado' => $request->estado,
                'funcion' => $request->funcion,
                'cargo' => $request->cargo,
                'id_grupos' => $request->id_grupos
            ]);

        return redirect()->route('cupof.index')->with('success', 'Cupof actualizado exitosamente.');
    }

    public function destroy($cupof)
    {
        // Verificar si hay profesores asociados
        $profesoresAsociados = DB::table('revista')->where('cupof', $cupof)->count();
        
        if ($profesoresAsociados > 0) {
            return redirect()->route('cupof.index')->with('error', 'No se puede eliminar el cupof porque tiene profesores asociados.');
        }

        DB::table('cupof')->where('cupof', $cupof)->delete();

        return redirect()->route('cupof.index')->with('success', 'Cupof eliminado exitosamente.');
    }

    // Métodos para gestionar profesores en el cupof
    public function agregarProfesor($cupof)
    {
        $cupo = DB::table('cupof')->where('cupof', $cupof)->first();
        
        if (!$cupo) {
            return redirect()->route('cupof.index')->with('error', 'Cupof no encontrado.');
        }

        // Obtener profesores usando la tabla tipousuario como intermediaria
        $profesores = DB::table('persona')
            ->join('tipousuario', 'persona.id', '=', 'tipousuario.id_persona')
            ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
            ->where('tipousuario.id_tipopersona', 1)
            ->select('persona.id', 'persona.dni', 'persona.nombre', 'persona.apellido', 'tipopersona.tipo')
            ->orderBy('persona.apellido')
            ->orderBy('persona.nombre')
            ->get();

        $tiposUsuario = DB::table('tipopersona')->get();

        return view('cupof.agregar-profesor', compact('cupo', 'profesores', 'tiposUsuario'));
    }

    public function storeProfesor(Request $request, $cupof)
    {
        $request->validate([
            'profesor_id' => 'required|exists:persona,id',
            'situacion' => 'required|string|max:50',
            'f_desde' => 'required|date',
            'f_hasta' => 'nullable|date|after_or_equal:f_desde'
        ]);

        // Obtener la próxima secuencia disponible
        $maxSecuencia = DB::table('revista')
            ->where('cupof', $cupof)
            ->max('secuencia');
        
        $nuevaSecuencia = ($maxSecuencia ?? 0) + 1;

        // Obtener el id_tipousuario del profesor seleccionado
        $tipousuario = DB::table('tipousuario')
            ->where('id_persona', $request->profesor_id)
            ->where('id_tipopersona', 1)
            ->first();

        if (!$tipousuario) {
            return redirect()->back()->with('error', 'El profesor seleccionado no tiene un tipo de usuario válido.');
        }

        try {
            // Verificar si ya existe un registro para este profesor en este cupof
            $existe = DB::table('revista')
                ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
                ->where('revista.cupof', $cupof)
                ->where('tipousuario.id_persona', $request->profesor_id)
                ->exists();

            if ($existe) {
                return redirect()->back()->with('error', 'Este profesor ya está asignado a este cupof.');
            }

            DB::table('revista')->insert([
                'cupof' => $cupof,
                'fd' => $request->f_desde, // Fecha desde
                'fh' => $request->f_hasta, // Fecha hasta
                'id_tipousuario' => $tipousuario->id,
                'secuencia' => $nuevaSecuencia,
                'situacion' => $request->situacion
            ]);

            return redirect()->route('cupof.show', $cupof)->with('success', 'Profesor agregado exitosamente al cupof.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar profesor: ' . $e->getMessage());
        }
    }

    public function eliminarProfesor($cupof, $profesorId)
    {
        // Buscar el registro en revista que corresponda al profesor
        $revista = DB::table('revista')
            ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
            ->where('revista.cupof', $cupof)
            ->where('tipousuario.id_persona', $profesorId)
            ->first();

        if ($revista) {
            DB::table('revista')
                ->where('id', $revista->id)
                ->delete();
        }

        return redirect()->route('cupof.show', $cupof)->with('success', 'Profesor eliminado del cupof exitosamente.');
    }
}
