@extends('app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orientaciones.index') }}">Orientaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $orientacion->nombre }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $orientacion->nombre }}</h1>
        
    </div>
    <i>Plan de estudio de la orientación de {{ $orientacion->nombre }}</i>     

    <ul class="nav nav-tabs justify-content-center mb-4 border-0" id="anioTabs" role="tablist">
        @foreach([4,5,6,7] as $anio)
            <li class="nav-item">
                <a class="nav-link {{ $anio == 4 ? 'active' : '' }}"
                   id="tab-{{ $anio }}"
                   data-toggle="tab"
                   href="#anio{{ $anio }}"
                   role="tab"
                   aria-controls="anio{{ $anio }}"
                   aria-selected="{{ $anio == 4 ? 'true' : 'false' }}"
                   style="font-size:1.2rem; font-weight:500;">
                    {{ $anio }}° Año
                </a>
            </li>
        @endforeach
    </ul>

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />

    <div class="tab-content" id="anioTabsContent">
        @foreach([4,5,6,7] as $anio)
        <div class="tab-pane fade {{ $anio == 4 ? 'show active' : '' }}" id="anio{{ $anio }}" role="tabpanel" aria-labelledby="tab-{{ $anio }}">
            <div class="row">
                <!-- Materias -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0" style="border-radius:12px;">
                        <div class="card-header font-weight-bold text-white" style="background-color:#1E6AC0; border-radius:12px 12px 0 0; text-align: center; font-size:1.3rem; font-family:'Arial',sans-serif;">
                            Materias
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="materiasTable{{ $anio }}" class="display">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Resumen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($materias->filter(function($materia) use ($anio) { return $materia->anio == $anio && $materia->tipo == 'materia'; }) as $materia)
                                            <tr>
                                                <td>{{ $materia->nombre }}</td>
                                                <td>{{ $materia->resumen }}</td>
                                                <td>
                                                    <a href="" class="btn btn-secondary btn-sm">Editar</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Talleres -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0" style="border-radius:12px;">
                        <div class="card-header bg-light text-dark font-weight-bold" style="border-radius:12px 12px 0 0; text-align: center; font-size:1.3rem; font-family:'Arial',sans-serif;">
                            Talleres
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="talleresTable{{ $anio }}" class="display">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Resumen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($materias->filter(function($materia) use ($anio) { return $materia->anio == $anio && $materia->tipo == 'taller'; }) as $taller)
                                            <tr>
                                                <td>{{ $taller->nombre }}</td>
                                                <td>{{ $taller->resumen }}</td>
                                                <td>
                                                    <a href="" class="btn btn-secondary btn-sm">Editar</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            [4, 5, 6, 7].forEach(anio => {
                $('#materiasTable' + anio).DataTable({
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
                $('#talleresTable' + anio).DataTable({
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
        });
    </script>
@endsection
