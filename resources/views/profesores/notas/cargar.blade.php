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
                    <div class="text-sm text-gray-500">CUPOF: {{ $cupof }}</div>
                </div>
            </div>
        </div>

        {{-- Formulario principal --}}
        <form id="notasForm" method="POST" action="{{ route('profesores.notas.guardar') }}">
            @csrf
            <input type="hidden" name="cupof" value="{{ $cupof }}">

            {{-- Tabla de notas --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Informes {{ now()->format('Y') }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Ingrese las notas directamente en la tabla</p>
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
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                            <tr>
                                <th class="px-4 py-3 text-left">Nombre</th>
                                <th class="px-4 py-3 text-left">Apellido</th>
                                <th class="px-4 py-3">1° Informe</th>
                                <th class="px-4 py-3">1° Cuatrimestre</th>
                                <th class="px-4 py-3">2° Informe</th>
                                <th class="px-4 py-3">2° Cuatrimestre</th>
                                <th class="px-4 py-3">Promedio</th>
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

                                        {{-- Promedio --}}
                                        <td class="px-4 py-4">
                                            <span id="promedio-{{ $alumno['asignacion_id'] }}"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                -
                                            </span>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-4 py-4">
                                            <button type="button"
                                                onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                class="text-red-600 hover:text-red-900 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No hay alumnos inscriptos en esta materia
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Footer con botón de guardar --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Total de estudiantes: {{ isset($alumnosConNotas) ? count($alumnosConNotas) : 0 }}
                        </div>
                        <div class="flex space-x-2">
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
            let clase = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';

            if (notas.length > 0) {
                const promedioNum = notas.reduce((a, b) => a + b, 0) / notas.length;
                promedio = promedioNum.toFixed(1);

                // Determinar el color según la nota
                if (promedioNum >= 7) {
                    clase =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                } else if (promedioNum >= 4) {
                    clase =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
                } else {
                    clase =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                }
            }

            const spanPromedio = document.getElementById(`promedio-${asignacionId}`);
            if (spanPromedio) {
                spanPromedio.textContent = promedio;
                spanPromedio.className = clase;
            }
        }

        // Función para limpiar el formulario
        function limpiarFormulario() {
            if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                const inputs = document.querySelectorAll('input[type="number"]');
                inputs.forEach(input => {
                    input.value = '';
                });

                // Limpiar promedios
                const spans = document.querySelectorAll('[id^="promedio-"]');
                spans.forEach(span => {
                    span.textContent = '-';
                    span.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                });
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

        // Manejar envío del formulario
        document.getElementById('notasForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Enviar por AJAX
            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarMensaje('Notas guardadas correctamente', 'success');
                    } else {
                        mostrarMensaje(data.message || 'Error al guardar las notas', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarMensaje('Error de conexión', 'error');
                });
        });

        // Calcular promedios al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                @foreach ($alumnosConNotas as $alumno)
                    calcularPromedio({{ $alumno['asignacion_id'] }});
                @endforeach
            @endif
        });
    </script>
</x-layouts.profesores.dashboard>
