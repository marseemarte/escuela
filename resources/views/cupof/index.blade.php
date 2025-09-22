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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif     

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
                    <td>{{ $cupo->materia_nombre ?? 'N/A' }}</td>
                    <td>{{ $cupo->curso_ano ?? 'N/A' }}</td>
                    <td>{{ $cupo->curso_division ?? '-' }}</td>
                    <td>
                        @if($cupo->turno == 'M')
                            Mañana
                        @elseif($cupo->turno == 'T')
                            Tarde
                        @elseif($cupo->turno == 'V')
                            Noche
                        @else
                            {{ $cupo->turno }}
                        @endif
                    </td>
                    <td>{{ $cupo->hsmodcar }}</td>
                    <td>{{ $cupo->grupo_nombre ?? 'Sin grupo' }}</td>
                    <td>{{ $cupo->funcion }}</td>
                    <td>{{ $cupo->cargo }}</td>
                    <td>
                        @if($cupo->estado == 'h')
                            <span class="badge bg-success">Activo</span>
                        @elseif($cupo->estado == 'd')
                            <span class="badge bg-danger">Inactivo</span>
                        @else
                            <span class="badge bg-secondary">{{ $cupo->estado }}</span>
                        @endif
                    </td>
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
