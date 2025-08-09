<?php

namespace App\Imports;

use App\Models\KK;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class KKImport extends DefaultValueBinder implements
    ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    SkipsOnError,
    SkipsOnFailure,
    WithCustomValueBinder
{
    use SkipsErrors, SkipsFailures;

    protected $importedCount = 0;
    protected $skippedCount = 0;

    /**
     * Bind value to a cell - Override untuk handle nomor KK yang panjang
     * @param Cell $cell
     * @param mixed $value
     * @return bool
     */
    public function bindValue(Cell $cell, $value)
    {
        // Jika kolom A (biasanya no_kk), paksa sebagai string
        if ($cell->getColumn() == 'A') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // Default behavior untuk kolom lain
        return parent::bindValue($cell, $value);
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Debug: Lihat struktur data yang masuk
        // Uncomment line di bawah untuk debug
        // \Log::info('Import Row: ', $row);

        // Clean no_kk dari kemungkinan format yang salah
        $no_kk = $this->cleanNoKK($row['no_kk'] ?? '');

        // Skip empty rows
        if (empty($no_kk)) {
            $this->skippedCount++;
            return null;
        }

        // Cek apakah no_kk sudah ada
        if (KK::where('no_kk', $no_kk)->exists()) {
            Log::info("KK sudah ada: {$no_kk}");
            $this->skippedCount++;
            return null;
        }

        try {
            // Clean nama kepala keluarga dari special characters
            $nama_kepala = $this->cleanNamaKepala($row['nama_kepala_keluarga'] ?? '');

            // Validasi no_kk harus 16 digit
            if (strlen($no_kk) !== 16 || !ctype_digit($no_kk)) {
                Log::warning("No KK tidak valid: {$no_kk} (harus 16 digit)");
                $this->skippedCount++;
                return null;
            }

            $this->importedCount++;

            // Buat data KK baru
            return new KK([
                'no_kk' => $no_kk,
                'nama_kepala_keluarga' => $nama_kepala ?: 'TIDAK DIKETAHUI',
                'alamat' => $this->cleanString($row['alamat'] ?? ''),
                'rt' => $this->cleanRT($row['rt'] ?? ''),
                'rw' => $this->cleanRT($row['rw'] ?? ''),
                'desa' => $this->cleanString($row['desa'] ?? ''),
                'kecamatan' => $this->cleanString($row['kecamatan'] ?? ''),
                'kabupaten' => $this->cleanString($row['kabupaten'] ?? ''),
                'provinsi' => $this->cleanString($row['provinsi'] ?? ''),
                'kode_pos' => $this->cleanKodePos($row['kode_pos'] ?? ''),
            ]);
        } catch (\Exception $e) {
            Log::error('KK Import Error: ' . $e->getMessage() . ' for no_kk: ' . $no_kk);
            $this->skippedCount++;
            return null;
        }
    }

    /**
     * Clean no_kk dari format Excel yang salah
     */
    private function cleanNoKK($value)
    {
        if (empty($value)) {
            return '';
        }

        // Convert ke string
        $value = strval($value);

        // Hapus tanda petik di awal jika ada
        $value = ltrim($value, "'");

        // Jika dalam format scientific notation (1.23457E+15)
        if (stripos($value, 'E+') !== false || stripos($value, 'E-') !== false) {
            // Convert dari scientific notation
            $value = sprintf("%.0f", floatval($value));
        }

        // Hapus semua karakter non-digit
        $value = preg_replace('/[^0-9]/', '', $value);

        // Hapus .0 di akhir jika ada (dari float conversion)
        $value = rtrim(rtrim($value, '0'), '.');

        return $value;
    }

    /**
     * Clean nama kepala keluarga
     */
    private function cleanNamaKepala($value)
    {
        if (empty($value)) {
            return '';
        }

        // Hapus tanda petik di awal/akhir
        $value = trim($value, "'\"");

        // Hapus multiple spaces
        $value = preg_replace('/\s+/', ' ', $value);

        // Trim
        return trim($value);
    }

    /**
     * Clean string umum
     */
    private function cleanString($value)
    {
        if (empty($value)) {
            return '';
        }

        // Convert ke string dan trim
        $value = trim(strval($value));

        // Hapus tanda petik di awal/akhir
        $value = trim($value, "'\"");

        // Hapus multiple spaces
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    /**
     * Clean RT/RW - pastikan format 3 digit
     */
    private function cleanRT($value)
    {
        if (empty($value)) {
            return '001';
        }

        // Hapus semua non-digit
        $value = preg_replace('/[^0-9]/', '', strval($value));

        // Pad dengan 0 di depan jika kurang dari 3 digit
        return str_pad($value, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Clean kode pos - pastikan 5 digit
     */
    private function cleanKodePos($value)
    {
        if (empty($value)) {
            return '00000';
        }

        // Hapus semua non-digit
        $value = preg_replace('/[^0-9]/', '', strval($value));

        // Ambil 5 digit pertama atau pad dengan 0
        if (strlen($value) > 5) {
            return substr($value, 0, 5);
        }

        return str_pad($value, 5, '0', STR_PAD_LEFT);
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Get imported count
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * Get skipped count
     */
    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }

    /**
     * Handle errors
     */
    public function onError(Throwable $e)
    {
        Log::error('Import Error: ' . $e->getMessage());
        $this->skippedCount++;
    }

    /**
     * Handle failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::warning('Import Failure on row ' . $failure->row() . ': ' . implode(', ', $failure->errors()));
            $this->skippedCount++;
        }
    }
}
