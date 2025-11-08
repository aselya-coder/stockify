

<?php $__env->startSection('title', 'Mutasi Stok'); ?>


<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📊 Mutasi Stok</h1>
            <p class="text-muted mb-0">Lihat semua riwayat pergerakan stok barang.</p>
        </div>
        <div>
            <a href="<?php echo e(route('stok.masuk')); ?>" class="btn btn-success me-2">
                <i class="bi bi-plus-circle me-1"></i> Catat Stok Masuk
            </a>
            <a href="<?php echo e(route('stok.keluar')); ?>" class="btn btn-danger">
                <i class="bi bi-dash-circle me-1"></i> Catat Stok Keluar
            </a>
        </div>
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
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th style="width: 100px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mutations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mutation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center text-muted"><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($mutation->created_at->format('d M Y, H:i')); ?></td>
                        <td class="fw-semibold"><?php echo e($mutation->product->nama_barang ?? 'Produk Dihapus'); ?></td>
                        <td>
                            <?php if($mutation->type == 'masuk'): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-down-circle me-1"></i> Stok Masuk
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-up-circle me-1"></i> Stok Keluar
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?php echo e($mutation->quantity); ?></td>
                        <td class="text-muted"><?php echo e($mutation->notes ?? '-'); ?></td>
                        <td class="text-center">
                            <?php if(auth()->user()->hasRole('admin')): ?>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('stok.edit', $mutation->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('stok.destroy', $mutation->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mutasi ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                            Belum ada riwayat mutasi stok.
                            <br>
                            <a href="<?php echo e(route('stok.masuk')); ?>" class="btn btn-sm btn-success mt-2 me-2">
                                <i class="bi bi-plus-circle me-1"></i> Catat Stok Masuk
                            </a>
                            <a href="<?php echo e(route('stok.keluar')); ?>" class="btn btn-sm btn-danger mt-2">
                                <i class="bi bi-dash-circle me-1"></i> Catat Stok Keluar
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/stok/index.blade.php ENDPATH**/ ?>