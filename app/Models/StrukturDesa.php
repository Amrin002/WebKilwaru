<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StrukturDesa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'posisi',
        'image',
        'nik',
        'nip',
        'telepon',
        'email',
        'alamat',
        'twitter',
        'facebook',
        'instagram',
        'kategori',
        'urutan',
        'aktif',
        'mulai_menjabat',
        'selesai_menjabat',
        'deskripsi',
        'pendidikan_terakhir'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aktif' => 'boolean',
        'mulai_menjabat' => 'date',
        'selesai_menjabat' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope untuk hanya menampilkan pejabat aktif
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan urutan
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan', 'asc')->orderBy('nama', 'asc');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('posisi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        });
    }

    /**
     * Get formatted social media links
     */
    public function getSocialMediaAttribute(): array
    {
        return array_filter([
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
        ]);
    }

    /**
     * Get image URL with fallback
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists('struktur-desa/' . $this->image)) {
            return asset('storage/struktur-desa/' . $this->image);
        }

        // Default avatar
        return asset('images/default-avatar.png');
    }

    /**
     * Get masa jabatan (lama menjabat)
     */
    public function getMasaJabatanAttribute(): ?string
    {
        if (!$this->mulai_menjabat) {
            return null;
        }

        $mulai = Carbon::parse($this->mulai_menjabat);
        $selesai = $this->selesai_menjabat ? Carbon::parse($this->selesai_menjabat) : Carbon::now();

        $tahun = $mulai->diffInYears($selesai);
        $bulan = $mulai->copy()->addYears($tahun)->diffInMonths($selesai);

        $result = [];
        if ($tahun > 0) $result[] = $tahun . ' tahun';
        if ($bulan > 0) $result[] = $bulan . ' bulan';

        return empty($result) ? 'Kurang dari 1 bulan' : implode(' ', $result);
    }

    /**
     * Check if currently serving
     */
    public function getIsCurrentlyServingAttribute(): bool
    {
        if (!$this->aktif || !$this->mulai_menjabat) {
            return false;
        }

        $now = Carbon::now();
        $mulai = Carbon::parse($this->mulai_menjabat);
        $selesai = $this->selesai_menjabat ? Carbon::parse($this->selesai_menjabat) : null;

        return $now->greaterThanOrEqualTo($mulai) &&
            (!$selesai || $now->lessThanOrEqualTo($selesai));
    }

    /**
     * Get status jabatan
     */
    public function getStatusJabatanAttribute(): string
    {
        if (!$this->aktif) {
            return 'Tidak Aktif';
        }

        if ($this->is_currently_serving) {
            return 'Aktif';
        }

        if ($this->selesai_menjabat && Carbon::parse($this->selesai_menjabat)->isPast()) {
            return 'Masa Jabatan Berakhir';
        }

        return 'Belum Mulai';
    }

    /**
     * Kategori jabatan yang tersedia
     */
    public static function getKategoriList(): array
    {
        return [
            'kepala_desa' => 'Kepala Desa',
            'sekretaris' => 'Sekretaris Desa',
            'kaur_keuangan' => 'Kaur Keuangan',
            'kaur_perencanaan' => 'Kaur Perencanaan',
            'kaur_tata_usaha' => 'Kaur Tata Usaha',
            'kasi_pemerintahan' => 'Kasi Pemerintahan',
            'kasi_kesejahteraan' => 'Kasi Kesejahteraan',
            'kasi_pelayanan' => 'Kasi Pelayanan',
            'kadus' => 'Kepala Dusun',
            'bpd' => 'BPD',
            'lainnya' => 'Lainnya'
        ];
    }

    /**
     * Get display name for kategori
     */
    public function getKategoriDisplayAttribute(): string
    {
        $list = self::getKategoriList();
        return $list[$this->kategori] ?? $this->kategori ?? 'Tidak Diketahui';
    }
}
