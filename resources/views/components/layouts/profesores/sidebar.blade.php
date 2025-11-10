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
            <li class="{{ $informes == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.informes.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                    <span class="pcoded-mtext">Informes</span>
                </a>
            </li>
            <li class="{{ $asistencias == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.asistencias.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                    <span class="pcoded-mtext">Asistencias</span>
                </a>
            </li>
            <li class="{{ $tareas == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.tareas.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-book"></i></span>
                    <span class="pcoded-mtext">Tareas</span>
                </a>
            </li>
                <li class="{{ $proyecto == 'true' ? 'active' : '' }}">
                    <a href="{{ route('profesores.proyecto.index') }}">
                        <span class="pcoded-micon"><i class="feather icon-folder"></i></span>
                        <span class="pcoded-mtext">Proyecto</span>
                    </a>
                </li>
                <li class="{{ $planificacion == 'true' ? 'active' : '' }}">
                    <a href="{{ route('profesores.planificaciones.index') }}">
                        <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                        <span class="pcoded-mtext">Planificacion</span>
                    </a>
                </li>
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
