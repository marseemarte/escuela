    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <x-layouts.profesores.dashboard notas titulo="Notas">
     <!--  <h1><a class="text-blue-600 select-text " href="{{route('profesores.notas.materias')}}">Materias</a>/Lista</h1> -->
        <h2 class="text-center">Informes 2025 de Practicas Profecionalizantes</h2>
        <h2 class="text-center mb-6">7°C</h2>
        <div class="relative shadow-md bg-white mt-5 w-full rounded-t-md border-t-4 border-gray-50">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                    <tr>
                        <th class="px-4 py-3 ">
                            Nombre
                        </th>
                        <th class="px-4 py-3 ">
                            Apellido
                        </th>
                        <th class="px-4 py-3 ">
                            1° Informe
                        </th>
                        <th class="px-4 py-3 ">
                            1° Cuatrimestre
                        </th>
                        <th class="px-4 py-3 ">
                            2° Informe
                        </th>
                        <th class="px-4 py-3 ">
                            2° Cuatrimestre
                        </th>
                        <th class="px-4 py-3 ">
                            Cierre
                        </th>
                        <th class="px-4 py-3 ">
                            Diciembre
                        </th>
                        <th class="px-4 py-3 ">
                            Febrero
                        </th>
                        <th class="px-4 py-3 ">
                            Nota Final
                        </th>
                        <th class="px-4 py-3 ">
                            Opciones
                        </th>
                    </tr>
                <tbody class="text-center">
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-6 py-3">
                            Federico
                        </td>
                        <td class="px-6 py-3">
                            Sosa
                        </td>
                        <td class="px-6 py-3">
                            
                        </td>
                        <td class="px-6 py-3">
                            
                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">
                            <p style="color:green;">TEP</p>
                        </td>
                        <td class="px-6 py-3">
                           <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Editar</button>
                        </td>
                    </tr>
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-6 py-3">
                            Aaron
                        </td>
                        <td class="px-6 py-3">
                            Cascino
                        </td>
                        <td class="px-6 py-3">
                            
                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">
                            <p style="color:green;">TEP</p>
                        </td>
                        <td class="px-6 py-3">
                           <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Editar</button>
                        </td>
                    </tr>
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-6 py-3">
                            Lionel
                        </td>
                        <td class="px-6 py-3">
                            Frate
                        </td>
                        <td class="px-6 py-3">
                        </td>
                        <td class="px-6 py-3">
                            
                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">

                        </td>
                        <td class="px-6 py-3">
                            <p style="color:blue;">TEA</p>
                        </td>
                        <td class="px-6 py-3">
                           <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Editar</button>
                        </td>
                    </tr>
                    </thead>
                </tbody>
            </table>

            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-s">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">
                    Cambiar Trayectoria
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                

<form class="max-w-md mx-auto">

    <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <h1>Alumno: Sosa Federico</h1>
    </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">

    </div>
    <div class="relative z-0 w-full mb-5 group">

<h1>Notas Actuales</h1>
    </div>
    </div>
    
  <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" name="floating_first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none :border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Primer Informe</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2"  min="1" max="10" disabled />

    </div>

  </div>
  <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " min="1" max="10" required />
        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Primer Cuatrimestre</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
      <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2"  disabled />

    </div>
  </div>
   <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " min="1" max="10" required />
        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Segundo Informe</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
      <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2" disabled />

    </div>
  </div>

   <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " min="1" max="10" required />
        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Segundo Cuatrimestre</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
      <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2" disabled />
    </div>
  </div>

   <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " min="1" max="10" required />
        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Diciembre</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
      <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2" disabled />
    </div>
  </div>

   <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " min="1" max="10" required />
        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Febrero</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
      <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-end text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  value="2" disabled />
    </div>
  </div>
  <p class="text-lg text-gray-900 dark:text-dark text-center">Nota Final:</p>
  

              
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <input type="submit" value="Cargar" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-non rounded-lg border border-gray-200  focus:z-10  bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300">Cancelar</button>
            </div>
             </form>
        </div>
    </div>
</div>
    </x-layouts.profesores.dashboard>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

