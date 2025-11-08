

<?php $__env->startSection('title', 'Dashboard Staff Gudang'); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📦 Dashboard Staff Gudang</h1>
            <p class="text-muted mb-0">Pusat aktivitas dan tugas harian Anda.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- Card Tugas Konfirmasi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">🔄 Menunggu Konfirmasi Anda</h5>
                <?php
                    $pendingMutations = \App\Models\StockMutation::with('product')->where('status', 'pending')->latest()->get();
                ?>
                <?php if($pendingMutations->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendingMutations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mutation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($mutation->type == 'masuk'): ?>
                                            <span class="badge bg-success">Masuk</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold"><?php echo e($mutation->product->nama_barang); ?></td>
                                    <td class="text-center"><?php echo e($mutation->quantity); ?></td>
                                    <td class="text-center">
                                        <?php if($mutation->type == 'masuk'): ?>
                                            <a href="<?php echo e(route('stok.masuk.confirm', $mutation->id)); ?>" class="btn btn-sm btn-primary">Konfirmasi</a>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('stok.keluar.confirm', $mutation->id)); ?>" class="btn btn-sm btn-primary">Konfirmasi</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Card Aksi Cepat -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">🚀 Aksi Cepat</h5>
                <p class="text-muted small">Lihat riwayat semua transaksi stok.</p>
                <a href="<?php echo e(route('stok.index')); ?>" class="btn btn-secondary btn-lg w-100 py-3">
                    <i class="bi bi-clock-history me-2"></i> Lihat Riwayat Stok
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/dashboard/staff.blade.php ENDPATH**/ ?>