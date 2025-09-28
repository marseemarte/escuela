<x-layouts.profesores.dashboard inicio titulo="Inicio" title="Mi Técnica | Panel de Profesores - Inicio">
    <div class="asistencias-container">
        <!-- Header de bienvenida -->
        <div class="asistencias-header">
            <div class="header-content">
                <h1 class="main-title">¡Bienvenido/a {{ Auth::check() ? Auth::user()->nombre_completo : 'Profesor' }}!
                </h1>
                <p class="main-subtitle">Aquí puedes gestionar tus clases, tareas y más.</p>
            </div>
            <div class="header-info">
                <div class="date-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="quick-actions-section">
            <h2 class="section-title">Accesos Rápidos</h2>
            <div class="quick-actions-grid">
                <a href="/profesores/informes" class="quick-action-card">
                    <div class="action-icon action-primary">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="action-title">Cargar Informes</h3>
                    <p class="action-description">Registra los informes de tus estudiantes</p>
                </a>

                <a href="/profesores/asistencias" class="quick-action-card">
                    <div class="action-icon action-success">
                        <i class="fas fa-check-square"></i>
                    </div>
                    <h3 class="action-title">Tomar Asistencia</h3>
                    <p class="action-description">Registra la asistencia de la clase de hoy</p>
                </a>

                <a href="/profesores/tareas" class="quick-action-card">
                    <div class="action-icon action-warning">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="action-title">Gestionar Tareas</h3>
                    <p class="action-description">Sube nuevas tareas y revisa entregas</p>
                </a>

                <a href="/profesores/horarios" class="quick-action-card">
                    <div class="action-icon action-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="action-title">Ver Horarios</h3>
                    <p class="action-description">Consulta información de tus horarios</p>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-primary .stat-icon {
            background: #3b82f6;
        }

        .stat-success .stat-icon {
            background: #10b981;
        }

        .stat-warning .stat-icon {
            background: #f59e0b;
        }

        .stat-info .stat-icon {
            background: #06b6d4;
        }

        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: #1f2937;
        }

        .stat-content p {
            margin: 0;
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Sections */
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 1.5rem;
            background: #3b82f6;
            border-radius: 2px;
        }

        /* Quick Actions */
        .quick-actions-section {
            margin-bottom: 2rem;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .quick-action-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }

        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            margin-bottom: 1rem;
        }

        .action-primary {
            background: #3b82f6;
        }

        .action-success {
            background: #10b981;
        }

        .action-warning {
            background: #f59e0b;
        }

        .action-info {
            background: #06b6d4;
        }

        .action-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .action-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        /* Activity */
        .recent-activity-section {
            margin-bottom: 2rem;
        }

        .activity-list {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .activity-success {
            background: #10b981;
        }

        .activity-primary {
            background: #3b82f6;
        }

        .activity-warning {
            background: #f59e0b;
        }

        .activity-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
        }

        .activity-description {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0 0 0.25rem 0;
        }

        .activity-time {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Reminders */
        .reminders-section {
            margin-bottom: 2rem;
        }

        .reminders-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .reminder-item {
            background: white;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid #e5e7eb;
        }

        .reminder-urgent {
            border-left-color: #ef4444;
            background: #fef2f2;
        }

        .reminder-normal {
            border-left-color: #3b82f6;
        }

        .reminder-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .reminder-urgent .reminder-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .reminder-normal .reminder-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .reminder-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
        }

        .reminder-description {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-layouts.profesores.dashboard>
