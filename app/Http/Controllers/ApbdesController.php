<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApbdesController extends Controller
{
    /**
     * Display APBDes for public (transparansi)
     */
    public function index(): View
    {
        // Mendapatkan tahun saat ini
        $currentYear = date('Y');

        // 1. Coba ambil APBDes untuk tahun ini
        $currentApbdes = Apbdes::byTahun($currentYear)->first();

        // 2. Jika APBDes tahun ini tidak ada, ambil yang terbaru
        if (!$currentApbdes) {
            $currentApbdes = Apbdes::latest()->first();
        }

        // Get semua tahun tersedia untuk dropdown
        $availableYears = Apbdes::getAllYears();

        // Get data kepala desa yang aktif untuk ditampilkan
        $kepalaDesa = StrukturDesa::byKategori('kepala_desa')
            ->aktif()
            ->ordered()
            ->first();

        return view('public.apbdes.index', compact(
            'currentApbdes',
            'availableYears',
            'kepalaDesa'
        ));
    }

    /**
     * Show APBDes by year
     */
    public function show(int $tahun): View
    {
        $apbdes = Apbdes::byTahun($tahun)->firstOrFail();
        $availableYears = Apbdes::getAllYears();

        // Get kepala desa aktif
        $kepalaDesa = StrukturDesa::byKategori('kepala_desa')
            ->aktif()
            ->ordered()
            ->first();

        return view('public.apbdes.show', compact(
            'apbdes',
            'availableYears',
            'kepalaDesa'
        ));
    }

    /**
     * API endpoint untuk get APBDes by year (AJAX)
     */
    public function getByYear(int $tahun)
    {
        $apbdes = Apbdes::byTahun($tahun)->first();

        if (!$apbdes) {
            return response()->json([
                'success' => false,
                'message' => "APBDes tahun {$tahun} tidak ditemukan"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tahun' => $apbdes->tahun,
                'total_anggaran' => $apbdes->total_anggaran,
                'total_anggaran_formatted' => $apbdes->total_anggaran_formatted,
                'breakdown' => $apbdes->breakdown,
                'breakdown_percentage' => $apbdes->breakdown_percentage,
                'has_pdf' => $apbdes->pdf_url !== null,
                'has_baliho' => $apbdes->baliho_url !== null,
                'pdf_url' => $apbdes->pdf_url,
                'baliho_url' => $apbdes->baliho_url
            ]
        ]);
    }

    // ============ ADMIN METHODS ============

    /**
     * Admin index - List all APBDes
     */
    public function adminIndex(): View
    {
        $titleHeader = "Kelola APBDes";

        $apbdesList = Apbdes::latest()
            ->paginate(10);

        // Statistics
        $statistics = [
            'total_apbdes' => Apbdes::count(),
            'tahun_terbaru' => Apbdes::getLatestYear(),
            'total_anggaran_terbaru' => Apbdes::latest()->first()?->total_anggaran ?? 0,
            'dengan_pdf' => Apbdes::hasPdf()->count(),
            'dengan_baliho' => Apbdes::hasBaliho()->count(),
        ];

        return view('admin.apbdes.index', compact(
            'apbdesList',
            'statistics',
            'titleHeader'
        ));
    }

    /**
     * Show form create APBDes
     */
    public function create(): View
    {
        $titleHeader = "Tambah APBDes";

        // Check if tahun ini sudah ada
        $currentYear = date('Y');
        $hasCurrentYear = Apbdes::hasYear($currentYear);

        return view('admin.apbdes.create', compact(
            'titleHeader',
            'currentYear',
            'hasCurrentYear'
        ));
    }

    /**
     * Store new APBDes
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => ['required', 'integer', 'min:2020', 'max:2050', 'unique:apbdes,tahun'],
            'pemerintahan_desa' => ['required', 'numeric', 'min:0'],
            'pembangunan_desa' => ['required', 'numeric', 'min:0'],
            'kemasyarakatan' => ['required', 'numeric', 'min:0'],
            'pemberdayaan' => ['required', 'numeric', 'min:0'],
            'bencana_darurat' => ['required', 'numeric', 'min:0'],
            'pdf_dokumen' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB
            'baliho_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:3072'], // 3MB
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_dokumen')) {
            $pdf = $request->file('pdf_dokumen');
            $pdfName = 'apbdes_' . $validated['tahun'] . '_' . time() . '.pdf';
            $pdf->storeAs('apbdes/pdf', $pdfName, 'public');
            $validated['pdf_dokumen'] = 'apbdes/pdf/' . $pdfName;
        }

        // Handle Baliho upload
        if ($request->hasFile('baliho_image')) {
            $image = $request->file('baliho_image');
            $imageName = 'baliho_' . $validated['tahun'] . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('apbdes/baliho', $imageName, 'public');
            $validated['baliho_image'] = 'apbdes/baliho/' . $imageName;
        }

        Apbdes::create($validated);

        return redirect()
            ->route('admin.apbdes.index')
            ->with('success', "APBDes tahun {$validated['tahun']} berhasil ditambahkan!");
    }

    /**
     * Show detail APBDes (admin)
     */
    public function adminShow(Apbdes $apbdes): View
    {
        $titleHeader = "Detail APBDes {$apbdes->tahun}";

        return view('admin.apbdes.show', compact(
            'apbdes',
            'titleHeader'
        ));
    }

    /**
     * Show form edit APBDes
     */
    public function edit(Apbdes $apbdes): View
    {
        $titleHeader = "Edit APBDes {$apbdes->tahun}";

        return view('admin.apbdes.edit', compact(
            'apbdes',
            'titleHeader'
        ));
    }

    /**
     * Update APBDes
     */
    public function update(Request $request, Apbdes $apbdes): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => ['required', 'integer', 'min:2020', 'max:2050'],
            'pemerintahan_desa' => ['required', 'numeric', 'min:0'],
            'pembangunan_desa' => ['required', 'numeric', 'min:0'],
            'kemasyarakatan' => ['required', 'numeric', 'min:0'],
            'pemberdayaan' => ['required', 'numeric', 'min:0'],
            'bencana_darurat' => ['required', 'numeric', 'min:0'],
            'pdf_dokumen' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'baliho_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_dokumen')) {
            // Delete old PDF
            if ($apbdes->pdf_dokumen && Storage::disk('public')->exists($apbdes->pdf_dokumen)) {
                Storage::disk('public')->delete($apbdes->pdf_dokumen);
            }

            $pdf = $request->file('pdf_dokumen');
            $pdfName = 'apbdes_' . $validated['tahun'] . '_' . time() . '.pdf';
            $pdf->storeAs('apbdes/pdf', $pdfName, 'public');
            $validated['pdf_dokumen'] = 'apbdes/pdf/' . $pdfName;
        }

        // Handle Baliho upload
        if ($request->hasFile('baliho_image')) {
            // Delete old image
            if ($apbdes->baliho_image && Storage::disk('public')->exists($apbdes->baliho_image)) {
                Storage::disk('public')->delete($apbdes->baliho_image);
            }

            $image = $request->file('baliho_image');
            $imageName = 'baliho_' . $validated['tahun'] . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('apbdes/baliho', $imageName, 'public');
            $validated['baliho_image'] = 'apbdes/baliho/' . $imageName;
        }

        $apbdes->update($validated);

        return redirect()
            ->route('admin.apbdes.show', $apbdes)
            ->with('success', "APBDes tahun {$apbdes->tahun} berhasil diperbarui!");
    }

    /**
     * Delete APBDes
     */
    public function destroy(Apbdes $apbdes): RedirectResponse
    {
        try {
            // Delete files
            if ($apbdes->pdf_dokumen && Storage::disk('public')->exists($apbdes->pdf_dokumen)) {
                Storage::disk('public')->delete($apbdes->pdf_dokumen);
            }

            if ($apbdes->baliho_image && Storage::disk('public')->exists($apbdes->baliho_image)) {
                Storage::disk('public')->delete($apbdes->baliho_image);
            }

            $tahun = $apbdes->tahun;
            $apbdes->delete();

            return redirect()
                ->route('admin.apbdes.index')
                ->with('success', "APBDes tahun {$tahun} berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.apbdes.index')
                ->with('error', 'Gagal menghapus APBDes!');
        }
    }

    /**
     * Download PDF dokumen APBDes
     */
    public function downloadPdf(Apbdes $apbdes)
    {
        // Periksa apakah file PDF benar-benar ada
        if (!$apbdes->pdf_dokumen || !Storage::disk('public')->exists($apbdes->pdf_dokumen)) {
            abort(404, 'File PDF tidak ditemukan');
        }

        // Tentukan nama file yang ramah pengguna untuk diunduh
        $filename = "APBDes_{$apbdes->tahun}_" . config('app.village_name', 'Desa') . ".pdf";

        // Unduh file
        return Storage::disk('public')->download($apbdes->pdf_dokumen, $filename);
    }
}
