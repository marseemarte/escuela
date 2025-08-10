<h1 class="text-4xl text-gray-900"> </h1>
<h1 class="text-2xl font-semibold mb-4">Ver Asistencias</h1>

<p class="mb-6 text-gray-600">Asistencias Totales de la Materia X 7°C 709</p>

<x-profesores.section-container>
    <div class="py-3.5 px-5 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">

        <x-profesores.input.text style="search" placeholder="Buscar Alumno" />

        <x-profesores.dropdown.button id="0" defaultLabel="Seleccionar">
            <x-profesores.dropdown.menu content="70% o mas" />
            <x-profesores.dropdown.menu content="Menos de 70%" />
        </x-profesores.dropdown.button>

        <div class="flex items-center space-x-3">
            <button type="button"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Buscar
            </button>
        </div>
    </div>
    <x-profesores.table>
        <x-profesores.table.thead>

            <x-profesores.table.th>
                #
            </x-profesores.table.th>
            <x-profesores.table.th>
                Nombre
            </x-profesores.table.th>
            <x-profesores.table.th>
                Apellido
            </x-profesores.table.th>
            <x-profesores.table.th>
                Asistencias
            </x-profesores.table.th>

        </x-profesores.table.thead>

        <x-profesores.table.tbody>
            <x-profesores.table.tr>

                <x-profesores.table.td>
                    1
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Aaron
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Pro
                </x-profesores.table.td>
                <x-profesores.table.td>
                    70%
                </x-profesores.table.td>

            </x-profesores.table.tr>

            <x-profesores.table.tr>

                <x-profesores.table.td>
                    2
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Lautaro
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Potron
                </x-profesores.table.td>
                <x-profesores.table.td>
                    40%
                </x-profesores.table.td>

            </x-profesores.table.tr>
            <x-profesores.table.tr bottom>
                <x-profesores.table.td>
                    3
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Roberto
                </x-profesores.table.td>
                <x-profesores.table.td>
                    Casas
                </x-profesores.table.td>
                <x-profesores.table.td>
                    95%
                </x-profesores.table.td>
            </x-profesores.table.tr>
        </x-profesores.table.tbody>
    </x-profesores.table>
</x-profesores.section-container>
