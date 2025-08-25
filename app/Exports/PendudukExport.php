<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PendudukExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $request;

    public function __construct($request = null)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Penduduk::with('kk');

        // Apply filters if request is provided
        if ($this->request) {
            if ($this->request->filled('search')) {
                $search = $this->request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                        ->orWhere('nik', 'LIKE', "%{$search}%")
                        ->orWhere('no_kk', 'LIKE', "%{$search}%");
                });
            }

            if ($this->request->filled('jenis_kelamin') && $this->request->jenis_kelamin !== 'all') {
                $query->where('jenis_kelamin', $this->request->jenis_kelamin);
            }

            if ($this->request->filled('agama') && $this->request->agama !== 'all') {
                $query->where('agama', $this->request->agama);
            }

            if ($this->request->filled('status_keluarga') && $this->request->status_keluarga !== 'all') {
                $query->where('status_keluarga', $this->request->status_keluarga);
            }
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIK',
            'No. KK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Pendidikan',
            'Pekerjaan',
            'Status',
            'Status Keluarga',
            'Golongan Darah',
            'Kewarganegaraan',
            'Nama Ayah',
            'Nama Ibu',
            'Umur',
            'Alamat KK',
            'Tanggal Dibuat',
        ];
    }

    /**
     * @param mixed $penduduk
     * @return array
     */
    public function map($penduduk): array
    {
        return [
            $penduduk->nik,
            $penduduk->no_kk,
            $penduduk->nama_lengkap,
            $penduduk->tempat_lahir,
            $penduduk->tanggal_lahir->format('d/m/Y'),
            $penduduk->jenis_kelamin,
            $penduduk->agama,
            $penduduk->pendidikan,
            $penduduk->pekerjaan,
            $penduduk->status,
            $penduduk->status_keluarga,
            $penduduk->golongan_darah,
            $penduduk->kewarganegaraan,
            $penduduk->nama_ayah,
            $penduduk->nama_ibu,
            $penduduk->umur . ' tahun',
            $penduduk->kk ? $penduduk->kk->alamat_lengkap : '',
            $penduduk->created_at->format('d/m/Y H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E8F0']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            // Style all cells
            'A:R' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // NIK
            'B' => 20, // No. KK
            'C' => 25, // Nama Lengkap
            'D' => 18, // Tempat Lahir
            'E' => 15, // Tanggal Lahir
            'F' => 15, // Jenis Kelamin
            'G' => 15, // Agama
            'H' => 18, // Pendidikan
            'I' => 20, // Pekerjaan
            'J' => 15, // Status
            'K' => 18, // Status Keluarga
            'L' => 15, // Golongan Darah
            'M' => 18, // Kewarganegaraan
            'N' => 25, // Nama Ayah
            'O' => 25, // Nama Ibu
            'P' => 10, // Umur
            'Q' => 40, // Alamat KK
            'R' => 18, // Tanggal Dibuat
        ];
    }
}
