<div class="sidebar w-[16vw] h-[92vh] bg-[#4d4d61]">
    <nav class="sidebar-navbar">
        <ul class="">
            <li class="pcoded-hasmenu {{ $inicio == 'true' ? 'activo' : '' }}" id="inicio">
                <a href="/profesores">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
            </li>
            <li class="pcoded-hasmenu {{ $notas == 'true' ? 'activo' : '' }}" id="notas">
                <a href="/profesores/notas">
                    <span class="pcoded-micon"><i class="feather icon-check"></i></span>
                    <span class="pcoded-mtext">Notas</span>
                </a>
            </li>
            <li class="pcoded-hasmenu  {{ $asistencias == 'true' ? 'activo' : '' }}" id="asistencias">
                <a href="/profesores/asistencias">
                    <span class="pcoded-micon"><i class="feather icon-check"></i></span>
                    <span class="pcoded-mtext">Asistencias</span>
                </a>
            </li>
            <li class="pcoded-hasmenu {{ $tareas == 'true' ? 'activo' : '' }}" id="tareas">
                <a href="/profesores/tareas">
                    <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                    <span class="pcoded-mtext">Tareas</span>
                </a>
            </li>
            <li class="pcoded-hasmenu {{ $alumnos == 'true' ? 'activo' : '' }}" id="alumnos">
                <a href="/profesores/alumnos">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Alumnos</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
