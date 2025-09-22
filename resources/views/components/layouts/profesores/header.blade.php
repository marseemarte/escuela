<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
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
                            <input type="text" class="form-control" placeholder="Buscar...">
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
                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notificaciones</h6>
                                <label class="label label-danger">Nuevo</label>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center img-radius"
                                        src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" alt="Avatar">
                                    <div class="media-body">
                                        <h5 class="notification-user">Nueva tarea</h5>
                                        <p class="notification-msg">Se ha asignado una nueva tarea</p>
                                        <span class="notification-time">hace 30 minutos</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('libraries/assets/images/avatar-4.jpg') }}" class="img-radius"
                                alt="User-Profile-Image">
                            <span>{{ Auth::check() ? Auth::user()->nombre_completo : 'Profesor' }}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <a href="#!">
                                    <i class="feather icon-settings"></i> Configuración
                                </a>
                            </li>
                            <li>
                                <a href="#!">
                                    <i class="feather icon-user"></i> Perfil
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background: none; border: none; color: inherit; cursor: pointer; width: 100%; text-align: left; padding: 0;">
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
