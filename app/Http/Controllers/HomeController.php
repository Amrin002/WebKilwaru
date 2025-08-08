<?php

namespace App\Http\Controllers;

use App\Models\Berita;
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

        return view('home.index', compact('latestBerita'));
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
