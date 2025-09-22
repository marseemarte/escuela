<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mi Técnica | Panel Profesores</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Feather Icons -->
    <link rel="stylesheet" href="{{ asset('libraries/assets/icon/feather/css/feather.css') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Pre-loader styles matching PCoded original */
        .theme-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .ball-scale .contain {
            position: relative;
            width: 54px;
            height: 54px;
        }
        
        .ball-scale .ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 3px solid #007bff;
            opacity: 0;
            animation: ball-scale 1s ease-in-out infinite;
        }
        
        .ball-scale .ring .frame {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }
        
        @keyframes ball-scale {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
        
        .ball-scale .ring:nth-child(1) { animation-delay: 0s; }
        .ball-scale .ring:nth-child(2) { animation-delay: 0.1s; }
        .ball-scale .ring:nth-child(3) { animation-delay: 0.2s; }
        .ball-scale .ring:nth-child(4) { animation-delay: 0.3s; }
        .ball-scale .ring:nth-child(5) { animation-delay: 0.4s; }

        /* PCoded Layout Structure */
        .pcoded {
            background: #d5dae6;
            min-height: 100vh;
        }
        
        .pcoded-overlay-box {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1028;
            display: none;
        }
        
        .pcoded.iscollapsed .pcoded-navbar {
            margin-left: -250px;
        }
        
        .pcoded.iscollapsed .pcoded-overlay-box {
            display: block;
        }
        
        /* Header Navbar */
        .header-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #fff;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .navbar-wrapper {
            display: flex;
            align-items: center;
            height: 100%;
        }
        
        .navbar-logo {
            width: 250px;
            height: 56px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            background: #fff;
            border-right: 1px solid #e9ecef;
        }
        
        .navbar-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            height: 100%;
        }
        
        /* Navigation Lists */
        .nav-left, .nav-right {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 10px;
        }
        
        /* Search */
        .main-search .input-group {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .main-search .form-control {
            border: none;
            background: transparent;
            outline: none;
            padding: 8px 12px;
            width: 200px;
            font-size: 14px;
        }
        
        .main-search .input-group-addon {
            padding: 8px 10px;
            cursor: pointer;
            color: #6c757d;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
        }
        
        /* Dropdown notifications */
        .header-notification {
            position: relative;
        }
        
        .dropdown-toggle {
            padding: 8px 10px;
            cursor: pointer;
            color: #6c757d;
            background: transparent;
            border: none;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: white;
        }
        
        .bg-c-pink {
            background-color: #f73164 !important;
        }
        
        .bg-c-green {
            background-color: #00d97e !important;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 300px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1050;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .dropdown-menu.hidden {
            display: none;
        }
        
        /* User Profile */
        .user-profile .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px;
        }
        
        .img-radius {
            border-radius: 50%;
        }
        
        /* Sidebar Navigation */
        .pcoded-navbar {
            position: fixed;
            left: 0;
            top: 56px;
            width: 250px;
            height: calc(100vh - 56px);
            background: #fff;
            border-right: 1px solid #e9ecef;
            z-index: 1024;
            transition: margin-left 0.3s ease;
            overflow-y: auto;
        }
        
        .pcoded-inner-navbar {
            height: 100%;
        }
        
        .pcoded-navigatio-lavel {
            background: #f4f4f4;
            color: #666;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 10px 25px;
            margin: 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .pcoded-item {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pcoded-item li {
            position: relative;
        }
        
        .pcoded-item li a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #555;
            text-decoration: none;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .pcoded-item li a:hover {
            background: #f8f9fa;
            color: #495057;
        }
        
        .pcoded-item li.active a {
            background: #e3f2fd;
            color: #1976d2;
            border-right: 3px solid #1976d2;
        }
        
        .pcoded-micon {
            width: 20px;
            text-align: center;
            margin-right: 15px;
            font-size: 16px;
        }
        
        .pcoded-mtext {
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Main Container */
        .pcoded-main-container {
            margin-left: 250px;
            margin-top: 56px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 56px);
        }
        
        .pcoded.iscollapsed .pcoded-main-container {
            margin-left: 0;
        }
        
        .pcoded-content {
            background: #f8f9fa;
            min-height: calc(100vh - 56px);
        }
        
        .pcoded-inner-content {
            padding: 20px;
        }
        
        .main-body {
            background: #f8f9fa;
        }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .pcoded-navbar {
                margin-left: -250px;
            }
            
            .pcoded-main-container {
                margin-left: 0;
            }
            
            .navbar-logo {
                width: auto;
            }
            
            .navbar-container {
                margin-left: 0;
            }
            
            .pcoded.iscollapsed .pcoded-navbar {
                margin-left: 0;
            }
        }
        
        /* Hide elements for mobile */
        @media (max-width: 768px) {
            .mobile-menu {
                display: block !important;
            }
            
            .nav-left .header-search {
                display: none;
            }
            
            .user-profile span {
                display: none;
            }
        }
    </style>
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
            <div class="contain">
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <!-- PCoded Layout Structure -->
    <div id="pcoded" class="pcoded">
        <!-- Overlay Box -->
        <div class="pcoded-overlay-box" onclick="toggleSidebar()"></div>
        
        <!-- Container -->
        <div class="pcoded-container navbar-wrapper">
            <!-- Header Navbar -->
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <!-- Logo Section -->
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!" onclick="toggleSidebar()">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="{{ route('profesores.index') }}">
                            <img class="h-8 w-auto" src="{{ asset('libraries/assets/images/log_nomb.png') }}" alt="Logo">
                        </a>
                        <a class="mobile-options lg:hidden">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>
                    
                    <!-- Navbar Container -->
                    <div class="navbar-container">
                        <!-- Left Navigation -->
                        <ul class="nav-left">
                            <!-- Search -->
                            <li class="header-search">
                                <div class="main-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close hidden">
                                            <i class="feather icon-x"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Buscar...">
                                        <span class="input-group-addon search-btn">
                                            <i class="feather icon-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <!-- Full Screen -->
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize"></i>
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Right Navigation -->
                        <ul class="nav-right">
                            <!-- Notifications -->
                            <li class="header-notification">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" onclick="toggleDropdown('notifications')">
                                        <i class="feather icon-bell"></i>
                                        <span class="badge bg-c-pink">5</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu hidden" id="notifications-dropdown">
                                        <li class="p-4 border-b border-gray-200 flex items-center justify-between">
                                            <h6 class="text-sm font-medium text-gray-900 m-0">Notifications</h6>
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">New</span>
                                        </li>
                                        <li class="p-3 border-b border-gray-100">
                                            <div class="flex">
                                                <img class="w-10 h-10 rounded-full mr-3" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Avatar">
                                                <div class="flex-1">
                                                    <h5 class="text-sm font-semibold text-gray-900 m-0">John Doe</h5>
                                                    <p class="text-xs text-gray-600 m-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="text-xs text-gray-500">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-3 border-b border-gray-100">
                                            <div class="flex">
                                                <img class="w-10 h-10 rounded-full mr-3" src="{{ asset('libraries/assets/images/avatar-3.jpg') }}" alt="Avatar">
                                                <div class="flex-1">
                                                    <h5 class="text-sm font-semibold text-gray-900 m-0">Joseph William</h5>
                                                    <p class="text-xs text-gray-600 m-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="text-xs text-gray-500">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="p-3">
                                            <div class="flex">
                                                <img class="w-10 h-10 rounded-full mr-3" src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Avatar">
                                                <div class="flex-1">
                                                    <h5 class="text-sm font-semibold text-gray-900 m-0">Sara Soudein</h5>
                                                    <p class="text-xs text-gray-600 m-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="text-xs text-gray-500">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <!-- Messages -->
                            <li class="header-notification">
                                <div class="dropdown">
                                    <div class="dropdown-toggle">
                                        <i class="feather icon-message-square"></i>
                                        <span class="badge bg-c-green">3</span>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- User Profile -->
                            <li class="user-profile header-notification">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" onclick="toggleDropdown('user')">
                                        <img src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" class="w-8 h-8 img-radius" alt="User-Profile-Image">
                                        <span class="text-sm font-medium text-gray-700 hidden md:inline">{{ Auth::check() ? Auth::user()->nombre_completo : 'Usuario' }}</span>
                                        <i class="feather icon-chevron-down ml-2"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu hidden" id="user-dropdown">
                                        <li>
                                            <a href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                                <i class="feather icon-settings mr-3"></i> Configuración
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                                <i class="feather icon-user mr-3"></i> Perfil
                                            </a>
                                        </li>
                                        <li class="border-t border-gray-100">
                                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 bg-transparent border-0 text-left">
                                                    <i class="feather icon-log-out mr-3"></i> Cerrar Sesión
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

            <!-- Main Container -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- Sidebar Navigation -->
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <!-- Menu Label -->
                            <div class="pcoded-navigatio-lavel">Menu</div>
                            
                            <!-- Navigation Items -->
                            <ul class="pcoded-item pcoded-left-item">
                                <!-- Inicio -->
                                <li class="{{ $inicio == 'true' ? 'active' : '' }}">
                                    <a href="{{ route('profesores.index') }}">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-home"></i>
                                        </span>
                                        <span class="pcoded-mtext">Inicio</span>
                                    </a>
                                </li>
                                
                                <!-- Notas -->
                                <li class="{{ $notas == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/notas">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-edit"></i>
                                        </span>
                                        <span class="pcoded-mtext">Notas</span>
                                    </a>
                                </li>
                                
                                <!-- Asistencias -->
                                <li class="{{ $asistencias == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/asistencias">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-check-square"></i>
                                        </span>
                                        <span class="pcoded-mtext">Asistencias</span>
                                    </a>
                                </li>
                                
                                <!-- Tareas -->
                                <li class="{{ $tareas == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/tareas">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-file-text"></i>
                                        </span>
                                        <span class="pcoded-mtext">Tareas</span>
                                    </a>
                                </li>
                                
                                <!-- Alumnos -->
                                <li class="{{ $alumnos == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/alumnos">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-users"></i>
                                        </span>
                                        <span class="pcoded-mtext">Alumnos</span>
                                    </a>
                                </li>
                                
                                <!-- Horarios -->
                                <li class="{{ $horarios == 'true' ? 'active' : '' }}">
                                    <a href="/profesores/horarios">
                                        <span class="pcoded-micon">
                                            <i class="feather icon-clock"></i>
                                        </span>
                                        <span class="pcoded-mtext">Horarios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    
                    <!-- Content Area -->
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                {{ $slot }}
                            </div>
                            <!-- Main-body end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts requeridos -->
    <script src="{{ asset('libraries/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('libraries/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <script>
        // Toggle sidebar para móvil
        function toggleSidebar() {
            const pcoded = document.getElementById('pcoded');
            pcoded.classList.toggle('iscollapsed');
        }

        // Toggle dropdowns
        function toggleDropdown(type) {
            const dropdown = document.getElementById(type + '-dropdown');
            const allDropdowns = document.querySelectorAll('.dropdown-menu');
            
            // Cerrar otros dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== type + '-dropdown') {
                    dd.classList.add('hidden');
                }
            });
            
            // Toggle el dropdown actual
            dropdown.classList.toggle('hidden');
        }

        // Función de pantalla completa
        function toggleFullScreen() {
            if (!document.fullscreenElement && !document.mozFullScreenElement && 
                !document.webkitFullscreenElement && !document.msFullscreenElement) {
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

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            // Cerrar dropdowns al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(dd => {
                        dd.classList.add('hidden');
                    });
                }
            });
            
            // Funcionalidad de búsqueda
            const searchInput = document.querySelector('.form-control');
            const searchClose = document.querySelector('.search-close');
            const searchBtn = document.querySelector('.search-btn');
            
            if (searchInput && searchClose) {
                searchInput.addEventListener('input', function() {
                    if (this.value) {
                        searchClose.classList.remove('hidden');
                    } else {
                        searchClose.classList.add('hidden');
                    }
                });
                
                searchClose.addEventListener('click', function() {
                    searchInput.value = '';
                    this.classList.add('hidden');
                    searchInput.focus();
                });
            }
            
            // Ocultar preloader
            setTimeout(function() {
                const loader = document.querySelector('.theme-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.style.display = 'none', 300);
                }
            }, 1000);
            
            // DataTables configuración
            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                $(document).ready(function() {
                    if ($('#myTable').length) {
                        $('#myTable').DataTable({
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
            }
        });

        // Manejo de errores de JavaScript
        window.addEventListener('error', function(e) {
            console.error('Error en JavaScript:', e.error);
        });
    </script>

</body>

</html>