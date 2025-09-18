{{-- Vista para cargar notas de una materia específica --}}
<x-layouts.profesores.dashboard notas titulo="Cargar Notas">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="space-y-6">
        {{-- Header con información de la materia --}}
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">
                                @if (isset($cupofInfo))
                                    {{ $cupofInfo->materia_nombre ?? 'Materia no encontrada' }}
                                @else
                                    Gestión de Notas
                                @endif
                            </h1>
                            <p class="text-sm text-gray-600">
                                @if (isset($cupofInfo))
                                    Curso: {{ $cupofInfo->ano ?? '' }}° - División: {{ $cupofInfo->division ?? '' }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="text-center sm:text-right">
                    <div>Período: {{ now()->format('Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Formulario principal --}}
        <form id="notasForm" method="POST" action="{{ route('profesores.notas.guardar') }}">
            @csrf
            <input type="hidden" name="cupof" value="{{ $cupof }}">

            {{-- Estadísticas en tiempo real --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Total Estudiantes</p>
                            <p class="text-2xl font-semibold text-gray-900" id="total-estudiantes">
                                {{ isset($alumnosConNotas) ? count($alumnosConNotas) : 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Promedio General</p>
                            <p class="text-2xl font-semibold text-gray-900" id="promedio-general">0.0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-times-circle text-red-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Desaprobados</p>
                            <p class="text-2xl font-semibold text-red-600" id="total-desaprobados">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-percentage text-yellow-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">% Aprobación</p>
                            <p class="text-2xl font-semibold text-yellow-600" id="porcentaje-aprobacion">0%</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Barra de progreso y distribución --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-medium text-gray-900">Progreso de Carga</h3>
                    <span class="text-sm text-gray-600" id="progreso-texto">0 de 0 campos completados</span>
                </div>
                <div class="bg-gray-200 rounded-full h-3 mb-4">
                    <div id="barra-progreso"
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500"
                        style="width: 0%"></div>
                </div>

                {{-- Distribución detallada --}}
                <div class="flex justify-center items-center space-x-6 pt-3 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-700">Aprobados: <span id="contador-aprobados"
                                class="font-semibold">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-700">En riesgo: <span id="contador-riesgo"
                                class="font-semibold">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-700">Desaprobados: <span id="contador-desaprobados-detalle"
                                class="font-semibold">0</span></span>
                    </div>
                </div>
            </div>

            {{-- Tabla de notas --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Cargar Notas {{ now()->format('Y') }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Complete las notas por período para cada estudiante</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('profesores.notas.index') }}"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver
                        </a>
                    </div>
                </div>

                {{-- Tabla principal --}}
                {{-- Vista de tabla para pantallas medianas y grandes --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                            <tr>
                                <th class="px-4 py-3 text-left">Nombre</th>
                                <th class="px-4 py-3 text-left">Apellido</th>
                                <th class="px-4 py-3">1° Informe</th>
                                <th class="px-4 py-3">1° Cuatrimestre</th>
                                <th class="px-4 py-3">2° Informe</th>
                                <th class="px-4 py-3">2° Cuatrimestre</th>
                                <th class="px-4 py-3">Cierre</th>
                                <th class="px-4 py-3">Promedio</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-center divide-y divide-gray-200">
                            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                                @foreach ($alumnosConNotas as $index => $alumno)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-4 py-4 text-left font-medium">{{ $alumno['nombre'] }}</td>
                                        <td class="px-4 py-4 text-left font-medium">{{ $alumno['apellido'] }}</td>

                                        {{-- 1° Informe --}}
                                        <td class="px-4 py-4">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                                min="1" max="10" step="0.1"
                                                data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="1"
                                                placeholder="-"
                                                onchange="calcularPromedio({{ $alumno['asignacion_id'] }})">
                                        </td>

                                        {{-- 1° Cuatrimestre --}}
                                        <td class="px-4 py-4">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                                min="1" max="10" step="0.1"
                                                data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="2"
                                                placeholder="-"
                                                onchange="calcularPromedio({{ $alumno['asignacion_id'] }})">
                                        </td>

                                        {{-- 2° Informe --}}
                                        <td class="px-4 py-4">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                                min="1" max="10" step="0.1"
                                                data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="3"
                                                placeholder="-"
                                                onchange="calcularPromedio({{ $alumno['asignacion_id'] }})">
                                        </td>

                                        {{-- 2° Cuatrimestre --}}
                                        <td class="px-4 py-4">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                                value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                                min="1" max="10" step="0.1"
                                                data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="4"
                                                placeholder="-"
                                                onchange="calcularPromedio({{ $alumno['asignacion_id'] }})">
                                        </td>

                                        {{-- Cierre --}}
                                        <td class="px-4 py-4">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][5]"
                                                value="{{ $alumno['nota_periodo_5'] ?? '' }}"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                                min="1" max="10" step="0.1"
                                                data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="5"
                                                placeholder="-"
                                                onchange="calcularPromedio({{ $alumno['asignacion_id'] }})">
                                        </td>

                                        {{-- Promedio --}}
                                        <td class="px-4 py-4">
                                            <span id="promedio-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                -
                                            </span>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="px-4 py-4">
                                            <span id="estado-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-minus mr-1"></i>
                                                Sin datos
                                            </span>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-4 py-4">
                                            <button type="button"
                                                onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                title="Limpiar notas de este alumno">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                                        No hay alumnos inscriptos en esta materia
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Vista de cards para móviles --}}
                <div class="md:hidden space-y-4 p-4">
                    @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                        @foreach ($alumnosConNotas as $index => $alumno)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-4">
                                {{-- Header del alumno --}}
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $alumno['apellido'] }},
                                            {{ $alumno['nombre'] }}</h3>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span id="promedio-mobile-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                -
                                            </span>
                                            <span id="estado-mobile-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-minus mr-1"></i>
                                                Sin datos
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button"
                                        onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50"
                                        title="Limpiar notas">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>

                                {{-- Grid de notas --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">1° Informe</label>
                                        <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                            value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                            min="1" max="10" step="0.1"
                                            data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="1"
                                            placeholder="-"
                                            onchange="calcularPromedioMobile({{ $alumno['asignacion_id'] }})">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">1°
                                            Cuatrimestre</label>
                                        <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                            value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                            min="1" max="10" step="0.1"
                                            data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="2"
                                            placeholder="-"
                                            onchange="calcularPromedioMobile({{ $alumno['asignacion_id'] }})">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">2° Informe</label>
                                        <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                            value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                            min="1" max="10" step="0.1"
                                            data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="3"
                                            placeholder="-"
                                            onchange="calcularPromedioMobile({{ $alumno['asignacion_id'] }})">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">2°
                                            Cuatrimestre</label>
                                        <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                            value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                            min="1" max="10" step="0.1"
                                            data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="4"
                                            placeholder="-"
                                            onchange="calcularPromedioMobile({{ $alumno['asignacion_id'] }})">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Cierre</label>
                                        <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][5]"
                                            value="{{ $alumno['nota_periodo_5'] ?? '' }}"
                                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500"
                                            min="1" max="10" step="0.1"
                                            data-alumno="{{ $alumno['asignacion_id'] }}" data-periodo="5"
                                            placeholder="-"
                                            onchange="calcularPromedioMobile({{ $alumno['asignacion_id'] }})">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No hay alumnos inscriptos en esta materia</p>
                        </div>
                    @endif
                </div>

                {{-- Footer con botón de guardar --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Total de estudiantes: {{ isset($alumnosConNotas) ? count($alumnosConNotas) : 0 }}
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" onclick="testGuardarNotas()"
                                class="inline-flex items-center px-3 py-2 border border-yellow-300 text-sm font-medium rounded-md text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <i class="fas fa-bug mr-1"></i>
                                Test Debug
                            </button>
                            <button type="button" onclick="limpiarFormulario()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-broom mr-2"></i>
                                Limpiar Todo
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Guardar Notas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Scripts para funcionalidad --}}
    <script>
        @verbatim
        // Función para calcular promedio automáticamente
        function calcularPromedio(asignacionId) {
            const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
            let notas = [];

            inputs.forEach(input => {
                const valor = parseFloat(input.value);
                if (!isNaN(valor) && valor >= 1 && valor <= 10) {
                    notas.push(valor);
                }
            });

            let promedio = '-';
            let clasePromedio =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            let estado = 'Sin datos';
            let claseEstado =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            let iconoEstado = 'fas fa-minus';

            if (notas.length > 0) {
                const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
                promedio = promedioNum.toFixed(1);

                if (promedioNum >= 7) {
                    clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    estado = 'Aprobado';
                    claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    iconoEstado = 'fas fa-check-circle';
                } else if (promedioNum >= 4) {
                    clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                    estado = 'En riesgo';
                    claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                    iconoEstado = 'fas fa-exclamation-triangle';
                } else {
                    clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                    estado = 'Desaprobado';
                    claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                    iconoEstado = 'fas fa-times-circle';
                }
            }

            const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
            if (spanPromedio) {
                spanPromedio.textContent = promedio;
                spanPromedio.className = clasePromedio;
            }

            const spanEstado = document.getElementById(`estado-${asignacionId}`);
            if (spanEstado) {
                spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                spanEstado.className = claseEstado;
            }

            actualizarDashboard();
        }

        // Función para calcular promedio en vista móvil
        function calcularPromedioMobile(asignacionId) {
            calcularPromedio(asignacionId);

            const promedio = document.getElementById(`promedio-${asignacionId}`);
            const estado = document.getElementById(`estado-${asignacionId}`);
            const promedioMobile = document.getElementById(`promedio-mobile-${asignacionId}`);
            const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);

            if (promedio && promedioMobile) {
                promedioMobile.textContent = promedio.textContent;
                promedioMobile.className = promedio.className;
            }

            if (estado && estadoMobile) {
                estadoMobile.innerHTML = estado.innerHTML;
                estadoMobile.className = estado.className;
            }
        }

        function actualizarDashboard() {
            cargarEstadisticas();
        }

        function cargarEstadisticas() {
            const params = new URLSearchParams(window.location.search);
            const cupof = params.get('cupof');

            if (!cupof) return;

            fetch(`/profesores/notas/cargar?cupof=${cupof}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.estadisticas) {
                        actualizarEstadisticasDinamicas(data.estadisticas);
                    }
                })
                .catch(error => {
                    actualizarDashboardLocal();
                });
        }

        function actualizarEstadisticasDinamicas(stats) {
            document.getElementById('total-estudiantes').textContent = stats.total_estudiantes || 0;
            document.getElementById('promedio-general').textContent = (stats.promedio_general || 0).toFixed(1);
            document.getElementById('total-desaprobados').textContent = stats.desaprobados || 0;
            document.getElementById('porcentaje-aprobacion').textContent = (stats.porcentaje_aprobacion || 0).toFixed(1) +
                '%';
            document.getElementById('contador-aprobados').textContent = stats.aprobados || 0;
            document.getElementById('contador-riesgo').textContent = stats.en_riesgo || 0;
            document.getElementById('contador-desaprobados-detalle').textContent = stats.desaprobados || 0;

            const textoProgreso = document.getElementById('progreso-texto');
            if (textoProgreso) {
                textoProgreso.textContent = `${stats.progreso_carga || 0}% completado`;
            }

            const barraProgreso = document.getElementById('barra-progreso');
            if (barraProgreso) {
                const progresoPorcentaje = stats.progreso_carga || 0;
                barraProgreso.style.width = progresoPorcentaje + '%';
            }
        }

        function actualizarDashboardLocal() {
            console.log('Usando estadísticas locales');
        }

        function limpiarFormulario() {
            if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
                document.querySelectorAll('[id^="promedio-"]').forEach(span => {
                    span.textContent = '-';
                    span.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                });
                document.querySelectorAll('[id^="estado-"]').forEach(estado => {
                    estado.innerHTML = '<i class="fas fa-minus mr-1"></i>Sin datos';
                    estado.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                });
                actualizarDashboard();
            }
        }

        function mostrarMensaje(mensaje, tipo) {
            tipo = tipo || 'info';
            const div = document.createElement('div');
            const claseColor = tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700';

            div.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ' + claseColor;

            const icono = tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info';
            div.innerHTML = `<div class="flex items-center">
                            <i class="fas fa-${icono}-circle mr-2"></i>
                            <span>${mensaje}</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-3">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;

            document.body.appendChild(div);
            setTimeout(() => div.remove(), 5000);
        }

        function testGuardarNotas() {
            console.log('=== TEST DE GUARDADO ===');

            const form = document.getElementById('notasForm');
            if (!form) {
                console.error('Formulario no encontrado');
                return;
            }

            const inputs = document.querySelectorAll('input[name^="notas["]');
            let hasNotas = false;

            inputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                    hasNotas = true;
                }
            });

            if (!hasNotas && inputs.length > 0) {
                inputs[0].value = '8';
                console.log('Nota de ejemplo agregada');
                const match = inputs[0].name.match(/\[(\d+)\]/);
                if (match) {
                    calcularPromedio(parseInt(match[1]));
                }
            }

            form.dispatchEvent(new Event('submit', {
                bubbles: true,
                cancelable: true
            }));
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
        @endverbatim
        @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
            @foreach ($alumnosConNotas as $alumno)
                calcularPromedio({{ $alumno['asignacion_id'] }});
            @endforeach
        @endif
        @verbatim

        setTimeout(() => cargarEstadisticas(), 100);
        });

        document.addEventListener('input', function(e) {
            if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
                const match = e.target.name.match(/notas\[(\d+)\]/);
                if (match) {
                    calcularPromedio(parseInt(match[1]));
                }

                clearTimeout(window.estadisticasTimeout);
                window.estadisticasTimeout = setTimeout(() => cargarEstadisticas(), 800);
            }
        });

        document.getElementById('notasForm').addEventListener('submit', function(e) {
            e.preventDefault();

            console.log('Formulario enviado');
            const formData = new FormData(this);

            console.log('Datos del formulario:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            mostrarMensaje('Guardando notas...', 'info');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    console.log('Respuesta:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    if (data.success) {
                        mostrarMensaje('Notas guardadas correctamente', 'success');
                        setTimeout(() => cargarEstadisticas(), 500);
                    } else {
                        mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
                        if (data.debug_info) {
                            console.error('Debug info:', data.debug_info);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarMensaje('Error de conexión: ' + error.message, 'error');
                });
        });
        @endverbatim
    </script>

    inputs.forEach(input => {
    const valor = parseFloat(input.value);
    if (!isNaN(valor) && valor >= 1 && valor <= 10) { notas.push(valor); } }); let promedio = '-'; let
        clasePromedio =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        let estado = 'Sin datos'; let
        claseEstado =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        let iconoEstado = 'fas fa-minus'; if (notas.length> 0) {
        const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
        promedio = promedioNum.toFixed(1);

        if (promedioNum >= 7) {
        clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
        estado = 'Aprobado';
        claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
        iconoEstado = 'fas fa-check-circle';
        } else if (promedioNum >= 4) {
        clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
        estado = 'En riesgo';
        claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
        iconoEstado = 'fas fa-exclamation-triangle';
        } else {
        clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
        estado = 'Desaprobado';
        claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
        iconoEstado = 'fas fa-times-circle';
        }
        }

        const spanPromedio = document.getElementById('promedio-' + asignacionId);
        if (spanPromedio) {
        spanPromedio.textContent = promedio;
        spanPromedio.className = clasePromedio;
        }

        const spanEstado = document.getElementById('estado-' + asignacionId);
        if (spanEstado) {
        spanEstado.innerHTML = '<i class="' + iconoEstado + ' mr-1"></i>' + estado;
        spanEstado.className = claseEstado;
        }

        actualizarDashboard();
        }

        // Función para calcular promedio en vista móvil
        function calcularPromedioMobile(asignacionId) {
        calcularPromedio(asignacionId);

        const promedio = document.getElementById('promedio-' + asignacionId);
        const estado = document.getElementById('estado-' + asignacionId);
        const promedioMobile = document.getElementById('promedio-mobile-' + asignacionId);
        const estadoMobile = document.getElementById('estado-mobile-' + asignacionId);

        if (promedio && promedioMobile) {
        promedioMobile.textContent = promedio.textContent;
        promedioMobile.className = promedio.className;
        }

        if (estado && estadoMobile) {
        estadoMobile.innerHTML = estado.innerHTML;
        estadoMobile.className = estado.className;
        }
        }

        function actualizarDashboard() {
        cargarEstadisticas();
        }

        function cargarEstadisticas() {
        const params = new URLSearchParams(window.location.search);
        const cupof = params.get('cupof');

        if (!cupof) return;

        fetch('/profesores/notas/cargar?cupof=' + cupof, {
        method: 'GET',
        headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
        }
        })
        .then(response => response.json())
        .then(data => {
        if (data.estadisticas) {
        actualizarEstadisticasDinamicas(data.estadisticas);
        }
        })
        .catch(error => {
        actualizarDashboardLocal();
        });
        }

        function actualizarEstadisticasDinamicas(stats) {
        document.getElementById('total-estudiantes').textContent = stats.total_estudiantes || 0;
        document.getElementById('promedio-general').textContent = (stats.promedio_general || 0).toFixed(1);
        document.getElementById('total-desaprobados').textContent = stats.desaprobados || 0;
        document.getElementById('porcentaje-aprobacion').textContent = (stats.porcentaje_aprobacion || 0).toFixed(1) +
        '%';
        document.getElementById('contador-aprobados').textContent = stats.aprobados || 0;
        document.getElementById('contador-riesgo').textContent = stats.en_riesgo || 0;
        document.getElementById('contador-desaprobados-detalle').textContent = stats.desaprobados || 0;

        const textoProgreso = document.getElementById('progreso-texto');
        if (textoProgreso) {
        textoProgreso.textContent = (stats.progreso_carga || 0) + '% completado';
        }

        const barraProgreso = document.getElementById('barra-progreso');
        if (barraProgreso) {
        const progresoPorcentaje = stats.progreso_carga || 0;
        barraProgreso.style.width = progresoPorcentaje + '%';
        }
        }

        function actualizarDashboardLocal() {
        console.log('Usando estadísticas locales');
        }

        function limpiarFormulario() {
        if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
        document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
        document.querySelectorAll('[id^="promedio-"]').forEach(span => {
        span.textContent = '-';
        span.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        });
        document.querySelectorAll('[id^="estado-"]').forEach(estado => {
        estado.innerHTML = '<i class="fas fa-minus mr-1"></i>Sin datos';
        estado.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        });
        actualizarDashboard();
        }
        }

        function mostrarMensaje(mensaje, tipo) {
        tipo = tipo || 'info';
        const div = document.createElement('div');
        const claseColor = tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
        tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
        'bg-blue-100 border border-blue-400 text-blue-700';

        div.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ' + claseColor;

        const icono = tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info';
        div.innerHTML = '<div class="flex items-center">' +
        '<i class="fas fa-' + icono + '-circle mr-2"></i>' +
        '<span>' + mensaje + '</span>' +
        '<button onclick="this.parentElement.parentElement.remove()" class="ml-3">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
        '</div>';

        document.body.appendChild(div);
        setTimeout(function() {
        div.remove();
        }, 5000);
        }

        function testGuardarNotas() {
        console.log('=== TEST DE GUARDADO ===');

            const form = document.getElementById('notasForm');
        if (!form) {
        console.error('Formulario no encontrado');
        return;
        }

        const inputs = document.querySelectorAll('input[name^="notas["]');
        let hasNotas = false;

        inputs.forEach(function(input) {
        if (input.value && input.value.trim() !== '') {
        hasNotas = true;
        }
        });

        if (!hasNotas && inputs.length > 0) {
        inputs[0].value = '8';
        console.log('Nota de ejemplo agregada');
        const match = inputs[0].name.match(/\[(\d+)\]/);
        if (match) {
        calcularPromedio(parseInt(match[1]));
        }
        }

        form.dispatchEvent(new Event('submit', {
        bubbles: true,
        cancelable: true
        }));
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
        @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
            @foreach ($alumnosConNotas as $alumno)
                calcularPromedio({{ $alumno['asignacion_id'] }});
            @endforeach
        @endif

        setTimeout(function() {
        cargarEstadisticas();
        }, 100);
        });

        document.addEventListener('input', function(e) {
        if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
        const match = e.target.name.match(/notas\[(\d+)\]/);
        if (match) {
        calcularPromedio(parseInt(match[1]));
        }

        clearTimeout(window.estadisticasTimeout);
        window.estadisticasTimeout = setTimeout(function() {
        cargarEstadisticas();
        }, 800);
        }
        });

        document.getElementById('notasForm').addEventListener('submit', function(e) {
        e.preventDefault();

        console.log('Formulario enviado');
        const formData = new FormData(this);

        console.log('Datos del formulario:');
        for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
        }

        mostrarMensaje('Guardando notas...', 'info');

        fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
        })
        .then(function(response) {
        console.log('Respuesta:', response.status);
        return response.json();
        })
        .then(function(data) {
        console.log('Datos recibidos:', data);
        if (data.success) {
        mostrarMensaje('Notas guardadas correctamente', 'success');
        setTimeout(function() {
        cargarEstadisticas();
        }, 500);
        } else {
        mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
        if (data.debug_info) {
        console.error('Debug info:', data.debug_info);
        }
        }
        })
        .catch(function(error) {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión: ' + error.message, 'error');
        });
        });
        </script>

        inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor) && valor >= 1 && valor <= 10) { notas.push(valor); } }); let promedio = '-'; let
            clasePromedio =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            let estado = 'Sin datos'; let
            claseEstado =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            let iconoEstado = 'fas fa-minus'; if (notas.length> 0) {
            const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
            promedio = promedioNum.toFixed(1);

            if (promedioNum >= 7) {
            clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            estado = 'Aprobado';
            claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
            iconoEstado = 'fas fa-check-circle';
            } else if (promedioNum >= 4) {
            clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
            estado = 'En riesgo';
            claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
            iconoEstado = 'fas fa-exclamation-triangle';
            } else {
            clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
            estado = 'Desaprobado';
            claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
            iconoEstado = 'fas fa-times-circle';
            }
            }

            const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
            if (spanPromedio) {
            spanPromedio.textContent = promedio;
            spanPromedio.className = clasePromedio;
            }

            const spanEstado = document.getElementById(`estado-${asignacionId}`);
            if (spanEstado) {
            spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
            spanEstado.className = claseEstado;
            }

            actualizarDashboard();
            }

            // Función para calcular promedio en vista móvil
            function calcularPromedioMobile(asignacionId) {
            calcularPromedio(asignacionId);

            const promedio = document.getElementById(`promedio-${asignacionId}`);
            const estado = document.getElementById(`estado-${asignacionId}`);
            const promedioMobile = document.getElementById(`promedio-mobile-${asignacionId}`);
            const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);

            if (promedio && promedioMobile) {
            promedioMobile.textContent = promedio.textContent;
            promedioMobile.className = promedio.className;
            }

            if (estado && estadoMobile) {
            estadoMobile.innerHTML = estado.innerHTML;
            estadoMobile.className = estado.className;
            }
            }

            function actualizarDashboard() {
            cargarEstadisticas();
            }

            function cargarEstadisticas() {
            const params = new URLSearchParams(window.location.search);
            const cupof = params.get('cupof');

            if (!cupof) return;

            fetch(`/profesores/notas/cargar?cupof=${cupof}`, {
            method: 'GET',
            headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
            }
            })
            .then(response => response.json())
            .then(data => {
            if (data.estadisticas) {
            actualizarEstadisticasDinamicas(data.estadisticas);
            }
            })
            .catch(error => {
            actualizarDashboardLocal();
            });
            }

            function actualizarEstadisticasDinamicas(stats) {
            document.getElementById('total-estudiantes').textContent = stats.total_estudiantes || 0;
            document.getElementById('promedio-general').textContent = (stats.promedio_general || 0).toFixed(1);
            document.getElementById('total-desaprobados').textContent = stats.desaprobados || 0;
            document.getElementById('porcentaje-aprobacion').textContent = (stats.porcentaje_aprobacion || 0).toFixed(1)
            +
            '%';
            document.getElementById('contador-aprobados').textContent = stats.aprobados || 0;
            document.getElementById('contador-riesgo').textContent = stats.en_riesgo || 0;
            document.getElementById('contador-desaprobados-detalle').textContent = stats.desaprobados || 0;

            const textoProgreso = document.getElementById('progreso-texto');
            if (textoProgreso) {
            textoProgreso.textContent = `${stats.progreso_carga || 0}% completado`;
            }

            const barraProgreso = document.getElementById('barra-progreso');
            if (barraProgreso) {
            const progresoPorcentaje = stats.progreso_carga || 0;
            barraProgreso.style.width = progresoPorcentaje + '%';
            }
            }

            function actualizarDashboardLocal() {
            // Fallback para cálculo local
            console.log('Usando estadísticas locales');
            }

            function limpiarFormulario() {
            if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
            document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
            document.querySelectorAll('[id^="promedio-"]').forEach(span => {
            span.textContent = '-';
            span.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            });
            document.querySelectorAll('[id^="estado-"]').forEach(estado => {
            estado.innerHTML = '<i class="fas fa-minus mr-1"></i>Sin datos';
            estado.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            });
            actualizarDashboard();
            }
            }

            function mostrarMensaje(mensaje, tipo = 'info') {
            const div = document.createElement('div');
            div.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
            tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
            tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
            'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
            div.innerHTML = `
            <div class="flex items-center">
                <i
                    class="fas fa-${tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info'}-circle mr-2"></i>
                <span>${mensaje}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            `;
            document.body.appendChild(div);
            setTimeout(() => div.remove(), 5000);
            }

            function testGuardarNotas() {
            console.log('=== TEST DE GUARDADO ===');

            const form = document.getElementById('notasForm');
            if (!form) {
            console.error('Formulario no encontrado');
            return;
            }

            const inputs = document.querySelectorAll('input[name^="notas["]');
            let hasNotas = false;

            inputs.forEach(input => {
            if (input.value && input.value.trim() !== '') {
            hasNotas = true;
            }
            });

            if (!hasNotas && inputs.length > 0) {
            inputs[0].value = '8';
            console.log('Nota de ejemplo agregada');
            calcularPromedio(inputs[0].name.match(/\[(\d+)\]/)[1]);
            }

            form.dispatchEvent(new Event('submit', {
            bubbles: true,
            cancelable: true
            }));
            }

            // Event Listeners
            document.addEventListener('DOMContentLoaded', function() {
            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                @foreach ($alumnosConNotas as $alumno)
                    calcularPromedio({{ $alumno['asignacion_id'] }});
                @endforeach
            @endif

            setTimeout(() => cargarEstadisticas(), 100);
            });

            document.addEventListener('input', function(e) {
            if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
            const match = e.target.name.match(/notas\[(\d+)\]/);
            if (match) {
            calcularPromedio(parseInt(match[1]));
            }

            clearTimeout(window.estadisticasTimeout);
            window.estadisticasTimeout = setTimeout(() => cargarEstadisticas(), 800);
            }
            });

            document.getElementById('notasForm').addEventListener('submit', function(e) {
            e.preventDefault();

            console.log('Formulario enviado');
            const formData = new FormData(this);

            console.log('Datos del formulario:');
            for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
            }

            mostrarMensaje('Guardando notas...', 'info');

            fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
            })
            .then(response => {
            console.log('Respuesta:', response.status);
            return response.json();
            })
            .then(data => {
            console.log('Datos recibidos:', data);
            if (data.success) {
            mostrarMensaje('Notas guardadas correctamente', 'success');
            setTimeout(() => cargarEstadisticas(), 500);
            } else {
            mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
            if (data.debug_info) {
            console.error('Debug info:', data.debug_info);
            }
            }
            })
            .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error de conexión: ' + error.message, 'error');
            });
            });
            </script>

            inputs.forEach(input => {
            const valor = parseFloat(input.value);
            if (!isNaN(valor) && valor >= 1 && valor <= 10) { notas.push(valor); } }); let promedio = '-'; let
                clasePromedio =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                let estado = 'Sin datos'; let
                claseEstado =
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                let iconoEstado = 'fas fa-minus'; if (notas.length> 0) {
                const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
                promedio = promedioNum.toFixed(1);

                // Determinar el color y estado según la nota
                if (promedioNum >= 7) {
                clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                estado = 'Aprobado';
                claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                iconoEstado = 'fas fa-check-circle';
                } else if (promedioNum >= 4) {
                clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                estado = 'En riesgo';
                claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                iconoEstado = 'fas fa-exclamation-triangle';
                } else {
                clasePromedio =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                estado = 'Desaprobado';
                claseEstado =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                iconoEstado = 'fas fa-times-circle';
                }
                }

                // Actualizar promedio
                const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
                if (spanPromedio) {
                spanPromedio.textContent = promedio;
                spanPromedio.className = clasePromedio;
                }

                // Actualizar estado
                const spanEstado = document.getElementById(`estado-${asignacionId}`);
                if (spanEstado) {
                spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                spanEstado.className = claseEstado;
                }

                // Actualizar dashboard general
                actualizarDashboard();
                }

                // Función para calcular promedio en vista móvil
                function calcularPromedioMobile(asignacionId) {
                // Reutilizar la función principal
                calcularPromedio(asignacionId);

                // Sincronizar elementos móviles
                const promedio = document.getElementById(`promedio-${asignacionId}`);
                const estado = document.getElementById(`estado-${asignacionId}`);
                const promedioMobile = document.getElementById(`promedio-mobile-${asignacionId}`);
                const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);

                if (promedio && promedioMobile) {
                promedioMobile.textContent = promedio.textContent;
                promedioMobile.className = promedio.className;
                }

                if (estado && estadoMobile) {
                estadoMobile.innerHTML = estado.innerHTML;
                estadoMobile.className = estado.className;
                }
                }

                // Función para actualizar el dashboard de estadísticas
                function actualizarDashboard() {
                // Cargar estadísticas dinámicas del backend
                cargarEstadisticas();
                }

                // Cargar estadísticas dinámicas
                function cargarEstadisticas() {
                const params = new URLSearchParams(window.location.search);
                const cupof = params.get('cupof');

                console.log('Cargando estadísticas para CUPOF:', cupof);

                if (!cupof) {
                console.error('No se encontró el cupof en la URL');
                return;
                }

                const url = `/profesores/notas/cargar?cupof=${cupof}`;
                console.log('URL de estadísticas:', url);

                fetch(url, {
                method: 'GET',
                headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
                }
                })
                .then(response => {
                console.log('Respuesta de estadísticas:', response.status, response.statusText);
                return response.json();
                })
                .then(data => {
                console.log('Datos de estadísticas recibidos:', data);
                if (data.estadisticas) {
                actualizarEstadisticasDinamicas(data.estadisticas);
                } else {
                console.warn('No se recibieron estadísticas en la respuesta');
                }
                })
                .catch(error => {
                console.error('Error al cargar estadísticas:', error);
                // Fallback a estadísticas calculadas localmente
                console.log('Usando fallback de estadísticas locales');
                actualizarDashboardLocal();
                });
                } // Actualizar las estadísticas con datos del backend
                function actualizarEstadisticasDinamicas(stats) {
                // Actualizar elementos del dashboard principal
                document.getElementById('total-estudiantes').textContent = stats.total_estudiantes || 0;
                document.getElementById('promedio-general').textContent = (stats.promedio_general || 0).toFixed(1);
                document.getElementById('total-desaprobados').textContent = stats.desaprobados || 0;
                document.getElementById('porcentaje-aprobacion').textContent = (stats.porcentaje_aprobacion ||
                0).toFixed(1)
                +
                '%';

                // Actualizar distribución detallada
                document.getElementById('contador-aprobados').textContent = stats.aprobados || 0;
                document.getElementById('contador-riesgo').textContent = stats.en_riesgo || 0;
                document.getElementById('contador-desaprobados-detalle').textContent = stats.desaprobados || 0;

                // Actualizar texto de progreso
                const textoProgreso = document.getElementById('progreso-texto');
                if (textoProgreso) {
                textoProgreso.textContent = `${stats.progreso_carga || 0}% completado`;
                }

                // Actualizar barra de progreso
                const barraProgreso = document.getElementById('barra-progreso');
                if (barraProgreso) {
                const progresoPorcentaje = stats.progreso_carga || 0;
                barraProgreso.style.width = progresoPorcentaje + '%';

                // Cambiar gradiente según progreso
                if (progresoPorcentaje >= 80) {
                barraProgreso.className =
                        'bg-gradient-to-r from-green-500 to-emerald-600 h-3 rounded-full transition-all duration-500';
                } else if (progresoPorcentaje >= 50) {
                barraProgreso.className =
                        'bg-gradient-to-r from-yellow-500 to-orange-600 h-3 rounded-full transition-all duration-500';
                } else {
                barraProgreso.className =
                        'bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500';
                }
                }

                // Actualizar colores dinámicos según las métricas
                actualizarColoresDinamicos(stats.promedio_general || 0, stats.porcentaje_aprobacion || 0);
                }

                // Función fallback para cálculo local de estadísticas
                function actualizarDashboardLocal() {
                const totalEstudiantes = document.querySelectorAll('[id^="promedio-"]').length;
                let totalConNotas = 0;
                let sumaPromedios = 0;
                let aprobados = 0;
                let desaprobados = 0;
                let enRiesgo = 0;
                let totalInputsLlenos = 0;
                let totalInputs = 0;

                // Recorrer todos los promedios
                document.querySelectorAll('[id^="promedio-"]').forEach(span => {
                const texto = span.textContent;
                if (texto !== '-') {
                const promedio = parseFloat(texto);
                totalConNotas++;
                sumaPromedios += promedio;

                if (promedio >= 7) {
                aprobados++;
                } else if (promedio >= 4) {
                enRiesgo++;
                } else {
                desaprobados++;
                }
                }
                });

                // Calcular progreso de carga (inputs llenos)
                document.querySelectorAll('input[type="number"]').forEach(input => {
                totalInputs++;
                if (input.value && input.value.trim() !== '') {
                totalInputsLlenos++;
                }
                });

                // Calcular métricas
                const promedioGeneral = totalConNotas > 0 ? (sumaPromedios / totalConNotas).toFixed(1) : '0.0';
                const porcentajeAprobacion = totalConNotas > 0 ? Math.round((aprobados / totalConNotas) * 100) : 0;
                const progresoPorcentaje = totalInputs > 0 ? Math.round((totalInputsLlenos / totalInputs) * 100) : 0;

                // Actualizar elementos del dashboard principal
                document.getElementById('total-estudiantes').textContent = totalEstudiantes;
                document.getElementById('promedio-general').textContent = promedioGeneral;
                document.getElementById('total-desaprobados').textContent = desaprobados;
                document.getElementById('porcentaje-aprobacion').textContent = porcentajeAprobacion + '%';

                // Actualizar distribución detallada
                document.getElementById('contador-aprobados').textContent = aprobados;
                document.getElementById('contador-riesgo').textContent = enRiesgo;
                document.getElementById('contador-desaprobados-detalle').textContent = desaprobados;

                // Actualizar texto de progreso
                const textoProgreso = document.getElementById('progreso-texto');
                if (textoProgreso) {
                textoProgreso.textContent = `${totalInputsLlenos} de ${totalInputs} campos completados`;
                }

                // Actualizar barra de progreso
                const barraProgreso = document.getElementById('barra-progreso');
                if (barraProgreso) {
                barraProgreso.style.width = progresoPorcentaje + '%';

                // Cambiar gradiente según progreso
                if (progresoPorcentaje >= 80) {
                barraProgreso.className =
                        'bg-gradient-to-r from-green-500 to-emerald-600 h-3 rounded-full transition-all duration-500';
                } else if (progresoPorcentaje >= 50) {
                barraProgreso.className =
                        'bg-gradient-to-r from-yellow-500 to-orange-600 h-3 rounded-full transition-all duration-500';
                } else {
                barraProgreso.className =
                        'bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500';
                }
                }

                // Actualizar colores dinámicos según las métricas
                actualizarColoresDinamicos(promedioGeneral, porcentajeAprobacion);
                }

                // Función para actualizar colores dinámicos del dashboard
                function actualizarColoresDinamicos(promedioGeneral, porcentajeAprobacion) {
                // Cambiar color del promedio general (mantener azul para promedio general)
                const elemPromedioGeneral = document.getElementById('promedio-general');
                if (elemPromedioGeneral) {
                const promedio = parseFloat(promedioGeneral);
                if (promedio >= 7) {
                elemPromedioGeneral.className =
                        'text-2xl font-semibold text-blue-600'; // Azul
                para
                consistencia con totales
                } else if (promedio >= 4) {
                elemPromedioGeneral.className = 'text-2xl font-semibold text-orange-600';
                } else if (promedio > 0) {
                elemPromedioGeneral.className = 'text-2xl font-semibold text-red-600';
                } else {
                elemPromedioGeneral.className = 'text-2xl font-semibold text-gray-900'; // Color por defecto
                }
                }

                // Mantener colores fijos para % aprobación (amarillo) y desaprobados (rojo) según totales
                const elemPorcentaje = document.getElementById('porcentaje-aprobacion');
                if (elemPorcentaje) {
                // Mantener color amarillo fijo para consistencia con totales
                elemPorcentaje.className = 'text-2xl font-semibold text-yellow-600';
                }

                // Mantener color rojo fijo para desaprobados según totales
                const elemDesaprobados = document.getElementById('total-desaprobados');
                if (elemDesaprobados) {
                elemDesaprobados.className = 'text-2xl font-semibold text-red-600';
                }
                }

                // Función para limpiar el formulario
                function limpiarFormulario() {
                if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                const inputs = document.querySelectorAll('input[type="number"]');
                inputs.forEach(input => {
                input.value = '';
                });

                // Limpiar promedios y estados
                const spans = document.querySelectorAll('[id^="promedio-"]');
                spans.forEach(span => {
                span.textContent = '-';
                span.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                });

                const estados = document.querySelectorAll('[id^="estado-"]');
                estados.forEach(estado => {
                estado.innerHTML = '<i class="fas fa-minus mr-1"></i>Sin datos';
                estado.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                });

                // Actualizar dashboard
                actualizarDashboard();
                }
                }

                // Función para limpiar las notas de un alumno específico
                function limpiarFilaAlumno(asignacionId) {
                const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
                inputs.forEach(input => {
                input.value = '';
                });
                calcularPromedio(asignacionId);
                // También actualizar vista móvil
                calcularPromedioMobile(asignacionId);
                }

                // Función para mostrar mensajes de éxito/error
                function mostrarMensaje(mensaje, tipo = 'info') {
                const div = document.createElement('div');
                div.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
                tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
                }`;
                div.innerHTML = `
                <div class="flex items-center">
                    <i
                        class="fas fa-${tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info'}-circle mr-2"></i>
                    <span>${mensaje}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                `;

                document.body.appendChild(div);
                setTimeout(() => div.remove(), 5000);
                }

                // Manejar envío del formulario
                document.getElementById('notasForm').addEventListener('submit', function(e) {
                e.preventDefault();

                console.log('Formulario enviado - iniciando procesamiento');

                const formData = new FormData(this);

                // Debug: mostrar todos los datos que se van a enviar
                console.log('Datos del formulario:');
                for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
                }

                // Mostrar indicador de carga
                mostrarMensaje('Guardando notas...', 'info');

                // Enviar por AJAX
                fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
                })
                .then(response => {
                console.log('Respuesta recibida:', response.status, response.statusText);
                return response.json();
                })
                .then(data => {
                console.log('Datos de respuesta:', data);
                if (data.success) {
                mostrarMensaje('Notas guardadas correctamente', 'success');
                // Actualizar estadísticas dinámicas después de guardar
                setTimeout(() => {
                cargarEstadisticas();
                }, 500);
                } else {
                mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
                if (data.errores) {
                console.error('Errores específicos:', data.errores);
                }
                }
                })
                .catch(error => {
                console.error('Error completo:', error);
                mostrarMensaje('Error de conexión: ' + error.message, 'error');
                });
                });
                });

                // Calcular promedios al cargar la página
                document.addEventListener('DOMContentLoaded', function() {
                @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                    @foreach ($alumnosConNotas as $alumno)
                        calcularPromedio({{ $alumno['asignacion_id'] }});
                    @endforeach
                @endif

                // Cargar estadísticas dinámicas inicial
                setTimeout(() => {
                cargarEstadisticas();
                }, 100);
                });

                // Agregar evento para actualizar estadísticas cuando se cambien valores
                document.addEventListener('input', function(e) {
                if (e.target.type === 'number' && e.target.name && e.target.name.includes('notas[')) {
                // Actualizar promedio inmediatamente
                const match = e.target.name.match(/notas\[(\d+)\]/);
                if (match) {
                calcularPromedio(parseInt(match[1]));
                }

                // Actualizar estadísticas con debounce
                clearTimeout(window.estadisticasTimeout);
                window.estadisticasTimeout = setTimeout(() => {
                cargarEstadisticas();
                }, 800);
                }
                });

                // Función de test para debug
                function testGuardarNotas() {
                console.log('=== TEST DE GUARDADO
                ===');
            
            // Obtener formulario
            const form = document.getElementById('notasForm');
                if (!form) {
                console.error('Formulario no encontrado');
                return;
                }

                // Llenar nota de ejemplo si no hay notas
                const inputs = document.querySelectorAll('input[name^="notas["]');
                let hasNotas = false;

                inputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                hasNotas = true;
                }
                });

                if (!hasNotas && inputs.length > 0) {
                inputs[0].value = '8';
                console.log('Nota de ejemplo agregada:', inputs[0].name, '= 8');
                }

                // Disparar evento submit
                console.log('Enviando formulario...');
                const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
                form.dispatchEvent(submitEvent);
                }
                </script>
</x-layouts.profesores.dashboard>
