{{-- Vista para corregir tareas de una materia específica --}}
<x-layouts.profesores.dashboard tareas titulo="Corregir Tarea">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12">
            {{-- Header con información de la tarea --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            {{-- Botón de regreso --}}
                            <a href="javascript:history.back()"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            {{-- Información de la tarea --}}
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">Corrección: {{ $tarea->titulo }}</h1>
                                <p class="text-muted mb-0">
                                    <strong>Materia:</strong> {{ $materia }} |
                                    <strong>Curso:</strong> {{ $curso }} |
                                    <strong>Fecha de entrega:</strong>
                                    {{ $tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : '-' }}
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

            {{-- Alertas --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="feather icon-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Estadísticas rápidas --}}
            @if ($entregas->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="feather icon-users mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-0">{{ $entregas->count() }}</h4>
                                <small>Total Estudiantes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="feather icon-check-circle mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-0">{{ $entregas->where('entrego', true)->count() }}</h4>
                                <small>Entregaron</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <i class="feather icon-x-circle mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-0">{{ $entregas->where('entrego', false)->count() }}</h4>
                                <small>No Entregaron</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabla de correcciones --}}
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-1">Corrección de Entregas</h2>
                    <p class="text-muted mb-0">Revise y califique las entregas de los estudiantes</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th  class="text-center" width="20%">Alumno</th>
                                <th  class="text-center" width="15%">Estado</th>
                                <th  class="text-center" width="20%">Respuesta</th>
                                <th  class="text-center" width="15%">Nota</th>
                                <th  class="text-center" width="20%">Devolución</th>
                                <th  class="text-center" width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entregas as $entrega)
                                <tr class="text-center {{ !$entrega['entrego'] ? 'table-danger' : '' }}">
                                    <td class="text-center">
                                        <strong>{{ $entrega['nombre_completo'] }}</strong>
                                        <br>
                                        <small class="text-muted">DNI: {{ $entrega['dni'] }}</small>
                                    </td>

                                    <td class="estado h6">
                                        @if ($entrega['entrego'])
                                            <span class="badge badge-success">
                                                <i class="feather icon-check-circle mr-1"></i>
                                                Entregado
                                            </span>
                                            @if ($entrega['fecha_entrega'])
                                                <br>
                                                <small class="text-muted">
                                                    {{ date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="feather icon-x-circle mr-1"></i>
                                                No entregó
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($entrega['entrego'])
                                            <a href="#" class="btn btn-link p-0" style="font-size: 0.8rem; font-weight: 500;"
                                                onclick="descargarRespuesta({{ $entrega['tarea_alumno_id'] }})">
                                                <i class="feather icon-download mr-1"></i>
                                                {{ $entrega['archivo'] }}
                                            </a>
                                        @else
                                            <span class="text-muted font-italic">Sin entrega</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($entrega['entrego'])
                                            <input type="number" min="1" max="10" step="0.01"
                                                value="{{ $entrega['nota'] ?? '' }}"
                                                class="form-control form-control-sm nota text-center"
                                                data-asignacion="{{ $entrega['asignacion_id'] }}"
                                                placeholder="ej: 7.25" style="width: 80px; margin: 0 auto;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($entrega['entrego'])
                                            <div class="form-group mb-0">
                                                <textarea rows="2" maxlength="200" class="form-control form-control-sm devolucion"
                                                    placeholder="Máximo 200 caracteres..." data-asignacion="{{ $entrega['asignacion_id'] }}"
                                                    oninput="actualizarContador(this)">{{ $entrega['devolucion'] ?? '' }}</textarea>
                                                <small class="contador text-muted">
                                                    {{ strlen($entrega['devolucion'] ?? '') }}/200
                                                </small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($entrega['entrego'])
                                            <!-- Botón Guardar (se muestra cuando NO tiene corrección) -->
                                            <button
                                                class="btn btn-sm btn-success guardar-btn {{ (bool) $entrega['tiene_nota'] ? 'd-none' : '' }}"
                                                data-asignacion="{{ $entrega['asignacion_id'] }}"
                                                onclick="guardarCorreccion(this)">
                                                <i class="feather icon-save mr-1"></i>
                                                Guardar
                                            </button>

                                            <!-- Botón Eliminar (se muestra cuando YA tiene corrección) -->
                                            <button
                                                class="btn btn-sm btn-danger eliminar-btn {{ (bool) $entrega['tiene_nota'] ? '' : 'd-none' }}"
                                                data-asignacion="{{ $entrega['asignacion_id'] }}"
                                                onclick="eliminarCorreccion(this)">
                                                <i class="feather icon-trash-2 mr-1"></i>
                                                Eliminar
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="feather icon-users" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3">No hay alumnos en este curso</h5>
                                            <p class="mb-0">No se encontraron alumnos asignados a este curso para el
                                                ciclo lectivo actual.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal Bootstrap para confirmar eliminación de corrección --}}
            <div class="modal fade" id="eliminarCorreccionModal" tabindex="-1" role="dialog"
                aria-labelledby="eliminarCorreccionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eliminarCorreccionModalLabel">Confirmar eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que quieres eliminar esta corrección? Esta acción no se puede deshacer.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger"
                                id="confirmarEliminarCorreccion">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mostrar mensaje si no hay entregas --}}
            @if ($entregas->count() > 0 && $entregas->where('entrego', true)->count() == 0)
                <div class="alert alert-warning mt-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="feather icon-alert-triangle mr-2"></i>
                        <div>
                            <strong>Sin respuestas:</strong> Ningún alumno ha entregado respuesta para esta tarea aún.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

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
                guardarBtn.classList.add('d-none');
                eliminarBtn.classList.remove('d-none');
            } else {
                guardarBtn.classList.remove('d-none');
                eliminarBtn.classList.add('d-none');
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
                mostrarMensaje('error', 'Por favor ingresa una nota válida (entre 1 y 10)');
                return;
            }

            // Deshabilitar botón
            button.disabled = true;
            const originalIcon = button.querySelector('i').className;
            button.innerHTML = '<i class="feather icon-loader"></i> Guardando...';

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
                button.innerHTML = `<${originalIcon} mr-1></i> Guardar`;
            }
        }

        // Variable global para almacenar la asignación a eliminar
        let asignacionAEliminar = null;

        // Función para mostrar modal de confirmación
        function eliminarCorreccion(button) {
            asignacionAEliminar = button.getAttribute('data-asignacion');
            $('#eliminarCorreccionModal').modal('show');
        }

        // Función para ejecutar la eliminación
        async function ejecutarEliminacion() {
            const confirmarBtn = document.getElementById('confirmarEliminarCorreccion');

            // Deshabilitar botón
            confirmarBtn.disabled = true;
            confirmarBtn.innerHTML = '<i class="feather icon-loader"></i> Eliminando...';

            try {
                const response = await fetch('{{ route('profesores.tareas.eliminar-correccion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        asignacion_id: asignacionAEliminar,
                        tarea_id: {{ $tarea->id }}
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Cerrar modal
                    $('#eliminarCorreccionModal').modal('hide');

                    // Mostrar mensaje de éxito
                    mostrarMensaje('success', data.message);

                    // Limpiar inputs
                    limpiarInputs(asignacionAEliminar);

                    // Cambiar a botón guardar
                    alternarBotones(asignacionAEliminar, false);
                } else {
                    mostrarMensaje('error', data.message || 'Error al eliminar la corrección');
                    $('#eliminarCorreccionModal').modal('hide');
                }

            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('error', 'Error de conexión. Inténtalo nuevamente.');
                $('#eliminarCorreccionModal').modal('hide');
            } finally {
                // Restaurar botón
                confirmarBtn.disabled = false;
                confirmarBtn.innerHTML = '<i class="feather icon-trash-2 mr-1"></i> Eliminar';
                asignacionAEliminar = null;
            }
        }

        // Configurar eventos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar botón de confirmación de eliminación
            document.getElementById('confirmarEliminarCorreccion').addEventListener('click', ejecutarEliminacion);
        });

        // Función para mostrar mensajes
        function mostrarMensaje(tipo, mensaje) {
            // Remover alertas existentes
            const alertasExistentes = document.querySelectorAll('.alert:not(.alert-permanent)');
            alertasExistentes.forEach(alerta => alerta.remove());

            // Crear nueva alerta
            const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = tipo === 'success' ? 'check-circle' : 'alert-circle';

            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show`;
            alert.innerHTML = `
                <i class="feather icon-${iconClass} mr-2"></i>
                ${mensaje}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;

            // Insertar después del header
            const header = document.querySelector('.card:first-of-type');
            header.insertAdjacentElement('afterend', alert);

            // Auto eliminar después de 5s
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    $(alert).alert('close');
                }
            }, 5000);
        }

        // Función para descargar respuesta del alumno
        function descargarRespuesta(tareaAlumnoId) {
            if (tareaAlumnoId) {
                window.location.href = `{{ url('/profesores/tareas/alumno') }}/${tareaAlumnoId}/descargar`;
            } else {
                mostrarMensaje('error', 'Error: No se puede descargar el archivo');
            }
        }
    </script>

</x-layouts.profesores.dashboard>
