

<?php $__env->startSection('title', 'Daftar Produk'); ?>


<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📦 Daftar Produk</h1>
            <p class="text-muted mb-0">Kelola semua data produk yang ada di gudang.</p>
        </div>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-products')): ?>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk
            </a>
        <?php endif; ?>
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
                        <th>Stok</th>
                        
                        <th class="text-end">Harga</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center text-muted"><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold"><?php echo e($product->nama_barang); ?></td>
                            <td><?php echo e($product->category->nama_kategori ?? '-'); ?></td>
                            <td><?php echo e($product->supplier->nama_supplier ?? '-'); ?></td>
                            <td>
                                
                                <span class="badge <?php echo e($product->stok < 10 ? 'bg-danger' : 'bg-success'); ?>">
                                    <?php echo e($product->stok); ?>

                                </span>
                            </td>
                            
                            <td class="text-end fw-semibold">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></td>
                            <td class="text-center">
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-products')): ?>
                                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-sm btn-outline-warning" title="Edit Produk">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-products')): ?>
                                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus Produk">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                        <tr>
                            
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data produk.
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-products')): ?>
                                    <br>
                                    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Produk Pertama
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/products/index.blade.php ENDPATH**/ ?>