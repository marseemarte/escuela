{{-- Vista para tomar asistencias de una materia específica --}}
<x-layouts.profesores.dashboard asistencias titulo="Tomar Asistencias">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="space-y-6">
        {{-- Header con información de la materia --}}
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                    {{-- Botón de regreso --}}
                    <a href="{{ route('profesores.asistencias.index') }}"
                        class="inline-flex items-center justify-center sm:justify-start px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>

                    {{-- Información de la materia --}}
                    <div class="text-center sm:text-left">
                        <h1 class="text-lg sm:text-2xl font-bold text-gray-900">{{ $cupofInfo->materia_nombre }}</h1>
                        <p class="text-sm sm:text-base text-gray-600">
                            {{ $cupofInfo->ano }}° {{ $cupofInfo->division }} - {{ $cupofInfo->grupo_nombre }}
                            (Turno
                            {{ ucfirst($cupofInfo->turno === 'M' ? 'Mañana' : ($cupofInfo->turno === 'T' ? 'Tarde' : 'Noche')) }})
                        </p>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="text-center sm:text-right">
                    <div class="text-sm text-gray-500">
                        <div>{{ now()->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de estudiantes --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Lista de Estudiantes</h2>
                <p class="text-sm text-gray-600 mt-1">Marque la asistencia para cada estudiante</p>
            </div>

            @if ($alumnos && count($alumnos) > 0)
                {{-- Vista de tabla para pantallas medianas y grandes --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Apellido y Nombre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Asistencia
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Justificado
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($alumnos as $index => $alumno)
                                <tr class="hover:bg-gray-50" data-asignacion="{{ $alumno->asignacion_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2">
                                            {{-- Presente --}}
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="asistencia_{{ $alumno->asignacion_id }}"
                                                    value="P"
                                                    class="form-radio h-4 w-4 text-green-600 transition duration-150 ease-in-out"
                                                    {{ $alumno->estado_asistencia === 'P' ? 'checked' : '' }}>
                                                <span class="ml-1 text-sm text-green-600 font-medium">P</span>
                                            </label>

                                            {{-- Ausente --}}
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="asistencia_{{ $alumno->asignacion_id }}"
                                                    value="A"
                                                    class="form-radio h-4 w-4 text-red-600 transition duration-150 ease-in-out"
                                                    {{ $alumno->estado_asistencia === 'A' ? 'checked' : '' }}>
                                                <span class="ml-1 text-sm text-red-600 font-medium">A</span>
                                            </label>

                                            {{-- Tardanza (cuenta como media ausencia) --}}
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="asistencia_{{ $alumno->asignacion_id }}"
                                                    value="T"
                                                    class="form-radio h-4 w-4 text-yellow-600 transition duration-150 ease-in-out"
                                                    {{ $alumno->estado_asistencia === 'T' ? 'checked' : '' }}>
                                                <span class="ml-1 text-sm text-yellow-600 font-medium">T</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" id="justificado_{{ $alumno->asignacion_id }}"
                                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                                {{ $alumno->justificado === '1' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700">Justificado</span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista de cards para móviles --}}
                <div class="md:hidden space-y-3 p-4">
                    @foreach ($alumnos as $index => $alumno)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm"
                            data-asignacion="{{ $alumno->asignacion_id }}">
                            {{-- Header del estudiante --}}
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                    </h3>
                                    <p class="text-xs text-gray-500">#{{ $index + 1 }}</p>
                                </div>
                            </div>

                            {{-- Controles de asistencia --}}
                            <div class="space-y-3">
                                {{-- Botones de asistencia --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-2">Estado de
                                        Asistencia</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        {{-- Presente --}}
                                        <label
                                            class="flex flex-col items-center p-2 border-2 rounded-lg cursor-pointer transition-colors {{ $alumno->estado_asistencia === 'P' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                                            <input type="radio" name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                value="P" class="sr-only"
                                                {{ $alumno->estado_asistencia === 'P' ? 'checked' : '' }}>
                                            <i class="fas fa-check text-green-600 mb-1"></i>
                                            <span class="text-xs font-medium text-green-600">Presente</span>
                                        </label>

                                        {{-- Ausente --}}
                                        <label
                                            class="flex flex-col items-center p-2 border-2 rounded-lg cursor-pointer transition-colors {{ $alumno->estado_asistencia === 'A' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300' }}">
                                            <input type="radio" name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                value="A" class="sr-only"
                                                {{ $alumno->estado_asistencia === 'A' ? 'checked' : '' }}>
                                            <i class="fas fa-times text-red-600 mb-1"></i>
                                            <span class="text-xs font-medium text-red-600">Ausente</span>
                                        </label>

                                        {{-- Tardanza (cuenta como media ausencia) --}}
                                        <label
                                            class="flex flex-col items-center p-2 border-2 rounded-lg cursor-pointer transition-colors {{ $alumno->estado_asistencia === 'T' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300' }}">
                                            <input type="radio" name="asistencia_mobile_{{ $alumno->asignacion_id }}"
                                                value="T" class="sr-only"
                                                {{ $alumno->estado_asistencia === 'T' ? 'checked' : '' }}>
                                            <i class="fas fa-clock text-yellow-600 mb-1"></i>
                                            <span class="text-xs font-medium text-yellow-600">Tardanza</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Checkbox justificado --}}
                                <div class="flex items-center justify-center">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="justificado_{{ $alumno->asignacion_id }}"
                                            class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                            {{ $alumno->justificado === '1' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Justificado</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Botones de acción --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                        <div class="text-sm text-gray-500">
                            Total de estudiantes: {{ count($alumnos) }}
                        </div>

                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            {{-- Botones de acción rápida --}}
                            <button type="button" onclick="marcarTodos('P')"
                                class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-green-50 hover:border-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-check mr-1 text-green-600"></i>
                                Todos Presentes
                            </button>

                            {{-- Botón guardar --}}
                            <button type="button" id="guardar-asistencias" onclick="guardarAsistencias()"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Guardar Asistencias
                            </button>
                        </div>
                    </div>
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-12">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
                        <i class="fas fa-users text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay estudiantes</h3>
                    <p class="mt-2 text-gray-500">
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

            // Estrategia: marcar solo los radios visibles para evitar conflictos
            // Desktop: buscar en .hidden.md:block
            // Mobile: buscar en .md:hidden

            // Determinar qué vista está activa
            const isDesktopView = window.innerWidth >= 768; // md breakpoint
            console.log('Vista detectada:', isDesktopView ? 'Desktop' : 'Mobile');

            if (isDesktopView) {
                // Vista desktop - marcar solo radios desktop
                const radiosDesktop = document.querySelectorAll(
                    `.hidden.md\\:block input[type="radio"][value="${estado}"]`);
                console.log('Radios desktop encontrados:', radiosDesktop.length);

                radiosDesktop.forEach((radio, index) => {
                    radio.checked = true;
                    console.log(`Marcado radio desktop ${index + 1}:`, radio.name);

                    // Disparar evento change
                    radio.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });
            } else {
                // Vista mobile - marcar solo radios mobile y actualizar visual
                const radiosMobile = document.querySelectorAll(`.md\\:hidden input[type="radio"][value="${estado}"]`);
                console.log('Radios mobile encontrados:', radiosMobile.length);

                radiosMobile.forEach((radio, index) => {
                    radio.checked = true;
                    console.log(`Marcado radio mobile ${index + 1}:`, radio.name);

                    // Actualizar visual del card mobile
                    updateMobileCardVisual(radio);

                    // Disparar evento change
                    radio.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });
            }

            console.log('marcarTodos completado');
        }

        // Función para verificar si hay asistencias existentes
        function verificarAsistenciasExistentes() {
            // Función eliminada - no mostrar mensaje de asistencias cargadas
        } // Función para actualizar el visual de los cards móviles
        function updateMobileCardVisual(radio) {
            const label = radio.closest('label');
            if (label) {
                // Remover clases activas de todos los hermanos
                const siblings = label.parentElement.querySelectorAll('label');
                siblings.forEach(sibling => {
                    sibling.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50',
                        'border-yellow-500', 'bg-yellow-50');
                    sibling.classList.add('border-gray-200');
                });

                // Agregar clases activas al seleccionado
                if (radio.checked) {
                    label.classList.remove('border-gray-200');
                    if (radio.value === 'P') {
                        label.classList.add('border-green-500', 'bg-green-50');
                    } else if (radio.value === 'A') {
                        label.classList.add('border-red-500', 'bg-red-50');
                    } else if (radio.value === 'T') {
                        label.classList.add('border-yellow-500', 'bg-yellow-50');
                    }
                }
            }
        }

        // Función para guardar asistencias
        async function guardarAsistencias() {
            const asistencias = [];
            const filas = document.querySelectorAll('[data-asignacion]');

            filas.forEach(elemento => {
                const asignacionId = elemento.dataset.asignacion;

                // Buscar radio marcado en desktop o mobile
                let estadoRadio = elemento.querySelector(`input[name="asistencia_${asignacionId}"]:checked`);
                if (!estadoRadio) {
                    // Si no encontró en desktop, buscar en mobile
                    estadoRadio = document.querySelector(
                        `input[name="asistencia_mobile_${asignacionId}"]:checked`);
                }

                const justificadoCheckbox = elemento.querySelector(`#justificado_${asignacionId}`);

                if (estadoRadio) {
                    asistencias.push({
                        asignacion_id: parseInt(asignacionId),
                        estado: estadoRadio.value,
                        justificado: justificadoCheckbox ? justificadoCheckbox.checked : false
                    });
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

                const response = await fetch('/profesores/asistencias/guardar', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

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
                console.error('Error al guardar asistencias:', error);
                mostrarMensaje('Error al guardar las asistencias: ' + error.message, 'error');
            } finally {
                // Restaurar botón
                botonGuardar.disabled = false;
                botonGuardar.innerHTML = '<i class="fas fa-save mr-2"></i>Guardar Asistencias';
            }
        }

        // Función para mostrar mensajes
        function mostrarMensaje(mensaje, tipo) {
            let alertClass, iconClass;

            switch (tipo) {
                case 'success':
                    alertClass = 'bg-green-100 border-green-400 text-green-700';
                    iconClass = 'fas fa-check-circle';
                    break;
                case 'error':
                    alertClass = 'bg-red-100 border-red-400 text-red-700';
                    iconClass = 'fas fa-exclamation-circle';
                    break;
                case 'info':
                    alertClass = 'bg-blue-100 border-blue-400 text-blue-700';
                    iconClass = 'fas fa-info-circle';
                    break;
                default:
                    alertClass = 'bg-gray-100 border-gray-400 text-gray-700';
                    iconClass = 'fas fa-info-circle';
            }

            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 z-50 ${alertClass} border px-4 py-3 rounded max-w-sm shadow-lg`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="${iconClass} mr-2"></i>
                    <span>${mensaje}</span>
                </div>
            `;

            document.body.appendChild(alertDiv);

            // Remover después de 3 segundos
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
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

                    // Si es un radio mobile, actualizar visual
                    if (event.target.name.includes('mobile')) {
                        updateMobileCardVisual(event.target);
                    }
                }
            });

            // Verificar si hay asistencias ya cargadas para hoy
            verificarAsistenciasExistentes();

            // Debug: Contar radios en cada vista
            const allRadios = document.querySelectorAll('input[type="radio"]');
            const mobileRadios = document.querySelectorAll('.md\\:hidden input[type="radio"]');
            const desktopRadios = document.querySelectorAll('.hidden.md\\:block input[type="radio"]');

            console.log('Total de radios encontrados:', allRadios.length);
            console.log('Radios mobile encontrados:', mobileRadios.length);
            console.log('Radios desktop encontrados:', desktopRadios.length);

            // Verificar estructura de HTML
            console.log('Contenedores desktop encontrados:', document.querySelectorAll('.hidden.md\\:block')
                .length);
            console.log('Contenedores mobile encontrados:', document.querySelectorAll('.md\\:hidden').length);

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

                    const justificado = elemento.querySelector(`#justificado_${asignacionId}`);

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

            console.log('Inicialización completada. Funciones disponibles:');
            console.log('- testMarcarTodos(): Prueba marcar todos como presentes');
            console.log('- verificarRadios(): Muestra el estado de todos los radios');
            console.log('- testCSRF(): Prueba la funcionalidad CSRF');
        });
    </script>
</x-layouts.profesores.dashboard>
