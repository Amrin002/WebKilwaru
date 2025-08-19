<?php

namespace App\Services;

use App\Models\ArsipSurat;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class QrCodeService
{
    /**
     * Directory untuk menyimpan QR Code
     */
    const QR_CODE_PATH = 'public/qr-codes';

    /**
     * Generate dan simpan QR Code untuk surat
     */
    public function generateAndSaveQrCode(string $nomorSurat): array
    {
        try {
            // Validasi nomor surat
            if (empty($nomorSurat)) {
                throw new \InvalidArgumentException('Nomor surat tidak boleh kosong');
            }

            // Generate URL verifikasi
            $verificationUrl = route('verifikasi.surat', ['nomorSurat' => $nomorSurat]);

            // Generate QR Code sebagai PNG
            $qrCode = QrCode::format('png')
                ->size(300)
                ->backgroundColor(255, 255, 255)
                ->color(45, 80, 22) // Warna hijau sesuai tema desa
                ->margin(2)
                ->errorCorrection('M')
                ->generate($verificationUrl);

            // Buat nama file
            $filename = $this->generateFilename($nomorSurat);

            // Pastikan direktori ada
            $this->ensureDirectoryExists();

            // Simpan ke storage
            $path = self::QR_CODE_PATH . '/' . $filename;
            Storage::put($path, $qrCode);

            // Generate juga versi base64 untuk embed
            $base64 = base64_encode($qrCode);

            // Log sukses
            Log::info('QR Code generated successfully', [
                'nomor_surat' => $nomorSurat,
                'path' => $path,
                'size' => strlen($qrCode)
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'storage_path' => storage_path('app/' . $path),
                'url' => Storage::url($path),
                'base64' => 'data:image/png;base64,' . $base64,
                'verification_url' => $verificationUrl,
                'file_size' => strlen($qrCode),
                'created_at' => now()->toISOString()
            ];
        } catch (\Exception $e) {
            Log::error('Generate QR Code Error: ' . $e->getMessage(), [
                'nomor_surat' => $nomorSurat,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode()
            ];
        }
    }

    /**
     * Generate nama file QR Code yang aman
     */
    private function generateFilename(string $nomorSurat): string
    {
        // Sanitize nomor surat untuk nama file
        $sanitized = preg_replace('/[^a-zA-Z0-9\-_]/', '-', $nomorSurat);
        $sanitized = trim($sanitized, '-');

        // Pastikan tidak terlalu panjang
        if (strlen($sanitized) > 50) {
            $sanitized = substr($sanitized, 0, 50);
        }

        return 'qr_' . $sanitized . '_' . time() . '.png';
    }

    /**
     * Pastikan direktori QR code ada
     */
    private function ensureDirectoryExists(): void
    {
        if (!Storage::exists(self::QR_CODE_PATH)) {
            Storage::makeDirectory(self::QR_CODE_PATH);
        }
    }

    /**
     * Get QR Code untuk display (base64)
     */
    public function getQrCodeBase64(string $nomorSurat, bool $regenerateIfNotFound = false): ?string
    {
        try {
            // Cek apakah sudah ada file QR Code
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();

            if ($arsip && $arsip->qr_code_path && Storage::exists($arsip->qr_code_path)) {
                $content = Storage::get($arsip->qr_code_path);
                return 'data:image/png;base64,' . base64_encode($content);
            }

            // Jika belum ada dan diminta untuk regenerate
            if ($regenerateIfNotFound) {
                $result = $this->generateAndSaveQrCode($nomorSurat);
                if ($result['success']) {
                    // Update path di database jika perlu
                    if ($arsip) {
                        $arsip->update(['qr_code_path' => $result['path']]);
                    }
                    return $result['base64'];
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Get QR Code Base64 Error: ' . $e->getMessage(), [
                'nomor_surat' => $nomorSurat
            ]);
            return null;
        }
    }

    /**
     * Generate QR Code untuk PDF (return binary PNG)
     */
    public function getQrCodeForPdf(string $nomorSurat, int $size = 200): ?string
    {
        try {
            $verificationUrl = route('verifikasi.surat', ['nomorSurat' => $nomorSurat]);

            // Generate QR Code dengan ukuran khusus untuk PDF
            $qrCode = QrCode::format('png')
                ->size($size)
                ->backgroundColor(255, 255, 255)
                ->color(45, 80, 22)
                ->margin(1) // Margin lebih kecil untuk PDF
                ->errorCorrection('M')
                ->generate($verificationUrl);

            return $qrCode;
        } catch (\Exception $e) {
            Log::error('Generate QR for PDF Error: ' . $e->getMessage(), [
                'nomor_surat' => $nomorSurat
            ]);
            return null;
        }
    }

    /**
     * Generate QR Code untuk preview (tanpa simpan)
     */
    public function generateQrCodePreview(string $nomorSurat, array $options = []): array
    {
        try {
            $verificationUrl = route('verifikasi.surat', ['nomorSurat' => $nomorSurat]);

            $size = $options['size'] ?? 200;
            $format = $options['format'] ?? 'png';
            $margin = $options['margin'] ?? 2;

            $qrCode = QrCode::format($format)
                ->size($size)
                ->backgroundColor(255, 255, 255)
                ->color(45, 80, 22)
                ->margin($margin)
                ->errorCorrection('M')
                ->generate($verificationUrl);

            return [
                'success' => true,
                'qr_code' => $qrCode,
                'base64' => 'data:image/' . $format . ';base64,' . base64_encode($qrCode),
                'verification_url' => $verificationUrl,
                'size' => $size,
                'format' => $format
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete QR Code file
     */
    public function deleteQrCode(string $path): bool
    {
        try {
            if (Storage::exists($path)) {
                $deleted = Storage::delete($path);

                if ($deleted) {
                    Log::info('QR Code file deleted', ['path' => $path]);
                }

                return $deleted;
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Delete QR Code Error: ' . $e->getMessage(), [
                'path' => $path
            ]);
            return false;
        }
    }

    /**
     * Regenerate QR Code
     */
    public function regenerateQrCode(string $nomorSurat): array
    {
        try {
            // Hapus QR Code lama jika ada
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();
            if ($arsip && $arsip->qr_code_path) {
                $this->deleteQrCode($arsip->qr_code_path);

                // Reset path di database
                $arsip->update(['qr_code_path' => null]);
            }

            // Generate yang baru
            $result = $this->generateAndSaveQrCode($nomorSurat);

            // Update path di database jika berhasil
            if ($result['success'] && $arsip) {
                $arsip->update(['qr_code_path' => $result['path']]);
            }

            return $result;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Bulk generate QR Codes
     */
    public function bulkGenerateQrCodes(array $nomorSurats): array
    {
        $results = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($nomorSurats as $nomorSurat) {
            $result = $this->generateAndSaveQrCode($nomorSurat);
            $results[$nomorSurat] = $result;

            if ($result['success']) {
                $successCount++;

                // Update arsip jika ada
                $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();
                if ($arsip) {
                    $arsip->update(['qr_code_path' => $result['path']]);
                }
            } else {
                $errorCount++;
            }
        }

        Log::info('Bulk QR Code generation completed', [
            'total' => count($nomorSurats),
            'success' => $successCount,
            'errors' => $errorCount
        ]);

        return [
            'total' => count($nomorSurats),
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'results' => $results
        ];
    }

    /**
     * Clean up old QR Codes
     */
    public function cleanupOldQrCodes(int $daysToKeep = 365): array
    {
        $deleted = 0;
        $errors = [];

        try {
            $this->ensureDirectoryExists();
            $files = Storage::files(self::QR_CODE_PATH);
            $cutoffTime = now()->subDays($daysToKeep)->timestamp;

            foreach ($files as $file) {
                try {
                    $lastModified = Storage::lastModified($file);
                    if ($lastModified < $cutoffTime) {
                        if (Storage::delete($file)) {
                            $deleted++;
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to process file {$file}: " . $e->getMessage();
                }
            }

            // Cleanup database references untuk file yang tidak ada
            $this->cleanupDatabaseReferences();

            Log::info('QR Code cleanup completed', [
                'deleted_files' => $deleted,
                'days_to_keep' => $daysToKeep,
                'errors_count' => count($errors)
            ]);
        } catch (\Exception $e) {
            Log::error('Cleanup QR Codes Error: ' . $e->getMessage());
            $errors[] = $e->getMessage();
        }

        return [
            'deleted_count' => $deleted,
            'errors' => $errors,
            'success' => empty($errors)
        ];
    }

    /**
     * Cleanup database references untuk file yang tidak ada
     */
    private function cleanupDatabaseReferences(): int
    {
        $cleaned = 0;

        try {
            $arsips = ArsipSurat::whereNotNull('qr_code_path')->get();

            foreach ($arsips as $arsip) {
                if (!Storage::exists($arsip->qr_code_path)) {
                    $arsip->update(['qr_code_path' => null]);
                    $cleaned++;
                }
            }
        } catch (\Exception $e) {
            Log::error('Cleanup database references error: ' . $e->getMessage());
        }

        return $cleaned;
    }

    /**
     * Get QR Code statistics
     */
    public function getQrCodeStatistics(): array
    {
        try {
            $this->ensureDirectoryExists();
            $files = Storage::files(self::QR_CODE_PATH);

            $totalFiles = count($files);
            $totalSize = 0;
            $oldestFile = null;
            $newestFile = null;

            foreach ($files as $file) {
                try {
                    $size = Storage::size($file);
                    $totalSize += $size;

                    $lastModified = Storage::lastModified($file);
                    if ($oldestFile === null || $lastModified < $oldestFile) {
                        $oldestFile = $lastModified;
                    }
                    if ($newestFile === null || $lastModified > $newestFile) {
                        $newestFile = $lastModified;
                    }
                } catch (\Exception $e) {
                    // Skip file yang error
                    continue;
                }
            }

            // Statistik dari database
            $arsipsWithQr = ArsipSurat::whereNotNull('qr_code_path')->count();
            $totalArsips = ArsipSurat::count();

            return [
                'total_files' => $totalFiles,
                'total_size_bytes' => $totalSize,
                'total_size_human' => $this->formatBytes($totalSize),
                'oldest_file' => $oldestFile ? Carbon::createFromTimestamp($oldestFile) : null,
                'newest_file' => $newestFile ? Carbon::createFromTimestamp($newestFile) : null,
                'arsips_with_qr' => $arsipsWithQr,
                'total_arsips' => $totalArsips,
                'coverage_percentage' => $totalArsips > 0 ? round(($arsipsWithQr / $totalArsips) * 100, 2) : 0
            ];
        } catch (\Exception $e) {
            Log::error('Get QR Code statistics error: ' . $e->getMessage());
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format bytes ke human readable
     */
    private function formatBytes(int $size, int $precision = 2): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Validate QR Code integrity
     */
    public function validateQrCodeIntegrity(string $nomorSurat): array
    {
        try {
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();

            if (!$arsip) {
                return [
                    'valid' => false,
                    'error' => 'Arsip surat tidak ditemukan'
                ];
            }

            if (!$arsip->qr_code_path) {
                return [
                    'valid' => false,
                    'error' => 'QR Code path tidak tersedia'
                ];
            }

            if (!Storage::exists($arsip->qr_code_path)) {
                return [
                    'valid' => false,
                    'error' => 'File QR Code tidak ditemukan'
                ];
            }

            // Cek apakah file bisa dibaca
            $content = Storage::get($arsip->qr_code_path);
            if (empty($content)) {
                return [
                    'valid' => false,
                    'error' => 'File QR Code kosong atau corrupt'
                ];
            }

            return [
                'valid' => true,
                'file_size' => strlen($content),
                'path' => $arsip->qr_code_path,
                'url' => Storage::url($arsip->qr_code_path)
            ];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
