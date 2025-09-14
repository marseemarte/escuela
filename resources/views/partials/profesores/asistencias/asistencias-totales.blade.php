<h1 class="text-4xl text-gray-900"> </h1>
<h1 class="text-2xl font-semibold mb-4">Ver Asistencias</h1>

<p class="mb-6 text-gray-600">Asistencias Totales de la Materia X 7°C 709</p>

<x-profesores.section-container>
    <x-profesores.search-bar.container id="totalAsistencias">

        <x-profesores.input.text style="search" placeholder="Buscar Alumno" :searchName="'fullName'" />

        <div class="col-span-1 md:col-span-1 lg:col-span-3 flex items-center justify-center md:justify-start">
            <button type="button"
                class="px-4 py-2 w-full md:w-auto text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Buscar
            </button>
        </div>
    </x-profesores.search-bar.container>
    <x-profesores.table searchId="totalAsistencias">
        <x-profesores.table.thead>
            <x-profesores.table.th class="w-1/10 text-xs md:text-sm">#</x-profesores.table.th>
            <x-profesores.table.th class="w-3/10 text-xs md:text-sm">Nombre</x-profesores.table.th>
            <x-profesores.table.th class="w-3/10 text-xs md:text-sm">Apellido</x-profesores.table.th>
            <x-profesores.table.th class="w-3/10 text-xs md:text-sm">Asistencias</x-profesores.table.th>
        </x-profesores.table.thead>

        <x-profesores.table.tbody>
            @php
                $index = 1;
                $alumnos = [
                    [
                        'id' => 1,
                        'nombre' => 'Aaron',
                        'apellido' => 'Pro',
                        'asistencias' => '70%',
                        'valor' => 'aprobado',
                    ],
                    [
                        'id' => 2,
                        'nombre' => 'Lautaro',
                        'apellido' => 'Potron',
                        'asistencias' => '40%',
                        'valor' => 'desaprobado',
                    ],
                    [
                        'id' => 3,
                        'nombre' => 'Roberto',
                        'apellido' => 'Casas',
                        'asistencias' => '95%',
                        'valor' => 'aprobado',
                    ],
                ];
            @endphp
            @foreach ($alumnos as $alumno)
                <x-profesores.table.tr :bottom="$loop->last">
                    <x-profesores.table.td class="w-1/10 md:w-auto">{{ $index }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-3/10 md:w-auto">{{ $alumno['nombre'] }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-3/10 md:w-auto">{{ $alumno['apellido'] }}</x-profesores.table.td>
                    <x-profesores.table.td class="w-3/10 md:w-auto">
                        <span
                            class="font-semibold {{ $alumno['asistencias'] >= '70%' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $alumno['asistencias'] }}
                        </span>
                    </x-profesores.table.td>
                </x-profesores.table.tr>
                @php
                    $index++;
                @endphp
            @endforeach
        </x-profesores.table.tbody>
    </x-profesores.table>
</x-profesores.section-container>
