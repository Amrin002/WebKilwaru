<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Apbdes extends Model
{
    use HasFactory;

    protected $table = 'apbdes';

    protected $fillable = [
        'tahun',
        'pemerintahan_desa',
        'pembangunan_desa',
        'kemasyarakatan',
        'pemberdayaan',
        'bencana_darurat',
        'total_anggaran',
        'pdf_dokumen',
        'baliho_image',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'pemerintahan_desa' => 'decimal:2',
        'pembangunan_desa' => 'decimal:2',
        'kemasyarakatan' => 'decimal:2',
        'pemberdayaan' => 'decimal:2',
        'bencana_darurat' => 'decimal:2',
        'total_anggaran' => 'decimal:2',
    ];

    /**
     * Boot method - Auto calculate total anggaran
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($apbdes) {
            $apbdes->total_anggaran =
                $apbdes->pemerintahan_desa +
                $apbdes->pembangunan_desa +
                $apbdes->kemasyarakatan +
                $apbdes->pemberdayaan +
                $apbdes->bencana_darurat;
        });
    }

    // ============ SCOPES ============

    /**
     * Scope untuk tahun tertentu
     */
    public function scopeByTahun(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun', $tahun);
    }

    /**
     * Scope untuk tahun terbaru
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('tahun', 'desc');
    }

    /**
     * Scope untuk tahun terlama
     */
    public function scopeOldest(Builder $query): Builder
    {
        return $query->orderBy('tahun', 'asc');
    }

    /**
     * Scope untuk APBDes yang ada file PDF
     */
    public function scopeHasPdf(Builder $query): Builder
    {
        return $query->whereNotNull('pdf_dokumen');
    }

    /**
     * Scope untuk APBDes yang ada baliho
     */
    public function scopeHasBaliho(Builder $query): Builder
    {
        return $query->whereNotNull('baliho_image');
    }

    // ============ ACCESSORS ============

    /**
     * Get formatted total anggaran
     */
    public function getTotalAnggaranFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_anggaran, 0, ',', '.');
    }

    /**
     * Get PDF URL
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_dokumen ? Storage::url($this->pdf_dokumen) : null;
    }

    /**
     * Get Baliho URL
     */
    public function getBalihoUrlAttribute(): ?string
    {
        return $this->baliho_image ? Storage::url($this->baliho_image) : null;
    }

    /**
     * Get breakdown anggaran dalam array
     */
    public function getBreakdownAttribute(): array
    {
        return [
            'Penyelenggaraan Pemerintahan Desa' => $this->pemerintahan_desa,
            'Pelaksanaan Pembangunan Desa' => $this->pembangunan_desa,
            'Pembinaan Kemasyarakatan' => $this->kemasyarakatan,
            'Pemberdayaan Masyarakat' => $this->pemberdayaan,
            'Penanggulangan Bencana & Darurat' => $this->bencana_darurat,
        ];
    }

    // Tambahkan accessor untuk format Rupiah
    public function getPemerintahanDesaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->pemerintahan_desa, 0, ',', '.');
    }

    public function getPembangunanDesaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->pembangunan_desa, 0, ',', '.');
    }

    public function getKemasyarakatanFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->kemasyarakatan, 0, ',', '.');
    }

    public function getPemberdayaanFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->pemberdayaan, 0, ',', '.');
    }

    public function getBencanaDaruratFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->bencana_darurat, 0, ',', '.');
    }

    /**
     * Get breakdown dalam persentase
     */
    public function getBreakdownPercentageAttribute(): array
    {
        $total = $this->total_anggaran;
        if ($total == 0) return [];

        return [
            'Penyelenggaraan Pemerintahan Desa' => round(($this->pemerintahan_desa / $total) * 100, 1),
            'Pelaksanaan Pembangunan Desa' => round(($this->pembangunan_desa / $total) * 100, 1),
            'Pembinaan Kemasyarakatan' => round(($this->kemasyarakatan / $total) * 100, 1),
            'Pemberdayaan Masyarakat' => round(($this->pemberdayaan / $total) * 100, 1),
            'Penanggulangan Bencana & Darurat' => round(($this->bencana_darurat / $total) * 100, 1),
        ];
    }

    // ============ STATIC METHODS ============

    /**
     * Get tahun terbaru yang ada APBDes
     */
    public static function getLatestYear(): ?int
    {
        return static::max('tahun');
    }

    /**
     * Get semua tahun yang ada APBDes
     */
    public static function getAllYears(): array
    {
        return static::orderBy('tahun', 'desc')->pluck('tahun')->toArray();
    }

    /**
     * Check apakah tahun sudah ada APBDes
     */
    public static function hasYear(int $tahun): bool
    {
        return static::where('tahun', $tahun)->exists();
    }
}
