<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Stockify'))</title>
    <meta name="description" content="Stockify - Sistem Manajemen Stok Barang Modern untuk Bisnis Anda.">
    <meta name="theme-color" content="#4f46e5">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #ffffff;
            --main-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--main-bg);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid #e5e7eb;
            padding: 1.5rem 1rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #4b5563;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.25s ease;
            margin-bottom: 0.5rem;
        }

        .sidebar .nav-link:hover {
            background: #eef2ff;
            color: var(--primary);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: #e0e7ff;
            color: var(--primary);
            font-weight: 600;
        }
        
        .sidebar .nav-link i {
            font-size: 1.2rem;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: 260px;
            padding: 0;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .content-header {
            background: white;
            padding: 2rem;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .content-header h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
        }

        .content-body {
            padding: 2rem;
            flex-grow: 1;
        }

        /* --- User Dropdown --- */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: #eef2ff;
            color: var(--primary);
            border: none;
            border-radius: 8px;
            padding: 10px 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
        }

        .user-btn:hover {
            background: #e0e7ff;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 180px;
            overflow: hidden;
            z-index: 999;
            border: 1px solid #e5e7eb;
        }

        .dropdown-menu a,
        .dropdown-menu form button {
            display: block;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            transition: background-color 0.2s;
        }

        .dropdown-menu a:hover,
        .dropdown-menu form button:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        /* --- Transisi & Loading --- */
        .page-transition {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .page-transition.active {
            opacity: 1;
            transform: translateY(0);
        }
        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #14b8a6, #f59e0b);
            animation: loading 1s linear infinite;
            z-index: 9999;
            display: none;
        }
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* --- Alert Notifications --- */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 350px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* --- Mobile Responsiveness --- */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
        }
    </style>

    <!-- Tambahan CSS dari halaman tertentu -->
    @stack('styles')
</head>

<body>
    <div id="loading-indicator"></div>
    
    <!-- Tombol Menu Mobile -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list fs-4"></i>
    </button>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div>
            <div class="logo">
                <i class="bi bi-box-seam-fill"></i> Stockify
            </div>

            @auth
            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Supplier
                </a>
                <a href="{{ route('stok.index') }}" class="nav-link {{ request()->routeIs('stok.index') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> Mutasi Stok
                </a>
                {{-- 🔧 MENU BARU YANG DITAMBAHKAN --}}
                <a href="{{ route('stok.total') }}" class="nav-link {{ request()->routeIs('stok.total') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> Laporan Stok
                </a>
            </nav>
            @endauth

        </div>

        {{-- Profil + Dropdown --}}
        <div class="user-dropdown">
            @auth
                <button id="userButton" class="user-btn">
                    <span class="bg-indigo-500 text-white rounded-full p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="text-truncate">{{ Auth::user()->name }}</span>
                </button>

                <div id="dropdownMenu" class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-circle me-2"></i> Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </aside>

    {{-- Konten Utama --}}
    <main class="main-content">
        <header class="content-header">
            @yield('page-header')
        </header>

        <div id="page" class="content-body page-transition">
            <!-- Notifikasi Flash Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Oops!</strong> Ada kesalahan pada input:<br>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <footer class="text-center text-gray-500 mt-10 border-top pt-3">
            © {{ date('Y') }} <span class="text-indigo-600 font-semibold">Stockify</span> — Sistem Manajemen Stok Barang Modern
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const page = document.getElementById("page");
            const loader = document.getElementById("loading-indicator");
            const sidebar = document.getElementById("sidebar");
            const mobileMenuToggle = document.getElementById("mobileMenuToggle");

            // Fade in
            setTimeout(() => page.classList.add("active"), 100);

            // Loading bar saat navigasi
            document.querySelectorAll("a[href]").forEach(link => {
                link.addEventListener("click", e => {
                    const url = link.getAttribute("href");
                    const samePage = url.startsWith("#") || url.startsWith("javascript:");
                    if (!samePage && !url.startsWith("http")) {
                        e.preventDefault();
                        loader.style.display = "block";
                        page.classList.remove("active");
                        setTimeout(() => window.location.href = url, 300);
                    }
                });
            });

            // Dropdown toggle
            const userButton = document.getElementById("userButton");
            const dropdown = document.getElementById("dropdownMenu");

            if (userButton && dropdown) {
                userButton.addEventListener("click", (e) => {
                    e.stopPropagation();
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener("click", () => dropdown.style.display = 'none');
            }

            // Mobile menu toggle
            if (mobileMenuToggle && sidebar) {
                mobileMenuToggle.addEventListener("click", () => {
                    sidebar.classList.toggle("active");
                });

                // Close sidebar when clicking outside on mobile
                document.addEventListener("click", (e) => {
                    if (window.innerWidth <= 768 && 
                        !sidebar.contains(e.target) && 
                        !mobileMenuToggle.contains(e.target)) {
                        sidebar.classList.remove("active");
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    <!-- Tambahan JavaScript dari halaman tertentu -->
    @stack('scripts')
</body>
</html>