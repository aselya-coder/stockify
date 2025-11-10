

<?php $__env->startSection('title', 'Stok Keluar'); ?>


<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📉 Stok Keluar</h1>
            <p class="text-muted mb-0">Catat barang yang keluar dari gudang.</p>
        </div>
        <a href="<?php echo e(route('stok.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Mutasi
        </a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Form Stok Keluar -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Stok Keluar</h5>
                <form action="<?php echo e(route('stok.keluar.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Produk</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->nama_barang); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-text text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah Keluar</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                        <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-text text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-dash-circle me-2"></i> Simpan Stok Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Informasi Stok Saat Ini -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Stok Saat Ini</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok Tersedia</th>
                                <th>Jumlah Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($product->nama_barang); ?></td>
                                <td>
                                    <span class="badge bg-danger"><?php echo e($product->stok); ?></span>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="<?php echo e(old('jumlah', $product->stok)); ?>" readonly>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/stok/keluar.blade.php ENDPATH**/ ?>