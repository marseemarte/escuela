
<x-layouts.profesores.dashboard titulo="Tareas"> 
    <h1 class="text-2xl font-semibold mb-2">{{ $cursos[0]['materia'] }} - {{ $cursos[0]['nombre'] }}</h1>
    <p class="mb-6 text-gray-600">Gestiona las tareas de la materia {{ $cursos[0]['materia'] }} del curso {{ $cursos[0]['nombre'] }}.  
        Aquí puedes subir modulos de teoria, tareas con fecha de entrega y hacer el seguimiento de respuestas.</p>

    @if(session('success'))
        <div id="alert-success" 
            class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif


    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Botón para subir nueva tarea -->
    <button class="btn btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg shadow mb-3 cursor-pointer" id="openModalBtn">
        + Subir nuevo archivo
    </button>

    <!-- Modal para subir tareas--> 
    <div id="tareaModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div id="tareaModalContent" 
           class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative transform transition-all duration-300 scale-95 opacity-0">

        <!-- Botón cerrar -->
        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 cursor-pointer">
          ✕
        </button>

        <!-- Pantalla de selección -->
        <div id="modalSeleccion" class="text-center">
          <h2 class="text-xl font-semibold mb-6">¿Qué deseas subir?</h2>
          <div class="flex flex-col gap-3">
            <button id="btnModulo" class="px-4 py-2 rounded bg-indigo-500 text-white hover:bg-indigo-600 cursor-pointer">
              📘 Módulo de teoría
            </button>
            <button id="btnTarea" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 cursor-pointer">
              📝 Tarea con fecha de entrega
            </button>
          </div>
        </div>

        <!-- Formulario (oculto por defecto) -->
        <div id="modalFormulario" class="hidden">
          <h2 id="formTitulo" class="text-xl font-semibold mb-4"></h2>

          <form method="POST" action="{{ route('tareas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Nombre</label>
              <input type="text" name="nombre"
                     class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                     required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
              <textarea name="descripcion"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                        rows="3"></textarea>
            </div>

            <input type="hidden" name="cupof" value="{{ $cursos[0]['id'] ?? $cupof }}">

            <!-- Campo fecha de entrega (solo para tarea) -->
            <div id="fechaEntrega" class="mb-4 hidden">
              <label class="block text-sm font-medium text-gray-700">Fecha de entrega</label>
              <input type="date" name="fecha_entrega"
                     class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                     min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <!-- Archivo -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Archivo (máx. 10MB)</label>
              <div class="flex border rounded items-center overflow-hidden">
                <label for="archivo"
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 cursor-pointer border-l">
                  Elegir archivo
                </label>
                <span id="archivoNombre" class="flex-1 px-3 py-2 text-gray-600 text-sm">
                  No se ha seleccionado ningún archivo
                </span>
                <input type="file" name="archivo" id="archivo" class="hidden" required
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png">
              </div>
            </div>

            <!-- Boton Cerrar y Subir -->
            <div class="flex justify-end space-x-2">
              <button type="button" id="cancelModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 cursor-pointer">
                Cancelar
              </button>
              <button type="submit" id="btnSubir" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 cursor-pointer">
                Subir
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mb-4">
        <nav class="flex space-x-2">
            <button id="tabModulos" 
                    class="tab-button px-4 py-2 rounded-t-lg font-medium border-none cursor-pointer transition-all duration-200">
                Módulos de teoría
            </button>
            <button id="tabTareas" 
                    class="tab-button px-4 py-2 rounded-t-lg font-medium border-none cursor-pointer transition-all duration-200">
                Tareas con fecha de entrega
            </button>
        </nav>
    </div>

    <!-- Sección Módulos de teoría -->
    <div id="modulosSection" class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-600 table-fixed">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Materia</th>
                    <th class="px-6 py-3">Curso</th>
                    <th class="px-6 py-3">Fecha de subida</th>
                    <th class="px-6 py-3">Archivo</th>
                    <th class="px-6 py-3">Vistos</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modulos as $modulo)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $modulo['titulo'] }}</td>
                        <td class="px-6 py-4">{{ $modulo['materia'] }}</td>
                        <td class="px-6 py-4">{{ $modulo['curso'] }}</td>
                        <td class="px-6 py-4">{{ $modulo['fecha_subida'] }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('profesores.tareas.descargar', $modulo['id']) }}" 
                               class="text-blue-600 hover:underline">
                                {{ $modulo['archivo'] }}
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $modulo['vistos'] }}</td>
                        <td class="px-6 py-4">
                            <button class="text-green-600 hover:underline seguimientoBtn mr-2 cursor-pointer" 
                                    data-tarea-id="{{ $modulo['id'] }}">
                                Seguimiento
                            </button>
                            <button class="text-red-600 hover:underline eliminarBtn cursor-pointer" 
                                    data-tarea-id="{{ $modulo['id'] }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-gray-500 italic">
                            No hay módulos subidos aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Sección Tareas con fecha de entrega -->
    <div id="tareasSection" class="overflow-x-auto shadow-md sm:rounded-lg hidden">
        <table class="w-full text-sm text-center text-gray-600 table-fixed">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Materia</th>
                    <th class="px-6 py-3">Curso</th>
                    <th class="px-6 py-3">Fecha de Subida</th>
                    <th class="px-6 py-3">Fecha de entrega</th>
                    <th class="px-6 py-3">Archivo</th>
                    <th class="px-6 py-3">Entregas</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $tarea['titulo'] }}</td>
                        <td class="px-6 py-4">{{ $tarea['materia'] }}</td>
                        <td class="px-6 py-4">{{ $tarea['curso'] }}</td>
                        <td class="px-6 py-4">{{ $tarea['fecha_subida'] }}</td>
                        <td class="px-6 py-4">
                            <span class="@if(strtotime($tarea['fecha_entrega']) < time()) text-red-600 font-semibold @endif">
                                {{ $tarea['fecha_entrega'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('profesores.tareas.descargar', $tarea['id']) }}" 
                               class="text-blue-600 hover:underline">
                                {{ $tarea['archivo'] }}
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $tarea['entregas'] }}/{{ $tarea['vistos'] }}</td>
                        <td class="px-6 py-4">
                            <button class="text-green-600 hover:underline seguimientoBtn mr-2 cursor-pointer" 
                                    data-tarea-id="{{ $tarea['id'] }}">
                                Seguimiento
                            </button>
                            <button class="text-red-600 hover:underline eliminarBtn cursor-pointer" 
                                    data-tarea-id="{{ $tarea['id'] }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-gray-500 italic">
                            No hay tareas subidas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal de seguimiento -->
    <div id="seguimientoModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative transform transition-all duration-300 scale-95 opacity-0">

        <button id="closeSeguimientoModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

        <h2 class="text-xl font-semibold mb-4">Seguimiento de la tarea</h2>
        
        <div id="tareaInfo" class="mb-4 p-4 bg-gray-50 rounded">
            <!-- Info de la tarea se carga dinámicamente -->
        </div>

        <div id="seguimientoContent" class="mb-4">
            <!-- Contenido del seguimiento se carga via AJAX -->
        </div>

        <div class="flex justify-end mt-4">
          <a href="#" id="btnCorregir" 
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hidden">
            Corregir
          </a>
        </div>
      </div>
    </div>

    <!-- Modal visual de eliminación -->
    <div id="eliminarModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 relative transform transition-all duration-300 scale-95 opacity-0">
        <button id="closeEliminarModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
        <h2 class="text-xl font-semibold mb-4">Confirmar eliminación</h2>
        <p class="mb-6 text-gray-700">¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.</p>
        <div class="flex justify-end gap-2">
          <button id="cancelEliminar" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
          <button id="confirmarEliminar" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Eliminar</button>
        </div>
      </div>
    </div>

<style>
.tab-button {
    background-color: #e5e5e5;
    color: #666;
    border-bottom: 3px solid transparent;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tab-button.active {
    background-color: #f9f9f9;
    color: #111;
    border-bottom: 3px solid #4f46e5;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let tareaIdParaEliminar = null;

    // --- Modal subir tareas ---
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const modal = document.getElementById('tareaModal');
    const modalContent = document.getElementById('tareaModalContent');
    const btnModulo = document.getElementById("btnModulo");
    const btnTarea = document.getElementById("btnTarea");
    const modalSeleccion = document.getElementById("modalSeleccion");
    const modalFormulario = document.getElementById("modalFormulario");
    const fechaEntrega = document.getElementById("fechaEntrega");
    const archivoInput = document.getElementById('archivo');
    const archivoNombre = document.getElementById('archivoNombre');
    const formSubir = document.querySelector('#modalFormulario form');
    const btnSubir = document.getElementById('btnSubir');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 20);
    }

    function closeModal() {
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalSeleccion.classList.remove("hidden");
            modalFormulario.classList.add("hidden");
            fechaEntrega.classList.add("hidden");
            limpiarFormulario();
        }, 300);
    }

    function limpiarFormulario() {
        document.querySelector('input[name="nombre"]').value = '';
        document.querySelector('textarea[name="descripcion"]').value = '';
        document.querySelector('input[name="archivo"]').value = '';
        archivoNombre.textContent = "No se ha seleccionado ningún archivo";
        document.querySelector('input[name="fecha_entrega"]').value = '';
        const cupofSelect = document.querySelector('select[name="cupof"]');
        if(cupofSelect) cupofSelect.selectedIndex = 0;
    }

    if (formSubir && btnSubir) {
        formSubir.addEventListener('submit', () => {
                btnSubir.disabled = true;
            btnSubir.textContent = 'Subiendo...';
        });
    }

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    btnModulo.addEventListener("click", () => {
        limpiarFormulario();
        modalSeleccion.classList.add("hidden");
        modalFormulario.classList.remove("hidden");
        fechaEntrega.classList.add("hidden");
        document.getElementById("formTitulo").textContent = "Subir Módulo de Teoría";
    });

    btnTarea.addEventListener("click", () => {
        limpiarFormulario();
        modalSeleccion.classList.add("hidden");
        modalFormulario.classList.remove("hidden");
        fechaEntrega.classList.remove("hidden");
        document.getElementById("formTitulo").textContent = "Subir Tarea con Fecha de Entrega";
    });

    archivoInput.addEventListener('change', () => {
        archivoNombre.textContent = archivoInput.files.length > 0 ? archivoInput.files[0].name : "No se ha seleccionado ningún archivo";
    });

    // --- Modal seguimiento ---
    const seguimientoBtns = document.querySelectorAll('.seguimientoBtn');
    const seguimientoModal = document.getElementById('seguimientoModal');
    const closeSeguimientoBtn = document.getElementById('closeSeguimientoModal');

    seguimientoBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const tareaId = btn.getAttribute('data-tarea-id');
            
            try {
                const response = await fetch(`/profesores/tareas/${tareaId}/seguimiento`);
                const data = await response.json();
                
                // Llenar info de la tarea
                document.getElementById('tareaInfo').innerHTML = `
                    <h3 class="font-semibold">${data.tarea.titulo}</h3>
                    <p class="text-sm text-gray-600">Curso: ${data.tarea.curso} | Materia: ${data.tarea.materia}</p>
                `;
                
                // Crear tabla de seguimiento
                let seguimientoHTML = `
                    <table class="w-full text-sm text-center text-gray-600 table-fixed">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">Alumno</th>
                                <th class="px-4 py-2">Estado</th>
                                ${data.tarea.es_tarea ? '<th class="px-4 py-2">Nota</th>' : ''}
                            </tr>
                        </thead>
                        <tbody>
                `;
                
                data.alumnos.forEach(alumno => {
                    const estadoClass = alumno.estado === 'No visto' ? 'text-red-600' : 
                                      alumno.estado === 'Visto y no respondido' ? 'text-yellow-600' : 
                                      'text-green-600';
                    
                    seguimientoHTML += `
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">${alumno.nombre_completo}</td>
                            <td class="px-4 py-2 ${estadoClass}">${alumno.estado}</td>
                            ${data.tarea.es_tarea ? `<td class="px-4 py-2">${alumno.nota || '-'}</td>` : ''}
                        </tr>
                    `;
                });
                
                seguimientoHTML += '</tbody></table>';
                document.getElementById('seguimientoContent').innerHTML = seguimientoHTML;
                
                // Mostrar botón corregir solo para tareas
                const btnCorregir = document.getElementById('btnCorregir');
                if (data.tarea.es_tarea) {
                    btnCorregir.classList.remove('hidden');
                    btnCorregir.href = `/profesores/tareas/${tareaId}/corregir`;
                } else {
                    btnCorregir.classList.add('hidden');
                }
                
                // Mostrar modal
                seguimientoModal.classList.remove('hidden');
                seguimientoModal.classList.add('flex');
                setTimeout(() => {
                    seguimientoModal.firstElementChild.classList.remove('scale-95','opacity-0');
                    seguimientoModal.firstElementChild.classList.add('scale-100','opacity-100');
                }, 20);
                
            } catch (error) {
                console.error('Error al cargar seguimiento:', error);
                alert('Error al cargar el seguimiento de la tarea');
            }
        });
    });

    closeSeguimientoBtn.addEventListener('click', () => {
        seguimientoModal.firstElementChild.classList.add('scale-95','opacity-0');
        seguimientoModal.firstElementChild.classList.remove('scale-100','opacity-100');
        setTimeout(() => {
            seguimientoModal.classList.remove('flex');
            seguimientoModal.classList.add('hidden');
        }, 300);
    });

    // Modal eliminar  
    const eliminarBtns = document.querySelectorAll('.eliminarBtn');
    const eliminarModal = document.getElementById('eliminarModal');
    const closeEliminarModalBtn = document.getElementById('closeEliminarModal');
    const cancelEliminarBtn = document.getElementById('cancelEliminar');
    const confirmarEliminarBtn = document.getElementById('confirmarEliminar');

    eliminarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tareaIdParaEliminar = btn.getAttribute('data-tarea-id');
            eliminarModal.classList.remove('hidden');
            eliminarModal.classList.add('flex');
            setTimeout(() => {
                eliminarModal.firstElementChild.classList.remove('scale-95','opacity-0');
                eliminarModal.firstElementChild.classList.add('scale-100','opacity-100');
            }, 20);
        });
    });

    function cerrarEliminarModal() {
        eliminarModal.firstElementChild.classList.add('scale-95','opacity-0');
        eliminarModal.firstElementChild.classList.remove('scale-100','opacity-100');
        setTimeout(() => {
            eliminarModal.classList.remove('flex');
            eliminarModal.classList.add('hidden');
            tareaIdParaEliminar = null;
        }, 300);
    }

    closeEliminarModalBtn.addEventListener('click', cerrarEliminarModal);
    cancelEliminarBtn.addEventListener('click', cerrarEliminarModal);

    // Manejo de la eliminación con fetch y CSRF
    confirmarEliminarBtn.addEventListener('click', async () => {
        if (!tareaIdParaEliminar) return;
        
        // Deshabilitar botón para evitar múltiples clics
        confirmarEliminarBtn.disabled = true;
        confirmarEliminarBtn.textContent = 'Eliminando...';
        
        try {
            // Usar el token CSRF directamente desde Laravel
            const csrfToken = '{{ csrf_token() }}';
            
            if (!csrfToken) {
                throw new Error('Token CSRF no encontrado. Recarga la página e intenta nuevamente.');
            }

            // Hacer la petición DELETE
            const response = await fetch(`/profesores/tareas/${tareaIdParaEliminar}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            // Verificar si la respuesta es exitosa
            if (!response.ok) {
                let errorMessage = `Error HTTP ${response.status}`;
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    // Si no puede parsear JSON, usar mensaje genérico
                    errorMessage = response.status === 404 ? 'Tarea no encontrada' :
                                 response.status === 403 ? 'No tienes permisos para eliminar esta tarea' :
                                 response.status === 500 ? 'Error interno del servidor' : errorMessage;
                }
                throw new Error(errorMessage);
            }
            
            const data = await response.json();
            
            if (data.success) {
                cerrarEliminarModal();
                
                // Mostrar mensaje de éxito
                const alertDiv = document.createElement('div');
                alertDiv.className = 'mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded transition-opacity duration-500';
                alertDiv.innerHTML = `<strong>¡Éxito!</strong> ${data.message || 'Tarea eliminada correctamente'}`;
                
                // Insertar al inicio del contenido
                const mainContent = document.querySelector('h1').parentElement;
                mainContent.insertBefore(alertDiv, mainContent.firstChild);
                
                // Auto-ocultar después de 3 segundos
                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    setTimeout(() => alertDiv.remove(), 500);
                }, 3000);
                
                // Eliminar fila de la tabla con animación
                if (data.success) {
                    const idAEliminar = tareaIdParaEliminar;
                    cerrarEliminarModal();

                    setTimeout(() => {
                        const filaAEliminar = document.querySelector(`button[data-tarea-id="${idAEliminar}"]`).closest('tr');
                        if (filaAEliminar) {
                            filaAEliminar.style.transition = 'opacity 0.3s, transform 0.3s';
                            filaAEliminar.style.opacity = '0';
                            filaAEliminar.style.transform = 'translateX(-100%)';

                            setTimeout(() => {
                                const tbody = filaAEliminar.parentNode;
                                filaAEliminar.remove();

                                const filasRestantes = Array.from(tbody.querySelectorAll('tr'))
                                    .filter(tr => tr.style.display !== 'none');

                                if (filasRestantes.length === 0) {
                                    const colspan = tbody.parentNode.querySelector('thead tr').children.length;
                                    const esTablaModulos = tbody.closest('#modulosSection') !== null;

                                    tbody.innerHTML = `
                                        <tr>
                                            <td colspan="${colspan}" class="px-6 py-4 text-gray-500 italic">
                                                No hay ${esTablaModulos ? 'módulos' : 'tareas'} subidos aún.
                                            </td>
                                        </tr>
                                    `;
                                }
                            }, 350); 
                        }
                    }, 300); 
                }
            } else {
                throw new Error(data.message || 'Error desconocido al eliminar la tarea');
            }
        } catch (error) {
            console.error('Error al eliminar tarea:', error);
            
            // Mostrar mensaje de error
            const alertDiv = document.createElement('div');
            alertDiv.className = 'mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded';
            alertDiv.innerHTML = `<strong>Error:</strong> ${error.message}`;
            
            const mainContent = document.querySelector('h1').parentElement;
            mainContent.insertBefore(alertDiv, mainContent.firstChild);
            
            // Auto-ocultar mensaje de error después de 5 segundos
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 5000);
            
            cerrarEliminarModal();
        } finally {
            // Restaurar botón
            confirmarEliminarBtn.disabled = false;
            confirmarEliminarBtn.textContent = 'Eliminar';
        }
    });

    // Tabs secciones
    const tabModulos = document.getElementById('tabModulos');
    const tabTareas = document.getElementById('tabTareas');
    const modulosSection = document.getElementById('modulosSection');
    const tareasSection = document.getElementById('tareasSection');

    function activarTab(tabActivo, tabInactivo, sectionActivo, sectionInactivo) {
        // Mostrar/ocultar secciones
        sectionActivo.classList.remove('hidden');
        sectionInactivo.classList.add('hidden');
        
        // Activar/desactivar tabs
        tabActivo.classList.add('active');
        tabInactivo.classList.remove('active');
    }

    tabModulos.addEventListener('click', () => {
        activarTab(tabModulos, tabTareas, modulosSection, tareasSection);
    });

    tabTareas.addEventListener('click', () => {
        activarTab(tabTareas, tabModulos, tareasSection, modulosSection);
    });

    // Inicializar con el primer tab activo
    activarTab(tabModulos, tabTareas, modulosSection, tareasSection);
});

// Auto-ocultar alerta de éxito si existe
const alertSuccess = document.getElementById('alert-success');
if (alertSuccess) {
    setTimeout(() => {
        alertSuccess.style.opacity = '0';
        setTimeout(() => alertSuccess.remove(), 500);
    }, 3000);
}
</script>

</x-layouts.profesores.dashboard>