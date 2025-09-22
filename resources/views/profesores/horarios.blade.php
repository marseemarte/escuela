<x-layouts.profesores.dashboard horarios titulo="Horarios">
    <div class="container py-4">
        <h1 class="mb-1">Horarios</h1>
        <h2 class="mb-4">Horarios 2025 de Prácticas Profesionalizantes</h2>

        {{-- Lista de cursos con botón para abrir modal --}}
        <div class="row mb-4">
            @forelse($cursosList as $curso)
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">
                                @if($curso['anio'] || $curso['division'])
                                    {{ $curso['anio'] ? $curso['anio'].'°' : '' }} {{ $curso['division'] ?? '' }}
                                    @if(!empty($curso['grupo_nombre'])) - {{ $curso['grupo_nombre'] }} @endif
                                @else
                                    Curso {{ $curso['cupof'] }}
                                @endif
                            </h5>

                            <p class="card-text text-muted small mb-3">
                                Turno: {{ isset($curso['turno']) ? ( $curso['turno'] === 'M' ? 'Mañana' : ($curso['turno'] === 'T' ? 'Tarde' : 'Noche') ) : '—' }}
                            </p>

                            <div class="mt-auto">
                                <button type="button"
                                        class="btn btn-outline-primary btn-sm w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#horarioCursoModal{{ $curso['cupof'] }}">
                                    <i class="fas fa-clock me-2"></i> Ver horario
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal específico para este curso (cupof) --}}
                <div class="modal fade" id="horarioCursoModal{{ $curso['cupof'] }}" tabindex="-1" aria-labelledby="horarioCursoLabel{{ $curso['cupof'] }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="horarioCursoLabel{{ $curso['cupof'] }}">
                                    @if($curso['anio'] || $curso['division'])
                                        Horario — {{ $curso['anio'] ? $curso['anio'].'°' : '' }} {{ $curso['division'] ?? '' }}
                                        @if(!empty($curso['grupo_nombre'])) - {{ $curso['grupo_nombre'] }} @endif
                                    @else
                                        Horario — Curso {{ $curso['cupof'] }}
                                    @endif
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <div class="modal-body">
                                @php
                                    $cup = $curso['cupof'];
                                    $horario = $horariosPorCurso[$cup] ?? null;
                                @endphp

                                @if($horario && count($horario) > 0)
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
                                                @foreach($horario as $franja => $celdas)
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
                                @else
                                    <div class="text-center py-4">
                                        <p class="mb-0 text-muted">No hay horario cargado para este curso.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                {{-- <a href="{{ route('profesores.horarios.editar', $curso['cupof']) }}" class="btn btn-primary">Editar horario</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        No hay cursos para mostrar.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Reuso estilos del horario original --}}
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
        @media (max-width: 576px) {
            .modal-dialog { max-width: 100%; margin: 0 10px; }
        }
    </style>
</x-layouts.profesores.dashboard>
