<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'no_hp',
        'nik',
        'is_verified_citizen',
        'nik_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified_citizen' => 'boolean',    // ← Tambahkan ini
            'nik_verified_at' => 'datetime',       // ← Tambahkan ini
        ];
    }
    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->roles === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->roles === 'user';
    }

    /**
     * Get user role name for display
     */
    public function getRoleDisplayName(): string
    {
        return match ($this->roles) {
            'admin' => 'Administrator',
            'user' => 'Pengguna',
            default => 'Tidak Diketahui'
        };
    }
    /**
     * Relasi ke surat KTM
     */
    public function suratKtm()
    {
        return $this->hasMany(SuratKtm::class);
    }

    // Relasi ke Surat KTU
    public function suratKtu()
    {
        return $this->hasMany(SuratKtu::class);
    }

    // Relasi ke Surat KPT
    public function suratKpt()
    {
        return $this->hasMany(SuratKpt::class);
    }
// ========================================
    // NIK VALIDATION & CITIZEN VERIFICATION
    // ========================================

    /**
     * Check if user is verified citizen (has valid NIK)
     */
    public function isVerifiedCitizen(): bool
    {
        return $this->is_verified_citizen && !is_null($this->nik);
    }

    /**
     * Check if user can register using NIK
     */
    public function canRegisterWithNIK(): bool
    {
        return is_null($this->nik) || !$this->is_verified_citizen;
    }

    /**
     * Verify user's NIK against Penduduk data
     */
    public function verifyNIK(string $nik): bool
    {
        $penduduk = Penduduk::where('nik', $nik)->first();
        
        if (!$penduduk) {
            return false;
        }

        // Update user dengan NIK dan status verifikasi
        $this->update([
            'nik' => $nik,
            'is_verified_citizen' => true,
            'nik_verified_at' => now(),
            // Optional: Update nama sesuai data penduduk
            'name' => $penduduk->nama_lengkap
        ]);

        return true;
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }
    public function scopeVerifiedCitizens($query)
    {
        return $query->where('is_verified_citizen', true)->whereNotNull('nik');
    }
    
    /**
     * Ambil surat KTM terbaru milik user
     */
    public function latestSuratKtm(int $limit = 5)
    {
        return $this->suratKtm()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Ambil surat KTU terbaru milik user
     */
    public function latestSuratKtu(int $limit = 5)
    {
        return $this->suratKtu()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Ambil surat KPT terbaru milik user
     */
    public function latestSuratKpt(int $limit = 5)
    {
        return $this->suratKpt()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
