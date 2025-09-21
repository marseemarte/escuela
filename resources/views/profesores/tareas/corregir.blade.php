<x-layouts.profesores.dashboard titulo="Corregir Tarea">
        <!-- Botón volver -->
    <a href="javascript:history.back()" 
       class="mb-4 inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 cursor-pointer">
        ← Volver
    </a>
    <!-- Título y descripción -->
    <h1 class="text-2xl font-semibold mb-2">Corrección de: {{ $tarea->titulo }}</h1>
    <p class="mb-4 text-gray-600">
        <strong>Materia:</strong> {{ $materia }} | 
        <strong>Curso:</strong> {{ $curso }} | 
        <strong>Fecha de entrega:</strong> {{ $tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : '-' }}
    </p>
    <p class="mb-6 text-gray-600">Aquí podrás revisar y corregir las respuestas de los alumnos.</p>

    @if(session('success'))
        <div id="alert-success" 
            class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif


    <!-- Estadísticas rápidas -->
    @if($entregas->count() > 0)
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800">Total Alumnos</h3>
                <p class="text-2xl font-bold text-blue-900">{{ $entregas->count() }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800">Entregaron</h3>
                <p class="text-2xl font-bold text-green-900">{{ $entregas->where('entrego', true)->count() }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <h3 class="font-semibold text-red-800">No entregaron</h3>
                <p class="text-2xl font-bold text-red-900">{{ $entregas->where('entrego', false)->count() }}</p>
            </div>
        </div>
    @endif

    <!-- Tabla de alumnos -->
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-600 table-fixed">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 w-1/6">Alumno</th>
                    <th class="px-6 py-3 w-1/6">Estado</th>
                    <th class="px-6 py-3 w-2/6">Respuesta</th>
                    <th class="px-6 py-3 w-1/6">Nota</th>
                    <th class="px-6 py-3 w-2/6">Devolución</th>
                    <th class="px-6 py-3 w-1/6">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entregas as $entrega)
                    <tr class="bg-white border-b hover:bg-gray-50 {{ !$entrega['entrego'] ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $entrega['nombre_completo'] }}
                            <br>
                            <small class="text-gray-500">DNI: {{ $entrega['dni'] }}</small>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($entrega['entrego'])
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Entregado
                                </span>
                                @if($entrega['fecha_entrega'])
                                    <br>
                                    <small class="text-gray-500">
                                        {{ date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) }}
                                    </small>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    No entregó
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($entrega['entrego'])
                                <a href="#" class="text-blue-600 hover:underline cursor-pointer" 
                                   onclick="descargarRespuesta({{ $entrega['tarea_alumno_id'] }})">
                                    📄 {{ $entrega['archivo'] }}
                                </a>
                            @else
                                <span class="text-gray-400 italic">Sin entrega</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($entrega['entrego'])
                                <input type="number" 
                                       min="1" 
                                       max="10" 
                                       step="0.01"
                                       value="{{ $entrega['nota'] ?? '' }}"
                                       class="nota w-20 border rounded px-2 py-1 text-center"
                                       data-asignacion="{{ $entrega['asignacion_id'] }}"
                                       placeholder="ej: 7.25">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($entrega['entrego'])
                                <div class="flex flex-col">
                                    <textarea rows="2" 
                                            maxlength="200" 
                                            class="devolucion w-full border rounded px-2 py-1 resize-none" 
                                            placeholder="Máximo 200 caracteres..."
                                            data-asignacion="{{ $entrega['asignacion_id'] }}"
                                            oninput="actualizarContador(this)">{{ $entrega['devolucion'] ?? '' }}</textarea>
                                    <small class="contador text-gray-500 text-right">
                                        {{ strlen($entrega['devolucion'] ?? '') }}/200
                                    </small>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($entrega['entrego'])
                                <!-- Botón Guardar (se muestra cuando NO tiene corrección) -->
                                <button class="guardar-btn px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 cursor-pointer {{ (bool)$entrega['tiene_nota'] ? 'hidden' : '' }}"
                                        data-asignacion="{{ $entrega['asignacion_id'] }}"
                                        onclick="guardarCorreccion(this)">
                                    Guardar
                                </button>
                                
                                <!-- Botón Eliminar (se muestra cuando YA tiene corrección) -->
                                <button class="eliminar-btn px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 disabled:opacity-50 cursor-pointer {{ (bool)$entrega['tiene_nota'] ? '' : 'hidden' }}"
                                        data-asignacion="{{ $entrega['asignacion_id'] }}"
                                        onclick="eliminarCorreccion(this)">
                                    Eliminar
                                </button>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No hay alumnos en este curso</h3>
                                <p class="mt-1 text-gray-500">No se encontraron alumnos asignados a este curso para el ciclo lectivo actual.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

<!-- Modal para confirmar eliminación de corrección -->
        <div id="eliminarCorreccionModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 relative transform transition-all duration-300 scale-95 opacity-0">
            <button id="closeEliminarCorreccionModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 cursor-pointer">✕</button>
            <h2 class="text-xl font-semibold mb-4">Confirmar eliminación</h2>
            <p class="mb-6 text-gray-700">¿Estás seguro de que quieres eliminar esta corrección? Esta acción no se puede deshacer.</p>
            <div class="flex justify-end gap-2">
                <button id="cancelEliminarCorreccion" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 cursor-pointer">Cancelar</button>
                <button id="confirmarEliminarCorreccion" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 cursor-pointer">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Mostrar mensaje si no hay entregas -->
    @if($entregas->count() > 0 && $entregas->where('entrego', true)->count() == 0)
        <div class="mt-6 bg-yellow-100 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Sin respuestas:</strong> Ningún alumno ha entregado respuesta para esta tarea aún.
                    </p>
                </div>
            </div>
        </div>
    @endif

<script>
    // Función para actualizar contador de caracteres
    function actualizarContador(textarea) {
        const contador = textarea.parentElement.querySelector('.contador');
        contador.textContent = textarea.value.length + '/200';
    }

    // Validación de notas (permitir hasta 2 decimales)
    document.addEventListener("DOMContentLoaded", function () {
        const notas = document.querySelectorAll(".nota");

        notas.forEach(input => {
            input.addEventListener("input", function () {
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
            const response = await fetch('{{ route("profesores.tareas.guardar-correccion") }}', {
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

    // NUEVA FUNCIÓN: Eliminar corrección con modal
    async function eliminarCorreccion(button) {
        const asignacionId = button.getAttribute('data-asignacion');
        
        // Mostrar modal de confirmación
        const modal = document.getElementById('eliminarCorreccionModal');
        const modalContent = modal.querySelector('.bg-white');
        
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
            const response = await fetch('{{ route("profesores.tareas.eliminar-correccion") }}', {
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
        const modalContent = modal.querySelector('.bg-white');
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

    // Función para mostrar mensajes (sin cambios)
    function mostrarMensaje(tipo, mensaje) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `mb-4 p-4 border rounded transition-opacity duration-500 ${
            tipo === 'success' 
                ? 'bg-green-100 border-green-300 text-green-700' 
                : 'bg-red-100 border-red-300 text-red-700'
        }`;
        alertDiv.textContent = mensaje;

        // Insertar al inicio
        const mainContent = document.querySelector('h1').parentElement;
        mainContent.insertBefore(alertDiv, mainContent.children[2]); // Después de la descripción

        // Auto-ocultar después de 3 segundos
        setTimeout(() => {
            alertDiv.style.opacity = '0';
            setTimeout(() => alertDiv.remove(), 500);
        }, 3000);
    }

    // Función para descargar respuesta del alumno (sin cambios)
    function descargarRespuesta(tareaAlumnoId) {
        if(tareaAlumnoId) {
            window.location.href = `{{ url('/profesores/tareas/alumno') }}/${tareaAlumnoId}/descargar`;
        } else {
            alert('Error: No se puede descargar el archivo');
        }
    }

    // Auto-ocultar alerta de éxito si existe (sin cambios)
    const alertSuccess = document.getElementById('alert-success');
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.opacity = '0';
            setTimeout(() => alertSuccess.remove(), 500);
        }, 3000);
    }
</script>

</x-layouts.profesores.dashboard>