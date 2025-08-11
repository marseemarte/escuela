@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.index') }}">Cupofs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cupof {{ $cupo->cupof ?? 'N/A' }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Revista de Profesores - Cupof {{ $cupo->cupof ?? 'N/A' }}</h1>
        <a href="{{ route('cupof.agregar-profesor', $cupo->cupof) }}" class="btn btn-success btn-sm">
            + Agregar Profesor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cupo)
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
                        <strong>Materia:</strong> {{ $cupo->materia_nombre }}
                    </div>
                    <div class="col-md-3">
                        <strong>Curso:</strong> {{ $cupo->curso_ano }}° {{ $cupo->curso_division }}
                    </div>
                    <div class="col-md-3">
                        <strong>Turno:</strong> {{ $cupo->turno }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <strong>Función:</strong> {{ $cupo->funcion }}
                    </div>
                    <div class="col-md-3">
                        <strong>Cargo:</strong> {{ $cupo->cargo }}
                    </div>
                    <div class="col-md-3">
                        <strong>Horas:</strong> {{ $cupo->hsmodcar }}
                    </div>
                    <div class="col-md-3">
                        <strong>Estado:</strong> 
                        @if($cupo->estado == 'h')
                            Activo
                        @elseif($cupo->estado == 'd')
                            Inactivo
                        @else
                            {{ $cupo->estado }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Profesores Asociados</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Secuencia</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo Usuario</th>
                            <th>Situación</th>
                            <th>F. Desde</th>
                            <th>F. Hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profesores as $profesor)
                            <tr>
                                <td>{{ $profesor->secuencia }}</td>
                                <td>{{ $profesor->dni }}</td>
                                <td>{{ $profesor->nombre }}</td>
                                <td>{{ $profesor->apellido }}</td>
                                <td>{{ $profesor->tipo_usuario }}</td>
                                <td>{{ $profesor->situacion }}</td>
                                <td>{{ $profesor->f_desde ? \Carbon\Carbon::parse($profesor->f_desde)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $profesor->f_hasta ? \Carbon\Carbon::parse($profesor->f_hasta)->format('d/m/Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('cupof.editar-profesor', [$cupo->cupof, $profesor->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('cupof.eliminar-profesor', [$cupo->cupof, $profesor->id]) }}" 
                                          method="POST" style="display:inline;" 
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este profesor del cupof?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    No hay profesores asociados a este cupof.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('cupof.index') }}" class="btn btn-secondary">
            Volver a la lista
        </a>
        <a href="{{ route('cupof.edit', $cupo->cupof) }}" class="btn btn-primary">
            Editar Cupof
        </a>
    </div>
@endsection
