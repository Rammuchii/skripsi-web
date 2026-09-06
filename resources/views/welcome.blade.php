<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Klasifikasi Buah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }

        .card{
            border:none;
            border-radius:18px;
        }

        .card-header{
            border-radius:18px 18px 0 0 !important;
        }

        img{
            border-radius:10px;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="card shadow-lg">

        <div class="card-header bg-success text-white text-center py-4">

            <h2>
                🍎 Sistem Klasifikasi Buah Menggunakan CNN
            </h2>

            <p class="mb-0">
                Implementasi CNN Terintegrasi dengan Perhitungan Harga Berdasarkan Berat
            </p>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <h4>Upload Gambar</h4>

                    <input
                        type="file"
                        class="form-control"
                    >

                    <div class="mt-4 text-center">

                        <img
                            src="https://placehold.co/350x250?text=Preview+Gambar"
                            class="img-fluid border"
                        >

                    </div>

                </div>

                <div class="col-md-6">

                    <h4>Hasil Prediksi</h4>

                    <table class="table">

                        <tr>
                            <th>Jenis Buah</th>
                            <td>-</td>
                        </tr>

                        <tr>
                            <th>Confidence</th>
                            <td>-</td>
                        </tr>

                        <tr>
                            <th>Berat (Kg)</th>
                            <td>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Masukkan berat"
                                >
                            </td>
                        </tr>

                        <tr>
                            <th>Harga/Kg</th>
                            <td>-</td>
                        </tr>

                        <tr>
                            <th>Total Harga</th>
                            <td>-</td>
                        </tr>

                    </table>

                    <button class="btn btn-success w-100">
                        Prediksi Buah
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>