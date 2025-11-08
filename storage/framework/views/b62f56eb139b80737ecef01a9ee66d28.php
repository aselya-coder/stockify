

<?php $__env->startSection('title', 'Daftar Pengguna'); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">👥 Daftar Pengguna</h1>
            <p class="text-muted mb-0">Kelola pengguna dan hak akses mereka.</p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i> Tambah Pengguna
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold"><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-primary"><?php echo e($role->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($user->created_at->format('d M Y')); ?></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Belum ada data pengguna.
                                <br>
                                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Pengguna Pertama
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\stockify\resources\views/admin/users/index.blade.php ENDPATH**/ ?>