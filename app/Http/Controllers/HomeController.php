<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest 3 published berita for home page
        $latestBerita = Berita::published()
            ->with('kategoriBeri')
            ->latest()
            ->limit(3)
            ->get();

        $strukturDesa = StrukturDesa::aktif()
            ->ordered()
            ->get()
            ->groupBy('kategori');

        return view('home.index', compact('latestBerita', 'strukturDesa'));
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
