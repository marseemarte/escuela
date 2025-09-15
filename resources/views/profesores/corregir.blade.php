<x-layouts.profesores.dashboard titulo="Corregir Tarea">

    <h1 class="text-2xl font-semibold mb-4">Corrección de Tarea</h1>
    <p class="mb-6 text-gray-600">Aquí podrás revisar y corregir las respuestas de los alumnos.</p>

    <!-- Tabla de alumnos -->
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-600 table-fixed">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 w-1/5">Alumno</th>
                    <th class="px-6 py-3 w-2/5">Respuesta</th>
                    <th class="px-6 py-3 w-1/5">Nota</th>
                    <th class="px-6 py-3 w-1/5">Devolucion</th>
                    <th class="px-6 py-3 w-1/5">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">Juan Pérez</td>
                    <td><a href="#" class="text-blue-600 hover:underline">Ver Archivo</a></td>

                    <td class="px-6 py-4">
                        <input type="number" min="1" max="10" class="nota w-16 border rounded px-2 py-1 text-center">
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <textarea rows="2" maxlength="200" oninput="this.nextElementSibling.textContent = this.value.length + '/200'" 
                            class="w-full border rounded px-2 py-1 resize-none" placeholder="Máximo 200 caracteres..."></textarea>
                            <small class="text-gray-500 text-right">0/200</small>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            Guardar
                        </button>
                    </td>
                </tr>

                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">María López</td>
                    <td><a href="#" class="text-blue-600 hover:underline">Ver Archivo</a></td>
                    
                    <td class="px-6 py-4">
                        <input type="number" min="1" max="10" class="nota w-16 border rounded px-2 py-1 text-center">
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <textarea rows="2" maxlength="200" oninput="this.nextElementSibling.textContent = this.value.length + '/200'" 
                            class="w-full border rounded px-2 py-1" placeholder="Máximo 200 caracteres..."></textarea>
                            <small class="text-gray-500 text-right">0/200</small>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            Guardar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const notas = document.querySelectorAll(".nota");

        notas.forEach(input => {
            input.addEventListener("input", function () {
                if (this.value !== "") {
                    if (this.value < 1) this.value = 1;
                    if (this.value > 10) this.value = 10;
                    }
                });
            });
        });

    </script>

</x-layouts.profesores.dashboard>
