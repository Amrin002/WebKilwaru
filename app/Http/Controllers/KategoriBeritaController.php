<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = KategoriBerita::withCount('beritas');
        $titleHeader = "Kelola Kategori Berita";

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'urutan');
        $sortOrder = $request->get('sort_order', 'asc');

        if ($sortBy === 'urutan') {
            $query->ordered();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $kategoriList = $query->paginate(15)->withQueryString();

        // Statistics
        $statistics = [
            'total' => KategoriBerita::count(),
            'active' => KategoriBerita::where('is_active', true)->count(),
            'inactive' => KategoriBerita::where('is_active', false)->count(),
            'with_berita' => KategoriBerita::has('beritas')->count(),
        ];

        return view('admin.kategori-berita.index', compact(
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
        $titleHeader = "Buat Kategori Berita";

        // Get next urutan number
        $nextUrutan = KategoriBerita::max('urutan') + 1;

        return view('admin.kategori-berita.create', compact('titleHeader', 'nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_beritas,nama'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:kategori_beritas,slug'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'warna' => ['required', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'urutan' => ['required', 'integer', 'min:0'],
        ]);

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        // Set is_active default value
        $validated['is_active'] = $request->has('is_active');

        $kategori = KategoriBerita::create($validated);

        return redirect()
            ->route('admin.kategori-berita.show', $kategori->slug)
            ->with('success', 'Kategori berita berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $titleHeader = "Detail Kategori Berita";
        $kategori = KategoriBerita::where('slug', $slug)
            ->withCount('beritas')
            ->firstOrFail();

        // Get latest berita from this category
        $latestBerita = $kategori->beritas()
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.kategori-berita.show', compact(
            'kategori',
            'latestBerita',
            'titleHeader'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug): View
    {
        $titleHeader = "Edit Kategori Berita";
        $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();

        return view('admin.kategori-berita.edit', compact('kategori', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug): RedirectResponse
    {
        $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('kategori_beritas')->ignore($kategori->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('kategori_beritas')->ignore($kategori->id)],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'warna' => ['required', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'urutan' => ['required', 'integer', 'min:0'],
        ]);

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        // Set is_active value
        $validated['is_active'] = $request->has('is_active');

        $kategori->update($validated);

        return redirect()
            ->route('admin.kategori-berita.show', $validated['slug'])
            ->with('success', 'Kategori berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug): RedirectResponse
    {
        try {
            $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();

            // Check if category has berita
            if ($kategori->beritas()->count() > 0) {
                return redirect()
                    ->route('admin.kategori-berita.index')
                    ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki berita!');
            }

            $kategori->delete();

            return redirect()
                ->route('admin.kategori-berita.index')
                ->with('success', 'Kategori berita berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.kategori-berita.index')
                ->with('error', 'Gagal menghapus kategori berita!');
        }
    }

    /**
     * Bulk actions for multiple kategori
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,activate,deactivate'],
            'selected_items' => ['required', 'array', 'min:1'],
            'selected_items.*' => ['exists:kategori_beritas,id'],
        ]);

        $action = $request->action;
        $selectedIds = $request->selected_items;

        switch ($action) {
            case 'delete':
                // Check if any selected categories have berita
                $categoriesWithBerita = KategoriBerita::whereIn('id', $selectedIds)
                    ->has('beritas')
                    ->count();

                if ($categoriesWithBerita > 0) {
                    return redirect()
                        ->route('admin.kategori-berita.index')
                        ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki berita!');
                }

                KategoriBerita::whereIn('id', $selectedIds)->delete();
                return redirect()
                    ->route('admin.kategori-berita.index')
                    ->with('success', count($selectedIds) . ' kategori berhasil dihapus!');

            case 'activate':
                KategoriBerita::whereIn('id', $selectedIds)->update(['is_active' => true]);
                return redirect()
                    ->route('admin.kategori-berita.index')
                    ->with('success', count($selectedIds) . ' kategori berhasil diaktifkan!');

            case 'deactivate':
                KategoriBerita::whereIn('id', $selectedIds)->update(['is_active' => false]);
                return redirect()
                    ->route('admin.kategori-berita.index')
                    ->with('success', count($selectedIds) . ' kategori berhasil dinonaktifkan!');

            default:
                return redirect()
                    ->route('admin.kategori-berita.index')
                    ->with('error', 'Aksi tidak valid!');
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive(string $slug): RedirectResponse
    {
        $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();
        $kategori->update(['is_active' => !$kategori->is_active]);

        $status = $kategori->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Kategori berhasil {$status}!");
    }

    /**
     * Update urutan (reorder categories)
     */
    public function updateUrutan(Request $request): RedirectResponse
    {
        $request->validate([
            'orders' => ['required', 'array'],
            'orders.*' => ['integer', 'exists:kategori_beritas,id'],
        ]);

        foreach ($request->orders as $urutan => $id) {
            KategoriBerita::where('id', $id)->update(['urutan' => $urutan + 1]);
        }

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('success', 'Urutan kategori berhasil diperbarui!');
    }

    /**
     * Get kategori list for API/AJAX
     */
    public function getKategoriList(Request $request)
    {
        $query = KategoriBerita::active()->ordered();

        if ($request->filled('search')) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }

        $kategoriList = $query->get(['id', 'nama', 'slug', 'warna', 'icon']);

        return response()->json($kategoriList);
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'total_kategori' => KategoriBerita::count(),
            'active' => KategoriBerita::where('is_active', true)->count(),
            'inactive' => KategoriBerita::where('is_active', false)->count(),
            'with_berita' => KategoriBerita::has('beritas')->count(),
        ];

        // Kategori dengan berita terbanyak
        $kategoriPopular = KategoriBerita::withCount('beritas')
            ->orderBy('beritas_count', 'desc')
            ->limit(5)
            ->get(['nama', 'slug', 'beritas_count']);

        return response()->json([
            'stats' => $stats,
            'popular_kategori' => $kategoriPopular,
        ]);
    }
    
}
