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
            <li class="{{ $proyectos == 'true' ? 'active' : '' }}">
                <a href="{{ route('profesores.proyectos.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-folder"></i></span>
                    <span class="pcoded-mtext">Proyectos</span>
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
                <a href="{{ route('profesores.horarios.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                    <span class="pcoded-mtext">Horarios</span>
                </a>
            </li>
        </ul>
        @php
            $esJefeDepartamento = \App\Models\Departamento::where(
                'id_tipousuario',
                Auth::user()->tiposUsuario()->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))->first()
                    ?->id,
            )
                ->where('estado', 'A')
                ->exists();
        @endphp

        @if ($esJefeDepartamento)
            <ul class="pcoded-item pcoded-left-item"
                style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <li class="">
                    <a href="{{ route('departamento.index') }}" class="waves-effect waves-dark"
                        style="background: rgba(255,255,255,0.05); border-radius: 4px; margin: 0 10px;">
                        <span class="pcoded-micon"><i class="feather icon-external-link"></i></span>
                        <span class="pcoded-mtext" style="font-weight: 500;">Portal de Departamento</span>
                    </a>
                </li>
            </ul>
        @endif
    </div>
</nav>
