<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\KKController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

// Route::get('/tampil', function () {
//     return view('admin.index');
// });

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');

    // KK Routes
    Route::resource('kk', KKController::class);

    // Additional routes for KK
    Route::get('kk/export', [KKController::class, 'export'])->name('kk.export');
    Route::post('kk/import', [KKController::class, 'import'])->name('kk.import');
});

require __DIR__ . '/auth.php';
