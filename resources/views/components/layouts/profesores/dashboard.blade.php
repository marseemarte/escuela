<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.profesores.head')
</head>

@php
    $inicio = isset($inicio) ? $inicio : 'false';
    $asistencias = isset($asistencias) ? $asistencias : 'false';
    $tareas = isset($tareas) ? $tareas : 'false';
    $alumnos = isset($alumnos) ? $alumnos : 'false';
    $notas = isset($notas) ? $notas : 'false';
@endphp

<body>
    <!-- Header, main y sidebar -->
    <x-layouts.profesores.header />
    <div class="flex">
        <x-layouts.profesores.sidebar :inicio='$inicio' :asistencias='$asistencias' :tareas='$tareas' :alumnos='$alumnos'
            :notas='$notas' />
        <x-layouts.profesores.main>
            {{ $slot }}
        </x-layouts.profesores.main>
    </div>


</body>


</html>
