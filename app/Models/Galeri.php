<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Galeri extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kegiatan',
        'foto',
        'keterangan'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the foto URL attribute.
     *
     * @return string
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            // Cek apakah foto sudah full URL (untuk external links)
            if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
                return $this->foto;
            }

            // Cek apakah file exists di storage
            if (Storage::disk('public')->exists($this->foto)) {
                // Gunakan asset() helper untuk generate URL
                return asset('storage/' . $this->foto);
            }
        }

        // Return placeholder image jika foto tidak ada
        return $this->getPlaceholderImage();
    }

    /**
     * Get placeholder image URL.
     *
     * @return string
     */
    private function getPlaceholderImage(): string
    {
        // Ukuran default untuk placeholder
        $width = 600;
        $height = 400;

        // Generate placeholder dengan nama kegiatan
        $text = urlencode(substr($this->nama_kegiatan ?? 'Foto Kegiatan', 0, 20));

        return "https://via.placeholder.com/{$width}x{$height}/2D5016/FFFFFF?text={$text}";
    }

    /**
     * Get the excerpt of keterangan.
     *
     * @param int $limit
     * @return string
     */
    public function getExcerpt(int $limit = 100): string
    {
        if (!$this->keterangan) {
            return '';
        }

        return \Illuminate\Support\Str::limit($this->keterangan, $limit);
    }

    /**
     * Get formatted creation date.
     *
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d F Y');
    }

    /**
     * Get relative creation date.
     *
     * @return string
     */
    public function getRelativeDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get file size if exists.
     *
     * @return string|null
     */
    public function getFileSizeAttribute(): ?string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            $sizeInBytes = Storage::disk('public')->size($this->foto);
            return $this->formatBytes($sizeInBytes);
        }

        return null;
    }

    /**
     * Format bytes to human readable format.
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get image dimensions if exists.
     *
     * @return array|null
     */
    public function getImageDimensionsAttribute(): ?array
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            $fullPath = Storage::disk('public')->path($this->foto);

            if (file_exists($fullPath)) {
                $dimensions = getimagesize($fullPath);

                if ($dimensions) {
                    return [
                        'width' => $dimensions[0],
                        'height' => $dimensions[1],
                        'formatted' => $dimensions[0] . ' x ' . $dimensions[1] . ' px'
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Check if image exists.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->foto && Storage::disk('public')->exists($this->foto);
    }

    /**
     * Scope untuk foto terbaru.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query, $limit = null)
    {
        $query = $query->orderBy('created_at', 'desc');

        if ($limit) {
            $query = $query->limit($limit);
        }

        return $query;
    }

    /**
     * Scope untuk filter berdasarkan tahun.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByYear($query, int $year)
    {
        return $query->whereYear('created_at', $year);
    }

    /**
     * Scope untuk filter berdasarkan bulan.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $month
     * @param int|null $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMonth($query, int $month, ?int $year = null)
    {
        $query = $query->whereMonth('created_at', $month);

        if ($year) {
            $query = $query->whereYear('created_at', $year);
        }

        return $query;
    }

    /**
     * Scope untuk pencarian.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
        });
    }

    /**
     * Get next galeri.
     *
     * @return \App\Models\Galeri|null
     */
    public function getNextAttribute(): ?Galeri
    {
        return static::where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Get previous galeri.
     *
     * @return \App\Models\Galeri|null
     */
    public function getPreviousAttribute(): ?Galeri
    {
        return static::where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get related galeri (excluding current).
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelated(int $limit = 6)
    {
        return static::where('id', '!=', $this->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Boot method untuk model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Event ketika model akan dihapus
        static::deleting(function ($galeri) {
            // Hapus file foto dari storage
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }
        });
    }

    /**
     * Convert model to array for API responses.
     *
     * @return array
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'nama_kegiatan' => $this->nama_kegiatan,
            'keterangan' => $this->keterangan,
            'foto_url' => $this->foto_url,
            'file_size' => $this->file_size,
            'dimensions' => $this->image_dimensions,
            'created_at' => $this->created_at->toISOString(),
            'formatted_date' => $this->formatted_date,
            'relative_date' => $this->relative_date,
        ];
    }

    /**
     * Static method untuk mendapatkan statistik.
     *
     * @return array
     */
    public static function getStatistics(): array
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        return [
            'total' => static::count(),
            'this_year' => static::byYear($currentYear)->count(),
            'this_month' => static::byMonth($currentMonth, $currentYear)->count(),
            'with_description' => static::whereNotNull('keterangan')->count(),
            'latest' => static::latest(5)->get(),
        ];
    }

    /**
     * Static method untuk mendapatkan arsip berdasarkan tahun.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArchives()
    {
        return static::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->year => $item->count];
            });
    }
}
