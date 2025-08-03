    <x-layouts.profesores.dashboard notas='true' titulo="Notas">
    <h1>Notas</h1>
    <h2 class="text-center">Informes 2025 de Practicas Profecionalizantes</h2>
    <h2 class="text-center mb-4">7°C</h2>
    <h2 class="text-center mb-4">Ingrese Nota Numerica</h2>
    <h2 class="text-center">Seleccionar Periodo</h2>
    <div class="flex justify-center mb-4">
        <select class="block w-1/3 px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            <option selected>Seleccione un periodo</option>
            <option value="0">Primer Informe</option>
            <option value="1">Primer Cuatrimestre</option>
            <option value="0">Segundo Informe</option>
            <option value="2">Segundo Cuatrimestre</option>
            <option value="0">Cierre</option>
            <option value="0">Diciembre</option>
            <option value="0">Febrero</option>
            <option value="0">Nota Final</option>
        </select>
    </div>
    <div class="flex justify-center mb-4">
        <a href="">
        <input type="button" value="Cambiar Periodo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
        </a>
    </div>
  <div class="relative shadow-md bg-white mt-5 w-full rounded-t-md border-t-4 border-gray-50">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                <tr>
                    <th class="px-6 py-3 ">
                        Nombre
                    </th>
                    <th class="px-6 py-3 ">
                        Apellido
                    </th>
                    <th class="px-6 py-3 ">
                        1° Informe
                    </th>
                      <th class="px-6 py-3 ">
                        1° Cuatrimestre
                    </th>
                      <th class="px-6 py-3 ">
                        2° Informe
                    </th>
                      <th class="px-6 py-3 ">
                        2° Cuatrimestre
                    </th>
                      <th class="px-6 py-3 ">
                        Cierre
                    </th>
                      <th class="px-6 py-3 ">
                        Diciembre
                    </th>
                      <th class="px-6 py-3 ">
                        Febrero
                    </th>
                      <th class="px-6 py-3 ">
                       Nota Final
                    </th>
                </tr>
                 <tbody class="text-center">
                 <tr class="bg-white border-b border-gray-200">
                    <td class="px-6 py-4">
                        Federico
                    </td>
                    <td class="px-6 py-4">
                        Sosa
                    </td>
                    <td class="px-6 py-4">
                        <form class="max-w-sm mx-auto">
                            <input type="number" min="1" max="10" 
                                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        </form>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <p style="color:red;">TED</p>
                    </td>
                </tr>
                                 <tr class="bg-white border-b border-gray-200">
                    <td class="px-6 py-4">
                        Aaron
                    </td>
                    <td class="px-6 py-4">
                        Cascino
                    </td>
                    <td class="px-6 py-4">
                        <form class="max-w-sm mx-auto">
                            <input type="number" min="1" max="10" 
                                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        </form>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <p style="color:green;">TEP</p>
                    </td>
                </tr>
                                 <tr class="bg-white border-b border-gray-200">
                    <td class="px-6 py-4">
                        Lionel
                    </td>
                    <td class="px-6 py-4">
                        Frate
                    </td>
                    <td class="px-6 py-4">
                        <form class="max-w-sm mx-auto">
                            <input type="number" min="1" max="10" 
                                class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        </form>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                    
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <p style="color:blue;">TEA</p>
                    </td>
                </tr>
            </thead>
            </tbody>
            </table>
            </x-layouts.profesores.dashboard>