<x-layouts.profesores.dashboard tareas titulo="Tareas" title="Mi Técnica | Panel de Profesores - Tareas">
    <div class="asistencias-container">
        {{-- Header --}}
        <div class="asistencias-header">
            <div class="header-content">
                <h1 class="main-title">Tareas</h1>
                <p class="main-subtitle">Seleccione una materia para gestionar tareas</p>
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
                @foreach ($materias as $cupof)
                    <div class="materia-card">
                        <div class="materia-content">
                            {{-- Cabecera de la materia --}}
                            <div class="materia-header">
                                <div class="materia-info">
                                    <h3 class="materia-title">
                                        {{ $cupof->materia->nombre }}
                                    </h3>
                                    <p class="materia-subtitle">
                                        {{ $cupof->curso->ano }}° {{ $cupof->curso->division }} -
                                        {{ $cupof->grupo->nombre }}
                                    </p>
                                </div>
                            </div>

                            {{-- Información adicional --}}
                            <div class="materia-details">
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Turno:
                                        {{ ucfirst($cupof->turno === 'M' ? 'Mañana' : ($cupof->turno === 'T' ? 'Tarde' : 'Noche')) }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users"></i>
                                    <span>Curso: {{ $cupof->curso->ano }}° Año División
                                        {{ $cupof->curso->division }}</span>
                                </div>
                            </div>

                            {{-- Botones de acción --}}
                            <div class="materia-actions">
                                <a href="{{ route('profesores.tareas.cargar', $cupof->cupof) }}"
                                    class="btn-primary-custom">
                                    <i class="fas fa-tasks"></i>
                                    Gestionar Tareas
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
                    <i class="fas fa-tasks"></i>
                </div>
                <h3 class="empty-title">No hay materias asignadas</h3>
                <p class="empty-subtitle">
                    No tiene materias asignadas en este momento para gestionar tareas.
                </p>
            </div>
        @endif
    </div>
</x-layouts.profesores.dashboard>
