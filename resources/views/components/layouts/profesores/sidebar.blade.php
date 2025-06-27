<div class="sidebar w-[16vw] h-[92vh] bg-[#4d4d61]">
    <nav class="sidebar-navbar">
        <ul class="navbar-content flex flex-col w-full h-[92vh]">
            <li class="navbar-item w-full border-l-3 border-[#4d4d61] h-[7%]  {{ $inicio == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="inicio">
                <a href="/profesores" class="flex items-center h-full">
                    <span class="pl-4 ">Inicio</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 border-[#4d4d61] h-[7%] {{ $notas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="notas">
                <a href="/profesores/notas" class="flex items-center h-full">
                    <span class="pl-4">Notas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 border-[#4d4d61] h-[7%]  {{ $asistencias == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="asistencias">
                <a href="/profesores/asistencias" class="flex items-center h-full">
                    <span class="pl-4">Asistencias</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 border-[#4d4d61] h-[7%] {{ $tareas == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="tareas">
                <a href="/profesores/tareas" class="flex items-center h-full">
                    <span class="pl-4">Tareas</span>
                </a>
            </li>
            <li class="navbar-item w-full border-l-3 border-[#4d4d61] h-[7%] {{ $alumnos == 'true' ? 'activo bg-[#626277] border-amber-400' : 'transition hover:bg-[#626277] hover:border-amber-400' }}"
                id="alumnos">
                <a href="/profesores/alumnos" class="flex items-center h-full">
                    <span class="pl-4">Alumnos</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
