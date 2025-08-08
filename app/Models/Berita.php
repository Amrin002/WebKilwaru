<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Berita extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'beritas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'konten',
        'gambar',
        'kategori',
        'penulis',
        'status',
        'is_featured',
        'views',
        'tags',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'views' => 'integer',
        'tags' => 'array',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug when creating
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        // Auto generate excerpt if not provided
        static::creating(function ($berita) {
            if (empty($berita->excerpt)) {
                $berita->excerpt = Str::limit(strip_tags($berita->konten), 150);
            }
        });
    }

    /**
     * Relasi dengan model KategoriBeri
     */
    public function kategoriBeri(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori', 'slug');
    }

    /**
     * Scope untuk berita yang sudah published
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope untuk berita featured
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk search berita
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('konten', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%")
                ->orWhere('tags', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk berita terbaru
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope untuk berita populer (berdasarkan views)
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Accessor untuk mendapatkan URL gambar lengkap
     */
    public function getGambarUrlAttribute(): ?string
    {
        if ($this->gambar) {
            return asset('storage/berita/' . $this->gambar);
        }
        return asset('assets/img/default-news.jpg'); // Default image
    }

    /**
     * Accessor untuk mendapatkan excerpt dengan format yang baik
     */
    public function getExcerptFormattedAttribute(): string
    {
        return Str::limit($this->excerpt, 100);
    }

    /**
     * Accessor untuk mendapatkan tanggal publikasi dalam format Indonesia
     */
    public function getPublishedAtFormattedAttribute(): string
    {
        if ($this->published_at) {
            return $this->published_at->locale('id')->isoFormat('dddd, D MMMM Y');
        }
        return '';
    }

    /**
     * Accessor untuk mendapatkan waktu publikasi relatif
     */
    public function getPublishedAtRelativeAttribute(): string
    {
        if ($this->published_at) {
            return $this->published_at->locale('id')->diffForHumans();
        }
        return '';
    }

    /**
     * Accessor untuk mendapatkan estimated reading time
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->konten));
        return ceil($wordCount / 200); // Assuming 200 words per minute
    }

    /**
     * Accessor untuk mendapatkan status badge
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'published' => '<span class="badge bg-success">Published</span>',
            'draft' => '<span class="badge bg-warning">Draft</span>',
            'archived' => '<span class="badge bg-secondary">Archived</span>',
            default => '<span class="badge bg-light">Unknown</span>'
        };
    }

    /**
     * Method untuk increment views
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Method untuk mendapatkan berita terkait
     */
    public function getRelatedNews(int $limit = 4)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where('kategori', $this->kategori)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Method untuk mendapatkan URL berita
     */
    public function getUrlAttribute(): string
    {
        return route('berita.show', $this->slug);
    }
}
