<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FruitPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceController extends Controller
{
    /**
     * Show the price editing form.
     */
    public function index(): View
    {
        $prices = FruitPrice::whereIn('fruit', FruitPrice::EDITABLE_FRUITS)
            ->get()
            ->keyBy('fruit');

        return view('admin.prices.index', [
            'prices' => $prices,
        ]);
    }

    /**
     * Update the editable fruit prices.
     */
    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (FruitPrice::EDITABLE_FRUITS as $fruit) {
            $rules[$fruit] = ['required', 'numeric', 'min:0'];
        }

        $validated = $request->validate($rules);

        foreach (FruitPrice::EDITABLE_FRUITS as $fruit) {
            FruitPrice::updateOrCreate(
                ['fruit' => $fruit],
                ['price' => $validated[$fruit]]
            );
        }

        return back()->with('success', 'Harga buah berhasil diperbarui.');
    }
}
