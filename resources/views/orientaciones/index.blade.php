@extends('app')

@section('content')

<!-- esto carga datos de CUPOF -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="#">Orientaciones</a></li>
        </ol>
    </nav>
    <h1 class="mb-4">Planes de Estudio</h1>
    <div class="text-center">
        <div class="row">
            @foreach($orientaciones as $orientacion)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('orientaciones.show', $orientacion->id) }}"
                       class="card text-center shadow-lg orientacion-card"
                       style="background:
                            {{ $orientacion->id == 1 ? 'rgb(89, 114, 151)' : 
                               ($orientacion->id == 2 ? '#6B9D7C' : 
                               ($orientacion->id == 3 ? '#C46464' :
                               ($orientacion->id == 4 ? 'rgb(228, 189, 71)' : 'rgb(228, 189, 71)'))) }};
                            color: #fff; text-decoration: none; border-radius: 16px;">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                            <img src="{{ asset('paper/img/' . strtolower(str_replace(' ', '_', $orientacion->nombre)) . '.png') }}"
                                 alt="{{ $orientacion->nombre }}" style="width: 100px; height: 100px;">
                            <span class="mt-2 font-weight-bold" style="font-size: 1.3em;">{{ $orientacion->nombre }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
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