

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">👑 Dashboard Admin</h1>
            <p class="text-muted mb-0">Gambaran umum keseluruhan sistem.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- Card Total Produk -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-box-seam text-primary fs-1"></i>
                <h3 class="mt-3 mb-1"><?php echo e(App\Models\Product::count()); ?></h3>
                <p class="text-muted mb-0">Total Produk</p>
            </div>
        </div>
    </div>

    <!-- Card Total Kategori -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-tags text-success fs-1"></i>
                <h3 class="mt-3 mb-1"><?php echo e(App\Models\Category::count()); ?></h3>
                <p class="text-muted mb-0">Total Kategori</p>
            </div>
        </div>
    </div>

    <!-- Card Total Supplier -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-truck text-info fs-1"></i>
                <h3 class="mt-3 mb-1"><?php echo e(App\Models\Supplier::count()); ?></h3>
                <p class="text-muted mb-0">Total Supplier</p>
            </div>
        </div>
    </div>

    <!-- Card Total User -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people text-warning fs-1"></i>
                <h3 class="mt-3 mb-1"><?php echo e(App\Models\User::count()); ?></h3>
                <p class="text-muted mb-0">Total Pengguna</p>
            </div>
        </div>
    </div>
</div>

<!-- Card Nilai Stok -->
<div class="card mt-4 border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h5 class="mb-1">💰 Nilai Total Stok</h5>
                <p class="text-muted mb-0">Estimasi nilai seluruh barang di gudang.</p>
            </div>
            <div class="text-end">
                <h2 class="mb-0 text-primary">Rp <?php echo e(number_format(\App\Models\Product::sum(\Illuminate\Support\Facades\DB::raw('harga * stok')), 0, ',', '.')); ?></h2>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>