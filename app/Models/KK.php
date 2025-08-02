<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KK extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'k_k_s';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'no_kk';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_kk',
        'alamat',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos'
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
     * Get full address
     *
     * @return string
     */
    public function getAlamatLengkapAttribute()
    {
        return "{$this->alamat} RT {$this->rt}/RW {$this->rw}, Desa {$this->desa}, Kec. {$this->kecamatan}, {$this->kabupaten}, {$this->provinsi} {$this->kode_pos}";
    }

    /**
     * Scope a query to search by address components
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('no_kk', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('desa', 'like', "%{$search}%")
                ->orWhere('kecamatan', 'like', "%{$search}%")
                ->orWhere('kabupaten', 'like', "%{$search}%")
                ->orWhere('provinsi', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by location
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByLocation($query, array $filters)
    {
        return $query->when($filters['provinsi'] ?? null, function ($q, $provinsi) {
            $q->where('provinsi', $provinsi);
        })->when($filters['kabupaten'] ?? null, function ($q, $kabupaten) {
            $q->where('kabupaten', $kabupaten);
        })->when($filters['kecamatan'] ?? null, function ($q, $kecamatan) {
            $q->where('kecamatan', $kecamatan);
        })->when($filters['desa'] ?? null, function ($q, $desa) {
            $q->where('desa', $desa);
        });
    }
}
