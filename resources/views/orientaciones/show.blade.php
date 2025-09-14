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
        @php
            $anios = $orientacion->id == 4 ? [1, 2, 3] : [4, 5, 6, 7];

        @endphp
        @foreach ($anios as $anio)
            <li class="nav-item">
                <a class="nav-link {{ $anio == ($orientacion->id == 4 ? 1 : 4) ? 'active' : '' }}" id="tab-{{ $anio }}" data-toggle="tab"
                    href="#anio{{ $anio }}" role="tab" aria-controls="anio{{ $anio }}"
                    aria-selected="{{ $anio == ($orientacion->id == 4 ? 1 : 4) ? 'true' : 'false' }}" style="font-size:1.2rem; font-weight:500;">
                    {{ $anio }}° Año
                </a>
            </li>
        @endforeach
    </ul>

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />

    <style>
        .modal-lg {
            max-width: 900px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>

    <div class="tab-content" id="anioTabsContent">
        @foreach ($anios as $anio)
            <div class="tab-pane fade {{ $anio == ($orientacion->id == 4 ? 1 : 4) ? 'show active' : '' }}" id="anio{{ $anio }}" role="tabpanel"
                aria-labelledby="tab-{{ $anio }}">
                <div class="row">
                    <!-- Materias -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0" style="border-radius:12px;">
                            <div class="card-header font-weight-bold text-white"
                                style="background-color:#1E6AC0; border-radius:12px 12px 0 0; text-align: center; font-size:1.3rem; font-family:'Arial',sans-serif;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Materias</span>
                                    <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                        data-target="#materiasModal" data-orientacion-id="{{ $orientacion->id }}"
                                        data-anio="{{ $anio }}" data-tipo="materia">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
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
                                            @foreach ($materias->filter(function ($materia) use ($anio) {
                                                return $materia->anio == $anio && $materia->tipo == 'materia';
                                            }) as $materia)
                                                <tr>
                                                    <td>{{ $materia->nombre }}</td>
                                                    <td>{{ $materia->resumen }}</td>
                                                    <td>
                                                        <!--<a href="" class="btn btn-secondary btn-sm">Editar</a>-->
                                                        <form
                                                            action="{{ route('materias.cambiar_orientacion', $materia->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="orientacion_id" value="5">
                                                            <input type="hidden" name="anio"
                                                                value="{{ $materia->anio }}">
                                                            <input type="hidden" name="tipo"
                                                                value="{{ $materia->tipo }}">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Eliminar</button>
                                                        </form>
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
                            <div class="card-header bg-light text-dark font-weight-bold"
                                style="border-radius:12px 12px 0 0; text-align: center; font-size:1.3rem; font-family:'Arial',sans-serif;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Talleres</span>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#materiasModal" data-orientacion-id="{{ $orientacion->id }}"
                                        data-anio="{{ $anio }}" data-tipo="taller">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
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
                                            @foreach ($materias->filter(function ($materia) use ($anio) {
                                            return $materia->anio == $anio && $materia->tipo == 'taller';
                                        }) as $taller)
                                                <tr>
                                                    <td>{{ $taller->nombre }}</td>
                                                    <td>{{ $taller->resumen }}</td>
                                                    <td>
                                                        <!--<a href="" class="btn btn-secondary btn-sm">Editar</a>-->
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

    <!-- Modal para buscar y agregar materias -->
    <div class="modal fade" id="materiasModal" tabindex="-1" role="dialog" aria-labelledby="materiasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materiasModalLabel">Buscar Materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Información:</strong> Al seleccionar una materia, se moverá a la orientación y año actuales.
                        Esto actualizará la base de datos y la materia aparecerá en la tabla correspondiente.
                    </div>

                    <div class="form-group">
                        <label for="searchMateria">Buscar materia:</label>
                        <input type="text" class="form-control" id="searchMateria"
                            placeholder="Escriba para buscar...">
                    </div>

                    <div class="form-group">
                        <label for="filterOrientacion">Filtrar por orientación:</label>
                        <select class="form-control" id="filterOrientacion">
                            <option value="">Todas las orientaciones</option>
                            <option value="1">Programación</option>
                            <option value="2">Turismo</option>
                            <option value="3">Construcción</option>
                            <option value="4">Ciclo Básico</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="filterAnio">Filtrar por año:</label>
                        <select class="form-control" id="filterAnio">
                            <option value="">Todos los años</option>
                            @if($orientacion->id == 4)
                                <option value="1">1° Año</option>
                                <option value="2">2° Año</option>
                                <option value="3">3° Año</option>
                            @elseif($orientacion->id == 1 || $orientacion->id == 2 || $orientacion->id == 3)
                                <option value="4">4° Año</option>
                                <option value="5">5° Año</option>
                                <option value="6">6° Año</option>
                                <option value="7">7° Año</option>
                            @endif
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="materiasSearchTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Resumen</th>
                                    <th>Orientación</th>
                                    <th>Año</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allMaterias as $materia)
                                    <tr
                                        class="materia-row"
                                        data-orientacion="{{ $materia->orientacion_id }}"
                                        data-anio="{{ $materia->anio }}"
                                    >
                                        <td>{{ $materia->nombre }}</td>
                                        <td>{{ $materia->resumen }}</td>
                                        <td>{{ $materia->orientacion->nombre ?? 'Sin clasificar' }}</td>
                                        <td>{{ $materia->anio }}° Año</td>
                                        <td>
                                            <!-- Botón para agregar a la orientación actual -->
                                            <form method="POST" action="{{ route('materias.cambiar_orientacion', $materia->id) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="orientacion_id" value="" class="input-orientacion-id">
                                                <input type="hidden" name="anio" value="" class="input-anio">
                                                <input type="hidden" name="tipo" value="{{ $materia->tipo }}">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Seleccionar
                                                </button>
                                            </form>
                                            <!-- Botón para mover a Sin clasificar -->
                                            <form method="POST" action="{{ route('materias.cambiar_orientacion', $materia->id) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="orientacion_id" value="5">
                                                <input type="hidden" name="anio" value="{{ $materia->anio }}">
                                                <input type="hidden" name="tipo" value="{{ $materia->tipo }}">
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-ban"></i> Sin clasificar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar DataTables
            @php
                $anios = $orientacion->id == 4 ? [1, 2, 3] : [4, 5, 6, 7];
            @endphp
            @json($anios).forEach(anio => {
                $('#materiasTable' + anio).DataTable({
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
                $('#talleresTable' + anio).DataTable({
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
            });

            // Variables globales para el modal
            let currentOrientacionId = null;
            let currentAnio = null;
            let currentTipo = null;
            let allMaterias = @json($allMaterias ?? []);

        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    $('#materiasModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orientacionId = button.data('orientacion-id');
        var anio = button.data('anio');
        $(this).find('.input-orientacion-id').val(orientacionId);
        $(this).find('.input-anio').val(anio);
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function filtrarMaterias() {
        let texto = document.getElementById('searchMateria').value.toLowerCase();
        let orientacion = document.getElementById('filterOrientacion').value;
        let anio = document.getElementById('filterAnio').value;

        document.querySelectorAll('#materiasSearchTable .materia-row').forEach(function(row) {
            let nombre = row.children[0].textContent.toLowerCase();
            let resumen = row.children[1].textContent.toLowerCase();
            let rowOrientacion = row.getAttribute('data-orientacion');
            let rowAnio = row.getAttribute('data-anio');

            let coincideTexto = nombre.includes(texto) || resumen.includes(texto) || texto === '';
            let coincideOrientacion = (orientacion === '' || rowOrientacion === orientacion);
            let coincideAnio = (anio === '' || rowAnio === anio);

            if (coincideTexto && coincideOrientacion && coincideAnio) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('searchMateria').addEventListener('input', filtrarMaterias);
    document.getElementById('filterOrientacion').addEventListener('change', filtrarMaterias);
    document.getElementById('filterAnio').addEventListener('change', filtrarMaterias);
});
</script>
@endsection
