<?php $__env->startSection('content'); ?>

    <section class="section">

        <div class="container" style="max-width: 720px;">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h3 class="fw-bold mb-0">Kelola Harga Buah</h3>
                    <p class="text-muted mb-0">Harga per kilogram untuk masing-masing jenis buah.</p>
                </div>

                <div class="d-flex gap-2">

                    <a href="<?php echo e(route('admin.history')); ?>" class="btn btn-outline-success">
                        <i class="bi bi-clock-history me-1"></i> History
                    </a>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>

                </div>

            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card shadow-card p-4 p-md-5">

                <form method="POST" action="<?php echo e(route('admin.prices.update')); ?>">

                    <?php echo csrf_field(); ?>

                    <?php $__currentLoopData = \App\Models\FruitPrice::EDITABLE_FRUITS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fruit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="mb-3">

                            <label for="<?php echo e($fruit); ?>" class="form-label fw-semibold text-capitalize">
                                <?php echo e($fruit); ?> (Rp / Kg)
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="1"
                                name="<?php echo e($fruit); ?>"
                                id="<?php echo e($fruit); ?>"
                                class="form-control"
                                value="<?php echo e(old($fruit, optional($prices->get($fruit))->price ?? 0)); ?>"
                                required>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <p class="text-muted small">
                        Kelas <strong>Non-Fruit</strong> memiliki harga tetap (Rp 0) dan tidak dapat diubah.
                    </p>

                    <button type="submit" class="btn btn-success w-100 py-2 mt-2">
                        Simpan Perubahan
                    </button>

                </form>

            </div>

        </div>

    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rama\OneDrive\Documents\Semester 8\Skripsi\skripsi-buah2\resources\views/admin/prices/index.blade.php ENDPATH**/ ?>