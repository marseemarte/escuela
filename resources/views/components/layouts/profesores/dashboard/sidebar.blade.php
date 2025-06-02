<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.profesores.head')
</head>

<body>
    <nav class="pcoded-navbar">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigatio-lavel">Navigation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu active pcoded-trigger">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>
