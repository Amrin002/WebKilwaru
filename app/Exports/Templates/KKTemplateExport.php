<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KKTemplateExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithEvents
{
    protected $sampleData;

    public function __construct()
    {
        $this->sampleData = collect([
            [
                'no_kk' => "'1234567890123456", // Tambahkan ' untuk memaksa text format
                'nama_kepala_keluarga' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No. 123',
                'rt' => '001',
                'rw' => '005',
                'desa' => 'Sukamaju',
                'kecamatan' => 'Cikarang Pusat',
                'kabupaten' => 'Bekasi',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '17530'
            ],
            [
                'no_kk' => "'9876543210987654",
                'nama_kepala_keluarga' => 'Siti Aminah',
                'alamat' => 'Jl. Sudirman No. 45',
                'rt' => '003',
                'rw' => '007',
                'desa' => 'Sumberejo',
                'kecamatan' => 'Cikarang Selatan',
                'kabupaten' => 'Bekasi',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '17550'
            ]
        ]);
    }

    public function collection()
    {
        return $this->sampleData;
    }

    public function headings(): array
    {
        return [
            'no_kk',
            'nama_kepala_keluarga',
            'alamat',
            'rt',
            'rw',
            'desa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'kode_pos'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2D5016']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            // Data rows styling
            'A2:J' . ($this->sampleData->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // no_kk
            'B' => 25, // nama_kepala_keluarga
            'C' => 30, // alamat
            'D' => 8,  // rt
            'E' => 8,  // rw
            'F' => 20, // desa
            'G' => 20, // kecamatan
            'H' => 20, // kabupaten
            'I' => 20, // provinsi
            'J' => 12, // kode_pos
        ];
    }

    /**
     * Register events to format cells properly
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Format kolom no_kk sebagai text untuk menghindari scientific notation
                $sheet->getStyle('A:A')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Format kolom kode_pos sebagai text
                $sheet->getStyle('J:J')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Tambahkan komentar/instruksi di header
                $sheet->getComment('A1')->getText()->createTextRun(
                    "PENTING: Untuk nomor KK yang panjang (16 digit), " .
                        "awali dengan tanda petik (') agar tidak berubah format.\n" .
                        "Contoh: '1234567890123456"
                );

                // Set column A as text explicitly
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $value = $sheet->getCell('A' . $row)->getValue();
                    if ($value) {
                        $sheet->setCellValueExplicit(
                            'A' . $row,
                            $value,
                            DataType::TYPE_STRING
                        );
                    }
                }
            },
        ];
    }
}

class KKInstructionSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            ['no_kk', 'Nomor Kartu Keluarga (16 digit angka)', 'Wajib diisi, harus unik'],
            ['nama_kepala_keluarga', 'Nama lengkap kepala keluarga', 'Wajib diisi, maksimal 100 karakter'],
            ['alamat', 'Alamat tempat tinggal', 'Wajib diisi, maksimal 255 karakter'],
            ['rt', 'Rukun Tetangga', 'Wajib diisi, maksimal 3 karakter'],
            ['rw', 'Rukun Warga', 'Wajib diisi, maksimal 3 karakter'],
            ['desa', 'Nama desa/kelurahan', 'Wajib diisi, maksimal 100 karakter'],
            ['kecamatan', 'Nama kecamatan', 'Wajib diisi, maksimal 100 karakter'],
            ['kabupaten', 'Nama kabupaten/kota', 'Wajib diisi, maksimal 100 karakter'],
            ['provinsi', 'Nama provinsi', 'Wajib diisi, maksimal 100 karakter'],
            ['kode_pos', 'Kode pos wilayah (5 digit angka)', 'Wajib diisi'],
            [],
            ['CATATAN PENTING:', '', ''],
            ['1. Jangan mengubah nama kolom pada baris pertama', '', ''],
            ['2. No. KK harus 16 digit angka dan belum terdaftar', '', ''],
            ['3. Kode pos harus 5 digit angka', '', ''],
            ['4. Hapus baris contoh sebelum melakukan import', '', ''],
            ['5. Maksimal 1000 baris data dalam sekali import', '', ''],
            ['6. Format file yang didukung: .xlsx, .xls, .csv', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'Kolom',
            'Deskripsi',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'E2E8F0']
                ],
            ],
            'A12:C12' => [
                'font' => ['bold' => true, 'color' => ['argb' => 'DC2626']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FEF2F2']
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 40,
            'C' => 35,
        ];
    }
}
