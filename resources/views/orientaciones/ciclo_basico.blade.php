@extends('app')

@section('content')
    <h1>Ciclo Basico</h1>
    <ul class="nav nav-tabs mb-3" id="anioTabs" role="tablist">
        @foreach([1,2,3] as $anio)
            <li class="nav-item">
                <a class="nav-link {{ $anio == 1 ? 'active' : '' }}"
                   id="tab-{{ $anio }}"
                   data-toggle="tab"
                   href="#anio{{ $anio }}"
                   role="tab"
                   aria-controls="anio{{ $anio }}"
                   aria-selected="{{ $anio == 1 ? 'true' : 'false' }}">
                    {{ $anio }}° Año
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="anioTabsContent">
        <div class="tab-pane fade show active" id="anio1" role="tabpanel" aria-labelledby="tab-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>Materias</h4>
                    <table id="materiasTable4" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ejemplo de materia</td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Talleres</h4>
                    <table id="talleresTable4" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ejemplo de taller</td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="anio2" role="tabpanel" aria-labelledby="tab-5">
            <div class="row">
                <div class="col-md-6">
                    <h4>Materias</h4>
                    <table id="materiasTable5" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ejemplo de materia 2do</td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Talleres</h4>
                    <table id="talleresTable5" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ejemplo de taller 2</td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="anio3" role="tabpanel" aria-labelledby="tab-6">
            <div class="row">
                <div class="col-md-6">
                    <h4>Materias</h4>
                    <table id="materiasTable6" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ejemplo de materia 3 </td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Talleres</h4>
                    <table id="talleresTable6" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Taller 3</td><td>ejemplo</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        [4,5,6,7].forEach(function(anio) {
            $('#materiasTable'+anio).DataTable();
            $('#talleresTable'+anio).DataTable();
        });
    });
</script>
@endsection

