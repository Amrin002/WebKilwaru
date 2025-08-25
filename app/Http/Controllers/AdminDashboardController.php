<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Penduduk;
use App\Models\SuratKtm;
use App\Models\SuratKtu;
use App\Models\Umkm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin dengan data dinamis.
     */
    public function index()
    {
        /**
         * Data Penduduk
         */
        // Mendapatkan data bulan ini
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth = $now->endOfMonth()->toDateString();

        // Mengambil data bulan lalu
        $lastMonth = Carbon::now()->subMonth();
        $startOfLastMonth = $lastMonth->startOfMonth()->toDateString();
        $endOfLastMonth = $lastMonth->endOfMonth()->toDateString();

        // 1. Menghitung Total Penduduk
        $totalPenduduk = Penduduk::count();

        // Menghitung total penduduk bulan ini dan bulan lalu
        $pendudukThisMonth = Penduduk::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $pendudukLastMonth = Penduduk::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // Menghitung persentase perubahan penduduk
        $persenPendudukChange = 0;
        if ($pendudukLastMonth > 0) {
            $persenPendudukChange = (($pendudukThisMonth - $pendudukLastMonth) / $pendudukLastMonth) * 100;
        }

        // 2. Menghitung Kepala Keluarga
        $kepalaKeluarga = Penduduk::kepalaKeluarga()->count();

        // Menghitung kepala keluarga bulan ini dan bulan lalu
        $kkThisMonth = Penduduk::kepalaKeluarga()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $kkLastMonth = Penduduk::kepalaKeluarga()->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // Menghitung persentase perubahan kepala keluarga
        $persenKkChange = 0;
        if ($kkLastMonth > 0) {
            $persenKkChange = (($kkThisMonth - $kkLastMonth) / $kkLastMonth) * 100;
        }


        /**
         * Data UMKM
         */
        $totalUmkm = Umkm::count(); // Menggunakan model Umkm untuk menghitung semua data
        $umkmThisMonth = Umkm::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $umkmLastMonth = Umkm::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $persenUmkmChange = 0;
        if ($umkmLastMonth > 0) {
            $persenUmkmChange = (($umkmThisMonth - $umkmLastMonth) / $umkmLastMonth) * 100;
        }
        $umkmActivities = Umkm::latest()->take(5)->get()->map(function ($item) {
            $item->jenis_aktivitas = 'UMKM Baru Ditambahkan';
            $item->icon_class = 'bi bi-shop'; // Contoh ikon
            return $item;
        });

        /**
         * Data Berita
         */
        $totalBeritaBulanIni = Berita::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $totalBeritaBulanLalu = Berita::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        $persenBeritaChange = 0;
        if ($totalBeritaBulanLalu > 0) {
            $persenBeritaChange = (($totalBeritaBulanIni - $totalBeritaBulanLalu) / $totalBeritaBulanLalu) * 100;
        }

        /**
         * Data Surat Terbaru
         */

        // 5. Mengambil 5 aktivitas terbaru dari model SuratKtm, SuratKtu, dan Umkm
        $suratKtm = SuratKtm::latest()->take(5)->get()->map(function ($item) {
            $item->jenis_aktivitas = 'Surat Keterangan Tidak Mampu';
            $item->icon_class = 'bi bi-file-earmark-text'; // Contoh ikon
            return $item;
        });
        $suratKtu = SuratKtu::latest()->take(5)->get()->map(function ($item) {
            $item->jenis_aktivitas = 'Surat Keterangan Usaha';
            $item->icon_class = 'bi bi-file-earmark-plus'; // Contoh ikon
            return $item;
        });


        // 6. Menghitung Layanan Populer (total yang disetujui/terdaftar bulan ini)

        $popularServices = collect([
            [
                'title' => 'Surat Keterangan Usaha',
                'count' => SuratKtu::where('status', 'disetujui')->whereMonth('updated_at', $now->month)->whereYear('updated_at', $now->year)->count(),
                'icon_class' => 'bi-file-earmark-plus',
                'status_class' => 'success',
            ],
            [
                'title' => 'Surat Keterangan Tidak Mampu',
                'count' => SuratKtm::where('status', 'disetujui')->whereMonth('updated_at', $now->month)->whereYear('updated_at', $now->year)->count(),
                'icon_class' => 'bi-file-earmark-text',
                'status_class' => 'info',
            ],
            [
                'title' => 'UMKM',
                'count' => Umkm::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count(),
                'icon_class' => 'bi-shop',
                'status_class' => 'warning',
            ],
        ])->sortByDesc('count')->values()->take(3);

        // Gabungkan dan ambil 10 data terbaru
        $latestActivities = $suratKtm->merge($suratKtu)->merge($umkmActivities)->sortByDesc('created_at')->take(5);


        // Mendefinisikan judul halaman
        $titleHeader = "Dashboard Admin";
        // Tambahkan logika untuk notifikasi


        // Mengirim data ke view
        return view('admin.index', compact(
            'titleHeader',
            'totalPenduduk',
            'kepalaKeluarga',
            'persenPendudukChange',
            'persenKkChange',
            'totalUmkm',
            'persenUmkmChange',
            'totalBeritaBulanIni',
            'persenBeritaChange',
            'latestActivities',
            'popularServices',


        ));
    }
}
