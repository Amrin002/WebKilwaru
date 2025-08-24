<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'umkms';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nik',
        'nama_umkm',
        'kategori',
        'nama_produk',
        'deskripsi_produk',
        'foto_produk',
        'nomor_telepon',
        'link_facebook',
        'link_instagram',
        'link_tiktok',
        'status',
        'catatan_admin',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'nik', // NIK tidak boleh tampil di public API
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relasi dengan model Penduduk (berdasarkan NIK)
     */
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }

    /**
     * Relasi dengan User (admin yang approve)
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========================================
    // ACCESSORS & MUTATORS
    // ========================================

    /**
     * Accessor untuk mendapatkan URL foto produk
     */
    public function getFotoProdukUrlAttribute(): string
    {
        if ($this->foto_produk) {
            return asset('storage/umkm-photos/' . $this->foto_produk);
        }

        // Return placeholder image jika tidak ada foto
        return asset('images/umkm-placeholder.jpg');
    }

    /**
     * Accessor untuk mendapatkan nama pemilik dari relasi penduduk
     */
    public function getNamaPemilikAttribute(): ?string
    {
        return $this->penduduk?->nama_lengkap;
    }

    /**
     * Accessor untuk format nama kategori yang user-friendly
     */
    public function getKategoriLabelAttribute(): string
    {
        $kategoriLabels = [
            'makanan' => 'Makanan & Minuman',
            'jasa' => 'Jasa & Layanan',
            'kerajinan' => 'Kerajinan & Handicraft',
            'pertanian' => 'Pertanian & Peternakan',
            'perdagangan' => 'Perdagangan & Retail',
            'lainnya' => 'Lainnya',
        ];

        return $kategoriLabels[$this->kategori] ?? $this->kategori;
    }

    /**
     * Accessor untuk status badge dengan styling
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge bg-warning text-dark">Menunggu Verifikasi</span>',
            'approved' => '<span class="badge bg-success">Disetujui</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Accessor untuk WhatsApp URL dengan pre-filled message
     */
    public function getWhatsappUrlAttribute(): string
    {
        $cleanNumber = $this->convertToWhatsAppNumber($this->nomor_telepon);

        // Pre-filled message
        $message = urlencode("Halo, saya tertarik dengan {$this->nama_produk} dari {$this->nama_umkm}. Bisa info lebih detail?");

        return "https://wa.me/{$cleanNumber}?text={$message}";
    }

    /**
     * Accessor untuk deskripsi singkat (truncated)
     */
    public function getDeskripsiSingkatAttribute(): string
    {
        return Str::limit($this->deskripsi_produk, 100, '...');
    }

    /**
     * Accessor untuk lama waktu sejak approved
     */
    public function getApprovedAgoAttribute(): ?string
    {
        if (!$this->approved_at) {
            return null;
        }

        return $this->approved_at->diffForHumans();
    }

    /**
     * Mutator untuk nomor telepon (normalisasi format)
     */
    public function setNomorTeleponAttribute($value): void
    {
        // Bersihkan dan normalisasi nomor telepon
        $cleaned = $this->convertToWhatsAppNumber($value);
        $this->attributes['nomor_telepon'] = $cleaned;
    }

    /**
     * Mutator untuk uppercase nama UMKM
     */
    public function setNamaUmkmAttribute($value): void
    {
        $this->attributes['nama_umkm'] = ucwords(strtolower(trim($value)));
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope untuk filter UMKM yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk filter UMKM yang masih pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk filter UMKM yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk search berdasarkan nama UMKM atau produk
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_umkm', 'like', "%{$search}%")
                ->orWhere('nama_produk', 'like', "%{$search}%")
                ->orWhere('deskripsi_produk', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk urutkan berdasarkan yang terbaru disetujui
     */
    public function scopeLatestApproved($query)
    {
        return $query->approved()
            ->orderBy('approved_at', 'desc')
            ->orderBy('created_at', 'desc');
    }

    // ========================================
    // STATIC METHODS
    // ========================================

    /**
     * Daftar kategori yang tersedia
     */
    public static function getKategoriOptions(): array
    {
        return [
            'makanan' => 'Makanan & Minuman',
            'jasa' => 'Jasa & Layanan',
            'kerajinan' => 'Kerajinan & Handicraft',
            'pertanian' => 'Pertanian & Peternakan',
            'perdagangan' => 'Perdagangan & Retail',
            'lainnya' => 'Lainnya',
        ];
    }

    /**
     * Daftar status yang tersedia
     */
    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];
    }

    // ========================================
    // INSTANCE METHODS
    // ========================================

    /**
     * Method untuk approve UMKM
     */
    public function approve($adminId = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $adminId,
            'catatan_admin' => null, // Clear rejection note
        ]);
    }

    /**
     * Method untuk reject UMKM dengan catatan
     */
    public function reject($catatan = null, $adminId = null): bool
    {
        return $this->update([
            'status' => 'rejected',
            'catatan_admin' => $catatan,
            'approved_at' => null,
            'approved_by' => $adminId,
        ]);
    }

    /**
     * Check apakah UMKM sudah disetujui
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check apakah UMKM masih pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check apakah UMKM ditolak
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get social media links yang ada
     */
    public function getSocialMediaLinks(): array
    {
        $links = [];

        if ($this->link_facebook) {
            $links['facebook'] = [
                'url' => $this->link_facebook,
                'icon' => 'fab fa-facebook-f',
                'color' => '#1877F2',
                'label' => 'Facebook'
            ];
        }

        if ($this->link_instagram) {
            $links['instagram'] = [
                'url' => $this->link_instagram,
                'icon' => 'fab fa-instagram',
                'color' => '#E4405F',
                'label' => 'Instagram'
            ];
        }

        if ($this->link_tiktok) {
            $links['tiktok'] = [
                'url' => $this->link_tiktok,
                'icon' => 'fab fa-tiktok',
                'color' => '#000000',
                'label' => 'TikTok'
            ];
        }

        return $links;
    }

    /**
     * Delete foto produk dari storage
     */
    public function deleteFotoProduk(): bool
    {
        if ($this->foto_produk && Storage::disk('public')->exists('umkm-photos/' . $this->foto_produk)) {
            return Storage::disk('public')->delete('umkm-photos/' . $this->foto_produk);
        }

        return true;
    }

    /**
     * Convert nomor telepon ke format WhatsApp yang benar
     */
    private function convertToWhatsAppNumber($phoneNumber): string
    {
        // Hapus semua karakter non-digit kecuali +
        $cleanNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Handle berbagai format nomor Indonesia
        if (preg_match('/^0[8-9]\d{8,11}$/', $cleanNumber)) {
            // Format: 0852xxxxxxxx, 0812xxxxxxxx, etc (nomor Indonesia yang diawali 0)
            $cleanNumber = '62' . substr($cleanNumber, 1);
        } elseif (preg_match('/^[8-9]\d{8,11}$/', $cleanNumber)) {
            // Format: 852xxxxxxxx, 812xxxxxxxx (tanpa leading 0)
            $cleanNumber = '62' . $cleanNumber;
        } elseif (str_starts_with($cleanNumber, '62')) {
            // Sudah format 62xxxxxxxxx
            $cleanNumber = $cleanNumber;
        } elseif (str_starts_with($cleanNumber, '+62')) {
            // Format +62xxxxxxxxx, hapus +
            $cleanNumber = substr($cleanNumber, 1);
        } elseif (!str_starts_with($cleanNumber, '+') && !str_starts_with($cleanNumber, '62')) {
            // Jika tidak ada country code sama sekali, assumsi Indonesia
            $cleanNumber = '62' . $cleanNumber;
        }

        // Pastikan format akhir adalah 62xxxxxxxxx (tanpa +)
        $cleanNumber = ltrim($cleanNumber, '+');

        return $cleanNumber;
    }

    // ========================================
    // MODEL EVENTS
    // ========================================

    /**
     * Boot method untuk model events
     */
    protected static function boot()
    {
        parent::boot();

        // Ketika UMKM dihapus, hapus juga fotonya
        static::deleting(function ($umkm) {
            $umkm->deleteFotoProduk();
        });

        // Auto set approved_at ketika status berubah ke approved
        static::updating(function ($umkm) {
            if ($umkm->isDirty('status') && $umkm->status === 'approved' && !$umkm->approved_at) {
                $umkm->approved_at = now();
            }
        });
    }
}
