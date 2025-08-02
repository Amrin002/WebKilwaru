<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Penduduk extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'penduduks';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'nik';

    /**
     * The "type" of the primary key ID.
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status',
        'status_keluarga',
        'golongan_darah',
        'kewarganegaraan',
        'nama_ayah',
        'nama_ibu',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Relasi dengan model KK (Kartu Keluarga)
     */
    public function kk(): BelongsTo
    {
        return $this->belongsTo(KK::class, 'no_kk', 'no_kk');
    }

    /**
     * Accessor untuk mendapatkan umur berdasarkan tanggal lahir
     */
    public function getUmurAttribute(): int
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    /**
     * Accessor untuk mendapatkan nama lengkap dengan format title case
     */
    public function getNamaLengkapFormattedAttribute(): string
    {
        return ucwords(strtolower($this->nama_lengkap));
    }

    /**
     * Accessor untuk mendapatkan tempat dan tanggal lahir
     */
    public function getTempatTanggalLahirAttribute(): string
    {
        return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d F Y');
    }

    /**
     * Scope untuk filter berdasarkan jenis kelamin
     */
    public function scopeLakiLaki($query)
    {
        return $query->where('jenis_kelamin', 'Laki-laki');
    }

    /**
     * Scope untuk filter berdasarkan jenis kelamin
     */
    public function scopePerempuan($query)
    {
        return $query->where('jenis_kelamin', 'Perempuan');
    }

    /**
     * Scope untuk filter berdasarkan agama
     */
    public function scopeByAgama($query, $agama)
    {
        return $query->where('agama', $agama);
    }

    /**
     * Scope untuk filter berdasarkan status keluarga
     */
    public function scopeByStatusKeluarga($query, $status)
    {
        return $query->where('status_keluarga', $status);
    }

    /**
     * Scope untuk mencari berdasarkan nama
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where('nama_lengkap', 'LIKE', '%' . $name . '%');
    }

    /**
     * Scope untuk filter berdasarkan rentang umur
     */
    public function scopeByAgeRange($query, $minAge, $maxAge)
    {
        $maxDate = Carbon::now()->subYears($minAge)->format('Y-m-d');
        $minDate = Carbon::now()->subYears($maxAge + 1)->format('Y-m-d');

        return $query->whereBetween('tanggal_lahir', [$minDate, $maxDate]);
    }

    /**
     * Scope untuk kepala keluarga
     */
    public function scopeKepalaKeluarga($query)
    {
        return $query->where('status_keluarga', 'Kepala Keluarga');
    }

    /**
     * Method untuk cek apakah sudah dewasa (17 tahun ke atas)
     */
    public function isDewasa(): bool
    {
        return $this->umur >= 17;
    }

    /**
     * Method untuk cek apakah dalam usia produktif (15-64 tahun)
     */
    public function isUsiaProduktif(): bool
    {
        return $this->umur >= 15 && $this->umur <= 64;
    }

    /**
     * Method untuk cek apakah lansia (65 tahun ke atas)
     */
    public function isLansia(): bool
    {
        return $this->umur >= 65;
    }

    /**
     * Method untuk cek apakah anak-anak (kurang dari 15 tahun)
     */
    public function isAnak(): bool
    {
        return $this->umur < 15;
    }
}
