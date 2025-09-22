<x-layouts.profesores.dashboard titulo="Corregir Tarea">
    <!-- Botón volver -->
    <a href="javascript:history.back()" class="corregir-btn-volver">
        ← Volver
    </a>
    <!-- Título y descripción -->
    <h1 class="corregir-main-title">Corrección de: {{ $tarea->titulo }}</h1>
    <p class="corregir-info-text">
        <strong>Materia:</strong> {{ $materia }} |
        <strong>Curso:</strong> {{ $curso }} |
        <strong>Fecha de entrega:</strong> {{ $tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : '-' }}
    </p>
    <p class="corregir-description">Aquí podrás revisar y corregir las respuestas de los alumnos.</p>

    @if (session('success'))
        <div id="alert-success" class="corregir-alert corregir-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="corregir-alert corregir-alert-error">
            {{ session('error') }}
        </div>
    @endif


    <!-- Estadísticas rápidas -->
    @if ($entregas->count() > 0)
        <div class="corregir-stats-grid">
            <div class="corregir-stat-card corregir-stat-blue">
                <h3 class="corregir-stat-title corregir-stat-title-blue">Total Alumnos</h3>
                <p class="corregir-stat-number corregir-stat-number-blue">{{ $entregas->count() }}</p>
            </div>
            <div class="corregir-stat-card corregir-stat-green">
                <h3 class="corregir-stat-title corregir-stat-title-green">Entregaron</h3>
                <p class="corregir-stat-number corregir-stat-number-green">
                    {{ $entregas->where('entrego', true)->count() }}</p>
            </div>
            <div class="corregir-stat-card corregir-stat-red">
                <h3 class="corregir-stat-title corregir-stat-title-red">No entregaron</h3>
                <p class="corregir-stat-number corregir-stat-number-red">
                    {{ $entregas->where('entrego', false)->count() }}</p>
            </div>
        </div>
    @endif

    <!-- Tabla de alumnos -->
    <div class="corregir-table-container">
        <table class="corregir-table">
            <thead class="corregir-table-header">
                <tr>
                    <th class="corregir-table-th corregir-table-th-alumno">Alumno</th>
                    <th class="corregir-table-th corregir-table-th-estado">Estado</th>
                    <th class="corregir-table-th corregir-table-th-respuesta">Respuesta</th>
                    <th class="corregir-table-th corregir-table-th-nota">Nota</th>
                    <th class="corregir-table-th corregir-table-th-devolucion">Devolución</th>
                    <th class="corregir-table-th corregir-table-th-acciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entregas as $entrega)
                    <tr class="corregir-table-row {{ !$entrega['entrego'] ? 'corregir-table-row-error' : '' }}">
                        <td class="corregir-table-td corregir-table-td-nombre">
                            {{ $entrega['nombre_completo'] }}
                            <br>
                            <small class="corregir-table-small">DNI: {{ $entrega['dni'] }}</small>
                        </td>

                        <td class="corregir-table-td">
                            @if ($entrega['entrego'])
                                <span class="corregir-badge corregir-badge-success">
                                    Entregado
                                </span>
                                @if ($entrega['fecha_entrega'])
                                    <br>
                                    <small class="corregir-table-small">
                                        {{ date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) }}
                                    </small>
                                @endif
                            @else
                                <span class="corregir-badge corregir-badge-danger">
                                    No entregó
                                </span>
                            @endif
                        </td>

                        <td class="corregir-table-td">
                            @if ($entrega['entrego'])
                                <a href="#" class="corregir-link"
                                    onclick="descargarRespuesta({{ $entrega['tarea_alumno_id'] }})">
                                    {{ $entrega['archivo'] }}
                                </a>
                            @else
                                <span class="corregir-text-muted">Sin entrega</span>
                            @endif
                        </td>

                        <td class="corregir-table-td">
                            @if ($entrega['entrego'])
                                <input type="number" min="1" max="10" step="0.01"
                                    value="{{ $entrega['nota'] ?? '' }}" class="nota corregir-input-nota"
                                    data-asignacion="{{ $entrega['asignacion_id'] }}" placeholder="ej: 7.25">
                            @else
                                <span class="corregir-text-muted">-</span>
                            @endif
                        </td>

                        <td class="corregir-table-td">
                            @if ($entrega['entrego'])
                                <div class="corregir-devolucion-container">
                                    <textarea rows="2" maxlength="200" class="devolucion corregir-textarea" placeholder="Máximo 200 caracteres..."
                                        data-asignacion="{{ $entrega['asignacion_id'] }}" oninput="actualizarContador(this)">{{ $entrega['devolucion'] ?? '' }}</textarea>
                                    <small class="contador corregir-text-counter">
                                        {{ strlen($entrega['devolucion'] ?? '') }}/200
                                    </small>
                                </div>
                            @else
                                <span class="corregir-text-muted">-</span>
                            @endif
                        </td>

                        <td class="corregir-table-td">
                            @if ($entrega['entrego'])
                                <!-- Botón Guardar (se muestra cuando NO tiene corrección) -->
                                <button
                                    class="guardar-btn corregir-btn-guardar {{ (bool) $entrega['tiene_nota'] ? 'hidden' : '' }}"
                                    data-asignacion="{{ $entrega['asignacion_id'] }}"
                                    onclick="guardarCorreccion(this)">
                                    Guardar
                                </button>

                                <!-- Botón Eliminar (se muestra cuando YA tiene corrección) -->
                                <button
                                    class="eliminar-btn corregir-btn-eliminar {{ (bool) $entrega['tiene_nota'] ? '' : 'hidden' }}"
                                    data-asignacion="{{ $entrega['asignacion_id'] }}"
                                    onclick="eliminarCorreccion(this)">
                                    Eliminar
                                </button>
                            @else
                                <span class="corregir-text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="corregir-table-empty">
                            <div class="corregir-empty-state">
                                <svg class="corregir-empty-icon" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="corregir-empty-title">No hay alumnos en este curso</h3>
                                <p class="corregir-empty-description">No se encontraron alumnos asignados a este curso
                                    para el ciclo lectivo actual.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal para confirmar eliminación de corrección -->
    <div id="eliminarCorreccionModal" class="corregir-modal">
        <div class="corregir-modal-content corregir-modal-content-small">
            <button id="closeEliminarCorreccionModal" class="corregir-modal-close">✕</button>
            <h2 class="corregir-modal-title">Confirmar eliminación</h2>
            <p class="corregir-modal-text">¿Estás seguro de que quieres eliminar esta corrección? Esta acción no se
                puede deshacer.</p>
            <div class="corregir-modal-actions">
                <button id="cancelEliminarCorreccion" class="corregir-btn-cancel">Cancelar</button>
                <button id="confirmarEliminarCorreccion" class="corregir-btn-danger">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Mostrar mensaje si no hay entregas -->
    @if ($entregas->count() > 0 && $entregas->where('entrego', true)->count() == 0)
        <div class="corregir-warning-box">
            <div class="corregir-warning-content">
                <div class="corregir-warning-icon">
                    <svg class="corregir-warning-svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="corregir-warning-text">
                    <p class="corregir-warning-message">
                        <strong>Sin respuestas:</strong> Ningún alumno ha entregado respuesta para esta tarea aún.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Base styles */
        .corregir-btn-volver {
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #4b5563;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .corregir-btn-volver:hover {
            background-color: #374151;
            color: white;
            text-decoration: none;
        }

        .corregir-main-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        .corregir-info-text {
            margin-bottom: 1rem;
            color: #4b5563;
        }

        .corregir-description {
            margin-bottom: 1.5rem;
            color: #4b5563;
        }

        /* Alerts */
        .corregir-alert {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 6px;
            transition: opacity 0.5s;
        }

        .corregir-alert-success {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .corregir-alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        /* Statistics grid */
        .corregir-stats-grid {
            margin-bottom: 1.5rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .corregir-stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .corregir-stat-card {
            padding: 1rem;
            border-radius: 8px;
        }

        .corregir-stat-blue {
            background-color: #dbeafe;
        }

        .corregir-stat-green {
            background-color: #dcfce7;
        }

        .corregir-stat-red {
            background-color: #fef2f2;
        }

        .corregir-stat-title {
            font-weight: 600;
        }

        .corregir-stat-title-blue {
            color: #1e40af;
        }

        .corregir-stat-title-green {
            color: #166534;
        }

        .corregir-stat-title-red {
            color: #dc2626;
        }

        .corregir-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .corregir-stat-number-blue {
            color: #1e3a8a;
        }

        .corregir-stat-number-green {
            color: #14532d;
        }

        .corregir-stat-number-red {
            color: #b91c1c;
        }

        /* Table styles */
        .corregir-table-container {
            overflow-x: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .corregir-table {
            width: 100%;
            font-size: 0.875rem;
            text-align: center;
            color: #4b5563;
            table-layout: fixed;
        }

        .corregir-table-header {
            background-color: #f9fafb;
            color: #374151;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .corregir-table-th {
            padding: 0.75rem 1.5rem;
        }

        .corregir-table-th-alumno {
            width: 16.666667%;
        }

        .corregir-table-th-estado {
            width: 16.666667%;
        }

        .corregir-table-th-respuesta {
            width: 33.333333%;
        }

        .corregir-table-th-nota {
            width: 16.666667%;
        }

        .corregir-table-th-devolucion {
            width: 33.333333%;
        }

        .corregir-table-th-acciones {
            width: 16.666667%;
        }

        .corregir-table-row {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .corregir-table-row:hover {
            background-color: #f9fafb;
        }

        .corregir-table-row-error {
            background-color: #fef2f2;
        }

        .corregir-table-td {
            padding: 1rem 1.5rem;
        }

        .corregir-table-td-nombre {
            font-weight: 500;
            color: #111827;
        }

        .corregir-table-small {
            color: #6b7280;
        }

        .corregir-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .corregir-badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .corregir-badge-danger {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .corregir-link {
            color: #2563eb;
            text-decoration: none;
            cursor: pointer;
        }

        .corregir-link:hover {
            text-decoration: underline;
            color: #1d4ed8;
        }

        .corregir-text-muted {
            color: #9ca3af;
            font-style: italic;
        }

        .corregir-input-nota {
            width: 5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.5rem;
            text-align: center;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .corregir-input-nota:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .corregir-devolucion-container {
            display: flex;
            flex-direction: column;
        }

        .corregir-textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.5rem;
            resize: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .corregir-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .corregir-text-counter {
            color: #6b7280;
            text-align: right;
        }

        /* Buttons */
        .corregir-btn-guardar {
            padding: 0.25rem 0.75rem;
            background-color: #059669;
            color: white;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, opacity 0.2s;
        }

        .corregir-btn-guardar:hover {
            background-color: #047857;
        }

        .corregir-btn-guardar:disabled {
            opacity: 0.5;
        }

        .corregir-btn-eliminar {
            padding: 0.25rem 0.75rem;
            background-color: #dc2626;
            color: white;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, opacity 0.2s;
        }

        .corregir-btn-eliminar:hover {
            background-color: #b91c1c;
        }

        .corregir-btn-eliminar:disabled {
            opacity: 0.5;
        }

        /* Empty state */
        .corregir-table-empty {
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .corregir-empty-state {
            color: #6b7280;
        }

        .corregir-empty-icon {
            margin: 0 auto;
            height: 3rem;
            width: 3rem;
            color: #9ca3af;
        }

        .corregir-empty-title {
            margin-top: 0.5rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: #111827;
        }

        .corregir-empty-description {
            margin-top: 0.25rem;
            color: #6b7280;
        }

        /* Modal styles */
        .corregir-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            backdrop-filter: blur(4px);
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            overflow: auto;
        }

        .corregir-modal-content {
            background: white;
            border-radius: 8px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem;
            padding: 1.5rem;
            position: relative;
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s;
        }

        .corregir-modal-content-small {
            max-width: 24rem;
        }

        .corregir-modal-close {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            color: #6b7280;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.25rem;
        }

        .corregir-modal-close:hover {
            color: #374151;
        }

        .corregir-modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #111827;
        }

        .corregir-modal-text {
            margin-bottom: 1.5rem;
            color: #374151;
        }

        .corregir-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .corregir-btn-cancel {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background-color: #d1d5db;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s;
        }

        .corregir-btn-cancel:hover {
            background-color: #9ca3af;
        }

        .corregir-btn-danger {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background-color: #dc2626;
            color: white;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s;
        }

        .corregir-btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Warning box */
        .corregir-warning-box {
            margin-top: 1.5rem;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
        }

        .corregir-warning-content {
            display: flex;
        }

        .corregir-warning-icon {
            flex-shrink: 0;
        }

        .corregir-warning-svg {
            height: 1.25rem;
            width: 1.25rem;
            color: #f59e0b;
        }

        .corregir-warning-text {
            margin-left: 0.75rem;
        }

        .corregir-warning-message {
            font-size: 0.875rem;
            color: #92400e;
        }

        /* Utility classes */
        .hidden {
            display: none;
        }

        /* Hacer los cuadros de estadísticas más pequeños */
.corregir-stats-grid {
    margin-bottom: 1.5rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.5rem; /* Reducido de 1rem */
    max-width: 600px; /* Ancho máximo */
    margin-left: auto;
    margin-right: auto;
}

@media (min-width: 768px) {
    .corregir-stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.corregir-stat-card {
    padding: 1rem; /* Volver al original */
    border-radius: 8px; /* Volver al original */
    text-align: center;
}

.corregir-stat-title {
    font-weight: 600;
    font-size: 0.875rem; /* Un poco más grande que 0.75rem */
    margin-bottom: 0.25rem;
}

.corregir-stat-number {
    font-size: 1.5rem; /* Volver al tamaño original */
    font-weight: 700;
    margin: 0;
}

/* Centrar las tablas */
.corregir-table-container {
    overflow-x: auto;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin: 0 auto; /* Centrar */
}

.corregir-table {
    width: 100%;
    font-size: 0.875rem;
    text-align: center !important;
    color: #4b5563;
    table-layout: fixed;
}

.corregir-table-th,
.corregir-table-td {
    text-align: center !important;
}

.corregir-table-td-nombre {
    font-weight: 500;
    color: #111827;
    text-align: center !important;
}

/* Modal de eliminación - falta el flex */
.corregir-modal.flex {
    display: flex !important;
}

.corregir-modal-content.scale-100 {
    transform: scale(1) !important;
}

.corregir-modal-content.opacity-100 {
    opacity: 1 !important;
}

.corregir-modal-content.scale-95 {
    transform: scale(0.95) !important;
}

.corregir-modal-content.opacity-0 {
    opacity: 0 !important;
}
    </style>

    <script>
        // Función para actualizar contador de caracteres
        function actualizarContador(textarea) {
            const contador = textarea.parentElement.querySelector('.contador');
            contador.textContent = textarea.value.length + '/200';
        }

        // Validación de notas (permitir hasta 2 decimales)
        document.addEventListener("DOMContentLoaded", function() {
            const notas = document.querySelectorAll(".nota");

            notas.forEach(input => {
                input.addEventListener("input", function() {
                    if (this.value !== "") {
                        let valor = parseFloat(this.value);
                        if (valor < 1) this.value = 1;
                        if (valor > 10) this.value = 10;

                        // Limitar a 2 decimales
                        if (this.value.includes('.')) {
                            let parts = this.value.split('.');
                            if (parts[1] && parts[1].length > 2) {
                                this.value = parts[0] + '.' + parts[1].substring(0, 2);
                            }
                        }
                    }
                });
            });
        });

        // Función para alternar botones
        function alternarBotones(asignacionId, mostrarEliminar = true) {
            const guardarBtn = document.querySelector(`.guardar-btn[data-asignacion="${asignacionId}"]`);
            const eliminarBtn = document.querySelector(`.eliminar-btn[data-asignacion="${asignacionId}"]`);

            if (mostrarEliminar) {
                guardarBtn.classList.add('hidden');
                eliminarBtn.classList.remove('hidden');
            } else {
                guardarBtn.classList.remove('hidden');
                eliminarBtn.classList.add('hidden');
            }
        }

        // Función para limpiar inputs
        function limpiarInputs(asignacionId) {
            const nota = document.querySelector(`.nota[data-asignacion="${asignacionId}"]`);
            const devolucion = document.querySelector(`.devolucion[data-asignacion="${asignacionId}"]`);
            const contador = devolucion.parentElement.querySelector('.contador');

            nota.value = '';
            devolucion.value = '';
            contador.textContent = '0/200';
        }

        // Función para guardar corrección
        async function guardarCorreccion(button) {
            const asignacionId = button.getAttribute('data-asignacion');
            const nota = document.querySelector(`.nota[data-asignacion="${asignacionId}"]`).value;
            const devolucion = document.querySelector(`.devolucion[data-asignacion="${asignacionId}"]`).value;

            // Validaciones
            if (!nota || parseFloat(nota) < 1 || parseFloat(nota) > 10) {
                alert('Por favor ingresa una nota válida (entre 1 y 10)');
                return;
            }

            // Deshabilitar botón
            button.disabled = true;
            button.textContent = 'Guardando...';

            try {
                const response = await fetch('{{ route('profesores.tareas.guardar-correccion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        asignacion_id: asignacionId,
                        tarea_id: {{ $tarea->id }},
                        nota: parseFloat(nota),
                        devolucion: devolucion
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Mostrar mensaje de éxito
                    mostrarMensaje('success', data.message);

                    // Cambiar a botón eliminar
                    alternarBotones(asignacionId, true);
                } else {
                    mostrarMensaje('error', data.message || 'Error al guardar la corrección');
                }

            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('error', 'Error de conexión. Inténtalo nuevamente.');
            } finally {
                // Restaurar botón
                button.disabled = false;
                button.textContent = 'Guardar';
            }
        }

        // Eliminar corrección con modal
        async function eliminarCorreccion(button) {
            const asignacionId = button.getAttribute('data-asignacion');

            // Mostrar modal de confirmación
            const modal = document.getElementById('eliminarCorreccionModal');
            const modalContent = modal.querySelector('.corregir-modal-content'); // Cambiar aquí

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 20);

            // Configurar el botón de confirmación para esta corrección específica
            const confirmarBtn = document.getElementById('confirmarEliminarCorreccion');
            confirmarBtn.onclick = () => ejecutarEliminacion(asignacionId, modal, modalContent);
        }

        // Función para ejecutar la eliminación
        async function ejecutarEliminacion(asignacionId, modal, modalContent) {
            const confirmarBtn = document.getElementById('confirmarEliminarCorreccion');

            // Deshabilitar botón
            confirmarBtn.disabled = true;
            confirmarBtn.textContent = 'Eliminando...';

            try {
                const response = await fetch('{{ route('profesores.tareas.eliminar-correccion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        asignacion_id: asignacionId,
                        tarea_id: {{ $tarea->id }}
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Cerrar modal
                    cerrarModalEliminarCorreccion(modal, modalContent);

                    // Mostrar mensaje de éxito
                    mostrarMensaje('success', data.message);

                    // Limpiar inputs
                    limpiarInputs(asignacionId);

                    // Cambiar a botón guardar
                    alternarBotones(asignacionId, false);
                } else {
                    mostrarMensaje('error', data.message || 'Error al eliminar la corrección');
                    cerrarModalEliminarCorreccion(modal, modalContent);
                }

                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensaje('error', 'Error de conexión. Inténtalo nuevamente.');
                    cerrarModalEliminarCorreccion(modal, modalContent);
                } finally {
                    // Restaurar botón
                    confirmarBtn.disabled = false;
                    confirmarBtn.textContent = 'Eliminar';
                }
            }

        // Función para cerrar el modal de eliminación
        function cerrarModalEliminarCorreccion(modal, modalContent) {
            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Configurar eventos del modal al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('eliminarCorreccionModal');
            const modalContent = modal.querySelector('.corregir-modal-content'); // Cambiar aquí también
            const closeBtn = document.getElementById('closeEliminarCorreccionModal');
            const cancelBtn = document.getElementById('cancelEliminarCorreccion');

            // Eventos para cerrar modal
            closeBtn.addEventListener('click', () => cerrarModalEliminarCorreccion(modal, modalContent));
            cancelBtn.addEventListener('click', () => cerrarModalEliminarCorreccion(modal, modalContent));

            // Cerrar modal al hacer clic fuera de él
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    cerrarModalEliminarCorreccion(modal, modalContent);
                }
            });
        });

function mostrarMensaje(tipo, mensaje) {
    // Crear el contenedor
    const alert = document.createElement('div');
    alert.className = `corregir-alert ${tipo === 'success' ? 'corregir-alert-success' : 'corregir-alert-error'}`;
    alert.textContent = mensaje;

    // Insertar debajo del título principal
    const container = document.querySelector('.corregir-main-title');
    container.insertAdjacentElement('afterend', alert);

    // Auto eliminar después de 3s
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }, 3000);
}


        // Función para descargar respuesta del alumno (sin cambios)
        function descargarRespuesta(tareaAlumnoId) {
            if (tareaAlumnoId) {
                window.location.href = `{{ url('/profesores/tareas/alumno') }}/${tareaAlumnoId}/descargar`;
            } else {
                alert('Error: No se puede descargar el archivo');
            }
        }


    </script>

</x-layouts.profesores.dashboard>
