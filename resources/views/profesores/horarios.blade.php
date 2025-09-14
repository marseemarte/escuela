<x-layouts.profesores.dashboard horarios titulo="Horarios">
    <div class="container py-4">
        <h1 class="mb-1">Horarios</h1>
        <h2 class="mb-4">Horarios 2025 de Prácticas Profesionalizantes</h2>

        <div class="card shadow-sm rounded">
            <div class="table-responsive">
                <table class="table align-middle mb-0 horario-table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:140px;">Hora</th>
                            @foreach($dias as $clave => $etiqueta)
                                <th class="text-center">{{ $etiqueta }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horarios as $franja => $celdas)
                            <tr>
                                <td class="text-center fw-semibold text-secondary">{{ $franja }}</td>

                                @foreach($dias as $clave => $etiqueta)
                                    @if(isset($celdas[$clave]) && $celdas[$clave] && !empty($celdas[$clave]['titulo']))
                                        <td class="p-2 align-top">
                                            <div class="horario-card p-2 rounded">
                                                <div class="fw-bold small text-dark text-uppercase lh-sm">
                                                    {{ $celdas[$clave]['titulo'] }}
                                                </div>

                                                @if(!empty($celdas[$clave]['profesor']))
                                                    <div class="small text-secondary mt-1">
                                                        {{ $celdas[$clave]['profesor'] }}
                                                    </div>
                                                @endif

                                                <div class="small mt-2">
                                                    @if(!empty($celdas[$clave]['salon']))
                                                        <a href="#" class="text-decoration-none small">Aula {{ $celdas[$clave]['salon'] }}</a>
                                                    @elseif(!empty($celdas[$clave]['abreviatura']))
                                                        <span class="text-primary small">{{ $celdas[$clave]['abreviatura'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="text-center text-muted">—</td>
                                    @endif
                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Estilos --}}
    <style>
        .horario-table { border: 1px solid #ccc; }
        .horario-table th {
            font-weight: 600; color: #333; text-transform: uppercase;
            font-size: 0.85rem; border: 1px solid #ccc; background: none;
        }
        .horario-table td { font-size: 0.85rem; border: 1px solid #ccc; }
        .horario-card {
            background: none; border: 1px solid #eee; min-height:72px;
            word-break: break-word; padding:.6rem;
        }
        .horario-card .fw-bold { font-size:.78rem; }
        .horario-card .small { font-size:.72rem; }
        .lh-sm { line-height:1.05; }
        @media (max-width:768px){ .horario-table th, .horario-table td { font-size:0.75rem; padding:4px; } }
    </style>
</x-layouts.profesores.dashboard>
