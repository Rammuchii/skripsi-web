<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\HistoryController;

Route::get('/', [PredictionController::class, 'index']);

Route::post('/predict', [PredictionController::class, 'predict'])
    ->name('predict');

/*
|--------------------------------------------------------------------------
| Stored images (served directly, doesn't rely on the public/storage symlink)
|--------------------------------------------------------------------------
| Deliberately NOT using the /storage/... URL space: php artisan serve's
| built-in dev server checks for a matching static file/symlink at that
| exact path BEFORE Laravel routing ever runs. If that symlink is broken
| (common on Windows), the request 404s right there and never reaches this
| file — so this route would never fire. Using /media/... avoids any
| collision with that symlink entirely.
*/

Route::get('/media/{path}', function (string $path) {

    $fullPath = storage_path('app/public/' . $path);

    if (!is_file($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);

})->where('path', '.*')->name('media.show');

/*
|--------------------------------------------------------------------------
| Auth (admin only, no public registration)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/prices', [PriceController::class, 'index'])->name('prices');
    Route::post('/prices', [PriceController::class, 'update'])->name('prices.update');

    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/history/export', [HistoryController::class, 'export'])->name('history.export');
    Route::delete('/history/{prediction}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::delete('/history', [HistoryController::class, 'destroyAll'])->name('history.destroyAll');

});

/*
|--------------------------------------------------------------------------
| TEMPORARY: reset admin password lewat browser (hapus setelah dipakai!)
|--------------------------------------------------------------------------
*/

Route::get('/reset-admin-password-x7f2q/{newPassword}', function (string $newPassword) {

    $user = \App\Models\User::where('username', 'admin')->first();

    if (!$user) {
        return 'User admin tidak ditemukan.';
    }

    $user->password = $newPassword;
    $user->save();

    return 'Password admin berhasil diubah menjadi: ' . $newPassword;

});
