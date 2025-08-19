<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        'qr_code_path', // Tambah kolom QR Code
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
        // Pastikan ada nomor surat dari arsip
        if (!$this->nomor_surat) {
            // Ambil nomor surat dari arsip yang sudah ada atau generate baru
            $this->ambilNomorSuratDariArsip();
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
            // Generate QR Code setelah arsip berhasil dibuat/diupdate
            $this->autoGenerateQrCodeOnApproval();
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
     * Ambil nomor surat dari ArsipSurat (ArsipSurat yang generate)
     */
    protected function ambilNomorSuratDariArsip(): void
    {
        // Cek apakah sudah ada arsip
        $arsip = $this->arsip;

        if ($arsip && $arsip->nomor_surat) {
            // Gunakan nomor dari arsip yang sudah ada
            $this->nomor_surat = $arsip->nomor_surat;
            $this->save();
        } else {
            // Generate nomor baru melalui ArsipSurat
            $nomorBaru = ArsipSurat::generateNomorSurat('SKTM');
            $this->nomor_surat = $nomorBaru;
            $this->save();
        }
    }

    /**
     * Update status dan generate nomor surat jika disetujui - DIPERBAIKI
     */
    public function updateStatus(string $status, string $keterangan = null): bool
    {
        return DB::transaction(function () use ($status, $keterangan) {
            $oldStatus = $this->status = $status;

            if ($keterangan) {
                $this->keterangan = $keterangan;
            }

            // Generate nomor surat jika disetujui dan belum ada nomor
            if ($status === 'disetujui' && !$this->nomor_surat) {
                $this->nomor_surat = self::generateNomorSurat();
            }
            // Jika disetujui dan belum ada nomor surat
            if ($status === 'disetujui' && !$this->nomor_surat) {
                $this->ambilNomorSuratDariArsip();
            }

            $saved = $this->save();

            // Simpan ke arsip jika disetujui
            if ($saved && $status === 'disetujui') {
                $arsip = $this->simpanKeArsip();
                // Generate QR Code jika belum ada
                if (!$this->qr_code_path) {
                    $this->generateQrCodeForSurat();
                }
            }
            // Hapus QR Code jika status berubah dari disetujui ke lainnya
            if ($saved && $oldStatus === 'disetujui' && $status !== 'disetujui') {
                $this->deleteQrCode();
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
    // QR CODE SIMPLE INTEGRATION
    // ========================================
    /**
     * Cek apakah bisa generate QR Code
     */
    public function canGenerateQrCode(): bool
    {
        return $this->status === 'disetujui' && !empty($this->nomor_surat);
    }
    /**
     * Auto generate QR Code ketika ada nomor surat
     * Tidak perlu method kompleks, cukup ini saja
     */
    public function ensureQrCodeExists(): void
    {
        // Hanya generate jika:
        // 1. Ada nomor surat
        // 2. Status disetujui  
        // 3. Belum ada QR code
        if ($this->nomor_surat && $this->status === 'disetujui' && !$this->qr_code_path) {
            try {
                // Generate QR Code menggunakan trait HasQrCode
                $result = $this->generateQrCode();

                if ($result['success']) {
                    Log::info('QR Code auto-generated for SuratKtm', [
                        'surat_id' => $this->id,
                        'nomor_surat' => $this->nomor_surat
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Auto QR Code generation failed', [
                    'surat_id' => $this->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
    /**
     * Generate QR Code dan simpan sebagai file PNG
     */
    public function generateQrCodeForSurat(): array
    {
        try {
            if (!$this->canGenerateQrCode()) {
                return ['success' => false, 'error' => 'Surat belum disetujui atau nomor surat belum ada'];
            }

            // URL verifikasi
            $verifikasiUrl = route('verifikasi.surat', ['nomorSurat' => $this->nomor_surat]);

            // Generate QR Code menggunakan API online (PNG)
            $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=png&data=" . urlencode($verifikasiUrl);

            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'QR Generator'
                ]
            ]);

            $qrContent = @file_get_contents($qrApiUrl, false, $context);

            if ($qrContent && strlen($qrContent) > 100) {
                // Buat nama file
                $fileName = 'qr_' . $this->id . '_' . time() . '.png';
                $filePath = 'qr_codes/' . $fileName;

                // Simpan file ke storage/app/public/qr_codes/
                $saved = \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $qrContent);

                if ($saved) {
                    // Update path di database (bukan data base64)
                    $this->update(['qr_code_path' => $filePath]);

                    Log::info('QR Code file saved', [
                        'surat_id' => $this->id,
                        'file_path' => $filePath
                    ]);

                    return [
                        'success' => true,
                        'message' => 'QR Code berhasil dibuat',
                        'file_path' => $filePath
                    ];
                }
            }

            return ['success' => false, 'error' => 'Gagal download QR Code dari API'];
        } catch (\Exception $e) {
            Log::error('QR Code generation failed', [
                'surat_id' => $this->id,
                'error' => $e->getMessage()
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    /**
     * Get QR Code untuk PDF - ambil dari file yang tersimpan
     */
    public function getQrCodeForPdf(): ?string
    {
        if (!$this->nomor_surat || $this->status !== 'disetujui') {
            return null;
        }

        try {
            // Cek apakah ada file QR Code
            if ($this->qr_code_path && Storage::disk('public')->exists($this->qr_code_path)) {
                // Baca file dan convert ke base64
                $fileContent = Storage::disk('public')->get($this->qr_code_path);
                return 'data:image/png;base64,' . base64_encode($fileContent);
            }

            // Jika belum ada file, generate baru
            $result = $this->generateQrCodeForSurat();

            if ($result['success'] && $this->qr_code_path) {
                $fileContent = \Illuminate\Support\Facades\Storage::disk('public')->get($this->qr_code_path);
                return 'data:image/png;base64,' . base64_encode($fileContent);
            }

            return null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('QR Code for PDF failed', [
                'surat_id' => $this->id,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }
    // QUICK FIX: Ganti method getQrCodeBase64() yang sudah ada dengan ini
    // Method ini tidak memerlukan Imagick extension

    /**
     * Get QR Code base64 untuk PDF - NO IMAGICK REQUIRED
     */
    public function getQrCodeBase64($generateIfMissing = false): ?string
    {
        // Jika tidak ada nomor surat atau status belum disetujui, return null
        if (!$this->nomor_surat || $this->status !== 'disetujui') {
            return null;
        }

        try {
            // URL verifikasi
            $verifikasiUrl = route('verifikasi.surat', ['nomorSurat' => $this->nomor_surat]);

            // Method 1: Coba pakai SimpleSoftwareIO QrCode dengan SVG backend (tidak perlu Imagick)
            if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
                try {
                    // Gunakan SVG format yang tidak memerlukan Imagick
                    $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                        ->size(300)
                        ->margin(2)
                        ->generate($verifikasiUrl);

                    // Convert SVG ke base64
                    return 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                } catch (\Exception $e) {
                    // Jika SVG juga gagal, lanjut ke method fallback
                    \Illuminate\Support\Facades\Log::info('SVG QR generation failed, using fallback', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Method 2: Fallback menggunakan API online QR generator
            $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=png&data=" . urlencode($verifikasiUrl);

            // Set context untuk HTTP request
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (compatible; QR Generator)'
                ]
            ]);

            $qrContent = @file_get_contents($qrApiUrl, false, $context);

            if ($qrContent && strlen($qrContent) > 100) { // Pastikan dapat data yang valid
                return 'data:image/png;base64,' . base64_encode($qrContent);
            }

            // Method 3: Fallback terakhir - buat QR code sederhana dengan HTML/CSS
            return $this->generateSimpleQrCodeFallback($verifikasiUrl);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('All QR Code generation methods failed', [
                'surat_id' => $this->id,
                'error' => $e->getMessage()
            ]);

            // Return QR code placeholder sebagai fallback terakhir
            return $this->generateQrCodePlaceholder();
        }
    }

    /**
     * Generate QR Code placeholder jika semua method gagal
     */
    private function generateQrCodePlaceholder(): string
    {
        $verifikasiUrl = route('verifikasi.surat', ['nomorSurat' => $this->nomor_surat]);

        // Buat QR code placeholder dengan text
        $placeholderSvg = '
    <svg width="300" height="300" xmlns="http://www.w3.org/2000/svg">
        <rect width="300" height="300" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2"/>
        <text x="150" y="120" text-anchor="middle" font-family="Arial" font-size="14" fill="#6c757d">QR CODE</text>
        <text x="150" y="140" text-anchor="middle" font-family="Arial" font-size="12" fill="#6c757d">VERIFIKASI</text>
        <text x="150" y="170" text-anchor="middle" font-family="Arial" font-size="10" fill="#495057">' . $this->nomor_surat . '</text>
        <text x="150" y="200" text-anchor="middle" font-family="Arial" font-size="8" fill="#6c757d">Scan untuk verifikasi</text>
        <text x="150" y="220" text-anchor="middle" font-family="Arial" font-size="8" fill="#6c757d">atau kunjungi:</text>
        <text x="150" y="240" text-anchor="middle" font-family="Arial" font-size="7" fill="#007bff">verifikasi.domain.com</text>
    </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($placeholderSvg);
    }

    /**
     * Generate simple QR code fallback menggunakan library sederhana
     */
    private function generateSimpleQrCodeFallback($url): ?string
    {
        try {
            // Gunakan API QR generator alternatif
            $alternatives = [
                "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($url),
                "https://quickchart.io/qr?text=" . urlencode($url) . "&size=300",
                "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url)
            ];

            foreach ($alternatives as $apiUrl) {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 5,
                        'user_agent' => 'QR Generator Bot'
                    ]
                ]);

                $qrContent = @file_get_contents($apiUrl, false, $context);

                if ($qrContent && strlen($qrContent) > 100) {
                    return 'data:image/png;base64,' . base64_encode($qrContent);
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get info QR Code
     */
    public function getQrCodeInfoForSurat(): array
    {
        return [
            'has_qr_code' => $this->hasValidQrCode(),
            'qr_code_url' => $this->hasValidQrCode() ? asset('storage/' . $this->qr_code_path) : null,
            'can_generate' => $this->canGenerateQrCode(),
            'verifikasi_url' => $this->nomor_surat ? route('verifikasi.surat', ['nomorSurat' => $this->nomor_surat]) : null,
            'file_size' => $this->hasValidQrCode() ? Storage::disk('public')->size($this->qr_code_path) : 0,
            'created_at' => $this->updated_at->format('d/m/Y H:i')
        ];
    }

    public function hasValidQrCode(): bool
    {
        return !empty($this->qr_code) || $this->canGenerateQrCode();
    }
    /**
     * Hapus file QR Code
     */
    public function deleteQrCode(): bool
    {
        try {
            if ($this->qr_code_path && Storage::disk('public')->exists($this->qr_code_path)) {
                Storage::disk('public')->delete($this->qr_code_path);
            }

            $this->update(['qr_code_path' => null]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function regenerateQrCode(): array
    {
        return $this->generateQrCodeForSurat();
    }

    /**
     * Get QR Code download URL - FIXED
     */
    public function getQrCodeDownloadUrl(array $params = []): ?string
    {
        if (!$this->hasValidQrCode()) {
            return null;
        }
        return route('admin.surat-ktm.download-qr', array_merge(['id' => $this->id], $params));
    }




    /**
     * Auto generate ketika surat disetujui
     */
    public function autoGenerateQrCodeOnApproval(): void
    {
        if ($this->canGenerateQrCode() && !$this->hasValidQrCode()) {
            try {
                $result = $this->generateQrCodeForSurat();
                if ($result['success']) {
                    \Illuminate\Support\Facades\Log::info('QR Code auto-generated', [
                        'surat_id' => $this->id,
                        'file_path' => $this->qr_code_path
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Auto QR generation failed', [
                    'surat_id' => $this->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    // ========================================
    // BOOT METHOD - SIMPLIFIED
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

        // Auto generate QR Code ketika nomor surat ada dan status disetujui
        static::updated(function ($model) {
            if ($model->wasChanged(['nomor_surat', 'status'])) {
                $model->ensureQrCodeExists();
            }
        });

        // Cleanup QR Code dan arsip when deleting
        static::deleting(function ($model) {
            // Hapus QR Code jika ada
            if ($model->qr_code_path) {
                $model->deleteQrCode();
            }

            // Hapus arsip
            if ($model->arsip) {
                $model->arsip->delete();
            }
        });
    }
}
