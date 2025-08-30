<?php

namespace App\Http\Controllers;

use App\Models\SuratKtu;
use App\Models\User;
use App\Notifications\SuratBaruNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratKtuController extends Controller
{
    // ========================================
    // GUEST METHODS (Landing Page)
    // ========================================

    /**
     * Index Surat KTU untuk guest
     */
    public function indexPublic()
    {
        return view('public.surat-ktu.index');
    }

    /**
     * Form pengajuan surat untuk guest
     */
    public function guestForm()
    {
        return view('public.surat-ktu.form');
    }

    /**
     * Store surat dari guest
     */
    public function guestStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'required|string|max:20', // Wajib untuk guest
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKtu::createForGuest($request->all());
            $admins = User::where('roles', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new SuratBaruNotification($surat));
            }
            return redirect()
                ->route('public.surat-ktu.track', $surat->public_token)
                ->with('success', 'Pengajuan surat berhasil! Simpan link ini untuk melacak status surat Anda.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan pengajuan: ' . $e->getMessage()]);
        }
    }

    /**
     * Track surat menggunakan public token
     */
    public function guestTrack($token)
    {
        $surat = SuratKtu::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        return view('public.surat-ktu.track', compact('surat'));
    }

    /**
     * API untuk mencari surat berdasarkan token (AJAX)
     */
    public function apiTrackSurat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|min:10|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $token = trim($request->token);
            $surat = SuratKtu::findByPublicToken($token);

            if (!$surat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Surat tidak ditemukan. Pastikan kode tracking yang Anda masukkan benar.',
                ], 404);
            }

            // Return URL untuk redirect
            return response()->json([
                'success' => true,
                'message' => 'Surat ditemukan!',
                'redirect_url' => route('public.surat-ktu.track', $token),
                'data' => [
                    'nama' => $surat->nama,
                    'status' => $surat->status,
                    'tanggal_pengajuan' => $surat->created_at->format('d/m/Y H:i')
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update surat oleh guest menggunakan token
     */
    public function guestUpdate(Request $request, $token)
    {
        $surat = SuratKtu::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat->updateByPemohon($request->all(), null, $token);

            return back()->with('success', 'Data surat berhasil diperbarui');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // ========================================
    // ADMIN METHODS (Full Control)
    // ========================================

    /**
     * Dashboard admin - daftar semua surat dengan filter
     */
    public function adminIndex(Request $request)
    {
        $titleHeader = 'Daftar Surat KTU';
        $filters = $request->only(['status', 'tipe_pemohon', 'search', 'tahun']);

        $surats = SuratKtu::forAdminDashboard($filters)->paginate(15);

        // Statistik untuk dashboard
        $statistik = [
            'total' => SuratKtu::count(),
            'diproses' => SuratKtu::diproses()->count(),
            'disetujui' => SuratKtu::disetujui()->count(),
            'ditolak' => SuratKtu::ditolak()->count(),
            'guest' => SuratKtu::guest()->count(),
            'user_terdaftar' => SuratKtu::registered()->count(),
        ];

        return view('admin.surat-ktu.index', compact('surats', 'statistik', 'filters', 'titleHeader'));
    }

    /**
     * Show detail surat untuk admin
     */
    public function adminShow($id)
    {
        $titleHeader = 'Detail Surat KTU';
        $surat = SuratKtu::with('user', 'arsip')->findOrFail($id);

        return view('admin.surat-ktu.show', compact('surat', 'titleHeader'));
    }

    /**
     * Form create surat oleh admin
     */
    public function adminCreate()
    {
        $titleHeader = 'Buat Surat KTU Baru';
        // Admin bisa pilih user atau buat untuk guest
        $users = \App\Models\User::where('roles', 'user')->get();

        return view('admin.surat-ktu.create', compact('users', 'titleHeader'));
    }

    /**
     * Store surat oleh admin
     */
    // app/Http/Controllers/SuratKtuController.php

    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'nomor_surat' => 'nullable|string|unique:surat_ktus,nomor_surat',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();

            // Cek jika status 'disetujui' dan nomor_surat kosong, maka generate otomatis
            if ($data['status'] === 'disetujui' && empty($data['nomor_surat'])) {
                $data['nomor_surat'] = SuratKtu::generateNomorSurat();
            }

            $surat = SuratKtu::createByAdmin($data, $request->user_id);

            return redirect()
                ->route('admin.surat-ktu.show', $surat->id)
                ->with('success', 'Surat berhasil dibuat');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat surat: ' . $e->getMessage()]);
        }
    }
    /**
     * Edit surat oleh admin
     */
    public function adminEdit($id)
    {
        $titleHeader = 'Edit Surat KTU';
        $surat = SuratKtu::with('user')->findOrFail($id);
        $users = \App\Models\User::where('roles', 'user')->get();

        return view('admin.surat-ktu.edit', compact('surat', 'users', 'titleHeader'));
    }

    /**
     * Update surat oleh admin (full access)
     */
    public function adminUpdate(Request $request, $id)
    {
        $surat = SuratKtu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'nomor_surat' => 'nullable|string|unique:surat_ktus,nomor_surat,' . $id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $oldStatus = $surat->status;
            // Update data surat
            $surat->fill($request->except(['status'])); // Update semua kecuali status

            // Handle nomor surat jika status disetujui
            if ($request->status === 'disetujui' && !$surat->nomor_surat) {
                $surat->nomor_surat = $request->nomor_surat ?: null; // Akan di-generate di updateStatus
            }

            $surat->save();
            // Update status menggunakan method yang terintegrasi QR code
            $surat->updateStatus($request->status, $request->keterangan);
            // Simpan ke arsip jika disetujui
            if ($request->status === 'disetujui') {
                $surat->simpanKeArsip();
            }

            return redirect()
                ->route('admin.surat-ktu.show', $surat->id)
                ->with('success', 'Surat berhasil diperbarui');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui surat: ' . $e->getMessage()]);
        }
    }

    /**
     * Update status surat oleh admin (AJAX)
     */
    public function adminUpdateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:diproses,disetujui,ditolak',
            'keterangan' => 'nullable|string|max:500',
            'nomor_surat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $surat = SuratKtu::findOrFail($id);
            $oldStatus = $surat->status;

            // Set nomor surat jika disetujui dan disediakan
            if ($request->status === 'disetujui' && $request->nomor_surat) {
                $surat->nomor_surat = $request->nomor_surat;
                $surat->save();
            }

            // GUNAKAN method updateStatus() dari model untuk memastikan QR code tergenerate
            $result = $surat->updateStatus($request->status, $request->keterangan);
            if (!$result) {
                throw new Exception('Gagal mengupdate status surat');
            }

            // Simpan ke arsip jika disetujui
            if ($request->status === 'disetujui') {
                $surat->simpanKeArsip();
            }

            // Generate WhatsApp notification link
            $waLink = null;
            if ($surat->nomor_telepon) {
                $waMessage = '';
                if ($surat->status === 'disetujui') {
                    $waMessage = "Selamat! Surat Keterangan Usaha (KTU) Anda dengan nama *{$surat->nama}* telah *disetujui*";
                    if ($surat->nomor_surat) {
                        $waMessage .= " dengan nomor surat *{$surat->nomor_surat}*";
                    }
                    $waMessage .= ". Usaha: *{$surat->nama_usaha}*. Anda dapat mengunduh atau mencetak surat Anda di: " . route('public.surat-ktu.track', $surat->public_token);
                } elseif ($surat->status === 'ditolak') {
                    $catatan = $surat->keterangan ? "Alasan penolakan: {$surat->keterangan}. " : "";
                    $waMessage = "Mohon maaf, pengajuan Surat Keterangan Usaha (KTU) Anda dengan nama *{$surat->nama}* untuk usaha *{$surat->nama_usaha}* telah *ditolak*. {$catatan}Anda dapat memperbaiki data dan mengajukan ulang. Status surat dapat dilihat di: " . route('public.surat-ktu.track', $surat->public_token);
                } elseif ($surat->status === 'diproses') {
                    $waMessage = "Surat Keterangan Usaha (KTU) Anda dengan nama *{$surat->nama}* untuk usaha *{$surat->nama_usaha}* sedang dalam tahap *pemrosesan*. Mohon menunggu untuk proses selanjutnya. Cek status di: " . route('public.surat-ktu.track', $surat->public_token);
                }

                if ($waMessage) {
                    // Asumsi ada method convertToWhatsAppNumber di model SuratKtu
                    $waLink = 'https://wa.me/' . $this->convertToWhatsAppNumber($surat->nomor_telepon) . '?text=' . urlencode($waMessage);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Status surat berhasil diperbarui',
                'data' => [
                    'status' => $surat->status,
                    'nomor_surat' => $surat->nomor_surat,
                    'keterangan' => $surat->keterangan,
                    'waLink' => $waLink,
                    'old_status' => $oldStatus,
                    'nama_pemohon' => $surat->nama,
                    'nama_usaha' => $surat->nama_usaha,
                    'redirect_to_wa' => true // Flag untuk redirect ke WA
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Error updating surat status', [
                'surat_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method untuk convert nomor telepon ke format WhatsApp
     */
    private function convertToWhatsAppNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert 08xxx to 628xxx (Indonesian format)
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }

        // Add 62 if not present
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Delete surat oleh admin
     */
    public function adminDestroy($id)
    {
        try {
            $surat = SuratKtu::findOrFail($id);

            // Hapus dari arsip jika ada
            if ($surat->arsip) {
                $surat->arsip->delete();
            }

            $surat->delete();

            return redirect()
                ->route('admin.surat-ktu.index')
                ->with('success', 'Surat berhasil dihapus');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus surat: ' . $e->getMessage()]);
        }
    }

    /**
     * Bulk action untuk admin
     */
    public function adminBulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject,delete',
            'surat_ids' => 'required|array|min:1',
            'surat_ids.*' => 'exists:surat_ktus,id',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $surats = SuratKtu::whereIn('id', $request->surat_ids)->get();
            $count = 0;

            foreach ($surats as $surat) {
                switch ($request->action) {
                    case 'approve':
                        $surat->updateStatusByAdmin('disetujui', $request->keterangan);
                        $count++;
                        break;

                    case 'reject':
                        $surat->updateStatusByAdmin('ditolak', $request->keterangan);
                        $count++;
                        break;

                    case 'delete':
                        if ($surat->arsip) {
                            $surat->arsip->delete();
                        }
                        $surat->delete();
                        $count++;
                        break;
                }
            }

            $actions = [
                'approve' => 'disetujui',
                'reject' => 'ditolak',
                'delete' => 'dihapus'
            ];

            return redirect()
                ->route('admin.surat-ktu.index')
                ->with('success', "{$count} surat berhasil {$actions[$request->action]}");
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal melakukan bulk action: ' . $e->getMessage()]);
        }
    }

    // ========================================
    // QR CODE SPECIFIC METHODS
    // ========================================

    /**
     * Generate nomor surat otomatis (AJAX)
     * Method baru untuk menghindari duplicate entry
     */
    public function generateNomor(Request $request)
    {
        try {
            // Generate nomor surat yang unik
            $nomorSurat = SuratKtu::generateNomorSurat();

            return response()->json([
                'success' => true,
                'nomor_surat' => $nomorSurat,
                'message' => 'Nomor surat berhasil di-generate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate nomor surat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR Code manual untuk surat tertentu
     */
    public function generateQrCode(Request $request, $id)
    {
        try {
            $surat = SuratKtu::findOrFail($id);

            // Check permission
            if (!Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya admin yang dapat generate QR Code'
                ], 403);
            }

            // Check if can generate QR code
            if (!$surat->canGenerateQrCode()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Surat belum disetujui atau nomor surat belum ada'
                ], 400);
            }

            // Generate QR Code
            $result = $surat->generateQrCodeForSurat();

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'QR Code berhasil di-generate',
                    'data' => $surat->getQrCodeInfoForSurat()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate QR Code: ' . $result['error']
                ], 500);
            }
        } catch (Exception $e) {
            Log::error('Manual QR Code generation failed', [
                'surat_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Regenerate QR Code untuk surat tertentu
     */
    public function regenerateQrCode(Request $request, $id)
    {
        try {
            $surat = SuratKtu::findOrFail($id);

            // Check permission
            if (!Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya admin yang dapat regenerate QR Code'
                ], 403);
            }

            // Regenerate QR Code
            $result = $surat->regenerateQrCode();

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'QR Code berhasil di-regenerate',
                    'data' => $surat->getQrCodeInfoForSurat()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal regenerate QR Code: ' . $result['error']
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get QR Code info untuk AJAX
     */
    public function getQrCodeInfo($id)
    {
        try {
            $surat = SuratKtu::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $surat->getQrCodeInfoForSurat()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Surat tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Download QR Code untuk surat tertentu
     */
    public function downloadQrCode($id)
    {
        try {
            $surat = SuratKtu::findOrFail($id);

            if (!$surat->canAccess()) {
                abort(403, 'Anda tidak memiliki akses ke surat ini');
            }

            if (!$surat->hasValidQrCode()) {
                return back()->withErrors(['error' => 'QR Code tidak tersedia untuk surat ini']);
            }

            // Generate download URL dengan parameter
            $downloadUrl = $surat->getQrCodeDownloadUrl([
                'size' => 400,
                'format' => 'png'
            ]);

            return redirect($downloadUrl);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Gagal download QR Code: ' . $e->getMessage()]);
        }
    }

    // ========================================
    // SHARED METHODS
    // ========================================

    /**
     * Download/Print surat yang sudah disetujui
     */
    public function download($id, $token = null)
    {
        if ($token) {
            // Akses via public token (guest)
            $surat = SuratKtu::where('public_token', $token)->findOrFail($id);
        } else {
            // Akses via login
            $surat = SuratKtu::findOrFail($id);

            if (!$surat->canAccess()) {
                abort(403, 'Anda tidak memiliki akses ke surat ini');
            }
        }

        if (!$surat->isDisetujui()) {
            abort(403, 'Surat belum disetujui');
        }
        // Ambil info QR Code untuk ditampilkan di halaman print
        $qrCodeInfo = $surat->getQrCodeInfoForSurat();
        // Generate PDF atau redirect ke view print
        return view('surat-ktu.print', compact('surat', 'qrCodeInfo'));
    }

    /**
     * API untuk statistik dashboard
     */
    public function apiStatistik(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $data = [
            'status' => SuratKtu::statistikStatus($tahun),
            'tipe_pemohon' => SuratKtu::statistikTipePemohon($tahun),
            'per_bulan' => SuratKtu::totalPerBulan($tahun),
            'terbaru' => SuratKtu::suratTerbaru(5)->map(function ($surat) {
                return [
                    'id' => $surat->id,
                    'nama' => $surat->nama,
                    'status' => $surat->status,
                    'tipe' => $surat->tipe_pemohon,
                    'tanggal' => $surat->created_at->format('d/m/Y H:i'),
                ];
            }),
        ];

        return response()->json($data);
    }

    /**
     * Export data surat ke PDF - DENGAN QR CODE OTOMATIS
     */
    public function export(Request $request, $id, $token = null)
    {
        if ($token) {
            // Guest access - pakai token
            $surat = SuratKtu::where('public_token', $token)->findOrFail($id);
        } else {
            // Admin/User access - pakai login
            $surat = SuratKtu::findOrFail($id);

            // Check access untuk user (bukan admin)
            if ($request->user() && !$request->user()->isAdmin() && !$surat->canAccess()) {
                abort(403, 'Anda tidak memiliki akses ke surat ini');
            }
        }

        // Validasi status surat
        if ($surat->status !== 'disetujui') {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Surat belum disetujui, tidak bisa diekspor']);
        }

        $tanggal_dikeluarkan = $surat->updated_at->format('d/m/Y');

        // SIMPLE: Ambil QR Code base64 - otomatis generate jika belum ada
        $qrCodeBase64 = $surat->getQrCodeForPdf();

        // URL verifikasi untuk QR Code
        $verifikasiUrl = route('verifikasi.surat', ['nomorSurat' => $surat->nomor_surat]);

        $response = Pdf::loadView('admin.surat-ktu.pdf', compact(
            'surat',
            'tanggal_dikeluarkan',
            'qrCodeBase64',
            'verifikasiUrl'
        ))->download('surat-ktu-' . $surat->nama . '.pdf');

        return $response;
    }

    // ========================================
    // USER METHODS (Login Required)
    // ========================================

    /**
     * Dashboard user - daftar surat milik user
     */
    public function userIndex()
    {
        $surats = SuratKtu::forUserDashboard()->paginate(10);

        return view('user.surat-ktu.index', compact('surats'));
    }

    /**
     * Form pengajuan surat untuk user terdaftar
     */
    public function userForm()
    {
        return view('user.surat-ktu.form');
    }

    /**
     * Store surat dari user terdaftar
     */
    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20', // Optional untuk user terdaftar
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKtu::createForUser($request->all());

            return redirect()
                ->route('user.surat-ktu.show', $surat->id)
                ->with('success', 'Pengajuan surat berhasil dibuat');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan pengajuan: ' . $e->getMessage()]);
        }
    }

    /**
     * Show detail surat untuk user
     */
    public function userShow($id)
    {
        $surat = SuratKtu::findOrFail($id);

        if (!$surat->canAccess()) {
            abort(403, 'Anda tidak memiliki akses ke surat ini');
        }
        // Ambil info QR Code jika surat disetujui
        $qrCodeInfo = $surat->isDisetujui() ? $surat->getQrCodeInfoForSurat() : null;

        return view('user.surat-ktu.show', compact('surat', 'qrCodeInfo'));
    }

    /**
     * Edit surat oleh user
     */
    public function userEdit($id)
    {
        $surat = SuratKtu::findOrFail($id);

        if (!$surat->canEdit()) {
            abort(403, 'Surat tidak dapat diedit');
        }

        return view('user.surat-ktu.edit', compact('surat'));
    }

    /**
     * Update surat oleh user
     */
    public function userUpdate(Request $request, $id)
    {
        $surat = SuratKtu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'kewarganegaraan' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat->updateByPemohon($request->all());

            return redirect()
                ->route('user.surat-ktu.show', $surat->id)
                ->with('success', 'Data surat berhasil diperbarui');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
