<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.profesores.head')
</head>

<body>
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <nav class="pcoded-navbar">
                <div class="pcoded-inner-navbar main-menu">
                    <div class="pcoded-navigatio-lavel">Navigation</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu {{ $inicio == 'true' ? 'pcoded-trigger' : '' }}" id="inicio">
                            <a href="/profesores">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Inicio</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu {{ $notas == 'true' ? 'pcoded-trigger' : '' }}" id="notas">
                            <a href="/profesores/notas">
                                <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                                <span class="pcoded-mtext">Notas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu {{ $asistencias == 'true' ? 'pcoded-trigger' : '' }}"
                            id="asistencias">
                            <a href="/profesores/asistencias">
                                <span class="pcoded-micon"><i class="feather icon-check"></i></span>
                                <span class="pcoded-mtext">Asistencias</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu {{ $tareas == 'true' ? 'pcoded-trigger' : '' }}" id="tareas">
                            <a href="/profesores/tareas">
                                <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                                <span class="pcoded-mtext">Tareas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu {{ $alumnos == 'true' ? 'pcoded-trigger' : '' }}" id="alumnos">
                            <a href="/profesores/alumnos">
                                <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                <span class="pcoded-mtext">Alumnos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        {{ $slot }}

    </div>
</body>

</html>
