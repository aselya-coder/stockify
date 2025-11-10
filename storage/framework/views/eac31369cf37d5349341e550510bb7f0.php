

<?php $__env->startSection('title', 'Dashboard Manajer Gudang'); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📋 Dashboard Manajer Gudang</h1>
            <p class="text-muted mb-0">Pantau operasional dan kondisi stok harian.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- Card Stok Menipis -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">⚠️ Stok Menipis</h5>
                <?php
                    $lowStockProducts = \App\Models\Product::with('category')->where('stok', '<', 10)->orderBy('stok', 'asc')->get();
                ?>
                <?php if($lowStockProducts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok Tersisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($product->nama_barang); ?></td>
                                    <td><?php echo e($product->category->nama_kategori ?? '-'); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><?php echo e($product->stok); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Semua stok aman. ✅</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Card Mutasi Terkini -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">🕐 Mutasi Terkini</h5>
                <?php
                    $recentMutations = \App\Models\StockMutation::with('product')->latest()->take(5)->get();
                ?>
                <ul class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $recentMutations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mutation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong><?php echo e($mutation->product->nama_barang); ?></strong>
                            <br>
                            <small class="text-muted">
                                <?php if($mutation->type == 'masuk'): ?>
                                    <span class="text-success">Barang Masuk</span>
                                <?php else: ?>
                                    <span class="text-danger">Barang Keluar</span>
                                <?php endif; ?>
                            </small>
                        </div>
                        <span class="badge bg-secondary rounded-pill"><?php echo e($mutation->quantity); ?> unit</span>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item px-0 text-muted">Belum ada mutasi.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/dashboard/manajer.blade.php ENDPATH**/ ?>