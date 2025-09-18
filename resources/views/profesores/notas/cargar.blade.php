<x-layouts.profesores.dashboard title="Cargar Notas">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cargar Notas') }}
        </h2>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dashboard de Estadísticas -->
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Dashboard de Notas - {{ $cupofInfo->grupo_nombre ?? 'N/A' }} | {{ $cupofInfo->materia_nombre }} |
                {{ $cupofInfo->ano }}° - División {{ $cupofInfo->division }}
            </h3>

            <!-- Grid de estadísticas principales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total de Estudiantes -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Estudiantes</p>
                            <p id="total-estudiantes" class="text-2xl font-semibold text-blue-900">
                                {{ isset($alumnosConNotas) ? count($alumnosConNotas) : 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Promedio General -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Promedio General</p>
                            <p id="promedio-general" class="text-2xl font-semibold text-green-900">
                                {{ isset($estadisticasDinamicas['promedio_general']) ? number_format($estadisticasDinamicas['promedio_general'], 1) : '0.0' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Porcentaje de Aprobación -->
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-percentage text-2xl text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-yellow-600">% Aprobación</p>
                            <p id="porcentaje-aprobacion" class="text-2xl font-semibold text-yellow-900">
                                {{ isset($estadisticasDinamicas['porcentaje_aprobacion']) ? number_format($estadisticasDinamicas['porcentaje_aprobacion'], 1) : '0' }}%
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Desaprobados -->
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-600">Desaprobados</p>
                            <p id="total-desaprobados" class="text-2xl font-semibold text-red-900">
                                {{ isset($estadisticasDinamicas['desaprobados']) ? $estadisticasDinamicas['desaprobados'] : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribución de Calificaciones -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h4 class="text-md font-medium text-gray-900 mb-3">Distribución de Estados</h4>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600" id="contador-aprobados">
                            {{ isset($estadisticasDinamicas['aprobados']) ? $estadisticasDinamicas['aprobados'] : 0 }}
                        </div>
                        <div class="text-sm text-gray-600">Aprobados (≥7)</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600" id="contador-riesgo">
                            {{ isset($estadisticasDinamicas['en_riesgo']) ? $estadisticasDinamicas['en_riesgo'] : 0 }}
                        </div>
                        <div class="text-sm text-gray-600">En Riesgo (4-6.9)</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600" id="contador-desaprobados-detalle">
                            {{ isset($estadisticasDinamicas['desaprobados']) ? $estadisticasDinamicas['desaprobados'] : 0 }}
                        </div>
                        <div class="text-sm text-gray-600">Desaprobados (<4)< /div>
                        </div>
                    </div>
                </div>

                <!-- Progreso de Carga -->
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-indigo-900 mb-2">Progreso de Carga</h4>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div id="barra-progreso"
                            class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500"
                            style="width: {{ isset($estadisticasDinamicas['progreso_carga']) ? $estadisticasDinamicas['progreso_carga'] : 0 }}%">
                        </div>
                    </div>
                    <p id="progreso-texto" class="text-sm text-indigo-700">
                        {{ isset($estadisticasDinamicas['progreso_carga']) ? $estadisticasDinamicas['progreso_carga'] : 0 }}%
                        completado
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario de Notas -->
        <div class="bg-white shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Listado de Estudiantes</h3>
                    <div class="flex space-x-2">
                        <button onclick="limpiarFormulario()"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-eraser mr-1"></i> Limpiar Todo
                        </button>
                        <!-- Botón para Desktop -->
                        <button type="submit" form="notasFormDesktop"
                            class="hidden md:inline-flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-save mr-1"></i> Guardar Notas
                        </button>
                        <!-- Botón para Mobile -->
                        <button type="submit" form="notasFormMobile"
                            class="md:hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-save mr-1"></i> Guardar Notas
                        </button>
                    </div>
                </div>

                @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                    <!-- Vista Desktop -->
                    <form id="notasFormDesktop" action="{{ route('profesores.notas.guardar') }}" method="POST"
                        class="hidden md:block">
                        @csrf
                        <input type="hidden" name="cupof" value="{{ $cupof }}">

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estudiante
                                        </th>
                                        <th
                                            class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            1° Informe
                                        </th>
                                        <th
                                            class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            1° Cuatrimestre
                                        </th>
                                        <th
                                            class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            2° Informe
                                        </th>
                                        <th
                                            class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            2° Cuatrimestre
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Promedio
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th
                                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($alumnosConNotas as $alumno)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                                </div>
                                                <div class="text-sm text-gray-500">DNI:
                                                    {{ $alumno['dni'] }}</div>
                                            </td>
                                            <td class="px-3 py-4 text-center">
                                                <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                    value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    min="1" max="10" step="0.1">
                                            </td>
                                            <td class="px-3 py-4 text-center">
                                                <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                    value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    min="1" max="10" step="0.1">
                                            </td>
                                            <td class="px-3 py-4 text-center">
                                                <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                    value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    min="1" max="10" step="0.1">
                                            </td>
                                            <td class="px-3 py-4 text-center">
                                                <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                                    value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    min="1" max="10" step="0.1">
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <span id="promedio-{{ $alumno['asignacion_id'] }}"
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    -
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <span id="estado-{{ $alumno['asignacion_id'] }}"
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-minus mr-1"></i>Sin datos
                                                </span>
                                            </td>
                                            <td class="px-2 py-4 text-center">
                                                <button type="button"
                                                    onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                    class="text-gray-400 hover:text-red-600 text-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Vista Mobile -->
                    <form id="notasFormMobile" action="{{ route('profesores.notas.guardar') }}" method="POST"
                        class="md:hidden">
                        @csrf
                        <input type="hidden" name="cupof" value="{{ $cupof }}">

                        <div class="space-y-4">
                            @foreach ($alumnosConNotas as $alumno)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                            </h4>
                                            <p class="text-sm text-gray-500">DNI: {{ $alumno['dni'] }}
                                            </p>
                                        </div>
                                        <button type="button"
                                            onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                            class="text-gray-400 hover:text-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">1°
                                                Informe</label>
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                value="{{ $alumno['nota_periodo_1'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                min="1" max="10" step="0.1">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">1°
                                                Cuatrimestre</label>
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                value="{{ $alumno['nota_periodo_2'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                min="1" max="10" step="0.1">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">2°
                                                Informe</label>
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                value="{{ $alumno['nota_periodo_3'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                min="1" max="10" step="0.1">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">2°
                                                Cuatrimestre</label>
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][4]"
                                                value="{{ $alumno['nota_periodo_4'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                min="1" max="10" step="0.1">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                        <div class="text-center">
                                            <span class="text-xs text-gray-500">Promedio</span>
                                            <div id="promedio-mobile-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                -
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-xs text-gray-500">Estado</span>
                                            <div id="estado-mobile-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                <i class="fas fa-minus mr-1"></i>Sin datos
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No hay estudiantes asignados a esta materia.</p>
                    </div>
                @endif
            </div>
        </div>

        <script>
            // Función para calcular el promedio de un alumno específico
            function calcularPromedio(asignacionId) {
                const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
                const notas = [];

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

                // Actualizar promedio en vista desktop
                const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
                if (spanPromedio) {
                    spanPromedio.textContent = promedio;
                    spanPromedio.className = clasePromedio;
                }

                // Actualizar estado en vista desktop
                const spanEstado = document.getElementById(`estado-${asignacionId}`);
                if (spanEstado) {
                    spanEstado.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                    spanEstado.className = claseEstado;
                }

                // Actualizar promedio en vista móvil
                const promedioMobile = document.getElementById(`promedio-mobile-${asignacionId}`);
                if (promedioMobile) {
                    promedioMobile.textContent = promedio;
                    promedioMobile.className = clasePromedio;
                }

                // Actualizar estado en vista móvil
                const estadoMobile = document.getElementById(`estado-mobile-${asignacionId}`);
                if (estadoMobile) {
                    estadoMobile.innerHTML = `<i class="${iconoEstado} mr-1"></i>${estado}`;
                    estadoMobile.className = claseEstado;
                }

                actualizarDashboard();
            }

            // Función para actualizar el dashboard de estadísticas
            function actualizarDashboard() {
                cargarEstadisticas();
            }

            // Cargar estadísticas dinámicas
            function cargarEstadisticas() {
                // Obtener cupof de la URL (/profesores/notas/1001)
                const pathParts = window.location.pathname.split('/');
                const cupof = pathParts[pathParts.length - 1];

                if (!cupof || cupof === 'notas') return;

                fetch(`/profesores/notas/${cupof}`, {
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

            // Actualizar las estadísticas con datos del backend
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

            // Función fallback para cálculo local de estadísticas
            function actualizarDashboardLocal() {
                const totalEstudiantes = document.querySelectorAll('[id^="promedio-"]').length /
                    2; // Dividido por 2 porque hay desktop y mobile
                let totalConNotas = 0;
                let sumaPromedios = 0;
                let aprobados = 0;
                let desaprobados = 0;
                let enRiesgo = 0;
                let totalInputsLlenos = 0;
                let totalInputs = 0;

                // Recorrer todos los promedios (solo desktop para evitar duplicados)
                document.querySelectorAll('[id^="promedio-"]:not([id*="mobile"])').forEach(span => {
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

                // Calcular progreso de carga (solo contar inputs de desktop para evitar duplicados)
                // Cada estudiante tiene 4 períodos, así que el total debe ser totalEstudiantes * 4
                document.querySelectorAll('#notasFormDesktop input[type="number"]').forEach(input => {
                    totalInputs++;
                    if (input.value && input.value.trim() !== '') {
                        totalInputsLlenos++;
                    }
                });

                // Calcular métricas
                const promedioGeneral = totalConNotas > 0 ? (sumaPromedios / totalConNotas).toFixed(1) : '0.0';
                const porcentajeAprobacion = totalConNotas > 0 ? Math.round((aprobados / totalConNotas) * 100) : 0;
                const progresoPorcentaje = totalInputs > 0 ? Math.round((totalInputsLlenos / totalInputs) * 100) : 0;

                // Actualizar elementos del dashboard
                document.getElementById('total-estudiantes').textContent = totalEstudiantes;
                document.getElementById('promedio-general').textContent = promedioGeneral;
                document.getElementById('total-desaprobados').textContent = desaprobados;
                document.getElementById('porcentaje-aprobacion').textContent = porcentajeAprobacion + '%';
                document.getElementById('contador-aprobados').textContent = aprobados;
                document.getElementById('contador-riesgo').textContent = enRiesgo;
                document.getElementById('contador-desaprobados-detalle').textContent = desaprobados;

                const textoProgreso = document.getElementById('progreso-texto');
                if (textoProgreso) {
                    textoProgreso.textContent = `${progresoPorcentaje}% completado`;
                }

                const barraProgreso = document.getElementById('barra-progreso');
                if (barraProgreso) {
                    barraProgreso.style.width = progresoPorcentaje + '%';
                }
            }

            // Función para limpiar el formulario
            function limpiarFormulario() {
                if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                    document.querySelectorAll('input[type="number"]').forEach(input => {
                        input.value = '';
                    });

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

            // Función para limpiar las notas de un alumno específico
            function limpiarFilaAlumno(asignacionId) {
                const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
                inputs.forEach(input => {
                    input.value = '';
                });
                calcularPromedio(asignacionId);
            }

            // Función para mostrar mensajes
            function mostrarMensaje(mensaje, tipo = 'info') {
                const div = document.createElement('div');
                div.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
                tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
                div.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${tipo === 'success' ? 'check' : tipo === 'error' ? 'times' : 'info'}-circle mr-2"></i>
                    <span>${mensaje}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                document.body.appendChild(div);
                setTimeout(() => div.remove(), 5000);
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

            // Actualizar promedios cuando cambian los valores
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

            // Manejar envío de ambos formularios
            function handleFormSubmit(formElement, formName) {
                console.log(`=== FORMULARIO ${formName} ENVIADO ===`);
                console.log('Action URL:', formElement.action);
                console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').content);

                const formData = new FormData(formElement);

                // Log todos los datos del formulario
                for (let [key, value] of formData.entries()) {
                    console.log(key + ': ' + value);
                }

                mostrarMensaje('Guardando notas...', 'info');

                fetch(formElement.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            let mensaje = 'Cambios guardados correctamente';
                            if (data.notas_nuevas > 0 && data.notas_actualizadas_eliminadas > 0) {
                                mensaje +=
                                    ` (${data.notas_nuevas} nuevas, ${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                            } else if (data.notas_nuevas > 0) {
                                mensaje += ` (${data.notas_nuevas} notas nuevas)`;
                            } else if (data.notas_actualizadas_eliminadas > 0) {
                                mensaje += ` (${data.notas_actualizadas_eliminadas} actualizadas/eliminadas)`;
                            }
                            mostrarMensaje(mensaje, 'success');

                            // Recargar la página después de un breve delay para refrescar las notas desde la BD
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            mostrarMensaje(data.message || data.error || 'Error al guardar las notas', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error completo:', error);
                        mostrarMensaje('Error de conexión: ' + error.message, 'error');
                    });
            }

            // Formulario Desktop
            const desktopForm = document.getElementById('notasFormDesktop');
            if (desktopForm) {
                desktopForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleFormSubmit(this, 'DESKTOP');
                });
            }

            // Formulario Mobile
            const mobileForm = document.getElementById('notasFormMobile');
            if (mobileForm) {
                mobileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleFormSubmit(this, 'MOBILE');
                });
            }
        </script>
</x-layouts.profesores.dashboard>
