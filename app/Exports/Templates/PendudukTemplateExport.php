<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PendudukTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Template Penduduk' => new PendudukTemplateSheet(),
            'Petunjuk' => new PendudukInstructionSheet(),
            'Referensi' => new PendudukReferenceSheet(),
        ];
    }
}

class PendudukTemplateSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                '1234567890123456',
                '1234567890123456',
                'John Doe',
                'Jakarta',
                '01/01/1990',
                'Laki-laki',
                'Islam',
                'S1',
                'Pegawai Swasta',
                'Kawin',
                'Kepala Keluarga',
                'A',
                'WNI',
                'John Sr.',
                'Jane Doe'
            ],
            [
                '9876543210987654',
                '1234567890123456',
                'Jane Doe',
                'Jakarta',
                '05/03/1992',
                'Perempuan',
                'Islam',
                'S1',
                'Ibu Rumah Tangga',
                'Kawin',
                'Istri',
                'B',
                'WNI',
                'Robert Smith',
                'Mary Smith'
            ]
        ];
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
            // Style header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '16A085']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000']
                    ],
                ],
            ],
            // Style data rows
            'A2:O1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'CCCCCC']
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // nik
            'B' => 20, // no_kk
            'C' => 25, // nama_lengkap
            'D' => 18, // tempat_lahir
            'E' => 15, // tanggal_lahir
            'F' => 15, // jenis_kelamin
            'G' => 15, // agama
            'H' => 18, // pendidikan
            'I' => 20, // pekerjaan
            'J' => 15, // status
            'K' => 18, // status_keluarga
            'L' => 15, // golongan_darah
            'M' => 18, // kewarganegaraan
            'N' => 25, // nama_ayah
            'O' => 25, // nama_ibu
        ];
    }
}

class PendudukInstructionSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            ['nik', 'Nomor Induk Kependudukan (16 digit angka)', 'Wajib diisi, harus unik'],
            ['no_kk', 'Nomor Kartu Keluarga (16 digit angka)', 'Wajib diisi, harus sudah terdaftar'],
            ['nama_lengkap', 'Nama lengkap penduduk', 'Wajib diisi, maksimal 255 karakter'],
            ['tempat_lahir', 'Tempat lahir', 'Wajib diisi, maksimal 255 karakter'],
            ['tanggal_lahir', 'Tanggal lahir (DD/MM/YYYY)', 'Wajib diisi, format: 01/01/1990'],
            ['jenis_kelamin', 'Jenis kelamin', 'Wajib diisi: Laki-laki atau Perempuan'],
            ['agama', 'Agama yang dianut', 'Wajib diisi, maksimal 50 karakter'],
            ['pendidikan', 'Pendidikan terakhir', 'Wajib diisi, maksimal 100 karakter'],
            ['pekerjaan', 'Pekerjaan/profesi', 'Wajib diisi, maksimal 100 karakter'],
            ['status', 'Status perkawinan', 'Wajib diisi, maksimal 50 karakter'],
            ['status_keluarga', 'Status dalam keluarga', 'Wajib diisi, maksimal 50 karakter'],
            ['golongan_darah', 'Golongan darah', 'Opsional, maksimal 3 karakter'],
            ['kewarganegaraan', 'Kewarganegaraan', 'Wajib diisi, maksimal 50 karakter'],
            ['nama_ayah', 'Nama ayah kandung', 'Wajib diisi, maksimal 255 karakter'],
            ['nama_ibu', 'Nama ibu kandung', 'Wajib diisi, maksimal 255 karakter'],
            [],
            ['CATATAN PENTING:', '', ''],
            ['1. Jangan mengubah nama kolom pada baris pertama', '', ''],
            ['2. NIK harus 16 digit angka dan belum terdaftar', '', ''],
            ['3. No. KK harus sudah terdaftar dalam sistem', '', ''],
            ['4. Tanggal lahir format DD/MM/YYYY (contoh: 01/01/1990)', '', ''],
            ['5. Jenis kelamin hanya: Laki-laki atau Perempuan', '', ''],
            ['6. Hapus baris contoh sebelum melakukan import', '', ''],
            ['7. Maksimal 1000 baris data dalam sekali import', '', ''],
            ['8. Format file yang didukung: .xlsx, .xls, .csv', '', ''],
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
            'A17:C17' => [
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

class PendudukReferenceSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            ['JENIS KELAMIN', 'AGAMA', 'PENDIDIKAN', 'STATUS PERKAWINAN', 'STATUS KELUARGA'],
            ['Laki-laki', 'Islam', 'Tidak Sekolah', 'Belum Kawin', 'Kepala Keluarga'],
            ['Perempuan', 'Kristen', 'SD', 'Kawin', 'Istri'],
            ['', 'Katolik', 'SMP', 'Cerai Hidup', 'Anak'],
            ['', 'Hindu', 'SMA', 'Cerai Mati', 'Menantu'],
            ['', 'Buddha', 'D1', '', 'Cucu'],
            ['', 'Khonghucu', 'D2', '', 'Orangtua'],
            ['', 'Kepercayaan', 'D3', '', 'Mertua'],
            ['', '', 'S1', '', 'Famili Lain'],
            ['', '', 'S2', '', 'Pembantu'],
            ['', '', 'S3', '', 'Lainnya'],
            [],
            ['GOLONGAN DARAH', 'KEWARGANEGARAAN', 'PEKERJAAN (Contoh)', '', ''],
            ['A', 'WNI', 'Pegawai Negeri Sipil', '', ''],
            ['B', 'WNA', 'TNI/POLRI', '', ''],
            ['AB', '', 'Pegawai Swasta', '', ''],
            ['O', '', 'Wiraswasta', '', ''],
            ['-', '', 'Petani', '', ''],
            ['', '', 'Nelayan', '', ''],
            ['', '', 'Buruh', '', ''],
            ['', '', 'Ibu Rumah Tangga', '', ''],
            ['', '', 'Pelajar/Mahasiswa', '', ''],
            ['', '', 'Pensiunan', '', ''],
            ['', '', 'Belum/Tidak Bekerja', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Pilihan 4',
            'Pilihan 5'
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
            'A13:E13' => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'F0F9FF']
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 25,
            'D' => 20,
            'E' => 20,
        ];
    }
}
