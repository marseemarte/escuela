<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.profesores.head', ['title' => isset($title) ? $title : 'Indefinido'])
</head>

@php
    $inicio = isset($inicio) ? $inicio : 'false';
    $proyectos = isset($proyectos) ? $proyectos : 'false';
    $planificaciones = isset($planificaciones) ? $planificaciones : 'false';
@endphp

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <!-- Header -->
            <x-layouts.profesores.header :titulo="$titulo" />

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- Sidebar -->
                    <x-layouts.profesores.sidebar :inicio="$inicio" :planificaciones="$planificaciones" :planificacion="$planificacion"
                        :proyectos="$proyectos" />

                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <script src="{{ asset('libraries/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/modernizr/js/modernizr.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/i18next/js/i18next.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
    <script
        src="{{ asset('libraries/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}">
    </script>
    <script src="{{ asset('libraries/bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/vartical-layout.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/script.js') }}"></script>

    <!--DataTables js-->
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#myTable', {
                language: {
                    decimal: "",
                    emptyTable: "No hay datos disponibles",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                    lengthMenu: "Mostrar _MENU_ registros",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron resultados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });
        });

        var timezoneOffset = -3 * 60; // Buenos Aires is UTC-3
        var currentDate = new Date();
        var utcDate = new Date(currentDate.getTime() + (currentDate.getTimezoneOffset() * 60000));
        var localDate = new Date(utcDate.getTime() + (timezoneOffset * 60000));
        document.write("<script>var currentTime = '" + localDate.toISOString().slice(0, 19).replace('T', ' ') + "';</" +
            "script>");

        // Asegurar que el pre-loader se oculte después de cargar
        $(document).ready(function() {
            setTimeout(function() {
                $('.theme-loader').fadeOut('slow');
            }, 1000);
        });

        // Si viene de Livewire, ocultar pre-loader inmediatamente
        if (window.history.replaceState && window.location.href.includes('livewire')) {
            $('.theme-loader').hide();
        }

        // Función para pantalla completa
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>

</body>

</html>
