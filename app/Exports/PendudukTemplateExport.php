<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PendudukTemplateExport implements 
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
                'nik' => "'3201234567890001", // Tambahkan ' untuk memaksa text format
                'no_kk' => "'3201234567890001",
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '01/01/1990',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Pegawai Swasta',
                'status' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'golongan_darah' => 'A',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Sutrisno',
                'nama_ibu' => 'Siti Aminah'
            ],
            [
                'nik' => "'3201234567890002",
                'no_kk' => "'3201234567890001",
                'nama_lengkap' => 'Siti Rahayu',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '15/05/1992',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'status' => 'Kawin',
                'status_keluarga' => 'Istri',
                'golongan_darah' => 'B',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Ahmad Dahlan',
                'nama_ibu' => 'Fatimah'
            ],
            [
                'nik' => "'3201234567890003",
                'no_kk' => "'3201234567890001",
                'nama_lengkap' => 'Ahmad Rizki',
                'tempat_lahir' => 'Bekasi',
                'tanggal_lahir' => '20/08/2015',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pendidikan' => 'SD',
                'pekerjaan' => 'Pelajar',
                'status' => 'Belum Kawin',
                'status_keluarga' => 'Anak',
                'golongan_darah' => 'O',
                'kewarganegaraan' => 'WNI',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Rahayu'
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
            'nama_ibu'
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
            'A2:O' . ($this->sampleData->count() + 1) => [
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
        ];
    }

    /**
     * Register events to format cells properly
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Format kolom NIK dan No KK sebagai text untuk menghindari scientific notation
                $sheet->getStyle('A:A')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);
                    
                $sheet->getStyle('B:B')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);
                
                // Tambahkan komentar/instruksi di header
                $sheet->getComment('A1')->getText()->createTextRun(
                    "PENTING: Untuk NIK (16 digit), " .
                    "awali dengan tanda petik (') agar tidak berubah format.\n" .
                    "Contoh: '3201234567890001"
                );
                
                $sheet->getComment('B1')->getText()->createTextRun(
                    "PENTING: No KK harus terdaftar di sistem.\n" .
                    "Awali dengan tanda petik (') untuk format yang benar.\n" .
                    "Contoh: '3201234567890001"
                );
                
                $sheet->getComment('E1')->getText()->createTextRun(
                    "Format tanggal: DD/MM/YYYY\n" .
                    "Contoh: 01/01/1990"
                );
                
                $sheet->getComment('F1')->getText()->createTextRun(
                    "Isi dengan:\n" .
                    "- Laki-laki\n" .
                    "- Perempuan"
                );
                
                $sheet->getComment('K1')->getText()->createTextRun(
                    "Isi dengan:\n" .
                    "- Kepala Keluarga\n" .
                    "- Istri\n" .
                    "- Anak\n" .
                    "- Lainnya"
                );
                
                // Set column A and B as text explicitly
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    // NIK
                    $value = $sheet->getCell('A' . $row)->getValue();
                    if ($value) {
                        $sheet->setCellValueExplicit(
                            'A' . $row,
                            $value,
                            DataType::TYPE_STRING
                        );
                    }
                    
                    // No KK
                    $value = $sheet->getCell('B' . $row)->getValue();
                    if ($value) {
                        $sheet->setCellValueExplicit(
                            'B' . $row,
                            $value,
                            DataType::TYPE_STRING
                        );
                    }
                }
            },
        ];
    }
}