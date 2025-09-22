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
                            <button class="btn btn-primary btn-sm btn-custom" id="openModalBtn">
                                <i class="fas fa-plus mr-1"></i>
                                Subir nuevo archivo
                            </button>
                            <!-- Botón de prueba temporal -->
                            <button type="button" class="btn btn-danger btn-sm ml-2" onclick="testModal()">
                                Test Modal
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
                                <i class="fas fa-book-open mr-1"></i>
                                Módulos de Teoría
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tareas-tab" data-toggle="tab" href="#tareas" role="tab"
                                aria-controls="tareas" aria-selected="false">
                                <i class="fas fa-calendar mr-1"></i>
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
                                                        class="btn btn-outline-primary btn-sm btn-custom"
                                                        target="_blank">
                                                        <i class="fas fa-download mr-1"></i>
                                                        Ver archivo
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-danger btn-sm btn-custom eliminarBtn"
                                                    data-tarea-id="{{ $modulo['id'] }}"
                                                    data-tarea-titulo="{{ $modulo['titulo'] }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-book-open mb-2" style="font-size: 2rem;"></i>
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
                                                @if (isset($tarea['fecha_entrega']) && $tarea['fecha_entrega'] !== '-')
                                                    @php
                                                        // Usar la fecha original de Carbon para determinar si está vencida
                                                        $esVencida =
                                                            isset($tarea['fecha_entrega_carbon']) &&
                                                            $tarea['fecha_entrega_carbon']
                                                                ? $tarea['fecha_entrega_carbon']->isPast()
                                                                : false;
                                                    @endphp
                                                    <span
                                                        class="badge {{ $esVencida ? 'badge-danger' : 'badge-success' }}">
                                                        {{ $tarea['fecha_entrega'] }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($tarea['archivo']))
                                                    <a href="{{ route('profesores.tareas.descargar', $tarea['id']) }}"
                                                        class="btn btn-outline-primary btn-sm btn-custom"
                                                        target="_blank">
                                                        <i class="fas fa-download mr-1"></i>
                                                        Ver archivo
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button
                                                        class="btn btn-outline-info btn-sm btn-custom seguimientoBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Seguimiento
                                                    </button>
                                                    <button
                                                        class="btn btn-outline-danger btn-sm btn-custom eliminarBtn"
                                                        data-tarea-id="{{ $tarea['id'] }}"
                                                        data-tarea-titulo="{{ $tarea['titulo'] }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-calendar mb-2" style="font-size: 2rem;"></i>
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
                                        class="btn btn-outline-primary btn-block h-100 py-3 btn-custom">
                                        <i class="fas fa-book-open mb-2" style="font-size: 2rem;"></i>
                                        <br>
                                        <strong>Módulo de Teoría</strong>
                                        <br>
                                        <small class="text-muted">Material de estudio</small>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" id="btnTarea"
                                        class="btn btn-outline-success btn-block h-100 py-3 btn-custom">
                                        <i class="fas fa-calendar mb-2" style="font-size: 2rem;"></i>
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
                                <button type="button" class="btn btn-secondary btn-custom" id="volverSeleccion">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Volver
                                </button>
                                <button type="submit" class="btn btn-primary btn-custom">
                                    <i class="fas fa-upload mr-1"></i>
                                    Subir Archivo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de seguimiento --}}
        <div class="modal fade" id="seguimientoModal" tabindex="-1" role="dialog"
            aria-labelledby="seguimientoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content modal-custom">
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="seguimientoModalLabel">
                            <i class="fas fa-eye mr-2"></i>
                            Seguimiento de Tarea
                        </h5>
                        <button type="button" class="close close-custom" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-body-custom">
                        <div id="tareaInfo" class="mb-4">
                            {{-- Info de la tarea se carga dinámicamente --}}
                        </div>
                        <div id="seguimientoContent">
                            {{-- Contenido del seguimiento se carga via AJAX --}}
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-custom">
                        <a href="#" id="btnCorregir" class="btn btn-primary btn-custom d-none">
                            <i class="fas fa-edit mr-1"></i>
                            Ir a Corregir
                        </a>
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de confirmación eliminar --}}
        <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog"
            aria-labelledby="eliminarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <div class="modal-header modal-header-danger">
                        <h5 class="modal-title" id="eliminarModalLabel">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Confirmar Eliminación
                        </h5>
                        <button type="button" class="close close-custom" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-body-custom text-center">
                        <div class="warning-icon mb-3">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h6 class="mb-3 font-weight-bold">¿Está seguro de que desea eliminar esta tarea?</h6>
                        <p class="text-muted mb-0">Esta acción no se puede deshacer y eliminará permanentemente el
                            archivo y todos los datos asociados.</p>
                    </div>
                    <div class="modal-footer modal-footer-custom justify-content-center">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>
                            Cancelar
                        </button>
                        <button type="button" id="confirmarEliminar" class="btn btn-danger btn-custom">
                            <i class="fas fa-trash mr-1"></i>
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            /* Estilos generales para el sistema de tareas */
            .custom-file-label::after {
                content: "Seleccionar";
                background-color: #007bff;
                border-color: #007bff;
                color: white;
                font-weight: 500;
            }

            /* Estilos mejorados para modales */
            .modal-custom {
                border: none;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }

            .modal-header-custom {
                background: linear-gradient(135deg, #007bff, #0056b3);
                color: white;
                border-bottom: none;
                padding: 1rem 1.5rem;
            }

            .modal-header-danger {
                background: linear-gradient(135deg, #dc3545, #c82333);
                color: white;
                border-bottom: none;
                padding: 1rem 1.5rem;
            }

            .modal-body-custom {
                padding: 1.5rem;
                background-color: #f8f9fa;
            }

            .modal-footer-custom {
                background-color: #f8f9fa;
                border-top: 1px solid #e9ecef;
                padding: 1rem 1.5rem;
            }

            .close-custom {
                color: white;
                opacity: 0.8;
                font-size: 1.5rem;
                font-weight: 300;
            }

            .close-custom:hover {
                color: white;
                opacity: 1;
            }

            .btn-custom {
                border-radius: 6px;
                font-weight: 500;
                padding: 0.5rem 1.2rem;
                transition: all 0.3s ease;
                text-transform: none;
            }

            .btn-custom:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .warning-icon {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            /* Mejoras en la visualización de seguimiento */
            #seguimientoContent table {
                width: 100%;
                margin: 0 auto;
                background-color: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            #seguimientoContent th,
            #seguimientoContent td {
                text-align: center;
                padding: 0.75rem;
                vertical-align: middle;
            }

            #seguimientoContent th {
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                color: #495057;
            }

            #seguimientoContent tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            /* Personalización de pestañas Bootstrap */
            .nav-tabs {
                border-bottom: 2px solid #e9ecef;
            }

            .nav-tabs .nav-link {
                border: 1px solid transparent;
                border-radius: 8px 8px 0 0;
                transition: all 0.3s ease;
                font-weight: 500;
                color: #6c757d;
            }

            .nav-tabs .nav-link.active {
                color: #007bff;
                background-color: #fff;
                border-color: #e9ecef #e9ecef #fff;
                border-bottom-color: #fff;
                font-weight: 600;
                box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
            }

            .nav-tabs .nav-link:hover:not(.active) {
                border-color: #e9ecef #e9ecef #e9ecef;
                background-color: #f8f9fa;
                color: #495057;
            }

            /* Mejoras en las tablas */
            .table {
                background-color: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .table th {
                font-weight: 600;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                color: #495057;
                border-bottom: 2px solid #dee2e6;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
                transform: scale(1.001);
                transition: all 0.2s ease;
            }

            /* Botones más elegantes */
            .btn-group .btn {
                border-radius: 6px;
                margin-right: 4px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-group .btn:last-child {
                margin-right: 0;
            }

            .btn-group .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            }

            /* Estilo para badges de fecha */
            .badge {
                font-weight: 500;
                font-size: 0.8rem;
                border-radius: 4px;
                padding: 0.4rem 0.6rem;
            }

            /* Cards mejoradas */
            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            }

            .card-header {
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                border-bottom: 1px solid #e9ecef;
                border-radius: 10px 10px 0 0;
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
                    margin-bottom: 4px;
                    margin-right: 0;
                    border-radius: 6px;
                }

                .modal-dialog {
                    margin: 1rem;
                }

                .modal-body-custom {
                    padding: 1rem;
                }
            }

            /* Animaciones sutiles */
            .btn,
            .card,
            .table {
                transition: all 0.3s ease;
            }

            /* Estado de carga */
            .loading {
                opacity: 0.6;
                pointer-events: none;
            }

            .loading::after {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                width: 20px;
                height: 20px;
                margin: -10px 0 0 -10px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #007bff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM cargado, inicializando sistema de tareas...');

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

                // Verificar que los elementos existen
                console.log('Elementos encontrados:', {
                    btnModulo: !!btnModulo,
                    btnTarea: !!btnTarea,
                    modalSeleccion: !!modalSeleccion,
                    modalFormulario: !!modalFormulario,
                    archivoInput: !!archivoInput
                });

                // Configurar input de archivo personalizado
                if (archivoInput) {
                    archivoInput.addEventListener('change', function() {
                        const fileName = this.files[0] ? this.files[0].name : 'Seleccionar archivo (máx. 10MB)';
                        this.nextElementSibling.innerHTML = fileName;
                    });
                }

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

                // Modal de eliminación - Versión mejorada con debugging
                function initEliminarBtns() {
                    console.log('🔧 Inicializando botones de eliminar...');

                    // Esperar un poco para que los elementos se carguen
                    setTimeout(() => {
                        const eliminarBtns = document.querySelectorAll('.eliminarBtn');
                        console.log('📊 Botones encontrados:', eliminarBtns.length);
                        console.log('📊 Botones:', Array.from(eliminarBtns).map(btn => ({
                            id: btn.getAttribute('data-tarea-id'),
                            titulo: btn.getAttribute('data-tarea-titulo')
                        })));

                        if (eliminarBtns.length === 0) {
                            console.warn('⚠️ No se encontraron botones con clase .eliminarBtn');
                            console.log('📋 Todos los botones en la página:', document.querySelectorAll(
                                'button').length);
                            return;
                        }

                        eliminarBtns.forEach((btn, index) => {
                            console.log(`🎯 Configurando botón ${index + 1}:`, btn);

                            // Remover listeners previos
                            btn.removeEventListener('click', handleEliminarClick);

                            // Agregar nuevo listener
                            btn.addEventListener('click', handleEliminarClick);

                            // Verificar que el listener se agregó
                            console.log(`✅ Listener agregado a botón ${index + 1}`);
                        });

                        console.log('✨ Inicialización completada');
                    }, 500);
                }

                // Función para manejar click en eliminar
                function handleEliminarClick(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('🎯 Botón eliminar clickeado!');
                    console.log('🎯 Evento:', e);
                    console.log('🎯 Elemento:', this);

                    tareaIdParaEliminar = this.getAttribute('data-tarea-id');
                    const tareaTitle = this.getAttribute('data-tarea-titulo');

                    console.log('📋 ID de tarea:', tareaIdParaEliminar);
                    console.log('📋 Título de tarea:', tareaTitle);

                    if (!tareaIdParaEliminar) {
                        console.error('❌ No se encontró ID de tarea');
                        alert('Error: No se puede obtener el ID de la tarea');
                        return;
                    }

                    // Actualizar título del modal
                    const modalLabel = document.getElementById('eliminarModalLabel');
                    if (modalLabel) {
                        modalLabel.innerHTML = `
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Eliminar: ${tareaTitle || 'Tarea'}
                        `;
                        console.log('✅ Título del modal actualizado');
                    } else {
                        console.error('❌ No se encontró el elemento eliminarModalLabel');
                    }

                    // Verificar que el modal existe
                    const modal = document.getElementById('eliminarModal');
                    if (!modal) {
                        console.error('❌ Modal eliminación no encontrado');
                        alert('Error: Modal de eliminación no disponible');
                        return;
                    }

                    // Mostrar modal - método directo
                    console.log('🚀 Mostrando modal...');
                    try {
                        if (typeof $ !== 'undefined' && $.fn.modal) {
                            console.log('📱 Usando jQuery para mostrar modal');
                            console.log('📱 Modal jQuery object:', $('#eliminarModal'));
                            console.log('📱 Modal element exists:', $('#eliminarModal').length > 0);

                            $('#eliminarModal').modal('show');

                            // Verificar después de mostrar
                            setTimeout(() => {
                                const isVisible = $('#eliminarModal').hasClass('show');
                                console.log('📱 Modal visible después de show:', isVisible);

                                if (!isVisible) {
                                    console.log('⚠️ Modal no visible, intentando método manual...');
                                    forceShowModal();
                                }
                            }, 300);
                        } else {
                            console.log('📱 jQuery no disponible, usando método manual');
                            forceShowModal();
                        }
                    } catch (error) {
                        console.error('❌ Error al mostrar modal:', error);
                        console.log('🔄 Intentando método manual como fallback...');
                        forceShowModal();
                    }
                }

                // Función para cerrar modal manualmente (backup)
                function closeEliminarModal() {
                    $('#eliminarModal').modal('hide');
                }

                // Inicializar botones de eliminar al cargar la página
                console.log('🔄 Ejecutando initEliminarBtns...');
                initEliminarBtns();

                // Re-inicializar después de que todo se cargue
                setTimeout(() => {
                    console.log('🔄 Re-inicializando botones después de 2 segundos...');
                    initEliminarBtns();
                }, 2000);

                // Test simple para verificar que funciona
                console.log('=== TESTING MODAL ===');
                console.log('jQuery disponible:', typeof $ !== 'undefined');
                console.log('Bootstrap disponible:', typeof bootstrap !== 'undefined');
                console.log('Modal elemento existe:', !!document.getElementById('eliminarModal'));

                // Función de test para abrir modal directamente
                window.testModal = function() {
                    console.log('🔧 Ejecutando test del modal...');
                    forceShowModal();
                };

                // Ejecutar test automáticamente
                setTimeout(() => {
                    console.log('Ejecutando test automático en 2 segundos...');
                    // window.testModal();
                }, 2000);

                // Confirmar eliminación
                const confirmarBtn = document.getElementById('confirmarEliminar');
                if (confirmarBtn) {
                    confirmarBtn.addEventListener('click', async function() {
                        if (!tareaIdParaEliminar) {
                            console.error('No hay tarea seleccionada para eliminar');
                            return;
                        }

                        // Deshabilitar botón durante la eliminación
                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Eliminando...';
                        this.classList.add('loading');

                        try {
                            console.log('Eliminando tarea ID:', tareaIdParaEliminar);

                            const response = await fetch(`/profesores/tareas/${tareaIdParaEliminar}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            });

                            console.log('Respuesta del servidor:', response.status);

                            if (response.ok) {
                                const data = await response.json();
                                console.log('Tarea eliminada exitosamente:', data);

                                // Cerrar modal
                                closeEliminarModal();

                                // Mostrar mensaje de éxito
                                mostrarAlerta('success', data.message || 'Tarea eliminada correctamente');

                                // Recargar la página después de un breve delay
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);

                            } else {
                                const errorData = await response.json();
                                throw new Error(errorData.message || 'Error al eliminar la tarea');
                            }
                        } catch (error) {
                            console.error('Error al eliminar:', error);
                            mostrarAlerta('error', 'Error al eliminar la tarea: ' + error.message);
                        } finally {
                            // Restaurar botón
                            this.disabled = false;
                            this.innerHTML = '<i class="fas fa-trash mr-1"></i> Eliminar';
                            this.classList.remove('loading');
                        }
                    });
                }

                // Función para mostrar alertas
                function mostrarAlerta(tipo, mensaje) {
                    // Remover alertas existentes
                    const alertasExistentes = document.querySelectorAll('.alert-dynamic');
                    alertasExistentes.forEach(alerta => alerta.remove());

                    // Crear nueva alerta
                    const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
                    const iconClass = tipo === 'success' ? 'check-circle' : 'exclamation-triangle';

                    const alert = document.createElement('div');
                    alert.className = `alert ${alertClass} alert-dismissible fade show alert-dynamic`;
                    alert.style.position = 'fixed';
                    alert.style.top = '20px';
                    alert.style.right = '20px';
                    alert.style.zIndex = '9999';
                    alert.style.minWidth = '300px';
                    alert.innerHTML = `
                        <i class="fas fa-${iconClass} mr-2"></i>
                        ${mensaje}
                        <button type="button" class="close" onclick="this.parentElement.remove()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    `;

                    // Insertar en el body
                    document.body.appendChild(alert);

                    // Auto eliminar después de 5s
                    setTimeout(() => {
                        if (alert && alert.parentNode) {
                            alert.remove();
                        }
                    }, 5000);
                }

                // Auto-hide success alerts
                const successAlert = document.querySelector('.alert-success');
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.opacity = '0';
                        setTimeout(() => successAlert.remove(), 500);
                    }, 3000);
                }
            });

            // =============================================================================
            // FUNCIÓN DE DEBUGGING SIMPLE PARA EL MODAL
            // =============================================================================
            console.log('Cargando función de debug del modal...');

            // Forzar mostrar modal con diferentes métodos
            function forceShowModal() {
                const modal = document.getElementById('eliminarModal');
                if (!modal) {
                    console.error('❌ Modal no encontrado en el DOM');
                    return;
                }

                console.log('✅ Modal encontrado:', modal);
                console.log('📊 Modal classes:', modal.className);
                console.log('📊 Modal style display:', modal.style.display);

                // Remover backdrop existente
                const existingBackdrop = document.querySelector('.modal-backdrop');
                if (existingBackdrop) {
                    console.log('🧹 Removiendo backdrop existente');
                    existingBackdrop.remove();
                }

                // Método manual con todas las clases Bootstrap
                console.log('📝 Usando método manual completo');

                // Resetear modal
                modal.style.display = '';
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');

                // Mostrar modal
                modal.style.display = 'block';
                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
                modal.setAttribute('aria-modal', 'true');
                document.body.classList.add('modal-open');

                // Crear backdrop
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.id = 'modal-backdrop-manual';
                document.body.appendChild(backdrop);

                // Agregar evento para cerrar con backdrop
                backdrop.addEventListener('click', function() {
                    forceHideModal();
                });

                console.log('✅ Modal mostrado manualmente');
                console.log('📊 Modal final classes:', modal.className);
                console.log('📊 Body classes:', document.body.className);
            }

            // Función para cerrar modal manual
            function forceHideModal() {
                console.log('🔄 Cerrando modal manualmente...');
                const modal = document.getElementById('eliminarModal');
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    modal.setAttribute('aria-hidden', 'true');
                    modal.removeAttribute('aria-modal');
                    document.body.classList.remove('modal-open');

                    // Remover backdrop manual
                    const backdrop = document.getElementById('modal-backdrop-manual');
                    if (backdrop) backdrop.remove();

                    // Remover cualquier backdrop
                    const allBackdrops = document.querySelectorAll('.modal-backdrop');
                    allBackdrops.forEach(bd => bd.remove());

                    console.log('✅ Modal cerrado');
                }
            }

            // Exponer funciones globalmente para poder usar desde consola
            window.forceShowModal = forceShowModal;
            window.forceHideModal = forceHideModal;
            window.initEliminarBtns = initEliminarBtns; // Hacer global
            window.handleEliminarClick = handleEliminarClick; // Hacer global
            window.testEliminarBtn = function() {
                console.log('🧪 Probando botón de eliminar...');
                const firstBtn = document.querySelector('.eliminarBtn');
                if (firstBtn) {
                    console.log('✅ Botón encontrado, simulando click...');
                    firstBtn.click();
                } else {
                    console.error('❌ No se encontró ningún botón con clase .eliminarBtn');
                }
            };
            window.reinitBtns = function() {
                console.log('🔄 Re-inicializando botones manualmente...');
                initEliminarBtns();
            };
            window.testModalDirectly = function() {
                console.log('🧪 Probando modal directamente...');
                console.log('Modal element:', document.getElementById('eliminarModal'));
                console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'N/A');

                // Probar diferentes métodos
                try {
                    console.log('Método 1: jQuery modal show');
                    $('#eliminarModal').modal('show');

                    setTimeout(() => {
                        console.log('Modal visible después de jQuery:', $('#eliminarModal').hasClass('show'));
                    }, 1000);
                } catch (e) {
                    console.error('Error con jQuery:', e);
                }
            };

            console.log('🚀 Funciones de debug disponibles:');
            console.log('  - forceShowModal(): Forzar mostrar modal');
            console.log('  - forceHideModal(): Forzar ocultar modal');
            console.log('  - testEliminarBtn(): Probar botón eliminar');
            console.log('  - reinitBtns(): Re-inicializar botones');
            console.log('  - testModalDirectly(): Probar modal con jQuery directamente');
        </script>

</x-layouts.profesores.dashboard>
