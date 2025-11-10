

<?php $__env->startSection('title', 'Konfirmasi Barang Keluar'); ?>

<?php $__env->startSection('page-header'); ?>
    <h1>✅ Konfirmasi Barang Keluar</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Produk</h5>
        <table class="table table-borderless">
            <tr>
                <td width="150">Nama Barang</td>
                <td><strong><?php echo e($mutation->product->nama_barang); ?></strong></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><strong><?php echo e($mutation->quantity); ?> unit</strong></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td><?php echo e($mutation->notes ?? '-'); ?></td>
            </tr>
        </table>

        <hr>

        <form action="<?php echo e(route('stok.keluar.confirm.update', $mutation->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <p>Apakah Anda yakin ingin mengkonfirmasi pengeluaran barang ini?</p>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-2"></i>Ya, Konfirmasi
            </button>
            <a href="<?php echo e(route('stok.index')); ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/stok/confirm-keluar.blade.php ENDPATH**/ ?>