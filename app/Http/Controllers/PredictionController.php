<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PredictionController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function predict(Request $request)
    {
        try {

            $request->validate([
                'weight' => 'required|numeric|min:0.01'
            ]);

            $imagePath = null;
            $fullPath = null;

            /*
            |--------------------------------------------------------------------------
            | Upload File
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);

                $imagePath = $request->file('image')->store('uploads', 'public');

                $fullPath = storage_path('app/public/' . $imagePath);
            }

            /*
            |--------------------------------------------------------------------------
            | Camera (Base64)
            |--------------------------------------------------------------------------
            */

            elseif ($request->filled('camera_image')) {

                $base64 = preg_replace(
                    '/^data:image\/\w+;base64,/',
                    '',
                    $request->camera_image
                );

                $image = base64_decode($base64);

                $imagePath = 'uploads/' . time() . '.png';

                Storage::disk('public')->put($imagePath, $image);

                $fullPath = storage_path('app/public/' . $imagePath);
            }

            else {

                return response()->json([
                    'success' => false,
                    'message' => 'Silakan upload gambar atau gunakan kamera.'
                ], 422);

            }

            /*
            |--------------------------------------------------------------------------
            | Flask API
            |--------------------------------------------------------------------------
            */

            try {

                $response = Http::timeout(60)
                    ->attach(
                        'image',
                        file_get_contents($fullPath),
                        basename($fullPath)
                    )
                    ->post(config('services.flask.url'));

            } catch (\Illuminate\Http\Client\ConnectionException $e) {

                Storage::disk('public')->delete($imagePath);

                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat terhubung ke Flask API. Pastikan server AI sedang berjalan.'
                ], 502);

            }

            if (!$response->successful()) {

                Storage::disk('public')->delete($imagePath);

                $flaskMessage = $response->json('message');

                return response()->json([
                    'success' => false,
                    'message' => $flaskMessage
                        ?: 'Flask API mengembalikan error (HTTP ' . $response->status() . ').'
                ], 502);

            }

            $result = $response->json();

            if (!is_array($result) || !isset($result['fruit'])) {

                Storage::disk('public')->delete($imagePath);

                return response()->json([
                    'success' => false,
                    'message' => 'Format respons dari Flask API tidak sesuai (field "fruit" tidak ditemukan).'
                ], 502);

            }

            $fixedPrices = [
                'nonfruit' => 0,
            ];

            $fruit = $result['fruit'];

            if (array_key_exists($fruit, $fixedPrices)) {
                $pricePerKg = $fixedPrices[$fruit];
            } else {
                $pricePerKg = optional(
                    \App\Models\FruitPrice::where('fruit', $fruit)->first()
                )->price ?? 0;
            }

            $weight = (float) $request->weight;

            $totalPrice = $pricePerKg * $weight;

            $confidence = $result['confidence'] ?? 0;

            \App\Models\Prediction::create([
                'fruit' => $fruit,
                'confidence' => $confidence,
                'weight' => $weight,
                'price_per_kg' => $pricePerKg,
                'total_price' => $totalPrice,
                'image_path' => $imagePath,
            ]);

            return response()->json([

                'success' => true,

                'fruit' => ucfirst($fruit),

                'confidence' => $confidence,

                'weight' => $weight,

                'pricePerKg' => $pricePerKg,

                'totalPrice' => $totalPrice,

                'image' => url('/media/' . $imagePath)

            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([

                'success' => false,

                'message' => 'Data yang dikirim tidak valid.',

                'errors' => $e->errors()

            ], 422);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()

            ], 500);

        }
    }
}