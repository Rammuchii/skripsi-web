# FruitVision Flask API

API klasifikasi gambar buah yang dipanggil oleh backend Laravel (`PredictionController@predict`)
lewat `FLASK_API_URL` (default `http://127.0.0.1:5000/predict`, lihat `.env` di root project Laravel).

## Menjalankan

```bash
cd flask-api
python3 -m venv venv
source venv/bin/activate      # Windows: venv\Scripts\activate
pip install -r requirements.txt
python app.py
```

Server akan berjalan di `http://127.0.0.1:5000`. Jalankan berbarengan dengan `php artisan serve`
di root project Laravel (dua terminal terpisah).

## Endpoint

- `GET /health` — cek server hidup, balas `{"success": true, "message": "Flask API is running."}`.
- `POST /predict` — terima file `image` (multipart/form-data), balas:
  ```json
  { "success": true, "fruit": "banana", "confidence": 98.42 }
  ```
  `fruit` adalah salah satu dari: `banana`, `mango`, `nonfruit`, `orange`, `other` — daftar ini
  **harus sama persis** dengan array `$prices` di `PredictionController.php` pada sisi Laravel.

## Catatan

- Urutan `class_names` di `app.py` harus sama persis dengan urutan `class_indices` saat training
  model (`skripsi.keras`). Jika urutan ini salah, prediksi akan salah label meski confidence tinggi.
- Model menerima input gambar `128x128x3` (RGB) — sudah dicek cocok dengan `skripsi.keras`.
- `debug=True` di `app.run()` cocok untuk pengembangan/demo skripsi. Matikan (`debug=False`) kalau
  nanti di-deploy ke server publik.
