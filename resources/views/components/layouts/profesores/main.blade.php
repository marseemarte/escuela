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
                        <li class="pcoded-hasmenu pcoded-trigger" id="inicio">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Inicio</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu" id="notas">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Notas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu" id="asistencias">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Asistencias</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu" id="tareas">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Tareas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu" id="alumnos">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Alumnos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        {{ $slot }}

    </div>



    <script>
        const inicio = document.getElementById('inicio');
        const notas = document.getElementById("notas");
        const asistencias = document.getElementById("asistencias");
        const alumnos = document.getElementById("alumnos");
        const tareas = document.getElementById("tareas");
        const navItems = [inicio, notas, asistencias, alumnos, tareas];
        navItems.forEach(element => {
            element.addEventListener('click', function() {
                // Remove 'active' class from all nav items
                navItems.forEach(item => {
                    item.classList.remove('active');
                    document.getElementById(item.id + 'Content').style.display = 'none';
                });
                // Add 'active' class to the clicked nav item
                document.getElementById(this.id + 'Content').style.display = 'block';
                this.classList.add('active');
            });

        });
    </script>

</body>

</html>
