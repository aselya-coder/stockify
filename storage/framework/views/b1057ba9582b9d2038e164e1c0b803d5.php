<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Stockify - Smart Inventory Management</title>
    <meta name="description" content="Stockify - Aplikasi Manajemen Stok Barang yang modern dan profesional. Kelola stok lebih cepat, akurat, dan efisien.">

    <!-- Inter Font -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #374151; /* Professional Gray */
            --secondary-color: #ffffff; /* Pure white */
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--white);
            color: var(--dark-color);
            line-height: 1.7;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Animations --- */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- Header / Navbar --- */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }
        .logo span {
            font-size: 0.8rem;
            color: var(--text-gray);
            display: block;
            font-weight: 400;
        }
        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: var(--primary-color);
        }
        .nav-links .btn-cta {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .nav-links .btn-cta:hover {
            background-color: #1f2937;
        }
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* --- Hero Section --- */
        .hero {
            padding: 120px 0 60px;
            display: flex;
            align-items: flex-start;
        }
        .hero-content {
            flex: 1;
            padding-right: 2rem;
        }
        .hero-content h1 {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        .hero-content p {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
        }
        .hero-buttons .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(55, 65, 81, 0.3);
        }
        .btn-outline {
            border: 2px solid var(--border-color);
            color: var(--dark-color);
        }
        .btn-outline:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .hero-table {
            flex: 1;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .hero-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .hero-table th, .hero-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .hero-table th {
            background-color: var(--light-bg);
            font-weight: 600;
            color: var(--primary-color);
        }
        .hero-table td {
            color: var(--dark-color);
        }
        .hero-table .icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        /* --- Section Styling --- */
        section {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            text-align: center;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto 4rem auto;
        }

        /* --- CSS untuk Mengurangi Jarak di Akhir Section --- */
        .section-reduce-bottom-padding {
            padding-bottom: 40px !important;
        }

        /* --- Features & Benefits Grid --- */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .card-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .card p {
            color: var(--text-gray);
        }

        /* --- Testimonials --- */
        .testimonials {
            background-color: var(--light-bg);
        }
        .testimonial-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        .testimonial-content p {
            font-style: italic;
            margin-bottom: 1rem;
        }
        .testimonial-content h4 {
            font-weight: 600;
        }
        .testimonial-content span {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        /* --- CTA Section --- */
        .cta {
            background: var(--primary-color);
            color: var(--white);
            text-align: center;
            border-radius: 12px;
            padding: 80px 0;
        }
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        .cta p {
            margin-bottom: 2rem;
        }
        .cta .btn {
            background-color: var(--white);
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .cta .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* --- Footer --- */
        footer {
            background-color: var(--dark-color);
            color: var(--white);
            padding: 60px 0 30px;
        }
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .footer-brand h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .footer-links h4 {
            margin-bottom: 1rem;
        }
        .footer-links ul {
            list-style: none;
        }
        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            line-height: 2;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: var(--white);
        }
        .social-icons a {
            color: #9ca3af;
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: color 0.3s;
        }
        .social-icons a:hover {
            color: var(--primary-color);
        }
        .footer-bottom {
            text-align: center;
            border-top: 1px solid #374151;
            padding-top: 2rem;
            color: #9ca3af;
        }

        /* --- Responsive --- */
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .mobile-menu-toggle { display: block; }
            .hero { flex-direction: column; text-align: center; padding: 120px 0 60px; }
            .hero-content { padding-right: 0; margin-bottom: 2rem; }
            .hero-table { margin-top: 2rem; }
            .footer-content { grid-template-columns: 1fr; text-align: center; }
        }
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
            .testimonial-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <header>
        <div class="container">
            <nav>
                <a href="#home" class="logo">
                    Stockify
                    <span>Smart Inventory Management</span>
                </a>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#benefits">Manfaat</a></li>
                    <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                    <li><a href="<?php echo e(route('register')); ?>" class="btn-cta">Mulai Sekarang</a></li>
                </ul>
                <button class="mobile-menu-toggle"><i class="bi bi-list"></i></button>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="hero">
            <div class="container">
                <div class="hero-content fade-in">
                    <h1>Kelola Stok Lebih Cepat & Akurat Bersama Stockify</h1>
                    <p>Pantau arus barang masuk dan keluar, dapatkan laporan real-time, dan hindari kekosongan stok hanya dalam satu dashboard.</p>
                    <div class="hero-buttons">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Coba Sekarang</a>
                        <a href="#features" class="btn btn-outline">Lihat Fitur</a>
                    </div>
                </div>
                <div class="hero-table fade-in">
                    <table>
                        <thead>
                            <tr>
                                <th>Fitur Utama</th>
                                <th>Manfaat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-box-seam icon"></i>Manajemen Stok Real-Time</td>
                                <td>Pantau stok secara langsung dengan update otomatis.</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-graph-up icon"></i>Laporan & Analitik</td>
                                <td>Data lengkap untuk keputusan bisnis yang tepat.</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-bell icon"></i>Notifikasi Stok Rendah</td>
                                <td>Hindari kekosongan stok dengan peringatan dini.</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-people icon"></i>Multi-User Access</td>
                                <td>Kelola akses dengan peran admin, kasir, dan staf.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <!-- Features Section -->
        <section id="features" class="section">
            <div class="container">
                <h2 class="section-title">Fitur Unggulan Stockify</h2>
                <p class="section-subtitle">Kelola inventaris bisnis Anda dengan fitur-fitur canggih yang dirancang untuk kemudahan dan efisiensi.</p>
                <div class="grid">
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-box-seam"></i></div>
                        <h3>Manajemen Stok Real-Time</h3>
                        <p>Pantau stok barang secara real-time dengan update otomatis setiap transaksi masuk dan keluar.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-graph-up"></i></div>
                        <h3>Laporan & Analitik</h3>
                        <p>Dapatkan laporan lengkap dan analitik data untuk membantu pengambilan keputusan bisnis.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-bell"></i></div>
                        <h3>Notifikasi Stok Rendah</h3>
                        <p>Sistem akan memberi tahu Anda ketika stok barang hampir habis untuk menghindari kekosongan.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-people"></i></div>
                        <h3>Multi-User Access</h3>
                        <p>Kelola akses pengguna dengan peran admin, kasir, dan staf gudang untuk keamanan data.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-tags"></i></div>
                        <h3>Kategori & Supplier</h3>
                        <p>Organisir produk berdasarkan kategori dan pantau performa supplier dengan mudah.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-cloud-check"></i></div>
                        <h3>Cloud-Based Storage</h3>
                        <p>Data tersimpan aman di cloud dan dapat diakses dari mana saja kapan saja.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section id="benefits" class="section section-reduce-bottom-padding">
            <div class="container">
                <h2 class="section-title">Manfaat Menggunakan Stockify</h2>
                <p class="section-subtitle">Rasakan perbedaannya dalam mengelola inventaris bisnis Anda.</p>
                <div class="grid">
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-clock-history"></i></div>
                        <h3>Efisiensi Waktu</h3>
                        <p>Hemat waktu hingga 70% dengan proses otomatisasi yang meminimalkan pekerjaan manual.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-shield-check"></i></div>
                        <h3>Minimalkan Kerugian</h3>
                        <p>Hindari kerugian akibat stok hilang atau kesalahan pencatatan dengan sistem yang akurat.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi-lightbulb"></i></div>
                        <h3>Keputusan Lebih Cepat</h3>
                        <p>Data real-time membantu Anda membuat keputusan bisnis yang lebih tepat dan cepat.</p>
                    </div>
                    <div class="card fade-in">
                        <div class="card-icon"><i class="bi bi-eye"></i></div>
                        <h3>Transparansi Penuh</h3>
                        <p>Semua aktivitas tercatat dan dapat diaudit untuk transparansi operasional maksimal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials section">
            <div class="container">
                <h2 class="section-title">Apa Kata Pengguna Kami</h2>
                <p class="section-subtitle">Bergabunglah dengan ribuan bisnis yang telah mempercayai Stockify.</p>
                <div class="grid">
                    <div class="testimonial-card fade-in">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="User" class="testimonial-avatar">
                        <div class="testimonial-content">
                            <p>"Stockify telah mengubah cara kami mengelola inventaris. Sekarang semuanya lebih efisien dan akurat."</p>
                            <h4>Sarah Johnson</h4>
                            <span>Owner, Retail Store</span>
                        </div>
                    </div>
                    <div class="testimonial-card fade-in">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="User" class="testimonial-avatar">
                        <div class="testimonial-content">
                            <p>"Laporan real-time sangat membantu dalam pengambilan keputusan. Sangat direkomendasikan!"</p>
                            <h4>Michael Chen</h4>
                            <span>Manager, Wholesale Business</span>
                        </div>
                    </div>
                    <div class="testimonial-card fade-in">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="User" class="testimonial-avatar">
                        <div class="testimonial-content">
                            <p>"Interface yang user-friendly dan fitur notifikasi stok rendah sangat berguna untuk bisnis kami."</p>
                            <h4>Emily Davis</h4>
                            <span>CEO, Fashion Boutique</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta section">
            <div class="container">
                <h2>Mulai Kelola Stok Anda Sekarang</h2>
                <p>Bergabunglah dengan ribuan bisnis yang telah menggunakan Stockify untuk mengoptimalkan manajemen inventaris mereka.</p>
                <a href="<?php echo e(route('register')); ?>" class="btn">Mulai Gratis</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo e(date('Y')); ?> Stockify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Mobile Menu Toggle ---
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }

            // --- Fade-in Animation on Scroll ---
            const faders = document.querySelectorAll('.fade-in');

            const appearOptions = {
                threshold: 0.2,
                rootMargin: "0px 0px -50px 0px"
            };

            const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        return;
                    } else {
                        entry.target.classList.add('visible');
                        appearOnScroll.unobserve(entry.target);
                    }
                });
            }, appearOptions);

            faders.forEach(fader => {
                appearOnScroll.observe(fader);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\stockify\resources\views/welcome.blade.php ENDPATH**/ ?>