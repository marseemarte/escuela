@extends('app')

@section('content')
    <div class="container">
        <h1>Dashboard - Bienvenido {{ Auth::user()->nombre_completo }}</h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Asistencias</h5>
                        <p class="card-text">Gestionar asistencias de alumnos</p>
                        <a href="{{ route('asistencias.index') }}" class="btn btn-primary">
                            Ir a Asistencias
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Notas</h5>
                        <p class="card-text">Gestionar notas de alumnos</p>
                        <a href="#" class="btn btn-secondary">
                            Próximamente
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tareas</h5>
                        <p class="card-text">Gestionar tareas y actividades</p>
                        <a href="#" class="btn btn-secondary">
                            Próximamente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
