<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\KK;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;
use Throwable;

class PendudukImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts,
    WithChunkReading,
    SkipsOnError,
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    protected $importedCount = 0;
    protected $skippedCount = 0;

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nik']) || empty($row['nama_lengkap'])) {
            $this->skippedCount++;
            return null;
        }

        try {
            // Parse tanggal lahir
            $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir']);

            if (!$tanggalLahir) {
                $this->skippedCount++;
                return null;
            }

            $this->importedCount++;

            return new Penduduk([
                'nik' => $row['nik'],
                'no_kk' => $row['no_kk'],
                'nama_lengkap' => $row['nama_lengkap'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $row['jenis_kelamin'],
                'agama' => $row['agama'],
                'pendidikan' => $row['pendidikan'],
                'pekerjaan' => $row['pekerjaan'],
                'status' => $row['status'],
                'status_keluarga' => $row['status_keluarga'],
                'golongan_darah' => $row['golongan_darah'] ?? null,
                'kewarganegaraan' => $row['kewarganegaraan'],
                'nama_ayah' => $row['nama_ayah'],
                'nama_ibu' => $row['nama_ibu'],
            ]);
        } catch (\Exception $e) {
            $this->skippedCount++;
            return null;
        }
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
            // Try different date formats
            $formats = [
                'd/m/Y',
                'd-m-Y',
                'Y-m-d',
                'm/d/Y',
                'd.m.Y'
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
            return null;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nik' => [
                'required',
                'string',
                'size:16',
                'unique:penduduks,nik'
            ],
            'no_kk' => [
                'required',
                'string',
                'exists:k_k_s,no_kk'
            ],
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status' => 'required|string|max:50',
            'status_keluarga' => 'required|string|max:50',
            'golongan_darah' => 'nullable|string|max:3',
            'kewarganegaraan' => 'required|string|max:50',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'no_kk.required' => 'No. KK wajib diisi',
            'no_kk.exists' => 'No. KK tidak terdaftar dalam sistem',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'agama.required' => 'Agama wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'status.required' => 'Status wajib diisi',
            'status_keluarga.required' => 'Status keluarga wajib diisi',
            'kewarganegaraan.required' => 'Kewarganegaraan wajib diisi',
            'nama_ayah.required' => 'Nama ayah wajib diisi',
            'nama_ibu.required' => 'Nama ibu wajib diisi',
        ];
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
     * @return int
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * @return int
     */
    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }

    /**
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        $this->skippedCount++;
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->skippedCount++;
        }
    }
}
