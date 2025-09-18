{{-- Vista principal de notas - Lista de materias --}}
<x-layouts.profesores.dashboard notas titulo="Notas">
    <div class="bg-white rounded-lg shadow-sm p-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Notas</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Seleccione una materia para gestionar notas</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Lista de materias --}}
        @if ($materias && count($materias) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach ($materias as $materia)
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-lg border border-gray-200 hover:border-green-300 transition-all duration-200 hover:shadow-md">
                        <div class="p-4 sm:p-6">
                            {{-- Cabecera de la materia --}}
                            <div
                                class="flex flex-col sm:flex-row sm:items-start justify-between mb-3 sm:mb-4 space-y-2 sm:space-y-0">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-base sm:text-lg text-gray-900 mb-1">
                                        {{ $materia->materia_nombre }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        {{ $materia->ano }}° {{ $materia->division }} - {{ $materia->grupo_nombre }}
                                    </p>
                                </div>
                            </div>

                            {{-- Información adicional --}}
                            <div class="space-y-1 sm:space-y-2 mb-3 sm:mb-4">
                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                    <i class="fas fa-clock w-3 h-3 sm:w-4 sm:h-4 mr-2"></i>
                                    <span>Turno:
                                        {{ ucfirst($materia->turno === 'M' ? 'Mañana' : ($materia->turno === 'T' ? 'Tarde' : 'Noche')) }}</span>
                                </div>
                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                    <i class="fas fa-users w-3 h-3 sm:w-4 sm:h-4 mr-2"></i>
                                    <span>Curso: {{ $materia->ano }}° Año División {{ $materia->division }}</span>
                                </div>
                            </div>

                            {{-- Botón de acción --}}
                            <div class="pt-3 sm:pt-4 border-t border-gray-200">
                                {{-- Debug URLs generadas --}}
                                <div class="mb-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
                                    <strong>🔍 URLs Debug:</strong><br>
                                    Test: {{ route('test.notas.cargar', $materia->cupof) }}<br>
                                    Original: {{ route('profesores.notas.cargar', $materia->cupof) }}<br>
                                    Debug Info: <a href="{{ route('debug.cupof', $materia->cupof) }}" target="_blank"
                                        class="text-blue-600 underline">CUPOF Info</a><br>
                                    Debug Alumnos: <a href="{{ route('debug.alumnos', $materia->cupof) }}"
                                        target="_blank" class="text-purple-600 underline">Alumnos Test</a><br>
                                    CUPOF: {{ $materia->cupof }}
                                </div>

                                {{-- Botón temporal de prueba --}}
                                <a href="{{ route('test.notas.cargar', $materia->cupof) }}"
                                    onclick="console.log('🔵 Click en botón TEST'); console.log('URL:', this.href); console.log('CUPOF:', '{{ $materia->cupof }}'); return true;"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm mb-2">
                                    <i class="fas fa-bug mr-2"></i>
                                    TEST - Gestionar Notas (Sin Middleware)
                                </a>

                                {{-- Botón original --}}
                                <a href="{{ route('profesores.notas.cargar', $materia->cupof) }}"
                                    onclick="console.log('🟢 Click en botón ORIGINAL'); console.log('URL:', this.href); console.log('CUPOF:', '{{ $materia->cupof }}'); return true;"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-clipboard-list mr-2"></i>
                                    Gestionar Notas (Original)
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Estado vacío --}}
            <div class="text-center py-12">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
                    <i class="fas fa-graduation-cap text-gray-400 text-xl"></i>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No hay materias asignadas</h3>
                <p class="mt-2 text-gray-500">
                    No tiene materias asignadas en este momento para gestionar notas.
                </p>
            </div>
        @endif
    </div>
</x-layouts.profesores.dashboard>
