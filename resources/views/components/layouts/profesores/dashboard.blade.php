<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.profesores.head')
</head>

@php
    $inicio = isset($inicio) ? $inicio : 'false';
    $asistencias = isset($asistencias) ? $asistencias : 'false';
    $tareas = isset($tareas) ? $tareas : 'false';
    $alumnos = isset($alumnos) ? $alumnos : 'false';
    $notas = isset($notas) ? $notas : 'false';
    $horarios = isset($horarios) ? $horarios : 'false';
    $titulo = isset($titulo) ? $titulo : 'Indefinido';
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
                    <x-layouts.profesores.sidebar :inicio="$inicio" :asistencias="$asistencias" :tareas="$tareas"
                        :alumnos="$alumnos" :notas="$notas" :horarios="$horarios" />

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
    $asistencias = isset($asistencias) ? $asistencias : 'false';
    $tareas = isset($tareas) ? $tareas : 'false';
    $alumnos = isset($alumnos) ? $alumnos : 'false';
    $notas = isset($notas) ? $notas : 'false';
    $horarios = isset($horarios) ? $horarios : 'false';
    $titulo = isset($titulo) ? $titulo : 'Indefinido';
    @endphp

    <body class="bg-gray-50">
        <!-- Pre-loader start -->
        <div class="fixed inset-0 bg-white z-50 flex items-center justify-center" id="theme-loader">
            <div class="ball-scale">
                <div class="contain">
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

        <div class="min-h-screen">
            <!-- Navbar superior -->
            <nav class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-40">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo y menú móvil -->
                        <div class="flex items-center">
                            <button id="mobile-menu-button"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 lg:hidden">
                                <i class="feather icon-menu text-xl"></i>
                            </button>
                            <div class="flex-shrink-0 flex items-center ml-4 lg:ml-0">
                                <a href="{{ route('profesores.index') }}">
                                    <img class="h-8 w-auto" src="{{ asset('libraries/assets/images/log_nomb.png') }}"
                                        alt="Logo">
                                </a>
                            </div>
                        </div>

                        <!-- Barra de búsqueda (oculta en móvil) -->
                        <div class="hidden lg:flex items-center flex-1 px-8">
                            <div class="max-w-lg w-full lg:max-w-xs">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="feather icon-search text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center space-x-4">
                            <!-- Pantalla completa -->
                            <button onclick="toggleFullScreen()"
                                class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                                <i class="feather icon-maximize text-xl"></i>
                            </button>

                            <!-- Notificaciones -->
                            <div class="relative">
                                <button
                                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 relative"
                                    id="notifications-button">
                                    <i class="feather icon-bell text-xl"></i>
                                    <span
                                        class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-pink-500 text-white text-xs flex items-center justify-center">0</span>
                                </button>
                            </div>

                            <!-- Mensajes -->
                            <button class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 relative">
                                <i class="feather icon-message-square text-xl"></i>
                                <span
                                    class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-green-500 text-white text-xs flex items-center justify-center">0</span>
                            </button>

                            <!-- Perfil de usuario -->
                            <div class="relative">
                                <button class="flex items-center p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                    id="user-menu-button">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Usuario">
                                    <span
                                        class="ml-2 text-sm font-medium hidden md:block">{{ Auth::check() ? Auth::user()->nombre_completo : 'Usuario' }}</span>
                                    <i class="feather icon-chevron-down ml-1 text-sm"></i>
                                </button>

                                <!-- Dropdown del usuario -->
                                <div id="user-dropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                    <a href="{{ route('settings.profile') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="feather icon-settings mr-3"></i>
                                        Configuración
                                    </a>
                                    <a href="{{ route('settings.profile') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="feather icon-user mr-3"></i>
                                        Perfil
                                    </a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="feather icon-log-out mr-3"></i>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
                id="sidebar">
                <div class="flex flex-col h-full pt-16 lg:pt-0">
                    <!-- Header del sidebar (solo visible en desktop) -->
                    <div class="hidden lg:flex items-center justify-center h-16 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Panel Profesores</h2>
                    </div>

                    <!-- Navegación -->
                    <nav class="flex-1 px-2 py-4 bg-white overflow-y-auto">
                        <div class="space-y-1">
                            <div class="px-3 py-2">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menú Principal
                                </p>
                            </div>

                            <!-- Inicio -->
                            <a href="/profesores"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $inicio == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-home mr-3 text-lg {{ $inicio == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Inicio
                            </a>

                            <!-- Notas -->
                            <a href="/profesores/notas"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $notas == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-edit mr-3 text-lg {{ $notas == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Notas
                            </a>

                            <!-- Asistencias -->
                            <a href="/profesores/asistencias"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $asistencias == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-check-square mr-3 text-lg {{ $asistencias == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Asistencias
                            </a>

                            <!-- Tareas -->
                            <a href="/profesores/tareas"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $tareas == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-clipboard mr-3 text-lg {{ $tareas == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Tareas
                            </a>

                            <!-- Alumnos -->
                            <a href="/profesores/alumnos"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $alumnos == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-users mr-3 text-lg {{ $alumnos == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Alumnos
                            </a>

                            <!-- Horarios -->
                            <a href="/profesores/horarios"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $horarios == 'true' ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <i
                                    class="feather icon-clock mr-3 text-lg {{ $horarios == 'true' ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                                Horarios
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Overlay para móvil -->
            <div class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden hidden" id="sidebar-overlay"></div>

            <!-- Contenido principal -->
            <div class="lg:pl-64">
                <div class="pt-16">
                    <!-- Page header -->
                    <div class="bg-white shadow">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="py-6">
                                <div class="lg:flex lg:items-center lg:justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                                            {{ $titulo }}
                                        </h2>
                                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="feather icon-calendar mr-2"></i>
                                                {{ now()->format('d/m/Y') }}
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="feather icon-clock mr-2"></i>
                                                <span id="current-time"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page body -->
                    <main class="flex-1">
                        <div class="py-6">
                            <div class="px-4 sm:px-6 lg:px-8">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('libraries/bower_components/jquery/js/jquery.min.js') }}"></script>
        <script src="{{ asset('libraries/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('libraries/bower_components/popper.js/js/popper.min.js') }}"></script>
        <script src="{{ asset('libraries/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('libraries/assets/js/script.js') }}"></script>
        <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

        @verbatim
            <script>
                // Funcionalidad del menú móvil
                document.addEventListener('DOMContentLoaded', function() {
                    const mobileMenuButton = document.getElementById('mobile-menu-button');
                    const sidebar = document.getElementById('sidebar');
                    const sidebarOverlay = document.getElementById('sidebar-overlay');

                    function toggleMobileMenu() {
                        sidebar.classList.toggle('-translate-x-full');
                        sidebarOverlay.classList.toggle('hidden');
                    }

                    mobileMenuButton.addEventListener('click', toggleMobileMenu);
                    sidebarOverlay.addEventListener('click', toggleMobileMenu);

                    // Dropdown del usuario
                    const userMenuButton = document.getElementById('user-menu-button');
                    const userDropdown = document.getElementById('user-dropdown');

                    userMenuButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        userDropdown.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function() {
                        userDropdown.classList.add('hidden');
                    });

                    // Reloj en tiempo real
                    function updateTime() {
                        const now = new Date();
                        const timeString = now.toLocaleTimeString('es-AR', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        const timeElement = document.getElementById('current-time');
                        if (timeElement) {
                            timeElement.textContent = timeString;
                        }
                    }

                    updateTime();
                    setInterval(updateTime, 1000);

                    // Preloader
                    setTimeout(function() {
                        const loader = document.getElementById('theme-loader');
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
        @endverbatim

    </body>

</html>
