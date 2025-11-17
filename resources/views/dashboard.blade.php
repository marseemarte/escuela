@extends('app')

@section('content')
    <div class="container">
        <h1>Dashboard - Bienvenido {{ Auth::user()->nombre_completo }}</h1>

        <div class="row mt-4">
            {{-- Sección de Asistencias (Profesores) --}}
            @if (Auth::user()->isProfesor())
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Asistencias</h5>
                            <p class="card-text">Gestionar asistencias de alumnos</p>
                            <a href="{{ route('profesores.asistencias.index') }}" class="btn btn-primary">
                                Ir a Asistencias
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Informes</h5>
                            <p class="card-text">Gestionar informes de alumnos</p>
                            <a href="{{ route('profesores.informes.index') }}" class="btn btn-primary">
                                Ir a Informes
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tareas</h5>
                            <p class="card-text">Gestionar tareas y actividades</p>
                            <a href="{{ route('profesores.tareas.index') }}" class="btn btn-primary">
                                Ir a Tareas
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sección de Jefe de Departamento --}}
            @if (Auth::user()->tiposUsuario()->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))->exists())
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <i class="fas fa-users-cog"></i> Jefe de Departamento
                            </h5>
                            <p class="card-text">Gestionar materias y profesores del departamento</p>
                            <a href="{{ route('departamento.index') }}" class="btn btn-success">
                                Ir al Panel de Jefe
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sección de estadísticas rápidas --}}
        @if (Auth::user()->tiposUsuario()->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))->exists())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Resumen de Departamento</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $tipoUsuario = Auth::user()
                                    ->tiposUsuario()
                                    ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Jefe de Departamento'))
                                    ->first();
                                $materiasAsignadas = $tipoUsuario ? $tipoUsuario->materiasComoJefe()->count() : 0;
                            @endphp

                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h3 class="text-success">{{ $materiasAsignadas }}</h3>
                                    <p class="text-muted">Materias Asignadas</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-primary">-</h3>
                                    <p class="text-muted">Profesores</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-info">-</h3>
                                    <p class="text-muted">Proyectos Activos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
