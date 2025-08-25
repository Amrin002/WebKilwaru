<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class VerifikasiSurat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'verifikasi_surats';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nomor_surat',
        'ip_address',
        'user_agent',
        'lokasi_perkiraan',
        'status_hasil',
        'referrer',
        'device_info',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'device_info' => 'array',
        'waktu_scan' => 'datetime',
    ];

    /**
     * Disable default timestamps karena hanya menggunakan waktu_scan
     */
    public $timestamps = false;

    /**
     * Custom timestamp untuk created_at
     */
    const CREATED_AT = 'waktu_scan';
    const UPDATED_AT = null;

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relasi ke ArsipSurat berdasarkan nomor_surat
     */
    public function arsipSurat(): BelongsTo
    {
        return $this->belongsTo(ArsipSurat::class, 'nomor_surat', 'nomor_surat');
    }


    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope untuk filter berdasarkan status hasil
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status_hasil', $status);
    }

    /**
     * Scope untuk verifikasi yang berhasil ditemukan
     */
    public function scopeFound(Builder $query): Builder
    {
        return $query->where('status_hasil', 'found');
    }

    /**
     * Scope untuk verifikasi yang tidak ditemukan
     */
    public function scopeNotFound(Builder $query): Builder
    {
        return $query->where('status_hasil', 'not_found');
    }

    /**
     * Scope untuk filter berdasarkan nomor surat tertentu
     */
    public function scopeByNomorSurat(Builder $query, string $nomorSurat): Builder
    {
        return $query->where('nomor_surat', $nomorSurat);
    }

    /**
     * Scope untuk filter berdasarkan range tanggal
     */
    public function scopeByDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('waktu_scan', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter berdasarkan hari ini
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('waktu_scan', Carbon::today());
    }

    /**
     * Scope untuk filter berdasarkan minggu ini
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('waktu_scan', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    /**
     * Scope untuk filter berdasarkan bulan ini
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('waktu_scan', Carbon::now()->month)
            ->whereYear('waktu_scan', Carbon::now()->year);
    }

    /**
     * Scope untuk filter berdasarkan IP address
     */
    public function scopeByIpAddress(Builder $query, string $ipAddress): Builder
    {
        return $query->where('ip_address', $ipAddress);
    }

    /**
     * Scope untuk pencarian berdasarkan nomor surat atau IP
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('lokasi_perkiraan', 'like', "%{$search}%");
        });
    }

    // ========================================
    // ACCESSORS
    // ========================================

    /**
     * Format waktu scan untuk display Indonesia
     */
    public function getWaktuScanFormattedAttribute(): string
    {
        return $this->waktu_scan
            ? $this->waktu_scan->locale('id')->isoFormat('DD MMMM YYYY, HH:mm:ss')
            : '-';
    }

    /**
     * Format waktu scan hanya jam
     */
    public function getJamScanAttribute(): string
    {
        return $this->waktu_scan
            ? $this->waktu_scan->format('H:i:s')
            : '-';
    }

    /**
     * Get browser info dari user agent
     */
    public function getBrowserInfoAttribute(): array
    {
        if (!$this->user_agent) {
            return ['browser' => 'Unknown', 'platform' => 'Unknown'];
        }

        $userAgent = $this->user_agent;

        // Detect browser
        $browser = 'Unknown';
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        }

        // Detect platform
        $platform = 'Unknown';
        if (strpos($userAgent, 'Windows') !== false) {
            $platform = 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $platform = 'MacOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $platform = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $platform = 'Android';
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $platform = 'iOS';
        }

        return ['browser' => $browser, 'platform' => $platform];
    }

    /**
     * Check if scan from mobile device
     */
    public function getIsMobileAttribute(): bool
    {
        if (!$this->user_agent) {
            return false;
        }

        return strpos($this->user_agent, 'Mobile') !== false ||
            strpos($this->user_agent, 'Android') !== false ||
            strpos($this->user_agent, 'iPhone') !== false ||
            strpos($this->user_agent, 'iPad') !== false;
    }

    /**
     * Get status hasil dalam bahasa Indonesia
     */
    public function getStatusHasilIndonesiaAttribute(): string
    {
        return match ($this->status_hasil) {
            'found' => 'Ditemukan',
            'not_found' => 'Tidak Ditemukan',
            'error' => 'Error',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status badge class untuk UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_hasil) {
            'found' => 'badge bg-success',
            'not_found' => 'badge bg-danger',
            'error' => 'badge bg-warning',
            default => 'badge bg-secondary'
        };
    }

    // ========================================
    // STATIC METHODS & HELPERS
    // ========================================

    /**
     * Log verifikasi baru
     */
    public static function logVerifikasi(string $nomorSurat, array $data): self
    {
        return self::create([
            'nomor_surat' => $nomorSurat,
            'ip_address' => $data['ip_address'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'lokasi_perkiraan' => $data['lokasi_perkiraan'] ?? null,
            'status_hasil' => $data['status_hasil'] ?? 'found',
            'referrer' => $data['referrer'] ?? null,
            'device_info' => $data['device_info'] ?? null,
        ]);
    }

    /**
     * Get waktu scan terakhir untuk nomor surat tertentu
     */
    public static function getWaktuScanTerakhir(string $nomorSurat): ?Carbon
    {
        $log = self::byNomorSurat($nomorSurat)
            ->latest('waktu_scan')
            ->first();

        return $log ? $log->waktu_scan : null;
    }

    /**
     * Hitung total verifikasi untuk nomor surat tertentu
     */
    public static function getTotalVerifikasi(string $nomorSurat): int
    {
        return self::byNomorSurat($nomorSurat)->count();
    }

    /**
     * Statistik verifikasi harian
     */
    public static function getStatistikHarian(Carbon $tanggal): array
    {
        $logs = self::whereDate('waktu_scan', $tanggal)->get();

        return [
            'total' => $logs->count(),
            'found' => $logs->where('status_hasil', 'found')->count(),
            'not_found' => $logs->where('status_hasil', 'not_found')->count(),
            'error' => $logs->where('status_hasil', 'error')->count(),
            'unique_documents' => $logs->pluck('nomor_surat')->unique()->count(),
            'unique_ips' => $logs->pluck('ip_address')->unique()->count(),
        ];
    }

    /**
     * Dokumen paling sering diverifikasi
     */
    public static function getDokumenTerpopuler(int $limit = 10): array
    {
        return self::selectRaw('nomor_surat, COUNT(*) as total_verifikasi')
            ->with('arsipSurat')
            ->groupBy('nomor_surat')
            ->orderByDesc('total_verifikasi')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * IP dengan aktivitas mencurigakan (terlalu banyak scan)
     */
    public static function getIpMencurigakan(int $threshold = 50): array
    {
        return self::selectRaw('ip_address, COUNT(*) as total_scan')
            ->whereDate('waktu_scan', '>=', Carbon::now()->subDays(7))
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) > ?', [$threshold])
            ->orderByDesc('total_scan')
            ->get()
            ->toArray();
    }

    /**
     * Cleanup log lama (untuk maintenance)
     */
    public static function cleanupOldLogs(int $daysToKeep = 365): int
    {
        $cutoffDate = Carbon::now()->subDays($daysToKeep);

        return self::where('waktu_scan', '<', $cutoffDate)->delete();
    }
}
