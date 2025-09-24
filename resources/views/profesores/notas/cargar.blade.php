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
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="h5 mb-1">Lista de Estudiantes</h2>
                            <p class="text-muted mb-0">Ingrese las notas para cada estudiante</p>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
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
                                            <th scope="col" class="text-center">Nota Final</th>
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
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][5]"
                                                        value="{{ $alumno['nota_periodo_5'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 70px; margin: 0 auto;" min="1"
                                                        max="10" step="0.1">
                                                </td>
                                                <td class="text-center">
                                                    <span id="estado-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-light">
                                                        <i class="feather icon-minus mr-1"></i>Ausente
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

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="form-label small">Nota Final</label>
                                                    <input type="number"
                                                        name="notas[{{ $alumno['asignacion_id'] }}][5]"
                                                        value="{{ $alumno['nota_periodo_5'] ?? '' }}"
                                                        class="form-control form-control-sm text-center"
                                                        min="1" max="10" step="0.1">
                                                </div>
                                            </div>

                                            <div
                                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                                <div class="text-center">
                                                    <small class="text-muted">Estado</small>
                                                    <div id="estado-mobile-{{ $alumno['asignacion_id'] }}"
                                                        class="badge badge-light mt-1">
                                                        <i class="feather icon-minus mr-1"></i>Ausente
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

        // Función para calcular el estado basado en la nota final o promedio de cuatrimestres
        function calcularEstado(asignacionId) {
            console.log('Calculando estado para asignación:', asignacionId);

            const notaFinalInput = document.querySelector(`input[name="notas[${asignacionId}][5]"]`);
            const notaPrimerCuatrimestreInput = document.querySelector(`input[name="notas[${asignacionId}][2]"]`);
            const notaSegundoCuatrimestreInput = document.querySelector(`input[name="notas[${asignacionId}][4]"]`);

            const notaFinal = parseFloat(notaFinalInput ? notaFinalInput.value : 0);
            const notaPrimerCuatrimestre = parseFloat(notaPrimerCuatrimestreInput ? notaPrimerCuatrimestreInput.value : 0);
            const notaSegundoCuatrimestre = parseFloat(notaSegundoCuatrimestreInput ? notaSegundoCuatrimestreInput.value : 0);

            let estado = 'Ausente';
            let claseEstado = 'badge badge-light';
            let iconoEstado = 'feather icon-minus';
            let notaParaEvaluar = 0;

            // Prioridad: Nota Final > Promedio de Cuatrimestres
            if (!isNaN(notaFinal) && notaFinal >= 1 && notaFinal <= 10) {
                // Si hay nota final, usar esa
                notaParaEvaluar = notaFinal;
            } else if (!isNaN(notaPrimerCuatrimestre) && notaPrimerCuatrimestre >= 1 && notaPrimerCuatrimestre <= 10 &&
                       !isNaN(notaSegundoCuatrimestre) && notaSegundoCuatrimestre >= 1 && notaSegundoCuatrimestre <= 10) {
                // Si hay ambas notas de cuatrimestres, calcular promedio
                notaParaEvaluar = (notaPrimerCuatrimestre + notaSegundoCuatrimestre) / 2;
            } else if (!isNaN(notaPrimerCuatrimestre) && notaPrimerCuatrimestre >= 1 && notaPrimerCuatrimestre <= 10) {
                // Solo primer cuatrimestre
                notaParaEvaluar = notaPrimerCuatrimestre;
            } else if (!isNaN(notaSegundoCuatrimestre) && notaSegundoCuatrimestre >= 1 && notaSegundoCuatrimestre <= 10) {
                // Solo segundo cuatrimestre
                notaParaEvaluar = notaSegundoCuatrimestre;
            }

            // Determinar el estado basado en la nota
            if (notaParaEvaluar > 0) {
                if (notaParaEvaluar >= 7) {
                    estado = 'TEA(Aprobado)';
                    claseEstado = 'badge badge-success';
                    iconoEstado = 'feather icon-check-circle';
                } else if (notaParaEvaluar >= 4) {
                    estado = 'TEP(En Proceso)';
                    claseEstado = 'badge badge-warning';
                    iconoEstado = 'feather icon-alert-triangle';
                } else {
                    estado = 'TED(Desaprobado)';
                    claseEstado = 'badge badge-danger';
                    iconoEstado = 'feather icon-x-circle';
                }
            }

            // Actualizar estado en vista desktop
            const spanEstado = document.getElementById(`estado-${asignacionId}`);
            if (spanEstado) {
                spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                spanEstado.className = claseEstado;
            }

            // Actualizar estado en vista móvil
            const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);
            if (estadoMobile) {
                estadoMobile.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                estadoMobile.className = claseEstado;
            }
        }

        // Función para actualizar el dashboard de estadísticas
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

            const totalEstudiantes = document.querySelectorAll('[id^="estado-"]:not([id*="mobile"])').length;
            let totalConNotas = 0;
            let sumaNotasFinales = 0;
            let aprobados = 0;
            let desaprobados = 0;
            let enRiesgo = 0;
            let totalInputsLlenos = 0;
            let totalInputs = 0;

            // Recorrer todos los estados (solo desktop para evitar duplicados)
            document.querySelectorAll('[id^="estado-"]:not([id*="mobile"])').forEach(span => {
                const texto = span.textContent;
                if (texto !== 'Ausente') {
                    totalConNotas++;
                    
                    // Buscar la nota final correspondiente
                    const asignacionId = span.id.replace('estado-', '');
                    const notaFinalInput = document.querySelector(`input[name="notas[${asignacionId}][5]"]`);
                    if (notaFinalInput && notaFinalInput.value) {
                        const notaFinal = parseFloat(notaFinalInput.value);
                        if (!isNaN(notaFinal)) {
                            sumaNotasFinales += notaFinal;
                            
                            if (notaFinal >= 7) {
                        aprobados++;
                            } else if (notaFinal >= 4) {
                        enRiesgo++;
                    } else {
                        desaprobados++;
                            }
                        }
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
            const promedioGeneral = totalConNotas > 0 ? (sumaNotasFinales / totalConNotas).toFixed(1) : '0.0';
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

                document.querySelectorAll('[id^="estado-"]').forEach(estado => {
                    estado.innerHTML = '<i class="feather icon-minus mr-1"></i>Ausente';
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
            calcularEstado(asignacionId);
        }

        // Sistema de mensajes copiado de asistencias
        window.mostrarMensaje = function(mensaje, tipo) {
            // Limpiar mensajes anteriores
            const mensajesAnteriores = document.querySelectorAll('.mensaje-notas');
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
            alertDiv.className = `${alertClass} position-fixed mensaje-notas`;
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

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== INICIALIZANDO SISTEMA DE NOTAS ===');

            // Calcular estados iniciales
            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                @foreach ($alumnosConNotas as $alumno)
                    calcularEstado({{ $alumno['asignacion_id'] }});
                @endforeach
            @endif
        });

        // Actualizar estados cuando cambian los valores
        document.addEventListener('input', function(e) {
            if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
                const match = e.target.name.match(/notas\[(\d+)\]/);
                if (match) {
                    const asignacionId = parseInt(match[1]);
                    console.log('Input cambiado para asignación:', asignacionId, 'Valor:', e.target.value);
                    calcularEstado(asignacionId);
                }
            }
        });

        // Manejar envío de ambos formularios
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
                        let mensaje = '✅ Notas guardadas correctamente';
                        if (data.notas_nuevas > 0 && data.notas_actualizadas_eliminadas > 0) {
                            mensaje +=
                                ` (${data.notas_nuevas} nuevas, ${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                        } else if (data.notas_nuevas > 0) {
                            mensaje += ` (${data.notas_nuevas} notas nuevas)`;
                        } else if (data.notas_actualizadas_eliminadas > 0) {
                            mensaje += ` (${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                        }

                        mostrarMensaje(mensaje, 'success');

                        // Recargar la página después de un breve delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
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

    {{-- Estilos para la vista móvil --}}
    <style>
        .mobile-notas-container .card {
            transition: transform 0.2s ease-in-out;
        }

        .mobile-notas-container .card:hover {
            transform: translateY(-1px);
        }

        /* Mejoras para botones móviles */
        .gap-2>*+* {
            margin-left: 0.5rem;
        }

        @media (max-width: 767.98px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .card-header .d-flex>div:first-child {
                margin-bottom: 1rem;
            }

            .gap-2 {
                gap: 0.5rem;
            }

            /* Remover margin-left en móvil para botones */
            .gap-2>*+* {
                margin-left: 0;
            }

            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                line-height: 1.5;
                min-height: 32px;
                white-space: nowrap;
            }

            /* Asegurar que ambos botones tengan el mismo tamaño en móvil */
            .card-header .d-flex .btn {
                flex: 1;
                max-width: none;
            }
        }
    </style>
</x-layouts.profesores.dashboard>
