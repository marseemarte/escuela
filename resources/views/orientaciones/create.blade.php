@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orientaciones.index') }}">Orientaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Orientación</li>
        </ol>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Crear Orientación</h1>
                    <button type="button" class="btn btn-secondary btn-sm"
                        onclick="window.location.href='{{ route('orientaciones.index') }}'">
                        Volver Atrás
                    </button>
                </div>
                <div class="mb-3">
                    <i>Crear una nueva orientación de estudio</i>    
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Errores:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('orientaciones.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre de la Orientación</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="{{ old('nombre') }}" required maxlength="255">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                value="{{ old('titulo') }}" required maxlength="255">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="color" class="form-label">Color de la Orientación</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-control" id="color" name="color" required>
                                        <option value="" disabled {{ old('color') ? '' : 'selected' }}>
                                            Seleccione un color
                                        </option>
                                        <option value="#6B9D7C" {{ old('color') == '#6B9D7C' ? 'selected' : '' }}>
                                            Verde Esmeralda
                                        </option>
                                        <option value="#597297" {{ old('color') == '#597297' ? 'selected' : '' }}>
                                            Azul Profundo
                                        </option>
                                        <option value="#C46464" {{ old('color') == '#C46464' ? 'selected' : '' }}>
                                            Rojo Coral
                                        </option>
                                        <option value="#E4BD47" {{ old('color') == '#E4BD47' ? 'selected' : '' }}>
                                            Amarillo Dorado
                                        </option>
                                        <option value="#FFA600" {{ old('color') == '#FFA600' ? 'selected' : '' }}>
                                            Naranja Brillante
                                        </option>
                                        <option value="#8E44AD" {{ old('color') == '#8E44AD' ? 'selected' : '' }}>
                                            Púrpura Real
                                        </option>
                                        <option value="#3498DB" {{ old('color') == '#3498DB' ? 'selected' : '' }}>
                                            Azul Cielo
                                        </option>
                                        <option value="#E74C3C" {{ old('color') == '#E74C3C' ? 'selected' : '' }}>
                                            Rojo Intenso
                                        </option>
                                        <option value="#2ECC71" {{ old('color') == '#2ECC71' ? 'selected' : '' }}>
                                            Verde Lima
                                        </option>
                                        <option value="#F39C12" {{ old('color') == '#F39C12' ? 'selected' : '' }}>
                                            Naranja Dorado
                                        </option>
                                        <option value="#9B59B6" {{ old('color') == '#9B59B6' ? 'selected' : '' }}>
                                            Violeta Suave
                                        </option>
                                        <option value="#1ABC9C" {{ old('color') == '#1ABC9C' ? 'selected' : '' }}>
                                            Turquesa
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div id="color-preview" class="border rounded p-3 text-center" 
                                         style="background-color: {{ old('color', '#6B9D7C') }}; color: white; font-weight: bold;">
                                        Vista Previa
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Crear Orientación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorSelect = document.getElementById('color');
            const colorPreview = document.getElementById('color-preview');
            
            function updateColorPreview() {
                const selectedColor = colorSelect.value || '#6B9D7C';
                colorPreview.style.backgroundColor = selectedColor;
            }
            
            colorSelect.addEventListener('change', updateColorPreview);
            updateColorPreview(); // Inicializar con el color por defecto
        });
    </script>
@endsection
