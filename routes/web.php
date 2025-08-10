<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KKController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\StatistikPertumbuhanController;
use App\Http\Controllers\StrukturDesaController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Di routes/web.php, tambahkan:
Route::get('/berita/rss-info', function () {
    return view('public.berita.rss-info');
})->name('berita.rss-info');
// Route::get('/tampil', function () {
//     return view('admin.index');
// });
//Berita routes (public)
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [PublicBeritaController::class, 'index'])->name('index');
    Route::get('/search', [PublicBeritaController::class, 'search'])->name('search');
    Route::get('/popular', [PublicBeritaController::class, 'popular'])->name('popular');
    Route::get('/latest', [PublicBeritaController::class, 'latest'])->name('latest');
    Route::get('/featured', [PublicBeritaController::class, 'featured'])->name('featured');
    Route::get('/categories', [PublicBeritaController::class, 'categories'])->name('categories');
    Route::get('/archive', [PublicBeritaController::class, 'archive'])->name('archive');
    Route::get('/rss', [PublicBeritaController::class, 'rss'])->name('rss');
    Route::get('/sitemap.xml', [PublicBeritaController::class, 'sitemap'])->name('sitemap');
    Route::get('/kategori/{slug}', [PublicBeritaController::class, 'kategori'])->name('kategori');
    Route::get('/{slug}', [PublicBeritaController::class, 'show'])->name('show');
});
// API endpoints untuk AJAX
Route::prefix('api/berita')->name('api.berita.')->group(function () {
    Route::get('/search', [PublicBeritaController::class, 'search'])->name('search');
    Route::get('/popular', [PublicBeritaController::class, 'popular'])->name('popular');
    Route::get('/latest', [PublicBeritaController::class, 'latest'])->name('latest');
    Route::get('/featured', [PublicBeritaController::class, 'featured'])->name('featured');
    Route::get('/categories', [PublicBeritaController::class, 'categories'])->name('categories');
});

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

Route::get('/sturktur-desa', [StrukturDesaController::class, 'publicStructure'])->name('struktur-desa.public');

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
        Route::get('kk/export', [KKController::class, 'export'])->name('kk.export');
        Route::post('kk/import', [KKController::class, 'import'])->name('kk.import');
        Route::get('kk-template', [KKController::class, 'downloadTemplate'])->name('kk.template');
        Route::get('kk-import-errors', [KKController::class, 'showImportErrors'])->name('kk.import-errors');
        Route::resource('kk', KKController::class);


        // Penduduk Routes
        Route::resource('penduduk', PendudukController::class);
        Route::get('penduduk-print', [PendudukController::class, 'print'])->name('penduduk.print');
        Route::get('penduduk-export', [PendudukController::class, 'export'])->name('penduduk.export');
        Route::get('penduduk-template', [PendudukController::class, 'downloadTemplate'])->name('penduduk.template');
        Route::get('penduduk-import-errors', [PendudukController::class, 'showImportErrors'])->name('penduduk.import-errors');
        Route::post('penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
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

        // Berita Management Routes
        Route::resource('berita', BeritaController::class);

        // Additional berita routes
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::post('/bulk-action', [BeritaController::class, 'bulkAction'])->name('bulk-action');
            Route::get('/{slug}/duplicate', [BeritaController::class, 'duplicate'])->name('duplicate');
            Route::post('/{slug}/toggle-featured', [BeritaController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{slug}/toggle-publish', [BeritaController::class, 'togglePublish'])->name('toggle-publish');
            Route::get('/export', [BeritaController::class, 'export'])->name('export');
            Route::get('/statistics', [BeritaController::class, 'statistics'])->name('statistics');
        });

        // Kategori Berita Management Routes
        Route::resource('kategori-berita', KategoriBeritaController::class);

        // Additional kategori berita routes - FIXED
        Route::prefix('kategori-berita')->name('kategori-berita.')->group(function () {
            // Bulk action route
            Route::post('/bulk-action', [KategoriBeritaController::class, 'bulkAction'])->name('bulk-action');

            // Toggle active route - FIXED method
            Route::patch('/{kategori:slug}/toggle-active', [KategoriBeritaController::class, 'toggleActive'])->name('toggle-active');

            // Update urutan route
            Route::post('/update-urutan', [KategoriBeritaController::class, 'updateUrutan'])->name('update-urutan');

            // Statistics route
            Route::get('/statistics', [KategoriBeritaController::class, 'statistics'])->name('statistics');
        });

        // API endpoints untuk admin
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/kategori-berita/list', [KategoriBeritaController::class, 'getKategoriList'])->name('kategori-berita.list');
        });
        Route::resource('struktur-desa', StrukturDesaController::class);
        Route::post('struktur-desa/{struktur_desa}/toggle-status', [StrukturDesaController::class, 'toggleStatus'])->name('struktur-desa.toggle-status');
        Route::post('struktur-desa-bulk-action', [StrukturDesaController::class, 'bulkAction'])->name('struktur-desa.bulk-action');
        Route::get('struktur-desa-export', [StrukturDesaController::class, 'export'])->name('struktur-desa.export');
        Route::get('struktur-desa-print', [StrukturDesaController::class, 'print'])->name('struktur-desa.print');


        Route::prefix('arsip-surat')->name('arsip-surat.')->group(function () {
            Route::get('/', [ArsipSuratController::class, 'index'])->name('index');
            Route::get('/create', [ArsipSuratController::class, 'create'])->name('create');
            Route::post('/', [ArsipSuratController::class, 'store'])->name('store');
            Route::get('/{arsipSurat}', [ArsipSuratController::class, 'show'])->name('show');
            Route::get('/{arsipSurat}/edit', [ArsipSuratController::class, 'edit'])->name('edit');
            Route::put('/{arsipSurat}', [ArsipSuratController::class, 'update'])->name('update');
            Route::delete('/{arsipSurat}', [ArsipSuratController::class, 'destroy'])->name('destroy');

            // Extra routes
            Route::get('/ajax/generate-nomor', [ArsipSuratController::class, 'generateNomor'])->name('generate-nomor');
            Route::get('/page/statistik', [ArsipSuratController::class, 'statistik'])->name('statistik');
            Route::get('/action/export', [ArsipSuratController::class, 'export'])->name('export');
            Route::get('/page/import', [ArsipSuratController::class, 'showImport'])->name('show-import');
            Route::post('/action/import', [ArsipSuratController::class, 'import'])->name('import');
        });
    });
});

// Redirect old berita URLs (jika ada)
Route::redirect('/news', '/berita', 301);
Route::redirect('/news/{slug}', '/berita/{slug}', 301);

// Redirect kategori lama (jika ada)
Route::redirect('/category/{slug}', '/berita/kategori/{slug}', 301);

require __DIR__ . '/auth.php';
