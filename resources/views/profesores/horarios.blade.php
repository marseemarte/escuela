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
                            @foreach($dias as $dia)
                                <th class="text-center">{{ $dia }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horarios as $franja => $celdas)
                            <tr>
                                <td class="text-center fw-semibold text-secondary">{{ $franja }}</td>
                                @foreach($dias as $dia)
                                    @if(isset($celdas[$dia]) && $celdas[$dia])
                                        <td class="p-2">
                                            <div class="horario-card p-2 rounded">
                                                <div class="fw-bold small text-dark text-uppercase">
                                                    {{ $celdas[$dia]['titulo'] }}
                                                </div>
                                                <div class="small text-primary mt-1">
                                                    {{ $celdas[$dia]['profesor'] }}
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
        .horario-table {
            border: 1px solid #ccc;
        }
        .horario-table th {
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            font-size: 0.85rem;
            border: 1px solid #ccc;
            background: none; /* sin gris */
        }
        .horario-table td {
            font-size: 0.85rem;
            border: 1px solid #ccc;
        }
        .horario-card {
            background: none; /* sin fondo */
            border: 1px solid #ddd;
        }
        .horario-card .fw-bold {
            font-size: 0.75rem;
        }
        .horario-card .text-primary {
            color: #0d6efd !important;
            font-weight: 500;
        }
        /* Responsividad */
        @media (max-width: 768px) {
            .horario-table th, .horario-table td {
                font-size: 0.75rem;
                padding: 4px;
            }
        }
    </style>
</x-layouts.profesores.dashboard>
