<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mi Técnica | Panel Profesores</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Escuela Técnica - Panel de Profesores" />
    <meta name="keywords" content="escuela, técnica, profesores, educación" />
    <meta name="author" content="Escuela Técnica" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('libraries/bower_components/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Feather Icons -->
    <link rel="stylesheet" href="{{ asset('libraries/assets/icon/feather/css/feather.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libraries/bower_components/font-awesome/css/font-awesome.min.css') }}">
    
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('libraries/bower_components/animate.css/animate.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('libraries/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('libraries/assets/css/component.css') }}">
    
    <!-- PCoded CSS -->
    <link rel="stylesheet" href="{{ asset('libraries/assets/css/pcoded-horizontal.min.css') }}">
</head>

@php
    $inicio = isset($inicio) ? $inicio : 'false';
    $asistencias = isset($asistencias) ? $asistencias : 'false';
    $tareas = isset($tareas) ? $tareas : 'false';
    $alumnos = isset($alumnos) ? $alumnos : 'false';
    $notas = isset($notas) ? $notas : 'false';
    $horarios = isset($horarios) ? $horarios : 'false';
    $titulo = isset($titulo) ? $titulo : 'Dashboard';
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

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu icon-toggle-right"></i>
                        </a>
                        <a href="{{ route('profesores.index') }}">
                            <img class="img-fluid" src="{{ asset('libraries/assets/images/log_nomb.png') }}" alt="Logo">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-bell"></i>
                                        <span class="badge bg-c-pink">5</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">John Doe</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="{{ asset('libraries/assets/images/avatar-3.jpg') }}" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">Joseph William</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">Sara Soudein</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-message-square"></i>
                                        <span class="badge bg-c-green">3</span>
                                    </div>
                                </div>
                            </li>
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" class="img-radius" alt="User-Profile-Image">
                                        <span>{{ Auth::check() ? Auth::user()->nombre_completo : 'Usuario' }}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{ route('settings.profile') }}">
                                                <i class="feather icon-settings"></i> Configuración
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('settings.profile') }}">
                                                <i class="feather icon-user"></i> Perfil
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; width: 100%; text-align: left; padding: 0;">
                                                    <i class="feather icon-log-out"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Sidebar chat start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="card card_main p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-inner-header">
                                <div class="back_chatBox">
                                    <div class="right-icon-control">
                                        <input type="text" class="form-control search-text" placeholder="Search Friend" id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius" src="{{ asset('libraries/assets/images/avatar-3.jpg') }}" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="{{ asset('libraries/assets/images/avatar-2.jpg') }}" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="{{ asset('libraries/assets/images/avatar-3.jpg') }}" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="{{ asset('libraries/assets/images/avatar-2.jpg') }}" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat start-->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                        <i class="feather icon-chevron-left"></i> Josephin Doe
                    </a>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src="{{ asset('libraries/assets/images/avatar-3.jpg') }}" alt="Generic placeholder image">
                    </a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media-right photo-table">
                        <a href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                </div>
                <div class="chat-reply-box p-b-20">
                    <div class="right-icon-control">
                        <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                        <div class="form-icon">
                            <i class="feather icon-navigation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Menu</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{{ $inicio == 'true' ? 'active' : '' }}">
                                    <a href="{{ route('profesores.index') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Inicio</span>
                                    </a>
                                </li>
                                <li class="{{ $notas == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/notas">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Notas</span>
                                    </a>
                                </li>
                                <li class="{{ $asistencias == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/asistencias">
                                        <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                                        <span class="pcoded-mtext">Asistencias</span>
                                    </a>
                                </li>
                                <li class="{{ $tareas == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/tareas">
                                        <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                                        <span class="pcoded-mtext">Tareas</span>
                                    </a>
                                </li>
                                <li class="{{ $alumnos == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/alumnos">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Alumnos</span>
                                    </a>
                                </li>
                                <li class="{{ $horarios == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/horarios">
                                        <span class="pcoded-micon"><i class="feather icon-clock"></i></span>
                                        <span class="pcoded-mtext">Horarios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page header start -->
                                    <div class="page-header">
                                        <div class="page-header-title">
                                            <h4>{{ $titulo }}</h4>
                                            <span>Panel de Profesores - {{ $titulo }}</span>
                                        </div>
                                        <div class="page-header-breadcrumb">
                                            <ul class="breadcrumb-title">
                                                <li class="breadcrumb-item">
                                                    <a href="{{ route('profesores.index') }}">
                                                        <i class="feather icon-home"></i>
                                                    </a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    <a href="#!">{{ $titulo }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Page header end -->
                                    
                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {{ $slot }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->
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
    <script src="{{ asset('libraries/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/vartical-layout.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('libraries/assets/js/script.js') }}"></script>

    <!--DataTables js-->
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof DataTable !== 'undefined' && document.getElementById('myTable')) {
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
            }
        });

        // Función de pantalla completa
        function toggleFullScreen() {
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        }

        // Tiempo actual
        var timezoneOffset = -3 * 60; // Buenos Aires is UTC-3
        var currentDate = new Date();
        var utcDate = new Date(currentDate.getTime() + (currentDate.getTimezoneOffset() * 60000));
        var localDate = new Date(utcDate.getTime() + (timezoneOffset * 60000));
        document.write("<script>var currentTime = '" + localDate.toISOString().slice(0, 19).replace('T', ' ') + "';</" + "script>");

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
    </script>

</body>

</html>