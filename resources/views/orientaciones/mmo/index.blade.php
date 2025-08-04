@extends('app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orientaciones.index') }}">Orientaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Maestro Mayor de Obra</li>
        </ol>
    </nav>
    <h1 class="display-4 text-center mb-4" style="font-size:2.5rem; font-weight:600;">Maestro Mayor de Obra</h1>

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
                        <div class="card-header font-weight-bold text-white" style="background-color:#972e2e; border-radius:12px 12px 0 0; text-align: center; font-size:1.3rem; font-family:'Arial',sans-serif;">
                            Materias
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="materiasTable{{ $anio }}" class="table table-hover table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($anio == 4)
                                            <tr><td>Dibujo Técnico</td><td>Fundamentos del dibujo en construcción.</td></tr>
                                        @elseif($anio == 5)
                                            <tr><td>Materiales de Construcción</td><td>Propiedades y usos de materiales.</td></tr>
                                        @elseif($anio == 6)
                                            <tr><td>Instalaciones</td><td>Instalaciones eléctricas y sanitarias.</td></tr>
                                        @elseif($anio == 7)
                                            <tr><td>Proyecto Final</td><td>Desarrollo de proyecto de obra.</td></tr>
                                        @endif
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($anio == 4)
                                            <tr><td>Taller de Construcción</td><td>Prácticas básicas de obra.</td></tr>
                                        @elseif($anio == 5)
                                            <tr><td>Taller de Materiales</td><td>Reconocimiento y uso de materiales.</td></tr>
                                        @elseif($anio == 6)
                                            <tr><td>Taller de Instalaciones</td><td>Montaje de instalaciones.</td></tr>
                                        @elseif($anio == 7)
                                            <tr><td>Taller de Proyecto</td><td>Presentación de proyecto final.</td></tr>
                                        @endif
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

