<x-layouts.profesores.dashboard asistencias='true'>
    <div id="tab[0]">
        @include('partials.profesores.asistencias.asistencias-tomar')
    </div>
    <div id="tab[1]" class="hidden">
        @include('partials.profesores.asistencias.asistencias-totales')
    </div>
    @vite('resources/js/profesores/components/dropdown.js')
    @vite('resources/js/profesores/asistencias.js')
</x-layouts.profesores.dashboard>
