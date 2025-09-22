<x-layouts.profesores.dashboard>

@section('content')
<div class="container">
    <h2>Cargar horarios</h2>

    @if ($errors->any())
      <div>
        <ul>
          @foreach ($errors->all() as $err)
            <li style="color:red">{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div style="color:green">{{ session('success') }}</div>
    @endif

    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf

        <div>
            <label for="turno">Turno</label>
            <select name="turno" id="turno" required>
                <option value="">-- seleccionar --</option>
                @foreach($turnos as $label => $value)
                    <option value="{{ $value }}" {{ old('turno') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_cursos">Curso</label>
            <select name="id_cursos" id="id_cursos" required>
                <option value="">-- seleccionar --</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ old('id_cursos') == $curso->id ? 'selected' : '' }}>
                        {{ $curso->ano }} {{ $curso->division ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_grupos">Grupo</label>
            <select name="id_grupos" id="id_grupos" required>
                <option value="">-- seleccionar --</option>
                @foreach($grupos as $g)
                    <option value="{{ $g->id }}" {{ old('id_grupos') == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_materias">Materia</label>
            <select name="id_materias" id="id_materias" required>
                <option value="">-- seleccionar --</option>
                @foreach($materias as $m)
                    <option value="{{ $m->id }}" {{ old('id_materias') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_salones">Salón</label>
            <select name="id_salones" id="id_salones" required>
                <option value="">-- seleccionar --</option>
                @foreach($salones as $s)
                    <option value="{{ $s->id }}" {{ old('id_salones') == $s->id ? 'selected' : '' }}>{{ $s->numero }}</option>
                @endforeach
            </select>
        </div>

        <hr>

        <div>
            <label>Días (selecciona uno o varios)</label>
            <div>
                @foreach($dias as $key => $label)
                    <label style="margin-right:10px">
                        <input type="checkbox" name="dias[]" value="{{ $key }}" {{ (is_array(old('dias')) && in_array($key, old('dias'))) ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        <div style="margin-top: 1rem;">
            <label>Horas (selecciona una o varias)</label>
            <div>
                @foreach($horas as $h)
                    <label style="display:inline-block; width:200px; margin:4px">
                        <input type="checkbox" name="horas[]" value="{{ $h->id }}" {{ (is_array(old('horas')) && in_array($h->id, old('horas'))) ? 'checked' : '' }}>
                        {{ $h->nombre }} ({{ substr($h->hd,0,5) }} - {{ substr($h->hh,0,5) }})
                    </label>
                @endforeach
            </div>
        </div>

        <div style="margin-top:1rem">
            <label for="estado">Estado</label>
            <select name="estado" id="estado">
                <option value="A" {{ old('estado','A') == 'A' ? 'selected' : '' }}>Activo</option>
                <option value="I" {{ old('estado') == 'I' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div style="margin-top:1rem">
            <button type="submit">Subir horarios</button>
        </div>
    </form>
</div>
@endsection
