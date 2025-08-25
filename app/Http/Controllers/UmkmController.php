<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Penduduk;
use App\Models\User;
use App\Notifications\UmkmPermohonanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UmkmController extends Controller
{
    // ========================================
    // PUBLIC METHODS
    // ========================================

    /**
     * Display form pendaftaran UMKM
     */
    public function create()
    {
        $kategoriOptions = Umkm::getKategoriOptions();

        return view('public.umkm.create', compact('kategoriOptions'));
    }

    /**
     * Store pendaftaran UMKM baru
     */
    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'nik' => [
                'required',
                'digits:16',
                'exists:penduduks,nik'
            ],
            'nama_umkm' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'kategori' => [
                'required',
                Rule::in(array_keys(Umkm::getKategoriOptions()))
            ],
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'deskripsi_produk' => [
                'required',
                'string',
                'max:1000',
                'min:10'
            ],
            'foto_produk' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048' // 2MB
            ],
            'nomor_telepon' => [
                'required',
                'string',
                'min:10',
                'max:20',
                'regex:/^[0-9+\-\s\(\)]*$/'
            ],
            'link_facebook' => [
                'nullable',
                'url',
                'max:500'
            ],
            'link_instagram' => [
                'nullable',
                'url',
                'max:500'
            ],
            'link_tiktok' => [
                'nullable',
                'url',
                'max:500'
            ]
        ], [
            // Custom error messages
            'nik.required' => 'NIK wajib diisi untuk validasi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.exists' => 'NIK tidak terdaftar sebagai warga desa. Hubungi admin jika terjadi kesalahan.',
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'nama_umkm.min' => 'Nama UMKM minimal 3 karakter.',
            'kategori.required' => 'Kategori usaha wajib dipilih.',
            'kategori.in' => 'Kategori usaha tidak valid.',
            'nama_produk.required' => 'Nama produk/jasa wajib diisi.',
            'nama_produk.min' => 'Nama produk minimal 3 karakter.',
            'deskripsi_produk.required' => 'Deskripsi produk wajib diisi.',
            'deskripsi_produk.min' => 'Deskripsi produk minimal 10 karakter.',
            'deskripsi_produk.max' => 'Deskripsi produk maksimal 1000 karakter.',
            'foto_produk.image' => 'File harus berupa gambar.',
            'foto_produk.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, WebP.',
            'foto_produk.max' => 'Ukuran gambar maksimal 2MB.',
            'nomor_telepon.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            'nomor_telepon.min' => 'Nomor telepon minimal 10 digit.',
            'nomor_telepon.regex' => 'Format nomor telepon tidak valid.',
            'link_facebook.url' => 'Link Facebook harus berupa URL yang valid.',
            'link_instagram.url' => 'Link Instagram harus berupa URL yang valid.',
            'link_tiktok.url' => 'Link TikTok harus berupa URL yang valid.',
        ]);

        // Handle file upload
        $fotoFilename = null;
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $fotoFilename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Store file ke storage/app/public/umkm-photos/
            $file->storeAs('umkm-photos', $fotoFilename, 'public');
        }

        // Cek apakah NIK sudah pernah mendaftar UMKM yang pending/approved
        $existingUmkm = Umkm::where('nik', $validated['nik'])
            ->whereIn('status', ['pending'])
            ->first();

        if ($existingUmkm) {
            // Jika upload file, hapus dulu
            if ($fotoFilename) {
                Storage::disk('public')->delete('umkm-photos/' . $fotoFilename);
            }

            return back()
                ->withInput()
                ->withErrors(['nik' => 'Anda sudah memiliki pendaftaran UMKM yang masih diproses atau telah disetujui.']);
        }

        // Create new UMKM record
        try {
            $umkm = Umkm::create([
                'nik' => $validated['nik'],
                'nama_umkm' => $validated['nama_umkm'],
                'kategori' => $validated['kategori'],
                'nama_produk' => $validated['nama_produk'],
                'deskripsi_produk' => $validated['deskripsi_produk'],
                'foto_produk' => $fotoFilename,
                'nomor_telepon' => $validated['nomor_telepon'],
                'link_facebook' => $validated['link_facebook'],
                'link_instagram' => $validated['link_instagram'],
                'link_tiktok' => $validated['link_tiktok'],
                'status' => 'pending'
            ]);
            // Kirim notifikasi ke semua admin
            $admins = User::where('roles', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new UmkmPermohonanNotification($umkm));
            }

            return redirect()
                ->route('umkm.success', ['id' => $umkm->id])
                ->with('success', 'Pendaftaran UMKM berhasil dikirim! Admin akan memverifikasi dalam 1-2 hari kerja.');
        } catch (\Exception $e) {
            // Jika gagal create, hapus file yang sudah diupload
            if ($fotoFilename) {
                Storage::disk('public')->delete('umkm-photos/' . $fotoFilename);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }

    /**
     * Halaman sukses setelah pendaftaran
     */
    public function success($id)
    {
        $umkm = Umkm::findOrFail($id);

        // Security: hanya tampilkan jika masih baru (maksimal 1 jam yang lalu)
        if ($umkm->created_at->diffInHours(now()) > 1) {
            return redirect()->route('home');
        }

        return view('public.umkm.success', compact('umkm'));
    }

    /**
     * Track status UMKM berdasarkan NIK (tanpa login)
     */
    public function track(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nik' => 'required|digits:16'
            ], [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit angka.'
            ]);

            $umkms = Umkm::where('nik', $request->nik)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($umkms->isEmpty()) {
                return back()->withErrors(['nik' => 'Tidak ditemukan pendaftaran UMKM dengan NIK tersebut.']);
            }

            return view('public.umkm.track-result', compact('umkms'));
        }

        return view('public.umkm.track');
    }

    /**
     * Display UMKM yang sudah approved di landing page
     * Method ini dipanggil dari HomeController
     */
    public static function getApprovedUmkms($limit = 6)
    {
        return Umkm::approved()
            ->latestApproved()
            ->with('penduduk')
            ->take($limit)
            ->get();
    }

    /**
     * Halaman daftar semua UMKM untuk publik (future feature)
     */
    public function publicIndex(Request $request)
    {
        $query = Umkm::approved()->with('penduduk');

        // Filter berdasarkan kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->byKategori($request->kategori);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $umkms = $query->latestApproved()->paginate(12);
        $kategoriOptions = ['semua' => 'Semua Kategori'] + Umkm::getKategoriOptions();

        return view('public.umkm.index', compact('umkms', 'kategoriOptions'));
    }

    /**
     * Show detail UMKM untuk publik (future feature)
     */
    public function publicShow($id)
    {
        // Ambil data UMKM tanpa membatasi statusnya
        $umkm = Umkm::with('penduduk')->findOrFail($id);
        return view('public.umkm.show', compact('umkm'));
    }

    /**
     * Show detail produk UMKM untuk pembeli.
     * Hanya bisa diakses untuk UMKM yang sudah disetujui.
     */
    public function publicProductShow($id)
    {
        $umkm = Umkm::approved()->with('penduduk')->findOrFail($id);

        return view('public.umkm.product_show', compact('umkm'));
    }
    // ========================================
    // ADMIN METHODS (middleware: auth, admin)
    // ========================================

    /**
     * Display admin dashboard UMKM
     */
    public function adminIndex(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Hanya admin yang bisa mengakses halaman ini.');
        }

        $tab = $request->get('tab', 'pending');

        // Statistics
        $stats = [
            'total' => Umkm::count(),
            'pending' => Umkm::pending()->count(),
            'approved' => Umkm::approved()->count(),
            'rejected' => Umkm::rejected()->count(),
        ];

        // Data berdasarkan tab yang aktif
        $query = Umkm::with(['penduduk', 'approvedBy']);

        switch ($tab) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved();
                break;
            case 'rejected':
                $query->rejected();
                break;
            default:
                // Show all
                break;
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_umkm', 'like', "%{$search}%")
                    ->orWhere('nama_produk', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('penduduk', function ($pendudukQuery) use ($search) {
                        $pendudukQuery->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        $umkms = $query->orderBy('created_at', 'desc')->paginate(15);
        $kategoriOptions = ['all' => 'Semua Kategori'] + Umkm::getKategoriOptions();
        $titleHeader = "Kelola UMKM";

        return view('admin.umkm.index', compact('umkms', 'stats', 'tab', 'kategoriOptions', 'titleHeader'));
    }
    /**
     * Display form to create new UMKM for admin.
     */
    public function adminCreate()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $kategoriOptions = Umkm::getKategoriOptions();
        $titleHeader = "Tambah UMKM Baru";
        $umkm = new Umkm(); // Objek kosong untuk form

        return view('admin.umkm.create', compact('kategoriOptions', 'titleHeader', 'umkm'));
    }
    /**
     * Display form to edit an existing UMKM for admin.
     */
    public function adminEdit($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::with('penduduk')->findOrFail($id);
        $kategoriOptions = Umkm::getKategoriOptions();
        $titleHeader = "Edit UMKM: " . $umkm->nama_umkm;

        return view('admin.umkm.edit', compact('umkm', 'kategoriOptions', 'titleHeader'));
    }
    /**
     * Show detail UMKM untuk review admin
     */
    public function adminShow($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::with(['penduduk', 'approvedBy'])->findOrFail($id);
        $titleHeader = "Detail UMKM: " . $umkm->nama_umkm;
        return view('admin.umkm.show', compact('umkm', 'titleHeader'));
    }

    /**
     * Approve UMKM
     */
    public function approve($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::findOrFail($id);

        if ($umkm->isApproved()) {
            return back()->with('warning', 'UMKM sudah disetujui sebelumnya.');
        }

        // Ambil data pemilik
        $penduduk = $umkm->penduduk;
        if (!$penduduk) {
            return back()->with('error', 'Data pemilik tidak ditemukan.');
        }

        $umkm->approve(Auth::id());

        // Pesan notifikasi WhatsApp
        $waMessage = "Pendaftaran UMKM Anda dengan nama usaha *{$umkm->nama_umkm}* telah disetujui. UMKM Anda kini sudah terdaftar di website desa. Silakan cek di tautan berikut: " . route('umkm.show', $umkm->id);
        $waLink = 'https://wa.me/' . $umkm->nomor_telepon . '?text=' . urlencode($waMessage);

        return back()->with('success', "UMKM '{$umkm->nama_umkm}' berhasil disetujui!")
            ->with('waLink', $waLink); // Tambahkan waLink ke session flash
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

        $umkm = Umkm::with('penduduk')->findOrFail($id);

        if ($umkm->isRejected()) {
            return back()->with('warning', 'UMKM sudah ditolak sebelumnya.');
        }

        $titleHeader = "Tolak UMKM: " . $umkm->nama_umkm;
        return view('admin.umkm.reject', compact('umkm', 'titleHeader'));
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

        $umkm = Umkm::findOrFail($id);

        if ($umkm->isRejected()) {
            return back()->with('warning', 'UMKM sudah ditolak sebelumnya.');
        }

        // Ambil data pemilik
        $penduduk = $umkm->penduduk;
        if (!$penduduk) {
            return back()->with('error', 'Data pemilik tidak ditemukan.');
        }

        $umkm->reject($request->catatan_admin, Auth::id());

        // Pesan notifikasi WhatsApp
        $waMessage = "Mohon maaf, pendaftaran UMKM Anda dengan nama usaha *{$umkm->nama_umkm}* telah ditolak. Catatan admin: {$request->catatan_admin}. Anda bisa mengajukan pendaftaran ulang setelah memperbaiki kekurangan data.";
        $waLink = 'https://wa.me/' . $umkm->nomor_telepon . '?text=' . urlencode($waMessage);

        return redirect()
            ->route('admin.umkm.index', ['tab' => 'rejected'])
            ->with('success', "UMKM '{$umkm->nama_umkm}' ditolak dengan catatan: {$request->catatan_admin}")
            ->with('waLink', $waLink); // Tambahkan waLink ke session flash
    }

    /**
     * Reset status UMKM ke pending (untuk yang rejected)
     */
    public function resetToPending($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::findOrFail($id);

        if (!$umkm->isRejected()) {
            return back()->with('warning', 'Hanya UMKM yang ditolak yang bisa direset ke pending.');
        }

        $umkm->update([
            'status' => 'pending',
            'catatan_admin' => null,
            'approved_at' => null,
            'approved_by' => null
        ]);

        return back()->with('success', "Status UMKM '{$umkm->nama_umkm}' direset ke pending.");
    }

    /**
     * Toggle status approved/pending untuk UMKM yang sudah approved
     */
    public function toggleStatus($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::findOrFail($id);

        if ($umkm->isApproved()) {
            // Jadikan pending
            $umkm->update([
                'status' => 'pending',
                'approved_at' => null,
                'approved_by' => null
            ]);
            $message = "UMKM '{$umkm->nama_umkm}' diubah ke status pending.";
        } elseif ($umkm->isPending()) {
            // Approve
            $umkm->approve(Auth::id());
            $message = "UMKM '{$umkm->nama_umkm}' disetujui.";
        } else {
            return back()->with('warning', 'UMKM yang ditolak tidak bisa di-toggle. Gunakan Reset to Pending.');
        }

        return back()->with('success', $message);
    }

    /**
     * Delete UMKM (hard delete)
     */
    public function destroy($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $umkm = Umkm::findOrFail($id);
        $namaUmkm = $umkm->nama_umkm;

        // Delete akan trigger model event yang otomatis hapus foto
        $umkm->delete();

        return back()->with('success', "UMKM '{$namaUmkm}' berhasil dihapus.");
    }

    /**
     * Bulk actions untuk multiple UMKM
     */
    public function bulkAction(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'umkm_ids' => 'required|array|min:1',
            'umkm_ids.*' => 'exists:umkms,id',
            'bulk_catatan' => 'required_if:action,reject|string|max:500'
        ], [
            'action.required' => 'Aksi harus dipilih.',
            'umkm_ids.required' => 'Pilih minimal 1 UMKM.',
            'umkm_ids.min' => 'Pilih minimal 1 UMKM.',
            'bulk_catatan.required_if' => 'Catatan penolakan wajib diisi untuk bulk reject.'
        ]);

        $umkmIds = $request->umkm_ids;
        $action = $request->action;
        $count = 0;

        foreach ($umkmIds as $id) {
            $umkm = Umkm::find($id);
            if (!$umkm) continue;

            switch ($action) {
                case 'approve':
                    if ($umkm->isPending() || $umkm->isRejected()) {
                        $umkm->approve(Auth::id());
                        $count++;
                    }
                    break;

                case 'reject':
                    if ($umkm->isPending() || $umkm->isApproved()) {
                        $umkm->reject($request->bulk_catatan, Auth::id());
                        $count++;
                    }
                    break;

                case 'delete':
                    $umkm->delete();
                    $count++;
                    break;
            }
        }

        $actionLabels = [
            'approve' => 'disetujui',
            'reject' => 'ditolak',
            'delete' => 'dihapus'
        ];

        return back()->with('success', "{$count} UMKM berhasil {$actionLabels[$action]}.");
    }

    /**
     * Export UMKM data ke Excel (future feature)
     */
    public function export(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        // TODO: Implement Excel export
        return back()->with('info', 'Fitur export akan segera tersedia.');
    }

    /**
     * Statistics page dengan charts (future feature)
     */
    public function statistics()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->role === 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $stats = [
            'total' => Umkm::count(),
            'pending' => Umkm::pending()->count(),
            'approved' => Umkm::approved()->count(),
            'rejected' => Umkm::rejected()->count(),
            'by_category' => Umkm::approved()
                ->selectRaw('kategori, COUNT(*) as total')
                ->groupBy('kategori')
                ->pluck('total', 'kategori'),
            'monthly_growth' => Umkm::approved()
                ->selectRaw('YEAR(approved_at) as year, MONTH(approved_at) as month, COUNT(*) as total')
                ->whereNotNull('approved_at')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->take(12)
                ->get()
        ];

        return view('admin.umkm.statistics', compact('stats'));
    }
}
