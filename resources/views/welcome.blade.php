<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Welcome</title>

    <!-- Tailwind CDN (agar langsung bekerja tanpa konfigurasi Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Stockify <span class="text-blue-600">App</span></h1>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex items-center justify-center min-h-[80vh] bg-gray-50">
        <div class="text-center px-6">

            <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                Kelola Stok dengan <span class="text-blue-600">Mudah & Cepat</span>
            </h2>

            <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                Aplikasi Stockify membantu Anda mengelola produk, supplier, kategori, dan laporan stok secara efisien.
            </p>

            <!-- Tombol Login dan Register di Tengah -->
            <div class="flex gap-4 justify-center">
                <a href="{{ route('login') }}"
                class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition">
                Login
                </a>
                <a href="{{ route('register') }}"
                class="px-6 py-3 border border-blue-600 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition">
                Register
                </a>
            </div>

        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-600">© 2025 Stockify App. All rights reserved.</p>
            <div class="flex justify-center space-x-4 mt-3">
                <a href="#" class="text-gray-600 hover:text-blue-600">Instagram</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">Facebook</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">GitHub</a>
            </div>
        </div>
    </footer>

</body>
</html>
