@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.index') }}">Cupofs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.show', $cupo->cupof) }}">Cupof {{ $cupo->cupof }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar Profesor</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Agregar Profesor al Cupof {{ $cupo->cupof }}</h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Información del Cupof</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Cupof:</strong> {{ $cupo->cupof }}
                </div>
                <div class="col-md-3">
                    <strong>Materia:</strong> {{ $cupo->materia_nombre ?? 'N/A' }}
                </div>
                <div class="col-md-3">
                    <strong>Curso:</strong> {{ $cupo->curso_ano ?? 'N/A' }}° {{ $cupo->curso_division ?? '' }}
                </div>
                <div class="col-md-3">
                    <strong>Turno:</strong> 
                    @if($cupo->turno == 'M')
                        Mañana
                    @elseif($cupo->turno == 'T')
                        Tarde
                    @elseif($cupo->turno == 'V')
                        Noche
                    @else
                        {{ $cupo->turno }}
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <strong>Horas:</strong> {{ $cupo->hsmodcar }}
                </div>
                <div class="col-md-3">
                    <strong>Función:</strong> {{ $cupo->funcion }}
                </div>
                <div class="col-md-3">
                    <strong>Cargo:</strong> {{ $cupo->cargo }}
                </div>
                <div class="col-md-3">
                    <strong>Estado:</strong> 
                    @if($cupo->estado == 'h')
                        <span class="badge bg-success">Activo</span>
                    @elseif($cupo->estado == 'd')
                        <span class="badge bg-danger">Inactivo</span>
                    @else
                        <span class="badge bg-secondary">{{ $cupo->estado }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Seleccionar Profesor</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cupof.store-profesor', $cupo->cupof) }}" method="POST" id="formAgregarProfesor">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="situacion" class="form-label">Situación *</label>
                            <select class="form-select situacion-soft @error('situacion') is-invalid @enderror" id="situacion" name="situacion" required>
                                <option value="">Seleccione la situación</option>
                               
                                <option value="Titular" {{ old('situacion') == 'Titular' ? 'selected' : '' }}>Titular</option>
                                <option value="Suplente" {{ old('situacion') == 'Suplente' ? 'selected' : '' }}>Suplente</option>
                                <option value="Provisional" {{ old('situacion') == 'Provisional' ? 'selected' : '' }}>Provisional</option>
                                <option value="Tit. Interino" {{ old('situacion') == 'Tit. Interino' ? 'selected' : '' }}>Tit. Interino</option>
                            </select>
                            @error('situacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="f_desde" class="form-label">Fecha Desde *</label>
                            <input type="date" class="form-control @error('f_desde') is-invalid @enderror" 
                                   id="f_desde" name="f_desde" value="{{ old('f_desde') }}" required>
                            @error('f_desde')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="f_hasta" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control @error('f_hasta') is-invalid @enderror" 
                                   id="f_hasta" name="f_hasta" value="{{ old('f_hasta') }}">
                            @error('f_hasta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Dejar vacío si no tiene fecha de finalización</small>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Seleccionar Profesor *</label>
                    <div class="table-responsive">
                        <table id="profesoresTable" class="display">
                            <thead>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profesores as $profesor)
                                    <tr>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="radio" 
                                                       name="profesor_id" id="profesor_{{ $profesor->id }}" 
                                                       value="{{ $profesor->id }}" 
                                                       {{ old('profesor_id') == $profesor->id ? 'checked' : '' }} required>
                                            </div>
                                        </td>
                                        <td>{{ $profesor->dni }}</td>
                                        <td>{{ $profesor->nombre }}</td>
                                        <td>{{ $profesor->apellido }}</td>
                                        <td>{{ $profesor->tipo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('profesor_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cupof.show', $cupo->cupof) }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success" id="btnAgregar" disabled>
                        Agregar Profesor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Estilos CSS para elementos soft -->
    <style>
        .situacion-soft {
            border: 1px solid #d1d3e2;
            border-radius: 10px;
            padding: 8px 12px;
            background-color: #fff;
            color: #5a5c69;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .situacion-soft:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }
        
        .situacion-soft:hover {
            border-color: #bac8f3;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar DataTable
            $('#profesoresTable').DataTable({
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
                },
                pageLength: 10,
                order: [[3, 'asc'], [2, 'asc']], // Ordenar por apellido, luego nombre
                columnDefs: [
                    { orderable: false, targets: 0 } // La columna de selección no es ordenable
                ]
            });

            // Habilitar/deshabilitar botón según selección
            const radioButtons = document.querySelectorAll('input[name="profesor_id"]');
            const btnAgregar = document.getElementById('btnAgregar');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    btnAgregar.disabled = !this.checked;
                });
            });

            // Verificar si ya hay una selección al cargar la página
            const selectedRadio = document.querySelector('input[name="profesor_id"]:checked');
            if (selectedRadio) {
                btnAgregar.disabled = false;
            }
        });
    </script>
@endsection
