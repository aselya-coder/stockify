

<?php $__env->startSection('title', 'Laporan Total Stok'); ?>


<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📊 Laporan Total Stok</h1>
            <p class="text-muted mb-0">Gambaran umum keseluruhan stok barang saat ini.</p>
        </div>
        <a href="<?php echo e(route('stok.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Mutasi
        </a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

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
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center text-muted"><?php echo e($loop->iteration); ?></td>
                        <td class="fw-semibold"><?php echo e($product->nama_barang); ?></td>
                        <td><?php echo e($product->category->nama_kategori ?? '-'); ?></td>
                        <td><?php echo e($product->supplier->nama_supplier ?? '-'); ?></td>
                        <td class="text-end">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></td>
                        <td class="text-center">
                            <?php if($product->stok < 10): ?>
                                <span class="badge bg-danger"><?php echo e($product->stok); ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?php echo e($product->stok); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end fw-semibold">
                            Rp <?php echo e(number_format($product->harga * $product->stok, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            Belum ada produk.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="5" class="text-end">GRAND TOTAL:</td>
                        <td class="text-center"><?php echo e($products->sum('stok')); ?></td>
                        <td class="text-end">Rp <?php echo e(number_format($products->sum(function($product) { return $product->harga * $product->stok; }), 0, ',', '.')); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title mb-4">📈 Diagram Stok Barang</h5>
        <div style="height: 400px; position: relative;">
            <canvas id="stockChart"></canvas>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('stockChart').getContext('2d');

            // Siapkan data dari PHP ke JavaScript
            const productLabels = <?php echo json_encode($products->pluck('nama_barang'), 15, 512) ?>;
            const stockData = <?php echo json_encode($products->pluck('stok'), 15, 512) ?>;

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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/stok/total.blade.php ENDPATH**/ ?>