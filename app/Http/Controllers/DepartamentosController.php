<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Materia;
use App\Models\Personas\TipoUsuario;
use App\Models\Personas\TipoPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentosController extends Controller
{
    /**
     * Mostrar listado de todos los departamentos
     */
    public function index()
    {
        $departamentos = Departamento::with(['tipoUsuario.persona', 'materias'])
            ->orderBy('nombre')
            ->get();

        // Obtener tipo persona "Profesor"
        $tipoProfesor = TipoPersona::where('tipo', 'Profesor')->first();

        // Obtener profesores disponibles para el modal de crear
        $profesoresDisponibles = [];
        if ($tipoProfesor) {
            $profesoresDisponibles = TipoUsuario::where('id_tipopersona', $tipoProfesor->id)
                ->where('estado', 'A')
                ->whereDoesntHave('departamento')
                ->with('persona')
                ->get()
                ->map(function ($tipoUsuario) {
                    return [
                        'id' => $tipoUsuario->id,
                        'nombre_completo' => $tipoUsuario->persona->apellido . ', ' . $tipoUsuario->persona->nombre,
                        'dni' => $tipoUsuario->persona->dni
                    ];
                })
                ->sortBy('nombre_completo')
                ->values();
        }

        return view('departamentos.index', compact('departamentos', 'profesoresDisponibles'));
    }

    /**
     * Mostrar formulario para crear departamento
     */
    public function create()
    {
        // Obtener tipo persona "Profesor"
        $tipoProfesor = TipoPersona::where('tipo', 'Profesor')->first();

        if (!$tipoProfesor) {
            return redirect()->route('departamentos.index')
                ->with('error', 'No existe el tipo de persona "Profesor"');
        }

        // Obtener profesores disponibles (que no sean jefes de departamento)
        $profesoresDisponibles = TipoUsuario::where('id_tipopersona', $tipoProfesor->id)
            ->where('estado', 'A')
            ->whereDoesntHave('departamento')
            ->with('persona')
            ->get()
            ->map(function ($tipoUsuario) {
                return [
                    'id' => $tipoUsuario->id,
                    'nombre_completo' => $tipoUsuario->persona->apellido . ', ' . $tipoUsuario->persona->nombre
                ];
            })
            ->sortBy('nombre_completo');

        return view('departamentos.create', compact('profesoresDisponibles'));
    }

    /**
     * Guardar nuevo departamento
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:departamento,nombre',
            'descripcion' => 'nullable|string|max:500',
            'id_tipousuario' => 'required|exists:tipousuario,id'
        ]);

        try {
            // Verificar que el profesor no sea jefe de otro departamento
            $existeDepartamento = Departamento::where('id_tipousuario', $request->id_tipousuario)
                ->where('estado', 'A')
                ->exists();

            if ($existeDepartamento) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Este profesor ya es jefe de otro departamento');
            }

            $departamento = Departamento::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_tipousuario' => $request->id_tipousuario,
                'estado' => 'A'
            ]);

            return redirect()->route('departamentos.index')
                ->with('success', 'Departamento creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el departamento: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar departamento específico
     */
    public function show($id)
    {
        $departamento = Departamento::with([
            'tipoUsuario.persona',
            'materias' => function ($query) {
                $query->orderBy('nombre');
            }
        ])->findOrFail($id);

        // Contar profesores por materia
        $materiasConProfesores = $departamento->materias->map(function ($materia) {
            $cantidadProfesores = DB::table('revista')
                ->join('cupof', 'revista.cupof', '=', 'cupof.cupof')
                ->where('cupof.id_materias', $materia->id)
                ->where('revista.situacion', 'A')
                ->where('cupof.estado', 'A')
                ->distinct('revista.id_tipousuario')
                ->count('revista.id_tipousuario');

            return [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'cantidad_profesores' => $cantidadProfesores
            ];
        });

        return response()->json([
            'id' => $departamento->id,
            'nombre' => $departamento->nombre,
            'descripcion' => $departamento->descripcion,
            'estado' => $departamento->estado,
            'jefe' => [
                'nombre' => $departamento->tipoUsuario->persona->nombre,
                'apellido' => $departamento->tipoUsuario->persona->apellido
            ],
            'materias' => $materiasConProfesores
        ]);
    }

    /**
     * Mostrar formulario para editar departamento
     */
    public function edit($id)
    {
        $departamento = Departamento::with('tipoUsuario.persona')->findOrFail($id);

        // Obtener tipo persona "Profesor"
        $tipoProfesor = TipoPersona::where('tipo', 'Profesor')->first();

        // Obtener profesores disponibles (que no sean jefes de otro departamento)
        $profesoresDisponibles = TipoUsuario::where('id_tipopersona', $tipoProfesor->id)
            ->where('estado', 'A')
            ->where(function ($query) use ($departamento) {
                $query->whereDoesntHave('departamento')
                    ->orWhere('id', $departamento->id_tipousuario);
            })
            ->with('persona')
            ->get()
            ->map(function ($tipoUsuario) {
                return [
                    'id' => $tipoUsuario->id,
                    'nombre_completo' => $tipoUsuario->persona->apellido . ', ' . $tipoUsuario->persona->nombre,
                    'dni' => $tipoUsuario->persona->dni
                ];
            })
            ->sortBy('nombre_completo')
            ->values();

        return response()->json([
            'id' => $departamento->id,
            'nombre' => $departamento->nombre,
            'descripcion' => $departamento->descripcion,
            'id_tipousuario' => $departamento->id_tipousuario,
            'estado' => $departamento->estado,
            'profesores' => $profesoresDisponibles
        ]);
    }
    /**
     * Actualizar departamento
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:departamento,nombre,' . $id,
            'descripcion' => 'nullable|string|max:500',
            'id_tipousuario' => 'required|exists:tipousuario,id',
            'estado' => 'required|in:A,I'
        ]);

        try {
            // Verificar que el nuevo profesor no sea jefe de otro departamento
            if ($request->id_tipousuario != $departamento->id_tipousuario) {
                $existeDepartamento = Departamento::where('id_tipousuario', $request->id_tipousuario)
                    ->where('estado', 'A')
                    ->where('id', '!=', $id)
                    ->exists();

                if ($existeDepartamento) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Este profesor ya es jefe de otro departamento');
                }
            }

            $departamento->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_tipousuario' => $request->id_tipousuario,
                'estado' => $request->estado
            ]);

            return redirect()->route('departamentos.index')
                ->with('success', 'Departamento actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el departamento: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar departamento
     */
    public function destroy($id)
    {
        try {
            $departamento = Departamento::findOrFail($id);

            // Verificar si tiene materias asignadas
            if ($departamento->materias()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar el departamento porque tiene materias asignadas');
            }

            $departamento->delete();

            return redirect()->route('departamentos.index')
                ->with('success', 'Departamento eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el departamento: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar vista para gestionar materias del departamento
     */
    public function materias($id)
    {
        $departamento = Departamento::with([
            'tipoUsuario.persona',
            'materias' => function ($query) {
                $query->orderBy('nombre');
            }
        ])->findOrFail($id);

        // Obtener IDs de materias ya asignadas a CUALQUIER departamento
        $materiasAsignadasIds = DB::table('departamento_materia')
            ->pluck('id_materia')
            ->toArray();

        // Obtener materias disponibles (no asignadas a ningún departamento)
        $materiasDisponibles = Materia::whereNotIn('id', $materiasAsignadasIds)
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'asignadas' => $departamento->materias,
            'disponibles' => $materiasDisponibles
        ]);
    }

    /**
     * Asignar materias al departamento
     */
    public function asignarMaterias(Request $request, $id)
    {
        $request->validate([
            'materias' => 'required|array',
            'materias.*' => 'exists:materias,id'
        ]);

        try {
            $departamento = Departamento::findOrFail($id);

            // Asignar materias sin eliminar las existentes
            $departamento->materias()->syncWithoutDetaching($request->materias);

            return redirect()->route('departamentos.materias', $id)
                ->with('success', 'Materias asignadas exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al asignar materias: ' . $e->getMessage());
        }
    }

    /**
     * Quitar materia del departamento
     */
    public function quitarMateria($id, $materiaId)
    {
        try {
            $departamento = Departamento::findOrFail($id);
            $departamento->materias()->detach($materiaId);

            return redirect()->back()
                ->with('success', 'Materia eliminada del departamento exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al quitar la materia: ' . $e->getMessage());
        }
    }
}
