<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\StrukturDesa;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mendapatkan tahun saat ini
        $currentYear = date('Y');

        // 1. Coba ambil APBDes untuk tahun ini
        $currentApbdes = Apbdes::byTahun($currentYear)->first();

        // 2. Jika APBDes tahun ini tidak ada, ambil yang terbaru
        if (!$currentApbdes) {
            $currentApbdes = Apbdes::latest()->first();
        }
        // Ambil data kepala desa
        $kepalaDesa = StrukturDesa::byKategori('kepala_desa')
            ->aktif()
            ->ordered()
            ->first();
        // Get latest 3 published berita for home page
        $latestBerita = Berita::published()
            ->with('kategoriBeri')
            ->latest()
            ->limit(3)
            ->get();
        // Get latest 6 galeri photos for home page
        $latestGaleri = Galeri::latest()
            ->limit(6)
            ->get();
        $strukturDesa = StrukturDesa::aktif()
            ->ordered()
            ->get()
            ->groupBy('kategori');

        $latestUmkm = Umkm::approved()->with('penduduk')->latest()->limit(4)->get();

        return view('home.index', compact('latestBerita', 'strukturDesa', 'latestGaleri', 'currentApbdes', 'kepalaDesa', 'latestUmkm'));
    }
    public function beritaLatest()
    {
        // Get latest 3 published berita for home page
        $latestBerita = Berita::published()
            ->with('kategoriBeri')
            ->latest()
            ->limit(3)
            ->get();

        return view('home.index', compact('latestBerita'));
    }
}
