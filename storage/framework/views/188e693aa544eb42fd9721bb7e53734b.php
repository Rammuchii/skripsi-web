<section id="how-to-use" class="section">

    <div class="container">

        <div class="text-center mb-5">

            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                Panduan
            </span>

            <h2 class="fw-bold mt-3">
                Cara Penggunaan
            </h2>

            <p class="text-secondary col-lg-6 mx-auto">
                Ikuti 4 langkah berikut untuk mendapatkan hasil klasifikasi buah beserta
                estimasi harganya.
            </p>

        </div>

        <div class="row g-4">

            <?php
                $steps = [
                    [
                        'icon' => 'bi-cloud-arrow-up',
                        'title' => '1. Upload atau Foto',
                        'desc' => 'Unggah gambar buah dari perangkat, atau gunakan tombol kamera untuk memotret buah secara langsung.',
                        'image' => 'images/guide/step-1-upload.png',
                    ],
                    [
                        'icon' => 'bi-speedometer2',
                        'title' => '2. Masukkan Berat',
                        'desc' => 'Isi berat buah dalam satuan kilogram (kg) pada kolom yang tersedia di samping gambar.',
                        'image' => 'images/guide/step-2-berat.png',
                    ],
                    [
                        'icon' => 'bi-cpu',
                        'title' => '3. Klik Predict Now',
                        'desc' => 'Gambar dikirim ke model AI (CNN) dan diproses secara real-time untuk diklasifikasikan.',
                        'image' => 'images/guide/step-3-predict.png',
                    ],
                    [
                        'icon' => 'bi-bar-chart-line',
                        'title' => '4. Lihat Hasil',
                        'desc' => 'Jenis buah, tingkat confidence, harga per kg, dan total harga langsung ditampilkan.',
                        'image' => 'images/guide/step-4-hasil.png',
                    ],
                ];
            ?>

            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="col-lg-3 col-md-6">

                    <div class="card feature-card h-100">

                        <div class="ratio ratio-4x3 bg-light rounded-top overflow-hidden">
                            <img
                                src="<?php echo e(file_exists(public_path($step['image'])) ? asset($step['image']) : 'https://placehold.co/400x300?text=Screenshot+' . urlencode($step['title'])); ?>"
                                alt="Screenshot <?php echo e($step['title']); ?>"
                                class="w-100 h-100"
                                style="object-fit: cover;">
                        </div>

                        <div class="card-body p-4">

                            <div class="feature-icon mb-3">
                                <i class="bi <?php echo e($step['icon']); ?>"></i>
                            </div>

                            <h5 class="fw-bold">
                                <?php echo e($step['title']); ?>

                            </h5>

                            <p class="text-secondary mb-0">
                                <?php echo e($step['desc']); ?>

                            </p>

                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>

</section>
<?php /**PATH C:\Users\Rama\OneDrive\Documents\Semester 8\Skripsi\skripsi-buah2\resources\views/partials/how-to-use.blade.php ENDPATH**/ ?>