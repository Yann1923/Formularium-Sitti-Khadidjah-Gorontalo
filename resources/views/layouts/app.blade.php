<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Formularium Rumah Sakit')</title>
    
    <!-- PWA Support -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Formularium">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #15803d;
            --secondary-color: #16a34a;
            --accent-color: #22c55e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        
        /* Header Styles */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .hospital-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .hospital-info h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .hospital-info p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        /* Sidebar Popup Styles */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        .sidebar-popup {
            position: fixed;
            top: 0;
            left: -320px;
            width: 320px;
            height: 100vh;
            background: linear-gradient(180deg, #15803d 0%, #166534 100%);
            overflow-y: auto;
            z-index: 10000;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .sidebar-popup.show {
            left: 0;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            position: relative;
        }
        
        .sidebar-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-close:hover {
            opacity: 1;
        }
        
        .sidebar-brand {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
        }
        
        .sidebar-brand:hover {
            color: var(--accent-color);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
        }
        
        .nav-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .nav-item {
            margin: 0.25rem 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #e0e7ef;
            text-decoration: none;
            border-radius: 14px;
            margin: 0 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: none;
            border-left: none;
        }
        
        .nav-link i {
            width: 22px;
            margin-right: 1rem;
            text-align: center;
            font-size: 1.2rem;
        }
        
        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
            box-shadow: 0 2px 8px 0 rgba(30,64,175,0.10);
        }
        
        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, #16a34a 0%, #15803d 100%);
            box-shadow: 0 4px 16px 0 rgba(21,128,61,0.15);
            font-weight: 700;
        }
        
        /* Dashboard special style */
        .nav-link.dashboard-main {
            background: linear-gradient(90deg, #15803d 0%, #16a34a 100%);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 16px 0 rgba(21,128,61,0.18);
            border-radius: 16px;
        }
        
        .nav-link.dashboard-main:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
        }
        
        /* User card at bottom */
        .sidebar-user-card {
            background: rgba(255,255,255,0.10);
            margin: 1.5rem 1rem 1rem 1rem;
            border-radius: 16px;
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #fff;
            box-shadow: 0 2px 8px 0 rgba(30,64,175,0.10);
        }
        
        .sidebar-user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .sidebar-user-info {
            flex: 1;
        }
        
        .sidebar-user-name {
            font-weight: 600;
            margin-bottom: 0;
            color: #fff;
        }
        
        .sidebar-user-role {
            font-size: 0.85rem;
            color: #c7d2fe;
        }
        
        .sidebar-logout-btn {
            width: 100%;
            margin-top: 0.5rem;
            background: linear-gradient(90deg, #f87171 0%, #ef4444 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.5rem 0;
            font-weight: 600;
            box-shadow: 0 2px 8px 0 rgba(239,68,68,0.10);
            transition: background 0.2s;
        }
        
        .sidebar-logout-btn:hover {
            background: linear-gradient(90deg, #ef4444 0%, #b91c1c 100%);
        }
        
        /* Main Content */
        .main-content {
            margin-top: 100px;
            padding: 2rem;
            min-height: calc(100vh - 100px);
        }
        
        .content-header {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }
        
        .breadcrumb {
            margin: 0.5rem 0 0;
            font-size: 0.9rem;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            margin: 0;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.8;
            margin: 0;
        }
        
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        /* Responsive */
        @media (min-width: 992px) {
            .sidebar-popup {
                width: 350px;
                left: -350px;
            }
        }
        
        @media (max-width: 768px) {
            .hospital-info {
                display: none;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container-fluid">
            <div class="header-content">
                <div class="d-flex align-items-center">
                    <button class="sidebar-toggle me-3" onclick="openSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="hospital-logo">
                        <div class="logo-placeholder" style="background: none; border: none;">
                            <img src="/logo-rsia.png" alt="Logo RSIA Sitti Khadidjah" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; background: #fff; padding: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        </div>
                        <div class="hospital-info">
                            <h4>Rumah Sakit Sitti Khadidjah</h4>
                            <p>Gorontalo</p>
                        </div>
                    </div>
                </div>
                
                <div class="user-menu">
                    <div class="user-info">
                        <p class="user-name">{{ auth()->user()->name }}</p>
                        <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user me-2"></i>Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <!-- Sidebar Popup -->
    <nav class="sidebar-popup" id="sidebarPopup">
        <div>
            <div class="sidebar-header">
                <button class="sidebar-close" onclick="closeSidebar()">
                    <i class="fas fa-times"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-pills me-2"></i>Formularium
                </a>
            </div>
            <div class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <div class="nav-item">
                        <a class="nav-link dashboard-main {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" onclick="closeSidebar()">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile') }}" onclick="closeSidebar()">
                            <i class="fas fa-user"></i>
                            Profil
                        </a>
                    </div>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Data Master</div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('medicines*') ? 'active' : '' }}" href="{{ route('medicines.index') }}" onclick="closeSidebar()">
                            <i class="fas fa-pills"></i>
                            Daftar Obat
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diseases*') ? 'active' : '' }}" href="{{ route('diseases.index') }}" onclick="closeSidebar()">
                            <i class="fas fa-disease"></i>
                            Daftar Penyakit
                        </a>
                    </div>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Tools</div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bmi*') ? 'active' : '' }}" href="{{ route('bmi.index') }}" onclick="closeSidebar()">
                            <i class="fas fa-calculator"></i>
                            Kalkulator BMI
                        </a>
                    </div>
                </div>
                @if(auth()->user()->isAdmin())
                <div class="nav-section">
                    <div class="nav-section-title">Administrasi</div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}" href="{{ route('users.index') }}" onclick="closeSidebar()">
                            <i class="fas fa-users"></i>
                            Kelola Pengguna
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- User Card Bottom -->
        <div>
            <div class="sidebar-user-card">
                <div class="sidebar-user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="padding: 0 1.5rem 1.5rem 1.5rem;">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav> --}}
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function openSidebar() {
            document.getElementById('sidebarOverlay').classList.add('show');
            document.getElementById('sidebarPopup').classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
        
        function closeSidebar() {
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.getElementById('sidebarPopup').classList.remove('show');
            document.body.style.overflow = ''; // Restore scrolling
        }
        
        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
        
        // Close sidebar when clicking on a link (already handled by onclick)
        // The onclick="closeSidebar()" on each nav link will close the sidebar when clicked
    </script>
    
    @stack('scripts')
    
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registered:', registration);
                    })
                    .catch(error => {
                        console.log('ServiceWorker registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html> 