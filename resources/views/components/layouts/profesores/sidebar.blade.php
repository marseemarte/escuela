@php

    $sidebarResponsive = [
        'df' => 'w-[60%] h-[91vh] top-[9vh]',
        'sm' => 'sm:w-[40%] sm:h-[90vh] sm:top-[10vh]',
        'md' => 'md:w-[27%] md:h-[90vh] md:top-[10vh]',
        'lg' => 'lg:w-[23%] lg:h-[91vh] lg:top-[9vh]',
        'xl' => 'xl:w-[20%] xl:h-[92vh] xl:top-[8vh]',
        '2xl' => '2xl:w-[16%] 2xl:h-[93vh] 2xl:top-[7vh]',
    ];
    $sidebarResponsive = implode(' ', $sidebarResponsive);

    $sidebarItemsResponsive = [
        'df' => 'h-[11%]',
        'sm' => 'sm:h-[11%]',
        'md' => 'md:h-[11%]',
        'lg' => 'lg:h-[10%]',
        'xl' => 'xl:h-[9%]',
        '2xl' => '2xl:h-[7%]',
    ];
    $sidebarItemsResponsive = implode(' ', $sidebarItemsResponsive);
@endphp
<div class="sidebar bg-[#4d4d61] fixed left-0 z-20 transition-none md:transition-all {{ $sidebarResponsive }} "
    id="sidebar">
    <nav class="sidebar-navbar text-gray-300">
        <ul class="navbar-content flex flex-col w-full h-[93vh]">
            <li class="navbar-item w-full border-l-3 my-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}  {{ $inicio == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="inicio">
                <a href="/profesores" class="flex items-center h-full">
                    <i class="{{ $inicio == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-house"></i>
                    <span class="pl-3 ">Inicio</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}  {{ $notas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="notas">
                <a href="/profesores/notas" class="flex items-center h-full">
                    <i class="{{ $notas == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-clipboard-list"></i>
                    <span class="pl-3">Notas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}   {{ $asistencias == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="asistencias">
                <a href="/profesores/asistencias" class="flex items-center h-full">
                    <i class="{{ $asistencias == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-address-book"></i>
                    <span class="pl-3">Asistencias</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}  {{ $tareas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="tareas">
                <a href="/profesores/tareas" class="flex items-center h-full">
                    <i class="{{ $tareas == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-book"></i>
                    <span class="pl-3">Tareas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}  {{ $alumnos == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="alumnos">
                <a href="/profesores/alumnos" class="flex items-center h-full">
                    <i class="{{ $alumnos == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-user-group"></i>
                    <span class="pl-3">Alumnos</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] {{ $sidebarItemsResponsive }}  {{ $horarios == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="horarios">
                <a href="/profesores/horarios" class="flex items-center h-full">
                    <i class="{{ $horarios == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-user-group"></i>
                    <span class="pl-3">horarios</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
