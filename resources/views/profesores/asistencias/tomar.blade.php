{{-- Vista para tomar asistencias de una materia específica --}}
{{-- Vista para tomar asistencias de una materia específica --}}
<x-layouts.profesores.dashboard asistencias titulo="Tomar Asistencias">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                console.log('Ejecutando marcarTodos con estado:', estado);

                // Marcar radios en vista desktop
                const radiosDesktop = document.querySelectorAll(
                    `input[type="radio"][value="${estado}"][name*="asistencia_"]:not([name*="mobile"])`);
                console.log('Radios desktop encontrados:', radiosDesktop.length);

                radiosDesktop.forEach((radio, index) => {
                    radio.checked = true;
                    console.log(`Marcado radio desktop ${index + 1}:`, radio.name);
                });

                // Marcar radios en vista mobile
                const radiosMobile = document.querySelectorAll(
                    `input[type="radio"][value="${estado}"][name*="asistencia_mobile_"]`);
                console.log('Radios mobile encontrados:', radiosMobile.length);

                radiosMobile.forEach((radio, index) => {
                    radio.checked = true;
                    console.log(`Marcado radio mobile ${index + 1}:`, radio.name);

                    // Actualizar visual del card mobile
                    updateMobileCardVisual(radio);
                });

                console.log('marcarTodos completado');
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
                console.log('🚀 Iniciando proceso de guardado de asistencias...');

                // Verificar que la función mostrarMensaje esté disponible
                if (typeof mostrarMensaje !== 'function') {
                    console.error('❌ Función mostrarMensaje no está disponible');
                    alert('Error: Sistema de mensajes no disponible');
                    return;
                }

                const asistencias = [];

                // SOLUCION: Procesar solo los elementos únicos por asignacion_id
                // En lugar de procesar todos los [data-asignacion], vamos a obtener IDs únicos
                const todosLosElementos = document.querySelectorAll('[data-asignacion]');
                const asignacionesUnicas = new Set();

                // Extraer IDs únicos de asignación
                todosLosElementos.forEach(elemento => {
                    asignacionesUnicas.add(elemento.dataset.asignacion);
                });

                console.log('🔍 DEBUG CHECKBOXES - Iniciando recolección de datos');
                console.log('Total de elementos encontrados:', todosLosElementos.length);
                console.log('Asignaciones únicas:', asignacionesUnicas.size);
                console.log('IDs únicos:', Array.from(asignacionesUnicas));

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

                    console.log('Estado radio encontrado:', estadoRadio ? estadoRadio.value : 'NO ENCONTRADO');
                    console.log('Checkbox justificado encontrado:', justificadoCheckbox ? 'SÍ' : 'NO');

                    if (justificadoCheckbox) {
                        console.log('Checkbox justificado checked:', justificadoCheckbox.checked);
                        console.log('Checkbox justificado type:', justificadoCheckbox.type);
                        console.log('Checkbox justificado id:', justificadoCheckbox.id);
                    } else {
                        console.log('❌ NO SE ENCONTRÓ EL CHECKBOX DE JUSTIFICADO');
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

                        console.log('Datos finales para enviar:', asistenciaData);
                        console.log(
                            `  Estado: ${estadoRadio.value}, Justificado permitido: ${estadoRadio.value === 'A' || estadoRadio.value === 'T'}, Checkbox marcado: ${justificadoCheckbox ? justificadoCheckbox.checked : false}, Resultado final: ${justificadoValue}`
                        );
                        asistencias.push(asistenciaData);
                    }
                });

                console.log('\n🚀 DATOS FINALES PARA ENVIAR:');
                console.log('Total asistencias recolectadas:', asistencias.length);
                asistencias.forEach((asistencia, idx) => {
                    console.log(`Asistencia ${idx + 1}:`, asistencia);
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
                    console.log('Enviando request sin CSRF (temporalmente)');
                    console.log('URL de destino:', '/profesores/asistencias/guardar');
                    console.log('Datos a enviar:', {
                        cupof: cupofActual,
                        asistencias: asistencias
                    });

                    // Temporalmente sin CSRF para Laravel 12
                    const formData = new FormData();
                    formData.append('cupof', cupofActual);
                    formData.append('asistencias', JSON.stringify(asistencias));

                    console.log('📡 Enviando petición HTTP...');
                    const response = await fetch('/profesores/asistencias/guardar', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    console.log('📡 Respuesta HTTP recibida, status:', response.status);

                    console.log('Respuesta recibida:', {
                        status: response.status,
                        statusText: response.statusText,
                        headers: Object.fromEntries(response.headers.entries())
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
                        console.error('Error response:', errorText);
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    const result = await response.json();
                    console.log('🎯 Respuesta del servidor:', result);

                    if (result.success) {
                        console.log('✅ Guardado exitoso, mostrando mensaje...');
                        // Mostrar mensaje de éxito simplificado
                        mostrarMensaje('Asistencias guardadas correctamente', 'success');

                        // Recargar la página después de 2 segundos para mostrar los datos actualizados
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        console.log('❌ Error en el guardado, mostrando error...');
                        mostrarMensaje('Error al guardar: ' + (result.error || result.message || 'Error desconocido'),
                            'error');
                    }

                } catch (error) {
                    console.error('💥 Error completo al guardar asistencias:', error);
                    console.error('💥 Stack trace:', error.stack);
                    console.log('🔍 Intentando mostrar mensaje de error...');

                    try {
                        mostrarMensaje('Error al guardar las asistencias: ' + error.message, 'error');
                    } catch (mensajeError) {
                        console.error('💥 Error al mostrar mensaje:', mensajeError);
                        // Fallback a alert si todo falla
                        alert('Error al guardar las asistencias: ' + error.message);
                    }
                } finally {
                    console.log('🔄 Finalizando proceso de guardado...');
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

                console.log('📢 Mensaje mostrado:', mensaje, 'Tipo:', tipo);

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
                // Debug: Verificar token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                console.log('Token CSRF encontrado:', csrfToken ? 'Sí' : 'No');
                if (csrfToken) {
                    console.log('Valor del token:', csrfToken.getAttribute('content'));
                }

                // Debug: Event listener global para detectar TODOS los cambios
                document.addEventListener('change', function(event) {
                    if (event.target.type === 'radio' && event.target.name.includes('asistencia')) {
                        console.log('🔄 CAMBIO GLOBAL DETECTADO:', event.target.name, '=', event.target.value);
                        console.log('🔍 Tipo de radio:', event.target.name.includes('mobile') ? 'MOBILE' :
                            'DESKTOP');

                        // Si es un radio mobile, actualizar visual
                        if (event.target.name.includes('mobile')) {
                            updateMobileCardVisual(event.target);
                        }

                        // NUEVO: Manejar estado del checkbox justificado
                        handleJustificadoCheckbox(event.target);
                    }
                });

                // Función para manejar el estado del checkbox justificado
                function handleJustificadoCheckbox(radioElement) {
                    // Verificar que el elemento exista
                    if (!radioElement || !radioElement.name) {
                        console.warn('⚠️ handleJustificadoCheckbox: elemento radio inválido');
                        return;
                    }

                    // Extraer ID de asignación del nombre del radio
                    let asignacionId;
                    const radioName = radioElement.name;

                    console.log('🔍 Analizando radio name:', radioName);

                    if (radioName.includes('mobile')) {
                        // Formato: asistencia_mobile_13
                        asignacionId = radioName.replace('asistencia_mobile_', '');
                        console.log('📱 Radio mobile detectado, ID extraído:', asignacionId);
                    } else if (radioName.includes('asistencia_')) {
                        // Formato: asistencia_13 (desktop)
                        asignacionId = radioName.replace('asistencia_', '');
                        console.log('🖥️ Radio desktop detectado, ID extraído:', asignacionId);
                    } else if (radioName.includes('asistencia[')) {
                        // Formato: asistencia[13] (formulario array)
                        asignacionId = radioName.replace('asistencia[', '').replace(']', '');
                        console.log('📋 Radio array detectado, ID extraído:', asignacionId);
                    } else {
                        console.warn('⚠️ Formato de nombre de radio no reconocido:', radioName);
                        return;
                    }

                    const estadoSeleccionado = radioElement.value;

                    // Verificar que tenemos un ID válido
                    if (!asignacionId || asignacionId === '') {
                        console.warn('⚠️ No se pudo extraer ID de asignación de:', radioName);
                        return;
                    }

                    // Encontrar ambos checkboxes (desktop y mobile)
                    const checkboxDesktop = document.querySelector(`#justificado_desktop_${asignacionId}`);
                    const checkboxMobile = document.querySelector(`#justificado_mobile_${asignacionId}`);

                    console.log(
                        `📋 Manejando checkbox justificado para asignación ${asignacionId}, estado: ${estadoSeleccionado}`
                    );
                    console.log('🔍 Checkboxes encontrados:', {
                        desktop: checkboxDesktop ? 'SÍ' : 'NO',
                        mobile: checkboxMobile ? 'SÍ' : 'NO'
                    });

                    // Función helper para manejar estilos del checkbox
                    function updateCheckboxStyle(checkbox, disabled, elementType) {
                        if (!checkbox) {
                            console.log(`⚠️ No se encontró checkbox ${elementType} para ID ${asignacionId}`);
                            return;
                        }

                        console.log(`🔧 Actualizando checkbox ${elementType}: disabled=${disabled}`);

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
                        console.log(`  ✅ Checkboxes deshabilitados (Presente)`);
                    } else if (estadoSeleccionado === 'ausente' || estadoSeleccionado === 'tarde' ||
                        estadoSeleccionado === 'A' || estadoSeleccionado === 'T') {
                        // Si está ausente o tarde, habilitar justificado
                        updateCheckboxStyle(checkboxDesktop, false, 'desktop');
                        updateCheckboxStyle(checkboxMobile, false, 'mobile');
                        console.log(
                            `  ✅ Checkboxes habilitados (${estadoSeleccionado === 'A' || estadoSeleccionado === 'ausente' ? 'Ausente' : 'Tarde'})`
                        );
                    }
                }

                // Verificar si hay asistencias ya cargadas para hoy
                verificarAsistenciasExistentes();

                // Función para verificar asistencias existentes
                function verificarAsistenciasExistentes() {
                    console.log('🔍 Verificando asistencias existentes...');
                    const radiosChecked = document.querySelectorAll('input[type="radio"]:checked');
                    console.log(`Radios marcados encontrados: ${radiosChecked.length}`);

                    radiosChecked.forEach((radio, index) => {
                        if (radio.name.includes('mobile')) {
                            updateMobileCardVisual(radio);
                        }
                        handleJustificadoCheckbox(radio);
                    });
                }

                // NUEVO: Inicializar estado de checkboxes justificado según estado actual
                function inicializarCheckboxesJustificado() {
                    console.log('🔄 Inicializando estado de checkboxes justificado...');

                    const todosLosRadios = document.querySelectorAll('input[type="radio"]:checked');
                    todosLosRadios.forEach(radio => {
                        if (radio.name.includes('asistencia')) {
                            handleJustificadoCheckbox(radio);
                        }
                    });

                    console.log('✅ Inicialización de checkboxes completada');
                }

                // Ejecutar inicialización
                inicializarCheckboxesJustificado();

                // Debug: Contar radios en cada vista
                const allRadios = document.querySelectorAll('input[type="radio"]');
                const mobileRadios = document.querySelectorAll('.asistencia-mobile-container input[type="radio"]');
                const desktopRadios = document.querySelectorAll('.d-none.d-md-block input[type="radio"]');

                console.log('Total de radios encontrados:', allRadios.length);
                console.log('Radios mobile encontrados:', mobileRadios.length);
                console.log('Radios desktop encontrados:', desktopRadios.length);

                // Verificar estructura de HTML
                console.log('Contenedores desktop encontrados:', document.querySelectorAll('.d-none.d-md-block')
                    .length);
                console.log('Contenedores mobile encontrados:', document.querySelectorAll(
                    '.asistencia-mobile-container').length);

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
                            console.log('Sincronizado radio mobile -> desktop:', asignacionId, this
                                .value);
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
                        console.log('Radio button desktop cambiado:', this.name, this.value);
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

                // Función de debug para verificar estado actual
                window.verificarEstado = function() {
                    console.log('=== VERIFICACIÓN DE ESTADO ===');
                    const formData = new FormData();
                    const asistencias = [];

                    document.querySelectorAll('[data-asignacion]').forEach(elemento => {
                        const asignacionId = elemento.dataset.asignacion;

                        // Buscar radio marcado (desktop o mobile)
                        let radioMarcado = elemento.querySelector(
                            `input[name="asistencia_${asignacionId}"]:checked`);
                        if (!radioMarcado) {
                            radioMarcado = document.querySelector(
                                `input[name="asistencia_mobile_${asignacionId}"]:checked`);
                        }

                        // Buscar checkbox justificado (desktop o mobile)
                        let justificado = document.querySelector(`#justificado_desktop_${asignacionId}`);
                        if (!justificado) {
                            justificado = document.querySelector(`#justificado_mobile_${asignacionId}`);
                        }

                        if (radioMarcado) {
                            console.log(
                                `Alumno ${asignacionId}: ${radioMarcado.value}, Justificado: ${justificado ? justificado.checked : false}`
                            );
                            asistencias.push({
                                asignacion_id: asignacionId,
                                estado: radioMarcado.value,
                                justificado: justificado ? justificado.checked : false
                            });
                        }
                    });

                    console.log('Total asistencias a enviar:', asistencias.length);
                    return asistencias;
                };

                // Test rápido de la función marcarTodos
                window.testMarcarTodos = function() {
                    console.log('Test de marcarTodos iniciado');
                    marcarTodos('P');
                };

                // Función para verificar el estado de todos los radios
                window.verificarRadios = function() {
                    console.log('=== VERIFICACIÓN DE RADIOS ===');
                    const estudiantes = document.querySelectorAll('[data-asignacion]');
                    estudiantes.forEach((elemento, index) => {
                        const asignacionId = elemento.dataset.asignacion;

                        // Radios desktop
                        const radiosDesktopP = document.querySelectorAll(
                            `input[name="asistencia_${asignacionId}"][value="P"]`);
                        const radiosDesktopA = document.querySelectorAll(
                            `input[name="asistencia_${asignacionId}"][value="A"]`);
                        const radiosDesktopT = document.querySelectorAll(
                            `input[name="asistencia_${asignacionId}"][value="T"]`);

                        // Radios mobile
                        const radiosMobileP = document.querySelectorAll(
                            `input[name="asistencia_mobile_${asignacionId}"][value="P"]`);
                        const radiosMobileA = document.querySelectorAll(
                            `input[name="asistencia_mobile_${asignacionId}"][value="A"]`);
                        const radiosMobileT = document.querySelectorAll(
                            `input[name="asistencia_mobile_${asignacionId}"][value="T"]`);

                        console.log(`Estudiante ${index + 1} (${asignacionId}):`);
                        console.log(
                            `  Desktop - P: ${radiosDesktopP.length}, Checked: ${Array.from(radiosDesktopP).filter(r => r.checked).length}`
                        );
                        console.log(
                            `  Desktop - A: ${radiosDesktopA.length}, Checked: ${Array.from(radiosDesktopA).filter(r => r.checked).length}`
                        );
                        console.log(
                            `  Desktop - T: ${radiosDesktopT.length}, Checked: ${Array.from(radiosDesktopT).filter(r => r.checked).length}`
                        );
                        console.log(
                            `  Mobile - P: ${radiosMobileP.length}, Checked: ${Array.from(radiosMobileP).filter(r => r.checked).length}`
                        );
                        console.log(
                            `  Mobile - A: ${radiosMobileA.length}, Checked: ${Array.from(radiosMobileA).filter(r => r.checked).length}`
                        );
                        console.log(
                            `  Mobile - T: ${radiosMobileT.length}, Checked: ${Array.from(radiosMobileT).filter(r => r.checked).length}`
                        );
                    });
                    console.log('=== FIN VERIFICACIÓN ===');
                };

                // Test de CSRF independiente
                window.testCSRF = async function() {
                    console.log('Test de CSRF iniciado');
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                        console.log('Token CSRF del meta:', csrfToken.getAttribute('content'));

                        const formData = new FormData();
                        formData.append('_token', csrfToken.getAttribute('content'));
                        formData.append('test', 'data');

                        const response = await fetch('/test-csrf', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        console.log('Respuesta del servidor:', response.status, response.statusText);
                        const result = await response.json();
                        console.log('Test CSRF resultado:', result);
                        return result;
                    } catch (error) {
                        console.error('Test CSRF error:', error);
                        return error;
                    }
                };

                // NUEVA FUNCIÓN: Verificar estado específico de justificados
                window.verificarEstadoJustificado = function() {
                    console.log('=== VERIFICACIÓN ESTADO JUSTIFICADO ===');

                    const todosLosElementos = document.querySelectorAll('[data-asignacion]');
                    const asignacionesUnicas = new Set();

                    todosLosElementos.forEach(elemento => {
                        asignacionesUnicas.add(elemento.dataset.asignacion);
                    });

                    Array.from(asignacionesUnicas).forEach((asignacionId, index) => {
                        // Buscar estado actual
                        let estadoRadio = document.querySelector(
                            `input[name="asistencia_${asignacionId}"]:checked`);
                        if (!estadoRadio) {
                            estadoRadio = document.querySelector(
                                `input[name="asistencia_mobile_${asignacionId}"]:checked`);
                        }

                        // Buscar checkboxes
                        const checkboxDesktop = document.querySelector(
                            `#justificado_desktop_${asignacionId}`);
                        const checkboxMobile = document.querySelector(
                            `#justificado_mobile_${asignacionId}`);

                        console.log(`Estudiante ${index + 1} (ID: ${asignacionId}):`);
                        console.log(`  Estado: ${estadoRadio ? estadoRadio.value : 'SIN ESTADO'}`);
                        console.log(
                            `  Justificado permitido: ${estadoRadio && (estadoRadio.value === 'A' || estadoRadio.value === 'T')}`
                        );

                        if (checkboxDesktop) {
                            console.log(
                                `  Desktop - Disabled: ${checkboxDesktop.disabled}, Checked: ${checkboxDesktop.checked}`
                            );
                        }
                        if (checkboxMobile) {
                            console.log(
                                `  Mobile - Disabled: ${checkboxMobile.disabled}, Checked: ${checkboxMobile.checked}`
                            );
                        }
                    });

                    console.log('=== FIN VERIFICACIÓN ===');
                };

                // NUEVA FUNCIÓN: Verificar que no hay duplicados
                window.verificarDuplicados = function() {
                    console.log('=== VERIFICACIÓN DE DUPLICADOS ===');
                    const todosLosElementos = document.querySelectorAll('[data-asignacion]');
                    const asignacionesUnicas = new Set();
                    const contadorPorAsignacion = {};

                    todosLosElementos.forEach(elemento => {
                        const id = elemento.dataset.asignacion;
                        asignacionesUnicas.add(id);
                        contadorPorAsignacion[id] = (contadorPorAsignacion[id] || 0) + 1;
                    });

                    console.log('Total elementos encontrados:', todosLosElementos.length);
                    console.log('Asignaciones únicas:', asignacionesUnicas.size);
                    console.log('Conteo por asignación:', contadorPorAsignacion);

                    // Detectar duplicados
                    const duplicados = Object.entries(contadorPorAsignacion).filter(([id, count]) => count > 1);
                    if (duplicados.length > 0) {
                        console.log('⚠️ DUPLICADOS DETECTADOS:', duplicados);
                    } else {
                        console.log('✅ No hay duplicados');
                    }

                    return {
                        total: todosLosElementos.length,
                        unicos: asignacionesUnicas.size,
                        duplicados: duplicados
                    };
                };

                // Función para verificar el estado de todos los checkboxes
                window.verificarCheckboxes = function() {
                    console.log('=== VERIFICACIÓN DE CHECKBOXES ===');
                    const estudiantes = document.querySelectorAll('[data-asignacion]');
                    estudiantes.forEach((elemento, index) => {
                        const asignacionId = elemento.dataset.asignacion;

                        const checkboxDesktop = document.querySelector(
                            `#justificado_desktop_${asignacionId}`);
                        const checkboxMobile = document.querySelector(
                            `#justificado_mobile_${asignacionId}`);

                        console.log(`Estudiante ${index + 1} (ID: ${asignacionId}):`);
                        console.log(`  Checkbox desktop: ${checkboxDesktop ? 'SÍ' : 'NO'}`);
                        console.log(`  Checkbox mobile: ${checkboxMobile ? 'SÍ' : 'NO'}`);

                        if (checkboxDesktop) {
                            console.log(`  Desktop checked: ${checkboxDesktop.checked}`);
                        }
                        if (checkboxMobile) {
                            console.log(`  Mobile checked: ${checkboxMobile.checked}`);
                        }
                    });
                    console.log('=== FIN VERIFICACIÓN ===');
                };

                // Función para probar marcar algunos checkboxes
                window.testCheckboxes = function() {
                    console.log('=== TEST DE CHECKBOXES ===');
                    const checkboxesDesktop = document.querySelectorAll(
                        'input[type="checkbox"][id*="justificado_desktop_"]');
                    const checkboxesMobile = document.querySelectorAll(
                        'input[type="checkbox"][id*="justificado_mobile_"]');

                    console.log('Checkboxes desktop encontrados:', checkboxesDesktop.length);
                    console.log('Checkboxes mobile encontrados:', checkboxesMobile.length);

                    // Marcar los primeros 2 checkboxes desktop
                    checkboxesDesktop.forEach((checkbox, index) => {
                        if (index < 2) {
                            checkbox.checked = true;
                            console.log(`Marcado checkbox desktop ${index + 1}: ${checkbox.id}`);

                            // Sincronizar con el mobile correspondiente
                            const asignacionId = checkbox.id.replace('justificado_desktop_', '');
                            const checkboxMobile = document.querySelector(
                                `#justificado_mobile_${asignacionId}`);
                            if (checkboxMobile) {
                                checkboxMobile.checked = true;
                                console.log(
                                    `Sincronizado checkbox mobile: justificado_mobile_${asignacionId}`);
                            }
                        }
                    });

                    console.log('Test completado. Verificar estado:');
                    verificarCheckboxes();
                };

                // Agregar event listeners para los checkboxes de justificado
                const checkboxesDesktop = document.querySelectorAll(
                    'input[type="checkbox"][id*="justificado_desktop_"]');
                const checkboxesMobile = document.querySelectorAll('input[type="checkbox"][id*="justificado_mobile_"]');

                console.log('Checkboxes desktop encontrados para sync:', checkboxesDesktop.length);
                console.log('Checkboxes mobile encontrados para sync:', checkboxesMobile.length);

                // Sincronizar desktop -> mobile
                checkboxesDesktop.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const asignacionId = this.id.replace('justificado_desktop_', '');
                        const checkboxMobile = document.querySelector(
                            `#justificado_mobile_${asignacionId}`);
                        if (checkboxMobile) {
                            checkboxMobile.checked = this.checked;
                            console.log(`Sincronizado desktop -> mobile (${asignacionId}):`, this
                                .checked);
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
                            console.log(`Sincronizado mobile -> desktop (${asignacionId}):`, this
                                .checked);
                        }
                    });
                });

                console.log('Sincronización de checkboxes configurada');

                // Función de test inicial
                window.testBasico = function() {
                    console.log('=== TEST BÁSICO ===');
                    console.log('1. Verificando contenedores:');
                    console.log('   - Desktop container:', document.querySelectorAll('.d-none.d-md-block').length);
                    console.log('   - Mobile container:', document.querySelectorAll('.asistencia-mobile-container')
                        .length);

                    console.log('2. Verificando radios:');
                    console.log('   - Total radios:', document.querySelectorAll('input[type="radio"]').length);
                    console.log('   - Radios mobile:', document.querySelectorAll(
                        '.asistencia-mobile-container input[type="radio"]').length);
                    console.log('   - Radios desktop:', document.querySelectorAll(
                        '.d-none.d-md-block input[type="radio"]').length);

                    console.log('3. Verificando checkboxes:');
                    console.log('   - Checkboxes desktop:', document.querySelectorAll(
                        'input[id*="justificado_desktop_"]').length);
                    console.log('   - Checkboxes mobile:', document.querySelectorAll(
                        'input[id*="justificado_mobile_"]').length);

                    console.log('4. Verificando data-asignacion:');
                    console.log('   - Elementos con data-asignacion:', document.querySelectorAll(
                        '[data-asignacion]').length);

                    console.log('5. Verificando estructura de tabla:');
                    const tablaRadios = document.querySelectorAll('.asistencia-radio-group input[type="radio"]');
                    console.log('   - Radios en tabla con nueva clase:', tablaRadios.length);

                    const checkboxJustificados = document.querySelectorAll(
                        '.justificado-center input[type="checkbox"]');
                    console.log('   - Checkboxes justificado con nueva clase:', checkboxJustificados.length);

                    console.log('6. Test de funcionalidad:');
                    const primerRadio = document.querySelector('input[type="radio"]');
                    if (primerRadio) {
                        console.log('   - Primer radio encontrado:', primerRadio.name, primerRadio.value);
                        console.log('   - Está checked:', primerRadio.checked);
                    } else {
                        console.warn('   ⚠️ NO SE ENCONTRARON RADIOS');
                    }

                    console.log('=== FIN TEST BÁSICO ===');

                    // Verificar problemas comunes
                    if (tablaRadios.length === 0) {
                        console.error('❌ PROBLEMA: No se encontraron radios en la tabla');
                    }
                    if (checkboxJustificados.length === 0) {
                        console.error('❌ PROBLEMA: No se encontraron checkboxes de justificado');
                    }
                };

                window.testEventos = function() {
                    console.log('=== TEST DE EVENTOS ===');

                    // Test de radio buttons
                    const primeraAsignacion = document.querySelector('[data-asignacion]');
                    if (primeraAsignacion) {
                        const asignacionId = primeraAsignacion.getAttribute('data-asignacion');
                        console.log('1. Testeando radio buttons para asignación:', asignacionId);

                        // Test radio desktop (formato: asistencia_ID)
                        const radioDesktopPresente = document.querySelector(
                            `input[name="asistencia_${asignacionId}"][value="P"]`);
                        const radioDesktopAusente = document.querySelector(
                            `input[name="asistencia_${asignacionId}"][value="A"]`);

                        console.log('   🖥️ Radios desktop encontrados:');
                        console.log('      - Presente:', radioDesktopPresente ? 'SÍ' : 'NO');
                        console.log('      - Ausente:', radioDesktopAusente ? 'SÍ' : 'NO');

                        // Test radio mobile (formato: asistencia_mobile_ID)
                        const radioMobilePresente = document.querySelector(
                            `input[name="asistencia_mobile_${asignacionId}"][value="P"]`);
                        const radioMobileAusente = document.querySelector(
                            `input[name="asistencia_mobile_${asignacionId}"][value="A"]`);

                        console.log('   📱 Radios mobile encontrados:');
                        console.log('      - Presente:', radioMobilePresente ? 'SÍ' : 'NO');
                        console.log('      - Ausente:', radioMobileAusente ? 'SÍ' : 'NO');

                        // Test checkboxes justificado
                        const checkboxDesktop = document.querySelector(`#justificado_desktop_${asignacionId}`);
                        const checkboxMobile = document.querySelector(`#justificado_mobile_${asignacionId}`);

                        console.log('   ☑️ Checkboxes justificado encontrados:');
                        console.log('      - Desktop:', checkboxDesktop ? 'SÍ' : 'NO', checkboxDesktop?.disabled ?
                            '(DISABLED)' : '(ENABLED)');
                        console.log('      - Mobile:', checkboxMobile ? 'SÍ' : 'NO', checkboxMobile?.disabled ?
                            '(DISABLED)' : '(ENABLED)');

                        // Simular click en ausente desktop
                        if (radioDesktopAusente) {
                            console.log('   🧪 Simulando click en ausente desktop...');
                            radioDesktopAusente.click();
                            setTimeout(() => {
                                console.log('      ✅ Resultado desktop ausente:');
                                console.log('         - Radio checked:', radioDesktopAusente.checked);
                                console.log('         - Checkbox desktop disabled:', checkboxDesktop
                                    ?.disabled);
                                console.log('         - Checkbox mobile disabled:', checkboxMobile
                                    ?.disabled);
                            }, 500);
                        }

                        // Test de checkbox justificado
                        setTimeout(() => {
                            if (checkboxDesktop && !checkboxDesktop.disabled) {
                                console.log('   🧪 Simulando click en checkbox desktop...');
                                checkboxDesktop.click();
                                console.log('      ✅ Checkbox desktop checked:', checkboxDesktop.checked);
                            } else {
                                console.log('   ⚠️ Checkbox desktop no disponible para test');
                            }
                        }, 1000);
                    } else {
                        console.error('❌ No se encontró ninguna asignación para testear');
                    }

                    console.log('=== FIN TEST DE EVENTOS ===');
                };

                // Función para resetear estado de test
                window.resetearTest = function() {
                    // Desmarcar todos los radios y checkboxes
                    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
                        input.checked = false;
                    });

                    // Limpiar clases visuales
                    document.querySelectorAll('.selected-present, .selected-absent, .selected-late').forEach(el => {
                        el.classList.remove('selected-present', 'selected-absent', 'selected-late');
                    });

                    console.log('✅ Estado de test reseteado');
                };

                // Función para test del mensaje
                window.testMensaje = function() {
                    console.log('=== TEST DE MENSAJE ===');
                    console.log('Probando mensaje de éxito...');
                    mostrarMensaje('✅ Asistencias guardadas correctamente', 'success');

                    setTimeout(() => {
                        console.log('Probando mensaje de error...');
                        mostrarMensaje('❌ Error al guardar las asistencias', 'error');
                    }, 2000);

                    setTimeout(() => {
                        console.log('Probando mensaje de info...');
                        mostrarMensaje('ℹ️ Información importante para el profesor', 'info');
                    }, 4000);

                    console.log('=== FIN TEST DE MENSAJE ===');
                };

                // Función específica para test de mensaje de guardado
                window.testMensajeGuardado = function() {
                    console.log('🧪 Testing mensaje de guardado específico...');

                    // Simular el mensaje exacto que se muestra al guardar
                    mostrarMensaje('Asistencias guardadas correctamente', 'success');

                    console.log('✅ Si ves el mensaje verde arriba a la derecha, el sistema funciona');
                }; // Función para test de guardado completo
                window.testGuardado = function() {
                    console.log('=== TEST DE GUARDADO ===');

                    // Verificar que hay asistencias para procesar
                    const asignaciones = document.querySelectorAll('[data-asignacion]');
                    if (asignaciones.length === 0) {
                        console.error('❌ No hay asignaciones para testear');
                        return;
                    }

                    console.log('✅ Asignaciones encontradas:', asignaciones.length);

                    // Simular marcar algunos estudiantes
                    const primeraAsignacion = asignaciones[0].dataset.asignacion;
                    const radioPresente = document.querySelector(
                        `input[name="asistencia_${primeraAsignacion}"][value="P"]`);

                    if (radioPresente) {
                        console.log('🧪 Marcando primer estudiante como presente...');
                        radioPresente.checked = true;

                        // Simular guardado (sin enviar realmente)
                        console.log('🧪 Simulando mensaje de guardado exitoso...');
                        mostrarMensaje('Asistencias guardadas correctamente (TEST)', 'success');
                    } else {
                        console.error('❌ No se encontró radio para testear');
                    }

                    console.log('=== FIN TEST DE GUARDADO ===');
                }; // Ejecutar test básico al cargar
                testBasico();

                // Funciones de debugging para el usuario
                console.log('=== FUNCIONES DE DEBUG DISPONIBLES ===');
                console.log('- testBasico(): Test inicial de elementos');
                console.log('- testEventos(): Test de funcionalidad de clicks');
                console.log('- resetearTest(): Resetea el estado de prueba');
                console.log('- testMensaje(): Prueba el sistema de mensajes (3 tipos)');
                console.log('- testMensajeGuardado(): Prueba específica del mensaje de guardado');
                console.log('- testGuardado(): Simula proceso de guardado completo');
                console.log('- mostrarMensaje(msg, tipo): Muestra mensaje personalizado');
                console.log('- verificarEstado(): Muestra el estado actual de todas las asistencias');
                console.log('- testMarcarTodos(): Marca todos los estudiantes como presentes');
                console.log('- verificarRadios(): Muestra información de los radios');
                console.log('- verificarCheckboxes(): Muestra información de los checkboxes de justificado');
                console.log('- verificarDuplicados(): Verifica si hay elementos duplicados');
                console.log('- testCSRF(): Prueba la funcionalidad CSRF');
                console.log('=== USO RECOMENDADO ===');
                console.log('1. Ejecutar testBasico() para verificar estructura');
                console.log('2. Ejecutar testEventos() para probar funcionalidad');
                console.log('3. Usar testMensaje() para probar mensajes');
                console.log('4. Usar resetearTest() para limpiar antes de nuevas pruebas');
                console.log('==========================================');

                console.log('✅ Inicialización JavaScript completada correctamente');
            });
        </script>
</x-layouts.profesores.dashboard>
