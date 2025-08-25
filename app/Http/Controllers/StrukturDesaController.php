<?php

namespace App\Http\Controllers;

use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StrukturDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = StrukturDesa::query();
        $titleHeader = "Kelola Struktur Desa";

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        // Filter by status aktif
        if ($request->filled('aktif')) {
            if ($request->aktif === '1') {
                $query->aktif();
            } elseif ($request->aktif === '0') {
                $query->where('aktif', false);
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'urutan');
        $sortOrder = $request->get('sort_order', 'asc');

        if ($sortBy === 'urutan') {
            $query->ordered();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $strukturDesa = $query->paginate(15)->withQueryString();

        // Data untuk filter dropdown
        $kategoriList = StrukturDesa::getKategoriList();

        // Statistics
        $statistics = $this->getStatistics();

        return view('admin.struktur-desa.index', compact(
            'strukturDesa',
            'kategoriList',
            'statistics',
            'titleHeader'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $titleHeader = "Tambah Pejabat Desa";
        $kategoriList = StrukturDesa::getKategoriList();

        return view('admin.struktur-desa.create', compact('kategoriList', 'titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // DD 1: Cek apakah ada file yang di-upload
        // dd([
        //     'has_file' => $request->hasFile('image'),
        //     'all_request' => $request->all(),
        //     'files' => $request->file(),
        //     'image_file' => $request->file('image')
        // ]);
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'posisi' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nik' => ['nullable', 'string', 'size:16', 'unique:struktur_desas,nik'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:struktur_desas,nip'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:struktur_desas,email'],
            'alamat' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:' . implode(',', array_keys(StrukturDesa::getKategoriList()))],
            'urutan' => ['required', 'integer', 'min:0'],
            'aktif' => ['boolean'],
            'mulai_menjabat' => ['nullable', 'date'],
            'selesai_menjabat' => ['nullable', 'date', 'after:mulai_menjabat'],
            'deskripsi' => ['nullable', 'string'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
        ]);

        // Handle image upload - FIXED METHOD
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('struktur-desa', $imageName, 'public');
            // DD 3: Cek hasil upload
            // dd([
            //     'generated_filename' => $imageName,
            //     'store_path' => $path,
            //     'file_exists' => file_exists(storage_path('app/public/' . $path)),
            //     'full_path' => storage_path('app/public/' . $path)
            // ]);

            $validated['image'] = $imageName;
        }

        // Set aktif default value
        $validated['aktif'] = $request->has('aktif');

        StrukturDesa::create($validated);

        return redirect()
            ->route('admin.struktur-desa.index')
            ->with('success', 'Data pejabat desa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StrukturDesa $struktur_desa): View
    {
        $titleHeader = "Detail Pejabat Desa";

        return view('admin.struktur-desa.show', compact('struktur_desa', 'titleHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturDesa $struktur_desa): View
    {
        $titleHeader = "Edit Pejabat Desa";
        $kategoriList = StrukturDesa::getKategoriList();

        return view('admin.struktur-desa.edit', compact('struktur_desa', 'kategoriList', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrukturDesa $struktur_desa): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'posisi' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nik' => ['nullable', 'string', 'size:16', Rule::unique('struktur_desas')->ignore($struktur_desa->id)],
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('struktur_desas')->ignore($struktur_desa->id)],
            'telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('struktur_desas')->ignore($struktur_desa->id)],
            'alamat' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:' . implode(',', array_keys(StrukturDesa::getKategoriList()))],
            'urutan' => ['required', 'integer', 'min:0'],
            'aktif' => ['boolean'],
            'mulai_menjabat' => ['nullable', 'date'],
            'selesai_menjabat' => ['nullable', 'date', 'after:mulai_menjabat'],
            'deskripsi' => ['nullable', 'string'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
        ]);

        // Handle image upload - FIXED METHOD
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($struktur_desa->image && Storage::disk('public')->exists('struktur-desa/' . $struktur_desa->image)) {
                Storage::disk('public')->delete('struktur-desa/' . $struktur_desa->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('struktur-desa', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        // Set aktif value
        $validated['aktif'] = $request->has('aktif');

        $struktur_desa->update($validated);

        return redirect()
            ->route('admin.struktur-desa.show', $struktur_desa)
            ->with('success', 'Data pejabat desa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrukturDesa $struktur_desa): RedirectResponse
    {
        try {
            // Delete image if exists - FIXED PATH
            if ($struktur_desa->image && Storage::disk('public')->exists('struktur-desa/' . $struktur_desa->image)) {
                Storage::disk('public')->delete('struktur-desa/' . $struktur_desa->image);
            }

            $struktur_desa->delete();

            return redirect()
                ->route('admin.struktur-desa.index')
                ->with('success', 'Data pejabat desa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.struktur-desa.index')
                ->with('error', 'Gagal menghapus data pejabat desa!');
        }
    }

    /**
     * Toggle status aktif pejabat
     */
    public function toggleStatus(StrukturDesa $struktur_desa): RedirectResponse
    {
        $struktur_desa->update([
            'aktif' => !$struktur_desa->aktif
        ]);

        $status = $struktur_desa->aktif ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Status pejabat berhasil {$status}!");
    }

    /**
     * Bulk actions (untuk multiple select)
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete'],
            'selected_ids' => ['required', 'array', 'min:1'],
            'selected_ids.*' => ['exists:struktur_desas,id']
        ]);

        switch ($request->action) {
            case 'activate':
                StrukturDesa::whereIn('id', $request->selected_ids)->update(['aktif' => true]);
                $message = count($request->selected_ids) . ' pejabat berhasil diaktifkan!';
                break;

            case 'deactivate':
                StrukturDesa::whereIn('id', $request->selected_ids)->update(['aktif' => false]);
                $message = count($request->selected_ids) . ' pejabat berhasil dinonaktifkan!';
                break;

            case 'delete':
                $strukturDesas = StrukturDesa::whereIn('id', $request->selected_ids)->get();

                // Delete images - FIXED PATH
                foreach ($strukturDesas as $struktur) {
                    if ($struktur->image && Storage::disk('public')->exists('struktur-desa/' . $struktur->image)) {
                        Storage::disk('public')->delete('struktur-desa/' . $struktur->image);
                    }
                }

                StrukturDesa::whereIn('id', $request->selected_ids)->delete();
                $message = count($request->selected_ids) . ' pejabat berhasil dihapus!';
                break;

            default:
                return redirect()
                    ->route('admin.struktur-desa.index')
                    ->with('error', 'Aksi tidak valid!');
        }

        return redirect()
            ->route('admin.struktur-desa.index')
            ->with('success', $message);
    }

    /**
     * Export data to CSV
     */
    public function export(Request $request)
    {
        $query = StrukturDesa::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        if ($request->filled('aktif')) {
            if ($request->aktif === '1') {
                $query->aktif();
            } elseif ($request->aktif === '0') {
                $query->where('aktif', false);
            }
        }

        $strukturDesa = $query->ordered()->get();

        $filename = 'struktur_desa_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($strukturDesa) {
            $file = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'ID',
                'Nama',
                'Posisi',
                'Kategori',
                'NIK',
                'NIP',
                'Telepon',
                'Email',
                'Alamat',
                'Status',
                'Urutan',
                'Mulai Menjabat',
                'Selesai Menjabat',
                'Masa Jabatan',
                'Pendidikan Terakhir',
                'Deskripsi',
                'Twitter',
                'Facebook',
                'Instagram',
                'Dibuat',
                'Diperbarui'
            ]);

            // Data rows
            foreach ($strukturDesa as $struktur) {
                fputcsv($file, [
                    $struktur->id,
                    $struktur->nama,
                    $struktur->posisi,
                    $struktur->kategori_display,
                    $struktur->nik,
                    $struktur->nip,
                    $struktur->telepon,
                    $struktur->email,
                    $struktur->alamat,
                    $struktur->status_jabatan,
                    $struktur->urutan,
                    $struktur->mulai_menjabat?->format('d/m/Y'),
                    $struktur->selesai_menjabat?->format('d/m/Y'),
                    $struktur->masa_jabatan,
                    $struktur->pendidikan_terakhir,
                    $struktur->deskripsi,
                    $struktur->twitter,
                    $struktur->facebook,
                    $struktur->instagram,
                    $struktur->created_at->format('d/m/Y H:i'),
                    $struktur->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print data structure desa
     */
    public function print(Request $request): View
    {
        $query = StrukturDesa::aktif()->ordered();

        // Apply filters if any
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        $strukturDesa = $query->get();

        return view('admin.struktur-desa.print', compact('strukturDesa'));
    }

    /**
     * Get public structure for website display
     */
    public function publicStructure(): View
    {
        $strukturDesa = StrukturDesa::aktif()
            ->ordered()
            ->get()
            ->groupBy('kategori');

        return view('public.struktur-desa', compact('strukturDesa'));
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics(): array
    {
        return [
            'total_pejabat' => StrukturDesa::count(),
            'aktif' => StrukturDesa::aktif()->count(),
            'tidak_aktif' => StrukturDesa::where('aktif', false)->count(),
            'kepala_desa' => StrukturDesa::byKategori('kepala_desa')->aktif()->count(),
            'sekretaris' => StrukturDesa::byKategori('sekretaris')->aktif()->count(),
            'kaur' => StrukturDesa::where('kategori', 'LIKE', 'kaur_%')->aktif()->count(),
            'kasi' => StrukturDesa::where('kategori', 'LIKE', 'kasi_%')->aktif()->count(),
            'kadus' => StrukturDesa::byKategori('kadus')->aktif()->count(),
            'masa_jabatan_rata_rata' => $this->getAverageTenure(),
        ];
    }

    /**
     * Calculate average tenure
     */
    private function getAverageTenure(): string
    {
        $pejabatAktif = StrukturDesa::aktif()
            ->whereNotNull('mulai_menjabat')
            ->get();

        if ($pejabatAktif->isEmpty()) {
            return '0 tahun';
        }

        $totalDays = 0;
        $count = 0;

        foreach ($pejabatAktif as $pejabat) {
            if ($pejabat->mulai_menjabat) {
                $mulai = \Carbon\Carbon::parse($pejabat->mulai_menjabat);
                $selesai = $pejabat->selesai_menjabat ?
                    \Carbon\Carbon::parse($pejabat->selesai_menjabat) :
                    \Carbon\Carbon::now();

                $totalDays += $mulai->diffInDays($selesai);
                $count++;
            }
        }

        if ($count === 0) {
            return '0 tahun';
        }

        $averageDays = $totalDays / $count;
        $years = floor($averageDays / 365);
        $months = floor(($averageDays % 365) / 30);

        $result = [];
        if ($years > 0) $result[] = $years . ' tahun';
        if ($months > 0) $result[] = $months . ' bulan';

        return empty($result) ? 'Kurang dari 1 bulan' : implode(' ', $result);
    }
}
