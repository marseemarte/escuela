<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Menu Jefes de Departamento</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ $inicio == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
            </li>
            <li class="{{ $proyectos == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.proyectos.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-folder"></i></span>
                    <span class="pcoded-mtext">Proyectos</span>
                </a>
            </li>
            <li class="{{ $planificaciones == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.planificaciones.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                    <span class="pcoded-mtext">Planificaciones</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
