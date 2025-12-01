@extends('app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            padding-left: 12px;
            padding-right: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            background-color: transparent;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 1px;
            top: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: 0;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-results__option {
            padding: 8px 12px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            padding: 8px;
            border-radius: 0.25rem;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Select de Estado */
        .select-estado {
            height: 38px !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 0.9375rem !important;
            line-height: 1.5 !important;
            background-color: white !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 8px !important;
        }

        .select-estado option {
            padding: 8px;
            line-height: 1.5;
        }

        /* Asegurar que los selects normales también se vean bien */
        .modal-body select.form-control:not(.select2-hidden-accessible) {
            height: 38px;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
        }
    </style>
@endsection

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Departamentos
        </h2>
    </x-slot>

    <div class="departamentos-container">
        {{-- Header --}}
        <div class="departamentos-header">
            <div class="header-content">
                <h1 class="main-title">Departamentos</h1>
                <p class="main-subtitle">Gestione los departamentos y sus materias asignadas</p>
            </div>
            <button class="btn-primary" data-toggle="modal" data-target="#modalCrearDepartamento">
                <i class="feather icon-plus"></i>
                Nuevo Departamento
            </button>
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

        {{-- Barra de búsqueda --}}
        <div class="search-filter-section">
            <div class="search-controls">
                <div class="search-wrapper">
                    <i class="feather icon-search search-icon"></i>
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="Buscar departamento por nombre o jefe...">
                    <button class="clear-search" id="clearSearch" style="display: none;">
                        <i class="feather icon-x"></i>
                    </button>
                </div>
            </div>
            <div class="search-stats">
                <span id="searchResults"></span>
            </div>
        </div>

        {{-- Lista de departamentos --}}
        @if (count($departamentos) > 0)
            <div class="departamentos-grid" id="departamentosGrid">
                @foreach ($departamentos as $departamento)
                    <div class="departamento-card" data-nombre="{{ strtolower($departamento->nombre) }}"
                        data-jefe="{{ strtolower($departamento->tipoUsuario->persona->apellido . ' ' . $departamento->tipoUsuario->persona->nombre) }}">

                        {{-- Header de la tarjeta --}}
                        <div class="card-header-custom">
                            <div class="departamento-info">
                                <h3 class="departamento-nombre">
                                    <i class="feather icon-briefcase mr-2"></i>
                                    {{ $departamento->nombre }}
                                </h3>
                                <span class="badge badge-{{ $departamento->estado == 'A' ? 'success' : 'secondary' }}">
                                    {{ $departamento->estado == 'A' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>

                        {{-- Cuerpo de la tarjeta --}}
                        <div class="card-body-custom">
                            {{-- Jefe del departamento --}}
                            <div class="info-row">
                                <i class="feather icon-user text-primary"></i>
                                <div>
                                    <strong>Jefe:</strong>
                                    <p class="mb-0">
                                        {{ $departamento->tipoUsuario->persona->apellido }},
                                        {{ $departamento->tipoUsuario->persona->nombre }}
                                    </p>
                                </div>
                            </div>

                            {{-- Descripción --}}
                            @if ($departamento->descripcion)
                                <div class="info-row">
                                    <i class="feather icon-file-text text-info"></i>
                                    <div>
                                        <strong>Descripción:</strong>
                                        <p class="mb-0">{{ $departamento->descripcion }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Materias asignadas --}}
                            <div class="info-row">
                                <i class="feather icon-book text-success"></i>
                                <div class="flex-grow-1">
                                    <strong>Materias ({{ count($departamento->materias) }}):</strong>
                                    @if (count($departamento->materias) > 0)
                                        <div class="materias-tags mt-2">
                                            @foreach ($departamento->materias->take(3) as $materia)
                                                <span class="badge badge-light">{{ $materia->nombre }}</span>
                                            @endforeach
                                            @if (count($departamento->materias) > 3)
                                                <span class="badge badge-secondary">
                                                    +{{ count($departamento->materias) - 3 }} más
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Sin materias asignadas</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="card-footer-custom">
                            <button class="btn btn-sm btn-info" onclick="verDetalles({{ $departamento->id }})"
                                data-toggle="modal" data-target="#modalDetalles">
                                <i class="feather icon-eye"></i> Ver
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="editarDepartamento({{ $departamento->id }})"
                                data-toggle="modal" data-target="#modalEditarDepartamento">
                                <i class="feather icon-edit"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-success" onclick="gestionarMaterias({{ $departamento->id }})"
                                data-toggle="modal" data-target="#modalMaterias">
                                <i class="feather icon-book-open"></i> Materias
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="confirmarEliminar({{ $departamento->id }}, '{{ $departamento->nombre }}')">
                                <i class="feather icon-trash-2"></i> Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="no-results" id="noResults" style="display: none;">
                <i class="feather icon-search" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="text-muted">No se encontraron resultados</h5>
            </div>
        @else
            <div class="empty-state">
                <i class="feather icon-briefcase"></i>
                <h3>No hay departamentos registrados</h3>
                <p>Comience creando un nuevo departamento</p>
                <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalCrearDepartamento">
                    <i class="feather icon-plus"></i> Crear Departamento
                </button>
            </div>
        @endif
    </div>

    {{-- Modal: Crear Departamento --}}
    <div class="modal fade" id="modalCrearDepartamento" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('departamentos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="feather icon-plus-circle mr-2"></i>
                            Crear Departamento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre del Departamento *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Ej: Matemática y Física" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                placeholder="Descripción opcional del departamento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="id_tipousuario">Jefe de Departamento *</label>
                            <select class="form-control select2-profesor" id="id_tipousuario" name="id_tipousuario"
                                required>
                                <option value="">Seleccione un profesor</option>
                                @foreach ($profesoresDisponibles ?? [] as $profesor)
                                    <option value="{{ $profesor['id'] }}" data-dni="{{ $profesor['dni'] ?? '' }}"
                                        data-nombre="{{ $profesor['nombre_completo'] }}">
                                        {{ $profesor['nombre_completo'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Editar Departamento --}}
    <div class="modal fade" id="modalEditarDepartamento" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditarDepartamento" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="feather icon-edit mr-2"></i>
                            Editar Departamento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nombre">Nombre del Departamento *</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_descripcion">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_id_tipousuario">Jefe de Departamento *</label>
                            <select class="form-control select2-profesor" id="edit_id_tipousuario" name="id_tipousuario"
                                required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_estado">Estado *</label>
                            <select class="form-control select-estado" id="edit_estado" name="estado" required>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Ver Detalles --}}
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="feather icon-info mr-2"></i>
                        Detalles del Departamento
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detallesContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Gestionar Materias --}}
    <div class="modal fade" id="modalMaterias" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="feather icon-book-open mr-2"></i>
                        Gestionar Materias
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="materiasContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Confirmación de Eliminación --}}
    <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="feather icon-alert-triangle mr-2"></i>
                        <span id="confirmarTitulo">Confirmar Acción</span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3">
                        <i class="feather icon-alert-circle text-warning" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 mb-3" id="confirmarMensaje">¿Está seguro de realizar esta acción?</h5>
                        <p class="text-muted" id="confirmarDescripcion">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarAccion">
                        <i class="feather icon-trash-2"></i> <span id="btnConfirmarTexto">Eliminar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Estilos --}}
    <style>
        .departamentos-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .departamentos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .main-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .main-subtitle {
            color: #6b7280;
            margin: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        /* Estilos de Modales */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }

        .modal-header .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .modal-header .modal-title i {
            font-size: 1.5rem;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
            font-size: 2rem;
            font-weight: 300;
            margin-top: -10px;
        }

        .modal-header .close:hover {
            opacity: 1;
            color: white;
        }

        .modal-body {
            padding: 2rem 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            background-color: #f9fafb;
            border-radius: 0 0 12px 12px;
        }

        .modal-footer .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-secondary {
            background-color: #6b7280;
            border: none;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #4b5563;
            transform: translateY(-2px);
        }

        .modal-footer .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Formularios en modales */
        .modal-body .form-group {
            margin-bottom: 1.5rem;
        }

        .modal-body .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }

        .modal-body .form-control,
        .modal-body .form-control:focus {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            height: auto;
            min-height: 38px;
        }

        .modal-body select.form-control {
            height: 38px !important;
            padding: 0.375rem 0.75rem !important;
        }

        .modal-body .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Detalles del departamento en modal */
        .detalle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .detalle-header h4 {
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .detalle-info {
            padding-top: 1rem;
        }

        .detalle-info p {
            color: #4b5563;
            line-height: 1.8;
        }

        .detalle-info strong {
            color: #1f2937;
            font-weight: 600;
        }

        .detalle-info hr {
            border-top: 2px solid #e5e7eb;
            margin: 1.5rem 0;
        }

        .detalle-info h5 {
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
        }

        .detalle-info .list-group-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .detalle-info .list-group-item:hover {
            background-color: #f9fafb;
            transform: translateX(5px);
        }

        /* Gestión de materias en modal */
        .modal-lg .col-md-6 h5 {
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        #btnQuitarSeleccionadas {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        #btnQuitarSeleccionadas:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .materia-asignada-check {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .modal-body .list-group {
            border-radius: 8px;
        }

        .modal-body .list-group-item {
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            cursor: pointer;
            margin-bottom: 0.25rem;
        }

        .modal-body .list-group-item:hover {
            background-color: #f3f4f6;
            border-color: #667eea;
        }

        .modal-body .list-group-item:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .modal-body .list-group-item:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .modal-body .list-group-item label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 400;
            color: #4b5563;
        }

        .modal-body .list-group-item input[type="checkbox"] {
            accent-color: #667eea;
        }

        .modal-body .list-group-item input[type="checkbox"]:checked+* {
            font-weight: 500;
            color: #667eea;
        }

        /* Spinner de carga */
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3rem;
        }

        /* Animación del modal */
        .modal.fade .modal-dialog {
            transform: scale(0.8);
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        /* Modal de Confirmación */
        .modal-header.bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .modal-body .feather.icon-alert-circle {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Barra de búsqueda mejorada */
        .search-filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }

        .search-controls {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 300px;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.125rem;
            pointer-events: none;
            z-index: 1;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 3rem 0.875rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .clear-search {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: #ef4444;
            border: none;
            border-radius: 6px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: white;
        }

        .clear-search:hover {
            background: #dc2626;
            transform: translateY(-50%) scale(1.05);
        }

        .clear-search i {
            font-size: 0.875rem;
        }

        .search-stats {
            font-size: 0.875rem;
            color: #6b7280;
            padding-left: 0.25rem;
        }

        .search-stats span {
            font-weight: 500;
            color: #3b82f6;
        }

        .search-bar .input-group {
            max-width: 500px;
        }

        .search-bar .input-group-text {
            border-right: 0;
            background: white;
        }

        .search-bar .form-control {
            border-left: 0;
        }

        @media (max-width: 768px) {
            .departamentos-grid {
                grid-template-columns: 1fr;
            }

            .departamentos-header {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary {
                justify-content: center;
            }

            .search-controls {
                flex-direction: column;
            }

            .search-wrapper {
                min-width: 100%;
            }

            .search-input {
                font-size: 0.875rem;
                padding: 0.75rem 2.5rem 0.75rem 2.5rem;
            }

            .modal-body {
                padding: 1.5rem 1rem;
            }

            .detalle-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        .departamentos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .departamento-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .departamento-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.25rem;
            color: white;
        }

        .departamento-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .departamento-nombre {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: white;
            display: flex;
            align-items: center;
        }

        .card-body-custom {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .info-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
            flex: 1;
        }

        .info-row i {
            font-size: 1.25rem;
            margin-top: 0.25rem;
        }

        .materias-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .materias-tags .badge {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .card-footer-custom {
            padding: 1rem 1.5rem;
            background: #f9fafb;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: auto;
        }

        .card-footer-custom .btn {
            flex: 1;
            min-width: fit-content;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
        }

        @media (max-width: 768px) {
            .departamentos-grid {
                grid-template-columns: 1fr;
            }

            .departamentos-header {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary {
                justify-content: center;
            }

            .modal-body {
                padding: 1.5rem 1rem;
            }

            .detalle-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        function normalizeText(text) {
            return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        }
        // Esperar a que jQuery esté disponible
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar Select2 dinámicamente
            if (!window.jQuery.fn.select2) {
                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
                script.onload = function() {
                    initializeSelect2();
                };
                document.head.appendChild(script);
            } else {
                initializeSelect2();
            }
        });

        function initializeSelect2() {
            $(document).ready(function() {
                console.log('Inicializando Select2...');

                // Funcionalidad de búsqueda con botón limpiar
                const searchInput = document.getElementById('searchInput');
                const clearButton = document.getElementById('clearSearch');

                if (searchInput && clearButton) {
                    searchInput.addEventListener('input', function() {
                        clearButton.style.display = this.value ? 'flex' : 'none';
                    });

                    clearButton.addEventListener('click', function() {
                        searchInput.value = '';
                        clearButton.style.display = 'none';
                        searchInput.dispatchEvent(new Event('input'));
                        searchInput.focus();
                    });
                }

                // Inicializar Select2 en el modal de crear
                if ($('#id_tipousuario').length) {
                    $('#id_tipousuario').select2({
                        placeholder: 'Escriba para buscar por nombre o DNI...',
                        allowClear: true,
                        dropdownParent: $('#modalCrearDepartamento'),
                        width: '100%',
                        matcher: function(params, data) {
                            if ($.trim(params.term) === '') {
                                return data;
                            }

                            var texto = normalizeText(data.text);
                            var dni = $(data.element).data('dni') || '';
                            var termino = normalizeText(params.term);

                            if (texto.indexOf(termino) > -1 || dni.toString().indexOf(termino) > -1) {
                                return data;
                            }

                            return null;
                        },
                        templateResult: function(data) {
                            if (!data.id) {
                                return data.text;
                            }

                            var dni = $(data.element).data('dni');
                            if (dni) {
                                return $('<span>' + data.text + ' <small class="text-muted">(DNI: ' +
                                    dni + ')</small></span>');
                            }
                            return data.text;
                        },
                        templateSelection: function(data) {
                            return data.text;
                        }
                    });
                    console.log('Select2 crear inicializado');
                }

                // Reinicializar Select2 cuando se abre el modal de editar
                $('#modalEditarDepartamento').on('shown.bs.modal', function() {
                    if ($('#edit_id_tipousuario').length) {
                        if ($('#edit_id_tipousuario').hasClass('select2-hidden-accessible')) {
                            $('#edit_id_tipousuario').select2('destroy');
                        }

                        $('#edit_id_tipousuario').select2({
                            placeholder: 'Escriba para buscar por nombre o DNI...',
                            allowClear: true,
                            dropdownParent: $('#modalEditarDepartamento'),
                            width: '100%',
                            matcher: function(params, data) {
                                if ($.trim(params.term) === '') {
                                    return data;
                                }

                                var texto = normalizeText(data.text);
                                var dni = $(data.element).data('dni') || '';
                                var termino = normalizeText(params.term);

                                if (texto.indexOf(termino) > -1 || dni.toString().indexOf(
                                        termino) > -1) {
                                    return data;
                                }

                                return null;
                            },
                            templateResult: function(data) {
                                if (!data.id) {
                                    return data.text;
                                }

                                var dni = $(data.element).data('dni');
                                if (dni) {
                                    return $('<span>' + data.text +
                                        ' <small class="text-muted">(DNI: ' + dni +
                                        ')</small></span>');
                                }
                                return data.text;
                            }
                        });
                        console.log('Select2 editar inicializado');
                    }
                });

                // Limpiar Select2 cuando se cierran los modales
                $('#modalCrearDepartamento').on('hidden.bs.modal', function() {
                    $('#id_tipousuario').val('').trigger('change');
                });

                $('#modalEditarDepartamento').on('hidden.bs.modal', function() {
                    if ($('#edit_id_tipousuario').hasClass('select2-hidden-accessible')) {
                        $('#edit_id_tipousuario').select2('destroy');
                    }
                });
            });
            // Búsqueda en tiempo real
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = normalizeText(this.value);
                const cards = document.querySelectorAll('.departamento-card');
                const noResults = document.getElementById('noResults');
                const searchResults = document.getElementById('searchResults');
                let hasResults = false;

                cards.forEach(card => {
                    const nombre = normalizeText(card.dataset.nombre);
                    const jefe = normalizeText(card.dataset.jefe);

                    if (nombre.includes(searchTerm) || jefe.includes(searchTerm)) {
                        card.style.display = 'block';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                const visibleCount = Array.from(cards).filter(card => card.style.display !== 'none').length;

                if (this.value) {
                    searchResults.textContent =
                        `${visibleCount} resultado${visibleCount !== 1 ? 's' : ''} encontrado${visibleCount !== 1 ? 's' : ''}`;
                } else {
                    searchResults.textContent = '';
                }

                noResults.style.display = hasResults ? 'none' : 'block';
            });
        }


        // Ver detalles del departamento
        function verDetalles(id) {
            fetch(`/departamentos/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detallesContent').innerHTML = generarHTMLDetalles(data);
                })
                .catch(error => {
                    document.getElementById('detallesContent').innerHTML =
                        '<div class="alert alert-danger">Error al cargar los detalles</div>';
                });
        }

        function generarHTMLDetalles(data) {
            let html = `
                <div class="detalle-header mb-4">
                    <h4>${data.nombre}</h4>
                    <span class="badge badge-${data.estado == 'A' ? 'success' : 'secondary'}">
                        ${data.estado == 'A' ? 'Activo' : 'Inactivo'}
                    </span>
                </div>
                <div class="detalle-info">
                    <p><strong>Jefe:</strong> ${data.jefe.apellido}, ${data.jefe.nombre}</p>
                    ${data.descripcion ? `<p><strong>Descripción:</strong> ${data.descripcion}</p>` : ''}
                    <hr>
                    <h5>Materias Asignadas (${data.materias.length})</h5>
            `;

            if (data.materias.length > 0) {
                html += '<ul class="list-group">';
                data.materias.forEach(materia => {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${materia.nombre}
                            <span class="badge badge-primary badge-pill">${materia.cantidad_profesores || 0} profesores</span>
                        </li>
                    `;
                });
                html += '</ul>';
            } else {
                html += '<p class="text-muted">No hay materias asignadas</p>';
            }

            html += '</div>';
            return html;
        }

        // Editar departamento
        function editarDepartamento(id) {
            fetch(`/departamentos/${id}/editar`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('formEditarDepartamento').action = `/departamentos/${id}`;
                    document.getElementById('edit_nombre').value = data.nombre;
                    document.getElementById('edit_descripcion').value = data.descripcion || '';
                    document.getElementById('edit_estado').value = data.estado;

                    // Cargar profesores disponibles
                    let selectProfesor = document.getElementById('edit_id_tipousuario');
                    selectProfesor.innerHTML = '';
                    data.profesores.forEach(profesor => {
                        let option = document.createElement('option');
                        option.value = profesor.id;
                        option.textContent = profesor.nombre_completo;
                        option.setAttribute('data-dni', profesor.dni || '');
                        option.setAttribute('data-nombre', profesor.nombre_completo);
                        if (profesor.id == data.id_tipousuario) {
                            option.selected = true;
                        }
                        selectProfesor.appendChild(option);
                    });
                });
        }

        function generarHTMLMaterias(data, departamentoId) {
            let html = `
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Materias Asignadas</h5>
                    <button type="button" class="btn btn-sm btn-danger" id="btnQuitarSeleccionadas" style="display: none;">
                        <i class="feather icon-trash-2"></i> Quitar Seleccionadas
                    </button>
                </div>
                <div class="list-group mb-3" style="max-height: 400px; overflow-y: auto;">
    `;

            if (data.asignadas.length > 0) {
                data.asignadas.forEach(materia => {
                    html += `
                <label class="list-group-item d-flex align-items-center">
                    <input type="checkbox" class="mr-3 materia-asignada-check" data-materia-id="${materia.id}">
                    <span class="flex-grow-1">${materia.nombre}</span>
                </label>
            `;
                });
            } else {
                html += '<p class="text-muted p-3">No hay materias asignadas</p>';
            }

            html += `
                </div>
            </div>
            <div class="col-md-6">
                <h5>Materias Disponibles</h5>
                <form id="formAsignarMaterias">
                    <div class="list-group mb-3" style="max-height: 400px; overflow-y: auto;">
    `;

            if (data.disponibles.length > 0) {
                data.disponibles.forEach(materia => {
                    html += `
                <label class="list-group-item">
                    <input type="checkbox" name="materias[]" value="${materia.id}" class="mr-2">
                    ${materia.nombre}
                </label>
            `;
                });
                html += `
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="feather icon-plus"></i> Asignar Seleccionadas
                    </button>
        `;
            } else {
                html += '<p class="text-muted p-3">No hay materias disponibles</p></div>';
            }

            html += `
                </form>
            </div>
        </div>
    `;

            return html;
        }

        // Función que se ejecuta después de cargar las materias
        function gestionarMaterias(id) {
            fetch(`/departamentos/${id}/materias`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('materiasContent').innerHTML = generarHTMLMaterias(data, id);

                    // Inicializar eventos para checkboxes
                    setTimeout(() => {
                        inicializarCheckboxesMaterias(id);
                        inicializarFormularioAsignar(id);
                    }, 100);
                });
        }

        // Inicializar formulario de asignar materias
        function inicializarFormularioAsignar(departamentoId) {
            const form = document.getElementById('formAsignarMaterias');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const checkboxes = form.querySelectorAll('input[name="materias[]"]:checked');
                const materiasIds = Array.from(checkboxes).map(cb => cb.value);

                if (materiasIds.length === 0) {
                    alert('Seleccione al menos una materia');
                    return;
                }

                // Crear FormData
                const formData = new FormData();
                materiasIds.forEach(id => {
                    formData.append('materias[]', id);
                });

                // Enviar por AJAX
                fetch(`/departamentos/${departamentoId}/asignar-materias`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Recargar la página o cerrar modal
                        location.reload();
                    })
                    .catch(error => {
                        alert('Error al asignar materias');
                        console.error(error);
                    });
            });
        }

        // Inicializar eventos de checkboxes
        function inicializarCheckboxesMaterias(departamentoId) {
            const checkboxes = document.querySelectorAll('.materia-asignada-check');
            const btnQuitar = document.getElementById('btnQuitarSeleccionadas');

            if (!btnQuitar || !checkboxes.length) return;

            // Evento para mostrar/ocultar botón de quitar
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const algunoSeleccionado = Array.from(checkboxes).some(cb => cb.checked);
                    btnQuitar.style.display = algunoSeleccionado ? 'inline-block' : 'none';
                });
            });

            // Evento para quitar materias seleccionadas
            btnQuitar.addEventListener('click', function() {
                const seleccionadas = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.materiaId);

                if (seleccionadas.length === 0) {
                    mostrarModalConfirmacion({
                        titulo: 'Sin Selección',
                        mensaje: 'No hay materias seleccionadas',
                        descripcion: 'Por favor seleccione al menos una materia.',
                        textoBoton: 'Entendido',
                        colorHeader: 'info',
                        onConfirm: () => {}
                    });
                    return;
                }

                quitarMateriasMultiples(departamentoId, seleccionadas);
            });
        }

        // Sistema de confirmación genérico
        let accionConfirmada = null;

        function mostrarModalConfirmacion(config) {
            // Configuración por defecto
            const opciones = {
                titulo: 'Confirmar Acción',
                mensaje: '¿Está seguro de realizar esta acción?',
                descripcion: 'Esta acción no se puede deshacer.',
                textoBoton: 'Eliminar',
                colorHeader: 'danger',
                onConfirm: () => {}
            };

            // Mezclar con configuración personalizada
            Object.assign(opciones, config);

            // Actualizar contenido del modal
            document.getElementById('confirmarTitulo').textContent = opciones.titulo;
            document.getElementById('confirmarMensaje').textContent = opciones.mensaje;
            document.getElementById('confirmarDescripcion').textContent = opciones.descripcion;
            document.getElementById('btnConfirmarTexto').textContent = opciones.textoBoton;

            // Cambiar color del header si es necesario
            const modalHeader = document.querySelector('#modalConfirmar .modal-header');
            modalHeader.className = `modal-header bg-${opciones.colorHeader}`;

            // Asignar acción al botón confirmar
            accionConfirmada = opciones.onConfirm;

            // Mostrar modal
            $('#modalConfirmar').modal('show');
        }

        // Evento del botón confirmar
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnConfirmarAccion').addEventListener('click', function() {
                if (accionConfirmada) {
                    accionConfirmada();
                }
                $('#modalConfirmar').modal('hide');
            });
        });

        // Confirmar eliminación de departamento
        function confirmarEliminar(id, nombre) {
            mostrarModalConfirmacion({
                titulo: 'Eliminar Departamento',
                mensaje: `¿Está seguro de eliminar el departamento "${nombre}"?`,
                descripcion: 'Se perderán todas las asignaciones de materias asociadas.',
                textoBoton: 'Sí, Eliminar',
                colorHeader: 'danger',
                onConfirm: () => {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/departamentos/${id}`;

                    let csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

                    let methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Confirmar quitar una materia
        function quitarMateria(departamentoId, materiaId) {
            mostrarModalConfirmacion({
                titulo: 'Quitar Materia',
                mensaje: '¿Está seguro de quitar esta materia del departamento?',
                descripcion: 'La materia quedará disponible para otros departamentos.',
                textoBoton: 'Sí, Quitar',
                colorHeader: 'warning',
                onConfirm: () => {
                    fetch(`/departamentos/${departamentoId}/materias/${materiaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(() => {
                            location.reload();
                        })
                        .catch(error => {
                            alert('Error al quitar la materia');
                            console.error(error);
                        });
                }
            });
        }

        // Quitar múltiples materias con confirmación
        function quitarMateriasMultiples(departamentoId, materiasIds) {
            mostrarModalConfirmacion({
                titulo: 'Quitar Materias',
                mensaje: `¿Está seguro de quitar ${materiasIds.length} materia(s) del departamento?`,
                descripcion: 'Las materias quedarán disponibles para otros departamentos.',
                textoBoton: 'Sí, Quitar Todas',
                colorHeader: 'warning',
                onConfirm: () => {
                    const promesas = materiasIds.map(materiaId =>
                        fetch(`/departamentos/${departamentoId}/materias/${materiaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                    );

                    Promise.all(promesas)
                        .then(() => {
                            location.reload();
                        })
                        .catch(error => {
                            alert('Error al quitar algunas materias');
                            console.error(error);
                        });
                }
            });
        }
    </script>
@endsection
