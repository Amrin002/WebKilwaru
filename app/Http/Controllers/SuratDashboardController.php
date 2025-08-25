<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKtm;
use App\Models\SuratKtu;
use App\Models\ArsipSurat;
use App\Models\VerifikasiSurat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuratDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard surat dengan data dinamis.
     */
    public function index()
    {
        $titleHeader = "Dashboard Surat";
        $currentYear = Carbon::now()->year;

        // ========================================
        // Statistik Utama
        // ========================================

        // Total permohonan dari semua jenis surat
        $totalPermohonan = SuratKtm::count() + SuratKtu::count();
        $totalArsip = ArsipSurat::count();

        // Total verifikasi QR Code
        $totalVerifikasi = VerifikasiSurat::count();
        $verifikasiBerhasil = VerifikasiSurat::found()->count();

        // Statistik berdasarkan status
        $suratStatsKtm = SuratKtm::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $suratStatsKtu = SuratKtu::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalDiproses = ($suratStatsKtm['diproses'] ?? 0) + ($suratStatsKtu['diproses'] ?? 0);
        $totalDisetujui = ($suratStatsKtm['disetujui'] ?? 0) + ($suratStatsKtu['disetujui'] ?? 0);
        $totalDitolak = ($suratStatsKtm['ditolak'] ?? 0) + ($suratStatsKtu['ditolak'] ?? 0);

        // ========================================
        // Aktivitas Terbaru
        // ========================================

        // Mengambil aktivitas terbaru dari model SuratKtm, SuratKtu, dan VerifikasiSurat
        $suratKtm = SuratKtm::latest()->take(5)->get()->map(function ($item) {
            $statusText = $item->status === 'disetujui' ? ' - Disetujui' : ' - Pengajuan Baru';
            $item->jenis_aktivitas = 'Surat Keterangan Tidak Mampu' . $statusText;
            $item->icon_class = $item->status === 'disetujui' ? 'bi-check-lg' : 'bi-clock';
            $item->status_class = $item->status === 'disetujui' ? 'success' : 'warning';
            $item->timestamp = $item->updated_at;
            return $item;
        });

        $suratKtu = SuratKtu::latest()->take(5)->get()->map(function ($item) {
            $statusText = $item->status === 'disetujui' ? ' - Disetujui' : ' - Pengajuan Baru';
            $item->jenis_aktivitas = 'Surat Keterangan Usaha' . $statusText;
            $item->icon_class = $item->status === 'disetujui' ? 'bi-check-lg' : 'bi-clock';
            $item->status_class = $item->status === 'disetujui' ? 'success' : 'warning';
            $item->timestamp = $item->updated_at;
            return $item;
        });

        $verifikasiSurat = VerifikasiSurat::found()->latest()->take(5)->get()->map(function ($item) {
            $item->jenis_aktivitas = 'Verifikasi Surat: ' . $item->nomor_surat;
            $item->icon_class = 'bi-patch-check';
            $item->status_class = 'success';
            $item->timestamp = $item->waktu_scan;
            return $item;
        });

        $latestActivities = $suratKtm->merge($suratKtu)->merge($verifikasiSurat)->sortByDesc('timestamp')->take(5);

        // ========================================
        // Data Grafik
        // ========================================
        $permohonanPerBulan = $this->getPermohonanPerBulan($currentYear);
        $verifikasiPerBulan = $this->getVerifikasiPerBulan($currentYear);

        // dd($permohonanPerBulan);
        // ========================================
        // Mengirim data ke view
        // ========================================
        return view('admin.surat.dashboard', compact(
            'titleHeader',
            'totalPermohonan',
            'totalArsip',
            'totalVerifikasi',
            'verifikasiBerhasil',
            'totalDiproses',
            'totalDisetujui',
            'totalDitolak',
            'latestActivities',
            'permohonanPerBulan',
            'verifikasiPerBulan'
        ));
    }

    /**
     * Helper untuk mendapatkan data permohonan per bulan.
     */
    private function getPermohonanPerBulan(int $year)
    {
        $permohonanKtm = SuratKtm::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $permohonanKtu = SuratKtu::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $data = [
            'labels' => [],
            'datasets' => [
                'ktm' => [],
                'ktu' => [],
                'total' => []
            ]
        ];

        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 1; $i <= 12; $i++) {
            $ktmCount = $permohonanKtm[$i] ?? 0;
            $ktuCount = $permohonanKtu[$i] ?? 0;

            $data['labels'][] = $bulan[$i - 1];
            $data['datasets']['ktm'][] = (int) $ktmCount;
            $data['datasets']['ktu'][] = (int) $ktuCount;
            $data['datasets']['total'][] = (int) ($ktmCount + $ktuCount);
        }

        return $data;
    }

    private function getVerifikasiPerBulan(int $year)
    {
        $verifikasiFound = VerifikasiSurat::select(DB::raw('MONTH(waktu_scan) as month'), DB::raw('count(*) as total'))
            ->found()
            ->whereYear('waktu_scan', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $verifikasiNotFound = VerifikasiSurat::select(DB::raw('MONTH(waktu_scan) as month'), DB::raw('count(*) as total'))
            ->notFound()
            ->whereYear('waktu_scan', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $data = [
            'labels' => [],
            'datasets' => [
                'found' => [],
                'not_found' => []
            ]
        ];

        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 1; $i <= 12; $i++) {
            $foundCount = $verifikasiFound[$i] ?? 0;
            $notFoundCount = $verifikasiNotFound[$i] ?? 0;

            $data['labels'][] = $bulan[$i - 1];
            $data['datasets']['found'][] = (int) $foundCount;
            $data['datasets']['not_found'][] = (int) $notFoundCount;
        }

        return $data;
    }
}
