@extends('app')

@section('content')
    <h1 class="mb-4">Planes de Estudio</h1>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <a href="{{ route('programacion') }}" class="card text-center shadow-lg orientacion-card" style="background:rgb(89, 114, 151); color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <img src="{{ asset('paper/img/programacion.png') }}" alt="Programación" style="width: 100px; height: 100px;">
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Programación</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('maestro_mayor_de_obra') }}" class="card text-center shadow-lg orientacion-card" style="background: #C46464; color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <img src="{{ asset('paper/img/construccion.png') }}" alt="Maestro Mayor de Obra" style="width: 100px; height: 100px;">
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">MMO</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('ciclo_basico') }}" class="card text-center shadow-lg orientacion-card" style="background:rgb(228, 189, 71); color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <img src="{{ asset('paper/img/ciclo_basico.png') }}" alt="Ciclo Básico" style="width: 100px; height: 100px;">
                    <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">Ciclo Básico</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('turismo') }}" class="card text-center shadow-lg orientacion-card" style="background: #6B9D7C; color: #fff; text-decoration: none; border-radius: 16px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                    <img src="{{ asset('paper/img/turismo.png') }}" alt="Turismo" style="width: 100px; height: 100px;">
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