@extends('layouts.app') {{-- o tu layout --}}
@section('content')
<div class="container">
    <h1>Cargar datos (horarios / materias / salones / curso / persona)</h1>

    @if(session('success'))
      <div style="background: #d4edda; padding: 10px; border-radius:5px; margin-bottom:10px;">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background:#f8d7da;padding:10px;border-radius:5px;margin-bottom:10px;">
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('horarios.store') }}">
        @csrf

        {{-- HORAS --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Horas</legend>
            <div id="horas-list">
                <div class="hora-row">
                    <input name="horas[0][nombre]" placeholder="07:20-08:20" required>
                    <input name="horas[0][turno]" placeholder="D" required style="width:50px;">
                    <input name="horas[0][hd]" placeholder="07:20:00" required>
                    <input name="horas[0][hh]" placeholder="08:20:00" required>
                    <label>Activo <input type="checkbox" name="horas[0][activo]" value="1" checked></label>
                </div>
            </div>
            <button type="button" onclick="addHora()">+ Añadir hora</button>
        </fieldset>

        {{-- MATERIAS --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Materias</legend>
            <div id="materias-list">
                <div class="materia-row">
                    <input name="materias[0][nombre]" placeholder="NOMBRE MATERIA" required style="width:60%;">
                    <input name="materias[0][abreviatura]" placeholder="ABR" required style="width:20%;">
                    <input name="materias[0][resumen]" placeholder="Resumen" style="width:15%;">
                </div>
            </div>
            <button type="button" onclick="addMateria()">+ Añadir materia</button>
        </fieldset>

        {{-- SALONES --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Salones</legend>
            <div id="salones-list">
                <div class="salon-row">
                    <input name="salones[0][piso]" placeholder="Piso" style="width:60px;" required>
                    <input name="salones[0][numero]" placeholder="Numero" required style="width:100px;">
                    <input name="salones[0][tipo]" placeholder="Tipo" style="width:120px;">
                    <input name="salones[0][capacidad]" placeholder="Capacidad" style="width:100px;">
                    <input name="salones[0][ubicacion]" placeholder="Ubicacion">
                </div>
            </div>
            <button type="button" onclick="addSalon()">+ Añadir salon</button>
        </fieldset>

        {{-- CURSO --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Curso / Grupo</legend>
            <label>División <input name="curso[division]" required></label>
            <label>Año <input name="curso[ano]" type="number" required></label>
            <label>Turno <input name="curso[turno]" required placeholder="D/T/N" style="width:60px;"></label>

            <div style="margin-top:8px;">
                <label>Grupo nombre <input name="grupos[0][nombre]" value="1"></label>
            </div>
        </fieldset>

        {{-- CUPOF: lista de abreviaturas a vincular --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Cupof (abreviaturas de materias a vincular)</legend>
            <p>Escribe las abreviaturas de las materias que quieras vincular (una por input):</p>
            <div id="cupof-list">
                <input name="cupof[0]" placeholder="PP-SI">
                <input name="cupof[1]" placeholder="SO">
            </div>
            <button type="button" onclick="addCupof()">+ Añadir abreviatura</button>
        </fieldset>

        {{-- HORARIOS --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Horarios (dia, hora, salon, materia)</legend>
            <div id="horarios-list">
                <div class="horario-row">
                    <select name="horarios[0][dia]">
                        @foreach($dias as $d)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                    <input name="horarios[0][hora]" placeholder="07:20-08:20" required>
                    <input name="horarios[0][salon]" placeholder="101" required>
                    <input name="horarios[0][materia]" placeholder="PP-SI" required>
                </div>
            </div>
            <button type="button" onclick="addHorario()">+ Añadir horario</button>
        </fieldset>

        {{-- PERSONA --}}
        <fieldset style="margin-bottom:20px;">
            <legend>Persona (opcional)</legend>
            <input name="persona[dni]" placeholder="DNI">
            <input name="persona[apellido]" placeholder="Apellido">
            <input name="persona[nombre]" placeholder="Nombre">
            <input name="persona[fechan]" placeholder="YYYY-MM-DD">
            <input name="persona[sexo]" placeholder="M/F">
            <input name="persona[domicilio]" placeholder="Domicilio">
            <input name="persona[telefono]" placeholder="Telefono">
            <input name="persona[mail]" placeholder="Email">
        </fieldset>

        <button type="submit">Cargar datos</button>
    </form>
</div>

<script>
    let horaIdx = 1;
    let materiaIdx = 1;
    let salonIdx = 1;
    let cupofIdx = 2;
    let horarioIdx = 1;

    function addHora() {
        const cont = document.getElementById('horas-list');
        const div = document.createElement('div');
        div.className = 'hora-row';
        div.innerHTML = `
            <input name="horas[${horaIdx}][nombre]" placeholder="07:20-08:20" required>
            <input name="horas[${horaIdx}][turno]" placeholder="D" required style="width:50px;">
            <input name="horas[${horaIdx}][hd]" placeholder="07:20:00" required>
            <input name="horas[${horaIdx}][hh]" placeholder="08:20:00" required>
            <label>Activo <input type="checkbox" name="horas[${horaIdx}][activo]" value="1" checked></label>
        `;
        cont.appendChild(div);
        horaIdx++;
    }

    function addMateria() {
        const cont = document.getElementById('materias-list');
        const div = document.createElement('div');
        div.className = 'materia-row';
        div.innerHTML = `
            <input name="materias[${materiaIdx}][nombre]" placeholder="NOMBRE MATERIA" required style="width:60%;">
            <input name="materias[${materiaIdx}][abreviatura]" placeholder="ABR" required style="width:20%;">
            <input name="materias[${materiaIdx}][resumen]" placeholder="Resumen" style="width:15%;">
        `;
        cont.appendChild(div);
        materiaIdx++;
    }

    function addSalon() {
        const cont = document.getElementById('salones-list');
        const div = document.createElement('div');
        div.className = 'salon-row';
        div.innerHTML = `
            <input name="salones[${salonIdx}][piso]" placeholder="Piso" style="width:60px;" required>
            <input name="salones[${salonIdx}][numero]" placeholder="Numero" required style="width:100px;">
            <input name="salones[${salonIdx}][tipo]" placeholder="Tipo" style="width:120px;">
            <input name="salones[${salonIdx}][capacidad]" placeholder="Capacidad" style="width:100px;">
            <input name="salones[${salonIdx}][ubicacion]" placeholder="Ubicacion">
        `;
        cont.appendChild(div);
        salonIdx++;
    }

    function addCupof() {
        const cont = document.getElementById('cupof-list');
        const input = document.createElement('input');
        input.name = `cupof[${cupofIdx}]`;
        input.placeholder = 'ABR';
        cont.appendChild(input);
        cupofIdx++;
    }

    function addHorario() {
        const cont = document.getElementById('horarios-list');
        const div = document.createElement('div');
        div.className = 'horario-row';
        div.innerHTML = `
            <select name="horarios[${horarioIdx}][dia]">
                <option value="LUN">LUN</option>
                <option value="MAR">MAR</option>
                <option value="MIE">MIE</option>
                <option value="JUE">JUE</option>
                <option value="VIE">VIE</option>
            </select>
            <input name="horarios[${horarioIdx}][hora]" placeholder="07:20-08:20" required>
            <input name="horarios[${horarioIdx}][salon]" placeholder="101" required>
            <input name="horarios[${horarioIdx}][materia]" placeholder="PP-SI" required>
        `;
        cont.appendChild(div);
        horarioIdx++;
    }
</script>
@endsection
