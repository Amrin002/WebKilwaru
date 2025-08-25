<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\KK;
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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class PendudukImport extends DefaultValueBinder implements
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
    protected $gagal = [];

    /**
     * Bind value to a cell - Override untuk handle NIK dan No KK yang panjang
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom A (NIK) dan B (No KK) harus dipaksa sebagai string
        if (in_array($cell->getColumn(), ['A', 'B'])) {
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
        // Debug log
        Log::info('Processing row:', $row);

        // Clean NIK dan No KK
        $nik = $this->cleanNIK($row['nik'] ?? '');
        $no_kk = $this->cleanNoKK($row['no_kk'] ?? '');

        // Skip empty rows
        if (empty($nik) || empty($row['nama_lengkap'])) {
            $this->skippedCount++;
            return null;
        }

        // Skip jika status admin (dari import lama)
        if (isset($row['status']) && strtolower($row['status']) === 'admin') {
            $this->skippedCount++;
            return null;
        }

        // Cek apakah NIK sudah ada
        if (Penduduk::where('nik', $nik)->exists()) {
            Log::info("NIK sudah ada: {$nik}");
            $this->gagal[] = [
                'nik' => $nik,
                'nama_lengkap' => $row['nama_lengkap'] ?? '',
                'alasan' => 'NIK sudah terdaftar'
            ];
            $this->skippedCount++;
            return null;
        }

        // Cek apakah no_kk valid
        if (!KK::where('no_kk', $no_kk)->exists()) {
            Log::warning("No KK tidak ditemukan: {$no_kk}");
            $this->gagal[] = [
                'nik' => $nik,
                'no_kk' => $no_kk,
                'nama_lengkap' => $row['nama_lengkap'] ?? '',
                'alasan' => 'No KK tidak ditemukan dalam sistem'
            ];
            $this->skippedCount++;
            return null;
        }

        try {
            // Parse tanggal lahir
            $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? '');

            if (!$tanggalLahir) {
                $this->gagal[] = [
                    'nik' => $nik,
                    'nama_lengkap' => $row['nama_lengkap'] ?? '',
                    'alasan' => 'Format tanggal lahir tidak valid'
                ];
                $this->skippedCount++;
                return null;
            }

            // Validasi NIK harus 16 digit
            if (strlen($nik) !== 16 || !ctype_digit($nik)) {
                $this->gagal[] = [
                    'nik' => $nik,
                    'nama_lengkap' => $row['nama_lengkap'] ?? '',
                    'alasan' => 'NIK harus 16 digit angka'
                ];
                $this->skippedCount++;
                return null;
            }

            $this->importedCount++;

            // Buat data penduduk baru
            return new Penduduk([
                'nik' => $nik,
                'no_kk' => $no_kk,
                'nama_lengkap' => $this->cleanString($row['nama_lengkap'] ?? ''),
                'tempat_lahir' => $this->cleanString($row['tempat_lahir'] ?? ''),
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $this->normalizeJenisKelamin($row['jenis_kelamin'] ?? ''),
                'agama' => $this->cleanString($row['agama'] ?? ''),
                'pendidikan' => $this->cleanString($row['pendidikan'] ?? ''),
                'pekerjaan' => $this->cleanString($row['pekerjaan'] ?? ''),
                'status' => $this->cleanString($row['status'] ?? ''),
                'status_keluarga' => $this->cleanString($row['status_keluarga'] ?? ''),
                'golongan_darah' => $this->cleanString($row['golongan_darah'] ?? ''),
                'kewarganegaraan' => $this->cleanString($row['kewarganegaraan'] ?? 'WNI'),
                'nama_ayah' => $this->cleanString($row['nama_ayah'] ?? ''),
                'nama_ibu' => $this->cleanString($row['nama_ibu'] ?? ''),
            ]);
        } catch (\Exception $e) {
            Log::error('Penduduk Import Error: ' . $e->getMessage() . ' for NIK: ' . $nik);
            $this->gagal[] = [
                'nik' => $nik,
                'nama_lengkap' => $row['nama_lengkap'] ?? '',
                'alasan' => 'Error: ' . $e->getMessage()
            ];
            $this->skippedCount++;
            return null;
        }
    }

    /**
     * Clean NIK dari format Excel yang salah
     */
    private function cleanNIK($value)
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

        return $value;
    }

    /**
     * Clean No KK sama seperti NIK
     */
    private function cleanNoKK($value)
    {
        return $this->cleanNIK($value); // Same logic
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
     * Parse tanggal lahir dari berbagai format
     */
    private function parseTanggalLahir($tanggal)
    {
        if (empty($tanggal)) {
            return null;
        }

        try {
            // Jika tanggal adalah angka (format serial Excel)
            if (is_numeric($tanggal)) {
                $date = Date::excelToDateTimeObject($tanggal);
                return Carbon::instance($date)->format('Y-m-d');
            }

            // Try different date formats
            $formats = [
                'd/m/Y',
                'd-m-Y',
                'Y-m-d',
                'm/d/Y',
                'd.m.Y',
                'j/n/Y', // without leading zeros
                'd/m/y', // 2 digit year
                'd-m-y'
            ];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $tanggal);
                    if ($date && $date->year >= 1900 && $date->year <= date('Y')) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Try Carbon parse as fallback
            $date = Carbon::parse($tanggal);
            if ($date && $date->year >= 1900 && $date->year <= date('Y')) {
                return $date->format('Y-m-d');
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('Failed to parse date: ' . $tanggal);
            return null;
        }
    }

    /**
     * Normalize jenis kelamin
     */
    private function normalizeJenisKelamin($value)
    {
        $value = strtolower(trim($value));

        // Map various formats to standard
        $mapping = [
            'l' => 'Laki-laki',
            'laki' => 'Laki-laki',
            'laki-laki' => 'Laki-laki',
            'laki laki' => 'Laki-laki',
            'pria' => 'Laki-laki',
            'male' => 'Laki-laki',
            'm' => 'Laki-laki',

            'p' => 'Perempuan',
            'perempuan' => 'Perempuan',
            'wanita' => 'Perempuan',
            'female' => 'Perempuan',
            'f' => 'Perempuan',
        ];

        return $mapping[$value] ?? 'Laki-laki'; // Default
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
     * Get data yang gagal import
     */
    public function getGagal(): array
    {
        return $this->gagal;
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

            $this->gagal[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values()
            ];

            $this->skippedCount++;
        }
    }
}
