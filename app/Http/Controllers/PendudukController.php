<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Penduduk::with('kk');
        $titleHeader = "Kelola Penduduk";

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_kk', 'LIKE', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'all') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by agama
        if ($request->filled('agama') && $request->agama !== 'all') {
            $query->where('agama', $request->agama);
        }

        // Filter by status keluarga
        if ($request->filled('status_keluarga') && $request->status_keluarga !== 'all') {
            $query->where('status_keluarga', $request->status_keluarga);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_lengkap');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $penduduk = $query->paginate(15)->withQueryString();

        // Data untuk filter dropdown
        $agamaList = Penduduk::distinct()->pluck('agama')->sort();
        $statusKeluargaList = Penduduk::distinct()->pluck('status_keluarga')->sort();

        return view('admin.penduduk.index', compact(
            'penduduk',
            'agamaList',
            'statusKeluargaList',
            'titleHeader'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $titleHeader = "Buat Data Penduduk";
        // Ambil data KK dengan nama kepala keluarga, diurutkan berdasarkan nama kepala keluarga
        $kkList = KK::select('no_kk', 'nama_kepala_keluarga', 'alamat', 'desa')
            ->orderBy('nama_kepala_keluarga', 'asc')
            ->get();

        return view('admin.penduduk.create', compact('kkList', 'titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:penduduks,nik'],
            'no_kk' => ['required', 'string', 'exists:k_k_s,no_kk'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'agama' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'string', 'max:100'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
            'status_keluarga' => ['required', 'string', 'max:50'],
            'golongan_darah' => ['nullable', 'string', 'max:3'],
            'kewarganegaraan' => ['required', 'string', 'max:50'],
            'nama_ayah' => ['required', 'string', 'max:255'],
            'nama_ibu' => ['required', 'string', 'max:255'],
        ]);

        Penduduk::create($validated);

        return redirect()
            ->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Using route model binding with NIK
     */
    public function show(string $nik): View
    {
        $titleHeader = "Detail Penduduk";
        $penduduk = Penduduk::where('nik', $nik)->with('kk')->firstOrFail();

        return view('admin.penduduk.show', compact('penduduk', 'titleHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     * Using route model binding with NIK
     */
    public function edit(string $nik): View
    {
        $titleHeader = "Edit Data Penduduk";
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
        // Ambil data KK dengan nama kepala keluarga, diurutkan berdasarkan nama kepala keluarga
        $kkList = KK::select('no_kk', 'nama_kepala_keluarga', 'alamat', 'desa')
            ->orderBy('nama_kepala_keluarga', 'asc')
            ->get();

        return view('admin.penduduk.edit', compact('penduduk', 'kkList', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     * Using route model binding with NIK
     */
    public function update(Request $request, string $nik): RedirectResponse
    {
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();

        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', Rule::unique('penduduks')->ignore($penduduk->nik, 'nik')],
            'no_kk' => ['required', 'string', 'exists:k_k_s,no_kk'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'agama' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'string', 'max:100'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
            'status_keluarga' => ['required', 'string', 'max:50'],
            'golongan_darah' => ['nullable', 'string', 'max:3'],
            'kewarganegaraan' => ['required', 'string', 'max:50'],
            'nama_ayah' => ['required', 'string', 'max:255'],
            'nama_ibu' => ['required', 'string', 'max:255'],
        ]);

        $penduduk->update($validated);

        return redirect()
            ->route('admin.penduduk.show', $validated['nik']) // Redirect to new NIK if changed
            ->with('success', 'Data penduduk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Using route model binding with NIK
     */
    public function destroy(string $nik): RedirectResponse
    {
        try {
            $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
            $penduduk->delete();

            return redirect()
                ->route('admin.penduduk.index')
                ->with('success', 'Data penduduk berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.penduduk.index')
                ->with('error', 'Gagal menghapus data penduduk!');
        }
    }

    /**
     * Export data penduduk to Excel/CSV
     */
    public function export(Request $request)
    {
        // TODO: Implement export functionality
        // Bisa menggunakan Laravel Excel atau export manual
        return redirect()
            ->route('admin.penduduk.index')
            ->with('info', 'Fitur export akan segera tersedia!');
    }

    /**
     * Print data penduduk
     */
    public function print(Request $request): View
    {
        $query = Penduduk::with('kk');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_kk', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'all') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('agama') && $request->agama !== 'all') {
            $query->where('agama', $request->agama);
        }

        if ($request->filled('status_keluarga') && $request->status_keluarga !== 'all') {
            $query->where('status_keluarga', $request->status_keluarga);
        }

        $penduduk = $query->orderBy('nama_lengkap')->get();

        return view('admin.penduduk.print', compact('penduduk'));
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'total_penduduk' => Penduduk::count(),
            'laki_laki' => Penduduk::lakiLaki()->count(),
            'perempuan' => Penduduk::perempuan()->count(),
            'kepala_keluarga' => Penduduk::kepalaKeluarga()->count(),
            'usia_produktif' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 64')->count(),
            'lansia' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 65')->count(),
            'anak_anak' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 15')->count(),
        ];

        // Statistik berdasarkan agama
        $agamaStats = Penduduk::selectRaw('agama, COUNT(*) as jumlah')
            ->groupBy('agama')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Statistik berdasarkan pendidikan
        $pendidikanStats = Penduduk::selectRaw('pendidikan, COUNT(*) as jumlah')
            ->groupBy('pendidikan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Statistik berdasarkan pekerjaan
        $pekerjaanStats = Penduduk::selectRaw('pekerjaan, COUNT(*) as jumlah')
            ->groupBy('pekerjaan')
            ->orderBy('jumlah', 'desc')
            ->limit(10)
            ->get();

        return [
            'basic_stats' => $stats,
            'agama_stats' => $agamaStats,
            'pendidikan_stats' => $pendidikanStats,
            'pekerjaan_stats' => $pekerjaanStats,
        ];
    }

    /**
     * Bulk actions (untuk multiple select)
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,export'],
            'selected_ids' => ['required', 'array', 'min:1'],
            'selected_ids.*' => ['exists:penduduks,nik']
        ]);

        switch ($request->action) {
            case 'delete':
                Penduduk::whereIn('nik', $request->selected_ids)->delete();
                return redirect()
                    ->route('admin.penduduk.index')
                    ->with('success', count($request->selected_ids) . ' data penduduk berhasil dihapus!');

            case 'export':
                // TODO: Implement bulk export
                return redirect()
                    ->route('admin.penduduk.index')
                    ->with('info', 'Fitur export akan segera tersedia!');

            default:
                return redirect()
                    ->route('admin.penduduk.index')
                    ->with('error', 'Aksi tidak valid!');
        }
    }

    /**
     * Duplicate penduduk data (for family members)
     */
    public function duplicate(string $nik): View
    {
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
        $kkList = KK::orderBy('no_kk')->get();

        // Create a copy for duplication
        $duplicatedData = $penduduk->toArray();
        unset($duplicatedData['nik']); // Remove NIK for new entry
        unset($duplicatedData['created_at']);
        unset($duplicatedData['updated_at']);

        return view('admin.penduduk.create', compact('kkList', 'duplicatedData'));
    }

    /**
     * Search penduduk with AJAX
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $penduduk = Penduduk::where('nama_lengkap', 'LIKE', "%{$query}%")
            ->orWhere('nik', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['nik', 'nama_lengkap', 'no_kk']);

        return response()->json($penduduk);
    }

    /**
     * Get penduduk by KK
     */
    public function getByKK(string $no_kk)
    {
        $penduduk = Penduduk::where('no_kk', $no_kk)
            ->orderBy('status_keluarga')
            ->get();

        return response()->json($penduduk);
    }

    /**
     * Validate NIK uniqueness (AJAX)
     */
    public function validateNIK(Request $request)
    {
        $nik = $request->get('nik');
        $currentNik = $request->get('current_nik'); // For edit validation

        $exists = Penduduk::where('nik', $nik);

        if ($currentNik) {
            $exists->where('nik', '!=', $currentNik);
        }

        $exists = $exists->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'NIK sudah terdaftar' : 'NIK tersedia'
        ]);
    }
}
