{{-- filepath: c:\xampp\htdocs\Laravel\escuela\resources\views\profesores\proyectos\index.blade.php --}}
<x-layouts.departamento.dashboard proyectos titulo="Proyectos"
    title="Mi Técnica | Panel de Jefes de Departamento - Proyectos">

    <div class="asistencias-container">
        {{-- Header --}}
        <div class="asistencias-header">
            <div class="header-content">
                <h1 class="main-title">Proyectos</h1>
                <p class="main-subtitle">Seleccione una materia para gestionar sus proyectos</p>
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
                                        {{ $materia['materia'] }}
                                    </h3>
                                    <p class="materia-subtitle">
                                        {{ $materia['curso'] }} - {{ $materia['grupo'] }}
                                    </p>
                                </div>
                                {{-- Badge con cantidad de proyectos --}}
                                @if ($materia['tiene_proyectos'])
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $materia['total_proyectos'] }}
                                        {{ $materia['total_proyectos'] == 1 ? 'proyecto' : 'proyectos' }}
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Sin proyectos
                                    </span>
                                @endif
                            </div>

                            {{-- Información adicional --}}
                            <div class="materia-details">
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Turno:
                                        {{ ucfirst($materia['turno'] === 'M' ? 'Mañana' : ($materia['turno'] === 'T' ? 'Tarde' : 'Noche')) }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-folder"></i>
                                    <span>
                                        @if ($materia['tiene_proyectos'])
                                            {{ $materia['total_proyectos'] }}
                                            {{ $materia['total_proyectos'] == 1 ? 'proyecto cargado' : 'proyectos cargados' }}
                                        @else
                                            Sin proyectos cargados
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Botones de acción --}}
                            <div class="materia-actions">
                                <a href="{{ route('profesores.proyectos.cargar', $materia['cupof']) }}"
                                    class="btn-primary-custom">
                                    <i class="fas fa-folder-open"></i>
                                    {{ $materia['tiene_proyectos'] ? 'Ver/Gestionar Proyectos' : 'Subir Proyecto' }}
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
                    <i class="fas fa-project-diagram"></i>
                </div>
                <h3 class="empty-title">No hay materias asignadas</h3>
                <p class="empty-subtitle">
                    No tiene materias asignadas en este momento para cargar proyectos.
                </p>
            </div>
        @endif
    </div>
</x-layouts.departamento.dashboard>
