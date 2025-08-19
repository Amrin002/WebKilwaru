<?php

namespace App\Models;

use App\HasQrCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ArsipSurat extends Model
{
    use HasFactory, HasQrCode;

    protected $table = 'arsip_surat';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'tujuan_surat',
        'tentang',
        'keterangan',
        'surat_detail_type',
        'surat_detail_id'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_surat' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relasi polymorphic ke detail surat
     */
    public function suratDetail()
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke verifikasi logs
     */
    public function verifikasiLogs()
    {
        return $this->hasMany(VerifikasiSurat::class, 'nomor_surat', 'nomor_surat');
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope untuk surat masuk (yang ada pengirim)
     */
    public function scopeSuratMasuk($query)
    {
        return $query->whereNotNull('pengirim');
    }

    /**
     * Scope untuk surat keluar (yang ada tujuan)
     */
    public function scopeSuratKeluar($query)
    {
        return $query->whereNotNull('tujuan_surat');
    }

    /**
     * Scope berdasarkan tahun
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->whereYear('tanggal_surat', $tahun);
    }

    /**
     * Scope berdasarkan bulan dan tahun
     */
    public function scopeBulanTahun($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('tanggal_surat', $bulan)
            ->whereYear('tanggal_surat', $tahun);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('pengirim', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%")
                ->orWhere('tujuan_surat', 'like', "%{$search}%")
                ->orWhere('tentang', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%");
        });
    }

    /**
     * Scope berdasarkan jenis surat detail
     */
    public function scopeJenisSurat($query, string $jenis)
    {
        $modelMap = [
            'ktm' => SuratKtm::class,
            // 'skpt' => SuratSkpt::class,
            // 'skd' => SuratSkd::class,
            // Tambah jenis surat lainnya
        ];

        if (isset($modelMap[$jenis])) {
            return $query->where('surat_detail_type', $modelMap[$jenis]);
        }

        return $query;
    }

    // ========================================
    // ACCESSORS
    // ========================================

    /**
     * Format tanggal untuk display Indonesia
     */
    public function getTanggalSuratFormattedAttribute(): string
    {
        return $this->tanggal_surat ?
            $this->tanggal_surat->format('d/m/Y') : '-';
    }

    /**
     * Deteksi kategori surat (masuk/keluar)
     */
    public function getKategoriSuratAttribute(): string
    {
        if ($this->pengirim) {
            return 'masuk';
        } elseif ($this->tujuan_surat) {
            return 'keluar';
        }
        return 'tidak diketahui';
    }

    /**
     * Konten utama surat (perihal atau tentang)
     */
    public function getKontenUtamaAttribute(): string
    {
        return $this->perihal ?: $this->tentang ?: '-';
    }

    /**
     * Pihak terkait (pengirim atau tujuan)
     */
    public function getPihakTerkaitAttribute(): string
    {
        return $this->pengirim ?: $this->tujuan_surat ?: '-';
    }

    /**
     * Nama jenis surat berdasarkan detail type
     */
    public function getJenisSuratAttribute(): string
    {
        if (!$this->surat_detail_type) {
            return 'Manual';
        }

        $typeMap = [
            SuratKtm::class => 'KTM',
            // SuratSkpt::class => 'SKPT',
            // SuratSkd::class => 'SKD',
        ];

        return $typeMap[$this->surat_detail_type] ?? 'Unknown';
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    /**
     * Cek apakah surat masuk
     */
    public function isSuratMasuk(): bool
    {
        return !is_null($this->pengirim);
    }

    /**
     * Cek apakah surat keluar
     */
    public function isSuratKeluar(): bool
    {
        return !is_null($this->tujuan_surat);
    }

    /**
     * Cek apakah memiliki detail surat
     */
    public function hasDetailSurat(): bool
    {
        return !is_null($this->surat_detail_type) && !is_null($this->surat_detail_id);
    }

    /**
     * Generate nomor urut berikutnya untuk tahun ini
     */
    public static function generateNomorUrut(int $tahun = null, string $jenisSurat = null): int
    {
        $tahun = $tahun ?: date('Y');

        // Jika ada jenis surat, filter berdasarkan jenis surat juga
        $query = static::suratKeluar() // filter surat keluar
            ->whereYear('tanggal_surat', $tahun);

        // Filter berdasarkan jenis surat jika diperlukan
        if ($jenisSurat) {
            $query->where('nomor_surat', 'like', "%/{$jenisSurat}/%");
        }

        $lastNumber = $query->selectRaw('MAX(CAST(SUBSTRING_INDEX(nomor_surat, "/", 1) AS UNSIGNED)) as max_number')
            ->value('max_number') ?? 0;

        return $lastNumber + 1;
    }
    /**
     * Statistik surat per bulan
     */
    public static function statistikBulanan(int $tahun): array
    {
        return static::selectRaw('MONTH(tanggal_surat) as bulan, 
                                  COUNT(CASE WHEN pengirim IS NOT NULL THEN 1 END) as surat_masuk,
                                  COUNT(CASE WHEN tujuan_surat IS NOT NULL THEN 1 END) as surat_keluar,
                                  COUNT(*) as total')
            ->whereYear('tanggal_surat', $tahun)
            ->groupByRaw('MONTH(tanggal_surat)')
            ->orderByRaw('MONTH(tanggal_surat)')
            ->get()
            ->toArray();
    }

    /**
     * Total surat per kategori
     */
    public static function totalPerKategori(int $tahun = null): array
    {
        $query = static::selectRaw('COUNT(CASE WHEN pengirim IS NOT NULL THEN 1 END) as surat_masuk,
                                   COUNT(CASE WHEN tujuan_surat IS NOT NULL THEN 1 END) as surat_keluar,
                                   COUNT(*) as total');

        if ($tahun) {
            $query->whereYear('tanggal_surat', $tahun);
        }

        return $query->first()->toArray();
    }

    /**
     * Surat terbaru
     */
    public static function suratTerbaru(int $limit = 10)
    {
        return static::orderBy('tanggal_surat', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }
    // ========================================
    // FUNGSI INTEGRASI DENGAN SISTEM SURAT
    // (COMMENTED - IMPLEMENTASI NANTI)
    // ========================================

    /**
     * Generate nomor surat otomatis untuk sistem buat surat baru
     * Auto-continue dari nomor terakhir di arsip
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */

    public function generateNomorSuratOtomatis(Request $request)
    {
        $jenisSurat = $request->input('jenis_surat'); // SKTM, SKPT, SKD, dll
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('n'));

        // Cek nomor terakhir di arsip untuk tahun ini
        $nomorUrut = static::generateNomorUrut($tahun);

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

        // Generate nomor surat sesuai format: 001/JENIS/NK/I/2025
        $nomorSurat = sprintf(
            '%03d/%s/NK/%s/%d',
            $nomorUrut,
            strtoupper($jenisSurat),
            $bulanRomawi[$bulan],
            $tahun
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'nomor_surat' => $nomorSurat,
                'nomor_urut' => $nomorUrut,
                'jenis_surat' => $jenisSurat,
                'tahun' => $tahun,
                'bulan' => $bulan
            ]
        ]);
    }


    /**
     * Simpan arsip surat otomatis ketika buat surat baru
     * Dipanggil dari sistem buat surat
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */

    public function simpanArsipOtomatis($dataSurat, $detailSuratType = null, $detailSuratId = null)
    {
        $arsipData = [
            'nomor_surat' => $dataSurat['nomor_surat'],
            'tanggal_surat' => $dataSurat['tanggal_surat'],
            'tujuan_surat' => $dataSurat['nama_penerima'], // untuk surat keluar
            'tentang' => $dataSurat['jenis_surat'] . ' - ' . $dataSurat['keperluan'],
            'keterangan' => 'Dibuat melalui sistem'
        ];

        // Jika ada detail surat, simpan referensi polymorphic
        if ($detailSuratType && $detailSuratId) {
            $arsipData['surat_detail_type'] = $detailSuratType;
            $arsipData['surat_detail_id'] = $detailSuratId;
        }

        return static::create($arsipData);
    }


    /**
     * Update arsip ketika detail surat diupdate
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */
    public function updateArsipOtomatis($arsipId, $dataSurat)
    {
        $arsip = static::find($arsipId);
        if ($arsip) {
            $arsip->update([
                'tujuan_surat' => $dataSurat['nama_penerima'],
                'tentang' => $dataSurat['jenis_surat'] . ' - ' . $dataSurat['keperluan'],
                'keterangan' => 'Diupdate melalui sistem pada ' . now()->format('d/m/Y H:i')
            ]);
        }
        return $arsip;
    }


    /**
     * Hapus arsip ketika detail surat dihapus
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */
    public function hapusArsipOtomatis($detailSuratType, $detailSuratId)
    {
        $arsip = static::where('surat_detail_type', $detailSuratType)
            ->where('surat_detail_id', $detailSuratId)
            ->first();

        if ($arsip) {
            $arsip->delete();
            return true;
        }
        return false;
    }

    /**
     * Cek konsistensi nomor surat dengan arsip
     * Pastikan tidak ada nomor yang terloncat
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */
    public function cekKonsistensiNomor(\Illuminate\Http\Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Ambil semua nomor urut yang ada
        $nomorAda = static::whereYear('tanggal_surat', $tahun)
            ->selectRaw('CAST(SUBSTRING_INDEX(nomor_surat, "/", 1) AS UNSIGNED) as nomor_urut')
            ->orderBy('nomor_urut')
            ->pluck('nomor_urut')
            ->toArray();

        // Cek nomor yang hilang
        $nomorHilang = [];
        if (!empty($nomorAda)) {
            $maxNomor = max($nomorAda);

            for ($i = 1; $i <= $maxNomor; $i++) {
                if (!in_array($i, $nomorAda)) {
                    $nomorHilang[] = $i;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'tahun' => $tahun,
                'total_surat' => count($nomorAda),
                'nomor_terakhir' => !empty($nomorAda) ? max($nomorAda) : 0,
                'nomor_hilang' => $nomorHilang,
                'konsisten' => empty($nomorHilang)
            ]
        ]);
    }
    /**
     * Sync arsip dengan detail surat yang sudah ada
     * Untuk data existing yang belum di-link
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */
    public function syncArsipDenganDetail()
    {
        // Ambil arsip yang belum ada detail
        $arsipTanpaDetail = static::whereNull('surat_detail_type')
            ->orWhereNull('surat_detail_id')
            ->get();

        $synced = 0;
        $errors = [];

        foreach ($arsipTanpaDetail as $arsip) {
            try {
                // Coba cari detail surat berdasarkan nomor surat

                // Untuk KTM:
                if (str_contains($arsip->tentang, 'KTM') || str_contains($arsip->tentang, 'Tidak Mampu')) {
                    $detailSurat = SuratKtm::where('nomor_surat', $arsip->nomor_surat)->first();
                    if ($detailSurat) {
                        $arsip->update([
                            'surat_detail_type' => SuratKtm::class,
                            'surat_detail_id' => $detailSurat->id
                        ]);
                        $synced++;
                    }
                }

                // Tambah logic untuk jenis surat lainnya...

            } catch (\Exception $e) {
                $errors[] = "Arsip ID {$arsip->id}: " . $e->getMessage();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => "Berhasil sync {$synced} arsip",
            'synced' => $synced,
            'errors' => $errors
        ]);
    }

    /**
     * Statistik integrasi arsip dengan detail surat
     * 
     * TODO: Implementasi ketika mulai buat sistem surat
     */
    public function statistikIntegrasi(\Illuminate\Http\Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $totalArsip = static::whereYear('tanggal_surat', $tahun)->count();
        $arsipAdaDetail = static::whereYear('tanggal_surat', $tahun)
            ->whereNotNull('surat_detail_type')
            ->whereNotNull('surat_detail_id')
            ->count();

        $persentaseIntegrasi = $totalArsip > 0 ? round(($arsipAdaDetail / $totalArsip) * 100, 2) : 0;

        return response()->json([
            'status' => 'success',
            'data' => [
                'tahun' => $tahun,
                'total_arsip' => $totalArsip,
                'arsip_ada_detail' => $arsipAdaDetail,
                'arsip_tanpa_detail' => $totalArsip - $arsipAdaDetail,
                'persentase_integrasi' => $persentaseIntegrasi
            ]
        ]);
    }
    /**
     * Generate nomor surat berdasarkan jenis
     */
    public static function generateNomorSuratByJenis(string $jenisSurat, int $tahun = null, int $bulan = null): string
    {
        $tahun = $tahun ?: date('Y');
        $bulan = $bulan ?: date('n');

        // Ambil nomor urut berdasarkan jenis surat
        $nomorUrut = static::generateNomorUrut($tahun, $jenisSurat);

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

        // Format: 001/JENIS/NK/I/2025
        return sprintf(
            '%03d/%s/NK/%s/%d',
            $nomorUrut,
            strtoupper($jenisSurat),
            $bulanRomawi[$bulan],
            $tahun
        );
    }

    /**
     * Helper untuk jenis surat yang umum
     */
    public static function generateNomorSKTM(int $tahun = null, int $bulan = null): string
    {
        return static::generateNomorSuratByJenis('SKTM', $tahun, $bulan);
    }

    public static function generateNomorSKPT(int $tahun = null, int $bulan = null): string
    {
        return static::generateNomorSuratByJenis('SKPT', $tahun, $bulan);
    }

    public static function generateNomorSKD(int $tahun = null, int $bulan = null): string
    {
        return static::generateNomorSuratByJenis('SKD', $tahun, $bulan);
    }

    public static function generateNomorSKU(int $tahun = null, int $bulan = null): string
    {
        return static::generateNomorSuratByJenis('SKU', $tahun, $bulan);
    }

    /**
     * Statistik per jenis surat
     */
    public static function statistikPerJenis(int $tahun = null): array
    {
        $query = static::selectRaw('surat_detail_type, COUNT(*) as total')
            ->whereNotNull('surat_detail_type');

        if ($tahun) {
            $query->whereYear('tanggal_surat', $tahun);
        }

        $result = $query->groupBy('surat_detail_type')
            ->pluck('total', 'surat_detail_type')
            ->toArray();

        // Convert class names to readable names
        $readable = [];
        foreach ($result as $class => $total) {
            $typeMap = [
                SuratKtm::class => 'SKTM',
                // SuratSkpt::class => 'SKPT',
                // SuratSkd::class => 'SKD',
            ];

            $name = $typeMap[$class] ?? basename(str_replace('\\', '/', $class));
            $readable[$name] = $total;
        }

        return $readable;
    }

    /**
     * Statistik nomor surat per jenis berdasarkan format nomor
     */
    public static function statistikPerJenisDariNomor(int $tahun = null): array
    {
        $query = static::selectRaw("
            CASE 
                WHEN nomor_surat LIKE '%/SKTM/%' THEN 'SKTM'
                WHEN nomor_surat LIKE '%/SKPT/%' THEN 'SKPT'
                WHEN nomor_surat LIKE '%/SKD/%' THEN 'SKD'
                WHEN nomor_surat LIKE '%/SKU/%' THEN 'SKU'
                ELSE 'LAINNYA'
            END as jenis_surat,
            COUNT(*) as total
        ");

        if ($tahun) {
            $query->whereYear('tanggal_surat', $tahun);
        }

        return $query->groupBy('jenis_surat')
            ->pluck('total', 'jenis_surat')
            ->toArray();
    }

    // ========================================
    // QR CODE METHODS
    // ========================================




    /**
     * Auto generate QR Code jika nomor surat berubah
     */
    protected static function boot()
    {
        parent::boot();
    }
}
