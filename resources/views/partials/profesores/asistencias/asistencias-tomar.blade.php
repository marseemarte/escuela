<h1 class="text-4xl text-gray-900">Asistencias de Hoy Materia X 7°C 709 </h1>


<div class="relative shadow-md bg-white mt-5 w-full rounded-t-md border-t-4 border-gray-50">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
            <tr>
                <th class="px-2 py-1 w-fit">
                    #
                </th>
                <th class="px-6 py-3 ">
                    Nombre
                </th>
                <th class="px-6 py-3 ">
                    Apellido
                </th>
                <th class="px-6 py-3 ">
                    Asistencia
                </th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr class="bg-white border-b border-gray-200">
                <td class="px-2 py-1">
                    1
                </td>
                <td class="px-6 py-4">
                    Aaron
                </td>
                <td class="px-6 py-4">
                    Pro
                </td>
                <td class="px-6 py-4">
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="0" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
                </td>
            </tr>
            <tr class="bg-white border-b border-gray-200">
                <td class="px-2 py-1">
                    2
                </td>
                <td class="px-6 py-4">
                    Lautaro
                </td>
                <td class="px-6 py-4">
                    Potron
                </td>
                <td class="px-6 py-4">
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="1" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
                </td>
            </tr>
            <tr class="bg-white">
                <td class="px-2 py-1">
                    1
                </td>
                <td class="px-6 py-4">
                    Roberto
                </td>
                <td class="px-6 py-4">
                    Casas
                </td>
                <td class="px-6 py-4">
                    <div class="w-full flex justify-center">
                        <x-profesores.dropdown.button id="2" defaultLabel="Presente">
                            <x-profesores.dropdown.menu content="Presente" />
                            <x-profesores.dropdown.menu content="Ausente" />
                            <x-profesores.dropdown.menu content="Justificado" />
                        </x-profesores.dropdown.button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
