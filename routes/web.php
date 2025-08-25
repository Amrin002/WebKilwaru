<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KKController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\StatistikPertumbuhanController;
use App\Http\Controllers\StrukturDesaController;
use App\Http\Controllers\SuratDashboardController;
use App\Http\Controllers\SuratKtmController;
use App\Http\Controllers\SuratKtuController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifikasiSuratController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// ========================================
// QR CODE & VERIFIKASI ROUTES (Public)
// ========================================
// Halaman verifikasi utama (untuk scan QR code)
Route::get('/verifikasi/{nomorSurat}', [VerifikasiSuratController::class, 'verify'])
    ->name('verifikasi.surat')
    ->where('nomorSurat', '[A-Za-z0-9\-\/]+'); // Allow nomor surat format

// QR Code public routes
Route::prefix('qr-code')->name('qr-code.')->group(function () {
    // Preview QR Code
    Route::get('{nomorSurat}/preview', [QrCodeController::class, 'preview'])
        ->name('preview');

    // Download QR Code sebagai file
    Route::get('{nomorSurat}/download', [QrCodeController::class, 'download'])
        ->name('download');

    // Embed QR Code untuk iframe/widget
    Route::get('{nomorSurat}/embed', [QrCodeController::class, 'embed'])
        ->name('embed');

    // Validasi QR Code integrity
    Route::get('{nomorSurat}/validate', [QrCodeController::class, 'validate'])
        ->name('validate');
});

// ========================================
// BERITA ROUTES (Public)
// ========================================
Route::get('/berita/rss-info', function () {
    return view('public.berita.rss-info');
})->name('berita.rss-info');

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

// API endpoints untuk AJAX berita
Route::prefix('api/berita')->name('api.berita.')->group(function () {
    Route::get('/search', [PublicBeritaController::class, 'search'])->name('search');
    Route::get('/popular', [PublicBeritaController::class, 'popular'])->name('popular');
    Route::get('/latest', [PublicBeritaController::class, 'latest'])->name('latest');
    Route::get('/featured', [PublicBeritaController::class, 'featured'])->name('featured');
    Route::get('/categories', [PublicBeritaController::class, 'categories'])->name('categories');
});

// ========================================
// APBDES ROUTES (Public)
// ========================================
Route::prefix('apbdes')->name('apbdes.')->group(function () {

    // Landing page APBDes (tahun terbaru)
    Route::get('/', [ApbdesController::class, 'index'])->name('index');

    // Detail APBDes per tahun
    Route::get('/{tahun}', [ApbdesController::class, 'show'])->name('show')
        ->where('tahun', '[0-9]{4}'); // Validasi tahun 4 digit

    // API endpoint untuk AJAX get data by year
    Route::get('/api/{tahun}', [ApbdesController::class, 'getByYear'])->name('api.get-by-year')
        ->where('tahun', '[0-9]{4}');

    // Download PDF dokumen APBDes
    Route::get('/{apbdes}/download-pdf', [ApbdesController::class, 'downloadPdf'])->name('download-pdf');
});


// Landing page untuk semua layanan surat
Route::get('/surat', function () {
    return view('public.surat.index');
})->name('public.surat.index');

// ========================================
// SURAT KTM - GUEST ROUTES (Public - Landing Page)
// ========================================
Route::prefix('surat-ktm')->name('public.surat-ktm.')->group(function () {
    // Form pengajuan untuk guest
    Route::get('/', [SuratKtmController::class, 'indexPublic'])
        ->name('index');

    Route::get('pengajuan', [SuratKtmController::class, 'guestForm'])
        ->name('form');

    // Submit pengajuan guest
    Route::post('pengajuan', [SuratKtmController::class, 'guestStore'])
        ->name('store');

    // Track surat dengan token
    Route::get('track/{token}', [SuratKtmController::class, 'guestTrack'])
        ->name('track');

    // Update data surat via token
    Route::put('track/{token}', [SuratKtmController::class, 'guestUpdate'])
        ->name('update');

    // API untuk mencari surat berdasarkan token
    Route::post('api/track', [SuratKtmController::class, 'apiTrackSurat'])
        ->name('api.track');

    // Download surat yang sudah disetujui via token
    Route::get('download/{id}/{token}', [SuratKtmController::class, 'download'])
        ->name('download');

    // Export PDF surat via token
    Route::get('export/{id}/{token}', [SuratKtmController::class, 'export'])
        ->name('export');
});

// ========================================
// SURAT KTU - GUEST ROUTES (Public - Landing Page) - BARU DITAMBAHKAN
// ========================================
Route::prefix('surat-ktu')->name('public.surat-ktu.')->group(function () {
    // Form pengajuan untuk guest (Landing Page)
    Route::get('/', [SuratKtuController::class, 'indexPublic'])
        ->name('index');

    Route::get('pengajuan', [SuratKtuController::class, 'guestForm'])
        ->name('form');

    // Submit pengajuan guest
    Route::post('pengajuan', [SuratKtuController::class, 'guestStore'])
        ->name('store');

    // Track surat dengan token
    Route::get('track/{token}', [SuratKtuController::class, 'guestTrack'])
        ->name('track');

    // Update data surat via token
    Route::put('track/{token}', [SuratKtuController::class, 'guestUpdate'])
        ->name('update');

    // API untuk mencari surat berdasarkan token (AJAX)
    Route::post('api/track', [SuratKtuController::class, 'apiTrackSurat'])
        ->name('api.track');

    // Download surat yang sudah disetujui via token
    Route::get('download/{id}/{token}', [SuratKtuController::class, 'download'])
        ->name('download');

    // Export PDF surat via token
    Route::get('export/{id}/{token}', [SuratKtuController::class, 'export'])
        ->name('export');
});

// Static pages
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/struktur-desa', [StrukturDesaController::class, 'publicStructure'])->name('struktur-desa.public');

// ===== PUBLIC ROUTES =====
Route::group(['prefix' => 'galeri'], function () {
    // Halaman utama galeri
    Route::get('/', [GaleriController::class, 'publicIndex'])->name('public.galeri.index');

    // Detail foto galeri
    Route::get('/{id}', [GaleriController::class, 'publicShow'])
        ->where('id', '[0-9]+')
        ->name('public.galeri.show');

    // Search API untuk live search
    Route::get('/search/api', [GaleriController::class, 'search'])->name('galeri.search');
});

Route::prefix('umkm')->name('umkm.')->group(function () {
    // Rute-rute spesifik harus diletakkan di atas rute umum
    Route::get('/daftar', [UmkmController::class, 'create'])->name('create');
    Route::post('/daftar', [UmkmController::class, 'store'])->name('store');
    Route::get('/sukses/{id}', [UmkmController::class, 'success'])->name('success');
    Route::match(['get', 'post'], '/track', [UmkmController::class, 'track'])->name('track');
    // Rute show detail untuk pembeli (hanya yang sudah approved)
    Route::get('/produk/{id}', [UmkmController::class, 'publicProductShow'])
        ->name('productShow')
        ->where('id', '[0-9]+');


    // Rute umum dengan parameter dinamis diletakkan paling bawah
    Route::get('/', [UmkmController::class, 'publicIndex'])->name('index');
    Route::get('/{id}', [UmkmController::class, 'publicShow'])->name('show');
});

// User dashboard (untuk semua user yang sudah login dan verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

// ========================================
// AUTHENTICATED USER ROUTES
// ========================================
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================================
    // SURAT KTM - USER ROUTES (Login Required)
    // ========================================
    Route::prefix('user/surat-ktm')->name('user.surat-ktm.')->group(function () {
        // Dashboard user - daftar surat milik user
        Route::get('/', [SuratKtmController::class, 'userIndex'])
            ->name('index');

        // Form pengajuan surat baru
        Route::get('create', [SuratKtmController::class, 'userForm'])
            ->name('create');

        // Submit pengajuan user
        Route::post('/', [SuratKtmController::class, 'userStore'])
            ->name('store');

        // Detail surat milik user
        Route::get('{id}', [SuratKtmController::class, 'userShow'])
            ->name('show');

        // Edit surat milik user (hanya yang masih diproses)
        Route::get('{id}/edit', [SuratKtmController::class, 'userEdit'])
            ->name('edit');

        // Update surat milik user
        Route::put('{id}', [SuratKtmController::class, 'userUpdate'])
            ->name('update');

        // Download surat yang sudah disetujui
        Route::get('{id}/download', [SuratKtmController::class, 'download'])
            ->name('download');

        // Export PDF surat milik user
        Route::get('{id}/export', [SuratKtmController::class, 'export'])
            ->name('export');
    });

    // ========================================
    // SURAT KTU - USER ROUTES (Login Required) - DIPERBAIKI
    // ========================================
    Route::prefix('user/surat-ktu')->name('user.surat-ktu.')->group(function () {
        // Dashboard user - daftar surat milik user
        Route::get('/', [SuratKtuController::class, 'userIndex'])
            ->name('index');

        // Form pengajuan surat baru
        Route::get('create', [SuratKtuController::class, 'userForm'])
            ->name('create');

        // Submit pengajuan user
        Route::post('/', [SuratKtuController::class, 'userStore'])
            ->name('store');

        // Detail surat milik user
        Route::get('{id}', [SuratKtuController::class, 'userShow'])
            ->name('show');

        // Edit surat milik user (hanya yang masih diproses)
        Route::get('{id}/edit', [SuratKtuController::class, 'userEdit'])
            ->name('edit');

        // Update surat milik user
        Route::put('{id}', [SuratKtuController::class, 'userUpdate'])
            ->name('update');

        // Download surat yang sudah disetujui
        Route::get('{id}/download', [SuratKtuController::class, 'download'])
            ->name('download');

        // Export PDF surat milik user
        Route::get('{id}/export', [SuratKtuController::class, 'export'])
            ->name('export');

        // Download QR Code khusus untuk surat milik user
        Route::get('{id}/download-qr', [SuratKtuController::class, 'downloadQrCode'])
            ->name('download-qr');
    });
});

// ========================================
// ADMIN ROUTES
// ========================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');


    // Admin Routes dengan prefix 'admin'
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/surat-dashboard', [SuratDashboardController::class, 'index'])->name('surat.dashboard');
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

        // Galeri Routes
        Route::resource('galeri', GaleriController::class);
        // Additional admin routes
        Route::group(['prefix' => 'galeri'], function () {
            // Bulk operations
            Route::post('/bulk-delete', [GaleriController::class, 'bulkDelete'])->name('admin.galeri.bulk-delete');

            // Statistics and exports
            Route::get('/statistics/api', [GaleriController::class, 'getStatistics'])->name('admin.galeri.statistics');
            Route::get('/export', [GaleriController::class, 'export'])->name('admin.galeri.export');
        });

        // Berita Management Routes
        Route::resource('berita', BeritaController::class);
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
        Route::prefix('kategori-berita')->name('kategori-berita.')->group(function () {
            Route::post('/bulk-action', [KategoriBeritaController::class, 'bulkAction'])->name('bulk-action');
            Route::patch('/{kategori:slug}/toggle-active', [KategoriBeritaController::class, 'toggleActive'])->name('toggle-active');
            Route::post('/update-urutan', [KategoriBeritaController::class, 'updateUrutan'])->name('update-urutan');
            Route::get('/statistics', [KategoriBeritaController::class, 'statistics'])->name('statistics');
        });

        // API endpoints untuk admin
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/kategori-berita/list', [KategoriBeritaController::class, 'getKategoriList'])->name('kategori-berita.list');
        });

        // Struktur Desa Routes
        Route::resource('struktur-desa', StrukturDesaController::class);
        Route::post('struktur-desa/{struktur_desa}/toggle-status', [StrukturDesaController::class, 'toggleStatus'])->name('struktur-desa.toggle-status');
        Route::post('struktur-desa-bulk-action', [StrukturDesaController::class, 'bulkAction'])->name('struktur-desa.bulk-action');
        Route::get('struktur-desa-export', [StrukturDesaController::class, 'export'])->name('struktur-desa.export');
        Route::get('struktur-desa-print', [StrukturDesaController::class, 'print'])->name('struktur-desa.print');

        // ========================================
        // SURAT KTM - ADMIN ROUTES (Admin Only) - UPDATED WITH QR CODE
        // ========================================
        Route::prefix('surat-ktm')->name('surat-ktm.')->group(function () {
            // Dashboard admin - daftar semua surat
            Route::get('/', [SuratKtmController::class, 'adminIndex'])
                ->name('index');

            // Form create surat oleh admin
            Route::get('create', [SuratKtmController::class, 'adminCreate'])
                ->name('create');

            // Store surat oleh admin
            Route::post('/', [SuratKtmController::class, 'adminStore'])
                ->name('store');

            // Detail surat (admin view)
            Route::get('{id}', [SuratKtmController::class, 'adminShow'])
                ->name('show');

            // Edit surat oleh admin
            Route::get('{id}/edit', [SuratKtmController::class, 'adminEdit'])
                ->name('edit');

            // Update surat oleh admin
            Route::put('{id}', [SuratKtmController::class, 'adminUpdate'])
                ->name('update');

            // Update status surat (AJAX)
            Route::patch('{id}/update-status', [SuratKtmController::class, 'adminUpdateStatus'])
                ->name('update-status');

            // Delete surat
            Route::delete('{id}', [SuratKtmController::class, 'adminDestroy'])
                ->name('destroy');

            // Bulk actions
            Route::post('bulk-action', [SuratKtmController::class, 'adminBulkAction'])
                ->name('bulk-action');

            // Generate nomor surat otomatis (AJAX)
            Route::post('generate-nomor', [SuratKtmController::class, 'generateNomor'])
                ->name('generate-nomor');

            // Export PDF surat
            Route::get('{id}/export', [SuratKtmController::class, 'export'])
                ->name('export');

            // Download surat untuk admin
            Route::get('{id}/download', [SuratKtmController::class, 'download'])
                ->name('download');

            // API Statistik untuk admin
            Route::get('api/statistik', [SuratKtmController::class, 'apiStatistik'])
                ->name('api.statistik');

            // ========================================
            // QR CODE MANAGEMENT ROUTES - BARU
            // ========================================

            // Generate QR Code manual
            Route::post('{id}/generate-qr', [SuratKtmController::class, 'generateQrCode'])
                ->name('generate-qr');

            // Regenerate QR Code
            Route::post('{id}/regenerate-qr', [SuratKtmController::class, 'regenerateQrCode'])
                ->name('regenerate-qr');

            // Get QR Code info (AJAX)
            Route::get('{id}/qr-info', [SuratKtmController::class, 'getQrCodeInfo'])
                ->name('qr-info');

            // Download QR Code khusus untuk surat tertentu
            Route::get('{id}/download-qr', [SuratKtmController::class, 'downloadQrCode'])
                ->name('download-qr');
        });

        // ========================================
        // SURAT KTU - ADMIN ROUTES (Admin Only) - LENGKAP
        // ========================================
        Route::prefix('surat-ktu')->name('surat-ktu.')->group(function () {
            // Dashboard admin - daftar semua surat
            Route::get('/', [SuratKtuController::class, 'adminIndex'])
                ->name('index');

            // Form create surat oleh admin
            Route::get('create', [SuratKtuController::class, 'adminCreate'])
                ->name('create');

            // Store surat oleh admin
            Route::post('/', [SuratKtuController::class, 'adminStore'])
                ->name('store');

            // Detail surat (admin view)
            Route::get('{id}', [SuratKtuController::class, 'adminShow'])
                ->name('show');

            // Edit surat oleh admin
            Route::get('{id}/edit', [SuratKtuController::class, 'adminEdit'])
                ->name('edit');

            // Update surat oleh admin
            Route::put('{id}', [SuratKtuController::class, 'adminUpdate'])
                ->name('update');

            // Update status surat (AJAX)
            Route::patch('{id}/update-status', [SuratKtuController::class, 'adminUpdateStatus'])
                ->name('update-status');

            // Delete surat
            Route::delete('{id}', [SuratKtuController::class, 'adminDestroy'])
                ->name('destroy');

            // Bulk actions
            Route::post('bulk-action', [SuratKtuController::class, 'adminBulkAction'])
                ->name('bulk-action');

            // Generate nomor surat otomatis (AJAX)
            Route::post('generate-nomor', [SuratKtuController::class, 'generateNomor'])
                ->name('generate-nomor');

            // Export PDF surat
            Route::get('{id}/export', [SuratKtuController::class, 'export'])
                ->name('export');

            // Download surat untuk admin
            Route::get('{id}/download', [SuratKtuController::class, 'download'])
                ->name('download');

            // API Statistik untuk admin
            Route::get('api/statistik', [SuratKtuController::class, 'apiStatistik'])
                ->name('api.statistik');

            // QR CODE MANAGEMENT ROUTES
            Route::post('{id}/generate-qr', [SuratKtuController::class, 'generateQrCode'])
                ->name('generate-qr');

            Route::post('{id}/regenerate-qr', [SuratKtuController::class, 'regenerateQrCode'])
                ->name('regenerate-qr');

            Route::get('{id}/qr-info', [SuratKtuController::class, 'getQrCodeInfo'])
                ->name('qr-info');

            Route::get('{id}/download-qr', [SuratKtuController::class, 'downloadQrCode'])
                ->name('download-qr');
        });

        // ========================================
        // ARSIP SURAT ROUTES
        // ========================================
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

        // ========================================
        // UMKM MANAGEMENT ROUTES (Admin Only)
        // ========================================
        Route::prefix('umkm')->name('umkm.')->group(function () {
            Route::get('/', [UmkmController::class, 'adminIndex'])->name('index');
            Route::get('/create', [UmkmController::class, 'adminCreate'])->name('create'); // Rute untuk form tambah baru
            Route::post('/', [UmkmController::class, 'adminStore'])->name('store'); // Rute untuk simpan data baru
            Route::get('/{id}/edit', [UmkmController::class, 'adminEdit'])->name('edit'); // Rute untuk form edit
            Route::get('/{id}', [UmkmController::class, 'adminShow'])->name('show');
            Route::get('/{id}/approve', [UmkmController::class, 'approve'])->name('approve');
            Route::get('/{id}/reject', [UmkmController::class, 'rejectForm'])->name('reject.form');
            Route::post('/{id}/reject', [UmkmController::class, 'reject'])->name('reject');
            Route::get('/{id}/reset', [UmkmController::class, 'resetToPending'])->name('reset-to-pending');
            Route::get('/{id}/toggle-status', [UmkmController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{id}', [UmkmController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-action', [UmkmController::class, 'bulkAction'])->name('bulk-action');
            Route::get('/export', [UmkmController::class, 'export'])->name('export');
            Route::get('/statistics', [UmkmController::class, 'statistics'])->name('statistics');
        });

        // ========================================
        // VERIFIKASI SURAT ADMIN ROUTES
        // ========================================

        // Dashboard verifikasi
        Route::get('/verifikasi-dashboard', [VerifikasiSuratController::class, 'dashboard'])
            ->name('verifikasi.dashboard');

        // Log verifikasi
        Route::get('/verifikasi-logs', [VerifikasiSuratController::class, 'logs'])
            ->name('verifikasi.logs');

        // Detail log tertentu
        Route::get('/verifikasi-logs/{verifikasiSurat}', [VerifikasiSuratController::class, 'logDetail'])
            ->name('verifikasi.log-detail');

        // Export logs
        Route::get('/export-verifikasi-logs', [VerifikasiSuratController::class, 'exportLogs'])
            ->name('verifikasi.export');

        // Maintenance: Cleanup old logs
        Route::post('/cleanup-logs', [VerifikasiSuratController::class, 'cleanupLogs'])
            ->name('verifikasi.cleanup');


        // Admin APBDES
        Route::prefix('apbdes')->name('apbdes.')->group(function () {
            // List semua APBDes
            Route::get('/', [ApbdesController::class, 'adminIndex'])->name('index');

            // Form tambah APBDes baru
            Route::get('/create', [ApbdesController::class, 'create'])->name('create');

            // Store APBDes baru
            Route::post('/', [ApbdesController::class, 'store'])->name('store');

            // Detail APBDes (admin view)
            Route::get('/{apbdes}', [ApbdesController::class, 'adminShow'])->name('show');

            // Form edit APBDes
            Route::get('/{apbdes}/edit', [ApbdesController::class, 'edit'])->name('edit');

            // Update APBDes
            Route::put('/{apbdes}', [ApbdesController::class, 'update'])->name('update');

            // Delete APBDes
            Route::delete('/{apbdes}', [ApbdesController::class, 'destroy'])->name('destroy');

            Route::get('/{apbdes}/download-pdf', [ApbdesController::class, 'downloadPdf'])->name('download.pdf');
        });
    });
});

// ========================================
// API ROUTES
// ========================================
Route::prefix('api')->group(function () {
    // Public API (tidak perlu auth)
    Route::prefix('public')->group(function () {
        // API untuk tracking surat guest
        Route::post('surat-ktm/track', [SuratKtmController::class, 'apiTrackSurat'])
            ->name('api.public.surat-ktm.track');

        // API untuk tracking surat guest KTU
        Route::post('surat-ktu/track', [SuratKtuController::class, 'apiTrackSurat'])
            ->name('api.public.surat-ktu.track');
    });

    // Authenticated API
    Route::middleware(['auth'])->group(function () {
        // Statistik untuk dashboard
        Route::get('surat-ktm/statistik', [SuratKtmController::class, 'apiStatistik'])
            ->name('api.surat-ktm.statistik');

        // Statistik untuk dashboard KTU
        Route::get('surat-ktu/statistik', [SuratKtuController::class, 'apiStatistik'])
            ->name('api.surat-ktu.statistik');

        // QR Code API untuk user yang login
        Route::prefix('qr-code')->name('api.qr-code.')->group(function () {
            Route::get('{nomorSurat}/info', [QrCodeController::class, 'getInfo'])
                ->name('info');
            Route::get('{nomorSurat}/stats', [QrCodeController::class, 'getStats'])
                ->name('stats');
        });
    });

    // Admin only API
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('api.admin.')->group(function () {
        // QR Code bulk operations
        Route::post('qr-code/bulk-generate', [QrCodeController::class, 'bulkGenerate'])
            ->name('qr-code.bulk-generate');
        Route::post('qr-code/cleanup', [QrCodeController::class, 'cleanup'])
            ->name('qr-code.cleanup');
        Route::get('qr-code/statistics', [QrCodeController::class, 'getStatistics'])
            ->name('qr-code.statistics');
    });
});

// ========================================
// REDIRECT ROUTES (untuk backward compatibility)
// ========================================

// Redirect old berita URLs
Route::redirect('/news', '/berita', 301);
Route::redirect('/news/{slug}', '/berita/{slug}', 301);
Route::redirect('/category/{slug}', '/berita/kategori/{slug}', 301);

require __DIR__ . '/auth.php';
