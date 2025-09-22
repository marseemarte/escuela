{{-- Vista para cargar notas de una materia específica --}}
<x-layouts.profesores.dashboard notas titulo="Cargar Notas">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12">
            {{-- Header con información de la materia --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            {{-- Botón de regreso --}}
                            <a href="{{ route('profesores.notas.index') }}"
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

            {{-- Formulario de Notas --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="h5 mb-1">Lista de Estudiantes</h2>
                            <p class="text-muted mb-0">Ingrese las notas para cada estudiante</p>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" onclick="limpiarFormulario()" class="btn btn-secondary btn-sm">
                                <i class="feather icon-trash-2 mr-1"></i> Limpiar Todo
                            </button>
                            {{-- Botón para Desktop --}}
                            <button type="submit" form="notasFormDesktop"
                                class="btn btn-primary btn-sm d-none d-md-inline-block">
                                <i class="feather icon-save mr-1"></i> Guardar Notas
                            </button>
                            {{-- Botón para Mobile --}}
                            <button type="submit" form="notasFormMobile" class="btn btn-primary btn-sm d-md-none">
                                <i class="feather icon-save mr-1"></i> Guardar Notas
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                        {{-- Vista Desktop --}}
                        <form id="notasFormDesktop" action="{{ route('profesores.notas.guardar') }}" method="POST"
                            class="d-none d-md-block">
                            @csrf
                            <input type="hidden" name="cupof" value="{{ $cupof }}">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Estudiante</th>
                                            <th scope="col" class="text-center">1° Informe</th>
                                            <th scope="col" class="text-center">1° Cuatrimestre</th>
                                            <th scope="col" class="text-center">2° Informe</th>
                                            <th scope="col" class="text-center">2° Cuatrimestre</th>
                                            <th scope="col" class="text-center">Promedio</th>
                                            <th scope="col" class="text-center">Estado</th>
                                            <th scope="col" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumnosConNotas as $alumno)
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold">
                                                        {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                                    </div>
                                                    <small class="text-muted">DNI: {{ $alumno['dni'] }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                        value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 70px; margin: 0 auto;" min="1"
                                                        max="10" step="0.1">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                        value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 70px; margin: 0 auto;" min="1"
                                                        max="10" step="0.1">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                        value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 70px; margin: 0 auto;" min="1"
                                                        max="10" step="0.1">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                                        value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 70px; margin: 0 auto;" min="1"
                                                        max="10" step="0.1">
                                                </td>
                                                <td class="text-center">
                                                    <span id="promedio-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-secondary">-</span>
                                                </td>
                                                <td class="text-center">
                                                    <span id="estado-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-light">
                                                        <i class="feather icon-minus mr-1"></i>Sin datos
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="feather icon-x"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        {{-- Vista Mobile --}}
                        <form id="notasFormMobile" action="{{ route('profesores.notas.guardar') }}" method="POST"
                            class="d-md-none">
                            @csrf
                            <input type="hidden" name="cupof" value="{{ $cupof }}">

                            <div class="mobile-notas-container">
                                @foreach ($alumnosConNotas as $alumno)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="card-title mb-1">
                                                        {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                                    </h6>
                                                    <small class="text-muted">DNI: {{ $alumno['dni'] }}</small>
                                                </div>
                                                <button type="button"
                                                    onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="feather icon-x"></i>
                                                </button>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small">1° Informe</label>
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                        value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        min="1" max="10" step="0.1">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small">1° Cuatrimestre</label>
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                        value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        min="1" max="10" step="0.1">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small">2° Informe</label>
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                        value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        min="1" max="10" step="0.1">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small">2° Cuatrimestre</label>
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                                        value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        min="1" max="10" step="0.1">
                                                </div>
                                            </div>

                                            <div
                                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                                <div class="text-center">
                                                    <small class="text-muted">Promedio</small>
                                                    <div id="promedio-mobile-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-secondary mt-1">-</div>
                                                </div>
                                                <div class="text-center">
                                                    <small class="text-muted">Estado</small>
                                                    <div id="estado-mobile-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-light mt-1">
                                                        <i class="feather icon-minus mr-1"></i>Sin datos
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                            <p class="text-muted">No hay estudiantes asignados a esta materia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales para el sistema de mensajes
        let mensajeTimeout;

        // Función para calcular el promedio de un alumno específico
        function calcularPromedio(asignacionId) {
            console.log('Calculando promedio para asignación:', asignacionId);

            const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
            const notas = [];

            inputs.forEach(input => {
                const valor = parseFloat(input.value);
                if (!isNaN(valor) && valor >= 1 && valor <= 10) {
                    notas.push(valor);
                }
            });

            let promedio = '-';
            let clasePromedio = 'badge badge-secondary';
            let estado = 'Sin datos';
            let claseEstado = 'badge badge-light';
            let iconoEstado = 'feather icon-minus';

            if (notas.length > 0) {
                const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
                promedio = promedioNum.toFixed(1);

                if (promedioNum >= 7) {
                    clasePromedio = 'badge badge-success';
                    estado = 'Aprobado';
                    claseEstado = 'badge badge-success';
                    iconoEstado = 'feather icon-check-circle';
                } else if (promedioNum >= 4) {
                    clasePromedio = 'badge badge-warning';
                    estado = 'En riesgo';
                    claseEstado = 'badge badge-warning';
                    iconoEstado = 'feather icon-alert-triangle';
                } else {
                    clasePromedio = 'badge badge-danger';
                    estado = 'Desaprobado';
                    claseEstado = 'badge badge-danger';
                    iconoEstado = 'feather icon-x-circle';
                }
            }

            // Actualizar promedio en vista desktop
            const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
            if (spanPromedio) {
                spanPromedio.textContent = promedio;
                spanPromedio.className = clasePromedio;
            }

            // Actualizar estado en vista desktop
            const spanEstado = document.getElementById(`estado-${asignacionId}`);
            if (spanEstado) {
                spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                spanEstado.className = claseEstado;
            }

            // Actualizar promedio en vista móvil
            const promedioMobile = document.getElementById(`promedio-mobile-${asignacionId}`);
            if (promedioMobile) {
                promedioMobile.textContent = promedio;
                promedioMobile.className = clasePromedio;
            }

            // Actualizar estado en vista móvil
            const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);
            if (estadoMobile) {
                estadoMobile.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                estadoMobile.className = claseEstado;
            }
        } // Función para actualizar el dashboard de estadísticas
        function actualizarDashboard() {
            cargarEstadisticas();
        }

        // Cargar estadísticas dinámicas
        function cargarEstadisticas() {
            const pathParts = window.location.pathname.split('/');
            const cupof = pathParts[pathParts.length - 1];

            if (!cupof || cupof === 'notas') return;

            fetch(`/profesores/notas/${cupof}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.estadisticas) {
                        actualizarEstadisticasDinamicas(data.estadisticas);
                    }
                })
                .catch(error => {
                    console.log('Error al cargar estadísticas, usando cálculo local:', error);
                    actualizarDashboardLocal();
                });
        }

        // Actualizar las estadísticas con datos del backend
        function actualizarEstadisticasDinamicas(stats) {
            console.log('Actualizando estadísticas:', stats);

            document.getElementById('total-estudiantes').textContent = stats.total_estudiantes || 0;
            document.getElementById('promedio-general').textContent = (stats.promedio_general || 0).toFixed(1);
            document.getElementById('total-desaprobados').textContent = stats.desaprobados || 0;
            document.getElementById('porcentaje-aprobacion').textContent = (stats.porcentaje_aprobacion || 0).toFixed(1) +
                '%';
            document.getElementById('contador-aprobados').textContent = stats.aprobados || 0;
            document.getElementById('contador-riesgo').textContent = stats.en_riesgo || 0;
            document.getElementById('contador-desaprobados-detalle').textContent = stats.desaprobados || 0;

            const textoProgreso = document.getElementById('progreso-texto');
            if (textoProgreso) {
                textoProgreso.textContent = `${stats.progreso_carga || 0}% completado`;
            }

            const barraProgreso = document.getElementById('barra-progreso');
            if (barraProgreso) {
                const progresoPorcentaje = stats.progreso_carga || 0;
                barraProgreso.style.width = progresoPorcentaje + '%';
                barraProgreso.setAttribute('aria-valuenow', progresoPorcentaje);
            }
        }

        // Función fallback para cálculo local de estadísticas
        function actualizarDashboardLocal() {
            console.log('Calculando estadísticas localmente');

            const totalEstudiantes = document.querySelectorAll('[id^="promedio-"]:not([id*="mobile"])').length;
            let totalConNotas = 0;
            let sumaPromedios = 0;
            let aprobados = 0;
            let desaprobados = 0;
            let enRiesgo = 0;
            let totalInputsLlenos = 0;
            let totalInputs = 0;

            // Recorrer todos los promedios (solo desktop para evitar duplicados)
            document.querySelectorAll('[id^="promedio-"]:not([id*="mobile"])').forEach(span => {
                const texto = span.textContent;
                if (texto !== '-') {
                    const promedio = parseFloat(texto);
                    totalConNotas++;
                    sumaPromedios += promedio;

                    if (promedio >= 7) {
                        aprobados++;
                    } else if (promedio >= 4) {
                        enRiesgo++;
                    } else {
                        desaprobados++;
                    }
                }
            });

            // Calcular progreso de carga
            document.querySelectorAll('#notasFormDesktop input[type="number"]').forEach(input => {
                totalInputs++;
                if (input.value && input.value.trim() !== '') {
                    totalInputsLlenos++;
                }
            });

            // Calcular métricas
            const promedioGeneral = totalConNotas > 0 ? (sumaPromedios / totalConNotas).toFixed(1) : '0.0';
            const porcentajeAprobacion = totalConNotas > 0 ? Math.round((aprobados / totalConNotas) * 100) : 0;
            const progresoPorcentaje = totalInputs > 0 ? Math.round((totalInputsLlenos / totalInputs) * 100) : 0;

            // Actualizar elementos del dashboard
            if (document.getElementById('total-estudiantes')) {
                document.getElementById('total-estudiantes').textContent = totalEstudiantes;
            }
            if (document.getElementById('promedio-general')) {
                document.getElementById('promedio-general').textContent = promedioGeneral;
            }
            if (document.getElementById('total-desaprobados')) {
                document.getElementById('total-desaprobados').textContent = desaprobados;
            }
            if (document.getElementById('porcentaje-aprobacion')) {
                document.getElementById('porcentaje-aprobacion').textContent = porcentajeAprobacion + '%';
            }
            if (document.getElementById('contador-aprobados')) {
                document.getElementById('contador-aprobados').textContent = aprobados;
            }
            if (document.getElementById('contador-riesgo')) {
                document.getElementById('contador-riesgo').textContent = enRiesgo;
            }
            if (document.getElementById('contador-desaprobados-detalle')) {
                document.getElementById('contador-desaprobados-detalle').textContent = desaprobados;
            }

            const textoProgreso = document.getElementById('progreso-texto');
            if (textoProgreso) {
                textoProgreso.textContent = `${progresoPorcentaje}% completado`;
            }

            const barraProgreso = document.getElementById('barra-progreso');
            if (barraProgreso) {
                barraProgreso.style.width = progresoPorcentaje + '%';
                barraProgreso.setAttribute('aria-valuenow', progresoPorcentaje);
            }
        }

        // Función para limpiar el formulario
        function limpiarFormulario() {
            if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                document.querySelectorAll('input[type="number"]').forEach(input => {
                    input.value = '';
                });

                document.querySelectorAll('[id^="promedio-"]').forEach(span => {
                    span.textContent = '-';
                    span.className = 'badge badge-secondary';
                });

                document.querySelectorAll('[id^="estado-"]').forEach(estado => {
                    estado.innerHTML = '<i class="feather icon-minus mr-1"></i>Sin datos';
                    estado.className = 'badge badge-light';
                });

                mostrarMensaje('Formulario limpiado correctamente', 'info');
            }
        }

        // Función para limpiar las notas de un alumno específico
        function limpiarFilaAlumno(asignacionId) {
            const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
            inputs.forEach(input => {
                input.value = '';
            });
            calcularPromedio(asignacionId);
        }

        // Sistema de mensajes mejorado para PCoded
        function mostrarMensaje(mensaje, tipo = 'info', duracion = 5000) {
            console.log('Mostrando mensaje:', mensaje, 'Tipo:', tipo);

            // Limpiar mensaje anterior si existe
            if (mensajeTimeout) {
                clearTimeout(mensajeTimeout);
            }

            // Remover mensajes existentes
            const mensajesExistentes = document.querySelectorAll('.mensaje-notas');
            mensajesExistentes.forEach(msg => msg.remove());

            let iconClass = 'feather icon-info';
            let alertClass = 'alert-info';
            let bgClass = 'bg-info';

            switch (tipo) {
                case 'success':
                    iconClass = 'feather icon-check-circle';
                    alertClass = 'alert-success';
                    bgClass = 'bg-success';
                    break;
                case 'error':
                    iconClass = 'feather icon-alert-triangle';
                    alertClass = 'alert-danger';
                    bgClass = 'bg-danger';
                    break;
                case 'warning':
                    iconClass = 'feather icon-alert-triangle';
                    alertClass = 'alert-warning';
                    bgClass = 'bg-warning';
                    break;
            }

            const mensajeDiv = document.createElement('div');
            mensajeDiv.className = `mensaje-notas alert ${alertClass} alert-dismissible fade show position-fixed`;
            mensajeDiv.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                border-radius: 8px;
                animation: slideInRight 0.3s ease-out;
            `;

            mensajeDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="${iconClass} mr-2" style="font-size: 1.2em;"></i>
                    <span class="flex-grow-1">${mensaje}</span>
                    <button type="button" class="close" onclick="cerrarMensaje(this)" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;

            document.body.appendChild(mensajeDiv);

            // Auto-cerrar después de la duración especificada
            mensajeTimeout = setTimeout(() => {
                if (mensajeDiv && mensajeDiv.parentNode) {
                    mensajeDiv.style.animation = 'slideOutRight 0.3s ease-in';
                    setTimeout(() => {
                        if (mensajeDiv.parentNode) {
                            mensajeDiv.remove();
                        }
                    }, 300);
                }
            }, duracion);
        }

        // Función para cerrar mensaje manualmente
        function cerrarMensaje(boton) {
            const mensaje = boton.closest('.mensaje-notas');
            if (mensaje) {
                mensaje.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => {
                    if (mensaje.parentNode) {
                        mensaje.remove();
                    }
                }, 300);
            }
            if (mensajeTimeout) {
                clearTimeout(mensajeTimeout);
            }
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== INICIALIZANDO SISTEMA DE NOTAS ===');

            // Calcular promedios iniciales
            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                @foreach ($alumnosConNotas as $alumno)
                    calcularPromedio({{ $alumno['asignacion_id'] }});
                @endforeach
            @endif
        });

        // Actualizar promedios cuando cambian los valores
        document.addEventListener('input', function(e) {
            if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
                const match = e.target.name.match(/notas\[(\d+)\]/);
                if (match) {
                    const asignacionId = parseInt(match[1]);
                    console.log('Input cambiado para asignación:', asignacionId, 'Valor:', e.target.value);
                    calcularPromedio(asignacionId);
                }
            }
        }); // Manejar envío de ambos formularios
        function handleFormSubmit(formElement, formName) {
            console.log(`=== FORMULARIO ${formName} ENVIADO ===`);
            console.log('Action URL:', formElement.action);
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').content);

            const formData = new FormData(formElement);

            // Log todos los datos del formulario
            console.log('Datos del formulario:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            mostrarMensaje('Guardando notas...', 'info', 10000);

            fetch(formElement.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        let mensaje = 'Cambios guardados correctamente';
                        if (data.notas_nuevas > 0 && data.notas_actualizadas_eliminadas > 0) {
                            mensaje +=
                                ` (${data.notas_nuevas} nuevas, ${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                        } else if (data.notas_nuevas > 0) {
                            mensaje += ` (${data.notas_nuevas} notas nuevas)`;
                        } else if (data.notas_actualizadas_eliminadas > 0) {
                            mensaje += ` (${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                        }
                        mostrarMensaje(mensaje, 'success', 3000);

                        // Recargar la página después de un breve delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    mostrarMensaje('Error de conexión: ' + error.message, 'error');
                });
        }

        // Formulario Desktop
        const desktopForm = document.getElementById('notasFormDesktop');
        if (desktopForm) {
            desktopForm.addEventListener('submit', function(e) {
                e.preventDefault();
                handleFormSubmit(this, 'DESKTOP');
            });
        }

        // Formulario Mobile
        const mobileForm = document.getElementById('notasFormMobile');
        if (mobileForm) {
            mobileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                handleFormSubmit(this, 'MOBILE');
            });
        }
    </script>

    {{-- Estilos para las animaciones de mensajes --}}
    <style>
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

        .mobile-notas-container .card {
            transition: transform 0.2s ease-in-out;
        }

        .mobile-notas-container .card:hover {
            transform: translateY(-1px);
        }
    </style>
</x-layouts.profesores.dashboard>
