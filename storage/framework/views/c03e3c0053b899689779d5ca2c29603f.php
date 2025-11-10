

<?php $__env->startSection('title', 'Tambah Produk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Menambahkan sedikit style agar input harga terlihat rapi */
    .input-group .form-control {
        text-align: right;
    }
</style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">📦 Tambah Produk</h1>
            <p class="text-muted mb-0">Masukkan produk baru ke dalam sistem.</p>
        </div>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-2"></i> Kembali
        </a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Formulir Produk</h5>
                <form action="<?php echo e(route('products.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control <?php $__errorArgs = ['nama_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_barang')); ?>" placeholder="Masukkan nama produk" required>
                            <?php $__errorArgs = ['nama_barang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stok" class="form-label">Stok Awal</label>
                            <input type="number" name="stok" id="stok" class="form-control <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('stok')); ?>" placeholder="0" min="0" required>
                            <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select <?php $__errorArgs = ['kategori_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('kategori_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->nama_kategori); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['kategori_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-select <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="" selected disabled>-- Pilih Supplier --</option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>" <?php echo e(old('supplier_id') == $supplier->id ? 'selected' : ''); ?>><?php echo e($supplier->nama_supplier); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga" id="harga" class="form-control <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('harga')); ?>" placeholder="0" required>
                            <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <small class="form-text text-muted">Masukkan angka tanpa titik atau koma.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">
                    <i class="bi bi-box-seam me-2"></i>Tambah Stok Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Produk</label>
                        
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="" selected disabled>-- Memuat --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" placeholder="0" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveStockBtn">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- FITUR 1: PERBAIKAN TAMPILAN HARGA ---
    const hargaInput = document.getElementById('harga');
    if (hargaInput) {
        hargaInput.addEventListener('blur', function() {
            // Hapus semua karakter kecuali angka
            let rawValue = this.value.replace(/\D/g, '');
            // Format ke format Rupiah
            if (rawValue) {
                this.value = new Intl.NumberFormat('id-ID').format(rawValue);
            } else {
                this.value = '';
            }
        });

        // Saat fokus, hapus format agar mudah diedit
        hargaInput.addEventListener('focus', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    // --- FITUR 2: MODAL TAMBAH STOK ---
    const addStockModal = new bootstrap.Modal(document.getElementById('addStockModal'));
    const addStockForm = document.getElementById('addStockForm');
    const saveStockBtn = document.getElementById('saveStockBtn');
    const productSelect = document.getElementById('product_id');

    // Ambil data produk saat modal dibuka
    document.getElementById('addStockModal').addEventListener('show.bs.modal', function () {
        fetch('<?php echo e(route("products.json")); ?>') // Buat route ini di web.php
            .then(response => response.json())
            .then(data => {
                productSelect.innerHTML = '<option value="" selected disabled>-- Pilih Produk --</option>';
                data.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = `${product.nama_barang} (Stok: ${product.stok})`;
                    productSelect.appendChild(option);
                });
            });
    });

    // Simpan stok baru
    saveStockBtn.addEventListener('click', function() {
        const formData = new FormData(addStockForm);
        const productId = formData.get('product_id');
        const jumlahStok = formData.get('jumlah_stok');

        if (!productId || !jumlahStok) {
            alert('Pilih produk dan masukkan jumlah stok!');
            return;
        }

        fetch(`/products/${productId}/add-stock`, { // Buat route ini di web.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                jumlah: jumlahStok
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Stok berhasil ditambahkan!');
                addStockModal.hide();
                addStockForm.reset();
                // Refresh halaman jika perlu
                window.location.reload();
            } else {
                alert('Gagal menambahkan stok.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan.');
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/products/create.blade.php ENDPATH**/ ?>