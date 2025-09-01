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
        <x-profesores.dropdown.button id="searchAsistenciasDropdown" defaultLabel="Seleccionar" :searchName="'valor'">
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
    <x-profesores.table searchId="tomarAsistencias">
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
            @php
                $index = 1;
                $alumnos = [
                    [
                        'id' => 1,
                        'nombre' => 'Juan',
                        'apellido' => 'Pérez',
                        'valor' => 'justificado',
                    ],
                    [
                        'id' => 2,
                        'nombre' => 'María',
                        'apellido' => 'González',
                        'valor' => 'ausente',
                    ],
                    [
                        'id' => 3,
                        'nombre' => 'Marta',
                        'apellido' => 'Ortega',
                        'valor' => 'presente',
                    ],
                ];
            @endphp
            @foreach ($alumnos as $alumno)
                <x-profesores.table.tr :bottom="$loop->last">
                    <x-profesores.table.td>
                        {{ $index }}
                    </x-profesores.table.td>
                    <x-profesores.table.td>
                        {{ $alumno['nombre'] }}
                    </x-profesores.table.td>
                    <x-profesores.table.td>
                        {{ $alumno['apellido'] }}
                    </x-profesores.table.td>
                    <x-profesores.table.td>
                        <div class="w-full flex justify-center">
                            <x-profesores.dropdown.button id="{{ $alumno['id'] }}"
                                defaultLabel="{{ ucfirst(empty($alumno['valor']) ? 'Presente' : $alumno['valor']) }}"
                                defaultSelectedValue="{{ empty($alumno['valor']) ? 'presente' : $alumno['valor'] }}">
                                @foreach (array_slice($dropdownContent, 0, 3) as $option)
                                    <x-profesores.dropdown.menu content="{{ $option['label'] }}"
                                        id="{{ $option['id'] }}" value="{{ $option['value'] }}" />
                                @endforeach
                            </x-profesores.dropdown.button>
                        </div>
                    </x-profesores.table.td>
                </x-profesores.table.tr>
                @php
                    $index++;
                @endphp
            @endforeach
        </x-profesores.table.tbody>
    </x-profesores.table>
</x-profesores.section-container>
