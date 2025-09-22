<x-layouts.profesores.dashboard horarios="true" titulo="Horarios">
    <div class="container py-4">
        <h1 class="mb-1">Horarios</h1>

        {{-- Lista de cursos con botón para abrir modal --}}
        <div class="row g-3 mb-4">
            @forelse($cursosList as $curso)
                @php
                    $cupRaw = (string) ($curso['cupof'] ?? '');
                    $cup = preg_replace('/[^A-Za-z0-9_-]/', '_', $cupRaw);
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 curso-card">
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Título de la materia/curso -->
                            <h5 class="card-title mb-1 fw-bold text-dark">
                                @if(!empty($curso['grupo_nombre']))
                                    {{ $curso['grupo_nombre'] }}
                                @else
                                    Curso {{ $curso['cupof'] }}
                                @endif
                            </h5>

                            <p class="card-subtitle mb-3 text-muted small fw-normal">
                                {{ $curso['anio'] ? $curso['anio'].'° ' : '' }}{{ $curso['division'] ?? 'A' }} - {{ $curso['cupof'] ?? '' }}
                            </p>

                            <!-- Información del turno -->
                            <div class="curso-info mb-3 flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-dark me-2" style="font-size: 0.875rem;"></i>
                                    <span class="small text-dark">
                                        Turno: {{ isset($curso['turno']) ? ( $curso['turno'] === 'M' ? 'Mañana' : ($curso['turno'] === 'T' ? 'Tarde' : 'Noche') ) : 'Mañana' }}
                                    </span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users text-dark me-2" style="font-size: 0.875rem;"></i>
                                    <span class="small text-dark">
                                        Curso: {{ $curso['anio'] ? $curso['anio'].'°' : '4°' }} Año División {{ $curso['division'] ?? 'A' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Botón para ver horario (sin onclick inline) -->
                            <div class="mt-auto">
                                <button type="button" class="btn btn-primary w-100 gestionar-btn"
                                        data-cupof="{{ $cupRaw }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#horarioCursoModal{{ $cup }}">
                                    <i class="fas fa-tasks me-2"></i>ver horario
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-4">
                        <i class="fas fa-info-circle me-2"></i>
                        No hay cursos para mostrar.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modales fuera del loop principal --}}
    @if(isset($cursosList) && count($cursosList) > 0)
        @foreach($cursosList as $curso)
            @php
                $cupRaw = (string) ($curso['cupof'] ?? '');
                $cup = preg_replace('/[^A-Za-z0-9_-]/', '_', $cupRaw);
                $horario = $horariosPorCurso[$curso['cupof'] ?? ''] ?? null;
            @endphp

            <div class="modal fade" id="horarioCursoModal{{ $cup }}" tabindex="-1"
                 aria-labelledby="horarioCursoLabel{{ $cup }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <div>
                                <h5 class="modal-title mb-1" id="horarioCursoLabel{{ $cup }}">
                                    <i class="fas fa-clock me-2"></i>
                                    @if($curso['anio'] || $curso['division'])
                                        {{ $curso['anio'] ? $curso['anio'].'°' : '' }} {{ $curso['division'] ?? '' }}
                                        @if(!empty($curso['grupo_nombre'])) - {{ $curso['grupo_nombre'] }} @endif
                                    @else
                                        Curso {{ $curso['cupof'] }}
                                    @endif
                                </h5>
                                <small class="text-white-50">
                                    Turno {{ isset($curso['turno']) ? ( $curso['turno'] === 'M' ? 'Mañana' : ($curso['turno'] === 'T' ? 'Tarde' : 'Noche') ) : '—' }}
                                </small>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body p-0">
                            @if($horario && count($horario) > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 horario-table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-center fw-bold" style="width:120px;">
                                                    <i class="fas fa-clock me-1"></i>Hora
                                                </th>
                                                @foreach($dias as $clave => $etiqueta)
                                                    <th class="text-center fw-bold">
                                                        <div class="d-none d-md-block">{{ $etiqueta }}</div>
                                                        <div class="d-md-none">{{ substr($etiqueta, 0, 3) }}</div>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($horario as $franja => $celdas)
                                                <tr>
                                                    <td class="text-center fw-semibold text-primary bg-light">
                                                        <small>{{ $franja }}</small>
                                                    </td>

                                                    @foreach($dias as $clave => $etiqueta)
                                                        @if(isset($celdas[$clave]) && $celdas[$clave] && !empty($celdas[$clave]['titulo']))
                                                            <td class="p-2 align-top">
                                                                <div class="horario-card p-2 rounded border-start border-3 border-primary">
                                                                    <div class="fw-bold small text-dark lh-sm mb-1">
                                                                        {{ $celdas[$clave]['titulo'] }}
                                                                    </div>

                                                                    @if(!empty($celdas[$clave]['profesor']))
                                                                        <div class="small text-secondary mb-1">
                                                                            <i class="fas fa-user me-1"></i>
                                                                            {{ $celdas[$clave]['profesor'] }}
                                                                        </div>
                                                                    @endif

                                                                    @if(!empty($celdas[$clave]['salon']))
                                                                        <div class="small text-primary">
                                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                                            Aula {{ $celdas[$clave]['salon'] }}
                                                                        </div>
                                                                    @elseif(!empty($celdas[$clave]['abreviatura']))
                                                                        <div class="small text-primary">
                                                                            {{ $celdas[$clave]['abreviatura'] }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td class="text-center text-muted p-3">
                                                                <small>—</small>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-times text-muted fs-1 mb-3"></i>
                                    <p class="mb-0 text-muted">No hay horario cargado para este curso.</p>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Estilos mejorados --}}
    <style>
        /* Tarjetas de cursos - Estilo similar a la imagen */
        .curso-card {
            transition: all 0.2s ease;
            border: 1px solid #e9ecef;
            background-color: #e8f2ff;
            border-radius: 8px;
            min-height: 180px;
            max-height: 220px;
        }

        .curso-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-color: #d1e7dd;
        }

        .curso-card .card-body {
            padding: 1rem !important;
        }

        .curso-card .card-title {
            font-size: 1.25rem;
            color: #1a1a1a !important;
            line-height: 1.2;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .curso-card .card-subtitle {
            font-size: 0.85rem;
            color: #495057 !important;
            margin-bottom: 0.75rem;
            line-height: 1.1;
        }

        .curso-card .curso-info {
            flex-grow: 1;
            margin-bottom: 0.75rem;
        }

        .curso-card .curso-info .small {
            font-size: 0.8rem;
            color: #343a40;
            line-height: 1.3;
        }

        .curso-card .curso-info i {
            color: #343a40 !important;
            font-size: 0.8rem;
        }

        .curso-card .gestionar-btn {
            background-color: #4285f4;
            border-color: #4285f4;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.7rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            color: white;
        }

        .curso-card .gestionar-btn:hover {
            background-color: #3367d6;
            border-color: #3367d6;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(66, 133, 244, 0.3);
        }

        .curso-card .gestionar-btn:focus {
            background-color: #3367d6;
            border-color: #3367d6;
            box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.25);
        }

        /* Tabla de horarios */
        .horario-table {
            border: none;
            font-size: 0.85rem;
        }

        .horario-table th {
            background-color: #f8f9fa !important;
            border: 1px solid #dee2e6;
            color: #495057;
            font-size: 0.8rem;
            padding: 0.75rem 0.5rem;
        }

        .horario-table td {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .horario-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef !important;
            min-height: 80px;
            word-break: break-word;
            transition: all 0.2s ease;
        }

        .horario-card:hover {
            background: #e9ecef;
            transform: scale(1.02);
        }

        .horario-card .fw-bold {
            font-size: 0.8rem;
            line-height: 1.2;
        }

        .horario-card .small {
            font-size: 0.75rem;
            line-height: 1.1;
        }

        /* Modal */
        /* Usa un z-index ligeramente superior para prevenir conflictos con elementos personalizados */
        .modal {
            z-index: 1060;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-dialog {
            margin: 1rem;
        }

        /* Modal responsivo */
        @media (max-width: 768px) {
            .horario-table th, .horario-table td {
                font-size: 0.75rem;
                padding: 0.5rem 0.25rem;
            }

            .horario-card {
                min-height: 60px;
                padding: 0.5rem !important;
            }

            .modal-dialog {
                margin: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 100%;
                margin: 0.25rem;
            }

            .horario-table {
                font-size: 0.7rem;
            }
        }

        /* Animaciones mejoradas */
        .modal.fade .modal-dialog {
            transform: scale(0.7) translate(0, -50px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .modal.show .modal-dialog {
            transform: scale(1) translate(0, 0);
            opacity: 1;
        }

        /* Scroll personalizado */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    {{-- JavaScript robusto para modales --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando sistema de modales (robusto) ...');

            function sanitizeCup(cup) {
                return String(cup).replace(/[^A-Za-z0-9_-]/g, '_');
            }

            function initAfterBootstrap() {
                if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
                    console.error('Bootstrap Modal no disponible tras cargarlo.');
                    return;
                }

                // Conectar botones .gestionar-btn
                document.querySelectorAll('.gestionar-btn').forEach(function(btn) {
                    try { btn.removeAttribute('onclick'); } catch(e){}

                    btn.addEventListener('click', function(e) {
                        const cupRaw = btn.dataset.cupof || btn.getAttribute('data-cupof');
                        if (!cupRaw) {
                            console.warn('Botón sin data-cupof');
                            return;
                        }

                        const cup = sanitizeCup(cupRaw);
                        const modalId = 'horarioCursoModal' + cup;
                        const modalEl = document.getElementById(modalId);

                        if (!modalEl) {
                            console.error('Modal no encontrado:', modalId);
                            alert('Error: modal no encontrado (ID: ' + modalId + '). Revisa la consola.');
                            return;
                        }

                        let modalInstance;
                        if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                            modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        } else {
                            modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        }
                        modalInstance.show();
                    });
                });

                // Limpieza de backdrops residuales al cerrar
                document.querySelectorAll('.modal').forEach(function(modalEl) {
                    modalEl.addEventListener('hidden.bs.modal', function() {
                        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    });
                });

                console.log('Inicialización de modales completada.');
            }

            // Si bootstrap no está definido, cargar bundle desde CDN (fallback)
            if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
                console.warn('Bootstrap no detectado. Intentando cargar bootstrap.bundle desde CDN (fallback)...');
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js';
                s.crossOrigin = 'anonymous';
                s.onload = function() {
                    console.log('Bootstrap cargado dinámicamente. Inicializando modales...');
                    initAfterBootstrap();
                };
                s.onerror = function() {
                    console.error('No se pudo cargar Bootstrap desde CDN. Asegúrate de incluirlo en el layout.');
                    // No hacemos alert intrusivo en producción, pero en desarrollo es útil:
                    // alert('Error: Bootstrap JS no está disponible. Revisa la consola y que el bundle esté cargado.');
                };
                document.body.appendChild(s);
            } else {
                initAfterBootstrap();
            }

            // Función de debug accesible en consola
            window.debugModal = function(cupof) {
                const cupSan = sanitizeCup(cupof);
                const id = 'horarioCursoModal' + cupSan;
                console.log('DEBUG modal id:', id, 'element:', document.getElementById(id));
            };
        });
    </script>
</x-layouts.profesores.dashboard>
