<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OVAs Académicas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-dark-blue: #1a365d;
            --secondary-dark-green: #1c4532;
            --accent-blue: #2c5282;
            --accent-green: #276749;
            --light-blue: #ebf8ff;
            --light-green: #f0fff4;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-dark-blue);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand i {
            font-size: 1.5rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: var(--accent-blue);
            color: white;
        }

        .menu-item.active {
            background-color: var(--accent-blue);
            color: white;
            border-left: 4px solid var(--accent-green);
        }

        .menu-item i {
            width: 1.5rem;
            text-align: center;
        }

        .menu-text {
            transition: opacity 0.3s ease;
        }

        .sidebar-collapsed .menu-text {
            opacity: 0;
            display: none;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content-expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .top-bar {
            background-color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary-dark-blue);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background-color: var(--light-blue);
        }

        .user-menu {
            position: relative;
        }

        .user-menu-button {
            background-color: var(--accent-blue);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .user-menu-button:hover {
            background-color: var(--accent-green);
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 200px;
            display: none;
        }

        .user-dropdown.show {
            display: block;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            color: var(--primary-dark-blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-blue);
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 999;
            }

            .mobile-menu-overlay.show {
                display: block;
            }
        }

        /* Content Area */
        .content-wrapper {
            flex: 1;
            padding: 2rem;
        }

        /* Footer */
        footer {
            background-color: var(--primary-dark-blue);
            color: white;
            padding: 1.5rem;
            margin-top: auto;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i>
                <span class="menu-text">OVAs Académicas</span>
            </a>
        </div>

        <nav class="sidebar-menu">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.programas.index') }}" class="menu-item {{ request()->routeIs('admin.programas.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span class="menu-text">Programas</span>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="menu-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="menu-text">Usuarios</span>
                    </a>
                @elseif(auth()->user()->isDocente())
                    <a href="{{ route('docente.dashboard') }}" class="menu-item {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('docente.ovas.index') }}" class="menu-item {{ request()->routeIs('docente.ovas.*') ? 'active' : '' }}">
                        <i class="fas fa-book-open"></i>
                        <span class="menu-text">Mis OVAs</span>
                    </a>
                    <a href="{{ route('docente.actividades.index') }}" class="menu-item {{ request()->routeIs('docente.actividades.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <span class="menu-text">Actividades</span>
                    </a>
                @elseif(auth()->user()->isEstudiante())
                    <a href="{{ route('estudiante.dashboard') }}" class="menu-item {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('estudiante.ovas.index') }}" class="menu-item {{ request()->routeIs('estudiante.ovas.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span class="menu-text">OVAs</span>
                    </a>
                    <a href="{{ route('estudiante.mis-ovas') }}" class="menu-item {{ request()->routeIs('estudiante.mis-ovas') ? 'active' : '' }}">
                        <i class="fas fa-bookmark"></i>
                        <span class="menu-text">Mis OVAs</span>
                    </a>
                    <a href="{{ route('estudiante.ovas.index') }}" class="menu-item {{ request()->routeIs('estudiante.ovas.foro.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        <span class="menu-text">Foro</span>
                    </a>
                @endif

                <div class="mt-8">
                    <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span class="menu-text">Perfil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="menu-item">
                        @csrf
                        <button type="submit" class="w-full text-left">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="menu-text">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </aside>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            @auth
                <div class="user-menu">
                    <button class="user-menu-button" id="userMenuButton">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ substr(auth()->user()->nombre_completo ?? auth()->user()->name, 0, 1) }}</span>
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Perfil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item w-full text-left">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" class="text-primary-dark-blue hover:text-accent-blue">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="bg-accent-green text-white px-4 py-2 rounded hover:bg-secondary-dark-green">Registrarse</a>
                </div>
            @endauth
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            <div class="text-center">
                <p class="text-sm">&copy; {{ date('Y') }} OVAs Académicas. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        let isSidebarExpanded = window.innerWidth > 768;

        function toggleSidebarMenu() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                mobileMenuOverlay.classList.toggle('show');
            } else {
                isSidebarExpanded = !isSidebarExpanded;
                sidebar.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('main-content-expanded');
            }
        }

        toggleSidebar.addEventListener('click', toggleSidebarMenu);
        mobileMenuOverlay.addEventListener('click', toggleSidebarMenu);

        // User Menu Dropdown
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');

        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Handle Window Resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                mobileMenuOverlay.classList.remove('show');
                if (!isSidebarExpanded) {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.add('main-content-expanded');
                }
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('main-content-expanded');
            }
        });

        // Initial setup
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.remove('main-content-expanded');
        } else if (!isSidebarExpanded) {
            sidebar.classList.add('sidebar-collapsed');
            mainContent.classList.add('main-content-expanded');
        }
    </script>

    @stack('scripts')
</body>
</html> 