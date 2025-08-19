<?php

namespace App;

use App\Services\QrCodeService;
use Illuminate\Support\Facades\Log;

/**
 * Trait untuk menambahkan fungsi QR Code ke model
 * Digunakan di ArsipSurat dan SuratKtm
 */
trait HasQrCode
{
    /**
     * Generate QR Code untuk model ini
     */
    public function generateQrCode(): array
    {
        try {
            $qrService = app(QrCodeService::class);
            $result = $qrService->generateAndSaveQrCode($this->nomor_surat);

            if ($result['success']) {
                // Update path QR Code di database
                $this->update(['qr_code_path' => $result['path']]);

                Log::info('QR Code generated for model', [
                    'model' => get_class($this),
                    'id' => $this->id,
                    'nomor_surat' => $this->nomor_surat
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Generate QR Code failed', [
                'model' => get_class($this),
                'id' => $this->id,
                'nomor_surat' => $this->nomor_surat,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get QR Code dalam format base64
     */
    public function getQrCodeBase64(bool $generateIfMissing = true): ?string
    {
        $qrService = app(QrCodeService::class);
        return $qrService->getQrCodeBase64($this->nomor_surat, $generateIfMissing);
    }

    /**
     * Get QR Code URL untuk download
     */
    public function getQrCodeDownloadUrl(array $params = []): string
    {
        $defaultParams = ['size' => 400, 'format' => 'png'];
        $params = array_merge($defaultParams, $params);

        return route('qr-code.download', $this->nomor_surat) . '?' . http_build_query($params);
    }

    /**
     * Get QR Code preview URL
     */
    public function getQrCodePreviewUrl(array $params = []): string
    {
        $defaultParams = ['size' => 300];
        $params = array_merge($defaultParams, $params);

        return route('qr-code.preview', $this->nomor_surat) . '?' . http_build_query($params);
    }

    /**
     * Get QR Code embed URL untuk iframe
     */
    public function getQrCodeEmbedUrl(int $size = 200): string
    {
        return route('qr-code.embed', $this->nomor_surat) . '?size=' . $size;
    }

    /**
     * Check apakah QR Code sudah ada dan valid
     */
    public function hasValidQrCode(): bool
    {
        $qrService = app(QrCodeService::class);
        $validation = $qrService->validateQrCodeIntegrity($this->nomor_surat);

        return $validation['valid'] ?? false;
    }

    /**
     * Regenerate QR Code
     */
    public function regenerateQrCode(): array
    {
        try {
            $qrService = app(QrCodeService::class);
            $result = $qrService->regenerateQrCode($this->nomor_surat);

            if ($result['success']) {
                $this->update(['qr_code_path' => $result['path']]);
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
     * Get verification URL untuk QR Code
     */
    public function getVerificationUrl(): string
    {
        return route('verifikasi.surat', ['nomorSurat' => $this->nomor_surat]);
    }

    /**
     * Get QR Code info untuk display di UI
     */
    public function getQrCodeInfo(): array
    {
        return [
            'nomor_surat' => $this->nomor_surat,
            'has_qr_code' => $this->hasValidQrCode(),
            'qr_code_path' => $this->qr_code_path,
            'verification_url' => $this->getVerificationUrl(),
            'download_url' => $this->getQrCodeDownloadUrl(),
            'preview_url' => $this->getQrCodePreviewUrl(),
            'embed_url' => $this->getQrCodeEmbedUrl(),
            'can_regenerate' => !empty($this->nomor_surat)
        ];
    }

    /**
     * Delete QR Code file
     */
    public function deleteQrCode(): bool
    {
        try {
            if ($this->qr_code_path) {
                $qrService = app(QrCodeService::class);
                $deleted = $qrService->deleteQrCode($this->qr_code_path);

                if ($deleted) {
                    $this->update(['qr_code_path' => null]);
                }

                return $deleted;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Delete QR Code failed', [
                'model' => get_class($this),
                'id' => $this->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    // ========================================
    // SCOPE METHODS
    // ========================================

    /**
     * Scope untuk model yang sudah punya QR Code
     */
    public function scopeWithQrCode($query)
    {
        return $query->whereNotNull('qr_code_path')
            ->where('qr_code_path', '!=', '');
    }

    /**
     * Scope untuk model yang belum punya QR Code
     */
    public function scopeWithoutQrCode($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('qr_code_path')
                ->orWhere('qr_code_path', '');
        });
    }

    // ========================================
    // MODEL EVENTS (Optional - implement di model)
    // ========================================

    /**
     * Boot method untuk auto-generate QR Code
     * Tambahkan di model yang menggunakan trait ini
     */
    protected static function bootHasQrCode()
    {
        // Auto generate QR Code ketika nomor_surat berubah
        static::updated(function ($model) {
            if ($model->isDirty('nomor_surat') && $model->nomor_surat) {
                // Generate QR Code di background (optional)
                // dispatch(new GenerateQrCodeJob($model));
            }
        });

        // Hapus QR Code ketika model dihapus
        static::deleting(function ($model) {
            $model->deleteQrCode();
        });
    }
}

// ========================================
// HELPER CLASS UNTUK QR CODE UTILITIES
// ========================================

class QrCodeHelper
{
    /**
     * Generate QR Code untuk multiple nomor surat
     */
    public static function bulkGenerate(array $nomorSurats): array
    {
        $qrService = app(QrCodeService::class);
        return $qrService->bulkGenerateQrCodes($nomorSurats);
    }

    /**
     * Generate QR Code HTML tag untuk embed di view
     */
    public static function generateHtmlTag(string $nomorSurat, array $options = []): string
    {
        $defaultOptions = [
            'size' => 200,
            'class' => 'qr-code',
            'alt' => 'QR Code untuk ' . $nomorSurat,
            'loading' => 'lazy'
        ];

        $options = array_merge($defaultOptions, $options);

        $embedUrl = route('qr-code.embed', $nomorSurat) . '?size=' . $options['size'];

        return sprintf(
            '<img src="%s" class="%s" alt="%s" loading="%s" width="%d" height="%d">',
            $embedUrl,
            $options['class'],
            $options['alt'],
            $options['loading'],
            $options['size'],
            $options['size']
        );
    }

    /**
     * Generate QR Code iframe untuk embed
     */
    public static function generateIframe(string $nomorSurat, array $options = []): string
    {
        $defaultOptions = [
            'size' => 200,
            'class' => 'qr-code-iframe',
            'border' => 'none'
        ];

        $options = array_merge($defaultOptions, $options);

        $embedUrl = route('qr-code.embed', $nomorSurat) . '?size=' . $options['size'];

        return sprintf(
            '<iframe src="%s" class="%s" width="%d" height="%d" style="border: %s;"></iframe>',
            $embedUrl,
            $options['class'],
            $options['size'],
            $options['size'],
            $options['border']
        );
    }

    /**
     * Generate download button HTML
     */
    public static function generateDownloadButton(string $nomorSurat, array $options = []): string
    {
        $defaultOptions = [
            'text' => 'Download QR Code',
            'class' => 'btn btn-primary',
            'size' => 400,
            'format' => 'png'
        ];

        $options = array_merge($defaultOptions, $options);

        $downloadUrl = route('qr-code.download', $nomorSurat) . '?' . http_build_query([
            'size' => $options['size'],
            'format' => $options['format']
        ]);

        return sprintf(
            '<a href="%s" class="%s" download>%s</a>',
            $downloadUrl,
            $options['class'],
            $options['text']
        );
    }

    /**
     * Get QR Code statistics
     */
    public static function getStatistics(): array
    {
        $qrService = app(QrCodeService::class);
        return $qrService->getQrCodeStatistics();
    }

    /**
     * Cleanup old QR Codes
     */
    public static function cleanup(int $daysToKeep = 365): array
    {
        $qrService = app(QrCodeService::class);
        return $qrService->cleanupOldQrCodes($daysToKeep);
    }
}
