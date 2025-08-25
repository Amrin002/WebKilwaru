<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Berita::with('kategoriBeri');
        $titleHeader = "Kelola Berita";

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        // Filter by featured
        if ($request->filled('featured') && $request->featured !== 'all') {
            if ($request->featured === 'yes') {
                $query->featured();
            } else {
                $query->where('is_featured', false);
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $beritas = $query->paginate(15)->withQueryString();

        // Data untuk filter dropdown
        $kategoriList = KategoriBerita::active()->ordered()->get();
        $statusList = ['draft', 'published', 'archived'];

        // Statistics
        $statistics = [
            'total' => Berita::count(),
            'published' => Berita::where('status', 'published')->count(),
            'draft' => Berita::where('status', 'draft')->count(),
            'featured' => Berita::where('is_featured', true)->count(),
        ];

        return view('admin.berita.index', compact(
            'beritas',
            'kategoriList',
            'statusList',
            'statistics',
            'titleHeader'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $titleHeader = "Buat Berita Baru";
        $kategoriList = KategoriBerita::active()->ordered()->get();

        return view('admin.berita.create', compact('kategoriList', 'titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:beritas,slug'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'kategori' => ['required', 'string', 'exists:kategori_beritas,slug'],
            'penulis' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['boolean'],
            'tags' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('berita', $imageName, 'public');
            $validated['gambar'] = $imageName;
        }

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Set is_featured default value
        $validated['is_featured'] = $request->has('is_featured');

        $berita = Berita::create($validated);

        return redirect()
            ->route('admin.berita.show', $berita->slug)
            ->with('success', 'Berita berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $titleHeader = "Detail Berita";
        $berita = Berita::where('slug', $slug)->with('kategoriBeri')->firstOrFail();

        return view('admin.berita.show', compact('berita', 'titleHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug): View
    {
        $titleHeader = "Edit Berita";
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $kategoriList = KategoriBerita::active()->ordered()->get();

        return view('admin.berita.edit', compact('berita', 'kategoriList', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug): RedirectResponse
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('beritas')->ignore($berita->id)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'kategori' => ['required', 'string', 'exists:kategori_beritas,slug'],
            'penulis' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['boolean'],
            'tags' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                Storage::disk('public')->delete('berita/' . $berita->gambar);
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('berita', $imageName, 'public');
            $validated['gambar'] = $imageName;
        }

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Convert tags string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published' && empty($validated['published_at']) && $berita->status !== 'published') {
            $validated['published_at'] = now();
        }

        // Set is_featured value
        $validated['is_featured'] = $request->has('is_featured');

        $berita->update($validated);

        return redirect()
            ->route('admin.berita.show', $validated['slug'])
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug): RedirectResponse
    {
        try {
            $berita = Berita::where('slug', $slug)->firstOrFail();

            // Delete image if exists
            if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                Storage::disk('public')->delete('berita/' . $berita->gambar);
            }

            $berita->delete();

            return redirect()
                ->route('admin.berita.index')
                ->with('success', 'Berita berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.berita.index')
                ->with('error', 'Gagal menghapus berita!');
        }
    }

    /**
     * Bulk actions for multiple berita
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,publish,unpublish,archive,feature,unfeature'],
            'selected_items' => ['required', 'array', 'min:1'],
            'selected_items.*' => ['exists:beritas,id'],
        ]);

        $action = $request->action;
        $selectedIds = $request->selected_items;

        switch ($action) {
            case 'delete':
                $beritas = Berita::whereIn('id', $selectedIds)->get();
                foreach ($beritas as $berita) {
                    // Delete images
                    if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                        Storage::disk('public')->delete('berita/' . $berita->gambar);
                    }
                }
                Berita::whereIn('id', $selectedIds)->delete();
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil dihapus!');

            case 'publish':
                Berita::whereIn('id', $selectedIds)->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil dipublish!');

            case 'unpublish':
                Berita::whereIn('id', $selectedIds)->update(['status' => 'draft']);
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil di-unpublish!');

            case 'archive':
                Berita::whereIn('id', $selectedIds)->update(['status' => 'archived']);
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil diarsipkan!');

            case 'feature':
                Berita::whereIn('id', $selectedIds)->update(['is_featured' => true]);
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil dijadikan featured!');

            case 'unfeature':
                Berita::whereIn('id', $selectedIds)->update(['is_featured' => false]);
                return redirect()
                    ->route('admin.berita.index')
                    ->with('success', count($selectedIds) . ' berita berhasil di-unfeature!');

            default:
                return redirect()
                    ->route('admin.berita.index')
                    ->with('error', 'Aksi tidak valid!');
        }
    }

    /**
     * Duplicate berita
     */
    public function duplicate(string $slug): View
    {
        $titleHeader = "Duplikasi Berita";
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $kategoriList = KategoriBerita::active()->ordered()->get();

        // Create a copy for duplication
        $duplicatedData = $berita->toArray();
        $duplicatedData['judul'] = $duplicatedData['judul'] . ' (Copy)';
        $duplicatedData['slug'] = '';
        $duplicatedData['status'] = 'draft';
        $duplicatedData['is_featured'] = false;
        $duplicatedData['views'] = 0;
        $duplicatedData['published_at'] = null;

        // Convert tags array back to string
        if (is_array($duplicatedData['tags'])) {
            $duplicatedData['tags'] = implode(', ', $duplicatedData['tags']);
        }

        unset($duplicatedData['id']);
        unset($duplicatedData['created_at']);
        unset($duplicatedData['updated_at']);

        return view('admin.berita.create', compact('kategoriList', 'duplicatedData', 'titleHeader'));
    }

    /**
     * Search berita with AJAX
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $beritas = Berita::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('excerpt', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'judul', 'slug', 'status']);

        return response()->json($beritas);
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'total_berita' => Berita::count(),
            'published' => Berita::where('status', 'published')->count(),
            'draft' => Berita::where('status', 'draft')->count(),
            'archived' => Berita::where('status', 'archived')->count(),
            'featured' => Berita::where('is_featured', true)->count(),
            'total_views' => Berita::sum('views'),
        ];

        // Statistik berdasarkan kategori
        $kategoriStats = Berita::selectRaw('kategori, COUNT(*) as jumlah')
            ->groupBy('kategori')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Berita populer (berdasarkan views)
        $popularBerita = Berita::published()
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get(['judul', 'slug', 'views']);

        // Berita terbaru
        $latestBerita = Berita::published()
            ->latest()
            ->limit(5)
            ->get(['judul', 'slug', 'published_at']);

        return response()->json([
            'stats' => $stats,
            'kategori_stats' => $kategoriStats,
            'popular_berita' => $popularBerita,
            'latest_berita' => $latestBerita,
        ]);
    }

    /**
     * Export berita data
     */
    public function export(Request $request)
    {
        // TODO: Implement export functionality
        return redirect()
            ->route('admin.berita.index')
            ->with('info', 'Fitur export akan segera tersedia!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(string $slug): RedirectResponse
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $berita->update(['is_featured' => !$berita->is_featured]);

        $status = $berita->is_featured ? 'featured' : 'unfeatured';

        return redirect()
            ->back()
            ->with('success', "Berita berhasil di-{$status}!");
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(string $slug): RedirectResponse
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        if ($berita->status === 'published') {
            $berita->update(['status' => 'draft']);
            $message = 'Berita berhasil di-unpublish!';
        } else {
            $berita->update([
                'status' => 'published',
                'published_at' => $berita->published_at ?? now()
            ]);
            $message = 'Berita berhasil dipublish!';
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
