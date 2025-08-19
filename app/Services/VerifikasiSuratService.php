<?php

namespace App\Services;

use App\Models\VerifikasiSurat;
use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerifikasiSuratService
{
    /**
     * Proses verifikasi surat dan log aktivitas
     */
    public function prosesVerifikasi(string $nomorSurat, Request $request): array
    {
        // Log aktivitas verifikasi
        $logData = $this->extractRequestData($request);

        // Cek apakah surat exists di arsip
        $arsipSurat = ArsipSurat::where('nomor_surat', $nomorSurat)->first();

        if ($arsipSurat) {
            $logData['status_hasil'] = 'found';

            // Log verifikasi
            VerifikasiSurat::logVerifikasi($nomorSurat, $logData);

            return [
                'status' => 'found',
                'data' => $this->formatVerifikasiData($arsipSurat),
                'waktu_scan' => now(),
                'total_verifikasi' => VerifikasiSurat::getTotalVerifikasi($nomorSurat)
            ];
        } else {
            $logData['status_hasil'] = 'not_found';

            // Log verifikasi gagal
            VerifikasiSurat::logVerifikasi($nomorSurat, $logData);

            return [
                'status' => 'not_found',
                'message' => 'Dokumen tidak ditemukan dalam sistem',
                'waktu_scan' => now()
            ];
        }
    }

    /**
     * Extract data dari request untuk logging
     */
    private function extractRequestData(Request $request): array
    {
        return [
            'ip_address' => $this->getRealIpAddress($request),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
            'device_info' => [
                'platform' => $this->detectPlatform($request->userAgent()),
                'browser' => $this->detectBrowser($request->userAgent()),
                'mobile' => $this->isMobile($request->userAgent()),
                'timestamp' => now()->timestamp
            ],
            'lokasi_perkiraan' => $this->getLocationFromIp($this->getRealIpAddress($request))
        ];
    }

    /**
     * Get real IP address dari request
     */
    private function getRealIpAddress(Request $request): string
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancer
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'                // Direct connection
        ];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) && !empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                $ipList = explode(',', $ip);
                return trim($ipList[0]);
            }
        }

        return $request->ip();
    }

    /**
     * Detect platform dari user agent
     */
    private function detectPlatform(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown';

        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Macintosh') !== false) return 'MacOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) return 'iOS';

        return 'Unknown';
    }

    /**
     * Detect browser dari user agent
     */
    private function detectBrowser(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown';

        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';
        if (stripos($userAgent, 'Opera') !== false) return 'Opera';

        return 'Unknown';
    }

    /**
     * Check if mobile device
     */
    private function isMobile(?string $userAgent): bool
    {
        if (!$userAgent) return false;

        return stripos($userAgent, 'Mobile') !== false ||
            stripos($userAgent, 'Android') !== false ||
            stripos($userAgent, 'iPhone') !== false ||
            stripos($userAgent, 'iPad') !== false;
    }

    /**
     * Get location dari IP (basic implementation)
     * Bisa diganti dengan service geolocation yang lebih canggih
     */
    private function getLocationFromIp(string $ipAddress): ?string
    {
        // Skip untuk IP lokal
        if ($this->isLocalIp($ipAddress)) {
            return 'Lokal/Internal';
        }

        // Implementasi basic - bisa ditingkatkan dengan service external
        // Untuk sekarang return null, nanti bisa ditambah integration dengan ip-api.com atau sejenisnya
        return null;
    }

    /**
     * Check if IP is local/private
     */
    private function isLocalIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    /**
     * Format data verifikasi untuk response
     */
    private function formatVerifikasiData(ArsipSurat $arsipSurat): array
    {
        return [
            'nomor_surat' => $arsipSurat->nomor_surat,
            'tanggal_surat' => $arsipSurat->tanggal_surat_formatted,
            'kategori_surat' => $arsipSurat->kategori_surat,
            'konten_utama' => $arsipSurat->konten_utama,
            'pihak_terkait' => $arsipSurat->pihak_terkait,
            'status_dokumen' => 'TERVERIFIKASI',
            'jenis_surat' => $this->getJenisSurat($arsipSurat),
            'penandatangan' => 'SIDIK RUMALOWAK, S.Pd, MMP, M.Si', // Sesuai dengan sistem lama
            'dikeluarkan_oleh' => 'Kantor Desa Akat Fadedo'
        ];
    }

    /**
     * Tentukan jenis surat berdasarkan konten
     */
    private function getJenisSurat(ArsipSurat $arsipSurat): string
    {
        $konten = strtolower($arsipSurat->konten_utama);

        // Mapping berdasarkan keyword
        $mapping = [
            'domisili' => 'SURAT KETERANGAN DOMISILI',
            'tidak mampu' => 'SURAT KETERANGAN TIDAK MAMPU',
            'usaha' => 'SURAT KETERANGAN USAHA',
            'pindah' => 'SURAT KETERANGAN PINDAH',
            'penghasilan' => 'SURAT KETERANGAN PENGHASILAN',
            'kematian' => 'SURAT KETERANGAN KEMATIAN',
            'kelahiran' => 'SURAT KETERANGAN KELAHIRAN',
        ];

        foreach ($mapping as $keyword => $jenis) {
            if (stripos($konten, $keyword) !== false) {
                return $jenis;
            }
        }

        return 'SURAT KETERANGAN';
    }

    /**
     * Get statistik verifikasi untuk dashboard
     */
    public function getStatistikVerifikasi(array $filters = []): array
    {
        $query = VerifikasiSurat::query();

        // Apply filters
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->byDateRange($filters['start_date'], $filters['end_date']);
        } elseif (isset($filters['period'])) {
            switch ($filters['period']) {
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

        $logs = $query->get();

        return [
            'total_verifikasi' => $logs->count(),
            'dokumen_found' => $logs->where('status_hasil', 'found')->count(),
            'dokumen_not_found' => $logs->where('status_hasil', 'not_found')->count(),
            'unique_documents' => $logs->pluck('nomor_surat')->unique()->count(),
            'unique_ips' => $logs->pluck('ip_address')->unique()->count(),
            'mobile_access' => $logs->filter(function ($log) {
                return stripos($log->user_agent, 'Mobile') !== false;
            })->count(),
            'popular_documents' => VerifikasiSurat::getDokumenTerpopuler(5),
            'recent_verifications' => $logs->sortByDesc('waktu_scan')->take(10)->values()
        ];
    }

    /**
     * Get data untuk grafik verifikasi
     */
    public function getDataGrafik(string $period = 'week'): array
    {
        $data = [];

        switch ($period) {
            case 'week':
                for ($i = 6; $i >= 0; $i--) {
                    $tanggal = Carbon::now()->subDays($i);
                    $stats = VerifikasiSurat::getStatistikHarian($tanggal);
                    $data[] = [
                        'tanggal' => $tanggal->format('Y-m-d'),
                        'label' => $tanggal->format('d M'),
                        'total' => $stats['total'],
                        'found' => $stats['found'],
                        'not_found' => $stats['not_found']
                    ];
                }
                break;

            case 'month':
                for ($i = 29; $i >= 0; $i--) {
                    $tanggal = Carbon::now()->subDays($i);
                    $stats = VerifikasiSurat::getStatistikHarian($tanggal);
                    $data[] = [
                        'tanggal' => $tanggal->format('Y-m-d'),
                        'label' => $tanggal->format('d/m'),
                        'total' => $stats['total'],
                        'found' => $stats['found'],
                        'not_found' => $stats['not_found']
                    ];
                }
                break;
        }

        return $data;
    }

    /**
     * Cleanup logs lama untuk maintenance
     */
    public function cleanupLogs(int $daysToKeep = 365): array
    {
        $deletedCount = VerifikasiSurat::cleanupOldLogs($daysToKeep);

        return [
            'deleted_count' => $deletedCount,
            'cutoff_date' => Carbon::now()->subDays($daysToKeep)->format('Y-m-d'),
            'remaining_count' => VerifikasiSurat::count()
        ];
    }
}
