<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QrCodeController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    // ========================================
    // PUBLIC API ENDPOINTS
    // ========================================

    /**
     * Generate QR Code untuk nomor surat tertentu
     * Route: POST /api/qr-code/generate
     */
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:100',
            'size' => 'nullable|integer|min:100|max:800',
            'format' => 'nullable|in:png,svg',
            'save_to_storage' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $nomorSurat = $request->nomor_surat;
            $saveToStorage = $request->boolean('save_to_storage', true);

            if ($saveToStorage) {
                // Generate dan simpan ke storage
                $result = $this->qrCodeService->generateAndSaveQrCode($nomorSurat);

                if ($result['success']) {
                    // Update database jika ada arsip
                    $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();
                    if ($arsip) {
                        $arsip->update(['qr_code_path' => $result['path']]);
                    }
                }
            } else {
                // Generate preview tanpa simpan
                $options = [
                    'size' => $request->get('size', 300),
                    'format' => $request->get('format', 'png')
                ];
                $result = $this->qrCodeService->generateQrCodePreview($nomorSurat, $options);
            }

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success'] ? 'QR Code berhasil dibuat' : 'Gagal membuat QR Code',
                'data' => $result
            ], $result['success'] ? 200 : 500);
        } catch (\Exception $e) {
            Log::error('QR Code generation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get QR Code dalam format base64
     * Route: GET /api/qr-code/{nomorSurat}/base64
     */
    public function getBase64(string $nomorSurat, Request $request)
    {
        try {
            $regenerate = $request->boolean('regenerate', false);
            $base64 = $this->qrCodeService->getQrCodeBase64($nomorSurat, $regenerate);

            if ($base64) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'nomor_surat' => $nomorSurat,
                        'qr_code_base64' => $base64,
                        'verification_url' => route('verifikasi.surat', ['nomorSurat' => $nomorSurat])
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil QR Code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download QR Code sebagai file
     * Route: GET /qr-code/{nomorSurat}/download
     */
    public function download(string $nomorSurat, Request $request)
    {
        try {
            $size = $request->get('size', 400);
            $format = $request->get('format', 'png');

            // Generate QR Code untuk download
            if ($format === 'pdf') {
                $qrCode = $this->qrCodeService->getQrCodeForPdf($nomorSurat, $size);
                $contentType = 'image/png';
                $extension = 'png';
            } else {
                $result = $this->qrCodeService->generateQrCodePreview($nomorSurat, [
                    'size' => $size,
                    'format' => $format
                ]);

                if (!$result['success']) {
                    abort(500, 'Gagal generate QR Code');
                }

                $qrCode = $result['qr_code'];
                $contentType = 'image/' . $format;
                $extension = $format;
            }

            if (!$qrCode) {
                abort(404, 'QR Code tidak dapat dibuat');
            }

            // Sanitize nama file
            $filename = 'qr_code_' . preg_replace('/[^a-zA-Z0-9\-_]/', '_', $nomorSurat) . '.' . $extension;

            return response($qrCode)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            Log::error('QR Code download error: ' . $e->getMessage());
            abort(500, 'Gagal mendownload QR Code');
        }
    }

    /**
     * Regenerate QR Code
     * Route: POST /api/qr-code/{nomorSurat}/regenerate
     */
    public function regenerate(string $nomorSurat)
    {
        try {
            // Cek apakah arsip surat ada
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();
            if (!$arsip) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arsip surat tidak ditemukan'
                ], 404);
            }

            $result = $this->qrCodeService->regenerateQrCode($nomorSurat);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success'] ? 'QR Code berhasil di-regenerate' : 'Gagal regenerate QR Code',
                'data' => $result
            ], $result['success'] ? 200 : 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ========================================
    // ADMIN ENDPOINTS
    // ========================================

    /**
     * Bulk generate QR Codes
     * Route: POST /admin/qr-codes/bulk-generate
     */
    public function bulkGenerate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surats' => 'required|array|min:1|max:100',
            'nomor_surats.*' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $nomorSurats = array_unique($request->nomor_surats);
            $result = $this->qrCodeService->bulkGenerateQrCodes($nomorSurats);

            return response()->json([
                'success' => true,
                'message' => "Bulk generate selesai. Berhasil: {$result['success_count']}, Gagal: {$result['error_count']}",
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan bulk generate',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR Codes untuk semua arsip yang belum punya
     * Route: POST /admin/qr-codes/generate-missing
     */
    public function generateMissing(Request $request)
    {
        try {
            // Ambil arsip yang belum punya QR Code atau file QR-nya hilang
            $arsipsWithoutQr = ArsipSurat::where(function ($query) {
                $query->whereNull('qr_code_path')
                    ->orWhere('qr_code_path', '');
            })->limit(50)->get(); // Batasi untuk mencegah timeout

            if ($arsipsWithoutQr->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Semua arsip sudah memiliki QR Code',
                    'data' => ['generated_count' => 0]
                ]);
            }

            $nomorSurats = $arsipsWithoutQr->pluck('nomor_surat')->toArray();
            $result = $this->qrCodeService->bulkGenerateQrCodes($nomorSurats);

            return response()->json([
                'success' => true,
                'message' => "Berhasil generate {$result['success_count']} QR Code dari {$result['total']} arsip",
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate QR Code yang hilang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cleanup QR Codes lama
     * Route: POST /admin/qr-codes/cleanup
     */
    public function cleanup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'days_to_keep' => 'nullable|integer|min:30|max:3650'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $daysToKeep = $request->get('days_to_keep', 365);
            $result = $this->qrCodeService->cleanupOldQrCodes($daysToKeep);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['success']
                    ? "Berhasil menghapus {$result['deleted_count']} file QR Code lama"
                    : 'Cleanup gagal',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan cleanup',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Statistik QR Codes
     * Route: GET /admin/qr-codes/statistics
     */
    public function statistics()
    {
        try {
            $stats = $this->qrCodeService->getQrCodeStatistics();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate QR Code integrity
     * Route: GET /admin/qr-codes/{nomorSurat}/validate
     */
    public function validate(string $nomorSurat)
    {
        try {
            $result = $this->qrCodeService->validateQrCodeIntegrity($nomorSurat);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi QR Code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ========================================
    // WEB VIEW ENDPOINTS
    // ========================================

    /**
     * Preview QR Code di browser
     * Route: GET /qr-code/{nomorSurat}/preview
     */
    public function preview(string $nomorSurat, Request $request)
    {
        try {
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();
            if (!$arsip) {
                abort(404, 'Arsip surat tidak ditemukan');
            }

            $size = $request->get('size', 300);
            $qrBase64 = $this->qrCodeService->getQrCodeBase64($nomorSurat, true);

            if (!$qrBase64) {
                abort(500, 'Gagal generate QR Code');
            }

            $data = [
                'nomor_surat' => $nomorSurat,
                'arsip' => $arsip,
                'qr_code_base64' => $qrBase64,
                'verification_url' => route('verifikasi.surat', ['nomorSurat' => $nomorSurat]),
                'size' => $size
            ];

            return view('qr-code.preview', $data);
        } catch (\Exception $e) {
            Log::error('QR Code preview error: ' . $e->getMessage());
            abort(500, 'Gagal menampilkan preview QR Code');
        }
    }

    /**
     * Embed QR Code untuk iframe
     * Route: GET /qr-code/{nomorSurat}/embed
     */
    public function embed(string $nomorSurat, Request $request)
    {
        try {
            $size = min($request->get('size', 200), 400); // Maksimal 400px untuk embed
            $result = $this->qrCodeService->generateQrCodePreview($nomorSurat, [
                'size' => $size,
                'format' => 'png'
            ]);

            if (!$result['success']) {
                abort(500, 'Gagal generate QR Code');
            }

            return response($result['qr_code'])
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=3600'); // Cache 1 jam

        } catch (\Exception $e) {
            Log::error('QR Code embed error: ' . $e->getMessage());
            abort(500, 'Gagal embed QR Code');
        }
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    /**
     * Get QR Code info untuk AJAX
     * Route: GET /api/qr-code/{nomorSurat}/info
     */
    public function getInfo(string $nomorSurat)
    {
        try {
            $arsip = ArsipSurat::where('nomor_surat', $nomorSurat)->first();

            if (!$arsip) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arsip surat tidak ditemukan'
                ], 404);
            }

            $validation = $this->qrCodeService->validateQrCodeIntegrity($nomorSurat);

            return response()->json([
                'success' => true,
                'data' => [
                    'nomor_surat' => $nomorSurat,
                    'has_qr_code' => $validation['valid'],
                    'qr_code_path' => $arsip->qr_code_path,
                    'qr_code_url' => $validation['valid'] ? $validation['url'] : null,
                    'verification_url' => route('verifikasi.surat', ['nomorSurat' => $nomorSurat]),
                    'file_size' => $validation['file_size'] ?? null,
                    'created_at' => $arsip->created_at,
                    'updated_at' => $arsip->updated_at,
                    'validation' => $validation
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil info QR Code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR Code untuk multiple format sekaligus
     * Route: POST /api/qr-code/{nomorSurat}/generate-multi
     */
    public function generateMultiFormat(string $nomorSurat, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formats' => 'nullable|array',
            'formats.*' => 'in:png,svg',
            'sizes' => 'nullable|array',
            'sizes.*' => 'integer|min:100|max:800'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $formats = $request->get('formats', ['png']);
            $sizes = $request->get('sizes', [200, 300, 400]);

            $results = [];

            foreach ($formats as $format) {
                foreach ($sizes as $size) {
                    $result = $this->qrCodeService->generateQrCodePreview($nomorSurat, [
                        'format' => $format,
                        'size' => $size
                    ]);

                    if ($result['success']) {
                        $results["{$format}_{$size}"] = [
                            'format' => $format,
                            'size' => $size,
                            'base64' => $result['base64']
                        ];
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Multi-format QR Code berhasil dibuat',
                'data' => [
                    'nomor_surat' => $nomorSurat,
                    'verification_url' => route('verifikasi.surat', ['nomorSurat' => $nomorSurat]),
                    'qr_codes' => $results
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate multi-format QR Code',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
