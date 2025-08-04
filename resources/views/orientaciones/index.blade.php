@extends('app')

@section('content')
    <h1 class="mb-4">Planes de Estudio</h1>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <a href="{{ route('programacion') }}" class="card text-center shadow-lg orientacion-card"
               style="background: #bbdefb; color: #0d47a1; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">💻</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Programación</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('maestro_mayor_de_obra') }}" class="card text-center shadow-lg orientacion-card"
               style="background: #ffcdd2; color: #b71c1c; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">🛠️</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">MMO</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('ciclo_basico') }}" class="card text-center shadow-lg orientacion-card"
               style="background: #fff9c4; color: #fbc02d; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">📚</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Ciclo Básico</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('turismo') }}" class="card text-center shadow-lg orientacion-card"
               style="background: #c8e6c9; color: #1b5e20; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">🚌</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Turismo</span>
                </div>
            </a>
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
