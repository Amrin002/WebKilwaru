<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class KategoriBerita extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'kategori_beritas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'warna',
        'icon',
        'is_active',
        'urutan',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug when creating
        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });

        // Ensure unique slug
        static::saving(function ($kategori) {
            $originalSlug = $kategori->slug;
            $counter = 1;

            while (static::where('slug', $kategori->slug)
                ->where('id', '!=', $kategori->id ?? 0)
                ->exists()
            ) {
                $kategori->slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        });
    }

    /**
     * Relasi dengan model Berita
     */
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori', 'slug');
    }

    /**
     * Relasi dengan berita yang sudah published
     */
    public function publishedBeritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori', 'slug')
            ->published();
    }

    /**
     * Scope untuk kategori aktif
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk ordering berdasarkan urutan
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan', 'asc')
            ->orderBy('nama', 'asc');
    }

    /**
     * Accessor untuk mendapatkan jumlah berita
     */
    public function getJumlahBeritaAttribute(): int
    {
        return $this->beritas()->count();
    }

    /**
     * Accessor untuk mendapatkan jumlah berita published
     */
    public function getJumlahBeritaPublishedAttribute(): int
    {
        return $this->publishedBeritas()->count();
    }

    /**
     * Accessor untuk mendapatkan icon dengan fallback
     */
    // Di model KategoriBerita.php
    public function getIconWithFallbackAttribute()
    {
        if ($this->icon) {
            // Untuk Font Awesome
            return '<i class="' . $this->icon . '"></i>';
        }
        // Default icon jika tidak ada
        return '<i class="fas fa-folder"></i>';
    }

    /**
     * Accessor untuk mendapatkan badge dengan warna
     */
    public function getBadgeAttribute(): string
    {
        return '<span class="badge" style="background-color: ' . $this->warna . '">' .
            $this->nama .
            '</span>';
    }

    /**
     * Method untuk mendapatkan URL kategori
     */
    public function getUrlAttribute(): string
    {
        return route('berita.kategori', $this->slug);
    }

    /**
     * Method untuk mendapatkan berita terbaru dari kategori ini
     */
    public function getLatestNews(int $limit = 5)
    {
        return $this->publishedBeritas()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
