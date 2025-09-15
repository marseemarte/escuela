<x-layouts.profesores.dashboard notas titulo="Notas">

    <form action="{{ route('profesores.notas.materias.lista') }}" method="get">
        <h1>Materias</h1>
        @php
            foreach ($materias as $materia) {
                echo '<input type="submit" value="' . $materia->nombre . '" name="materia"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer mt-4">
                
                <br>';
           
            };
        @endphp
      

    </form>
</x-layouts.profesores.dashboard>
