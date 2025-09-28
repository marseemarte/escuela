{{-- Vista para tomar asistencias de una materia específica --}}
{{-- Vista para tomar asistencias de una materia específica --}}
<x-layouts.profesores.dashboard asistencias titulo="Tomar Asistencias">

    <div class="row">
        <div class="col-12">
            {{-- Header con información de la materia --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            {{-- Botón de regreso --}}
                            <a href="{{ route('profesores.asistencias.index') }}"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            {{-- Información de la materia --}}
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">{{ $cupofInfo->materia_nombre }}</h1>
                                <p class="text-muted mb-0">
                                    {{ $cupofInfo->ano }}° {{ $cupofInfo->division }} - {{ $cupofInfo->grupo_nombre }}
                                    (Turno
                                    {{ ucfirst($cupofInfo->turno === 'M' ? 'Mañana' : ($cupofInfo->turno === 'T' ? 'Tarde' : 'Noche')) }})
                                </p>
                            </div>
                        </div>

                        {{-- Información adicional --}}
                        <div class="text-center text-md-right">
                            <small class="text-muted">
                                {{ now()->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de estudiantes --}}
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-1">Lista de Estudiantes</h2>
                    <p class="text-muted mb-0">Marque la asistencia para cada estudiante</p>
                </div>

                @if ($alumnos && count($alumnos) > 0)
                    {{-- Vista de tabla para pantallas medianas y grandes --}}
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-left">Apellido y Nombre</th>
                                        <th scope="col" class="text-center">Asistencia</th>
                                        <th scope="col" class="text-center">Justificado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alumnos as $index => $alumno)
                                        <tr data-asignacion="{{ $alumno->asignacion_id }}">
                                            <td class="text-center font-weight-bold">
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                            </td>
                                            <td class="text-center">
                                                <div class="asistencia-radio-group">
                                                    {{-- Presente --}}
                                                    <div class="form-check">
                                                        <input type="radio"
                                                            name="asistencia_{{ $alumno->asignacion_id }}"
                                                            value="P" id="presente_{{ $alumno->asignacion_id }}"
                                                            class="form-check-input"
                                                            {{ $alumno->estado_asistencia === 'P' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-success font-weight-bold"
                                                            for="presente_{{ $alumno->asignacion_id }}">
                                                            <i class="fas fa-check"></i> P
                                                        </label>
                                                    </div>

                                                    {{-- Ausente --}}
                                                    <div class="form-check">
                                                        <input type="radio"
                                                            name="asistencia_{{ $alumno->asignacion_id }}"
                                                            value="A" id="ausente_{{ $alumno->asignacion_id }}"
                                                            class="form-check-input"
                                                            {{ $alumno->estado_asistencia === 'A' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-danger font-weight-bold"
                                                            for="ausente_{{ $alumno->asignacion_id }}">
                                                            <i class="fas fa-times"></i> A
                                                        </label>
                                                    </div>

                                                    {{-- Tardanza --}}
                                                    <div class="form-check">
                                                        <input type="radio"
                                                            name="asistencia_{{ $alumno->asignacion_id }}"
                                                            value="T" id="tarde_{{ $alumno->asignacion_id }}"
                                                            class="form-check-input"
                                                            {{ $alumno->estado_asistencia === 'T' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-warning font-weight-bold"
                                                            for="tarde_{{ $alumno->asignacion_id }}">
                                                            <i class="fas fa-clock"></i> T
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="justificado-center">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            id="justificado_desktop_{{ $alumno->asignacion_id }}"
                                                            data-asignacion="{{ $alumno->asignacion_id }}"
                                                            class="form-check-input checkbox-justificado"
                                                            {{ $alumno->justificado === '1' ? 'checked' : '' }}
                                                            {{ $alumno->estado_asistencia === 'P' ? 'disabled' : '' }}>
                                                        <label
                                                            class="form-check-label {{ $alumno->estado_asistencia === 'P' ? 'text-muted' : 'text-dark' }}"
                                                            for="justificado_desktop_{{ $alumno->asignacion_id }}">
                                                            Justificado
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Vista de cards para móviles --}}
                    <div class="asistencia-mobile-container">
                        @foreach ($alumnos as $index => $alumno)
                            <div class="asistencia-student-card" data-asignacion="{{ $alumno->asignacion_id }}">
                                {{-- Header del estudiante --}}
                                <div class="student-header">
                                    <div>
                                        <h3 class="student-name">
                                            {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                        </h3>
                                        <p class="student-number">#{{ $index + 1 }}</p>
                                    </div>
                                </div>

                                {{-- Controles de asistencia --}}
                                <div class="attendance-controls">
                                    {{-- Botones de asistencia --}}
                                    <div>
                                        <label class="attendance-label">Estado de Asistencia</label>
                                        <div class="attendance-grid">
                                            {{-- Presente --}}
                                            <label
                                                class="attendance-option {{ $alumno->estado_asistencia === 'P' ? 'selected-present' : '' }}">
                                                <input type="radio"
                                                    name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                    value="P" class="sr-only"
                                                    {{ $alumno->estado_asistencia === 'P' ? 'checked' : '' }}>
                                                <i class="fas fa-check text-success"></i>
                                                <span>Presente</span>
                                            </label>

                                            {{-- Ausente --}}
                                            <label
                                                class="attendance-option {{ $alumno->estado_asistencia === 'A' ? 'selected-absent' : '' }}">
                                                <input type="radio"
                                                    name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                    value="A" class="sr-only"
                                                    {{ $alumno->estado_asistencia === 'A' ? 'checked' : '' }}>
                                                <i class="fas fa-times text-danger"></i>
                                                <span>Ausente</span>
                                            </label>

                                            {{-- Tardanza --}}
                                            <label
                                                class="attendance-option {{ $alumno->estado_asistencia === 'T' ? 'selected-late' : '' }}">
                                                <input type="radio"
                                                    name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                    value="T" class="sr-only"
                                                    {{ $alumno->estado_asistencia === 'T' ? 'checked' : '' }}>
                                                <i class="fas fa-clock text-warning"></i>
                                                <span>Tardanza</span>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Checkbox justificado --}}
                                    <div class="justified-checkbox-container">
                                        <label class="justified-checkbox">
                                            <input type="checkbox"
                                                id="justificado_mobile_{{ $alumno->asignacion_id }}"
                                                data-asignacion="{{ $alumno->asignacion_id }}"
                                                class="form-check-input checkbox-justificado"
                                                {{ $alumno->justificado === '1' ? 'checked' : '' }}
                                                {{ $alumno->estado_asistencia === 'P' ? 'disabled' : '' }}>
                                            <span
                                                class="{{ $alumno->estado_asistencia === 'P' ? 'text-muted' : 'text-dark' }}">Justificado</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Botones de acción --}}
                    <div class="action-buttons-container">
                        <div class="action-buttons-wrapper">
                            <div class="student-count">
                                Total de estudiantes: {{ count($alumnos) }}
                            </div>

                            <div class="quick-actions">
                                {{-- Botones de acción rápida --}}
                                <button type="button" onclick="marcarTodos('P')" class="quick-action-btn">
                                    <i class="fas fa-check mr-1 text-success"></i>
                                    Todos Presentes
                                </button>

                                {{-- Botón guardar --}}
                                <button type="button" id="guardar-asistencias" onclick="guardarAsistencias()"
                                    class="save-btn">
                                    <i class="fas fa-save mr-2"></i>
                                    Guardar Asistencias
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Estado vacío --}}
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="empty-state-title">No hay estudiantes</h3>
                        <p class="empty-state-subtitle">
                            No se encontraron estudiantes para esta materia.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- JavaScript específico para esta página --}}
        <script>
            // Variables globales
            const cupofActual = {{ $cupofInfo->cupof }};

            // Función para marcar todos los alumnos con un estado
            function marcarTodos(estado) {

                // Marcar radios en vista desktop
                const radiosDesktop = document.querySelectorAll(
                    `input[type="radio"][value="${estado}"][name*="asistencia_"]:not([name*="mobile"])`);

                radiosDesktop.forEach((radio, index) => {
                    radio.checked = true;
                });

                // Marcar radios en vista mobile
                const radiosMobile = document.querySelectorAll(
                    `input[type="radio"][value="${estado}"][name*="asistencia_mobile_"]`);

                radiosMobile.forEach((radio, index) => {
                    radio.checked = true;

                    // Actualizar visual del card mobile
                    updateMobileCardVisual(radio);
                });

            }

            // Función para actualizar el visual de los cards móviles
            function updateMobileCardVisual(radio) {
                const label = radio.closest('label');
                if (label) {
                    // Remover clases activas de todos los hermanos
                    const siblings = label.parentElement.querySelectorAll('label');
                    siblings.forEach(sibling => {
                        sibling.classList.remove('selected-present', 'selected-absent', 'selected-late');
                    });

                    // Agregar clases activas al seleccionado
                    if (radio.checked) {
                        if (radio.value === 'P') {
                            label.classList.add('selected-present');
                        } else if (radio.value === 'A') {
                            label.classList.add('selected-absent');
                        } else if (radio.value === 'T') {
                            label.classList.add('selected-late');
                        }
                    }
                }
            }

            // Función para guardar asistencias
            async function guardarAsistencias() {

                // Verificar que la función mostrarMensaje esté disponible
                if (typeof mostrarMensaje !== 'function') {
                    alert('Error: Sistema de mensajes no disponible');
                    return;
                }

                const asistencias = [];

                // Procesar solo los elementos únicos por asignacion_id
                const todosLosElementos = document.querySelectorAll('[data-asignacion]');
                const asignacionesUnicas = new Set();

                // Extraer IDs únicos de asignación
                todosLosElementos.forEach(elemento => {
                    asignacionesUnicas.add(elemento.dataset.asignacion);
                });

                // Procesar cada asignación única
                Array.from(asignacionesUnicas).forEach((asignacionId, index) => {
                    console.log(`\n--- Procesando alumno ${index + 1} (Asignación ID: ${asignacionId}) ---`);

                    // Buscar radio marcado (preferir desktop, luego mobile)
                    let estadoRadio = document.querySelector(`input[name="asistencia_${asignacionId}"]:checked`);
                    if (!estadoRadio) {
                        estadoRadio = document.querySelector(
                            `input[name="asistencia_mobile_${asignacionId}"]:checked`);
                    }

                    // Buscar checkbox de justificado (preferir desktop, luego mobile)
                    let justificadoCheckbox = document.querySelector(`#justificado_desktop_${asignacionId}`);
                    if (!justificadoCheckbox) {
                        justificadoCheckbox = document.querySelector(`#justificado_mobile_${asignacionId}`);
                    }

                    if (estadoRadio) {
                        // IMPORTANTE: El justificado solo es válido para Ausente (A) o Tarde (T)
                        let justificadoValue = false;
                        if ((estadoRadio.value === 'A' || estadoRadio.value === 'T') && justificadoCheckbox &&
                            justificadoCheckbox.checked) {
                            justificadoValue = true;
                        }

                        const asistenciaData = {
                            asignacion_id: parseInt(asignacionId),
                            estado: estadoRadio.value,
                            justificado: justificadoValue
                        };

                        asistencias.push(asistenciaData);
                    }
                });

                if (asistencias.length === 0) {
                    alert('No hay asistencias para guardar');
                    return;
                }

                // Deshabilitar botón mientras se guarda
                const botonGuardar = document.getElementById('guardar-asistencias');
                botonGuardar.disabled = true;
                botonGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';

                try {

                    // Temporalmente sin CSRF para Laravel 12
                    const formData = new FormData();
                    formData.append('cupof', cupofActual);
                    formData.append('asistencias', JSON.stringify(asistencias));

                    const response = await fetch('/profesores/asistencias/guardar', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    // Verificar si la respuesta es válida
                    if (!response.ok) {
                        // Si es error 419 (CSRF token mismatch), recargar la página
                        if (response.status === 419) {
                            mostrarMensaje('Sesión expirada. Recargando página para obtener nueva sesión...', 'error');
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                            return;
                        }

                        const errorText = await response.text();
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    const result = await response.json();

                    if (result.success) {
                        // Mostrar mensaje de éxito simplificado
                        mostrarMensaje('Asistencias guardadas correctamente', 'success');

                        // Recargar la página después de 2 segundos para mostrar los datos actualizados
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        mostrarMensaje('Error al guardar: ' + (result.error || result.message || 'Error desconocido'),
                            'error');
                    }

                } catch (error) {
                    try {
                        mostrarMensaje('Error al guardar las asistencias: ' + error.message, 'error');
                    } catch (mensajeError) {
                        // Fallback a alert si todo falla
                        alert('Error al guardar las asistencias: ' + error.message);
                    }
                } finally {
                    // Restaurar botón
                    botonGuardar.disabled = false;
                    botonGuardar.innerHTML = '<i class="fas fa-save mr-2"></i>Guardar Asistencias';
                }
            }

            // Función para mostrar mensajes - hacerla global para debugging
            window.mostrarMensaje = function(mensaje, tipo) {
                // Limpiar mensajes anteriores
                const mensajesAnteriores = document.querySelectorAll('.mensaje-asistencias');
                mensajesAnteriores.forEach(mensaje => mensaje.remove());

                let alertClass, iconClass;

                switch (tipo) {
                    case 'success':
                        alertClass = 'alert alert-success';
                        iconClass = 'fas fa-check-circle';
                        break;
                    case 'error':
                        alertClass = 'alert alert-danger';
                        iconClass = 'fas fa-exclamation-circle';
                        break;
                    case 'info':
                        alertClass = 'alert alert-info';
                        iconClass = 'fas fa-info-circle';
                        break;
                    default:
                        alertClass = 'alert alert-secondary';
                        iconClass = 'fas fa-info-circle';
                }

                const alertDiv = document.createElement('div');
                alertDiv.className = `${alertClass} position-fixed mensaje-asistencias`;
                alertDiv.style.cssText = `
                    position: fixed !important;
                    top: 20px !important; 
                    right: 20px !important; 
                    z-index: 2147483647 !important; 
                    max-width: 380px !important; 
                    min-width: 280px !important;
                    box-shadow: 0 8px 25px rgba(0,0,0,0.25) !important;
                    border-radius: 12px !important;
                    padding: 16px 20px !important;
                    animation: slideInRight 0.3s ease-out !important;
                    border: none !important;
                    font-weight: 600 !important;
                    font-size: 14px !important;
                    backdrop-filter: blur(10px) !important;
                    transform: translateZ(0) !important;
                `;

                alertDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="${iconClass} mr-2" style="font-size: 1.1rem;"></i>
                        <span style="flex: 1;">${mensaje}</span>
                        <button type="button" class="close ml-2" style="font-size: 1.2rem; opacity: 0.7; background: none; border: none; color: inherit;" onclick="this.parentElement.parentElement.remove()">
                            <span>&times;</span>
                        </button>
                    </div>
                `;

                // Agregar animación CSS si no existe
                if (!document.getElementById('mensaje-animations')) {
                    const style = document.createElement('style');
                    style.id = 'mensaje-animations';
                    style.textContent = `
                        @keyframes slideInRight {
                            from {
                                transform: translateX(100%);
                                opacity: 0;
                            }
                            to {
                                transform: translateX(0);
                                opacity: 1;
                            }
                        }
                        @keyframes slideOutRight {
                            from {
                                transform: translateX(0);
                                opacity: 1;
                            }
                            to {
                                transform: translateX(100%);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }

                document.body.appendChild(alertDiv);

                // Remover después de 4 segundos con animación
                setTimeout(() => {
                    alertDiv.style.animation = 'slideOutRight 0.3s ease-in';
                    setTimeout(() => {
                        if (alertDiv.parentNode) {
                            alertDiv.remove();
                        }
                    }, 300);
                }, 4000);
            }

            // Event listeners para la vista móvil y desktop
            document.addEventListener('DOMContentLoaded', function() {

                // Event listener global para detectar TODOS los cambios
                document.addEventListener('change', function(event) {
                    if (event.target.type === 'radio' && event.target.name.includes('asistencia')) {

                        // Si es un radio mobile, actualizar visual
                        if (event.target.name.includes('mobile')) {
                            updateMobileCardVisual(event.target);
                        }

                        // Manejar estado del checkbox justificado
                        handleJustificadoCheckbox(event.target);
                    }
                });

                // Función para manejar el estado del checkbox justificado
                function handleJustificadoCheckbox(radioElement) {
                    // Verificar que el elemento exista
                    if (!radioElement || !radioElement.name) {
                        return;
                    }

                    // Extraer ID de asignación del nombre del radio
                    let asignacionId;
                    const radioName = radioElement.name;

                    if (radioName.includes('mobile')) {
                        // Formato: asistencia_mobile_13
                        asignacionId = radioName.replace('asistencia_mobile_', '');
                    } else if (radioName.includes('asistencia_')) {
                        // Formato: asistencia_13 (desktop)
                        asignacionId = radioName.replace('asistencia_', '');
                    } else if (radioName.includes('asistencia[')) {
                        // Formato: asistencia[13] (formulario array)
                        asignacionId = radioName.replace('asistencia[', '').replace(']', '');

                    } else {
                        return;
                    }

                    const estadoSeleccionado = radioElement.value;

                    // Encontrar ambos checkboxes (desktop y mobile)
                    const checkboxDesktop = document.querySelector(`#justificado_desktop_${asignacionId}`);
                    const checkboxMobile = document.querySelector(`#justificado_mobile_${asignacionId}`);

                    // Función helper para manejar estilos del checkbox
                    function updateCheckboxStyle(checkbox, disabled, elementType) {
                        if (!checkbox) {
                            return;
                        }

                        checkbox.disabled = disabled;

                        // Si está deshabilitado, desmarcar
                        if (disabled) {
                            checkbox.checked = false;
                        }

                        // Actualizar estilos visuales
                        const label = checkbox.closest('label');
                        if (label) {
                            if (disabled) {
                                label.style.opacity = '0.5';
                                label.style.cursor = 'not-allowed';
                            } else {
                                label.style.opacity = '1';
                                label.style.cursor = 'pointer';
                            }
                        }
                    }

                    // Habilitar/deshabilitar según el estado
                    if (estadoSeleccionado === 'presente' || estadoSeleccionado === 'P') {
                        // Si está presente, deshabilitar y desmarcar justificado
                        updateCheckboxStyle(checkboxDesktop, true, 'desktop');
                        updateCheckboxStyle(checkboxMobile, true, 'mobile');

                    } else if (estadoSeleccionado === 'ausente' || estadoSeleccionado === 'tarde' ||
                        estadoSeleccionado === 'A' || estadoSeleccionado === 'T') {
                        // Si está ausente o tarde, habilitar justificado
                        updateCheckboxStyle(checkboxDesktop, false, 'desktop');
                        updateCheckboxStyle(checkboxMobile, false, 'mobile');
                    }
                }
                // Función para verificar asistencias existentes
                function verificarAsistenciasExistentes() {
                    const radiosChecked = document.querySelectorAll('input[type="radio"]:checked');

                    radiosChecked.forEach((radio, index) => {
                        if (radio.name.includes('mobile')) {
                            updateMobileCardVisual(radio);
                        }
                        handleJustificadoCheckbox(radio);
                    });
                }

                // Verificar si hay asistencias ya cargadas para hoy
                verificarAsistenciasExistentes();

                // Inicializar estado de checkboxes justificado según estado actual
                function inicializarCheckboxesJustificado() {

                    const todosLosRadios = document.querySelectorAll('input[type="radio"]:checked');
                    todosLosRadios.forEach(radio => {
                        if (radio.name.includes('asistencia')) {
                            handleJustificadoCheckbox(radio);
                        }
                    });
                }

                // Ejecutar inicialización
                inicializarCheckboxesJustificado();

                const mobileRadios = document.querySelectorAll('.asistencia-mobile-container input[type="radio"]');
                const desktopRadios = document.querySelectorAll('.d-none.d-md-block input[type="radio"]');

                // Agregar event listeners para los radio buttons de la vista móvil (con nuevos nombres)
                mobileRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        updateMobileCardVisual(this);
                        // Sincronizar con el radio button de escritorio correspondiente
                        const asignacionId = this.name.replace('asistencia_mobile_', '');
                        const desktopRadio = document.querySelector(
                            `input[name="asistencia_${asignacionId}"][value="${this.value}"]`);
                        if (desktopRadio) {
                            desktopRadio.checked = true;
                        }
                    });

                    // Inicializar estado visual
                    if (radio.checked) {
                        updateMobileCardVisual(radio);
                    }
                });

                // Agregar event listeners para los radio buttons de la vista de escritorio
                desktopRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        // Sincronizar con el radio button móvil correspondiente si existe
                        const asignacionId = this.name.replace('asistencia_', '');
                        const mobileRadio = document.querySelector(
                            `input[name="asistencia_mobile_${asignacionId}"][value="${this.value}"]`
                        );
                        if (mobileRadio) {
                            mobileRadio.checked = true;
                            updateMobileCardVisual(mobileRadio);
                        }
                    });
                });

                // Agregar event listeners para los checkboxes de justificado
                const checkboxesDesktop = document.querySelectorAll(
                    'input[type="checkbox"][id*="justificado_desktop_"]');
                const checkboxesMobile = document.querySelectorAll('input[type="checkbox"][id*="justificado_mobile_"]');

                // Sincronizar desktop -> mobile
                checkboxesDesktop.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const asignacionId = this.id.replace('justificado_desktop_', '');
                        const checkboxMobile = document.querySelector(
                            `#justificado_mobile_${asignacionId}`);
                        if (checkboxMobile) {
                            checkboxMobile.checked = this.checked;
                        }
                    });
                });

                // Sincronizar mobile -> desktop
                checkboxesMobile.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const asignacionId = this.id.replace('justificado_mobile_', '');
                        const checkboxDesktop = document.querySelector(
                            `#justificado_desktop_${asignacionId}`);
                        if (checkboxDesktop) {
                            checkboxDesktop.checked = this.checked;
                        }
                    });
                });

            });
        </script>
</x-layouts.profesores.dashboard>
