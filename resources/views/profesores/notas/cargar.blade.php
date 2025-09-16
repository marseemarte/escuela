{{-- Vista para cargar notas de una materia específica --}}
<x-layouts.profesores.dashboard notas titulo="Cargar Notas">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="space-y-6">
        {{-- Header con información de la materia --}}
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                    {{-- Botón de regreso --}}
                    <a href="{{ route('profesores.notas.index') }}"
                        class="inline-flex items-center justify-center sm:justify-start px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>

                    {{-- Información de la materia --}}
                    <div class="text-center sm:text-left">
                        <h1 class="text-lg sm:text-2xl font-bold text-gray-900">
                            {{ $cupofInfo->materia_nombre ?? 'Materia' }}</h1>
                        <p class="text-sm sm:text-base text-gray-600">
                            {{ $cupofInfo->ano ?? '7' }}° {{ $cupofInfo->division ?? 'C' }} -
                            {{ $cupofInfo->grupo_nombre ?? 'Grupo' }}
                            (Turno
                            {{ ucfirst(($cupofInfo->turno ?? 'M') === 'M' ? 'Mañana' : (($cupofInfo->turno ?? 'M') === 'T' ? 'Tarde' : 'Noche')) }})
                        </p>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="text-center sm:text-right">
                    <div class="text-sm text-gray-500">
                        <div>Período: {{ now()->format('Y') }}</div>
                    </div>
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
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Notas
                    </button>
                </div>

                {{-- Tabla principal --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                            <tr>
                                <th class="px-4 py-3 text-left">Nombre</th>
                                <th class="px-4 py-3 text-left">Apellido</th>
                                <th class="px-4 py-3">1° Período</th>
                                <th class="px-4 py-3">2° Período</th>
                                <th class="px-4 py-3">3° Período</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-center divide-y divide-gray-200">
                            {{-- Si hay alumnos dinámicos, los mostramos aquí --}}
                            @if (isset($alumnosConNotas) && count($alumnosConNotas) > 0)
                                @foreach ($alumnosConNotas as $index => $alumno)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-4 py-3 text-left font-medium text-gray-900">
                                            {{ $alumno['nombre'] }}</td>
                                        <td class="px-4 py-3 text-left font-medium text-gray-900">
                                            {{ $alumno['apellido'] }}</td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][1]"
                                                value="{{ $alumno['notas']['1'] }}" min="1" max="10"
                                                step="0.1"
                                                class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md text-center focus:ring-green-500 focus:border-green-500"
                                                placeholder="-">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][2]"
                                                value="{{ $alumno['notas']['2'] }}" min="1" max="10"
                                                step="0.1"
                                                class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md text-center focus:ring-green-500 focus:border-green-500"
                                                placeholder="-">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="notas[{{ $alumno['asignacion_id'] }}][3]"
                                                value="{{ $alumno['notas']['3'] }}" min="1" max="10"
                                                step="0.1"
                                                class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md text-center focus:ring-green-500 focus:border-green-500"
                                                placeholder="-">
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                onclick="limpiarFilaAlumno({{ $alumno['asignacion_id'] }})"
                                                class="text-gray-400 hover:text-red-600 transition-colors duration-200"
                                                title="Limpiar notas del alumno">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
                        <div class="flex space-x-3">
                            <button type="button" onclick="limpiarFormulario()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-eraser mr-2"></i>
                                Limpiar
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-save mr-2"></i>
                                Guardar Todas las Notas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Scripts para funcionalidad --}}
    <script>
        // Función para calcular nota final automáticamente
        function calcularNotaFinal(alumnoId) {
            const inputs = document.querySelectorAll(`input[name^="notas[${alumnoId}]"]`);
            let notas = [];

            inputs.forEach(input => {
                const valor = parseFloat(input.value);
                if (!isNaN(valor) && valor >= 1 && valor <= 10) {
                    notas.push(valor);
                }
            });

            let notaFinal = '-';
            let clase = 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800';

            if (notas.length > 0) {
                const promedio = notas.reduce((a, b) => a + b, 0) / notas.length;
                notaFinal = promedio.toFixed(1);

                // Determinar el color según la nota
                if (promedio >= 7) {
                    clase = 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800';
                } else if (promedio >= 4) {
                    clase = 'px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800';
                } else {
                    clase = 'px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800';
                }
            }

            const spanFinal = document.getElementById(`nota-final-${alumnoId}`);
            if (spanFinal) {
                spanFinal.textContent = notaFinal;
                spanFinal.className = clase;
            }
        }

        // Función para limpiar el formulario
        function limpiarFormulario() {
            if (confirm('¿Está seguro que desea limpiar todas las notas?')) {
                const inputs = document.querySelectorAll('input[type="number"]');
                inputs.forEach(input => {
                    input.value = '';
                });

                // Limpiar notas finales
                const spans = document.querySelectorAll('[id^="nota-final-"]');
                spans.forEach(span => {
                    span.textContent = '-';
                    span.className = 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800';
                });
            }
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

        // Función para limpiar las notas de un alumno específico
        function limpiarFilaAlumno(asignacionId) {
            const inputs = document.querySelectorAll(`input[name^="notas[${asignacionId}]"]`);
            inputs.forEach(input => {
                input.value = '';
            });
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
    </script>
</x-layouts.profesores.dashboard>
{{-- Vista de tabla para pantallas medianas y grandes --}}
<div class="hidden md:block overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Estudiante
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    1° Informe
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    1° Cuatrimestre
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    2° Informe
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    2° Cuatrimestre
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cierre
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Diciembre
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Febrero
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nota Final
                </th>
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($alumnos as $alumno)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-green-800">
                                        {{ substr($alumno->nombre, 0, 1) }}{{ substr($alumno->apellido, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                </div>
                                <div class="text-sm text-gray-500">DNI: {{ $alumno->dni }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="1er_informe">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="1er_cuatrimestre">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="2do_informe">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="2do_cuatrimestre">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="cierre">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="diciembre">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" max="10"
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                            placeholder="-" data-alumno="{{ $alumno->id }}" data-periodo="febrero">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800"
                            id="nota-final-{{ $alumno->id }}">-</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <button type="button" class="text-green-600 hover:text-green-900 mr-2"
                            onclick="guardarNotasAlumno({{ $alumno->id }})">
                            <i class="fas fa-save"></i>
                        </button>
                        <button type="button" class="text-blue-600 hover:text-blue-900"
                            onclick="editarAlumno({{ $alumno->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Vista móvil --}}
<div class="md:hidden">
    @foreach ($alumnos as $alumno)
        <div class="border-b border-gray-200 p-4">
            <div class="flex items-center mb-3">
                <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                        <span class="text-sm font-medium text-green-800">
                            {{ substr($alumno->nombre, 0, 1) }}{{ substr($alumno->apellido, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <div class="text-sm font-medium text-gray-900">
                        {{ $alumno->apellido }}, {{ $alumno->nombre }}
                    </div>
                    <div class="text-sm text-gray-500">DNI: {{ $alumno->dni }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">1° Informe</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="1er_informe">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">1° Cuatrimestre</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="1er_cuatrimestre">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">2° Informe</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="2do_informe">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">2° Cuatrimestre</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="2do_cuatrimestre">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Cierre</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="cierre">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Diciembre</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="diciembre">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Febrero</label>
                    <input type="number" min="1" max="10"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md"
                        data-alumno="{{ $alumno->id }}" data-periodo="febrero">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nota Final</label>
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                        id="nota-final-mobile-{{ $alumno->id }}">-</span>
                </div>
            </div>

            <div class="mt-3 flex justify-end space-x-2">
                <button type="button"
                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700"
                    onclick="guardarNotasAlumno({{ $alumno->id }})">
                    <i class="fas fa-save mr-1"></i>
                    Guardar
                </button>
            </div>
        </div>
    @endforeach
</div>

{{-- Botón para guardar todas las notas --}}
<div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Total de estudiantes: {{ count($alumnos) }}
        </div>
        <button type="button"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            onclick="guardarTodasLasNotas()">
            <i class="fas fa-save mr-2"></i>
            Guardar Todas las Notas
        </button>
    </div>
</div>
@else
{{-- Estado vacío --}}
<div class="text-center py-12">
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
        <i class="fas fa-users text-gray-400 text-xl"></i>
    </div>
    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay estudiantes registrados</h3>
    <p class="mt-2 text-gray-500">
        No se encontraron estudiantes para esta materia.
    </p>
</div>
@endif
</div>
</div>

{{-- Scripts para manejo de notas --}}
<script>
    // Token CSRF para las peticiones AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Función para calcular nota final
    function calcularNotaFinal(alumnoId) {
        const inputs = document.querySelectorAll(`input[data-alumno="${alumnoId}"]`);
        let notas = [];

        inputs.forEach(input => {
            const valor = parseFloat(input.value);
            if (!isNaN(valor) && valor >= 1 && valor <= 10) {
                notas.push(valor);
            }
        });

        let notaFinal = '-';
        if (notas.length > 0) {
            const promedio = notas.reduce((a, b) => a + b, 0) / notas.length;
            notaFinal = promedio.toFixed(1);
        }

        // Actualizar la vista de escritorio
        const spanFinal = document.getElementById(`nota-final-${alumnoId}`);
        if (spanFinal) {
            spanFinal.textContent = notaFinal;
            spanFinal.className = getNotaClass(notaFinal);
        }

        // Actualizar la vista móvil
        const spanFinalMobile = document.getElementById(`nota-final-mobile-${alumnoId}`);
        if (spanFinalMobile) {
            spanFinalMobile.textContent = notaFinal;
            spanFinalMobile.className = getNotaClass(notaFinal);
        }
    }

    // Función para obtener clases CSS según la nota
    function getNotaClass(nota) {
        const baseClass = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ';
        if (nota === '-') return baseClass + 'bg-gray-100 text-gray-800';

        const notaNum = parseFloat(nota);
        if (notaNum >= 7) return baseClass + 'bg-green-100 text-green-800';
        if (notaNum >= 4) return baseClass + 'bg-yellow-100 text-yellow-800';
        return baseClass + 'bg-red-100 text-red-800';
    }

    // Event listeners para recalcular nota final cuando cambian los inputs
    document.addEventListener('input', function(e) {
        if (e.target.hasAttribute('data-alumno')) {
            const alumnoId = e.target.getAttribute('data-alumno');
            calcularNotaFinal(alumnoId);
        }
    });

    // Función para guardar notas de un alumno específico
    function guardarNotasAlumno(alumnoId) {
        const inputs = document.querySelectorAll(`input[data-alumno="${alumnoId}"]`);
        const notas = {};

        inputs.forEach(input => {
            const periodo = input.getAttribute('data-periodo');
            const valor = input.value;
            if (valor && !isNaN(parseFloat(valor))) {
                notas[periodo] = parseFloat(valor);
            }
        });

        // Aquí iría la llamada AJAX para guardar en la base de datos
        console.log('Guardando notas para alumno:', alumnoId, notas);

        // Simulación de guardado exitoso
        mostrarMensaje('Notas guardadas correctamente', 'success');
    }

    // Función para guardar todas las notas
    function guardarTodasLasNotas() {
        const todosLosInputs = document.querySelectorAll('input[data-alumno]');
        const notasPorAlumno = {};

        todosLosInputs.forEach(input => {
            const alumnoId = input.getAttribute('data-alumno');
            const periodo = input.getAttribute('data-periodo');
            const valor = input.value;

            if (!notasPorAlumno[alumnoId]) {
                notasPorAlumno[alumnoId] = {};
            }

            if (valor && !isNaN(parseFloat(valor))) {
                notasPorAlumno[alumnoId][periodo] = parseFloat(valor);
            }
        });

        // Aquí iría la llamada AJAX para guardar todas las notas
        console.log('Guardando todas las notas:', notasPorAlumno);

        // Simulación de guardado exitoso
        mostrarMensaje('Todas las notas han sido guardadas correctamente', 'success');
    }

    // Función para mostrar mensajes
    function mostrarMensaje(mensaje, tipo = 'info') {
        // Crear elemento de mensaje
        const div = document.createElement('div');
        div.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
                tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                tipo === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
        div.textContent = mensaje;

        document.body.appendChild(div);

        // Remover después de 3 segundos
        setTimeout(() => {
            div.remove();
        }, 3000);
    }

    // Función para editar alumno (modal)
    function editarAlumno(alumnoId) {
        // Aquí se abriría un modal similar al de la vista original
        console.log('Editando alumno:', alumnoId);
    }

    // Calcular notas finales al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const alumnosIds = [...new Set(Array.from(document.querySelectorAll('input[data-alumno]')).map(input =>
            input.getAttribute('data-alumno')))];
        alumnosIds.forEach(id => calcularNotaFinal(id));
    });
</script>
</x-layouts.profesores.dashboard>
