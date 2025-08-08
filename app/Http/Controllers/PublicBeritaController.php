<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class PublicBeritaController extends Controller
{
    /**
     * Display a listing of published berita for public
     */
    public function index(Request $request): View
    {
        $query = Berita::published()->with('kategoriBeri');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->byKategori($request->kategori);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $beritas = $query->paginate(12)->withQueryString();

        // Get featured berita for hero section
        $featuredBerita = Berita::published()
            ->featured()
            ->latest()
            ->limit(3)
            ->get();

        // Get categories for filter
        $kategoriList = KategoriBerita::active()
            ->withCount(['publishedBeritas'])
            ->ordered()
            ->get();

        // Popular berita sidebar
        $popularBerita = Berita::published()
            ->popular()
            ->limit(5)
            ->get();

        // Latest berita sidebar
        $latestBerita = Berita::published()
            ->latest()
            ->limit(5)
            ->get();

        return view('public.berita.index', compact(
            'beritas',
            'featuredBerita',
            'kategoriList',
            'popularBerita',
            'latestBerita'
        ));
    }

    /**
     * Display the specified berita
     */
    public function show(string $slug): View
    {
        $berita = Berita::published()
            ->where('slug', $slug)
            ->with('kategoriBeri')
            ->firstOrFail();

        // Increment views
        $berita->incrementViews();

        // Get related berita
        $relatedBerita = $berita->getRelatedNews(4);

        // Popular berita sidebar
        $popularBerita = Berita::published()
            ->where('id', '!=', $berita->id)
            ->popular()
            ->limit(5)
            ->get();

        // Latest berita sidebar
        $latestBerita = Berita::published()
            ->where('id', '!=', $berita->id)
            ->latest()
            ->limit(5)
            ->get();

        // Previous and next berita
        $previousBerita = Berita::published()
            ->where('published_at', '<', $berita->published_at)
            ->latest()
            ->first();

        $nextBerita = Berita::published()
            ->where('published_at', '>', $berita->published_at)
            ->oldest()
            ->first();

        return view('public.berita.show', compact(
            'berita',
            'relatedBerita',
            'popularBerita',
            'latestBerita',
            'previousBerita',
            'nextBerita'
        ));
    }

    /**
     * Display berita by kategori
     */
    public function kategori(string $slug): View
    {
        $kategori = KategoriBerita::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $query = $kategori->publishedBeritas()
            ->with('kategoriBeri');

        // Search functionality
        if (request()->filled('search')) {
            $query->search(request()->search);
        }

        // Sorting
        $sortBy = request()->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $beritas = $query->paginate(12)->withQueryString();

        // Get featured berita from this category
        $featuredBerita = $kategori->publishedBeritas()
            ->where('is_featured', true)
            ->latest()
            ->limit(3)
            ->get();

        // Popular berita from this category
        $popularBerita = $kategori->publishedBeritas()
            ->popular()
            ->limit(5)
            ->get();

        // Latest berita from this category
        $latestBerita = $kategori->publishedBeritas()
            ->latest()
            ->limit(5)
            ->get();

        // Other categories
        $otherKategori = KategoriBerita::active()
            ->where('id', '!=', $kategori->id)
            ->withCount(['publishedBeritas'])
            ->ordered()
            ->get();

        return view('public.berita.kategori', compact(
            'kategori',
            'beritas',
            'featuredBerita',
            'popularBerita',
            'latestBerita',
            'otherKategori'
        ));
    }

    /**
     * Search berita (AJAX endpoint)
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $beritas = Berita::published()
            ->search($query)
            ->limit(10)
            ->get(['id', 'judul', 'slug', 'excerpt', 'gambar', 'published_at']);

        return response()->json($beritas->map(function ($berita) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'excerpt' => $berita->excerpt_formatted,
                'gambar_url' => $berita->gambar_url,
                'published_at' => $berita->published_at_relative,
                'url' => $berita->url,
            ];
        }));
    }

    /**
     * Get popular berita (AJAX endpoint)
     */
    public function popular(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $kategori = $request->get('kategori');

        $query = Berita::published()->popular();

        if ($kategori && $kategori !== 'all') {
            $query->byKategori($kategori);
        }

        $beritas = $query->limit($limit)->get();

        return response()->json($beritas->map(function ($berita) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'excerpt' => $berita->excerpt_formatted,
                'gambar_url' => $berita->gambar_url,
                'views' => $berita->views,
                'published_at' => $berita->published_at_relative,
                'url' => $berita->url,
            ];
        }));
    }

    /**
     * Get latest berita (AJAX endpoint)
     */
    public function latest(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $kategori = $request->get('kategori');

        $query = Berita::published()->latest();

        if ($kategori && $kategori !== 'all') {
            $query->byKategori($kategori);
        }

        $beritas = $query->limit($limit)->get();

        return response()->json($beritas->map(function ($berita) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'excerpt' => $berita->excerpt_formatted,
                'gambar_url' => $berita->gambar_url,
                'published_at' => $berita->published_at_relative,
                'url' => $berita->url,
            ];
        }));
    }

    /**
     * Get featured berita (AJAX endpoint)
     */
    public function featured(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 5);
        $kategori = $request->get('kategori');

        $query = Berita::published()->featured()->latest();

        if ($kategori && $kategori !== 'all') {
            $query->byKategori($kategori);
        }

        $beritas = $query->limit($limit)->get();

        return response()->json($beritas->map(function ($berita) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'excerpt' => $berita->excerpt_formatted,
                'gambar_url' => $berita->gambar_url,
                'published_at' => $berita->published_at_relative,
                'url' => $berita->url,
            ];
        }));
    }

    /**
     * Get categories with berita count (AJAX endpoint)
     */
    public function categories(Request $request): JsonResponse
    {
        $categories = KategoriBerita::active()
            ->withCount(['publishedBeritas'])
            ->ordered()
            ->get();

        return response()->json($categories->map(function ($kategori) {
            return [
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'slug' => $kategori->slug,
                'warna' => $kategori->warna,
                'icon' => $kategori->icon_with_fallback,
                'jumlah_berita' => $kategori->published_beritas_count,
                'url' => $kategori->url,
            ];
        }));
    }

    /**
     * Get archive by month/year
     */
    public function archive(Request $request): View
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = Berita::published()
            ->whereYear('published_at', $year);

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        $beritas = $query->latest()->paginate(12)->withQueryString();

        // Get available years and months for archive navigation
        $availableYears = Berita::published()
            ->selectRaw('YEAR(published_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $availableMonths = [];
        if ($year) {
            $availableMonths = Berita::published()
                ->whereYear('published_at', $year)
                ->selectRaw('MONTH(published_at) as month, MONTHNAME(published_at) as month_name')
                ->groupBy('month', 'month_name')
                ->orderBy('month')
                ->get();
        }

        return view('public.berita.archive', compact(
            'beritas',
            'year',
            'month',
            'availableYears',
            'availableMonths'
        ));
    }

    /**
     * RSS Feed for berita
     */
    public function rss()
    {
        $beritas = Berita::published()
            ->latest()
            ->limit(20)
            ->get();

        return response()
            ->view('public.berita.rss', compact('beritas'))
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    /**
     * Sitemap for berita
     */
    public function sitemap()
    {
        $beritas = Berita::published()
            ->latest()
            ->get(['slug', 'updated_at']);

        $categories = KategoriBerita::active()
            ->get(['slug', 'updated_at']);

        return response()
            ->view('public.berita.sitemap', compact('beritas', 'categories'))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
