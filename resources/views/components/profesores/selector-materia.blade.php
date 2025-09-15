@props([
    'materias' => [],
    'titulo' => 'Seleccionar Materia',
    'descripcion' => 'Seleccione una materia para continuar',
    'contenedorId' => 'materias-selector',
    'onSelectCallback' => null,
])

<div class="bg-white shadow rounded-lg p-6" id="{{ $contenedorId }}">
    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ $titulo }}</h2>

    @if ($descripcion)
        <p class="text-sm text-gray-600 mb-4">{{ $descripcion }}</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="{{ $contenedorId }}-botones">
        @forelse ($materias as $materia)
            <button type="button"
                class="materia-btn p-4 text-left border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                data-cupof="{{ $materia->cupof }}" data-nombre="{{ $materia->materia_nombre }}"
                data-curso="{{ $materia->ano }}°{{ $materia->division }}" data-grupo="{{ $materia->grupo_nombre }}"
                data-turno="{{ $materia->turno }}" data-container="{{ $contenedorId }}">

                <div class="font-semibold text-gray-900 mb-1">{{ $materia->materia_nombre }}</div>
                <div class="text-sm text-gray-600">
                    {{ $materia->ano }}°{{ $materia->division }} - Grupo {{ $materia->grupo_nombre }}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Turno: {{ $materia->turno === 'M' ? 'Mañana' : ($materia->turno === 'T' ? 'Tarde' : 'Noche') }}
                </div>
            </button>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">No se encontraron materias asignadas.</p>
                <p class="text-sm text-gray-400 mt-2">Contacte al administrador si esto es un error.</p>
            </div>
        @endforelse
    </div>

    <!-- Información de materia seleccionada -->
    <div id="{{ $contenedorId }}-info" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6 hidden">
        <h3 class="text-md font-medium text-blue-900 mb-2">Materia Seleccionada</h3>
        <p class="text-blue-700 font-semibold" id="{{ $contenedorId }}-detalle"></p>
        <p class="text-sm text-blue-600 mt-1">Fecha: {{ date('d/m/Y') }}</p>
        <div class="mt-3">
            <div class="flex items-center text-sm text-blue-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                Materia seleccionada correctamente
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const contenedorId = '{{ $contenedorId }}';
        const materiaBtns = document.querySelectorAll(`#${contenedorId} .materia-btn`);
        const infoDiv = document.getElementById(`${contenedorId}-info`);
        const detalleSpan = document.getElementById(`${contenedorId}-detalle`);

        materiaBtns.forEach((btn) => {
            btn.addEventListener("click", function() {
                const cupof = this.dataset.cupof;
                const nombre = this.dataset.nombre;
                const curso = this.dataset.curso;
                const grupo = this.dataset.grupo;
                const turno = this.dataset.turno;

                // Remover selección anterior
                materiaBtns.forEach((b) => {
                    b.classList.remove(
                        "border-blue-500",
                        "bg-blue-50",
                        "ring-2",
                        "ring-blue-500"
                    );
                    b.classList.add("border-gray-200");
                });

                // Marcar como seleccionado
                this.classList.remove("border-gray-200");
                this.classList.add(
                    "border-blue-500",
                    "bg-blue-50",
                    "ring-2",
                    "ring-blue-500"
                );

                // Mostrar información
                const turnoTexto = turno === "M" ? "Mañana" : turno === "T" ? "Tarde" : "Noche";
                detalleSpan.textContent =
                    `${nombre} - ${curso} - Grupo ${grupo} (Turno ${turnoTexto})`;
                infoDiv.classList.remove("hidden");

                // Emitir evento personalizado para que otros módulos puedan escuchar
                window.dispatchEvent(new CustomEvent('materiaSeleccionada', {
                    detail: {
                        cupof: cupof,
                        nombre: nombre,
                        curso: curso,
                        grupo: grupo,
                        turno: turno,
                        container: contenedorId
                    }
                }));

                @if ($onSelectCallback)
                    // Ejecutar callback personalizado si se proporciona
                    {{ $onSelectCallback }}(cupof, nombre, curso, grupo, turno);
                @endif
            });
        });
    });
</script>
