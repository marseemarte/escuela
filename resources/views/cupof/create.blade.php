@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.index') }}">Cupofs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Cupof</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Crear Nuevo Cupof</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Información del Cupof</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cupof.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_materias" class="form-label">Materia *</label>
                            <select class="form-select @error('id_materias') is-invalid @enderror" id="id_materias" name="id_materias" required>
                                <option value="">Seleccione una materia</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ old('id_materias') == $materia->id ? 'selected' : '' }}>
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
                                    <option value="{{ $curso->id }}" {{ old('id_cursos') == $curso->id ? 'selected' : '' }}>
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
                                <option value="M" {{ old('turno') == 'M' ? 'selected' : '' }}>M (Mañana)</option>
                                <option value="T" {{ old('turno') == 'T' ? 'selected' : '' }}>T (Tarde)</option>
                                <option value="V" {{ old('turno') == 'V' ? 'selected' : '' }}>V (Noche)</option>
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
                                   id="hsmodcar" name="hsmodcar" value="{{ old('hsmodcar') }}" 
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
                                    <option value="{{ $grupo->id }}" {{ old('id_grupos') == $grupo->id ? 'selected' : '' }}>
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
                                   id="funcion" name="funcion" value="{{ old('funcion') }}" 
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
                                   id="cargo" name="cargo" value="{{ old('cargo') }}" 
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
                                <option value="h" {{ old('estado') == 'h' ? 'selected' : '' }}>Activo</option>
                                <option value="d" {{ old('estado') == 'd' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cupof.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        Crear Cupof
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
