<?php

namespace App\Http\Controllers;

use App\Models\SuratKtm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratKtmController extends Controller
{
    // ========================================
    // GUEST METHODS (Landing Page)
    // ========================================

    /**
     * Index Surat KTM untuk guest
     */
    public function indexPublic()
    {
        return view('public.surat-ktm.index');
    }

    /**
     * Form pengajuan surat untuk guest
     */
    public function guestForm()
    {
        return view('public.surat-ktm.form');
    }

    /**
     * Store surat dari guest
     */
    public function guestStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20', // Wajib untuk guest
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKtm::createForGuest($request->all());

            return redirect()
                ->route('public.surat-ktm.track', $surat->public_token)
                ->with('success', 'Pengajuan surat berhasil! Simpan link ini untuk melacak status surat Anda.');
        } catch (\Exception $e) {
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
        $surat = SuratKtm::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        return view('public.surat-ktm.track', compact('surat'));
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
            $surat = SuratKtm::findByPublicToken($token);

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
                'redirect_url' => route('public.surat-ktm.track', $token),
                'data' => [
                    'nama' => $surat->nama,
                    'status' => $surat->status,
                    'tanggal_pengajuan' => $surat->created_at->format('d/m/Y H:i')
                ]
            ]);
        } catch (\Exception $e) {
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
        $surat = SuratKtm::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat->updateByPemohon($request->all(), null, $token);

            return back()->with('success', 'Data surat berhasil diperbarui');
        } catch (\Exception $e) {
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
        $titleHeader = 'Daftar Surat KTM';
        $filters = $request->only(['status', 'tipe_pemohon', 'search', 'tahun']);

        $surats = SuratKtm::forAdminDashboard($filters)->paginate(15);

        // Statistik untuk dashboard
        $statistik = [
            'total' => SuratKtm::count(),
            'diproses' => SuratKtm::diproses()->count(),
            'disetujui' => SuratKtm::disetujui()->count(),
            'ditolak' => SuratKtm::ditolak()->count(),
            'guest' => SuratKtm::guest()->count(),
            'user_terdaftar' => SuratKtm::registered()->count(),
        ];

        return view('admin.surat-ktm.index', compact('surats', 'statistik', 'filters', 'titleHeader'));
    }

    /**
     * Show detail surat untuk admin
     */
    public function adminShow($id)
    {
        $titleHeader = 'Detail Surat KTM';
        $surat = SuratKtm::with('user', 'arsip')->findOrFail($id);

        return view('admin.surat-ktm.show', compact('surat', 'titleHeader'));
    }

    /**
     * Form create surat oleh admin
     */
    public function adminCreate()
    {
        $titleHeader = 'Buat Surat KTM Baru';
        // Admin bisa pilih user atau buat untuk guest
        $users = \App\Models\User::where('roles', 'user')->get();

        return view('admin.surat-ktm.create', compact('users', 'titleHeader'));
    }

    /**
     * Store surat oleh admin
     */
    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'keterangan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|unique:surat_ktms,nomor_surat',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKtm::createByAdmin($request->all(), $request->user_id);

            return redirect()
                ->route('admin.surat-ktm.show', $surat->id)
                ->with('success', 'Surat berhasil dibuat');
        } catch (\Exception $e) {
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
        $titleHeader = 'Edit Surat KTM';
        $surat = SuratKtm::with('user')->findOrFail($id);
        $users = \App\Models\User::where('roles', 'user')->get();
        // Format tanggal lahir jika ada
        // if ($surat->tanggal_lahir) {
        //     $surat->tanggal_lahir = \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d');
        // }

        return view('admin.surat-ktm.edit', compact('surat', 'users', 'titleHeader'));
    }

    /**
     * Generate nomor surat otomatis (AJAX)
     * Method baru untuk menghindari duplicate entry
     */
    public function generateNomor(Request $request)
    {
        try {
            // Generate nomor surat yang unik
            $nomorSurat = SuratKtm::generateNomorSurat();

            return response()->json([
                'success' => true,
                'nomor_surat' => $nomorSurat,
                'message' => 'Nomor surat berhasil di-generate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate nomor surat: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update surat oleh admin (full access)
     */
    public function adminUpdate(Request $request, $id)
    {
        $surat = SuratKtm::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'keterangan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|unique:surat_ktms,nomor_surat,' . $id,
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
                ->route('admin.surat-ktm.show', $surat->id)
                ->with('success', 'Surat berhasil diperbarui');
        } catch (\Exception $e) {
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
            $surat = SuratKtm::findOrFail($id);

            // Set nomor surat jika disetujui dan disediakan
            if ($request->status === 'disetujui' && $request->nomor_surat) {
                $surat->nomor_surat = $request->nomor_surat;
                $surat->save();
            }

            // GUNAKAN method updateStatus() dari model untuk memastikan QR code tergenerate
            $result = $surat->updateStatus($request->status, $request->keterangan);
            if (!$result) {
                throw new \Exception('Gagal mengupdate status surat');
            }


            return response()->json([
                'success' => true,
                'message' => 'Status surat berhasil diperbarui',
                'data' => [
                    'status' => $surat->status,
                    'nomor_surat' => $surat->nomor_surat,
                    'keterangan' => $surat->keterangan,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Delete surat oleh admin
     */
    public function adminDestroy($id)
    {
        try {
            $surat = SuratKtm::findOrFail($id);

            // Hapus dari arsip jika ada
            if ($surat->arsip) {
                $surat->arsip->delete();
            }

            $surat->delete();

            return redirect()
                ->route('admin.surat-ktm.index')
                ->with('success', 'Surat berhasil dihapus');
        } catch (\Exception $e) {
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
            'surat_ids.*' => 'exists:surat_ktms,id',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $surats = SuratKtm::whereIn('id', $request->surat_ids)->get();
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
                ->route('admin.surat-ktm.index')
                ->with('success', "{$count} surat berhasil {$actions[$request->action]}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melakukan bulk action: ' . $e->getMessage()]);
        }
    }
    // ========================================
    // QR CODE SPECIFIC METHODS - BARU
    // ========================================

    /**
     * Generate QR Code manual untuk surat tertentu
     */
    public function generateQrCode(Request $request, $id)
    {
        try {
            $surat = SuratKtm::findOrFail($id);

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
        } catch (\Exception $e) {
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
            $surat = SuratKtm::findOrFail($id);

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
        } catch (\Exception $e) {
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
            $surat = SuratKtm::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $surat->getQrCodeInfoForSurat()
            ]);
        } catch (\Exception $e) {
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
            $surat = SuratKtm::findOrFail($id);

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
        } catch (\Exception $e) {
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
            $surat = SuratKtm::where('public_token', $token)->findOrFail($id);
        } else {
            // Akses via login
            $surat = SuratKtm::findOrFail($id);

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
        return view('surat-ktm.print', compact('surat', 'qrCodeInfo'));
    }

    /**
     * API untuk statistik dashboard
     */
    public function apiStatistik(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $data = [
            'status' => SuratKtm::statistikStatus($tahun),
            'tipe_pemohon' => SuratKtm::statistikTipePemohon($tahun),
            'per_bulan' => SuratKtm::totalPerBulan($tahun),
            'terbaru' => SuratKtm::suratTerbaru(5)->map(function ($surat) {
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
            $surat = SuratKtm::where('public_token', $token)->findOrFail($id);
        } else {
            // Admin/User access - pakai login
            $surat = SuratKtm::findOrFail($id);

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

        $response = Pdf::loadView('admin.surat-ktm.pdf', compact(
            'surat',
            'tanggal_dikeluarkan',
            'qrCodeBase64',
            'verifikasiUrl'
        ))->download('surat-ktm-' . $surat->nama . '.pdf');

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
        $surats = SuratKtm::forUserDashboard()->paginate(10);

        return view('user.surat-ktm.index', compact('surats'));
    }

    /**
     * Form pengajuan surat untuk user terdaftar
     */
    public function userForm()
    {
        return view('user.surat-ktm.form');
    }

    /**
     * Store surat dari user terdaftar
     */
    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20', // Optional untuk user terdaftar
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKtm::createForUser($request->all());

            return redirect()
                ->route('user.surat-ktm.show', $surat->id)
                ->with('success', 'Pengajuan surat berhasil dibuat');
        } catch (\Exception $e) {
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
        $surat = SuratKtm::findOrFail($id);

        if (!$surat->canAccess()) {
            abort(403, 'Anda tidak memiliki akses ke surat ini');
        }
        // Ambil info QR Code jika surat disetujui
        $qrCodeInfo = $surat->isDisetujui() ? $surat->getQrCodeInfoForSurat() : null;

        return view('user.surat-ktm.show', compact('surat', 'qrCodeInfo'));
    }

    /**
     * Edit surat oleh user
     */
    public function userEdit($id)
    {
        $surat = SuratKtm::findOrFail($id);

        if (!$surat->canEdit()) {
            abort(403, 'Surat tidak dapat diedit');
        }

        return view('user.surat-ktm.edit', compact('surat'));
    }

    /**
     * Update surat oleh user
     */
    public function userUpdate(Request $request, $id)
    {
        $surat = SuratKtm::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat->updateByPemohon($request->all());

            return redirect()
                ->route('user.surat-ktm.show', $surat->id)
                ->with('success', 'Data surat berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
