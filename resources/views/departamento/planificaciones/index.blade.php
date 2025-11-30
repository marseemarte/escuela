<x-layouts.departamento.dashboard planificaciones titulo="Planificaciones"
    title="Mi Técnica | Panel de Jefes de Departamento - Planificaciones">


    <div class="asistencias-container">
        {{-- Header --}}
        <div class="asistencias-header">
            <div class="header-content">
                <h1 class="main-title">Planificaciones del Departamento</h1>
                <p class="main-subtitle">Revise las planificaciones de las materias de su departamento</p>
            </div>
            <div class="header-info">
                <div class="date-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Lista de materias --}}
        @if ($materias && count($materias) > 0)
            <div class="materias-grid">
                @foreach ($materias as $materia)
                    <div class="materia-card">
                        <div class="materia-content">
                            {{-- Cabecera de la materia --}}
                            <div class="materia-header">
                                <div class="materia-info">
                                    <h3 class="materia-title">
                                        {{ $materia->nombre }}
                                    </h3>
                                    <p class="materia-subtitle">
                                        @if ($materia->orientacion)
                                            {{ $materia->orientacion->nombre }}
                                        @endif
                                    </p>
                                </div>
                                {{-- Badge con cantidad de planificaciones --}}
                                @php
                                    $totalPlanificaciones = $materia->planificaciones->count();
                                @endphp
                                @if ($totalPlanificaciones > 0)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $totalPlanificaciones }}
                                        {{ $totalPlanificaciones == 1 ? 'planificación' : 'planificaciones' }}
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Sin planificaciones
                                    </span>
                                @endif
                            </div>

                            {{-- Información adicional --}}
                            <div class="materia-details">
                                <div class="detail-item">
                                    <i class="fas fa-book"></i>
                                    <span>{{ $materia->anio }}° Año - {{ $materia->tipo }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-folder"></i>
                                    <span>
                                        @if ($totalPlanificaciones > 0)
                                            {{ $totalPlanificaciones }}
                                            {{ $totalPlanificaciones == 1 ? 'planificación cargada' : 'planificaciones cargadas' }}
                                        @else
                                            Sin planificaciones cargadas
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Botones de acción --}}
                            <div class="materia-actions">
                                <a href="{{ route('departamento.planificaciones.show', $materia->id) }}"
                                    class="btn-primary-custom">
                                    <i class="fas fa-eye"></i>
                                    {{ $totalPlanificaciones > 0 ? 'Ver Planificaciones' : 'No hay planificaciones' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Estado vacío --}}
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-title">No hay materias asignadas</h3>
                <p class="empty-subtitle">
                    No tiene materias asignadas en este momento para cargar Planificaciones.
                </p>
            </div>
        @endif
    </div>
</x-layouts.departamento.dashboard>
