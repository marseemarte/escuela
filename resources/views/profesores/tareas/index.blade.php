{{-- Vista principal de tareas - Lista de materias --}}
<x-layouts.profesores.dashboard titulo="Tareas">
    <div class="tareas-container">
        {{-- Header --}}
        <div class="tareas-header">
            <div>
                <h1 class="tareas-title">Tareas</h1>
                <p class="tareas-subtitle">Seleccione una materia para gestionar tareas</p>
            </div>
            <div class="tareas-info">
                <div class="tareas-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Lista de materias --}}
        @if ($materias && count($materias) > 0)
            <div class="tareas-grid">
                @foreach ($materias as $materia)
                    <div class="tareas-card">
                        <div class="tareas-card-content">
                            {{-- Cabecera de la materia --}}
                            <div class="tareas-card-header">
                                <div class="tareas-card-title-section">
                                    <h3 class="tareas-card-title">
                                        {{ $materia->materia_nombre }}
                                    </h3>
                                    <p class="tareas-card-course">
                                        {{ $materia->ano }}° {{ $materia->division }} - {{ $materia->grupo_nombre }}
                                    </p>
                                </div>
                            </div>

                            {{-- Información adicional --}}
                            <div class="tareas-card-info">
                                <div class="tareas-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Turno:
                                        {{ ucfirst($materia->turno === 'M' ? 'Mañana' : ($materia->turno === 'T' ? 'Tarde' : 'Noche')) }}</span>
                                </div>
                                <div class="tareas-info-item">
                                    <i class="fas fa-users"></i>
                                    <span>Curso: {{ $materia->ano }}° Año División {{ $materia->division }}</span>
                                </div>
                            </div>

                            {{-- Botón de acción --}}
                            <div class="tareas-card-action">
                                <a href="{{ route('profesores.tareas.cargar', $materia->cupof) }}"
                                    class="tareas-btn-primary">
                                    <i class="fas fa-tasks mr-2"></i>
                                    Gestionar Tareas
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Estado vacío --}}
            <div class="tareas-empty-state">
                <div class="tareas-empty-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3 class="tareas-empty-title">No hay materias asignadas</h3>
                <p class="tareas-empty-text">
                    No tiene materias asignadas en este momento para gestionar tareas.
                </p>
            </div>
        @endif
    </div>

    <style>
        .tareas-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .tareas-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .tareas-header {
                flex-direction: row;
                align-items: center;
                gap: 0;
            }
        }

        .tareas-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        @media (min-width: 640px) {
            .tareas-title {
                font-size: 1.5rem;
            }
        }

        .tareas-subtitle {
            color: #4b5563;
            margin: 0.25rem 0 0 0;
            font-size: 0.875rem;
        }

        @media (min-width: 640px) {
            .tareas-subtitle {
                font-size: 1rem;
            }
        }

        .tareas-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .tareas-info {
                flex-direction: row;
                align-items: center;
                gap: 1rem;
            }
        }

        .tareas-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: #6b7280;
        }

        @media (min-width: 640px) {
            .tareas-date {
                font-size: 0.875rem;
            }
        }

        .tareas-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .tareas-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .tareas-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .tareas-card {
            background: linear-gradient(to bottom right, #eff6ff, #e0e7ff);
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .tareas-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .tareas-card-content {
            padding: 1rem;
        }

        @media (min-width: 640px) {
            .tareas-card-content {
                padding: 1.5rem;
            }
        }

        .tareas-card-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .tareas-card-header {
                flex-direction: row;
                align-items: flex-start;
                margin-bottom: 1rem;
                gap: 0;
            }
        }

        .tareas-card-title-section {
            flex: 1;
        }

        .tareas-card-title {
            font-weight: 600;
            font-size: 1rem;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }

        @media (min-width: 640px) {
            .tareas-card-title {
                font-size: 1.125rem;
            }
        }

        .tareas-card-course {
            font-size: 0.75rem;
            color: #4b5563;
            margin: 0;
        }

        @media (min-width: 640px) {
            .tareas-card-course {
                font-size: 0.875rem;
            }
        }

        .tareas-card-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-bottom: 0.75rem;
        }

        @media (min-width: 640px) {
            .tareas-card-info {
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
        }

        .tareas-info-item {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: #4b5563;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .tareas-info-item {
                font-size: 0.875rem;
            }
        }

        .tareas-info-item i {
            width: 0.75rem;
            height: 0.75rem;
        }

        @media (min-width: 640px) {
            .tareas-info-item i {
                width: 1rem;
                height: 1rem;
            }
        }

        .tareas-card-action {
            padding-top: 0.75rem;
            border-top: 1px solid #e5e7eb;
        }

        @media (min-width: 640px) {
            .tareas-card-action {
                padding-top: 1rem;
            }
        }

        .tareas-btn-primary {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            border: 1px solid transparent;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            color: white;
            background-color: #2563eb;
            text-decoration: none;
            transition: background-color 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .tareas-btn-primary:hover {
            background-color: #1d4ed8;
            color: white;
            text-decoration: none;
        }

        .tareas-btn-primary:focus {
            outline: 2px solid transparent;
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .tareas-empty-state {
            text-align: center;
            padding: 3rem 0;
        }

        .tareas-empty-icon {
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 4rem;
            width: 4rem;
            border-radius: 50%;
            background-color: #f3f4f6;
        }

        .tareas-empty-icon i {
            color: #9ca3af;
            font-size: 1.25rem;
        }

        .tareas-empty-title {
            margin-top: 1rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: #111827;
        }

        .tareas-empty-text {
            margin-top: 0.5rem;
            color: #6b7280;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }
    </style>
</x-layouts.profesores.dashboard>
