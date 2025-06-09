<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informes</title>
    <style>
        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
        }
        .container-flex {
            display: flex;
            min-height: 100vh;
        }
        aside.sidebar {
            width: 250px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            padding: 0;
            transition: left 0.3s;
        }
        main.main-content {
            flex: 1;
            background: #f8fafc;
            padding: 32px;
        }
        .sidebar-toggle {
            display: none;
            position: absolute;
            top: 16px;
            left: 16px;
            background: #4e73df;
            border: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 20px;
            z-index: 1001;
            cursor: pointer;
        }
        @media (max-width: 900px) {
            aside.sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                z-index: 1000;
                box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            }
            aside.sidebar.open {
                left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            main.main-content {
                padding: 16px;
            }
            .container-flex {
                flex-direction: column;
            }
        }
        @media (max-width: 600px) {
            aside.sidebar {
                width: 80vw;
                min-width: 180px;
                max-width: 320px;
            }
            main.main-content {
                padding: 8px;
            }
        }
        /* Optional: Overlay for mobile menu */
        .sidebar-overlay {
            display: none;
        }
        .sidebar-overlay.active {
            display: block;
            position: fixed;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.2);
            z-index: 999;
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" id="sidebarToggle">&#9776;</button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="container-flex">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Logo -->
            <div style="display: flex; align-items: center; gap: 10px; padding: 32px 24px 16px 24px;">
                <img src="https://img.icons8.com/ios-filled/50/4e73df/graduation-cap.png" alt="Logo" style="width:32px; height:32px;">
                <div>
                    <div style="font-weight: 700; font-size: 20px; color: #222;">ENLACE</div>
                    <div style="font-size: 12px; color: #888;">ESCOLAR</div>
                </div>
            </div>
            <!-- Menu -->
            <nav style="flex: 1; padding: 0 0 0 0;">
                <div style="margin-bottom: 24px;">
                    <div style="padding: 8px 24px 4px 24px; font-size: 13px; color: #bbb;">Principal</div>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/home.png"/></span>
                        Inicio
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/user.png"/></span>
                        Mi Cuenta
                    </a>
                </div>
                <div style="margin-bottom: 24px;">
                    <div style="padding: 8px 24px 4px 24px; font-size: 13px; color: #bbb;">Académico</div>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/classroom.png"/></span>
                        Cursos
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/student-male.png"/></span>
                        Alumnos
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/list.png"/></span>
                        CUPOF
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/calendar.png"/></span>
                        Horarios
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/id-verified.png"/></span>
                        Carnet
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/classroom.png"/></span>
                        Salones
                    </a>
                </div>
                <div style="margin-bottom: 24px;">
                    <div style="padding: 8px 24px 4px 24px; font-size: 13px; color: #bbb;">Gestión</div>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/conference.png"/></span>
                        Personal
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/family.png"/></span>
                        Parentescos
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 24px; color: #222; text-decoration: none; border-radius: 8px; transition: background 0.2s;">
                        <span><img src="https://img.icons8.com/ios-filled/20/4e73df/teacher.png"/></span>
                        Asistencia Docente
                    </a>
                </div>
            </nav>
            <!-- End Sidebar -->
        </aside>
        <!-- Main Content Placeholder -->
        <main class="main-content">
            <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 24px;">Informes 2025</h1>

        </main>
    </div>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }
        toggle.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
        // Optional: close sidebar on resize if desktop
        window.addEventListener('resize', function() {
            if(window.innerWidth > 900) closeSidebar();
        });
    </script>
</body>
</html>