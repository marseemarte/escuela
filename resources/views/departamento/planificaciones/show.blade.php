<x-layouts.departamento.dashboard planificaciones titulo="Planificaciones"
    title="Mi Técnica | Panel de Jefes de Departamento - Planificaciones">

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            <!-- Botón volver -->
                            <a href="{{ route('departamento.planificaciones.index') }}"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            <!-- Información -->
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">{{ $materia->nombre }}</h1>
                                <p class="text-muted mb-0">
                                    @if ($materia->orientacion)
                                        {{ $materia->orientacion->nombre }} |
                                    @endif
                                    {{ $materia->anio }}º Año - {{ $materia->tipo }}
                                </p>
                            </div>
                        </div>

                        <!-- Información adicional (Fecha) -->
                        <div class="text-center text-md-right">
                            <small class="text-muted">
                                {{ now()->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="feather icon-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Planificaciones de la materia -->
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-1">Planificaciones de {{ $materia->nombre }}</h2>
                    <p class="text-muted mb-0">Todas las planificaciones cargadas por los profesores de esta materia
                    </p>
                </div>
                <div class="card-body">
                    @if (count($planificaciones) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Profesor</th>
                                        <th>Curso</th>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha de carga</th>
                                        <th>Última actualización</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planificaciones as $planificacion)
                                        <tr>
                                            <td>
                                                <i class="feather icon-user mr-1"></i>
                                                {{ $planificacion->revista->tipoUsuario->persona->apellido }}
                                                {{ $planificacion->revista->tipoUsuario->persona->nombre }}
                                            </td>
                                            <td>
                                                {{ $planificacion->revista->getRelation('cupof')->curso->ano }}º
                                                {{ $planificacion->revista->getRelation('cupof')->curso->division }}
                                                @if ($planificacion->revista->getRelation('cupof')->grupo)
                                                    -
                                                    {{ $planificacion->revista->getRelation('cupof')->grupo->nombre }}
                                                @endif
                                            </td>
                                            <td>
                                                <i class="feather icon-file-text mr-1"></i>
                                                {{ Str::limit($planificacion->nombre_archivo, 40) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-light">{{ $planificacion->tamanio_formateado }}</span>
                                            </td>
                                            <td>
                                                <i class="feather icon-calendar mr-1 text-muted"></i>
                                                {{ $planificacion->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if ($planificacion->updated_at != $planificacion->created_at)
                                                    <i class="feather icon-clock mr-1 text-muted"></i>
                                                    {{ $planificacion->updated_at->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('profesores.planificaciones.descargar', $planificacion->id) }}"
                                                    class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="feather icon-download"></i> Descargar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="feather icon-file-text text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">No hay planificaciones cargadas</h5>
                            <p class="text-muted mb-0">Aún no se han subido planificaciones para esta materia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Estilos adicionales --}}
    <style>
        .download-link {
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 500;
        }

        .download-link:hover {
            text-decoration: underline;
            transform: translateX(2px);
        }

        .table td {
            vertical-align: middle;
        }

        /* Animaciones suaves */
        .btn {
            transition: all 0.2s ease;
        }

        /* Efectos hover mejorados */
        .btn-outline-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Mejoras en la tabla */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Iconos más grandes en estados vacíos */
        .text-center i[style*="font-size: 3rem"] {
            opacity: 0.3;
        }

        /* Badge personalizado */
        .badge-light {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        /* Mejora visual para thead */
        .thead-light th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table {
                font-size: 0.875rem;
            }
        }
    </style>

</x-layouts.departamento.dashboard>
