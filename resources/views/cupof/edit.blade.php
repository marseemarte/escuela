@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.index') }}">Cupofs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Cupof {{ $cupo->cupof }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Editar Cupof {{ $cupo->cupof }}</h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Información del Cupof</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cupof.update', $cupo->cupof) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_materias" class="form-label">Materia *</label>
                            <select class="form-select @error('id_materias') is-invalid @enderror" id="id_materias" name="id_materias" required>
                                <option value="">Seleccione una materia</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ old('id_materias', $cupo->id_materias) == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_materias')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_cursos" class="form-label">Curso *</label>
                            <select class="form-select @error('id_cursos') is-invalid @enderror" id="id_cursos" name="id_cursos" required>
                                <option value="">Seleccione un curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ old('id_cursos', $cupo->id_cursos) == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->ano }}° {{ $curso->division }} - {{ $curso->turno }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_cursos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="turno" class="form-label">Turno *</label>
                            <select class="form-select @error('turno') is-invalid @enderror" id="turno" name="turno" required>
                                <option value="">Seleccione el turno</option>
                                <option value="M" {{ old('turno', $cupo->turno) == 'M' ? 'selected' : '' }}>M (Mañana)</option>
                                <option value="T" {{ old('turno', $cupo->turno) == 'T' ? 'selected' : '' }}>T (Tarde)</option>
                                <option value="V" {{ old('turno', $cupo->turno) == 'V' ? 'selected' : '' }}>V (Noche)</option>
                            </select>
                            @error('turno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="hsmodcar" class="form-label">Horas *</label>
                            <input type="number" class="form-control @error('hsmodcar') is-invalid @enderror" 
                                   id="hsmodcar" name="hsmodcar" value="{{ old('hsmodcar', $cupo->hsmodcar) }}" 
                                   min="1" max="40" required>
                            @error('hsmodcar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="id_grupos" class="form-label">Grupo</label>
                            <select class="form-select @error('id_grupos') is-invalid @enderror" id="id_grupos" name="id_grupos">
                                <option value="">Sin grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('id_grupos', $cupo->id_grupos) == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_grupos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="funcion" class="form-label">Función *</label>
                            <input type="text" class="form-control @error('funcion') is-invalid @enderror" 
                                   id="funcion" name="funcion" value="{{ old('funcion', $cupo->funcion) }}" 
                                   placeholder="Ej: Docente titular" required>
                            @error('funcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo *</label>
                            <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                                   id="cargo" name="cargo" value="{{ old('cargo', $cupo->cargo) }}" 
                                   placeholder="Ej: Profesor de Matemática" required>
                            @error('cargo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado *</label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="">Seleccione el estado</option>
                                <option value="h" {{ old('estado', $cupo->estado) == 'h' ? 'selected' : '' }}>Activo</option>
                                <option value="d" {{ old('estado', $cupo->estado) == 'd' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cupof.show', $cupo->cupof) }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Actualizar Cupof
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
