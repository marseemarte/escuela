<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Menu Jefes de Departamento</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ $inicio == 'true' ? 'active' : '' }}">
                <a href="{{ route('departamento.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Inicio</span>
                </a>
            </li>
            <li class="{{ $proyectos == 'true' ? 'active' : '' }}">
                <a href="{{ route('departamento.proyectos.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-folder"></i></span>
                    <span class="pcoded-mtext">Proyectos</span>
                </a>
            </li>
            <li class="{{ $planificaciones == 'true' ? 'active' : '' }}">
                <a href="{{ route('departamento.planificaciones.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                    <span class="pcoded-mtext">Planificaciones</span>
                </a>
            </li>
            <li class="{{ $profesores == 'true' ? 'active' : '' }}">
                <a href="{{ route('departamento.profesores') }}">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Profesores</span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item"
            style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <li class="">
                <a href="{{ route('profesores.index') }}" class="waves-effect waves-dark"
                    style="background: rgba(255,255,255,0.05); border-radius: 4px; margin: 0 10px;">
                    <span class="pcoded-micon"><i class="feather icon-external-link"></i></span>
                    <span class="pcoded-mtext" style="font-weight: 500;">Portal de Docente</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
