@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start py-10 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="w-full max-w-6xl px-4 animate-fadeIn">

        {{-- 🏷️ Judul --}}
        <div class="text-center mb-6">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight flex items-center justify-center gap-2">
                <span class="text-4xl">📊</span> Dashboard 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Stockify</span>
            </h2>
            <p class="text-gray-500 mt-2 text-sm md:text-base">
                Lihat ringkasan produk, kategori, supplier, dan stok terbaru
            </p>
        </div>

        {{-- 🔍 Kolom Pencarian --}}
        <div class="relative mb-10">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari produk, kategori, atau supplier..." 
                class="w-full px-4 py-3 pl-11 rounded-xl shadow-sm border border-gray-200 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            >
            <span class="absolute left-3 top-3 text-gray-400 text-xl">🔍</span>
        </div>

        {{-- 🔹 Statistik Ringkas --}}
        <div id="statsSection" class="flex flex-wrap justify-center gap-6 mb-12">
            @php
                $stats = [
                    ['emoji' => '📦', 'label' => 'Produk', 'value' => $productsCount ?? 0, 'color' => 'from-indigo-500 to-indigo-400'],
                    ['emoji' => '🗂️', 'label' => 'Kategori', 'value' => $categoriesCount ?? 0, 'color' => 'from-teal-500 to-emerald-400'],
                    ['emoji' => '🚚', 'label' => 'Supplier', 'value' => $suppliersCount ?? 0, 'color' => 'from-amber-500 to-orange-400'],
                    ['emoji' => '⚠️', 'label' => 'Stok Rendah', 'value' => $lowStock ?? 0, 'color' => 'from-rose-500 to-pink-400'],
                ];
            @endphp

            @foreach ($stats as $index => $stat)
            <div 
                class="w-[150px] sm:w-[160px] md:w-[180px] lg:w-[200px] bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 p-5 text-center transform hover:-translate-y-1 animate-fadeUp" 
                style="animation-delay: {{ $index * 150 }}ms;"
            >
                <div class="flex justify-center mb-3">
                    <div class="p-4 rounded-full bg-gradient-to-r {{ $stat['color'] }} text-3xl shadow-lg">
                        {{ $stat['emoji'] }}
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ $stat['value'] }}</h3>
                <p class="text-gray-500 font-medium mt-1 text-sm">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- 📦 Grafik Kategori Produk --}}
        <div id="chartSection" class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-md mb-10 mx-auto max-w-4xl hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 animate-fadeUp" style="animation-delay: 600ms;">
            <h3 class="font-semibold mb-4 text-center text-gray-700 text-lg">
                📦 Distribusi Produk per Kategori
            </h3>
            <div class="flex justify-center">
                <div class="w-full h-72">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        {{-- 📈 Grafik Stok Masuk dan Keluar --}}
        <div id="stockSection" class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-md mx-auto max-w-4xl hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 animate-fadeUp" style="animation-delay: 900ms;">
            <h3 class="font-semibold mb-4 text-center text-gray-700 text-lg">
                📈 Perbandingan Stok Masuk dan Keluar
            </h3>
            <div class="flex justify-center">
                <div class="w-full h-72">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>

        {{-- 🔍 Hasil Pencarian --}}
        <div id="searchResult" class="hidden bg-white p-6 rounded-2xl shadow-md text-gray-700"></div>

    </div>
</div>

{{-- 🧩 Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // --- Chart Produk per Kategori ---
    const categoryLabels = @json($categoryLabels ?? []);
    const categoryCounts = @json($categoryCounts ?? []);

    if (categoryLabels.length > 0) {
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: categoryCounts,
                    backgroundColor: 'rgba(99, 102, 241, 0.5)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    } else {
        document.getElementById('chartSection').innerHTML = `
            <p class="text-center text-gray-500 py-10">Belum ada data kategori untuk ditampilkan.</p>
        `;
    }

    // --- Chart Stok Masuk & Keluar ---
    const produkLabels = @json($produkLabels ?? []);
    const stokMasuk = @json($stokMasuk ?? []);
    const stokKeluar = @json($stokKeluar ?? []);

    if (produkLabels.length > 0) {
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'line',
            data: {
                labels: produkLabels,
                datasets: [
                    {
                        label: 'Stok Masuk',
                        data: stokMasuk,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Stok Keluar',
                        data: stokKeluar,
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    } else {
        document.getElementById('stockSection').innerHTML = `
            <p class="text-center text-gray-500 py-10">Belum ada data stok untuk ditampilkan.</p>
        `;
    }

    // --- Fitur Search Sederhana ---
    const searchInput = document.getElementById('searchInput');
    const searchResult = document.getElementById('searchResult');
    const statsSection = document.getElementById('statsSection');
    const chartSection = document.getElementById('chartSection');
    const stockSection = document.getElementById('stockSection');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();

        if (query === '') {
            searchResult.classList.add('hidden');
            statsSection.classList.remove('hidden');
            chartSection.classList.remove('hidden');
            stockSection.classList.remove('hidden');
            return;
        }

        statsSection.classList.add('hidden');
        chartSection.classList.add('hidden');
        stockSection.classList.add('hidden');
        searchResult.classList.remove('hidden');
        searchResult.innerHTML = `
            <div class="text-center">
                <h4 class="text-lg font-semibold mb-2">🔎 Hasil untuk: <b>${query}</b></h4>
                <p class="text-sm text-gray-500">Fitur pencarian lanjutan sedang dikembangkan.</p>
            </div>
        `;
    });
});
</script>

{{-- 🎨 Animasi CSS --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 1s ease-out forwards;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeUp {
    opacity: 0;
    animation: fadeUp 0.8s ease-out forwards;
}
</style>
@endsection
