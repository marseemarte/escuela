<x-layouts.profesores.dashboard notas titulo="Notas">

    <form action="{{ route('profesores.notas.materias') }}" method="post">
        @csrf
        <h2 class="mt-4"> Ciclo Basico</h2>

        <input type="submit" value="1°G" name="curso"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer mt-4">

        <h2 class="mt-4">Ciclo Superior</h2>

        <input type="submit" value="7°C" name="curso"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer mt-4">
    </form>
</x-layouts.profesores.dashboard>
