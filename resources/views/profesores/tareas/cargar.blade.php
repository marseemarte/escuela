<x-layouts.profesores.dashboard tareas titulo="Tareas" title="Mi Técnica | Panel de Profesores - Tareas">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            <!-- Botón volver -->
                            <a href="{{ route('profesores.index') }}"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            <!-- Información -->
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">{{ $cursos[0]['materia'] }} - {{ $cursos[0]['nombre'] }}</h1>
                                <p class="text-muted mb-0">
                                    Gestiona las tareas de la materia {{ $cursos[0]['materia'] }} del curso
                                    {{ $cursos[0]['nombre'] }}.
                                    Aquí puedes subir módulos de teoría, tareas con fecha de entrega y hacer el
                                    seguimiento de respuestas.
                                </p>
                            </div>
                        </div>

                        <!-- Información adicional (Fecha) -->
                        <div class="text-center text-md-right">
                            <small class="text-muted">
                                {{ now()->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="feather icon-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Informacion y boton Subir Archivo -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="h5 mb-1">Gestión de Tareas</h2>
                            <p class="text-muted mb-0">Sube y administra el contenido de la materia</p>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <button type="button" id="openModalBtn" class="btn btn-primary btn-sm">
                                <i class="feather icon-plus mr-1"></i> Subir nuevo archivo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para subir tareas -->
            <div id="tareaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tareaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tareaModalLabel">Subir Archivo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Elegir tipo de archivo -->
                        <div class="modal-body">
                            <div id="modalSeleccion">
                                <div class="text-center mb-4">
                                    <h6>¿Qué deseas subir?</h6>
                                    <p class="text-muted">Selecciona el tipo de archivo que quieres subir</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <button id="btnModulo" class="btn btn-outline-primary btn-block py-3">
                                            <i class="feather icon-book mr-2"></i>
                                            <div>
                                                <strong>Módulo de teoría</strong>
                                                <br><small class="text-muted">Material de estudio sin fecha de
                                                    entrega</small>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button id="btnTarea" class="btn btn-outline-success btn-block py-3">
                                            <i class="feather icon-edit mr-2"></i>
                                            <div>
                                                <strong>Tarea con fecha de entrega</strong>
                                                <br><small class="text-muted">Actividad evaluable con fecha
                                                    límite</small>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulario (oculto por defecto) -->
                            <div id="modalFormulario" class="d-none">
                                <form method="POST" action="{{ route('profesores.tareas.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" class="form-control" required
                                            placeholder="Ingresa el nombre del archivo">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción opcional del contenido"></textarea>
                                    </div>

                                    <input type="hidden" name="cupof" value="{{ $cursos[0]['id'] ?? $cupof }}">

                                    <!-- Campo fecha de entrega (solo para tarea) -->
                                    <div id="fechaEntrega" class="form-group d-none">
                                        <label class="form-label">Fecha de entrega <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="fecha_entrega" class="form-control"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        <small class="form-text text-muted">Los estudiantes podrán entregar hasta esta
                                            fecha</small>
                                    </div>

                                    <!-- Subir Archivo -->
                                    <div class="form-group">
                                        <label class="form-label">Archivo <span class="text-danger">*</span></label>
                                        <div class="file-upload-container">
                                            <input type="file" name="archivo" id="archivo" class="file-input"
                                                required
                                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.rar,.zip,.7z,.tar,.gz">
                                            <div class="file-upload-display d-flex align-items-center">
                                                <button type="button"
                                                    class="btn btn-outline-secondary file-upload-btn">
                                                    <i class="feather icon-upload mr-2"></i>
                                                    Agregar archivo
                                                </button>
                                                <span class="file-name-display ml-3 text-muted" id="fileNameDisplay">
                                                    Ningún archivo seleccionado
                                                </span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted mt-2">
                                            Formatos permitidos: PDF, Word, PowerPoint, Excel, Imágenes, Comprimidos
                                            (máx. 20MB)
                                        </small>
                                    </div>

                                    <!-- Botones -->
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="backToSelection" class="btn btn-secondary">
                                            <i class="feather icon-arrow-left mr-1"></i> Atrás
                                        </button>
                                        <div>
                                            <button type="button" class="btn btn-outline-secondary mr-2"
                                                data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="submit" id="btnSubir" class="btn btn-primary">
                                                <i class="feather icon-upload mr-1"></i> Subir
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs de navegación -->
            <div class="mb-4">
                <ul class="nav nav-tabs" id="tareasTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="modulos-tab" data-toggle="tab" href="#modulos"
                            role="tab" aria-controls="modulos" aria-selected="true">
                            <i class="feather icon-book mr-1"></i>
                            Módulos de teoría
                            <span class="badge badge-secondary ml-1">{{ count($modulos) }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tareas-tab" data-toggle="tab" href="#tareas" role="tab"
                            aria-controls="tareas" aria-selected="false">
                            <i class="feather icon-edit mr-1"></i>
                            Tareas con fecha de entrega
                            <span class="badge badge-secondary ml-1">{{ count($tareas) }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sección Módulos de teoría -->
            <div class="tab-content" id="tareasTabContent">
                <div class="tab-pane fade show active" id="modulos" role="tabpanel" aria-labelledby="modulos-tab">
                    @if (count($modulos) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">Nombre</th>
                                        <th scope="col" class="text-center">Materia</th>
                                        <th scope="col" class="text-center">Fecha de subida</th>
                                        <th scope="col" class="text-center">Archivo</th>
                                        <th scope="col" class="text-center">Vistos</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modulos as $modulo)
                                        <tr class="text-center">
                                            <td class="font-weight-bold">{{ $modulo['titulo'] }}</td>
                                            <td>{{ $modulo['materia'] }}</td>
                                            <td>{{ $modulo['fecha_subida'] }}</td>
                                            <td>
                                                <a href="{{ route('profesores.tareas.descargar', $modulo['id']) }}"
                                                    class="download-link text-decoration-none"
                                                    title="Ver archivo: {{ $modulo['archivo'] }}"
                                                    data-toggle="tooltip"
                                                    {{ Str::endsWith(strtolower($modulo['archivo']), '.pdf') ? 'target="_blank"' : '' }}>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i class="feather {{ Str::endsWith(strtolower($modulo['archivo']), '.pdf') ? 'icon-eye' : 'icon-download' }} text-primary mr-2"
                                                            style="font-size: 1.1rem;"></i>
                                                        <span class="text-primary font-weight-medium file-name">
                                                            {{ Str::limit($modulo['archivo'], 20) }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-lg badge-info">{{ $modulo['vistos'] }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary seguimientoBtn"
                                                        data-tarea-id="{{ $modulo['id'] }}" title="Ver seguimiento">
                                                        <i class="feather icon-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger eliminarBtn"
                                                        data-tarea-id="{{ $modulo['id'] }}" title="Eliminar">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="feather icon-book text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">No hay módulos subidos aún</h5>
                            <p class="text-muted">Los módulos de teoría aparecerán aquí una vez que los subas</p>
                        </div>
                    @endif
                </div>

                <!-- Sección Tareas con fecha de entrega -->
                <div class="tab-pane fade" id="tareas" role="tabpanel" aria-labelledby="tareas-tab">
                    @if (count($tareas) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">Nombre</th>
                                        <th scope="col" class="text-center">Materia</th>
                                        <th scope="col" class="text-center">Fecha de Subida</th>
                                        <th scope="col" class="text-center">Fecha de entrega</th>
                                        <th scope="col" class="text-center">Archivo</th>
                                        <th scope="col" class="text-center">Entregas</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tareas as $tarea)
                                        <tr class="text-center">
                                            <td class="font-weight-bold">{{ $tarea['titulo'] }}</td>
                                            <td>{{ $tarea['materia'] }}</td>
                                            <td>{{ $tarea['fecha_subida'] }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-lg {{ strtotime($tarea['fecha_entrega']) < time() ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $tarea['fecha_entrega'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('profesores.tareas.descargar', $tarea['id']) }}"
                                                    class="download-link text-decoration-none"
                                                    title="Ver archivo: {{ $tarea['archivo'] }}"
                                                    data-toggle="tooltip"
                                                    {{ Str::endsWith(strtolower($tarea['archivo']), '.pdf') ? 'target="_blank"' : '' }}>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i class="feather {{ Str::endsWith(strtolower($tarea['archivo']), '.pdf') ? 'icon-eye' : 'icon-download' }} text-primary mr-2"
                                                            style="font-size: 1.1rem;"></i>
                                                        <span class="text-primary font-weight-medium file-name">
                                                            {{ Str::limit($tarea['archivo'], 20) }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-lg badge-primary">{{ $tarea['entregas'] }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary seguimientoBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}" title="Ver seguimiento">
                                                        <i class="feather icon-eye"></i>
                                                    </button>
                                                    <a href="{{ route('profesores.tareas.corregir', $tarea['id']) }}"
                                                        class="btn btn-sm btn-outline-success" title="Corregir">
                                                        <i class="feather icon-check-circle"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger eliminarBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}" title="Eliminar">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="feather icon-edit text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">No hay tareas subidas aún</h5>
                            <p class="text-muted">Las tareas con fecha de entrega aparecerán aquí una vez que las subas
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de seguimiento -->
    <div class="modal fade" id="seguimientoModal" tabindex="-1" role="dialog"
        aria-labelledby="seguimientoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seguimientoModalLabel">Seguimiento de la tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="tareaInfo" class="alert alert-info">
                        <!-- Info de la tarea se carga dinámicamente, revisar script -->>
                    </div>

                    <div id="seguimientoContent">
                        <!-- Contenido del seguimiento se carga via AJAX, revisar script -->
                    </div>
                </div>
                <!-- Botones -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="#" id="btnCorregir" class="btn btn-success d-none">
                        <i class="feather icon-edit mr-1"></i>
                        Ir a Corregir
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación eliminar -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="feather icon-alert-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                        <h6>¿Estás seguro de que quieres eliminar esta tarea?</h6>
                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmarEliminar" class="btn btn-danger">
                        <i class="feather icon-trash-2 mr-1"></i>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let tareaIdParaEliminar = null;

            // Mantener pestaña activa al recargar
            const tabs = document.querySelectorAll('#tareasTabs a');
            const lastTab = localStorage.getItem('lastActiveTab');
            if (lastTab) {
                const triggerEl = document.querySelector(`#tareasTabs a[href="${lastTab}"]`);
                if (triggerEl) {
                    $(triggerEl).tab('show'); // jQuery + Bootstrap 4
                }
            }

            // Guardar la pestaña al cambiar
            $(tabs).on('shown.bs.tab', function(e) {
                const href = e.target.getAttribute('href'); // href de la pestaña activa
                localStorage.setItem('lastActiveTab', href);
            });

            // Sistema de mensajes
            function mostrarMensaje(mensaje, tipo) {
                const alertasExistentes = document.querySelectorAll('.alert-temp');
                alertasExistentes.forEach(alerta => alerta.remove());

                const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = tipo === 'success' ? 'check-circle' : 'alert-circle';

                const alert = document.createElement('div');
                alert.className = `alert ${alertClass} alert-dismissible fade show alert-temp`;
                alert.innerHTML = `
                    <i class="feather icon-${iconClass} mr-2"></i>
                    ${mensaje}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                `;

                document.querySelector('.row .col-12').insertBefore(alert, document.querySelector('.card'));

                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        $(alert).alert('close');
                    }
                }, 5000);
            }

            // Modal subir tareas
            const openModalBtn = document.getElementById('openModalBtn');
            const modalSeleccion = document.getElementById('modalSeleccion');
            const modalFormulario = document.getElementById('modalFormulario');
            const fechaEntrega = document.getElementById('fechaEntrega');
            const archivoInput = document.getElementById('archivo');

            // abrir modal
            openModalBtn?.addEventListener('click', () => {
                $('#tareaModal').modal('show');
            });

            // Funcionalidad mejorada del selector de archivo
            const fileUploadDisplay = document.querySelector('.file-upload-display');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileUploadBtn = document.querySelector('.file-upload-btn');

            // Clic en el área completa abre el selector
            fileUploadDisplay?.addEventListener('click', () => {
                archivoInput?.click();
            });

            // Manejar selección de archivo mejorada
            if (archivoInput) {
                archivoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        // Validar tamaño del archivo (20MB máximo)
                        const maxSize = 20 * 1024 * 1024; // 20MB en bytes
                        if (file.size > maxSize) {
                            if (fileNameDisplay) {
                                fileNameDisplay.textContent =
                                    'Error: El archivo es demasiado grande (máx. 20MB)';
                                fileNameDisplay.style.color = '#dc3545';
                            }
                            if (fileUploadDisplay) {
                                fileUploadDisplay.classList.remove('file-selected');
                                fileUploadDisplay.style.borderColor = '#dc3545';
                            }
                            if (fileUploadBtn) {
                                fileUploadBtn.innerHTML =
                                    '<i class="feather icon-alert-triangle mr-2"></i>Archivo muy grande';
                            }
                            this.value = ''; // Limpiar selección
                        } else {
                            // Mostrar nombre del archivo
                            if (fileNameDisplay) {
                                fileNameDisplay.textContent = file.name;
                                fileNameDisplay.classList.add('has-file');
                                fileNameDisplay.style.color = '';
                            }

                            // Cambiar apariencia del contenedor
                            if (fileUploadDisplay) {
                                fileUploadDisplay.classList.add('file-selected');
                                fileUploadDisplay.style.borderColor = '';
                            }

                            // Cambiar texto del botón
                            if (fileUploadBtn) {
                                fileUploadBtn.innerHTML =
                                    '<i class="feather icon-check mr-2"></i>Archivo seleccionado';
                            }
                        }
                    } else {
                        // Restablecer estado
                        if (fileNameDisplay) {
                            fileNameDisplay.textContent = 'Ningún archivo seleccionado';
                            fileNameDisplay.classList.remove('has-file');
                            fileNameDisplay.style.color = '';
                        }
                        if (fileUploadDisplay) {
                            fileUploadDisplay.classList.remove('file-selected');
                            fileUploadDisplay.style.borderColor = '';
                        }
                        if (fileUploadBtn) {
                            fileUploadBtn.innerHTML =
                                '<i class="feather icon-upload mr-2"></i>Agregar archivo';
                        }
                    }
                });
            }

            // Botón módulo
            document.getElementById('btnModulo')?.addEventListener('click', () => {
                modalSeleccion.classList.add('d-none');
                modalFormulario.classList.remove('d-none');
                fechaEntrega.classList.add('d-none');
                document.getElementById('tareaModalLabel').textContent = 'Subir Módulo de Teoría';
                fechaEntrega.querySelector('input').removeAttribute('required');
            });

            // Botón tarea
            document.getElementById('btnTarea')?.addEventListener('click', () => {
                modalSeleccion.classList.add('d-none');
                modalFormulario.classList.remove('d-none');
                fechaEntrega.classList.remove('d-none');
                document.getElementById('tareaModalLabel').textContent = 'Subir Tarea con Fecha de Entrega';
                fechaEntrega.querySelector('input').setAttribute('required', 'required');
            });

            // Botón atrás
            document.getElementById('backToSelection')?.addEventListener('click', () => {
                modalFormulario.classList.add('d-none');
                modalSeleccion.classList.remove('d-none');
                document.getElementById('tareaModalLabel').textContent = 'Subir Archivo';
            });

            // Limpiar modal al cerrar
            $('#tareaModal').on('hidden.bs.modal', function() {
                modalSeleccion.classList.remove('d-none');
                modalFormulario.classList.add('d-none');
                document.getElementById('tareaModalLabel').textContent = 'Subir Archivo';

                // Limpiar formulario y selector personalizado
                const form = modalFormulario.querySelector('form');
                if (form) {
                    form.reset();

                    // Restablecer selector de archivo personalizado
                    if (fileNameDisplay) {
                        fileNameDisplay.textContent = 'Ningún archivo seleccionado';
                        fileNameDisplay.classList.remove('has-file');
                        fileNameDisplay.style.color = '';
                    }
                    if (fileUploadDisplay) {
                        fileUploadDisplay.classList.remove('file-selected');
                        fileUploadDisplay.style.borderColor = '';
                    }
                    if (fileUploadBtn) {
                        fileUploadBtn.innerHTML = '<i class="feather icon-upload mr-2"></i>Agregar archivo';
                    }
                }
            });

            // Modal seguimiento
            document.querySelectorAll('.seguimientoBtn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const tareaId = btn.getAttribute('data-tarea-id');
                    try {
                        const response = await fetch(
                            `/profesores/tareas/${tareaId}/seguimiento`);
                        const data = await response.json();

                        // Info de la tarea
                        document.getElementById('tareaInfo').innerHTML = `
                            <strong>${data.tarea.titulo}</strong><br>
                            <small>Curso: ${data.tarea.curso} | Materia: ${data.tarea.materia}</small>
                        `;

                        // Tabla de seguimiento
                        let seguimientoHTML = `
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Alumno</th>
                                            <th class="text-center">Estado</th>
                                            ${data.tarea.es_tarea ? '<th class="text-center">Nota</th>' : ''}
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        data.alumnos.forEach(alumno => {
                            let estadoClass = 'badge-danger';
                            if (alumno.estado === 'Visto y no respondido') estadoClass =
                                'badge-warning';
                            if (alumno.estado.includes('Entregado') || alumno.estado ===
                                'Visto') estadoClass = 'badge-success';

                            seguimientoHTML += `
                                <tr class="text-center">
                                    <td>${alumno.nombre_completo}</td>
                                    <td><span class="badge ${estadoClass}">${alumno.estado}</span></td>
                                    ${data.tarea.es_tarea ? `<td>${alumno.nota ? alumno.nota : '-'}</td>` : ''}
                                </tr>
                            `;
                        });

                        seguimientoHTML += '</tbody></table></div>';
                        document.getElementById('seguimientoContent').innerHTML =
                            seguimientoHTML;

                        // Botón corregir
                        const btnCorregir = document.getElementById('btnCorregir');
                        if (data.tarea.es_tarea) {
                            btnCorregir.classList.remove('d-none');
                            btnCorregir.href = `/profesores/tareas/${tareaId}/corregir`;
                        } else {
                            btnCorregir.classList.add('d-none');
                        }

                        $('#seguimientoModal').modal('show');

                    } catch (error) {
                        console.error('Error al cargar seguimiento:', error);
                        mostrarMensaje('Error al cargar el seguimiento de la tarea', 'error');
                    }
                });
            });

            // Modal eliminar
            document.querySelectorAll('.eliminarBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    tareaIdParaEliminar = btn.getAttribute('data-tarea-id');
                    $('#eliminarModal').modal('show');
                });
            });

            // Confirmar eliminación
            document.getElementById('confirmarEliminar')?.addEventListener('click', async () => {
                if (!tareaIdParaEliminar) return;

                const btnConfirmar = document.getElementById('confirmarEliminar');
                const originalText = btnConfirmar.innerHTML;

                btnConfirmar.disabled = true;
                btnConfirmar.innerHTML = '<i class="feather icon-loader mr-1"></i> Eliminando...';

                try {
                    const response = await fetch(`/profesores/tareas/${tareaIdParaEliminar}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`Error HTTP ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        $('#eliminarModal').modal('hide');
                        mostrarMensaje(data.message || 'Tarea eliminada correctamente', 'success');

                        // Eliminar fila de la tabla
                        const fila = document.querySelector(
                            `button[data-tarea-id="${tareaIdParaEliminar}"]`)?.closest('tr');
                        if (fila) {
                            fila.style.transition = 'opacity 0.3s';
                            fila.style.opacity = '0';
                            setTimeout(() => fila.remove(), 300);
                        }

                        setTimeout(() => location.reload(), 1500);
                    } else {
                        throw new Error(data.message || 'Error desconocido al eliminar la tarea');
                    }

                } catch (error) {
                    console.error('Error al eliminar tarea:', error);
                    $('#eliminarModal').modal('hide');
                    mostrarMensaje('Error al eliminar la tarea: ' + error.message, 'error');
                } finally {
                    btnConfirmar.disabled = false;
                    btnConfirmar.innerHTML = originalText;
                    tareaIdParaEliminar = null;
                }
            });

            // Manejar envío del formulario
            const formSubir = document.querySelector('#modalFormulario form');
            const btnSubir = document.getElementById('btnSubir');

            if (formSubir && btnSubir) {
                formSubir.addEventListener('submit', () => {
                    btnSubir.disabled = true;
                    btnSubir.innerHTML = '<i class="feather icon-loader mr-1"></i> Subiendo...';
                });
            }

            // Auto-ocultar alertas de sesión después de 5 segundos
            setTimeout(() => {
                const alertas = document.querySelectorAll('.alert:not(.alert-temp)');
                alertas.forEach(alerta => {
                    if (alerta.classList.contains('alert-success') || alerta.classList.contains(
                            'alert-danger')) {
                        $(alerta).alert('close');
                    }
                });
            }, 5000);
        });
    </script>

    {{-- Estilos adicionales para mejorar la apariencia --}}
    <style>
        /* Mejoras visuales */
        .custom-file-label::after {
            content: "Buscar";
        }

        .file-upload-container {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 0.1px;
            height: 0.1px;
            overflow: hidden;
        }

        .file-upload-display {
            border: 2px dashed #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-display:hover {
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.05);
        }

        .file-upload-display.file-selected {
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.05);
        }

        .file-upload-btn {
            border: 1px solid #6c757d;
            background-color: #fff;
            color: #6c757d;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .file-upload-btn:hover {
            background-color: #6c757d;
            color: #fff;
            border-color: #6c757d;
        }

        .file-upload-display.file-selected .file-upload-btn {
            border-color: #28a745;
            color: #28a745;
        }

        .file-upload-display.file-selected .file-upload-btn:hover {
            background-color: #28a745;
            color: #fff;
        }

        .file-name-display {
            font-size: 0.875rem;
            flex: 1;
            word-break: break-word;
        }

        .file-name-display.has-file {
            color: #495057 !important;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .file-upload-display {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .file-name-display {
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }
        }

        .btn-group .btn {
            border-radius: 0.25rem !important;
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .table td {
            vertical-align: middle;
        }

        .nav-tabs .nav-link.active {
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            border-bottom-color: transparent;
        }

        .tab-content {
            border-top: none;
        }

        .modal-xl {
            max-width: 1140px;
        }

        .alert-temp {
            position: relative;
            z-index: 1050;
        }

        /* Animaciones suaves */
        .table tbody tr {
            transition: all 0.3s ease;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .modal {
            backdrop-filter: blur(3px);
        }

        /* Responsive mejoras */
        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin-bottom: 2px;
                margin-right: 0;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Estados de badges */
        .badge-danger {
            background-color: #ff7b00;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-primary {
            background-color: #007bff;
        }

        /* Efectos hover mejorados */
        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Mejoras en la tabla */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .05);
        }

        /* Iconos más grandes en estados vacíos */
        .text-center i[style*="font-size: 3rem"] {
            opacity: 0.3;
        }

        /* Espaciado consistente */
        .card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }

        .download-link {
            transition: all 0.3s ease;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin: -0.25rem -0.5rem;
        }

        .download-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transform: translateY(-1px);
            text-decoration: none !important;
        }

        .download-link:hover .feather {
            transform: translateY(-2px);
        }

        .download-link .file-name {
            font-size: 0.875rem;
            line-height: 1.2;
            word-break: break-word;
        }

        /* Colores específicos */
        .text-primary {
            color: #007bff !important;
        }

        .font-weight-medium {
            font-weight: 500;
        }

        /* Efectos hover adicionales */
        .download-link:hover .text-primary {
            color: #0056b3 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .download-link .file-name {
                font-size: 0.8rem;
            }

            .download-link .feather {
                font-size: 1rem !important;
            }
        }

        /* Tooltip personalizado */
        .tooltip {
            font-size: 0.875rem;
        }

        .tooltip-inner {
            background-color: #343a40;
            color: #fff;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
        }

        /* Estados de hover mejorados */
        .table tbody tr:hover .download-link {
            background-color: rgba(0, 123, 255, 0.05);
        }
    </style>

</x-layouts.profesores.dashboard>
