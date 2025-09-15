<x-layouts.profesores.dashboard asistencias titulo="Asistencias Totales">
    <div class="p-4 sm:p-6">
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Porcentajes de Asistencia</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">
                        {{ $cupofInfo->materia_nombre }} - {{ $cupofInfo->ano }}° {{ $cupofInfo->division }}
                        "{{ $cupofInfo->grupo_nombre }}" ({{ $cupofInfo->turno }})
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('profesores.asistencias.index') }}"
                        class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Materias
                    </a>
                    <a href="{{ route('profesores.asistencias.tomar', $cupofInfo->cupof) }}"
                        class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Tomar Asistencias
                    </a>
                </div>
            </div>
        </div>

        {{-- Estadísticas Generales --}}
        @if (!empty($estadisticas))
            @php
                $totalAlumnos = count($estadisticas);
                $promedioAsistencia = 0;
                if ($totalAlumnos > 0) {
                    $suma = array_sum(array_column($estadisticas, 'porcentaje_presente'));
                    $promedioAsistencia = round($suma / $totalAlumnos, 1);
                }
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-sm"></i>
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
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-percentage text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Promedio de Asistencia</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $promedioAsistencia }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-day text-indigo-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Días Registrados</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $estadisticas[0]['total_dias'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tabla de Porcentajes --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if (!empty($estadisticas))
                {{-- Vista de tabla para pantallas medianas y grandes --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Apellido y Nombre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Días
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Presentes
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ausencias
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tardanzas
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    % Asistencia
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($estadisticas as $stat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $stat['alumno']->apellido }}, {{ $stat['alumno']->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm text-gray-900">{{ $stat['total_dias'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $stat['presentes'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $stat['ausencias'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $stat['tardanzas'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="flex-1 max-w-20">
                                                @php
                                                    $porcentaje = $stat['porcentaje_presente'];
                                                    $colorClase = 'bg-red-500';
                                                    if ($porcentaje >= 85) {
                                                        $colorClase = 'bg-green-500';
                                                    } elseif ($porcentaje >= 70) {
                                                        $colorClase = 'bg-yellow-500';
                                                    } elseif ($porcentaje >= 50) {
                                                        $colorClase = 'bg-orange-500';
                                                    }
                                                @endphp
                                                <div class="bg-gray-200 rounded-full h-2">
                                                    <div class="{{ $colorClase }} h-2 rounded-full"
                                                        style="width: {{ $porcentaje }}%"></div>
                                                </div>
                                            </div>
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-900">{{ $porcentaje }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista de cards para móviles --}}
                <div class="md:hidden space-y-3 p-4">
                    @foreach ($estadisticas as $stat)
                        @php
                            $porcentaje = $stat['porcentaje_presente'];
                            $colorClase = 'bg-red-500';
                            $colorBorde = 'border-red-200';
                            $colorFondo = 'bg-red-50';
                            if ($porcentaje >= 85) {
                                $colorClase = 'bg-green-500';
                                $colorBorde = 'border-green-200';
                                $colorFondo = 'bg-green-50';
                            } elseif ($porcentaje >= 70) {
                                $colorClase = 'bg-yellow-500';
                                $colorBorde = 'border-yellow-200';
                                $colorFondo = 'bg-yellow-50';
                            } elseif ($porcentaje >= 50) {
                                $colorClase = 'bg-orange-500';
                                $colorBorde = 'border-orange-200';
                                $colorFondo = 'bg-orange-50';
                            }
                        @endphp

                        <div class="border {{ $colorBorde }} rounded-lg p-4 {{ $colorFondo }}">
                            {{-- Nombre del estudiante --}}
                            <div class="mb-3">
                                <h3 class="text-sm font-semibold text-gray-900">
                                    {{ $stat['alumno']->apellido }}, {{ $stat['alumno']->nombre }}
                                </h3>
                            </div>

                            {{-- Porcentaje principal --}}
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-600">Porcentaje de Asistencia</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $porcentaje }}%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="{{ $colorClase }} h-2 rounded-full"
                                        style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>

                            {{-- Estadísticas detalladas --}}
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="text-center">
                                    <div class="text-gray-500">Total Días</div>
                                    <div class="font-semibold text-gray-900">{{ $stat['total_dias'] }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">Presentes</div>
                                    <div class="font-semibold text-green-600">{{ $stat['presentes'] }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">Ausencias</div>
                                    <div class="font-semibold text-red-600">{{ $stat['ausencias'] }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-500">Tardanzas</div>
                                    <div class="font-semibold text-yellow-600">{{ $stat['tardanzas'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-12">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
                        <i class="fas fa-chart-bar text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Sin datos de asistencia</h3>
                    <p class="mt-2 text-gray-500">
                        No hay registros de asistencia para esta materia aún.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('profesores.asistencias.tomar', $cupofInfo->cupof) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Comenzar a Tomar Asistencias
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.profesores.dashboard>
