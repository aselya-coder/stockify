@extends('layouts.app')

@section('title', 'Laporan Total Stok')

{{-- Header Halaman --}}
@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📊 Laporan Total Stok</h1>
            <p class="text-muted mb-0">Gambaran umum keseluruhan stok barang saat ini.</p>
        </div>
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Mutasi
        </a>
    </div>
@endsection

{{-- Konten Utama --}}
@section('content')
{{-- Kartu untuk Tabel --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Stok Tersedia</th>
                        <th class="text-end">Nilai Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $product->nama_barang }}</td>
                        <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                        <td>{{ $product->supplier->nama_supplier ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($product->stok < 10)
                                <span class="badge bg-danger">{{ $product->stok }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->stok }}</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold">
                            Rp {{ number_format($product->harga * $product->stok, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            Belum ada produk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                {{-- Baris Total di Bagian Bawah --}}
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="5" class="text-end">GRAND TOTAL:</td>
                        <td class="text-center">{{ $products->sum('stok') }}</td>
                        <td class="text-end">Rp {{ number_format($products->sum(function($product) { return $product->harga * $product->stok; }), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- Kartu untuk Diagram (DIPINDAHKAN KE BAWAH) --}}
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title mb-4">📈 Diagram Stok Barang</h5>
        <div style="height: 400px; position: relative;">
            <canvas id="stockChart"></canvas>
        </div>
    </div>
</div>
@endsection

{{-- Section untuk JavaScript --}}
@push('scripts')
    {{-- 1. Tambahkan Library Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- 2. Inisialisasi Diagram --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('stockChart').getContext('2d');

            // Siapkan data dari PHP ke JavaScript
            const productLabels = @json($products->pluck('nama_barang'));
            const stockData = @json($products->pluck('stok'));

            // Buat warna otomatis untuk setiap batang
            const backgroundColors = stockData.map((_, index) => {
                const colors = [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ];
                return colors[index % colors.length];
            });

            new Chart(ctx, {
                type: 'bar', // Tipe diagram: 'bar', 'pie', 'doughnut', 'line', dll.
                data: {
                    labels: productLabels, // Label untuk sumbu X (Nama Barang)
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: stockData, // Data untuk sumbu Y (Jumlah Stok)
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color.replace('0.6', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true, // Mulai sumbu Y dari 0
                            title: {
                                display: true,
                                text: 'Jumlah Stok'
                            }
                        },
                        x: {
                           title: {
                                display: true,
                                text: 'Nama Barang'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legend karena hanya ada satu dataset
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + ' unit';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush