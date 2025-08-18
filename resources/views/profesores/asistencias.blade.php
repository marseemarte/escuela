<x-layouts.profesores.dashboard asistencias>

    <x-profesores.tab id="0" mainTab>

        @include('partials.profesores.asistencias.asistencias-tomar')

    </x-profesores.tab>

    <x-profesores.tab id="1">

        @include('partials.profesores.asistencias.asistencias-totales')

    </x-profesores.tab>

    @vite('resources/js/profesores/components/dropdown.js')
    @vite('resources/js/profesores/utils/search.js')
    @vite('resources/js/profesores/asistencias.js')
</x-layouts.profesores.dashboard>
