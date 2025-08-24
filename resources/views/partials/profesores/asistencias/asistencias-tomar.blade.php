<h1 class="text-2xl font-semibold mb-4">Tomar Asistencias</h1>

<p class="mb-6 text-gray-600">Asistencias de hoy materia X 7°C 709</p>

<x-profesores.section-container>
    <x-profesores.search-bar.container id="tomarAsistencias">
        <x-profesores.input.text style="search" placeholder="Buscar Alumno" :searchName="'fullName'" />

        @php
            $dropdownContent = [
                'Presente' => ['id' => 0, 'label' => 'Presente', 'value' => 'presente'],
                'Ausente' => ['id' => 1, 'label' => 'Ausente', 'value' => 'ausente'],
                'Justificado' => ['id' => 2, 'label' => 'Justificado', 'value' => 'justificado'],
                'Todos' => ['id' => 3, 'label' => 'Todos', 'value' => ''],
            ];
        @endphp
        <x-profesores.dropdown.button id="0" defaultLabel="Seleccionar" :searchName="'valor'">
            @foreach ($dropdownContent as $option)
                <x-profesores.dropdown.menu content="{{ $option['label'] }}" id="{{ $option['id'] }}"
                    value="{{ $option['value'] }}" />
            @endforeach
        </x-profesores.dropdown.button>
        <div class="flex items-center space-x-3">
            <button type="button"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Buscar
            </button>
        </div>
    </x-profesores.search-bar.container>
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
                        <x-profesores.dropdown.button id="1" defaultLabel="Presente"
                            defaultSelectedValue="presente">
                            @foreach (array_slice($dropdownContent, 0, 3) as $option)
                                <x-profesores.dropdown.menu content="{{ $option['label'] }}" id="{{ $option['id'] }}"
                                    value="{{ $option['value'] }}" />
                            @endforeach
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
                        <x-profesores.dropdown.button id="2" defaultLabel="Presente"
                            defaultSelectedValue="presente">
                            @foreach (array_slice($dropdownContent, 0, 3) as $option)
                                <x-profesores.dropdown.menu content="{{ $option['label'] }}" id="{{ $option['id'] }}"
                                    value="{{ $option['value'] }}" />
                            @endforeach
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
                        <x-profesores.dropdown.button id="3" defaultLabel="Presente"
                            defaultSelectedValue="presente">
                            @foreach (array_slice($dropdownContent, 0, 3) as $option)
                                <x-profesores.dropdown.menu content="{{ $option['label'] }}" id="{{ $option['id'] }}"
                                    value="{{ $option['value'] }}" />
                            @endforeach
                        </x-profesores.dropdown.button>
                    </div>

                </x-profesores.table.td>
            </x-profesores.table.tr>
        </x-profesores.table.tbody>
    </x-profesores.table>
</x-profesores.section-container>
