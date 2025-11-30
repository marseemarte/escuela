<x-layouts.departamento.dashboard profesores titulo="Profesores"
    title="Mi Técnica | Panel de Jefes de Departamento - Profesores">

    <div class="asistencias-container">
        {{-- Header --}}
        <div class="asistencias-header">
            <div class="header-content">
                <h1 class="main-title">Profesores del Departamento</h1>
                <p class="main-subtitle">Consulte los profesores y su carga horaria en el departamento</p>
            </div>
            <div class="header-info">
                <div class="date-info">
                    <i class="feather icon-calendar"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
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
        {{-- Barra de búsqueda y filtros --}}
        <div class="search-filter-section">
            <div class="search-controls">
                <div class="search-wrapper">
                    <i class="feather icon-search search-icon"></i>
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="Buscar por nombre, DNI o curso...">
                    <button class="clear-search" id="clearSearch" style="display: none;">
                        <i class="feather icon-x"></i>
                    </button>
                </div>
                <div class="filter-wrapper">
                    <select id="materiaFilter" class="filter-select">
                        <option value="">Todas las materias</option>
                        @php
                            $materiasUnicas = $profesores->pluck('materia')->unique('id')->sortBy('nombre');
                        @endphp
                        @foreach ($materiasUnicas as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="search-stats">
                <span id="searchResults"></span>
            </div>
        </div>
        {{-- Tabla de profesores --}}
        <div class="card">
            <div class="card-header">
                <h2 class="h5 mb-1">Listado de Profesores</h2>
                <p class="text-muted mb-0">Profesores que dictan materias del {{ $departamento->nombre }}</p>
            </div>
            <div class="card-body">
                @if (count($profesores) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Profesor</th>
                                    <th>Materia</th>
                                    <th>Curso</th>
                                    <th class="text-center">Proyecto</th>
                                    <th class="text-center">Planificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profesores as $profesor)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle mr-2">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <div>
                                                    <span class="font-weight-bold">
                                                        {{ $profesor['persona']->apellido }},
                                                        {{ $profesor['persona']->nombre }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">DNI:
                                                        {{ $profesor['persona']->dni }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="feather icon-book mr-1"></i>
                                            {{ $profesor['materia']->nombre }}
                                        </td>
                                        <td>
                                            {{ $profesor['curso']->ano }}º {{ $profesor['curso']->division }}
                                            @if ($profesor['grupo'])
                                                - {{ $profesor['grupo']->nombre }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($profesor['tiene_proyecto'])
                                                <span class="badge badge-success">
                                                    <i class="feather icon-check-circle"></i> Cargado
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="feather icon-x-circle"></i> Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($profesor['tiene_planificacion'])
                                                <span class="badge badge-success">
                                                    <i class="feather icon-check-circle"></i> Cargada
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="feather icon-x-circle"></i> Pendiente
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginación --}}
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Mostrando <span id="showingStart">1</span> - <span id="showingEnd">10</span> de <span
                                id="totalRecords">{{ count($profesores) }}</span> profesores
                        </div>
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination mb-0" id="paginationControls">
                                <!-- Se genera dinámicamente con JavaScript -->
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="feather icon-users text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No hay profesores asignados</h5>
                        <p class="text-muted mb-0">Aún no hay profesores dictando materias de este departamento</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Estilos adicionales --}}
    <style>
        .asistencias-container {
            padding: 1.5rem;
        }

        .asistencias-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-content .main-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .header-content .main-subtitle {
            color: #6b7280;
            margin: 0;
        }

        .date-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
        }

        .card-header h2 {
            margin: 0;
            color: #1f2937;
            font-weight: 600;
        }

        .card-body {
            padding: 0;
        }

        .table {
            margin: 0;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 1.5rem;
        }

        .table th {
            vertical-align: middle;
            padding: 1rem 1.5rem;
        }

        .thead-light th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .badge {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #10b981;
            color: white;
        }

        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }

        .badge-info {
            background-color: #3b82f6;
            color: white;
        }

        /* Iconos más grandes en estados vacíos */
        .text-center i[style*="font-size: 3rem"] {
            opacity: 0.3;
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

        .search-wrapper {
            position: relative;
            max-width: 600px;
            margin-bottom: 0.75rem;
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

        .filter-wrapper {
            min-width: 200px;
        }

        .filter-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
            background: #f9fafb;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-select option {
            padding: 0.5rem;
        }

        /* Paginación */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .pagination {
            margin: 0;
        }

        .page-item .page-link {
            color: #3b82f6;
            border-color: #e5e7eb;
            padding: 0.375rem 0.75rem;
        }

        .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .page-item.disabled .page-link {
            color: #9ca3af;
        }

        .page-link:hover {
            background-color: #f3f4f6;
        }

        /* Ocultar filas */
        .hidden-row {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-controls {
                flex-direction: column;
            }

            .search-wrapper {
                min-width: 100%;
            }

            .filter-wrapper {
                width: 100%;
            }

            .table {
                font-size: 0.875rem;
            }

            .table td,
            .table th {
                padding: 0.75rem;
            }

            .asistencias-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const materiaFilter = document.getElementById('materiaFilter');
            const clearButton = document.getElementById('clearSearch');
            const searchResults = document.getElementById('searchResults');
            const tableBody = document.querySelector('.table tbody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            const itemsPerPage = 10;
            let currentPage = 1;
            let filteredRows = rows;

            // Función de búsqueda y filtrado
            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                const materiaId = materiaFilter.value;

                filteredRows = rows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    const matchSearch = text.includes(searchTerm);

                    // Si no hay filtro de materia, solo buscar por texto
                    if (!materiaId) {
                        return matchSearch;
                    }

                    // Obtener el ID de la materia de la fila (guardado en data attribute)
                    const rowMateriaCell = row.cells[1]; // Columna de materia
                    const rowMateriaText = rowMateriaCell.textContent.trim();
                    const selectedMateriaText = materiaFilter.options[materiaFilter.selectedIndex].text;
                    const matchMateria = materiaId === '' || rowMateriaText.includes(selectedMateriaText);

                    return matchSearch && matchMateria;
                });

                currentPage = 1;
                updateDisplay();
                updateSearchStats();

                // Mostrar/ocultar botón de limpiar
                clearButton.style.display = searchTerm ? 'flex' : 'none';
            }

            // Función para actualizar estadísticas de búsqueda
            function updateSearchStats() {
                const hasSearch = searchInput.value || materiaFilter.value;
                if (hasSearch) {
                    searchResults.textContent =
                        `${filteredRows.length} resultado${filteredRows.length !== 1 ? 's' : ''} encontrado${filteredRows.length !== 1 ? 's' : ''}`;
                } else {
                    searchResults.textContent = '';
                }
            }

            // Limpiar búsqueda
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                materiaFilter.value = '';
                filterRows();
                searchInput.focus();
            });

            // Función para actualizar la visualización
            function updateDisplay() {
                // Ocultar todas las filas
                rows.forEach(row => row.classList.add('hidden-row'));

                // Calcular rango de filas a mostrar
                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const rowsToShow = filteredRows.slice(start, end);

                // Mostrar filas correspondientes
                rowsToShow.forEach(row => row.classList.remove('hidden-row'));

                // Actualizar información de paginación
                updatePaginationInfo(start, end);
                updatePaginationControls();
            }

            // Actualizar información de paginación
            function updatePaginationInfo(start, end) {
                document.getElementById('showingStart').textContent = filteredRows.length > 0 ? start + 1 : 0;
                document.getElementById('showingEnd').textContent = Math.min(end, filteredRows.length);
                document.getElementById('totalRecords').textContent = filteredRows.length;
            }

            // Actualizar controles de paginación
            function updatePaginationControls() {
                const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
                const paginationControls = document.getElementById('paginationControls');
                paginationControls.innerHTML = '';

                // Si no hay páginas, no mostrar controles
                if (totalPages <= 0) return;

                // Botón anterior
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Anterior</a>`;
                paginationControls.appendChild(prevLi);

                // Números de página
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                if (endPage - startPage < maxVisiblePages - 1) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageLi = document.createElement('li');
                    pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    pageLi.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                    paginationControls.appendChild(pageLi);
                }

                // Botón siguiente
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Siguiente</a>`;
                paginationControls.appendChild(nextLi);

                // Event listeners para los botones
                paginationControls.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (!this.parentElement.classList.contains('disabled')) {
                            currentPage = parseInt(this.dataset.page);
                            updateDisplay();
                        }
                    });
                });
            }

            // Event listeners
            searchInput.addEventListener('input', filterRows);
            materiaFilter.addEventListener('change', filterRows);

            // Inicializar
            updateDisplay();
        });
    </script>
</x-layouts.departamento.dashboard>
