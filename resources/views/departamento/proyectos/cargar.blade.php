{{-- filepath: c:\xampp\htdocs\Laravel\escuela\resources\views\profesores\proyectos\cargar.blade.php --}}
<x-layouts.departamento.dashboard proyectos titulo="Proyectos"
    title="Mi Técnica | Panel de Jefes de Departamento - Proyectos">

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3 mb-md-0">
                            <!-- Botón volver -->
                            <a href="{{ route('profesores.proyectos.index') }}"
                                class="btn btn-outline-secondary btn-sm mb-3 mb-md-0 mr-md-3">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>

                            <!-- Información -->
                            <div class="text-center text-md-left">
                                <h1 class="h4 mb-1">{{ $cupofInfo->materia->nombre }}</h1>
                                <p class="text-muted mb-0">
                                    {{ $cupofInfo->curso->ano }}º {{ $cupofInfo->curso->division }}
                                    @if ($cupofInfo->grupo)
                                        - {{ $cupofInfo->grupo->nombre }}
                                    @endif
                                    | Turno: {{ $cupofInfo->turno }}
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="feather icon-alert-circle mr-2"></i>
                    {{ session('error') }}
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

            <!-- Mis Proyectos -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="h5 mb-1">Mis Proyectos</h2>
                            <p class="text-muted mb-0">
                                @if ($misProyectos->count() > 0)
                                    Tienes {{ $misProyectos->count() }}
                                    {{ $misProyectos->count() == 1 ? 'proyecto cargado' : 'proyectos cargados' }}
                                @else
                                    Gestiona los proyectos de esta materia
                                @endif
                            </p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <button type="button" id="openModalBtn" class="btn btn-primary btn-sm">
                                <i class="feather icon-upload mr-1"></i> Subir nuevo proyecto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($misProyectos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha de carga</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($misProyectos as $proyecto)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas {{ $proyecto->icono }} mr-2 text-primary"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <a href="{{ route('profesores.proyectos.descargar', $proyecto->id) }}"
                                                            class="text-primary download-link font-weight-bold"
                                                            target="_blank">
                                                            {{ $proyecto->nombre_archivo }}
                                                        </a>
                                                        <br>
                                                        <span class="badge badge-{{ $proyecto->color_badge }}">
                                                            {{ strtoupper($proyecto->extension) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-light">{{ $proyecto->tamanio_formateado }}</span>
                                            </td>
                                            <td>
                                                <i class="feather icon-calendar mr-1 text-muted"></i>
                                                {{ $proyecto->created_at->format('d/m/Y') }}
                                                <br>
                                                <small
                                                    class="text-muted">{{ $proyecto->created_at->format('H:i') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('profesores.proyectos.descargar', $proyecto->id) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank"
                                                        title="Descargar">
                                                        <i class="feather icon-download"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger eliminar-proyecto-btn"
                                                        data-id="{{ $proyecto->id }}"
                                                        data-nombre="{{ $proyecto->nombre_archivo }}" title="Eliminar">
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
                        <div class="text-center py-4">
                            <i class="feather icon-folder text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">No has subido proyectos aún</h5>
                            <p class="text-muted mb-3">Comienza subiendo tu primer proyecto para esta materia</p>
                            <button type="button" id="openModalBtn2" class="btn btn-primary">
                                <i class="feather icon-upload mr-1"></i> Subir proyecto
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para subir proyecto -->
    <div id="proyectoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="proyectoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proyectoModalLabel">Subir Nuevo Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formProyecto" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cupof" value="{{ $cupofInfo->cupof }}">
                        <input type="hidden" name="id_revista" value="{{ $miRevista->id }}">

                        <div class="alert alert-info">
                            <i class="feather icon-info mr-2"></i>
                            <strong>Información:</strong> Sube tu proyecto en formato PDF, Word, Excel, PowerPoint o
                            archivos comprimidos (máximo 20 MB).
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Archivo del proyecto <span
                                    class="text-danger">*</span></label>
                            <div class="file-upload-container">
                                <input type="file" id="archivo" name="archivo"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar" required
                                    class="file-input">
                                <div class="file-upload-display d-flex align-items-center justify-content-between">
                                    <span id="fileNameDisplay" class="file-name-display text-muted ml-2">
                                        Ningún archivo seleccionado
                                    </span>
                                    <button type="button" class="file-upload-btn">
                                        <i class="feather icon-upload mr-2"></i>Seleccionar archivo
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Formatos permitidos: PDF, Word, Excel, PowerPoint, ZIP, RAR. Tamaño máximo: 20 MB.
                            </small>
                        </div>

                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnSubir" class="btn btn-primary">
                                <i class="feather icon-upload mr-1"></i> Subir proyecto
                            </button>
                        </div>
                    </form>
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
                        <h6>¿Estás seguro de que quieres eliminar este proyecto?</h6>
                        <p class="text-muted mb-2"><strong id="nombreProyectoEliminar"></strong></p>
                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmarEliminar" class="btn btn-danger">
                        <i class="feather icon-trash-2 mr-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let proyectoIdParaEliminar = null;

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

            // Abrir modal
            const openModalBtn = document.getElementById('openModalBtn');
            const openModalBtn2 = document.getElementById('openModalBtn2');

            [openModalBtn, openModalBtn2].forEach(btn => {
                btn?.addEventListener('click', () => {
                    $('#proyectoModal').modal('show');
                });
            });

            // Funcionalidad del selector de archivo
            const fileUploadDisplay = document.querySelector('.file-upload-display');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileUploadBtn = document.querySelector('.file-upload-btn');
            const archivoInput = document.getElementById('archivo');

            fileUploadDisplay?.addEventListener('click', () => {
                archivoInput?.click();
            });

            if (archivoInput) {
                archivoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        // Validar tamaño del archivo (20MB máximo)
                        const maxSize = 20 * 1024 * 1024;
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
                                    '<i class="feather icon-upload mr-2"></i>Seleccionar archivo';
                            }
                            this.value = '';
                        } else {
                            if (fileNameDisplay) {
                                fileNameDisplay.textContent = file.name;
                                fileNameDisplay.classList.add('has-file');
                                fileNameDisplay.style.color = '';
                            }
                            if (fileUploadDisplay) {
                                fileUploadDisplay.classList.add('file-selected');
                                fileUploadDisplay.style.borderColor = '';
                            }
                            if (fileUploadBtn) {
                                fileUploadBtn.innerHTML =
                                    '<i class="feather icon-check mr-2"></i>Archivo seleccionado';
                            }
                        }
                    } else {
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
                                '<i class="feather icon-upload mr-2"></i>Seleccionar archivo';
                        }
                    }
                });
            }

            // Limpiar modal al cerrar
            $('#proyectoModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('formProyecto');
                if (form) {
                    form.reset();
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
                            '<i class="feather icon-upload mr-2"></i>Seleccionar archivo';
                    }
                }
            });

            // Manejar envío del formulario
            const formProyecto = document.getElementById('formProyecto');
            const btnSubir = document.getElementById('btnSubir');

            if (formProyecto && btnSubir) {
                formProyecto.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const formData = new FormData(formProyecto);

                    btnSubir.disabled = true;
                    btnSubir.innerHTML = '<i class="feather icon-loader mr-1"></i> Subiendo...';

                    try {
                        const response = await fetch('{{ route('profesores.proyectos.guardar') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            $('#proyectoModal').modal('hide');
                            mostrarMensaje(data.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            throw new Error(data.message || 'Error al guardar el proyecto');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        mostrarMensaje('Error al subir el proyecto: ' + error.message, 'error');
                    } finally {
                        btnSubir.disabled = false;
                        btnSubir.innerHTML = '<i class="feather icon-upload mr-1"></i> Subir proyecto';
                    }
                });
            }

            // Modal eliminar
            document.querySelectorAll('.eliminar-proyecto-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    proyectoIdParaEliminar = this.getAttribute('data-id');
                    const nombreProyecto = this.getAttribute('data-nombre');
                    document.getElementById('nombreProyectoEliminar').textContent = nombreProyecto;
                    $('#eliminarModal').modal('show');
                });
            });

            // Confirmar eliminación
            document.getElementById('confirmarEliminar')?.addEventListener('click', async () => {
                if (!proyectoIdParaEliminar) return;

                const btnConfirmar = document.getElementById('confirmarEliminar');
                const originalText = btnConfirmar.innerHTML;

                btnConfirmar.disabled = true;
                btnConfirmar.innerHTML = '<i class="feather icon-loader mr-1"></i> Eliminando...';

                try {
                    const url = '{{ route('profesores.proyectos.eliminar', ':id') }}'.replace(':id',
                        proyectoIdParaEliminar);

                    const response = await fetch(url, {
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
                        mostrarMensaje(data.message || 'Proyecto eliminado correctamente', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        throw new Error(data.message || 'Error desconocido al eliminar el proyecto');
                    }

                } catch (error) {
                    console.error('Error al eliminar proyecto:', error);
                    $('#eliminarModal').modal('hide');
                    mostrarMensaje('Error al eliminar el proyecto: ' + error.message, 'error');
                } finally {
                    btnConfirmar.disabled = false;
                    btnConfirmar.innerHTML = originalText;
                    proyectoIdParaEliminar = null;
                }
            });

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

    {{-- Estilos adicionales --}}
    <style>
        /* Mejoras visuales */
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

        .download-link {
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 500;
        }

        .download-link:hover {
            text-decoration: underline;
            transform: translateX(2px);
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

            .btn-group {
                display: flex;
                flex-direction: column;
            }

            .btn-group .btn {
                margin-bottom: 0.25rem;
            }
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .table td {
            vertical-align: middle;
        }

        .alert-temp {
            position: relative;
            z-index: 1050;
        }

        /* Animaciones suaves */
        .btn {
            transition: all 0.2s ease;
        }

        .modal {
            backdrop-filter: blur(3px);
        }

        /* Efectos hover mejorados */
        .btn-outline-primary:hover,
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
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Iconos más grandes en estados vacíos */
        .text-center i[style*="font-size: 3rem"] {
            opacity: 0.3;
        }

        /* Badge personalizado */
        .badge-light {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        /* Mejora visual para thead */
        .thead-light th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    </style>

</x-layouts.departamento.dashboard>
