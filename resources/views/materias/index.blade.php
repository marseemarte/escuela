@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Materias</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Materias</h1>
        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="window.location.href='{{ route('materias.create') }}'">
            + Nueva Materia
        </button>
    </div>
    <i> Listado de materias disponibles </i>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />

    <table id="materiasTable" class="display">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th>Estado</th>
                <th>Resumen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($materias as $materia)
                <tr>
                    <td>{{ $materia->nombre }}</td>
                    <td>{{ $materia->abreviatura }}</td>
                    <td>
                        @if($materia->estado == 'h')
                            <span class="badge bg-success">Activo</span>
                        @elseif($materia->estado == 'd')
                            <span class="badge bg-danger">Inactivo</span>
                        @else
                            <span class="badge bg-secondary">{{ $materia->estado }}</span>
                        @endif
                    </td>
                    <td>{{ $materia->resumen }}</td>
                    <td>
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm btn-warning">Editar</a>
                        {{-- 
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Seguro que querés eliminar esta materia?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form> 
                        --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay materias cargadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#materiasTable').DataTable({
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar MENU registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del START al END de un total de TOTAL registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de MAX registros)",
                    "sSearch":         "Buscar:",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar de forma ascendente",
                        "sSortDescending": ": Activar para ordenar de forma descendente"
                    }
                }
            });
        });
    </script>
@endsection