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
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #eef2ff);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: white;
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
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4b5563;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .sidebar a:hover {
            background: #eef2ff;
            color: var(--primary);
            transform: translateX(4px);
        }

        .sidebar a.active {
            background: #e0e7ff;
            color: var(--primary);
            font-weight: 600;
        }

        .main-content {
            margin-left: 240px;
            padding: 2rem;
            width: calc(100% - 240px);
        }

        /* Profil */
        .user-dropdown {
            position: relative;
            text-align: center;
        }

        .user-btn {
            background: #eef2ff;
            color: var(--primary);
            border: none;
            border-radius: 9999px;
            padding: 8px 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
        }

        .user-btn:hover {
            background: #e0e7ff;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-width: 160px;
            overflow: hidden;
            z-index: 999;
        }

        .dropdown-menu a,
        .dropdown-menu form button {
            display: block;
            padding: 10px 15px;
            color: #374151;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-menu a:hover,
        .dropdown-menu form button:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        /* Efek transisi halaman */
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
    </style>
</head>

<body>
    <div id="loading-indicator"></div>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div>
            <h2 class="text-xl font-bold text-indigo-600 mb-4 flex items-center gap-2">
                <i class="bi bi-box-seam"></i> Stockify
            </h2>

            @auth
            <nav class="nav flex-column gap-1">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    📦 Produk
                </a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    🗂️ Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    🚚 Supplier
                </a>
                <a href="{{ route('stok.index') }}" class="{{request()->routeIs('stok.*') ? 'active' : ''}}">
                    📊 Stok
                </a>
            </nav>
            @endauth

        </div>

        {{-- Profil + Dropdown --}}
        <div class="user-dropdown mt-5">
            @auth
                <button id="userButton" class="user-btn">
                    <span class="bg-indigo-500 text-white rounded-full px-2 py-1 text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                    <span>{{ Auth::user()->name }}</span>
                </button>

                <div id="dropdownMenu" class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-circle me-1"></i> Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </aside>

    {{-- Konten Utama --}}
    <div id="page" class="main-content page-transition">
        @yield('content')

        <footer class="text-center text-gray-500 mt-10 border-t pt-3">
            © {{ date('Y') }} <span class="text-indigo-600 font-semibold">Stockify</span> — Sistem Manajemen Stok Barang Modern
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const page = document.getElementById("page");
            const loader = document.getElementById("loading-indicator");

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
                    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                });

                document.addEventListener("click", () => dropdown.style.display = "none");
            }
        });
    </script>
</body>
</html>
