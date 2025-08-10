<h1 class="text-2xl font-semibold mb-4">Tomar Asistencias</h1>

<p class="mb-6 text-gray-600">Asistencias de hoy materia X 7°C 709</p>

<x-profesores.section-container>
    <div class="py-3.5 px-5 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <input type="text"
            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Buscar Alumno…">
        <x-profesores.dropdown.button id="0" defaultLabel="Seleccionar asistencia">
            <x-profesores.dropdown.menu content="Presente" />
            <x-profesores.dropdown.menu content="Ausente" />
            <x-profesores.dropdown.menu content="Justificado" />
            <x-profesores.dropdown.menu content="Todos" />
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
                Asistencia
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
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="1" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
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
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="2" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
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
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="3" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
                </x-profesores.table.td>
            </x-profesores.table.tr>
        </x-profesores.table.tbody>
    </x-profesores.table>
</x-profesores.section-container>
