@extends('app')

@section('content')
    <h1 class="mb-4">Planes de Estudio</h1>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <a href="{{ route('programacion') }}" class="card text-center shadow-lg orientacion-card" style="background: #1565c0; color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">💻</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Programación</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('maestro_mayor_de_obra') }}" class="card text-center shadow-lg orientacion-card" style="background: #c62828; color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">🛠️</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">MMO</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('ciclo_basico') }}" class="card text-center shadow-lg orientacion-card" style="background: #ffd600; color: #333; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">📚</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Ciclo Básico</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('turismo') }}" class="card text-center shadow-lg orientacion-card" style="background: #388e3c; color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <span style="font-size: 3em;">🚌</span>
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Turismo</span>
                </div>
            </a>
        </div>
    </div>
    <style>
        .orientacion-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .orientacion-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            text-decoration: none;
        }
    </style>
@endsection