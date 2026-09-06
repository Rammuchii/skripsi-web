<section id="prediction" class="section">

    <div class="container">

        <div class="text-center mb-5">

            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                AI Prediction
            </span>

            <h2 class="fw-bold mt-3">
                Try FruitVision AI
            </h2>

            <p class="text-secondary col-lg-6 mx-auto">
                Upload gambar buah atau gunakan kamera, kemudian masukkan berat buah untuk mendapatkan hasil klasifikasi dan estimasi harga.
            </p>

        </div>

        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card shadow-card">

                    <div class="card-body p-5">

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

                        <div id="predictAlert" class="d-none"></div>

                        <form id="predictForm" action="<?php echo e(route('predict')); ?>" method="POST" enctype="multipart/form-data">

                            <?php echo csrf_field(); ?>

                            <div
                                id="dropArea"
                                class="text-center p-5 mb-4">

                                <i class="bi bi-cloud-arrow-up display-4 text-success"></i>

                                <h4 class="fw-bold mt-3">
                                    Drag & Drop Image
                                </h4>

                                <p class="text-secondary">
                                    atau pilih gambar dari perangkat
                                </p>

                                <input
                                    type="file"
                                    id="imageInput"
                                    name="image"
                                    class="form-control"
                                    accept="image/*">

                                
                                <input
                                    type="hidden"
                                    id="cameraImage"
                                    name="camera_image">

                                <button
                                    type="button"
                                    id="openCamera"
                                    class="btn btn-outline-success mt-3">

                                    <i class="bi bi-camera me-2"></i>

                                    Open Camera

                                </button>

                            </div>

                            <div class="row g-4">

                                <div class="col-lg-6">

                                    <?php if(session('image')): ?>

                                        <img
                                            id="previewImage"
                                            src="<?php echo e(asset('storage/' . session('image'))); ?>"
                                            class="img-fluid rounded-4 border">

                                    <?php else: ?>

                                        <img
                                            id="previewImage"
                                            src="https://placehold.co/700x500?text=Preview+Image"
                                            class="img-fluid rounded-4 border">

                                    <?php endif; ?>

                                    <div
                                        id="cameraSection"
                                        class="d-none mt-4">

                                        <video
                                            id="camera"
                                            autoplay
                                            playsinline
                                            class="img-fluid rounded-4 border">
                                        </video>

                                        <canvas
                                            id="canvas"
                                            class="d-none">
                                        </canvas>

                                        <button
                                            type="button"
                                            id="captureImage"
                                            class="btn btn-success w-100 mt-3">

                                            <i class="bi bi-camera-fill me-2"></i>

                                            Capture Image

                                        </button>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Berat Buah (Kg)
                                        </label>

                                        <input
                                            type="number"
                                            name="weight"
                                            class="form-control"
                                            step="0.01"
                                            min="0.01"
                                            value="<?php echo e(old('weight', session('weight'))); ?>"
                                            placeholder="0.50"
                                            required>

                                    </div>

                                    <button
                                        type="submit"
                                        id="predictBtn"
                                        class="btn btn-success w-100 py-3">

                                        <span id="predictBtnText">Predict Now</span>

                                    </button>

                                    <div id="predictProgress" class="progress mt-3 d-none" style="height:6px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:100%"></div>
                                    </div>

                                    <button
                                        type="button"
                                        id="resetPredictBtn"
                                        class="btn btn-outline-success w-100 py-2 mt-3 d-none">

                                        <i class="bi bi-arrow-repeat me-2"></i>

                                        Prediksi Lagi

                                    </button>

                                    <hr class="my-4">

                                    <div class="mb-3">

                                        <small class="text-secondary">
                                            Fruit
                                        </small>

                                        <h3 class="fw-bold text-success" id="resultFruit">

                                            <?php echo e(session('fruit','-')); ?>


                                        </h3>

                                    </div>

                                    <div class="mb-4">

                                        <div class="d-flex justify-content-between">

                                            <span>
                                                Confidence
                                                <i class="bi bi-info-circle text-secondary ms-1"
                                                   data-bs-toggle="tooltip"
                                                   title="Confidence menunjukkan seberapa yakin model AI terhadap hasil klasifikasi ini. Semakin tinggi persentasenya, semakin yakin sistem terhadap jenis buah yang terdeteksi."></i>
                                            </span>

                                            <span id="resultConfidenceText">

                                                <?php echo e(session('confidence',0)); ?>%

                                            </span>

                                        </div>

                                        <div class="progress mt-2">

                                            <div
                                                id="resultConfidenceBar"
                                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                style="width: <?php echo e(session('confidence',0)); ?>%;">

                                                <?php echo e(session('confidence',0)); ?>%

                                            </div>

                                        </div>

                                        <small class="text-secondary d-block mt-1">
                                            Persentase keyakinan model AI terhadap jenis buah yang terdeteksi.
                                        </small>

                                    </div>

                                    <div class="row g-3">

                                        <div class="col-6">

                                            <div class="stat-card">

                                                <small class="text-secondary">

                                                    Price / Kg

                                                </small>

                                                <h5 class="fw-bold text-success mt-2" id="resultPricePerKg">

                                                    Rp <?php echo e(number_format(session('pricePerKg',0),0,',','.')); ?>


                                                </h5>

                                            </div>

                                        </div>

                                        <div class="col-6">

                                            <div class="stat-card">

                                                <small class="text-secondary">

                                                    Total Price

                                                </small>

                                                <h5 class="fw-bold text-success mt-2" id="resultTotalPrice">

                                                    Rp <?php echo e(number_format(session('totalPrice',0),0,',','.')); ?>


                                                </h5>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section><?php /**PATH C:\Users\Rama\OneDrive\Documents\Semester 8\Skripsi\skripsi-buah2\resources\views/partials/prediction.blade.php ENDPATH**/ ?>