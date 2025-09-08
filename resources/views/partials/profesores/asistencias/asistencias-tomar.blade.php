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
        <div class="col-span-1 md:col-span-1 lg:col-span-2 flex items-center justify-center md:justify-start">
            <button type="button"
                class="px-4 py-2 w-full md:w-auto text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Buscar
            </button>
        </div>
        <div
            class="col-span-1 md:col-span-1 lg:col-span-1 flex items-center space-x-2 justify-center md:justify-end md:justify-self-end col-start-1 md:col-start-3 lg:col-start-6 order-last md:order-none mt-2 md:mt-0">
            <x-profesores.circle-button label="P" color="blue" extraClasses="quick-set-btn" data-tipo="p" />
            <x-profesores.circle-button label="A" color="yellow" extraClasses="quick-set-btn" data-tipo="a" />
            <x-profesores.circle-button label="J" color="gray" extraClasses="quick-set-btn" data-tipo="j" />
        </div>
    </x-profesores.search-bar.container>
    <x-profesores.table searchId="tomarAsistencias">
        <x-profesores.table.thead>
            <x-profesores.table.th class="w-1/12 text-xs md:text-sm">#</x-profesores.table.th>
            <x-profesores.table.th class="w-3/12 text-xs md:text-sm">Nombre</x-profesores.table.th>
            <x-profesores.table.th class="w-3/12 text-xs md:text-sm">Apellido</x-profesores.table.th>
            <x-profesores.table.th class="w-5/12 text-xs md:text-sm">Asistencia</x-profesores.table.th>

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
                    <x-profesores.table.td class="w-1/12 md:w-auto">{{ $index }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-3/12 md:w-auto">{{ $alumno['nombre'] }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-3/12 md:w-auto">{{ $alumno['apellido'] }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-5/12 md:w-auto px-2 md:px-4">
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
