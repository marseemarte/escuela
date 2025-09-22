{{-- Vista para gestionar tareas de una materia específica --}}
<x-layouts.profesores.dashboard tareas titulo="Gestión de Tareas">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12">
            {{-- Header con información de la materia --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            {{-- Botón de regreso --}}
                            <a href="{{ route('profesores.tareas.index') }}"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            {{-- Información de la materia --}}
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">
                                    @if ($cursos->isNotEmpty())
                                        {{ $cursos->first()['materia'] }} - {{ $cursos->first()['nombre'] }}
                                    @else
                                        Gestión de Tareas
                                    @endif
                                </h1>
                                <p class="text-muted mb-0">
                                    Gestión de contenido académico y tareas con seguimiento de entregas
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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    <strong>Error:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Contenido principal --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="h5 mb-1">Gestión de Material Académico</h2>
                            <p class="text-muted mb-0">Administre módulos de teoría y tareas con fecha de entrega</p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <button class="btn btn-primary btn-sm" id="openModalBtn">
                                <i class="feather icon-plus mr-1"></i>
                                Subir nuevo archivo
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Navegación por pestañas --}}
                <div class="card-body pb-0">
                    <ul class="nav nav-tabs" id="tareasTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="modulos-tab" data-toggle="tab" href="#modulos" role="tab"
                                aria-controls="modulos" aria-selected="true">
                                <i class="feather icon-book-open mr-1"></i>
                                Módulos de Teoría
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tareas-tab" data-toggle="tab" href="#tareas" role="tab"
                                aria-controls="tareas" aria-selected="false">
                                <i class="feather icon-calendar mr-1"></i>
                                Tareas con Entrega
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contenido de pestañas --}}
                <div class="tab-content" id="tareasTabContent">
                    {{-- Módulos de teoría --}}
                    <div class="tab-pane fade show active" id="modulos" role="tabpanel" aria-labelledby="modulos-tab">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th width="30%">Título</th>
                                        <th width="30%">Descripción</th>
                                        <th width="15%">Fecha</th>
                                        <th width="15%">Archivo</th>
                                        <th width="10%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($modulos as $modulo)
                                        <tr class="text-center">
                                            <td class="font-weight-medium">{{ $modulo['titulo'] }}</td>
                                            <td class="text-muted">
                                                {{ isset($modulo['descripcion']) && $modulo['descripcion'] ? $modulo['descripcion'] : 'Sin descripción' }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $modulo['fecha_subida'] ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                @if (isset($modulo['archivo']))
                                                    <a href="{{ route('profesores.tareas.descargar', $modulo['id']) }}"
                                                        class="btn btn-outline-primary btn-sm" target="_blank">
                                                        <i class="feather icon-download mr-1"></i>
                                                        Ver archivo
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-danger btn-sm eliminarBtn"
                                                    data-tarea-id="{{ $modulo['id'] }}"
                                                    data-tarea-titulo="{{ $modulo['titulo'] }}">
                                                    <i class="feather icon-trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="feather icon-book-open mb-2" style="font-size: 2rem;"></i>
                                                    <p class="mb-0">No hay módulos de teoría disponibles</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tareas con fecha de entrega --}}
                    <div class="tab-pane fade" id="tareas" role="tabpanel" aria-labelledby="tareas-tab">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th width="25%">Título</th>
                                        <th width="25%">Descripción</th>
                                        <th width="15%">Fecha Entrega</th>
                                        <th width="15%">Archivo</th>
                                        <th width="20%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tareas as $tarea)
                                        <tr class="text-center">
                                            <td class="font-weight-medium">{{ $tarea['titulo'] }}</td>
                                            <td class="text-muted">
                                                {{ isset($tarea['descripcion']) && $tarea['descripcion'] ? $tarea['descripcion'] : 'Sin descripción' }}
                                            </td>
                                            <td>
                                                @if (isset($tarea['fecha_entrega']))
                                                    @php
                                                        $fechaEntrega = \Carbon\Carbon::parse($tarea['fecha_entrega']);
                                                        $esVencida = $fechaEntrega->isPast();
                                                    @endphp
                                                    <span
                                                        class="badge {{ $esVencida ? 'badge-danger' : 'badge-success' }}">
                                                        {{ $fechaEntrega->format('d/m/Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($tarea['archivo']))
                                                    <a href="{{ route('profesores.tareas.descargar', $tarea['id']) }}"
                                                        class="btn btn-outline-primary btn-sm" target="_blank">
                                                        <i class="feather icon-download mr-1"></i>
                                                        Ver archivo
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-info btn-sm seguimientoBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}">
                                                        <i class="feather icon-eye mr-1"></i>
                                                        Seguimiento
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm eliminarBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}"
                                                        data-tarea-titulo="{{ $tarea['titulo'] }}">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="feather icon-calendar mb-2"
                                                        style="font-size: 2rem;"></i>
                                                    <p class="mb-0">No hay tareas con fecha de entrega</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para subir tareas --}}
    <div class="modal fade" id="tareaModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tareaModalLabel">Subir Nuevo Archivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- Selección de tipo --}}
                    <div id="modalSeleccion">
                        <div class="text-center mb-4">
                            <h6 class="mb-3">¿Qué tipo de archivo deseas subir?</h6>
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" id="btnModulo"
                                        class="btn btn-outline-primary btn-block h-100 py-3">
                                        <i class="feather icon-book-open mb-2" style="font-size: 2rem;"></i>
                                        <br>
                                        <strong>Módulo de Teoría</strong>
                                        <br>
                                        <small class="text-muted">Material de estudio</small>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" id="btnTarea"
                                        class="btn btn-outline-success btn-block h-100 py-3">
                                        <i class="feather icon-calendar mb-2" style="font-size: 2rem;"></i>
                                        <br>
                                        <strong>Tarea con Entrega</strong>
                                        <br>
                                        <small class="text-muted">Con fecha límite</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Formulario --}}
                    <div id="modalFormulario" class="d-none">
                        <form method="POST" action="{{ route('profesores.tareas.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cupof"
                                value="{{ request()->route('cupof') ?? ($cursos->isNotEmpty() ? $cursos->first()['id'] : '') }}">
                            <input type="hidden" name="tipo" id="tipoArchivo">

                            <div class="form-group">
                                <label for="nombreArchivo">Título <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombreArchivo" class="form-control"
                                    required>
                                <small class="form-text text-muted">Ingrese un título descriptivo para el
                                    archivo</small>
                            </div>

                            <div class="form-group">
                                <label for="descripcionArchivo">Descripción</label>
                                <textarea name="descripcion" id="descripcionArchivo" class="form-control" rows="3"
                                    placeholder="Descripción opcional del contenido"></textarea>
                            </div>

                            <div class="form-group" id="fechaEntregaGroup" style="display: none;">
                                <label for="fechaEntrega">Fecha de Entrega <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_entrega" id="fechaEntrega" class="form-control"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                <small class="form-text text-muted">Seleccione la fecha límite para la entrega</small>
                            </div>

                            <div class="form-group">
                                <label for="archivoInput">Archivo <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="archivo" id="archivoInput" class="custom-file-input"
                                        required>
                                    <label class="custom-file-label" for="archivoInput">Seleccionar archivo (máx.
                                        10MB)</label>
                                </div>
                                <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX,
                                    PPT, PPTX</small>
                            </div>

                            <div class="modal-footer px-0 pb-0">
                                <button type="button" class="btn btn-secondary" id="volverSeleccion">
                                    <i class="feather icon-arrow-left mr-1"></i>
                                    Volver
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather icon-upload mr-1"></i>
                                    Subir Archivo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <style>
            /* Estilos para el sistema de tareas */
            .custom-file-label::after {
                content: "Seleccionar";
                background-color: #007bff;
                border-color: #007bff;
                color: white;
            }

            /* Mejoras en la visualización de seguimiento */
            #seguimientoContent table {
                width: 100% !important;
                margin: 0 auto !important;
            }

            #seguimientoContent th,
            #seguimientoContent td {
                text-align: center !important;
                padding: 0.75rem !important;
                vertical-align: middle !important;
            }

            #seguimientoContent th {
                background-color: #f8f9fa !important;
                font-weight: 600 !important;
                border-bottom: 2px solid #dee2e6 !important;
            }

            /* Personalización de pestañas Bootstrap */
            .nav-tabs .nav-link {
                border: 1px solid transparent;
                border-radius: 0.25rem 0.25rem 0 0;
                transition: all 0.3s ease;
            }

            .nav-tabs .nav-link.active {
                color: #007bff !important;
                background-color: #fff;
                border-color: #dee2e6 #dee2e6 #fff;
                border-bottom-color: #fff;
                font-weight: 600;
            }

            .nav-tabs .nav-link:hover:not(.active) {
                border-color: #e9ecef #e9ecef #dee2e6;
                background-color: #f8f9fa;
            }

            /* Mejoras en las tablas */
            .table th {
                font-weight: 600;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            /* Botones más elegantes */
            .btn-group .btn {
                border-radius: 0.25rem;
                margin-right: 2px;
            }

            .btn-group .btn:last-child {
                margin-right: 0;
            }

            /* Estilo para badges de fecha */
            .badge {
                font-weight: 500;
                font-size: 0.8rem;
            }

            /* Responsive improvements */
            @media (max-width: 768px) {
                .table-responsive {
                    border: none;
                }

                .btn-group {
                    flex-direction: column;
                }

                .btn-group .btn {
                    margin-bottom: 2px;
                    border-radius: 0.25rem !important;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Variables para el modal de tareas
                let tipoSeleccionado = '';
                let tareaIdParaEliminar = null;

                // Referencias a elementos del DOM
                const btnModulo = document.getElementById('btnModulo');
                const btnTarea = document.getElementById('btnTarea');
                const modalSeleccion = document.getElementById('modalSeleccion');
                const modalFormulario = document.getElementById('modalFormulario');
                const fechaEntregaGroup = document.getElementById('fechaEntregaGroup');
                const tipoArchivoInput = document.getElementById('tipoArchivo');
                const volverBtn = document.getElementById('volverSeleccion');
                const archivoInput = document.getElementById('archivoInput');

                // Configurar input de archivo personalizado
                archivoInput.addEventListener('change', function() {
                    const fileName = this.files[0] ? this.files[0].name : 'Seleccionar archivo (máx. 10MB)';
                    this.nextElementSibling.innerHTML = fileName;
                });

                // Manejador para abrir modal
                document.getElementById('openModalBtn').addEventListener('click', function() {
                    $('#tareaModal').modal('show');
                    resetModal();
                });

                // Función para resetear el modal
                function resetModal() {
                    modalSeleccion.classList.remove('d-none');
                    modalFormulario.classList.add('d-none');
                    fechaEntregaGroup.style.display = 'none';
                    tipoSeleccionado = '';
                    document.querySelector('#modalFormulario form').reset();
                    archivoInput.nextElementSibling.innerHTML = 'Seleccionar archivo (máx. 10MB)';
                }

                // Manejador para seleccionar módulo
                btnModulo.addEventListener('click', function() {
                    tipoSeleccionado = 'modulo';
                    tipoArchivoInput.value = 'modulo';
                    modalSeleccion.classList.add('d-none');
                    modalFormulario.classList.remove('d-none');
                    fechaEntregaGroup.style.display = 'none';
                    document.getElementById('tareaModalLabel').textContent = 'Subir Módulo de Teoría';
                });

                // Manejador para seleccionar tarea
                btnTarea.addEventListener('click', function() {
                    tipoSeleccionado = 'tarea';
                    tipoArchivoInput.value = 'tarea';
                    modalSeleccion.classList.add('d-none');
                    modalFormulario.classList.remove('d-none');
                    fechaEntregaGroup.style.display = 'block';
                    document.getElementById('fechaEntrega').required = true;
                    document.getElementById('tareaModalLabel').textContent = 'Subir Tarea con Entrega';
                });

                // Manejador para volver a la selección
                volverBtn.addEventListener('click', function() {
                    resetModal();
                });

                // Modal de seguimiento
                document.querySelectorAll('.seguimientoBtn').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const tareaId = this.getAttribute('data-tarea-id');
                        try {
                            const response = await fetch(
                                `/profesores/tareas/${tareaId}/seguimiento`);
                            if (!response.ok) throw new Error('Error en la respuesta');

                            const data = await response.json();

                            // Actualizar el contenido del modal
                            document.getElementById('seguimientoModalLabel').textContent =
                                `Seguimiento: ${data.tarea.titulo}`;

                            // Información de la tarea
                            const tareaInfo = document.getElementById('tareaInfo');
                            tareaInfo.innerHTML = `
                            <div class="alert alert-info">
                                <h6><strong>${data.tarea.titulo}</strong></h6>
                                <p class="mb-1">${data.tarea.descripcion || 'Sin descripción'}</p>
                                <small>Fecha de entrega: ${data.tarea.fecha_entrega || 'No especificada'}</small>
                            </div>
                        `;

                            // Tabla de seguimiento
                            const seguimientoContent = document.getElementById(
                                'seguimientoContent');
                            if (data.entregas && data.entregas.length > 0) {
                                let tabla = `
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th>Alumno</th>
                                                <th>Estado</th>
                                                <th>Fecha Entrega</th>
                                                <th>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            `;

                                data.entregas.forEach(entrega => {
                                    const estado = entrega.entrego ?
                                        '<span class="badge badge-success">Entregado</span>' :
                                        '<span class="badge badge-danger">No entregado</span>';

                                    const nota = entrega.nota ?
                                        `<span class="badge badge-primary">${entrega.nota}</span>` :
                                        '<span class="text-muted">-</span>';

                                    tabla += `
                                    <tr class="text-center">
                                        <td class="font-weight-medium">${entrega.alumno}</td>
                                        <td>${estado}</td>
                                        <td>${entrega.fecha_entrega || '-'}</td>
                                        <td>${nota}</td>
                                    </tr>
                                `;
                                });

                                tabla += '</tbody></table></div>';
                                seguimientoContent.innerHTML = tabla;

                                // Mostrar botón de corrección si hay entregas
                                const btnCorregir = document.getElementById('btnCorregir');
                                btnCorregir.href = `/profesores/tareas/${tareaId}/corregir`;
                                btnCorregir.classList.remove('d-none');
                            } else {
                                seguimientoContent.innerHTML = `
                                <div class="text-center py-4">
                                    <i class="feather icon-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">No hay entregas para esta tarea.</p>
                                </div>
                            `;
                                document.getElementById('btnCorregir').classList.add('d-none');
                            }

                            $('#seguimientoModal').modal('show');

                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error al cargar el seguimiento de la tarea');
                        }
                    });
                });

                // Modal de eliminación
                document.querySelectorAll('.eliminarBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        tareaIdParaEliminar = this.getAttribute('data-tarea-id');
                        const tareaTitle = this.getAttribute('data-tarea-titulo');
                        document.getElementById('eliminarModalLabel').textContent =
                            `Eliminar: ${tareaTitle}`;
                        $('#eliminarModal').modal('show');
                    });
                });

                // Confirmar eliminación
                document.getElementById('confirmarEliminar').addEventListener('click', async function() {
                    if (!tareaIdParaEliminar) return;

                    try {
                        const response = await fetch(`/profesores/tareas/${tareaIdParaEliminar}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Content-Type': 'application/json'
                            }
                        });

                        if (response.ok) {
                            $('#eliminarModal').modal('hide');
                            location.reload(); // Recargar la página para mostrar los cambios
                        } else {
                            throw new Error('Error al eliminar');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error al eliminar la tarea');
                    }
                });

                // Auto-hide success alerts
                const successAlert = document.querySelector('.alert-success');
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.opacity = '0';
                        setTimeout(() => successAlert.remove(), 500);
                    }, 3000);
                }
            });
        </script>

</x-layouts.profesores.dashboard>
