{{-- Vista de estadísticas de notas --}}
<x-layouts.profesores.dashboard notas titulo="Estadísticas de Notas">
    <div class="p-4 sm:p-6">
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Estadísticas de Notas</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">
                        {{ $cupofInfo->materia_nombre }} - {{ $cupofInfo->ano }}° {{ $cupofInfo->division }}
                        "{{ $cupofInfo->grupo_nombre }}" ({{ $cupofInfo->turno }})
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('profesores.notas.index') }}"
                        class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Materias
                    </a>
                    <a href="{{ route('profesores.notas.cargar', $cupofInfo->cupof) }}"
                        class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Cargar Notas
                    </a>
                </div>
            </div>
        </div>

        {{-- Estadísticas Generales --}}
        @if (!empty($estadisticas))
            @php
                $totalAlumnos = count($estadisticas);
                $promedioGeneral = 0;
                $aprobados = 0;
                $desaprobados = 0;

                if ($totalAlumnos > 0) {
                    $suma = 0;
                    foreach ($estadisticas as $alumno) {
                        if (isset($alumno['promedio']) && $alumno['promedio'] > 0) {
                            $suma += $alumno['promedio'];
                            if ($alumno['promedio'] >= 7) {
                                $aprobados++;
                            } else {
                                $desaprobados++;
                            }
                        }
                    }
                    $promedioGeneral = $totalAlumnos > 0 ? round($suma / $totalAlumnos, 2) : 0;
                }

                $porcentajeAprobacion = $totalAlumnos > 0 ? round(($aprobados / $totalAlumnos) * 100, 1) : 0;
            @endphp

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
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalAlumnos }}</p>
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
                            <p class="text-2xl font-semibold text-gray-900">{{ $promedioGeneral }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Aprobados</p>
                            <p class="text-2xl font-semibold text-green-600">{{ $aprobados }}</p>
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
                            <p class="text-2xl font-semibold text-yellow-600">{{ $porcentajeAprobacion }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de estudiantes y sus notas --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Detalle por Estudiante</h2>
                </div>

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
                                    Promedio
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($estadisticas as $alumno)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-800">
                                                        {{ substr($alumno['nombre'], 0, 1) }}{{ substr($alumno['apellido'], 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                                </div>
                                                <div class="text-sm text-gray-500">DNI: {{ $alumno['dni'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-sm font-medium {{ $alumno['1er_informe'] >= 7 ? 'text-green-600' : ($alumno['1er_informe'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $alumno['1er_informe'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-sm font-medium {{ $alumno['1er_cuatrimestre'] >= 7 ? 'text-green-600' : ($alumno['1er_cuatrimestre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $alumno['1er_cuatrimestre'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-sm font-medium {{ $alumno['2do_informe'] >= 7 ? 'text-green-600' : ($alumno['2do_informe'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $alumno['2do_informe'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-sm font-medium {{ $alumno['2do_cuatrimestre'] >= 7 ? 'text-green-600' : ($alumno['2do_cuatrimestre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $alumno['2do_cuatrimestre'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-sm font-medium {{ $alumno['cierre'] >= 7 ? 'text-green-600' : ($alumno['cierre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $alumno['cierre'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-lg font-semibold {{ $alumno['promedio'] >= 7 ? 'text-green-600' : ($alumno['promedio'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ number_format($alumno['promedio'], 1) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($alumno['promedio'] >= 7)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Aprobado
                                            </span>
                                        @elseif ($alumno['promedio'] >= 4)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                En riesgo
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Desaprobado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista móvil --}}
                <div class="md:hidden">
                    @foreach ($estadisticas as $alumno)
                        <div class="border-b border-gray-200 p-4">
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-green-800">
                                            {{ substr($alumno['nombre'], 0, 1) }}{{ substr($alumno['apellido'], 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $alumno['apellido'] }}, {{ $alumno['nombre'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">DNI: {{ $alumno['dni'] }}</div>
                                </div>
                                <div class="text-right">
                                    <div
                                        class="text-lg font-semibold {{ $alumno['promedio'] >= 7 ? 'text-green-600' : ($alumno['promedio'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($alumno['promedio'], 1) }}
                                    </div>
                                    @if ($alumno['promedio'] >= 7)
                                        <span class="text-xs text-green-600">Aprobado</span>
                                    @elseif ($alumno['promedio'] >= 4)
                                        <span class="text-xs text-yellow-600">En riesgo</span>
                                    @else
                                        <span class="text-xs text-red-600">Desaprobado</span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <div class="text-center">
                                    <div class="text-gray-500">1° Inf.</div>
                                    <div
                                        class="font-medium {{ $alumno['1er_informe'] >= 7 ? 'text-green-600' : ($alumno['1er_informe'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $alumno['1er_informe'] ?? '-' }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">1° Cuatr.</div>
                                    <div
                                        class="font-medium {{ $alumno['1er_cuatrimestre'] >= 7 ? 'text-green-600' : ($alumno['1er_cuatrimestre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $alumno['1er_cuatrimestre'] ?? '-' }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">2° Inf.</div>
                                    <div
                                        class="font-medium {{ $alumno['2do_informe'] >= 7 ? 'text-green-600' : ($alumno['2do_informe'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $alumno['2do_informe'] ?? '-' }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">2° Cuatr.</div>
                                    <div
                                        class="font-medium {{ $alumno['2do_cuatrimestre'] >= 7 ? 'text-green-600' : ($alumno['2do_cuatrimestre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $alumno['2do_cuatrimestre'] ?? '-' }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">Cierre</div>
                                    <div
                                        class="font-medium {{ $alumno['cierre'] >= 7 ? 'text-green-600' : ($alumno['cierre'] >= 4 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $alumno['cierre'] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Gráfico de distribución de notas (opcional) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Distribución de Notas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $aprobados }}</div>
                        <div class="text-sm text-gray-600">Aprobados (≥7)</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-green-600 h-2 rounded-full"
                                style="width: {{ $totalAlumnos > 0 ? ($aprobados / $totalAlumnos) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ $totalAlumnos - $aprobados - $desaprobados }}</div>
                        <div class="text-sm text-gray-600">En riesgo (4-6.9)</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-yellow-600 h-2 rounded-full"
                                style="width: {{ $totalAlumnos > 0 ? (($totalAlumnos - $aprobados - $desaprobados) / $totalAlumnos) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $desaprobados }}</div>
                        <div class="text-sm text-gray-600">Desaprobados (<4)< /div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-red-600 h-2 rounded-full"
                                        style="width: {{ $totalAlumnos > 0 ? ($desaprobados / $totalAlumnos) * 100 : 0 }}%">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-12">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
                        <i class="fas fa-chart-bar text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay datos de notas</h3>
                    <p class="mt-2 text-gray-500">
                        Aún no se han cargado notas para esta materia.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('profesores.notas.cargar', $cupofInfo->cupof) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <i class="fas fa-edit mr-2"></i>
                            Cargar Notas
                        </a>
                    </div>
                </div>
        @endif
    </div>
</x-layouts.profesores.dashboard>
