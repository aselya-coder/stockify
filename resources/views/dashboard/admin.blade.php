@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .chart-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    /* Animasi untuk tombol refresh */
    .spinner {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">👑 Dashboard Admin</h1>
            <p class="text-muted mb-0">Gambaran umum keseluruhan sistem.</p>
        </div>
        <div>
            <button id="refreshButton" class="btn btn-outline-primary" onclick="refreshCharts()">
                <i class="bi bi-arrow-clockwise"></i> Refresh Data
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Card Total Produk -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="bi bi-box-seam text-primary fs-1"></i>
                <h3 class="mt-3 mb-1">{{ App\Models\Product::count() }}</h3>
                <p class="text-muted mb-0">Total Produk</p>
            </div>
        </div>
    </div>

    <!-- Card Total Kategori -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="bi bi-tags text-success fs-1"></i>
                <h3 class="mt-3 mb-1">{{ App\Models\Category::count() }}</h3>
                <p class="text-muted mb-0">Total Kategori</p>
            </div>
        </div>
    </div>

    <!-- Card Total Supplier -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="bi bi-truck text-info fs-1"></i>
                <h3 class="mt-3 mb-1">{{ App\Models\Supplier::count() }}</h3>
                <p class="text-muted mb-0">Total Supplier</p>
            </div>
        </div>
    </div>

    <!-- Card Total User -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="bi bi-people text-warning fs-1"></i>
                <h3 class="mt-3 mb-1">{{ App\Models\User::count() }}</h3>
                <p class="text-muted mb-0">Total Pengguna</p>
            </div>
        </div>
    </div>
</div>

<!-- Card Nilai Stok -->
<div class="card mt-4 border-0 shadow-sm stat-card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h5 class="mb-1">💰 Nilai Total Stok</h5>
                <p class="text-muted mb-0">Estimasi nilai seluruh barang di gudang.</p>
            </div>
            <div class="text-end">
                <h2 class="mb-0 text-primary">Rp {{ number_format(\App\Models\Product::sum(\Illuminate\Support\Facades\DB::raw('harga * stok')), 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mt-2">
    <!-- Chart Produk per Kategori -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm chart-card">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0">📊 Distribusi Produk per Kategori</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Stok Terendah -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm chart-card">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0">⚠️ 10 Produk Stok Terendah</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="lowStockChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Supplier Distribution -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm chart-card">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0">🚚 Distribusi Produk per Supplier</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="supplierChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Nilai Stok per Kategori -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm chart-card">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0">💵 Nilai Stok per Kategori</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="stockValueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Table -->
<div class="card mt-4 border-0 shadow-sm stat-card">
    <div class="card-header bg-white border-0 pt-4">
        <h5 class="mb-0">📈 Statistik Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center p-3">
                    <h6 class="text-muted">Rata-rata Harga Produk</h6>
                    <h4 class="text-primary">Rp {{ number_format(\App\Models\Product::avg('harga'), 0, ',', '.') }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3">
                    <h6 class="text-muted">Total Stok Barang</h6>
                    <h4 class="text-success">{{ number_format(\App\Models\Product::sum('stok'), 0, ',', '.') }} Unit</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3">
                    <h6 class="text-muted">Produk Stok Rendah</h6>
                    <h4 class="text-warning">{{ \App\Models\Product::where('stok', '<', 10)->count() }} Produk</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3">
                    <h6 class="text-muted">Produk Habis</h6>
                    <h4 class="text-danger">{{ \App\Models\Product::where('stok', '=', 0)->count() }} Produk</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fungsi refresh dipindahkan ke luar DOMContentLoaded agar bisa diakses secara global
    function refreshCharts() {
        const refreshButton = document.getElementById('refreshButton');
        const icon = refreshButton.querySelector('i');
        
        // Berikan animasi spin dan nonaktifkan tombol sementara
        icon.className = 'bi bi-arrow-repeat spinner';
        refreshButton.disabled = true;
        
        // Muat ulang halaman
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Data dari backend
        const categoryData = @json(\App\Models\Category::withCount('products')->get());
        const lowStockData = @json(\App\Models\Product::orderBy('stok', 'asc')->limit(10)->get());
        const supplierData = @json(\App\Models\Supplier::withCount('products')->get());
        
        // Query untuk nilai stok per kategori
        const stockValueData = @json(\App\Models\Category::with('products')->get()->map(function($category) {
            return [
                'name' => $category->nama_kategori,
                'value' => $category->products->sum(function($product) { return $product->harga * $product->stok; })
            ];
        }));

        // Fungsi untuk menemukan kolom nama produk
        function getProductName(product) {
            return product.nama_barang || product.nama_produk || product.product_name || product.nama || product.name || product.title || 'Produk Tanpa Nama';
        }

        // Fungsi untuk menemukan kolom nama kategori
        function getCategoryName(category) {
            return category.nama_kategori || category.category_name || category.nama || category.name || 'Kategori Tanpa Nama';
        }

        // Fungsi untuk menemukan kolom nama supplier
        function getSupplierName(supplier) {
            return supplier.nama_supplier || supplier.supplier_name || supplier.nama || supplier.name || 'Supplier Tanpa Nama';
        }

        // Chart default options untuk animasi hover
        const defaultChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true
                }
            }
        };

        // Chart Produk per Kategori
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryData.map(c => getCategoryName(c)),
                datasets: [{
                    label: 'Jumlah Produk',
                    data: categoryData.map(c => c.products_count),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)',
                    hoverBorderColor: 'rgba(54, 162, 235, 1)',
                    hoverBorderWidth: 3
                }]
            },
            options: {
                ...defaultChartOptions,
                plugins: { ...defaultChartOptions.plugins, legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { display: true, color: 'rgba(0, 0, 0, 0.05)' } },
                    x: { ticks: { font: { size: 11 } }, grid: { display: false } }
                },
                onHover: (event, activeElements) => { event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default'; }
            }
        });

        // Chart Stok Terendah
        const lowStockCtx = document.getElementById('lowStockChart').getContext('2d');
        new Chart(lowStockCtx, {
            type: 'bar',
            data: {
                labels: lowStockData.map(p => {
                    const productName = getProductName(p);
                    return productName.length > 15 ? productName.substring(0, 15) + '...' : productName;
                }),
                datasets: [{
                    label: 'Stok',
                    data: lowStockData.map(p => p.stok),
                    backgroundColor: lowStockData.map(p => p.stok === 0 ? 'rgba(255, 99, 132, 0.6)' : p.stok < 5 ? 'rgba(255, 206, 86, 0.6)' : 'rgba(75, 192, 192, 0.6)'),
                    borderColor: lowStockData.map(p => p.stok === 0 ? 'rgba(255, 99, 132, 1)' : p.stok < 5 ? 'rgba(255, 206, 86, 1)' : 'rgba(75, 192, 192, 1)'),
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: lowStockData.map(p => p.stok === 0 ? 'rgba(255, 99, 132, 0.9)' : p.stok < 5 ? 'rgba(255, 206, 86, 0.9)' : 'rgba(75, 192, 192, 0.9)'),
                    hoverBorderColor: lowStockData.map(p => p.stok === 0 ? 'rgba(255, 99, 132, 1)' : p.stok < 5 ? 'rgba(255, 206, 86, 1)' : 'rgba(75, 192, 192, 1)'),
                    hoverBorderWidth: 3
                }]
            },
            options: {
                ...defaultChartOptions,
                indexAxis: 'y',
                plugins: { ...defaultChartOptions.plugins, legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { font: { size: 11 } }, grid: { display: true, color: 'rgba(0, 0, 0, 0.05)' } },
                    y: { ticks: { font: { size: 11 } }, grid: { display: false } }
                },
                onHover: (event, activeElements) => { event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default'; }
            }
        });

        // Chart Supplier Distribution
        const supplierCtx = document.getElementById('supplierChart').getContext('2d');
        new Chart(supplierCtx, {
            type: 'doughnut',
            data: {
                labels: supplierData.map(s => getSupplierName(s)),
                datasets: [{
                    data: supplierData.map(s => s.products_count),
                    backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverBackgroundColor: ['rgba(255, 99, 132, 0.9)', 'rgba(54, 162, 235, 0.9)', 'rgba(255, 206, 86, 0.9)', 'rgba(75, 192, 192, 0.9)', 'rgba(153, 102, 255, 0.9)', 'rgba(255, 159, 64, 0.9)'],
                    hoverBorderColor: '#fff',
                    hoverBorderWidth: 4,
                    hoverOffset: 15
                }]
            },
            options: {
                ...defaultChartOptions,
                plugins: {
                    ...defaultChartOptions.plugins,
                    legend: { position: 'right', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } },
                    tooltip: { ...defaultChartOptions.plugins.tooltip, callbacks: { label: function(context) { let label = context.label || ''; if (label) { label += ': '; } label += context.parsed + ' produk'; return label; } } }
                },
                onHover: (event, activeElements) => { event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default'; }
            }
        });

        // Chart Nilai Stok per Kategori
        const stockValueCtx = document.getElementById('stockValueChart').getContext('2d');
        const categoryStockValues = stockValueData;

        new Chart(stockValueCtx, {
            type: 'pie',
            data: {
                labels: categoryStockValues.map(c => c.name),
                datasets: [{
                    data: categoryStockValues.map(c => c.value),
                    backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverBackgroundColor: ['rgba(255, 99, 132, 0.9)', 'rgba(54, 162, 235, 0.9)', 'rgba(255, 206, 86, 0.9)', 'rgba(75, 192, 192, 0.9)', 'rgba(153, 102, 255, 0.9)', 'rgba(255, 159, 64, 0.9)'],
                    hoverBorderColor: '#fff',
                    hoverBorderWidth: 4,
                    hoverOffset: 20
                }]
            },
            options: {
                ...defaultChartOptions,
                plugins: {
                    ...defaultChartOptions.plugins,
                    legend: { position: 'right', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } },
                    tooltip: { ...defaultChartOptions.plugins.tooltip, callbacks: { label: function(context) { let label = context.label || ''; if (label) { label += ': '; } label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed); return label; } } }
                },
                onHover: (event, activeElements) => { event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default'; }
            }
        });
    });
</script>
@endpush