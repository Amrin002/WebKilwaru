<?php

namespace App\Exports;

use App\Models\KK;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KKExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
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
        $query = KK::query();

        // Apply filters if request is provided
        if ($this->request) {
            if ($this->request->filled('search')) {
                $query->search($this->request->search);
            }

            $filters = [
                'provinsi' => $this->request->provinsi,
                'kabupaten' => $this->request->kabupaten,
                'kecamatan' => $this->request->kecamatan,
                'desa' => $this->request->desa,
            ];

            $query->filterByLocation(array_filter($filters));
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No. KK',
            'Nama Kepala Keluarga',
            'Alamat',
            'RT',
            'RW',
            'Desa',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Kode Pos',
            'Alamat Lengkap',
            'Tanggal Dibuat',
        ];
    }

    /**
     * @param mixed $kk
     * @return array
     */
    public function map($kk): array
    {
        return [
            $kk->no_kk,
            $kk->nama_kepala_keluarga,
            $kk->alamat,
            $kk->rt,
            $kk->rw,
            $kk->desa,
            $kk->kecamatan,
            $kk->kabupaten,
            $kk->provinsi,
            $kk->kode_pos,
            $kk->alamat_lengkap,
            $kk->created_at->format('d/m/Y H:i:s'),
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
            'A:L' => [
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
            'A' => 20, // No. KK
            'B' => 25, // Nama Kepala Keluarga
            'C' => 30, // Alamat
            'D' => 8,  // RT
            'E' => 8,  // RW
            'F' => 20, // Desa
            'G' => 20, // Kecamatan
            'H' => 20, // Kabupaten
            'I' => 20, // Provinsi
            'J' => 12, // Kode Pos
            'K' => 50, // Alamat Lengkap
            'L' => 18, // Tanggal Dibuat
        ];
    }
}
