@extends('app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orientaciones.index') }}">Orientaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Programación</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Programación</h1>
        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="window.location.href='{{ route('orientaciones.create') }}'">
            + Crear Materia
        </button>   
    </div>
    <i>Plan de estudio de la orientación de Programación</i>     

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
                                <table id="materiasTable{{ $anio }}" class="table table-hover table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($anio == 4)
                                                <td>Sistemas Digitales</td><td>Introducción a los sistemas digitales.</td>
                                            @elseif($anio == 5)
                                                <td>Hardware</td><td>Estudio de componentes físicos de computadoras.</td>
                                            @elseif($anio == 6)
                                                <td>Redes</td><td>Conceptos básicos de redes informáticas.</td>
                                            @elseif($anio == 7)
                                                <td>Base de Datos</td><td>Diseño y administración de bases de datos.</td>
                                            @endif
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm">Ver</a>
                                                <a href="#" class="btn btn-secondary btn-sm">Editar</a>
                                                <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                            </td>
                                        </tr>
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
                                <table id="talleresTable{{ $anio }}" class="table table-hover table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($anio == 4)
                                                <td>Taller de Informática</td><td>Uso básico de computadoras.</td>
                                            @elseif($anio == 5)
                                                <td>Taller de Hardware</td><td>Armado y reparación de PCs.</td>
                                            @elseif($anio == 6)
                                                <td>Taller de Redes</td><td>Instalación y configuración de redes.</td>
                                            @elseif($anio == 7)
                                                <td>Taller de Programación</td><td>Desarrollo de aplicaciones.</td>
                                            @endif
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm">Ver</a>
                                                <a href="#" class="btn btn-secondary btn-sm">Editar</a>
                                                <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                                            </td>
                                        </tr>

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
                        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                    }
                });
                $('#talleresTable' + anio).DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                    }
                });
            });
        });
    </script>
@endsection
