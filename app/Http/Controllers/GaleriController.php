<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // ===== ADMIN SECTION =====

    /**
     * Display a listing of the resource for admin.
     */
    public function index(Request $request)
    {
        $titleHeader = 'Galeri';

        $query = Galeri::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        // Filter by year
        if ($request->filled('tahun')) {
            $query->byYear($request->get('tahun'));
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('nama_kegiatan', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $galeris = $query->paginate(10)->withQueryString();

        return view('admin.galeri.index', compact('galeris', 'titleHeader'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titleHeader = 'Tambah Galeri';
        return view('admin.galeri.create', compact('titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $fotoPath = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'foto' => $fotoPath,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        $titleHeader = 'Detail Galeri';
        return view('admin.galeri.show', compact('galeri', 'titleHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        $titleHeader = 'Edit Galeri';
        return view('admin.galeri.edit', compact('galeri', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $data = [
            'nama_kegiatan' => $request->nama_kegiatan,
            'keterangan' => $request->keterangan
        ];

        // Jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama - PERBAIKAN DI SINI
            if ($galeri->foto && Storage::disk('public')->exists('galeri/' . $galeri->foto)) {
                Storage::disk('public')->delete('galeri/' . $galeri->foto);
            }

            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        try {
            // Hapus foto dari storage - PERBAIKAN DI SINI  
            if ($galeri->foto && Storage::disk('public')->exists('galeri/' . $galeri->foto)) {
                Storage::disk('public')->delete('galeri/' . $galeri->foto);
            }

            $galeri->delete();

            return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting galeri: ' . $e->getMessage());
            return redirect()->route('admin.galeri.index')->with('error', 'Gagal menghapus galeri!');
        }
    }

    // ===== PUBLIC SECTION =====

    /**
     * Tampilan galeri untuk public
     */
    public function publicIndex(Request $request)
    {
        $query = Galeri::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        // Filter by year
        if ($request->filled('tahun')) {
            $query->byYear($request->get('tahun'));
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('nama_kegiatan', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $galeris = $query->paginate(12)->withQueryString();

        return view('public.galeri.index', compact('galeris'));
    }

    /**
     * Detail galeri untuk public
     */
    public function publicShow($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeriLainnya = $galeri->getRelated(6);

        return view('public.galeri.show', compact('galeri', 'galeriLainnya'));
    }

    /**
     * Search API untuk live search
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $galeris = Galeri::search($query)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($galeri) {
                return [
                    'id' => $galeri->id,
                    'nama_kegiatan' => $galeri->nama_kegiatan,
                    'foto_url' => $galeri->foto_url,
                    'url' => route('public.galeri.show', $galeri->id),
                    'created_at' => $galeri->formatted_date
                ];
            });

        return response()->json($galeris);
    }

    /**
     * Get galeri statistics untuk dashboard
     */
    public function getStatistics()
    {
        $statistics = Galeri::getStatistics();

        // Group by month for chart
        $monthlyStats = Galeri::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->count];
            });

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyStats->get($i, 0);
        }

        return response()->json([
            'total_foto' => $statistics['total'],
            'foto_this_month' => $statistics['this_month'],
            'foto_this_year' => $statistics['this_year'],
            'recent_foto' => $statistics['latest'],
            'chart_data' => $chartData,
            'archives' => Galeri::getArchives()
        ]);
    }

    /**
     * Bulk delete untuk admin
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:galeris,id'
        ]);

        $galeris = Galeri::whereIn('id', $request->ids)->get();

        foreach ($galeris as $galeri) {
            // Model akan otomatis hapus foto karena boot method
            $galeri->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' foto berhasil dihapus'
        ]);
    }

    /**
     * Export galeri data
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'json');

        $query = Galeri::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        if ($request->filled('tahun')) {
            $query->byYear($request->get('tahun'));
        }

        $galeris = $query->latest()->get();

        switch ($format) {
            case 'csv':
                return $this->exportCsv($galeris);
            case 'json':
            default:
                return response()->json($galeris->map(function ($galeri) {
                    return $galeri->toApiArray();
                }));
        }
    }

    /**
     * Export to CSV
     */
    private function exportCsv($galeris)
    {
        $filename = 'galeri_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($galeris) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['ID', 'Nama Kegiatan', 'Keterangan', 'Foto', 'Ukuran File', 'Dimensi', 'Tanggal Upload']);

            // Data CSV
            foreach ($galeris as $galeri) {
                fputcsv($file, [
                    $galeri->id,
                    $galeri->nama_kegiatan,
                    $galeri->keterangan,
                    $galeri->foto,
                    $galeri->file_size ?? 'N/A',
                    $galeri->image_dimensions['formatted'] ?? 'N/A',
                    $galeri->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
