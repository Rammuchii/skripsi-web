<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HistoryController extends Controller
{
    /**
     * Fruit classes that can appear in the history filter dropdown.
     */
    private const FRUITS = ['apple', 'banana', 'mango', 'nonfruit', 'orange', 'pineapple', 'strawberry'];

    /**
     * Show a paginated, filterable list of past predictions.
     */
    public function index(Request $request): View
    {
        $predictions = $this->filteredQuery($request)
            ->paginate(15)
            ->appends($request->query());

        return view('admin.history.index', [
            'predictions' => $predictions,
            'fruits' => self::FRUITS,
        ]);
    }

    /**
     * Export the (optionally filtered) history as a CSV file.
     */
    public function export(Request $request): StreamedResponse
    {
        $predictions = $this->filteredQuery($request)->get();

        $filename = 'riwayat-prediksi-' . now()->format('Y-m-d_His') . '.csv';

        $callback = function () use ($predictions) {

            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel reads accented/special characters correctly
            fwrite($handle, "\xEF\xBB\xBF");

            // Tells Excel explicitly which character separates columns.
            // Without this, Excel with Indonesian regional settings (which
            // use "," as the decimal separator) misreads a comma-separated
            // file and dumps everything into a single column.
            fwrite($handle, "sep=;\r\n");

            fputcsv($handle, [
                'Buah', 'Confidence (%)', 'Berat (kg)', 'Harga/Kg', 'Total Harga', 'Tanggal', 'Jam',
            ], ';');

            foreach ($predictions as $prediction) {
                fputcsv($handle, [
                    ucfirst($prediction->fruit),
                    $prediction->confidence,
                    $prediction->weight,
                    $prediction->price_per_kg,
                    $prediction->total_price,
                    $prediction->created_at->format('Y-m-d'),
                    $prediction->created_at->format('H:i:s'),
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Delete a single prediction record (and its stored image, if any).
     */
    public function destroy(Prediction $prediction): RedirectResponse
    {
        if ($prediction->image_path) {
            Storage::disk('public')->delete($prediction->image_path);
        }

        $prediction->delete();

        return back()->with('success', 'Riwayat prediksi berhasil dihapus.');
    }

    /**
     * Delete all prediction records (and their stored images).
     */
    public function destroyAll(): RedirectResponse
    {
        Prediction::chunkById(100, function ($predictions) {
            foreach ($predictions as $prediction) {
                if ($prediction->image_path) {
                    Storage::disk('public')->delete($prediction->image_path);
                }

                $prediction->delete();
            }
        });

        return back()->with('success', 'Semua riwayat prediksi berhasil dihapus.');
    }

    /**
     * Build the predictions query with fruit + date range filters applied.
     */
    private function filteredQuery(Request $request)
    {
        $query = Prediction::query()->orderByDesc('created_at');

        if ($request->filled('fruit') && in_array($request->query('fruit'), self::FRUITS, true)) {
            $query->where('fruit', $request->query('fruit'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->query('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->query('date_to'));
        }

        return $query;
    }
}