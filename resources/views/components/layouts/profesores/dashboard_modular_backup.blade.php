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

<body class="bg-[#eeeded]">
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

    <div class="flex w-full">
        <!-- Header -->
        <x-layouts.profesores.header :titulo="$titulo" />
        
        <!-- Sidebar -->
        <x-layouts.profesores.sidebar 
            :inicio="$inicio" 
            :asistencias="$asistencias" 
            :tareas="$tareas" 
            :alumnos="$alumnos" 
            :notas="$notas" 
            :horarios="$horarios" />
        
        <!-- Main Content -->
        <x-layouts.profesores.main>
            {{ $slot }}
        </x-layouts.profesores.main>
    </div>

    @verbatim
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile menu toggle
                const sidebarButton = document.getElementById('sidebar-button');
                const sidebar = document.getElementById('sidebar');
                const darkenMain = document.getElementById('darkenMain');

                if (sidebarButton && sidebar) {
                    sidebarButton.addEventListener('click', function() {
                        sidebar.classList.toggle('hidden');
                        sidebar.classList.toggle('md:block');
                        if (darkenMain) {
                            darkenMain.classList.toggle('hidden');
                        }
                    });
                }

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
        </script>
    @endverbatim

</body>

</html>