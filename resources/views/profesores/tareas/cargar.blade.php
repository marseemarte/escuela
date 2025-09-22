
<x-layouts.profesores.dashboard titulo="Tareas"> 
    <h1 class="tareas-main-title">{{ $cursos[0]['materia'] }} - {{ $cursos[0]['nombre'] }}</h1>
    <p class="tareas-main-description">Gestiona las tareas de la materia {{ $cursos[0]['materia'] }} del curso {{ $cursos[0]['nombre'] }}.  
        Aquí puedes subir modulos de teoria, tareas con fecha de entrega y hacer el seguimiento de respuestas.</p>

    @if(session('success'))
        <div id="alert-success" class="tareas-alert tareas-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="tareas-alert tareas-alert-error">
            <ul class="tareas-error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Botón para subir nueva tarea -->
    <button class="tareas-btn-upload" id="openModalBtn">
        + Subir nuevo archivo
    </button>

    <!-- Modal para subir tareas--> 
    <div id="tareaModal" class="tareas-modal">
      <div id="tareaModalContent" class="tareas-modal-content">

        <!-- Botón cerrar -->
        <button id="closeModalBtn" class="tareas-modal-close">
          ✕
        </button>

        <!-- Pantalla de selección -->
        <div id="modalSeleccion" class="tareas-modal-selection">
          <h2 class="tareas-modal-title">¿Qué deseas subir?</h2>
          <div class="tareas-modal-buttons">
            <button id="btnModulo" class="tareas-btn-modulo">
              📘 Módulo de teoría
            </button>
            <button id="btnTarea" class="tareas-btn-tarea">
              📝 Tarea con fecha de entrega
            </button>
          </div>
        </div>

        <!-- Formulario (oculto por defecto) -->
        <div id="modalFormulario" class="tareas-form-section hidden">
          <h2 id="formTitulo" class="tareas-form-title"></h2>

          <form method="POST" action="{{ route('tareas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="tareas-form-group">
              <label class="tareas-form-label">Nombre</label>
              <input type="text" name="nombre" class="tareas-form-input" required>
            </div>

            <div class="tareas-form-group">
              <label class="tareas-form-label">Descripción (opcional)</label>
              <textarea name="descripcion" class="tareas-form-textarea" rows="3"></textarea>
            </div>

            <input type="hidden" name="cupof" value="{{ $cursos[0]['id'] ?? $cupof }}">

            <!-- Campo fecha de entrega (solo para tarea) -->
            <div id="fechaEntrega" class="tareas-form-group hidden">
              <label class="tareas-form-label">Fecha de entrega</label>
              <input type="date" name="fecha_entrega" class="tareas-form-input" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <!-- Archivo -->
            <div class="tareas-form-group">
              <label class="tareas-form-label">Archivo (máx. 10MB)</label>
              <div class="tareas-file-input">
                <label for="archivo" class="tareas-file-button">
                  Elegir archivo
                </label>
                <span id="archivoNombre" class="tareas-file-name">
                  No se ha seleccionado ningún archivo
                </span>
                <input type="file" name="archivo" id="archivo" class="hidden" required
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png">
              </div>
            </div>

            <!-- Boton Cerrar y Subir -->
            <div class="tareas-form-actions">
              <button type="button" id="cancelModalBtn" class="tareas-btn-cancel">
                Cancelar
              </button>
              <button type="submit" id="btnSubir" class="tareas-btn-submit">
                Subir
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="tareas-tabs-section">
        <nav class="tareas-tabs">
            <button id="tabModulos" class="tareas-tab-button">
                Módulos de teoría
            </button>
            <button id="tabTareas" class="tareas-tab-button">
                Tareas con fecha de entrega
            </button>
        </nav>
    </div>

    <!-- Sección Módulos de teoría -->
    <div id="modulosSection" class="tareas-table-container">
        <table class="tareas-table">
            <thead class="tareas-table-header">
                <tr>
                    <th class="tareas-table-th">Nombre</th>
                    <th class="tareas-table-th">Materia</th>
                    <th class="tareas-table-th">Curso</th>
                    <th class="tareas-table-th">Fecha de subida</th>
                    <th class="tareas-table-th">Archivo</th>
                    <th class="tareas-table-th">Vistos</th>
                    <th class="tareas-table-th">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modulos as $modulo)
                    <tr class="tareas-table-row">
                        <td class="tareas-table-td tareas-table-td-title">{{ $modulo['titulo'] }}</td>
                        <td class="tareas-table-td">{{ $modulo['materia'] }}</td>
                        <td class="tareas-table-td">{{ $modulo['curso'] }}</td>
                        <td class="tareas-table-td">{{ $modulo['fecha_subida'] }}</td>
                        <td class="tareas-table-td">
                            <a href="{{ route('profesores.tareas.descargar', $modulo['id']) }}" 
                               class="tareas-link">
                                {{ $modulo['archivo'] }}
                            </a>
                        </td>
                        <td class="tareas-table-td">{{ $modulo['vistos'] }}</td>
                        <td class="tareas-table-td">
                            <button class="tareas-btn-seguimiento seguimientoBtn" 
                                    data-tarea-id="{{ $modulo['id'] }}">
                                Seguimiento
                            </button>
                            <button class="tareas-btn-eliminar eliminarBtn" 
                                    data-tarea-id="{{ $modulo['id'] }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="tareas-table-empty">
                            No hay módulos subidos aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Sección Tareas con fecha de entrega -->
    <div id="tareasSection" class="tareas-table-container hidden">
        <table class="tareas-table">
            <thead class="tareas-table-header">
                <tr>
                    <th class="tareas-table-th">Nombre</th>
                    <th class="tareas-table-th">Materia</th>
                    <th class="tareas-table-th">Curso</th>
                    <th class="tareas-table-th">Fecha de Subida</th>
                    <th class="tareas-table-th">Fecha de entrega</th>
                    <th class="tareas-table-th">Archivo</th>
                    <th class="tareas-table-th">Entregas</th>
                    <th class="tareas-table-th">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                    <tr class="tareas-table-row">
                        <td class="tareas-table-td tareas-table-td-title">{{ $tarea['titulo'] }}</td>
                        <td class="tareas-table-td">{{ $tarea['materia'] }}</td>
                        <td class="tareas-table-td">{{ $tarea['curso'] }}</td>
                        <td class="tareas-table-td">{{ $tarea['fecha_subida'] }}</td>
                        <td class="tareas-table-td">
                            <span class="@if(strtotime($tarea['fecha_entrega']) < time()) tareas-date-expired @endif">
                                {{ $tarea['fecha_entrega'] }}
                            </span>
                        </td>
                        <td class="tareas-table-td">
                            <a href="{{ route('profesores.tareas.descargar', $tarea['id']) }}" 
                               class="tareas-link">
                                {{ $tarea['archivo'] }}
                            </a>
                        </td>
                        <td class="tareas-table-td">{{ $tarea['entregas'] }}</td>
                        <td class="tareas-table-td">
                            <button class="tareas-btn-seguimiento seguimientoBtn" 
                                    data-tarea-id="{{ $tarea['id'] }}">
                                Seguimiento
                            </button>
                            <button class="tareas-btn-eliminar eliminarBtn" 
                                    data-tarea-id="{{ $tarea['id'] }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="tareas-table-empty">
                            No hay tareas subidas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal de seguimiento -->
        <!-- Modal de seguimiento -->
    <div id="seguimientoModal" class="tareas-modal">
      <div class="tareas-modal-content tareas-modal-large">

        <button id="closeSeguimientoModal" class="tareas-modal-close">✕</button>

        <h2 class="tareas-modal-title">Seguimiento de la tarea</h2>
        
        <div id="tareaInfo" class="tareas-info-section">
            <!-- Info de la tarea se carga dinámicamente -->
        </div>

        <div id="seguimientoContent" class="tareas-seguimiento-content">
            <!-- Contenido del seguimiento se carga via AJAX -->
        </div>

        <div class="tareas-modal-footer">
          <a href="#" id="btnCorregir" class="tareas-btn-corregir hidden">
              Ir a Corregir
          </a>
        </div>
      </div>
    </div>

    <!-- Modal de confirmación eliminar -->
    <div id="eliminarModal" class="tareas-modal">
      <div class="tareas-modal-content">
        <button id="closeEliminarModal" class="tareas-modal-close">✕</button>
        <h2 class="tareas-modal-title">Confirmar eliminación</h2>
        <p class="tareas-modal-text">¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.</p>
        <div class="tareas-modal-actions">
          <button id="cancelEliminar" class="tareas-btn-cancel">Cancelar</button>
          <button id="confirmarEliminar" class="tareas-btn-danger">Eliminar</button>
        </div>
      </div>
    </div>

<style>
/* Base styles */
.tareas-main-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #111827;
}

.tareas-main-description {
    margin-bottom: 1.5rem;
    color: #4b5563;
}

/* Alerts */
.tareas-alert {
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 6px;
    transition: opacity 0.5s;
}

.tareas-alert-success {
    background-color: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.tareas-alert-error {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.tareas-error-list {
    list-style-type: disc;
    list-style-position: inside;
    margin: 0;
    padding: 0;
}

/* Upload button */
.tareas-btn-upload {
    background-color: #2563eb;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    margin-bottom: 0.75rem;
    cursor: pointer;
    border: none;
    font-weight: 500;
}

.tareas-btn-upload:hover {
    background-color: #1d4ed8;
}

/* Modal styles */
.tareas-modal {
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

.tareas-modal.flex {
    display: flex;
}

.tareas-modal-content {
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

.tareas-modal-large {
    max-width: 56rem;
}

.tareas-modal-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    color: #6b7280;
    cursor: pointer;
    background: none;
    border: none;
    font-size: 1.25rem;
}

.tareas-modal-close:hover {
    color: #374151;
}

.tareas-modal-selection {
    text-align: center;
}

.tareas-modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #111827;
}

.tareas-modal-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tareas-btn-modulo {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #6366f1;
    color: white;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

.tareas-btn-modulo:hover {
    background-color: #4f46e5;
}

.tareas-btn-tarea {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #2563eb;
    color: white;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

.tareas-btn-tarea:hover {
    background-color: #1d4ed8;
}

/* Form styles */
.tareas-form-section {
    /* Already hidden by default */
}

.tareas-form-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #111827;
}

.tareas-form-group {
    margin-bottom: 1rem;
}

.tareas-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.25rem;
}

.tareas-form-input, .tareas-form-textarea {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 0.75rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.tareas-form-input:focus, .tareas-form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.tareas-file-input {
    display: flex;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    align-items: center;
    overflow: hidden;
}

.tareas-file-button {
    padding: 0.5rem 1rem;
    background-color: #f3f4f6;
    cursor: pointer;
    border-left: 1px solid #d1d5db;
    transition: background-color 0.2s;
}

.tareas-file-button:hover {
    background-color: #e5e7eb;
}

.tareas-file-name {
    flex: 1;
    padding: 0.75rem;
    color: #4b5563;
    font-size: 0.875rem;
}

.tareas-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.tareas-btn-cancel {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #d1d5db;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

.tareas-btn-cancel:hover {
    background-color: #9ca3af;
}

.tareas-btn-submit {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #2563eb;
    color: white;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

.tareas-btn-submit:hover {
    background-color: #1d4ed8;
}

.tareas-btn-danger {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #dc2626;
    color: white;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

.tareas-btn-danger:hover {
    background-color: #b91c1c;
}

/* Tabs */
.tareas-tabs-section {
    margin-bottom: 1rem;
}

.tareas-tabs {
    display: flex;
    gap: 0.5rem;
}

.tareas-tab-button {
    padding: 0.5rem 1rem;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    background-color: #e5e5e5;
    color: #666;
    border-bottom: 3px solid transparent;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tareas-tab-button.active {
    background-color: #f9f9f9;
    color: #111;
    border-bottom: 3px solid #4f46e5;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Tables */
.tareas-table-container {
    overflow-x: auto;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.tareas-table {
    width: 100%;
    font-size: 0.875rem;
    text-align: center;
    color: #4b5563;
    table-layout: fixed;
}

.tareas-table-header {
    background-color: #f9fafb;
    color: #374151;
    text-transform: uppercase;
    font-size: 0.75rem;
}

.tareas-table-th {
    padding: 0.75rem 1.5rem;
}

.tareas-table-row {
    background-color: white;
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.2s;
}

.tareas-table-row:hover {
    background-color: #f9fafb;
}

.tareas-table-td {
    padding: 1rem 1.5rem;
}

.tareas-table-td-title {
    font-weight: 500;
    color: #111827;
}

.tareas-table-empty {
    padding: 1rem 1.5rem;
    color: #6b7280;
    font-style: italic;
}

.tareas-link {
    color: #2563eb;
    text-decoration: none;
}

.tareas-link:hover {
    text-decoration: underline;
}

.tareas-btn-seguimiento {
    color: #059669;
    background: none;
    border: none;
    cursor: pointer;
    margin-right: 0.5rem;
    text-decoration: none;
}

.tareas-btn-seguimiento:hover {
    text-decoration: underline;
}

.tareas-btn-eliminar {
    color: #dc2626;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.tareas-btn-eliminar:hover {
    text-decoration: underline;
}

.tareas-date-expired {
    color: #dc2626;
    font-weight: 600;
}

/* Info section */
.tareas-info-section {
    margin-bottom: 1rem;
    padding: 1rem;
    background-color: #f9fafb;
    border-radius: 6px;
}

.tareas-seguimiento-content {
    margin-bottom: 1rem;
}

.tareas-modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.tareas-btn-corregir {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #059669;
    color: white;
    text-decoration: none;
    transition: background-color 0.2s;
}

.tareas-btn-corregir:hover {
    background-color: #047857;
    color: white;
    text-decoration: none;
}

.tareas-modal-text {
    margin-bottom: 1.5rem;
    color: #374151;
}

.tareas-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

/* Utility classes */
.hidden {
    display: none;
}

.mr-2 {
    margin-right: 0.5rem;
}

.flex {
    display: flex;
}

.scale-95 {
    transform: scale(0.95);
}

.scale-100 {
    transform: scale(1);
}

.opacity-0 {
    opacity: 0;
}

.opacity-100 {
    opacity: 1;
}
</style>

    <!-- Modal visual de eliminación -->
    <div id="eliminarModal" class="tareas-modal">
      <div class="tareas-modal-content">
        <button id="closeEliminarModal" class="tareas-modal-close">✕</button>
        <h2 class="tareas-modal-title">Confirmar eliminación</h2>
        <p class="tareas-modal-text">¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.</p>
        <div class="tareas-modal-actions">
          <button id="cancelEliminar" class="tareas-btn-cancel">Cancelar</button>
          <button id="confirmarEliminar" class="tareas-btn-danger">Eliminar</button>
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