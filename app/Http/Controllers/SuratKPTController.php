<?php

namespace App\Http\Controllers;

use App\Models\SuratKPT;
use App\Models\User;
use App\Models\StrukturDesa; // Import model StrukturDesa
use App\Notifications\SuratBaruNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Services\WhatsAppService; // Import service baru

class SuratKPTController extends Controller
{
    // Inject WhatsAppService
    protected $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    // ========================================
    // GUEST METHODS (Landing Page)
    // ========================================

    /**
     * Index Surat KPT untuk guest
     */
    public function indexPublic()
    {
        return view('public.surat-kpt.index');
    }

    /**
     * Form pengajuan surat untuk guest
     */
    public function guestForm()
    {
        return view('public.surat-kpt.form');
    }

    /**
     * Store surat dari guest
     */
    public function guestStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_yang_bersangkutan' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'alamat_yang_bersangkutan' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_orang_tua' => 'required|string|max:255',
            'penghasilan_per_bulan' => 'required|integer',
            'keperluan' => 'required|string',
            'tanggal_surat' => 'required|date',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $surat = SuratKPT::createForGuest($request->all());
            // Kirim notifikasi ke semua admin
            $admins = User::where('roles', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new SuratBaruNotification($surat));
            }

            return redirect()
                ->route('public.surat-kpt.track', $surat->public_token)
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
        $surat = SuratKPT::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        return view('public.surat-kpt.track', compact('surat'));
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
            $surat = SuratKPT::findByPublicToken($token);

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
                'redirect_url' => route('public.surat-kpt.track', $token),
                'data' => [
                    'nama_yang_bersangkutan' => $surat->nama_yang_bersangkutan,
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
        $surat = SuratKPT::findByPublicToken($token);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'nama_yang_bersangkutan' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'alamat_yang_bersangkutan' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_orang_tua' => 'required|string|max:255',
            'penghasilan_per_bulan' => 'required|integer',
            'keperluan' => 'required|string',
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
        $titleHeader = 'Daftar Surat KPT';
        $filters = $request->only(['status', 'tipe_pemohon', 'search', 'tahun']);

        $surats = SuratKPT::forAdminDashboard($filters)->paginate(15);

        // Statistik untuk dashboard
        $statistik = [
            'total' => SuratKPT::count(),
            'diproses' => SuratKPT::diproses()->count(),
            'disetujui' => SuratKPT::disetujui()->count(),
            'ditolak' => SuratKPT::ditolak()->count(),
            'guest' => SuratKPT::guest()->count(),
            'user_terdaftar' => SuratKPT::registered()->count(),
        ];

        return view('admin.surat-kpt.index', compact('surats', 'statistik', 'filters', 'titleHeader'));
    }

    /**
     * Show detail surat untuk admin
     */
    public function adminShow($id)
    {
        $titleHeader = 'Detail Surat KPT';
        $surat = SuratKPT::with('user', 'arsip')->findOrFail($id);

        return view('admin.surat-kpt.show', compact('surat', 'titleHeader'));
    }

    /**
     * Form create surat oleh admin
     */
    public function adminCreate()
    {
        $titleHeader = 'Buat Surat KPT Baru';
        // Admin bisa pilih user atau buat untuk guest
        $users = \App\Models\User::where('roles', 'user')->get();

        return view('admin.surat-kpt.create', compact('users', 'titleHeader'));
    }

    /**
     * Store surat oleh admin
     */
    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama_yang_bersangkutan' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'alamat_yang_bersangkutan' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_orang_tua' => 'required|string|max:255',
            'penghasilan_per_bulan' => 'required|integer',
            'keperluan' => 'required|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'keterangan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|unique:surat_k_p_t_s,nomor_surat',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Ambil data Kepala Desa
            $kepalaDesa = StrukturDesa::where('kategori', 'kepala_desa')->aktif()->first();
            if (!$kepalaDesa) {
                return back()->withInput()->withErrors(['error' => 'Data Kepala Desa tidak ditemukan!']);
            }

            // Ambil semua data dari request
            $data = $request->all();

            // Tambahkan data penanda tangan ke request
            $data['nama'] = $kepalaDesa->nama;
            $data['jabatan'] = $kepalaDesa->posisi;
            $data['alamat'] = 'Kilwaru'; // Alamat tetap "Kilwaru"

            $surat = SuratKPT::createByAdmin($data, $request->user_id);

            return redirect()
                ->route('admin.surat-kpt.show', $surat->id)
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
        $titleHeader = 'Edit Surat KPT';
        $surat = SuratKPT::with('user')->findOrFail($id);
        $users = \App\Models\User::where('roles', 'user')->get();

        return view('admin.surat-kpt.edit', compact('surat', 'users', 'titleHeader'));
    }

    /**
     * Generate nomor surat otomatis (AJAX)
     */
    public function generateNomor(Request $request)
    {
        try {
            // Generate nomor surat yang unik
            $nomorSurat = SuratKPT::generateNomorSurat();

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
        $surat = SuratKPT::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'nama_yang_bersangkutan' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'alamat_yang_bersangkutan' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_orang_tua' => 'required|string|max:255',
            'penghasilan_per_bulan' => 'required|integer',
            'keperluan' => 'required|string',
            'nomor_telepon' => 'required_if:user_id,null|nullable|string|max:20',
            'status' => 'required|in:diproses,disetujui,ditolak',
            'keterangan' => 'nullable|string',
            'nomor_surat' => 'nullable|string|unique:surat_k_p_t_s,nomor_surat,' . $id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Ambil data Kepala Desa
            $kepalaDesa = StrukturDesa::where('kategori', 'kepala_desa')->aktif()->first();
            if (!$kepalaDesa) {
                return back()->withInput()->withErrors(['error' => 'Data Kepala Desa tidak ditemukan!']);
            }

            $data = $request->except(['nama', 'jabatan', 'alamat']);
            
            // Tambahkan data penanda tangan ke data update
            $data['nama'] = $kepalaDesa->nama;
            $data['jabatan'] = $kepalaDesa->posisi;
            $data['alamat'] = 'Kilwaru';

            $surat->fill($data);
            $surat->save();

            // Update status menggunakan method dari model yang terintegrasi QR code
            $surat->updateStatus($request->status, $request->keterangan);

            // Generate WhatsApp notification link menggunakan service
            $waLink = $this->waService->generateSuratNotificationLink($surat, $surat->status, 'SuratKPT');

            return redirect()
                ->route('admin.surat-kpt.show', $surat->id)
                ->with('success', 'Surat berhasil diperbarui')
                ->with('waLink', $waLink);
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
            $surat = SuratKPT::findOrFail($id);
            $oldStatus = $surat->status;

            // Set nomor surat jika disetujui dan disediakan
            if ($request->status === 'disetujui' && $request->nomor_surat) {
                $surat->nomor_surat = $request->nomor_surat;
                $surat->save();
            }

            // Update status menggunakan method updateStatus() dari model
            $result = $surat->updateStatus($request->status, $request->keterangan);
            if (!$result) {
                throw new \Exception('Gagal mengupdate status surat');
            }

            // Generate WhatsApp notification link menggunakan service
            $waLink = $this->waService->generateSuratNotificationLink($surat, $surat->status, 'SuratKPT');

            return response()->json([
                'success' => true,
                'message' => 'Status surat berhasil diperbarui',
                'data' => [
                    'status' => $surat->status,
                    'nomor_surat' => $surat->nomor_surat,
                    'keterangan' => $surat->keterangan,
                    'waLink' => $waLink,
                    'old_status' => $oldStatus,
                    'nama_pemohon' => $surat->nama_yang_bersangkutan,
                    'redirect_to_wa' => true // Flag untuk redirect ke WA
                ]
            ]);
        } catch (\Exception $e) {
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
     * Delete surat oleh admin
     */
    public function adminDestroy($id)
    {
        try {
            $surat = SuratKPT::findOrFail($id);

            if ($surat->arsip) {
                $surat->arsip->delete();
            }

            $surat->delete();

            return redirect()
                ->route('admin.surat-kpt.index')
                ->with('success', 'Surat berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus surat: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject UMKM dengan form catatan
     */
    public function rejectForm($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $surat = SuratKPT::findOrFail($id);

        if ($surat->isDitolak()) {
            return back()->with('warning', 'Surat sudah ditolak sebelumnya.');
        }

        $titleHeader = "Tolak Surat KPT: " . $surat->nama_yang_bersangkutan;
        return view('admin.surat-kpt.reject', compact('surat', 'titleHeader'));
    }

    /**
     * Process reject UMKM
     */
    public function reject(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ], [
            'catatan_admin.required' => 'Catatan penolakan wajib diisi.',
            'catatan_admin.max' => 'Catatan maksimal 500 karakter.'
        ]);

        $surat = SuratKPT::findOrFail($id);

        if ($surat->isDitolak()) {
            return back()->with('warning', 'Surat sudah ditolak sebelumnya.');
        }

        $surat->updateStatus('ditolak', $request->catatan_admin);

        // Pesan notifikasi WhatsApp
        $waLink = $this->waService->generateSuratNotificationLink($surat, 'ditolak', 'SuratKPT');

        return redirect()
            ->route('admin.surat-kpt.index', ['tab' => 'rejected'])
            ->with('success', "Surat '{$surat->nama_yang_bersangkutan}' ditolak dengan catatan: {$request->catatan_admin}")
            ->with('waLink', $waLink); // Tambahkan waLink ke session flash
    }

    /**
     * Bulk action untuk admin
     */
    public function adminBulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject,delete',
            'surat_ids' => 'required|array|min:1',
            'surat_ids.*' => 'exists:surat_k_p_t_s,id',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $surats = SuratKPT::whereIn('id', $request->surat_ids)->get();
            $count = 0;
            $waLinks = [];

            foreach ($surats as $surat) {
                switch ($request->action) {
                    case 'approve':
                        $surat->updateStatusByAdmin('disetujui', $request->keterangan);
                        // Logika WA
                        $waLinks[] = $this->waService->generateSuratNotificationLink($surat, 'disetujui', 'SuratKPT');
                        $count++;
                        break;

                    case 'reject':
                        $surat->updateStatusByAdmin('ditolak', $request->keterangan);
                        // Logika WA
                        $waLinks[] = $this->waService->generateSuratNotificationLink($surat, 'ditolak', 'SuratKPT');
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

            $response = redirect()
                ->route('admin.surat-kpt.index')
                ->with('success', "{$count} surat berhasil {$actions[$request->action]}");

            if ($request->action !== 'delete' && count($waLinks) > 0) {
                return $response->with('waLinks', $waLinks);
            }

            return $response;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melakukan bulk action: ' . $e->getMessage()]);
        }
    }

    /**
     * Download/Print surat yang sudah disetujui
     */
    public function download($id, $token = null)
    {
        if ($token) {
            // Akses via public token (guest)
            $surat = SuratKPT::where('public_token', $token)->findOrFail($id);
        } else {
            // Akses via login
            $surat = SuratKPT::findOrFail($id);

            if (!$surat->canAccess()) {
                abort(403, 'Anda tidak memiliki akses ke surat ini');
            }
        }

        if (!$surat->isDisetujui()) {
            abort(403, 'Surat belum disetujui');
        }

        $qrCodeBase64 = $surat->getQrCodeForPdf();
        $verifikasiUrl = route('verifikasi.surat', ['nomorSurat' => $surat->nomor_surat]);

        return view('admin.surat-kpt.pdf', compact('surat', 'qrCodeBase64', 'verifikasiUrl'));
    }
}
