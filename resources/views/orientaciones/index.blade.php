@extends('app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orientaciones</li>
    </ol>
</nav>
<h1 class="mb-5 text-center display-5 fw-semibold text-primary-emphasis">Planes de Estudio</h1>

<div class="d-flex justify-content-center">
    <div class="p-4 rounded shadow-sm" style="background: linear-gradient(135deg, #f8fafc 80%, #e3eafc 100%); min-width: 80%;">
        <div class="row justify-content-center g-4">
            @php
                $planes = [
                    ['nombre' => 'Programación', 'ruta' => 'programacion', 'color' => '#1565c0', 'emoji' => '💻', 'texto' => '#fff'],
                    ['nombre' => 'MMO', 'ruta' => 'maestro_mayor_de_obra', 'color' => '#c62828', 'emoji' => '🛠️', 'texto' => '#fff'],
                    ['nombre' => 'Ciclo Básico', 'ruta' => 'ciclo_basico', 'color' => '#ffd600', 'emoji' => '📚', 'texto' => '#333'],
                    ['nombre' => 'Turismo', 'ruta' => 'turismo', 'color' => '#388e3c', 'emoji' => '🚌', 'texto' => '#fff'],
                ];
            @endphp

            @foreach($planes as $plan)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route($plan['ruta']) }}"
                       class="card text-center shadow-lg orientacion-card"
                       style="background: {{ $plan['color'] }}; color: {{ $plan['texto'] }}; text-decoration: none; border-radius: 20px;">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center py-4" style="height: 190px;">
                            <div style="font-size: 3rem;">{{ $plan['emoji'] }}</div>
                            <div class="mt-3 fw-bold" style="font-size: 1.25rem;">{{ $plan['nombre'] }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .orientacion-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .orientacion-card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }
</style>
@endsection
