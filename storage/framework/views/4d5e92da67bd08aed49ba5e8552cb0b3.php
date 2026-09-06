<section class="section" id="result">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">Hasil Prediksi</h2>

            <p class="text-muted">
                Hasil klasifikasi akan ditampilkan setelah proses prediksi selesai.
            </p>

        </div>

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-card">

                    <div class="card-body p-4">

                        <div class="text-center" id="resultSummaryEmpty">

                            <i class="bi bi-clipboard-data fs-1 text-success"></i>

                            <h3 class="mt-3 fw-bold">
                                Belum Ada Hasil
                            </h3>

                            <p class="text-muted">
                                Silakan unggah gambar dan klik tombol <strong>Prediksi</strong>.
                            </p>

                        </div>

                        <div class="text-center d-none" id="resultSummaryFilled">

                            <i class="bi bi-check-circle fs-1 text-success"></i>

                            <h3 class="mt-3 fw-bold">
                                Prediksi Selesai
                            </h3>

                            <p class="text-muted">
                                Berikut hasil klasifikasi gambar yang Anda unggah.
                            </p>

                        </div>

                        <hr>

                        <div class="row text-center">

                            <div class="col-md-4 mb-3">

                                <div class="stat-card">

                                    <h6 class="text-muted">Jenis Buah</h6>

                                    <h5 class="fw-bold" id="resultSectionFruit">-</h5>

                                </div>

                            </div>

                            <div class="col-md-4 mb-3">

                                <div class="stat-card">

                                    <h6 class="text-muted">Confidence</h6>

                                    <h5 class="fw-bold" id="resultSectionConfidence">-</h5>

                                </div>

                            </div>

                            <div class="col-md-4 mb-3">

                                <div class="stat-card">

                                    <h6 class="text-muted">Harga</h6>

                                    <h5 class="fw-bold" id="resultSectionPrice">-</h5>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section><?php /**PATH C:\Users\Rama\OneDrive\Documents\Semester 8\Skripsi\skripsi-buah2\resources\views/partials/result.blade.php ENDPATH**/ ?>