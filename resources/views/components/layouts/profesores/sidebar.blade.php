<div class="sidebar w-[16vw] h-[93vh] bg-[#4d4d61]" id="sidebar">
    <nav class="sidebar-navbar text-gray-300">
        <ul class="navbar-content flex flex-col w-full h-[93vh]">
            <li class="navbar-item w-full border-l-3 my-1 border-[#4d4d61] h-[6%]  {{ $inicio == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="inicio">
                <a href="/profesores" class="flex items-center h-full">
                    <i class="pl-4 fa-solid fa-house"></i>
                    <span class="pl-3 ">Inicio</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] h-[6%] {{ $notas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="notas">
                <a href="/profesores/notas" class="flex items-center h-full">
                    <i class="{{ $notas == 'true' ? 'pl-8' : 'pl-4' }} fa-solid fa-clipboard-list"></i>
                    <span class="pl-3">Notas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] h-[6%]  {{ $asistencias == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="asistencias">
                <a href="/profesores/asistencias" class="flex items-center h-full">
                    <i class="pl-4 fa-solid fa-address-book"></i>
                    <span class="pl-3">Asistencias</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] h-[6%] {{ $tareas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="tareas">
                <a href="/profesores/tareas" class="flex items-center h-full">
                    <i class="pl-4 fa-solid fa-book"></i>
                    <span class="pl-3">Tareas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 mb-1 border-[#4d4d61] h-[6%] {{ $alumnos == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="alumnos">
                <a href="/profesores/alumnos" class="flex items-center h-full">
                    <i class="pl-4 fa-solid fa-user-group"></i>
                    <span class="pl-3">Alumnos</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
