{{-- resources/views/alumnos/index.blade.php --}}
<x-layouts.profesores.dashboard alumnos="true" titulo="Alumnos">
  <!-- Título de la sección -->
  <h1 class="text-2xl font-semibold mb-4">Alumnos</h1>
  <p class="mb-6 text-gray-600">Busca y filtra tus alumnos por cualquier dato y revisa su asistencia.</p>

  <div class="relative shadow-md sm:rounded-lg bg-white p-6 space-y-6">
    <!-- Filtros de búsqueda -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
      <input
        type="text"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar DNI…"
      >
      <input
        type="text"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar nombre…"
      >
      <input
        type="text"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar apellido…"
      >
      <input
        type="email"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar email…"
      >
      <input
        type="text"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar domicilio…"
      >
      <input
        type="text"
        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Buscar localidad…"
      >
    </div>

    <!-- Botones de acción -->
    <div class="flex items-center space-x-3">
      <button
        type="button"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500"
      >
        Buscar
      </button>
      <button
        type="button"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-400"
      >
        Imprimir
      </button>
    </div>

    <!-- Tabla de alumnos -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600">
        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
          <tr>
            <th class="px-6 py-3">DNI</th>
            <th class="px-6 py-3">Nombre</th>
            <th class="px-6 py-3">Apellido</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Domicilio</th>
            <th class="px-6 py-3">Localidad</th>
            <th class="px-6 py-3 text-center">Asistencia</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-b hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">42461431</td>
            <td class="px-6 py-4">Abril</td>
            <td class="px-6 py-4">Gouchat Covelli</td>
            <td class="px-6 py-4">—</td>
            <td class="px-6 py-4">Calle Falsa 123</td>
            <td class="px-6 py-4">Santa Teresita</td>
            <td class="px-6 py-4 text-center">
              <a href="#" class="text-blue-600 hover:underline">Ver</a>
            </td>
          </tr>
          <tr class="bg-white border-b hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">23710299</td>
            <td class="px-6 py-4">Adriana</td>
            <td class="px-6 py-4">Ladner</td>
            <td class="px-6 py-4">—</td>
            <td class="px-6 py-4">Av. Siempre Viva 742</td>
            <td class="px-6 py-4">Mar de Ajó</td>
            <td class="px-6 py-4 text-center">
              <a href="#" class="text-blue-600 hover:underline">Ver</a>
            </td>
          </tr>
          <tr class="bg-white hover:bg-gray-50">
            <td class="px-6 py-4 font-medium text-gray-900">13270144</td>
            <td class="px-6 py-4">Adriana</td>
            <td class="px-6 py-4">Magán</td>
            <td class="px-6 py-4">—</td>
            <td class="px-6 py-4">Calle Principal 456</td>
            <td class="px-6 py-4">Santa Teresita</td>
            <td class="px-6 py-4 text-center">
              <a href="#" class="text-blue-600 hover:underline">Ver</a>
            </td>
          </tr>
          <!-- Más filas estáticas según necesites -->
        </tbody>
      </table>
    </div>

    <!-- Paginación estática -->
    <nav class="flex items-center justify-between pt-4" aria-label="Navegación de tabla">
      <span class="text-sm text-gray-500">
        Mostrando <span class="font-semibold text-gray-900">1-3</span> de <span class="font-semibold text-gray-900">721</span>
      </span>
      <ul class="inline-flex -space-x-px text-sm h-8">
        <li>
          <a href="#"
             class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-l hover:bg-gray-100 hover:text-gray-700">
            Previous
          </a>
        </li>
        <li><a href="#"
               class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
               1
            </a>
        </li>
        <li><a href="#"
               class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
               2
            </a>
        </li>
        <li><a href="#"
               aria-current="page"
               class="flex items-center justify-center px-3 h-8 text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100">
               3
            </a>
        </li>
        <li><a href="#"
               class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
               4
            </a>
        </li>
        <li><a href="#"
               class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">
               5
            </a>
        </li>
        <li>
          <a href="#"
             class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-r hover:bg-gray-100 hover:text-gray-700">
            Next
          </a>
        </li>
      </ul>
    </nav>
  </div>
</x-layouts.profesores.dashboard>
