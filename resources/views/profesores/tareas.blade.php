<x-layouts.profesores.dashboard titulo="Tareas"> 
   
    <h1 class="text-2xl font-semibold mb-2">Tareas</h1>
    <p class="mb-6 text-gray-600">Gestiona las tareas que compartes con tus cursos. 
        Aquí puedes subir archivos, ver a qué curso se asignaron y hacer el seguimiento de respuestas.</p>

    <!-- Botón para subir nueva tarea -->
    <button class="btn btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg shadow mb-3" id="openModalBtn">
        + Subir nueva tarea
    </button>

    <!-- Modal para subir tareas--> 
    <div id="tareaModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div id="tareaModalContent" 
           class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative transform transition-all duration-300 scale-95 opacity-0">

        <!-- Botón cerrar -->
        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
          ✕
        </button>

        <!-- Pantalla de selección -->
        <div id="modalSeleccion" class="text-center">
          <h2 class="text-xl font-semibold mb-6">¿Qué deseas subir?</h2>
          <div class="flex flex-col gap-3">
            <button id="btnModulo" class="px-4 py-2 rounded bg-indigo-500 text-white hover:bg-indigo-600">
              📘 Módulo de teoría
            </button>
            <button id="btnTarea" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
              📑 Tarea con fecha de entrega
            </button>
          </div>
        </div>

        <!-- Formulario (oculto por defecto) -->
        <div id="modalFormulario" class="hidden">
          <h2 id="formTitulo" class="text-xl font-semibold mb-4"></h2>

          <form method="POST" action="{{ route('tareas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Nombre</label>
              <input type="text" name="nombre"
                     class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                     required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Curso</label>
              <select name="curso"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                      required>
                <option value="" disabled selected>Selecciona un curso</option>
                <option value="2°A">2°A</option>
                <option value="3°B">3°B</option>
              </select>
            </div>

            <!-- Campo fecha (solo para tarea) -->
            <div id="fechaEntrega" class="mb-4 hidden">
              <label class="block text-sm font-medium text-gray-700">Fecha de entrega</label>
              <input type="date" name="fecha_entrega"
                     class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            <!-- Archivo -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Archivo</label>
              <div class="flex border rounded items-center overflow-hidden">
                <label for="archivo"
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 cursor-pointer border-l">
                  Elegir archivo
                </label>
                <span id="archivoNombre" class="flex-1 px-3 py-2 text-gray-600 text-sm">
                  No se ha seleccionado ningún archivo
                </span>
                <input type="file" name="archivo" id="archivo" class="hidden" required>
              </div>
            </div>

          <!-- Boton Cerrar y Subir -->
          <div class="flex justify-end space-x-2">
            <button type="button" id="cancelModalBtn" 
                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
            <button type="submit" 
                    class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Subir</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Tabla de tareas -->
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-3">
        <table class="w-full text-sm text-center text-gray-600 table-fixed">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 w-1/5">Nombre</th>
                    <th class="px-6 py-3 w-1/5">Curso</th>
                    <th class="px-6 py-3 w-1/5">Archivo</th>
                    <th class="px-6 py-3 w-1/5">Fecha de entrega</th>
                    <th class="px-6 py-3 w-1/5">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">Ejercicio de Matematica</td>
                    <td class="px-6 py-4">2°A</td>
                    <td><a href="#" class="text-blue-600 hover:underline">Ver Archivo</a></td>
                    <td class="px-6 py-4">—</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info me-2 text-green-600 hover:underline seguimientoBtn">Seguimiento</button>
                        <button class="btn btn-sm btn-outline-danger text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">Revolucion Francesa</td>
                    <td class="px-6 py-4">3°B</td>
                    <td><a href="#" class="text-blue-600 hover:underline">Ver Archivo</a></td>
                    <td class="px-6 py-4">—</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info me-2 text-green-600 hover:underline seguimientoBtn">Seguimiento</button>
                        <button class="btn btn-sm btn-outline-danger text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal de seguimiento -->
    <div id="seguimientoModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative transform transition-all duration-300 scale-95 opacity-0">

        <button id="closeSeguimientoModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

        <h2 class="text-xl font-semibold mb-4">Seguimiento de la tarea</h2>

        <table class="w-full text-sm text-center text-gray-600 table-fixed mb-4">
          <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
            <tr>
              <th class="px-4 py-2">Alumno</th>
              <th class="px-4 py-2">Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white border-b hover:bg-gray-50">
              <td class="px-4 py-2">Juan Pérez</td>
              <td class="px-4 py-2">Visto</td>
            </tr>
            <tr class="bg-white border-b hover:bg-gray-50">
              <td class="px-4 py-2">María López</td>
              <td class="px-4 py-2">No visto</td>
            </tr>
            <tr class="bg-white border-b hover:bg-gray-50">
              <td class="px-4 py-2">Carlos Gómez</td>
              <td class="px-4 py-2">Visto y respondido</td>
            </tr>
            <tr class="bg-white border-b hover:bg-gray-50">
              <td class="px-4 py-2">Lucía Fernández</td>
              <td class="px-4 py-2">Visto y no respondido</td>
            </tr>
          </tbody>
        </table>

        <div class="flex justify-end mt-4">
          <a href="{{ route('profesores.tareas.corregir') }}" 
            class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Corregir
          </a>
        </div>
      </div>
    </div>

    <!-- Modal visual de eliminacion -->
    <div id="eliminarModal" class="fixed inset-0 z-50 backdrop-blur bg-black/50 hidden items-center justify-center overflow-auto">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 relative transform transition-all duration-300 scale-95 opacity-0">
        <button id="closeEliminarModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
        <h2 class="text-xl font-semibold mb-4">Confirmar eliminación</h2>
        <p class="mb-6 text-gray-700">¿Estás seguro de que quieres eliminar esta tarea?</p>
        <div class="flex justify-end gap-2">
          <button id="cancelEliminar" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
          <button class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Eliminar</button>
        </div>
      </div>
    </div>

    <script>
      // Modal subir tareas
      const openBtn = document.getElementById('openModalBtn');
      const closeBtn = document.getElementById('closeModalBtn');
      const cancelBtn = document.getElementById('cancelModalBtn');
      const modal = document.getElementById('tareaModal');
      const modalContent = document.getElementById('tareaModalContent');
      const btnModulo = document.getElementById("btnModulo");
      const btnTarea = document.getElementById("btnTarea");
      const modalSeleccion = document.getElementById("modalSeleccion");
      const modalFormulario = document.getElementById("modalFormulario");
      const fechaEntrega = document.getElementById("fechaEntrega");
      const archivoInput = document.getElementById('archivo');
      const archivoNombre = document.getElementById('archivoNombre');
      const eliminarBtns = document.querySelectorAll('.btn-outline-danger');
      const eliminarModal = document.getElementById('eliminarModal');
      const closeEliminarModalBtn = document.getElementById('closeEliminarModal');
      const cancelEliminarBtn = document.getElementById('cancelEliminar');

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
          modalContent.classList.remove('scale-95', 'opacity-0');
          modalContent.classList.add('scale-100', 'opacity-100');
        }, 20);
      }

      function closeModal() {
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
          modalSeleccion.classList.remove("hidden");
          modalFormulario.classList.add("hidden");
          fechaEntrega.classList.add("hidden");
          limpiarFormulario();
        }, 300);
      }

      openBtn.addEventListener('click', openModal);
      closeBtn.addEventListener('click', closeModal);
      cancelBtn.addEventListener('click', closeModal);

      function limpiarFormulario() {
        // Limpiar inputs comunes
        document.querySelector('input[name="nombre"]').value = '';
        document.querySelector('input[name="archivo"]').value = '';
        document.getElementById('archivoNombre').textContent = "No se ha seleccionado ningún archivo";

        // Limpiar campos de tarea
        document.querySelector('input[name="fecha_entrega"]').value = '';

        // reiniciar select de curso
        const cursoSelect = document.querySelector('select[name="curso"]');
        if(cursoSelect) {
            cursoSelect.selectedIndex = 0;
        }
     }

      btnModulo.addEventListener("click", () => {
        limpiarFormulario();
        modalSeleccion.classList.add("hidden");
        modalFormulario.classList.remove("hidden");
        fechaEntrega.classList.add("hidden");
        document.getElementById("formTitulo").textContent = "Subir Módulo de Teoría";
      });

      btnTarea.addEventListener("click", () => {
        limpiarFormulario();
        modalSeleccion.classList.add("hidden");
        modalFormulario.classList.remove("hidden");
        fechaEntrega.classList.remove("hidden");
        document.getElementById("formTitulo").textContent = "Subir Tarea con Fecha de Entrega";
      });

      archivoInput.addEventListener('change', () => {
        archivoNombre.textContent = archivoInput.files.length > 0 ? archivoInput.files[0].name : "No se ha seleccionado ningún archivo";
      });

      // Modal seguimiento
      const seguimientoBtns = document.querySelectorAll('.seguimientoBtn');
      const seguimientoModal = document.getElementById('seguimientoModal');
      const closeSeguimientoBtn = document.getElementById('closeSeguimientoModal');
      const btnCorregir = document.getElementById('btnCorregir');

      seguimientoBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          seguimientoModal.classList.remove('hidden');
          seguimientoModal.classList.add('flex');
          setTimeout(() => {
            seguimientoModal.firstElementChild.classList.remove('scale-95','opacity-0');
            seguimientoModal.firstElementChild.classList.add('scale-100','opacity-100');
          }, 20);
        });
      });

      closeSeguimientoBtn.addEventListener('click', () => {
        seguimientoModal.firstElementChild.classList.add('scale-95','opacity-0');
        seguimientoModal.firstElementChild.classList.remove('scale-100','opacity-100');
        setTimeout(() => {
          seguimientoModal.classList.remove('flex');
          seguimientoModal.classList.add('hidden');
        }, 300);
      });

      btnCorregir.addEventListener('click', () => {
        window.location.href = '/profesores/tareas/corregir';
      });

        eliminarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
        eliminarModal.classList.remove('hidden');
        eliminarModal.classList.add('flex');
        setTimeout(() => {
          eliminarModal.firstElementChild.classList.remove('scale-95','opacity-0');
          eliminarModal.firstElementChild.classList.add('scale-100','opacity-100');
        }, 20);
      });
    });

      function cerrarEliminarModal() {
        eliminarModal.firstElementChild.classList.add('scale-95','opacity-0');
        eliminarModal.firstElementChild.classList.remove('scale-100','opacity-100');
        setTimeout(() => {
          eliminarModal.classList.remove('flex');
          eliminarModal.classList.add('hidden');
        }, 300);
      }

      closeEliminarModalBtn.addEventListener('click', cerrarEliminarModal);
      cancelEliminarBtn.addEventListener('click', cerrarEliminarModal);

    </script>

</x-layouts.profesores.dashboard>
