<?php

namespace App\Http\Controllers\Profesores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class HorariosController extends Controller
{
    /**
     * Mostrar formulario de creación de horarios
     */
    public function create()
    {
        $horas = DB::table('horas')->where('activo', 1)->orderBy('hd', 'asc')->get();
        $cursos = DB::table('cursos')->orderBy('ano')->orderBy('division')->get();
        $grupos = DB::table('grupos')->orderBy('nombre')->get();
        $materias = DB::table('materias')->orderBy('nombre')->get();
        $salones = DB::table('salones')->orderBy('numero')->get();

        $turnos = ['Mañana' => 'M', 'Tarde' => 'T', 'Noche' => 'N'];

        $dias = [
            'L' => 'Lunes',
            'M' => 'Martes',
            'X' => 'Miércoles',
            'J' => 'Jueves',
            'V' => 'Viernes',
            'S' => 'Sábado'
        ];

        return view('profesores.create', compact('horas','cursos','grupos','materias','salones','turnos','dias'));
    }

    /**
     * Guardar horarios
     */
    public function store(Request $request)
    {
        $rules = [
            'turno' => ['required', 'string'],
            'id_cursos' => ['required', 'integer'],
            'id_grupos' => ['required', 'integer'],
            'id_materias' => ['required', 'integer'],
            'id_salones' => ['required', 'integer'],
            'dias' => ['required', 'array', 'min:1'],
            'dias.*' => ['string'],
            'horas' => ['required', 'array', 'min:1'],
            'horas.*' => ['integer'],
            'estado' => ['nullable', Rule::in(['A','I'])],
        ];

        $validator = Validator::make($request->all(), $rules, [
            'dias.required' => 'Debes seleccionar al menos un día.',
            'horas.required' => 'Debes seleccionar al menos una hora.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $turno = $request->input('turno');
        $idCurso = $request->input('id_cursos');
        $idGrupo = $request->input('id_grupos');
        $idMateria = $request->input('id_materias');
        $idSalon = $request->input('id_salones');
        $dias = $request->input('dias');
        $horas = $request->input('horas');
        $estado = $request->input('estado', 'A');

        // validar existencia cupof
        $cupof = DB::table('cupof')
            ->where('id_cursos', $idCurso)
            ->where('id_grupos', $idGrupo)
            ->where('id_materias', $idMateria)
            ->where('turno', $turno)
            ->first();

        if (!$cupof) {
            return redirect()->back()
                ->withErrors(['cupof' => 'No se encontró una asignación (cupof) para el curso/grupo/materia/turno seleccionados. Crea primero la entrada en cupof.'])
                ->withInput();
        }

        $cupofKey = $cupof->cupof ?? $cupof->id ?? null;

        // validar conflictos de horarios
        $conflictos = [];
        foreach ($dias as $dia) {
            foreach ($horas as $horaId) {
                $existe = DB::table('horarios')
                    ->where('dia', $dia)
                    ->where('id_horas', $horaId)
                    ->where('id_salones', $idSalon)
                    ->where('estado','A')
                    ->first();

                if ($existe) {
                    $conflictos[] = [
                        'dia' => $dia,
                        'hora_id' => $horaId,
                        'salon_id' => $idSalon
                    ];
                }
            }
        }

        if (!empty($conflictos)) {
            $mensajes = [];
            foreach ($conflictos as $c) {
                $hora = DB::table('horas')->where('id', $c['hora_id'])->first();
                $salon = DB::table('salones')->where('id', $c['salon_id'])->first();
                $mensajes[] = "Conflicto: día {$c['dia']}, hora " . ($hora->nombre ?? $c['hora_id']) . ", salón " . ($salon->numero ?? $c['salon_id']);
            }
            return redirect()->back()->withErrors(['conflictos' => $mensajes])->withInput();
        }

        // inserción
        DB::beginTransaction();
        try {
            $insertData = [];
            $now = now();
            foreach ($dias as $dia) {
                foreach ($horas as $horaId) {
                    $insertData[] = [
                        'cupof' => $cupofKey,
                        'id_horas' => $horaId,
                        'dia' => $dia,
                        'id_salones' => $idSalon,
                        'estado' => $estado,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
            }

            DB::table('horarios')->insert($insertData);
            DB::commit();

            return redirect()->route('horarios.create')->with('success', 'Horarios cargados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['db' => 'Error al guardar: ' . $e->getMessage()])->withInput();
        }
    }
}
