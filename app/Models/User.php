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
        'no_hp'
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
