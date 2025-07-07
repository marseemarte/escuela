<x-layouts.profesores.dashboard asistencias='true'>
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
                            <div class="flex relative">
                                <button data-id="0"
                                    class="inline-flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center">
                                    Presente
                                    <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown[0]" data-id="0"
                                    class="dropdown hidden z-10 absolute top-[100%] mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li>
                                            <button id="dropdownOptionPresente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Presente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionAusente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Ausente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionJustificado"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Justificado</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                            <div class="flex relative">
                                <button data-id="1"
                                    class="inline-flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center">
                                    Presente
                                    <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown[1]" data-id="1"
                                    class="dropdown hidden z-10 absolute top-[100%] mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li>
                                            <button id="dropdownOptionPresente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Presente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionAusente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Ausente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionJustificado"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Justificado</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                            <div class="flex relative">
                                <button data-id="2"
                                    class="inline-flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center">
                                    Presente
                                    <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown[2]" data-id="2"
                                    class="dropdown hidden z-10 absolute top-[100%] mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <li>
                                            <button id="dropdownOptionPresente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Presente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionAusente"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Ausente</button>
                                        </li>
                                        <li>
                                            <button id="dropdownOptionJustificado"
                                                class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer">Justificado</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @vite('resources/js/profesores/components/dropdown.js')
</x-layouts.profesores.dashboard>
