<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Menu Profesores</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ $inicio == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
            </li>
            <li class="{{ $notas == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.notas.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                    <span class="pcoded-mtext">Notas</span>
                </a>
            </li>
            <li class="{{ $asistencias == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.asistencias.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                    <span class="pcoded-mtext">Asistencias</span>
                </a>
            </li>
            <li class="{{ $tareas == 'true' ? 'active' : '' }}">
                <a href="{{ route('tareas.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                    <span class="pcoded-mtext">Tareas</span>
                </a>
            </li>
            <li class="{{ $alumnos == 'true' ? 'active' : '' }}">
                <a href="{{ route('alumnos.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Alumnos</span>
                </a>
            </li>
            <li class="{{ $horarios == 'true' ? 'active' : '' }}">
                <a href="{{ route('horarios.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                    <span class="pcoded-mtext">Horarios</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
