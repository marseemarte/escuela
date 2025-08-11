@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cupofs</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cupofs</h1>
        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="window.location.href='{{ route('cupof.create') }}'">
            + Crear Cupof 
        </button>
    </div>
    <i> Los cupos de materias que están disponibles en la escuela actualmente </i>     

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />

    <table id="cupofTable" class="display">
        <thead>
            <tr>
                <th>ID Cupo</th>
                <th>Materia</th>
                <th>Curso</th>
                <th>División</th>
                <th>Turno</th>
                <th>Horas</th>
                <th>Grupo</th>
                <th>Función</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cupof as $cupo)
                <tr>
                    <td>{{ $cupo->cupof }}</td>
                    <td>
                        {{ $materias->firstWhere('id', $cupo->id_materias)->nombre ?? $cupo->id_materias }}
                    </td>
                    <td>
                        {{ $cursos->firstWhere('id', $cupo->id_cursos)->ano ?? $cupo->id_cursos }}
                    </td>
                    <td>
                        {{ $cursos->firstWhere('id', $cupo->id_cursos)->division ?? '-' }}
                    </td>
                    <td>
                        {{ $cursos->firstWhere('id', $cupo->id_cursos)->turno ?? $cupo->turno }}
                    </td>
                    <td>{{ $cupo->hsmodcar }}</td>
                    <td>{{ $cupo->id_grupos }}</td>
                    <td>{{ $cupo->funcion }}</td>
                    <td>{{ $cupo->cargo }}</td>
                    <td>{{ $cupo->estado }}</td>
                    <td>    
                        <a href="{{ route('cupof.show', $cupo->cupof) }}" class="btn btn-primary btn-sm">Ver Revista</a>
                        <a href="{{ route('cupof.edit', $cupo->cupof) }}" class="btn btn-secondary btn-sm">Editar</a>
                        <form action="{{ route('cupof.destroy', $cupo->cupof) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este cupof?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">No hay cupos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#cupofTable').DataTable({
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
@endsection
