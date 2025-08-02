<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\KKController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistikPertumbuhanController;
use Illuminate\Support\Facades\Route;

// Public routes
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

// User dashboard (untuk semua user yang sudah login dan verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

// Routes untuk authenticated users (user & admin bisa akses profile)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');

    // Admin Routes dengan prefix 'admin'
    Route::prefix('admin')->name('admin.')->group(function () {

        // KK Routes
        Route::resource('kk', KKController::class);
        Route::get('kk/export', [KKController::class, 'export'])->name('kk.export');
        Route::post('kk/import', [KKController::class, 'import'])->name('kk.import');

        // Penduduk Routes
        Route::resource('penduduk', PendudukController::class);
        Route::get('penduduk-print', [PendudukController::class, 'print'])->name('penduduk.print');
        Route::get('penduduk-export', [PendudukController::class, 'export'])->name('penduduk.export');
        Route::post('penduduk-bulk-action', [PendudukController::class, 'bulkAction'])->name('penduduk.bulk-action');
        Route::get('penduduk-statistics', [PendudukController::class, 'statistics'])->name('penduduk.statistics');

        // Routes untuk Statistik Pertumbuhan
        Route::prefix('statistik')->name('statistik.')->group(function () {
            Route::get('/pertumbuhan', [StatistikPertumbuhanController::class, 'index'])
                ->name('pertumbuhan');

            Route::get('/pertumbuhan/export', [StatistikPertumbuhanController::class, 'export'])
                ->name('pertumbuhan.export');

            Route::get('/pertumbuhan/print', [StatistikPertumbuhanController::class, 'print'])
                ->name('pertumbuhan.print');

            Route::get('/pertumbuhan/chart-data', [StatistikPertumbuhanController::class, 'getChartData'])
                ->name('pertumbuhan.chart-data');
        });
    });
});

require __DIR__ . '/auth.php';
