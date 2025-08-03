<h1 class="text-4xl text-gray-900">Asistencias de Hoy Materia X 7°C 709 </h1>


<x-profesores.section-container>
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
                        <x-profesores.dropdown.button id="0" defaultLabel="Presente">
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
                        <x-profesores.dropdown.button id="1" defaultLabel="Presente">
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
                        <x-profesores.dropdown.button id="2" defaultLabel="Presente">
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
