<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.profesores.head')
</head>

<body>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- Header and main -->
            <x-layouts.profesores.header>
                <x-layouts.profesores.main>
                    {{ $slot }}
                </x-layouts.profesores.main>
            </x-layouts.profesores.header>
        </div>
    </div>
    </div>
    </div>
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\jquery\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\bower_components\popper.js\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript"
        src="{{ asset('libraries\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\modernizr\js\modernizr.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\chart.js\js\Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="{{ asset('libraries\assets\pages\widget\amchart\amcharts.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\widget\amchart\serial.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\widget\amchart\light.js') }}"></script>
    <script src="{{ asset('libraries\assets\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\SmoothScroll.js') }}"></script>
    <script src="{{ asset('libraries\assets\js\pcoded.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('libraries\assets\js\vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\dashboard\custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\script.min.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
</body>

</html>
