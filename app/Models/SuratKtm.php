<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratKtm extends Model
{
    use HasFactory;

    protected $table = 'surat_ktms';

    protected $fillable = [
        'nomor_surat',
        'public_token',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_kawin',
        'kewarganegaraan',
        'alamat',
        'keterangan',
        'status',
        'nomor_telepon',
        'user_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'datetime:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi polymorphic ke ArsipSurat
     */
    public function arsip()
    {
        return $this->morphOne(ArsipSurat::class, 'surat_detail');
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope berdasarkan status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope surat yang diproses
     */
    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    /**
     * Scope surat yang disetujui
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope surat yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope berdasarkan tahun
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->whereYear('created_at', $tahun);
    }

    /**
     * Scope berdasarkan bulan dan tahun
     */
    public function scopeBulanTahun($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('nomor_surat', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%");
        });
    }

    /**
     * Scope berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope surat guest (user_id null)
     */
    public function scopeGuest($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope surat user terdaftar (user_id tidak null)
     */
    public function scopeRegistered($query)
    {
        return $query->whereNotNull('user_id');
    }

    // ========================================
    // ACCESSORS
    // ========================================

    /**
     * Format tanggal lahir untuk display Indonesia
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        return $this->tanggal_lahir ?
            Carbon::parse($this->tanggal_lahir)->format('d/m/Y') : '-';
    }
    // Accessor khusus untuk form edit (format Y-m-d)
    public function getTanggalLahirForFormAttribute(): ?string
    {
        return $this->tanggal_lahir ?
            Carbon::parse($this->tanggal_lahir)->format('Y-m-d') : null;
    }
    /**
     * Nama lengkap dengan tempat, tanggal lahir
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->nama . ', ' . $this->tempat_lahir . ', ' . $this->tanggal_lahir_formatted;
    }

    /**
     * Status badge untuk display
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'diproses' => '<span class="badge bg-warning">Diproses</span>',
            'disetujui' => '<span class="badge bg-success">Disetujui</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Umur berdasarkan tanggal lahir
     */
    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    /**
     * Cek apakah surat dibuat oleh guest
     */
    public function getIsGuestAttribute(): bool
    {
        return is_null($this->user_id);
    }

    /**
     * Type pemohon
     */
    public function getTipePemohonAttribute(): string
    {
        return $this->is_guest ? 'Guest' : 'User Terdaftar';
    }

    // ========================================
    // MUTATORS
    // ========================================

    /**
     * Set nama to title case
     */
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }

    /**
     * Set tempat lahir to title case
     */
    public function setTempatLahirAttribute($value)
    {
        $this->attributes['tempat_lahir'] = ucwords(strtolower($value));
    }

    /**
     * Set alamat to title case
     */
    public function setAlamatAttribute($value)
    {
        $this->attributes['alamat'] = ucwords(strtolower($value));
    }

    // ========================================
    // USER ROLE BASED METHODS
    // ========================================

    /**
     * Buat surat baru untuk guest (dari landing page)
     */
    public static function createForGuest(array $data): self
    {
        // Validasi nomor telepon wajib untuk guest
        if (!isset($data['nomor_telepon']) || empty($data['nomor_telepon'])) {
            throw new \InvalidArgumentException('Nomor telepon wajib diisi untuk pendaftar guest');
        }

        $suratData = array_merge($data, [
            'user_id' => null,
            'status' => 'diproses',
            'public_token' => Str::random(32)
        ]);

        return static::create($suratData);
    }

    /**
     * Buat surat baru untuk user terdaftar
     */
    public static function createForUser(array $data, $userId = null): self
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            throw new \InvalidArgumentException('User ID diperlukan untuk membuat surat');
        }

        $suratData = array_merge($data, [
            'user_id' => $userId,
            'status' => 'diproses',
            'public_token' => Str::random(32)
        ]);

        return static::create($suratData);
    }

    /**
     * Admin dapat membuat surat atas nama siapa saja
     */
    public static function createByAdmin(array $data, $userId = null): self
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            throw new \Exception('Hanya admin yang dapat menggunakan method ini');
        }

        $suratData = array_merge($data, [
            'user_id' => $userId, // bisa null untuk guest atau user_id tertentu
            'status' => $data['status'] ?? 'diproses',
            'public_token' => Str::random(32)
        ]);

        // Admin bisa langsung set nomor surat jika disetujui
        if (isset($data['status']) && $data['status'] === 'disetujui') {
            $suratData['nomor_surat'] = $data['nomor_surat'] ?? static::generateNomorSurat();
        }

        return static::create($suratData);
    }

    /**
     * Cek apakah user dapat mengakses surat ini
     */
    public function canAccess($user = null): bool
    {
        $user = $user ?? Auth::user();

        // Admin bisa akses semua
        if ($user && $user->isAdmin()) {
            return true;
        }

        // User hanya bisa akses surat miliknya
        if ($user && $this->user_id === $user->id) {
            return true;
        }

        // Guest tidak bisa akses lewat method ini (harus lewat public token)
        return false;
    }

    /**
     * Cek apakah user dapat mengedit surat ini
     */
    public function canEdit($user = null): bool
    {
        $user = $user ?? Auth::user();

        // Admin bisa edit semua
        if ($user && $user->isAdmin()) {
            return true;
        }

        // User hanya bisa edit surat miliknya yang masih diproses
        if ($user && $this->user_id === $user->id && $this->status === 'diproses') {
            return true;
        }

        return false;
    }

    /**
     * Update status surat (khusus admin)
     */
    public function updateStatusByAdmin(string $status, string $keterangan = null, $userId = null): bool
    {
        $user = $userId ? User::find($userId) : Auth::user();

        if (!$user || !$user->isAdmin()) {
            throw new \Exception('Hanya admin yang dapat mengubah status surat');
        }

        return $this->updateStatus($status, $keterangan);
    }

    /**
     * Update data surat oleh pemohon (user terdaftar atau guest via token)
     */
    public function updateByPemohon(array $data, $user = null, string $publicToken = null): bool
    {
        // Cek authorization
        if ($publicToken) {
            // Update via public token (guest)
            if ($this->public_token !== $publicToken) {
                throw new \Exception('Token tidak valid');
            }

            if ($this->status !== 'diproses') {
                throw new \InvalidArgumentException('Surat tidak dapat diubah karena sudah diproses');
            }
        } else {
            // Update via user login
            if (!$this->canEdit($user)) {
                throw new \Exception('Anda tidak memiliki akses untuk mengubah surat ini');
            }
        }

        // Filter data yang boleh diubah pemohon
        $allowedFields = [
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'status_kawin',
            'kewarganegaraan',
            'alamat',
            'nomor_telepon'
        ];

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        return $this->update($updateData);
    }

    /**
     * Ambil surat berdasarkan public token (untuk guest)
     */
    public static function findByPublicToken(string $token): ?self
    {
        return static::where('public_token', $token)->first();
    }

    /**
     * Generate link tracking untuk guest
     */
    public function getTrackingUrl(): string
    {
        return url('/track/' . $this->public_token);
    }

    // ========================================
    // HELPER METHODS - DIPERBAIKI
    // ========================================

    /**
     * Generate public token untuk akses publik
     */
    public function generatePublicToken(): string
    {
        $token = Str::random(32);
        $this->update(['public_token' => $token]);
        return $token;
    }

    /**
     * Generate nomor surat otomatis - DIPERBAIKI
     * Mengecek nomor dari kedua tabel: surat_ktms dan arsip_surat
     */
    public static function generateNomorSurat(): string
    {
        $tahun = date('Y');
        $bulan = date('n');

        // Format bulan ke romawi
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        // Cek nomor terakhir dari KEDUA tabel
        $maxFromSuratKtm = static::whereYear('created_at', $tahun)
            ->where('nomor_surat', 'like', '%/SKTM/%')
            ->selectRaw('MAX(CAST(SUBSTRING_INDEX(nomor_surat, "/", 1) AS UNSIGNED)) as max_number')
            ->value('max_number') ?? 0;

        $maxFromArsip = ArsipSurat::whereYear('tanggal_surat', $tahun)
            ->where('nomor_surat', 'like', '%/SKTM/%')
            ->selectRaw('MAX(CAST(SUBSTRING_INDEX(nomor_surat, "/", 1) AS UNSIGNED)) as max_number')
            ->value('max_number') ?? 0;

        // Ambil nilai maksimum dari kedua tabel
        $nomorUrut = max($maxFromSuratKtm, $maxFromArsip) + 1;

        // Format: 001/SKTM/NK/I/2025
        return sprintf(
            '%03d/SKTM/NK/%s/%d',
            $nomorUrut,
            $bulanRomawi[$bulan],
            $tahun
        );
    }

    /**
     * Simpan ke arsip otomatis ketika disetujui - DIPERBAIKI
     * Menghindari duplikasi dan memastikan arsip tersimpan
     */
    public function simpanKeArsip(): ?ArsipSurat
    {
        if ($this->status !== 'disetujui' || !$this->nomor_surat) {
            return null;
        }

        // Cek apakah sudah ada arsip untuk surat ini
        $existingArsip = ArsipSurat::where('surat_detail_type', self::class)
            ->where('surat_detail_id', $this->id)
            ->first();

        if ($existingArsip) {
            // Update arsip yang sudah ada
            $existingArsip->update([
                'nomor_surat' => $this->nomor_surat,
                'tanggal_surat' => now()->toDateString(),
                'tujuan_surat' => $this->nama,
                'tentang' => 'Surat Keterangan Tidak Mampu - ' . $this->nama,
                'keterangan' => 'Diupdate melalui sistem pada ' . now()->format('d/m/Y H:i')
            ]);
            return $existingArsip;
        }

        // Buat arsip baru menggunakan DB transaction untuk memastikan konsistensi
        return DB::transaction(function () {
            $arsip = ArsipSurat::create([
                'nomor_surat' => $this->nomor_surat,
                'tanggal_surat' => now()->toDateString(),
                'tujuan_surat' => $this->nama,
                'tentang' => 'Surat Keterangan Tidak Mampu - ' . $this->nama,
                'keterangan' => 'Dibuat melalui sistem',
                'surat_detail_type' => self::class,
                'surat_detail_id' => $this->id
            ]);

            return $arsip;
        });
    }

    /**
     * Update status dan generate nomor surat jika disetujui - DIPERBAIKI
     */
    public function updateStatus(string $status, string $keterangan = null): bool
    {
        return DB::transaction(function () use ($status, $keterangan) {
            $this->status = $status;

            if ($keterangan) {
                $this->keterangan = $keterangan;
            }

            // Generate nomor surat jika disetujui dan belum ada nomor
            if ($status === 'disetujui' && !$this->nomor_surat) {
                $this->nomor_surat = self::generateNomorSurat();
            }

            $saved = $this->save();

            // Simpan ke arsip jika disetujui
            if ($saved && $status === 'disetujui') {
                $this->simpanKeArsip();
            }

            return $saved;
        });
    }

    /**
     * Cek apakah sudah disetujui
     */
    public function isDisetujui(): bool
    {
        return $this->status === 'disetujui';
    }

    /**
     * Cek apakah ditolak
     */
    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }

    /**
     * Cek apakah masih diproses
     */
    public function isDiproses(): bool
    {
        return $this->status === 'diproses';
    }

    // ========================================
    // STATIC METHODS
    // ========================================

    /**
     * Statistik surat per status
     */
    public static function statistikStatus(int $tahun = null): array
    {
        $query = static::selectRaw('status, COUNT(*) as total');

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $result = $query->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Ensure all statuses are present
        return array_merge([
            'diproses' => 0,
            'disetujui' => 0,
            'ditolak' => 0
        ], $result);
    }

    /**
     * Statistik berdasarkan tipe pemohon
     */
    public static function statistikTipePemohon(int $tahun = null): array
    {
        $query = static::selectRaw('
            CASE 
                WHEN user_id IS NULL THEN "guest" 
                ELSE "user" 
            END as tipe,
            COUNT(*) as total
        ');

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $result = $query->groupByRaw('
            CASE 
                WHEN user_id IS NULL THEN "guest" 
                ELSE "user" 
            END
        ')->pluck('total', 'tipe')->toArray();

        // Ensure both types are present
        return array_merge([
            'guest' => 0,
            'user' => 0
        ], $result);
    }

    /**
     * Surat terbaru
     */
    public static function suratTerbaru(int $limit = 10)
    {
        return static::with('user')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Total surat per bulan
     */
    public static function totalPerBulan(int $tahun): array
    {
        return static::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan')
            ->toArray();
    }

    /**
     * Daftar surat untuk dashboard admin
     */
    public static function forAdminDashboard(array $filters = [])
    {
        $query = static::with('user');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['tipe_pemohon'])) {
            if ($filters['tipe_pemohon'] === 'guest') {
                $query->whereNull('user_id');
            } elseif ($filters['tipe_pemohon'] === 'user') {
                $query->whereNotNull('user_id');
            }
        }

        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        if (isset($filters['tahun'])) {
            $query->tahun($filters['tahun']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Daftar surat untuk user dashboard
     */
    public static function forUserDashboard($userId = null)
    {
        $userId = $userId ?? Auth::id();

        return static::where('user_id', $userId)
            ->orderBy('created_at', 'desc');
    }

    // ========================================
    // BOOT METHOD
    // ========================================

    protected static function boot()
    {
        parent::boot();

        // Auto generate public token
        static::creating(function ($model) {
            if (!$model->public_token) {
                $model->public_token = Str::random(32);
            }
        });

        // Cleanup arsip when deleting surat
        static::deleting(function ($model) {
            if ($model->arsip) {
                $model->arsip->delete();
            }
        });
    }
}
