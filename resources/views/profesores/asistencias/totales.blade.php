<x-layouts.profesores.dashboard asistencias titulo="Asistencias Totales"
    title="Mi Técnica | Panel de Profesores - Asistencias">
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="mb-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div class="mb-3 mb-md-0">
                        <h1 class="h4 mb-1">Porcentajes de Asistencia</h1>
                        <p class="text-muted">
                            {{ $cupofInfo->materia_nombre }} - {{ $cupofInfo->ano }}° {{ $cupofInfo->division }}
                            "{{ $cupofInfo->grupo_nombre }}" ({{ $cupofInfo->turno }})
                        </p>
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <a href="{{ route('profesores.asistencias.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Volver a Materias
                        </a>
                        <a href="{{ route('profesores.asistencias.tomar', $cupofInfo->cupof) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check mr-1"></i>
                            Tomar Asistencias
                        </a>
                    </div>
                </div>
            </div>

            {{-- Estadísticas Generales --}}
            @if (!empty($estadisticas))
                @php
                    $totalAlumnos = count($estadisticas);
                    $promedioAsistencia = 0;
                    if ($totalAlumnos > 0) {
                        $suma = array_sum(array_column($estadisticas, 'porcentaje_presente'));
                        $promedioAsistencia = round($suma / $totalAlumnos, 1);
                    }
                @endphp

                <div class="stats-container">
                    <div class="stats-grid">
                        <div class="stat-card stat-card-primary">
                            <div class="stat-card-body">
                                <div class="stat-content">
                                    <div class="stat-icon stat-icon-primary">
                                        <i class="fas fa-users text-primary"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h6 class="stat-label">Total Estudiantes</h6>
                                        <h2 class="stat-value">{{ $totalAlumnos }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card stat-card-success">
                            <div class="stat-card-body">
                                <div class="stat-content">
                                    <div class="stat-icon stat-icon-success">
                                        <i class="fas fa-percentage text-success"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h6 class="stat-label">Promedio de Asistencia</h6>
                                        <h2 class="stat-value">{{ $promedioAsistencia }}%</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card stat-card-info">
                            <div class="stat-card-body">
                                <div class="stat-content">
                                    <div class="stat-icon stat-icon-info">
                                        <i class="fas fa-calendar-day text-info"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h6 class="stat-label">Días Registrados</h6>
                                        <h2 class="stat-value">{{ $estadisticas[0]['total_dias'] ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabla de Porcentajes --}}
            <div class="card">
                @if (!empty($estadisticas))
                    {{-- Vista de tabla para pantallas medianas y grandes --}}
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-left">Apellido y Nombre</th>
                                        <th scope="col" class="text-center">Total Días</th>
                                        <th scope="col" class="text-center">Presentes</th>
                                        <th scope="col" class="text-center">Ausencias</th>
                                        <th scope="col" class="text-center">Tardanzas</th>
                                        <th scope="col" class="text-center">% Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estadisticas as $stat)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ $stat['alumno']->apellido }}, {{ $stat['alumno']->nombre }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-dark">{{ $stat['total_dias'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    {{ $stat['presentes'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">
                                                    {{ $stat['ausencias'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning">
                                                    {{ $stat['tardanzas'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="flex-grow-1" style="max-width: 80px;">
                                                        @php
                                                            $porcentaje = $stat['porcentaje_presente'];
                                                            $colorClass = 'bg-danger';
                                                            if ($porcentaje >= 85) {
                                                                $colorClass = 'bg-success';
                                                            } elseif ($porcentaje >= 70) {
                                                                $colorClass = 'bg-warning';
                                                            } elseif ($porcentaje >= 50) {
                                                                $colorClass = 'bg-warning';
                                                            }
                                                        @endphp
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar {{ $colorClass }}"
                                                                style="width: {{ $porcentaje }}%"></div>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="ml-2 small font-weight-bold">{{ $porcentaje }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Vista de cards para móviles --}}
                    <div class="totales-mobile-container">
                        @foreach ($estadisticas as $stat)
                            @php
                                $porcentaje = $stat['porcentaje_presente'];
                                $cardClass = 'low-attendance';
                                if ($porcentaje >= 85) {
                                    $cardClass = 'high-attendance';
                                } elseif ($porcentaje >= 70) {
                                    $cardClass = 'medium-attendance';
                                }
                            @endphp

                            <div class="totales-student-card {{ $cardClass }}">
                                {{-- Nombre del estudiante --}}
                                <div class="student-name-mobile">
                                    {{ $stat['alumno']->apellido }}, {{ $stat['alumno']->nombre }}
                                </div>

                                {{-- Porcentaje principal --}}
                                <div class="percentage-container">
                                    <div class="percentage-header">
                                        <span class="percentage-label">Porcentaje de Asistencia</span>
                                        <span class="percentage-value">{{ $porcentaje }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        @php
                                            $progressClass = 'low';
                                            if ($porcentaje >= 85) {
                                                $progressClass = 'high';
                                            } elseif ($porcentaje >= 70) {
                                                $progressClass = 'medium';
                                            }
                                        @endphp
                                        <div class="progress-fill {{ $progressClass }}"
                                            style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>

                                {{-- Estadísticas detalladas --}}
                                <div class="stats-details">
                                    <div class="stat-detail">
                                        <div class="stat-detail-label">Total Días</div>
                                        <div class="stat-detail-value">{{ $stat['total_dias'] }}</div>
                                    </div>
                                    <div class="stat-detail">
                                        <div class="stat-detail-label">Presentes</div>
                                        <div class="stat-detail-value present">{{ $stat['presentes'] }}</div>
                                    </div>
                                    <div class="stat-detail">
                                        <div class="stat-detail-label">Ausencias</div>
                                        <div class="stat-detail-value absent">{{ $stat['ausencias'] }}</div>
                                    </div>
                                    <div class="stat-detail">
                                        <div class="stat-detail-label">Tardanzas</div>
                                        <div class="stat-detail-value late">{{ $stat['tardanzas'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Estado vacío --}}
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="empty-state-title">Sin datos de asistencia</h3>
                        <p class="empty-state-subtitle">
                            No hay registros de asistencia para esta materia aún.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('profesores.asistencias.tomar', $cupofInfo->cupof) }}"
                                class="btn btn-primary">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Comenzar a Tomar Asistencias
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.profesores.dashboard>
