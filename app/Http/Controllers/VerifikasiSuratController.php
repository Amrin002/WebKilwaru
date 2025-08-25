<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\StrukturDesa;
use App\Models\VerifikasiSurat;
use App\Services\VerifikasiSuratService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifikasiSuratController extends Controller
{
    /**
     * Service untuk handle business logic
     */
    protected VerifikasiSuratService $verifikasiService;

    public function __construct(VerifikasiSuratService $verifikasiService)
    {
        $this->verifikasiService = $verifikasiService;
    }

    // ========================================
    // MAIN VERIFICATION METHODS
    // ========================================

    /**
     * Halaman verifikasi surat (Web)
     * Route: GET /verifikasi/{nomorSurat}
     */
    public function verify(string $nomorSurat, Request $request)
    {
        try {
            // Log verifikasi activity
            $this->logVerifikasi($nomorSurat, $request);

            // Cari arsip surat
            $arsipSurat = ArsipSurat::where('nomor_surat', $nomorSurat)
                ->with('suratDetail') // Load relasi detail surat
                ->first();

            if ($arsipSurat) {
                // Buat object verifikasi dengan data lengkap
                $verifikasi = $this->buildVerifikasiData($arsipSurat);
                $waktuScanTerakhir = VerifikasiSurat::getWaktuScanTerakhir($nomorSurat);
                $totalVerifikasi = VerifikasiSurat::getTotalVerifikasi($nomorSurat);

                return view('verifikasi.surat', compact('verifikasi', 'waktuScanTerakhir', 'totalVerifikasi'));
            } else {
                return view('verifikasi.not-found', compact('nomorSurat'));
            }
        } catch (\Exception $e) {
            Log::error('Verifikasi error: ' . $e->getMessage(), [
                'nomor_surat' => $nomorSurat,
                'ip' => $request->ip()
            ]);

            return view('verifikasi.not-found', compact('nomorSurat'));
        }
    }
    /**
     * Build data verifikasi dari arsip surat
     */
    private function buildVerifikasiData(ArsipSurat $arsipSurat)
    {
        // Mulai dengan data dasar dari arsip
        $data = [
            'no_surat' => $arsipSurat->nomor_surat,
            'nomor_surat' => $arsipSurat->nomor_surat,
            'tanggal_terbit' => $arsipSurat->tanggal_surat,
            'status' => 'TERVERIFIKASI',
            'type_surat' => $this->getJenisSurat($arsipSurat),
            'jenis_surat' => $this->getJenisSurat($arsipSurat),
            'penandatangan' => $this->getPenandatangan(),
            'dikeluarkan_oleh' => 'Kantor Desa Akat Fadedo'
        ];

        // Tentukan nama berdasarkan jenis surat (masuk/keluar)
        if ($arsipSurat->isSuratMasuk()) {
            // Untuk surat masuk, nama adalah pengirim
            $data['nama'] = $arsipSurat->pengirim;
            $data['nama_pemohon'] = $arsipSurat->pengirim;
        } elseif ($arsipSurat->isSuratKeluar()) {
            // Untuk surat keluar, nama adalah tujuan surat
            $data['nama'] = $arsipSurat->tujuan_surat;
            $data['nama_pemohon'] = $arsipSurat->tujuan_surat;
        }

        // Jika ada detail surat (polymorphic relationship)
        if ($arsipSurat->suratDetail) {
            $detailSurat = $arsipSurat->suratDetail;

            // Override nama jika ada di detail surat
            if (isset($detailSurat->nama)) {
                $data['nama'] = $detailSurat->nama;
                $data['nama_pemohon'] = $detailSurat->nama;
            } elseif (isset($detailSurat->nama_pemohon)) {
                $data['nama'] = $detailSurat->nama_pemohon;
                $data['nama_pemohon'] = $detailSurat->nama_pemohon;
            } elseif (isset($detailSurat->nama_penerima)) {
                $data['nama'] = $detailSurat->nama_penerima;
                $data['nama_pemohon'] = $detailSurat->nama_penerima;
            }

            // Ambil jenis surat dari detail jika ada
            if (isset($detailSurat->jenis_surat)) {
                $data['type_surat'] = $detailSurat->jenis_surat;
                $data['jenis_surat'] = $detailSurat->jenis_surat;
            }
        }

        // Fallback jika nama masih kosong
        if (empty($data['nama']) && empty($data['nama_pemohon'])) {
            $data['nama'] = 'Data nama tidak tersedia';
            $data['nama_pemohon'] = 'Data nama tidak tersedia';
        }

        return (object) $data;
    }
    /**
     * Get nama penandatangan dari StrukturDesa
     * Prioritas: Kepala Desa aktif -> Kepala Desa non-aktif -> Default
     */
    private function getPenandatangan(): string
    {
        try {
            // Cari kepala desa yang aktif dan sedang menjabat
            $kepalaDesa = StrukturDesa::where('kategori', 'kepala_desa')
                ->where('aktif', true)
                ->where(function ($query) {
                    $query->whereNull('selesai_menjabat')
                        ->orWhere('selesai_menjabat', '>=', now());
                })
                ->where('mulai_menjabat', '<=', now())
                ->orderBy('mulai_menjabat', 'desc')
                ->first();

            if ($kepalaDesa) {
                return strtoupper($kepalaDesa->nama);
            }

            // Fallback: Cari kepala desa aktif tanpa validasi tanggal
            $kepalaDesaAktif = StrukturDesa::where('kategori', 'kepala_desa')
                ->where('aktif', true)
                ->orderBy('mulai_menjabat', 'desc')
                ->first();

            if ($kepalaDesaAktif) {
                return strtoupper($kepalaDesaAktif->nama);
            }

            // Fallback terakhir: Cari kepala desa manapun
            $kepalaDesaAny = StrukturDesa::where('kategori', 'kepala_desa')
                ->orderBy('mulai_menjabat', 'desc')
                ->first();

            if ($kepalaDesaAny) {
                return strtoupper($kepalaDesaAny->nama);
            }

            // Default jika tidak ada data kepala desa
            return 'AHMAD BUGIS';
        } catch (\Exception $e) {
            // Log error dan return default
            Log::warning('Error getting penandatangan from StrukturDesa: ' . $e->getMessage());
            return 'AHMAD BUGIS';
        }
    }
    /**
     * Log aktivitas verifikasi
     */
    private function logVerifikasi(string $nomorSurat, Request $request)
    {
        try {
            // Cek apakah surat ditemukan untuk status log
            $arsipExists = ArsipSurat::where('nomor_surat', $nomorSurat)->exists();

            VerifikasiSurat::logVerifikasi($nomorSurat, [
                'ip_address' => $this->getRealIpAddress($request),
                'user_agent' => $request->userAgent(),
                'lokasi_perkiraan' => $this->getLocationFromIp($request->ip()),
                'status_hasil' => $arsipExists ? 'found' : 'not_found',
                'referrer' => $request->header('referer'),
                'device_info' => $this->getDeviceInfo($request)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Get real IP address behind proxy/cloudflare
     */
    private function getRealIpAddress(Request $request)
    {
        // Check for IP from Cloudflare
        if ($request->header('HTTP_CF_CONNECTING_IP')) {
            return $request->header('HTTP_CF_CONNECTING_IP');
        }

        // Check for IP from proxy
        if ($request->header('HTTP_CLIENT_IP')) {
            return $request->header('HTTP_CLIENT_IP');
        }

        // Check for IP from forwarded header
        if ($request->header('HTTP_X_FORWARDED_FOR')) {
            $ips = explode(',', $request->header('HTTP_X_FORWARDED_FOR'));
            return trim($ips[0]);
        }

        return $request->ip();
    }

    /**
     * Get simple location info from IP (placeholder)
     */
    private function getLocationFromIp(string $ip)
    {
        // Untuk implementasi sederhana, bisa return static
        // Atau integrate dengan service seperti ipinfo.io
        return 'Indonesia'; // Placeholder
    }

    /**
     * Get device info from user agent
     */
    private function getDeviceInfo(Request $request)
    {
        $userAgent = $request->userAgent();

        return [
            'is_mobile' => $request->isMobile(),
            'platform' => $this->detectPlatform($userAgent),
            'browser' => $this->detectBrowser($userAgent)
        ];
    }
    /**
     * Detect platform from user agent
     */
    private function detectPlatform(string $userAgent)
    {
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac') !== false) return 'MacOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) return 'iOS';

        return 'Unknown';
    }
    /**
     * Detect browser from user agent
     */
    private function detectBrowser(string $userAgent)
    {
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';

        return 'Unknown';
    }
    /**
     * Tentukan jenis surat berdasarkan data arsip
     */
    private function getJenisSurat(ArsipSurat $arsipSurat)
    {
        // Jika ada detail type polymorphic
        if ($arsipSurat->surat_detail_type) {
            $typeMap = [
                'App\Models\SuratKtm' => 'SURAT KETERANGAN TIDAK MAMPU',
                'App\Models\SuratSkpt' => 'SURAT KETERANGAN PENDUDUK TETAP',
                'App\Models\SuratSkd' => 'SURAT KETERANGAN DOMISILI',
                'App\Models\SuratSku' => 'SURAT KETERANGAN USAHA',
            ];

            if (isset($typeMap[$arsipSurat->surat_detail_type])) {
                return $typeMap[$arsipSurat->surat_detail_type];
            }
        }

        // Deteksi dari nomor surat
        $nomorSurat = strtoupper($arsipSurat->nomor_surat);

        if (strpos($nomorSurat, 'SKTM') !== false || strpos($nomorSurat, 'KTM') !== false) {
            return 'SURAT KETERANGAN TIDAK MAMPU';
        } elseif (strpos($nomorSurat, 'SKPT') !== false) {
            return 'SURAT KETERANGAN PENDUDUK TETAP';
        } elseif (strpos($nomorSurat, 'SKD') !== false) {
            return 'SURAT KETERANGAN DOMISILI';
        } elseif (strpos($nomorSurat, 'SKU') !== false) {
            return 'SURAT KETERANGAN USAHA';
        }

        // Deteksi dari perihal/tentang
        $content = strtoupper($arsipSurat->perihal . ' ' . $arsipSurat->tentang);

        if (strpos($content, 'TIDAK MAMPU') !== false) {
            return 'SURAT KETERANGAN TIDAK MAMPU';
        } elseif (strpos($content, 'DOMISILI') !== false) {
            return 'SURAT KETERANGAN DOMISILI';
        } elseif (strpos($content, 'USAHA') !== false) {
            return 'SURAT KETERANGAN USAHA';
        }

        return 'SURAT KETERANGAN';
    }
    /**
     * API verifikasi untuk mobile/AJAX
     * Route: GET /api/verifikasi/{nomorSurat}
     */
    public function apiVerify(string $nomorSurat, Request $request)
    {
        try {
            $result = $this->verifikasiService->prosesVerifikasi($nomorSurat, $request);

            if ($result['status'] === 'found') {
                return response()->json([
                    'success' => true,
                    'status' => 'valid',
                    'data' => $result['data'],
                    'waktu_scan' => $result['waktu_scan']->format('H:i:s'),
                    'total_verifikasi' => $result['total_verifikasi'],
                    'message' => 'Dokumen terverifikasi dan sah'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'not_found',
                    'message' => 'Dokumen tidak ditemukan dalam sistem',
                    'waktu_scan' => $result['waktu_scan']->format('H:i:s')
                ], 404);
            }
        } catch (\Exception $e) {
            // Log error
            Log::error('Verifikasi API Error: ' . $e->getMessage(), [
                'nomor_surat' => $nomorSurat,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem',
                'waktu_scan' => now()->format('H:i:s')
            ], 500);
        }
    }

    // ========================================
    // REAL-TIME DATA METHODS
    // ========================================

    /**
     * Get waktu scan terakhir (untuk real-time update)
     * Route: GET /api/waktu-verifikasi/{nomorSurat}
     */
    public function getWaktuTerakhir(string $nomorSurat)
    {
        $waktuTerakhir = VerifikasiSurat::getWaktuScanTerakhir($nomorSurat);

        return response()->json([
            'waktu_terakhir' => $waktuTerakhir ? $waktuTerakhir->format('H:i:s') : now()->format('H:i:s'),
            'timestamp' => $waktuTerakhir ? $waktuTerakhir->timestamp : now()->timestamp,
            'formatted' => $waktuTerakhir ? $waktuTerakhir->locale('id')->isoFormat('HH:mm:ss') : now()->locale('id')->isoFormat('HH:mm:ss')
        ]);
    }

    /**
     * Get statistik verifikasi dokumen tertentu
     * Route: GET /api/statistik-dokumen/{nomorSurat}
     */
    public function getStatistikDokumen(string $nomorSurat)
    {
        $logs = VerifikasiSurat::byNomorSurat($nomorSurat)
            ->with('arsipSurat')
            ->latest('waktu_scan')
            ->get();

        $statistik = [
            'total_verifikasi' => $logs->count(),
            'verifikasi_hari_ini' => $logs->filter(function ($log) {
                return $log->waktu_scan->isToday();
            })->count(),
            'verifikasi_minggu_ini' => $logs->filter(function ($log) {
                return $log->waktu_scan->isCurrentWeek();
            })->count(),
            'pertama_kali_diverifikasi' => $logs->last()?->waktu_scan?->locale('id')->isoFormat('DD MMMM YYYY, HH:mm'),
            'terakhir_diverifikasi' => $logs->first()?->waktu_scan?->locale('id')->isoFormat('DD MMMM YYYY, HH:mm'),
            'unique_ips' => $logs->pluck('ip_address')->unique()->count(),
            'platform_breakdown' => $this->getPlatformBreakdown($logs),
            'recent_access' => $logs->take(5)->map(function ($log) {
                return [
                    'waktu' => $log->waktu_scan->locale('id')->isoFormat('DD MMM, HH:mm'),
                    'ip' => $log->ip_address,
                    'platform' => $log->browser_info['platform'],
                    'browser' => $log->browser_info['browser'],
                    'mobile' => $log->is_mobile
                ];
            })
        ];

        return response()->json($statistik);
    }

    // ========================================
    // ADMIN DASHBOARD METHODS
    // ========================================

    /**
     * Dashboard verifikasi untuk admin
     * Route: GET /admin/verifikasi-dashboard
     */
    public function dashboard()
    {
        $statistik = $this->verifikasiService->getStatistikVerifikasi(['period' => 'month']);
        $grafikData = $this->verifikasiService->getDataGrafik('week');

        return view('admin.verifikasi.dashboard', compact('statistik', 'grafikData'));
    }

    /**
     * Log verifikasi untuk admin
     * Route: GET /admin/verifikasi-logs
     */
    public function logs(Request $request)
    {
        $query = VerifikasiSurat::with('arsipSurat')->latest('waktu_scan');

        // Filter berdasarkan parameter
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'today':
                    $query->today();
                    break;
                case 'week':
                    $query->thisWeek();
                    break;
                case 'month':
                    $query->thisMonth();
                    break;
            }
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $logs = $query->paginate(50);

        // Data untuk filter dropdown
        $statistikPeriode = [
            'today' => VerifikasiSurat::today()->count(),
            'week' => VerifikasiSurat::thisWeek()->count(),
            'month' => VerifikasiSurat::thisMonth()->count(),
        ];

        return view('admin.verifikasi.logs', compact('logs', 'statistikPeriode'));
    }

    /**
     * Detail log verifikasi tertentu
     * Route: GET /admin/verifikasi-logs/{id}
     */
    public function logDetail(VerifikasiSurat $verifikasiSurat)
    {
        $verifikasiSurat->load('arsipSurat');

        // Ambil log lain dari IP yang sama (untuk detect suspicious activity)
        $logDariIpSama = VerifikasiSurat::byIpAddress($verifikasiSurat->ip_address)
            ->where('id', '!=', $verifikasiSurat->id)
            ->latest('waktu_scan')
            ->limit(10)
            ->get();

        return view('admin.verifikasi.log-detail', compact('verifikasiSurat', 'logDariIpSama'));
    }

    // ========================================
    // API FOR CHARTS & ANALYTICS
    // ========================================

    /**
     * Data untuk chart verifikasi
     * Route: GET /api/chart-verifikasi
     */
    public function chartData(Request $request)
    {
        $period = $request->get('period', 'week'); // week, month
        $data = $this->verifikasiService->getDataGrafik($period);

        return response()->json([
            'labels' => array_column($data, 'label'),
            'datasets' => [
                [
                    'label' => 'Total Verifikasi',
                    'data' => array_column($data, 'total'),
                    'backgroundColor' => 'rgba(44, 90, 160, 0.2)',
                    'borderColor' => 'rgba(44, 90, 160, 1)',
                    'borderWidth' => 2
                ],
                [
                    'label' => 'Dokumen Ditemukan',
                    'data' => array_column($data, 'found'),
                    'backgroundColor' => 'rgba(40, 167, 69, 0.2)',
                    'borderColor' => 'rgba(40, 167, 69, 1)',
                    'borderWidth' => 2
                ],
                [
                    'label' => 'Tidak Ditemukan',
                    'data' => array_column($data, 'not_found'),
                    'backgroundColor' => 'rgba(220, 53, 69, 0.2)',
                    'borderColor' => 'rgba(220, 53, 69, 1)',
                    'borderWidth' => 2
                ]
            ]
        ]);
    }

    /**
     * Export log verifikasi ke Excel/CSV
     * Route: GET /admin/export-verifikasi-logs
     */
    public function exportLogs(Request $request)
    {
        // Implementation untuk export - bisa pakai Laravel Excel
        // Untuk sekarang return JSON dulu

        $query = VerifikasiSurat::with('arsipSurat');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        $logs = $query->get();

        $exportData = $logs->map(function ($log) {
            return [
                'Nomor Surat' => $log->nomor_surat,
                'Waktu Scan' => $log->waktu_scan_formatted,
                'IP Address' => $log->ip_address,
                'Lokasi' => $log->lokasi_perkiraan ?: '-',
                'Browser' => $log->browser_info['browser'],
                'Platform' => $log->browser_info['platform'],
                'Mobile' => $log->is_mobile ? 'Ya' : 'Tidak',
                'Status' => $log->status_hasil_indonesia,
                'Referrer' => $log->referrer ?: '-'
            ];
        });

        return response()->json([
            'data' => $exportData,
            'total' => $logs->count(),
            'generated_at' => now()->locale('id')->isoFormat('DD MMMM YYYY, HH:mm:ss')
        ]);
    }

    // ========================================
    // MAINTENANCE & UTILITIES
    // ========================================

    /**
     * Cleanup log lama (untuk maintenance)
     * Route: POST /admin/cleanup-logs
     */
    public function cleanupLogs(Request $request)
    {
        $request->validate([
            'days_to_keep' => 'required|integer|min:30|max:3650' // Min 30 hari, max 10 tahun
        ]);

        try {
            $result = $this->verifikasiService->cleanupLogs($request->days_to_keep);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$result['deleted_count']} log lama",
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Cleanup logs error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan cleanup logs'
            ], 500);
        }
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    /**
     * Get breakdown platform dari logs
     */
    private function getPlatformBreakdown($logs)
    {
        $platforms = $logs->map(function ($log) {
            return $log->browser_info['platform'];
        })->countBy();

        return $platforms->toArray();
    }

    /**
     * Handle rate limiting (future enhancement)
     */
    private function checkRateLimit(Request $request)
    {
        $ip = $request->ip();
        $key = "verifikasi_rate_limit:{$ip}";

        // Simple rate limiting: max 60 requests per minute
        $attempts = cache()->get($key, 0);

        if ($attempts >= 60) {
            return false;
        }

        cache()->put($key, $attempts + 1, now()->addMinute());
        return true;
    }
}
