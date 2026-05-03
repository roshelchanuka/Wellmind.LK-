   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - WellMind LK</title>
    
    <!-- Hardcoded Assets for XAMPP stability (bypasses Vite path issues permanently) -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}?v={{ time() }}">
    <script type="module" src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/main.js') }}?v={{ time() }}"></script>
    @yield('styles')
</head>
<body class="admin-body premium-theme">

    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/websitelogo.jpg') }}" alt="Logo">
            <h2 style="font-family: 'League Spartan'; font-size: 1.2rem; margin: 0;">ADMIN PANEL</h2>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">dashboard</span> <span data-key="adminDashboard">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">group</span> <span data-key="userManagement">User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.support.index') }}" class="{{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">support_agent</span> <span data-key="supportTickets">Support Tickets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.index') }}" class="{{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">playlist_play</span> <span data-key="contentManager">Content Manager</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.metrics') }}" class="{{ request()->routeIs('admin.metrics') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">monitoring</span> <span data-key="systemMetrics">System Metrics</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-top: auto;">
                    <a href="{{ route('home') }}">
                        <span class="material-symbols-outlined">logout</span> <span data-key="exitAdmin">Exit Admin</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <main class="admin-main">
        <header class="admin-header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 style="margin: 0; font-family: 'League Spartan';" data-key="adminDashboard">@yield('page-title', 'Dashboard')</h1>
                    <p style="color: var(--text-muted); margin: 5px 0 0;"><span data-key="greetingWelcomeBack">Welcome back,</span> {{ Auth::user()->full_name }}</p>
                </div>
            </div>
            
            <div class="header-actions">
                <div class="lang-dropdown">
                    <button class="lang-dropbtn" id="langDropBtn">
                        <span class="material-symbols-outlined">language</span>
                        <span class="current-lang-text" id="currentLangText">English</span>
                        <span class="material-symbols-outlined icon-arrow">expand_more</span>
                    </button>
                    <div class="lang-dropdown-content">
                        <a href="#" class="lang-option" data-lang="en">English</a>
                        <a href="#" class="lang-option" data-lang="si">සිංහල</a>
                        <a href="#" class="lang-option" data-lang="ta">தமிழ்</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="admin-content">
            @yield('content')
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#749D62',
                background: '#1e293b',
                color: '#fff'
            });
        @endif

        // Sidebar Toggle Logic
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            body.classList.toggle('sidebar-open');
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
    </script>
    @yield('scripts')
</body>
</html>
