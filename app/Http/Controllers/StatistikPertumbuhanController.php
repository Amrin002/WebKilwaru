<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikPertumbuhanController extends Controller
{
    /**
     * Display statistik pertumbuhan penduduk
     */
    public function index(Request $request): View
    {
        $titleHeader = "Statistik Pertumbuhan Penduduk";

        // Get date range from request or default to current year
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $period = $request->get('period', 'monthly'); // monthly, yearly, quarterly

        // Get basic statistics
        $basicStats = $this->getBasicStatistics();

        // Get growth data based on period
        $growthData = $this->getGrowthData($startDate, $endDate, $period);

        // Get demographic statistics
        $demographicStats = $this->getDemographicStatistics();

        // Get age group statistics
        $ageGroupStats = $this->getAgeGroupStatistics();

        // Get regional statistics
        $regionalStats = $this->getRegionalStatistics();

        // Get yearly comparison
        $yearlyComparison = $this->getYearlyComparison();

        return view('admin.statistik.pertumbuhan.index', compact(
            'titleHeader',
            'basicStats',
            'growthData',
            'demographicStats',
            'ageGroupStats',
            'regionalStats',
            'yearlyComparison',
            'startDate',
            'endDate',
            'period'
        ));
    }

    /**
     * Get basic population statistics
     */
    private function getBasicStatistics(): array
    {
        $totalPenduduk = Penduduk::count();
        $totalKK = KK::count();

        return [
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKK,
            'rata_rata_anggota_kk' => $totalKK > 0 ? round($totalPenduduk / $totalKK, 2) : 0,
            'laki_laki' => Penduduk::where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => Penduduk::where('jenis_kelamin', 'Perempuan')->count(),
            'kepala_keluarga' => Penduduk::where('status_keluarga', 'Kepala Keluarga')->count(),
        ];
    }

    /**
     * Get population growth data based on registration date
     */
    private function getGrowthData(string $startDate, string $endDate, string $period): array
    {
        $format = match ($period) {
            'yearly' => '%Y',
            'quarterly' => '%Y-Q%q',
            'monthly' => '%Y-%m',
            'weekly' => '%Y-%u',
            'daily' => '%Y-%m-%d',
            default => '%Y-%m'
        };

        // Growth data untuk penduduk
        $pendudukGrowth = Penduduk::selectRaw("
                DATE_FORMAT(created_at, '{$format}') as period,
                COUNT(*) as jumlah,
                SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan
            ")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Growth data untuk KK
        $kkGrowth = KK::selectRaw("
                DATE_FORMAT(created_at, '{$format}') as period,
                COUNT(*) as jumlah
            ")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Calculate cumulative data
        $cumulativePenduduk = 0;
        $cumulativeKK = 0;

        $growthWithCumulative = [];

        foreach ($pendudukGrowth as $growth) {
            $cumulativePenduduk += $growth->jumlah;
            $kkCount = $kkGrowth->where('period', $growth->period)->first()?->jumlah ?? 0;
            $cumulativeKK += $kkCount;

            $growthWithCumulative[] = [
                'period' => $growth->period,
                'penduduk_baru' => $growth->jumlah,
                'kk_baru' => $kkCount,
                'laki_laki_baru' => $growth->laki_laki,
                'perempuan_baru' => $growth->perempuan,
                'cumulative_penduduk' => $cumulativePenduduk,
                'cumulative_kk' => $cumulativeKK,
                'growth_rate' => $cumulativePenduduk > $growth->jumlah ?
                    round((($growth->jumlah / ($cumulativePenduduk - $growth->jumlah)) * 100), 2) : 0
            ];
        }

        return $growthWithCumulative;
    }

    /**
     * Get demographic statistics
     */
    private function getDemographicStatistics(): array
    {
        // Statistics by religion
        $agamaStats = Penduduk::selectRaw('agama, COUNT(*) as jumlah, 
                (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM penduduks)) as persentase')
            ->groupBy('agama')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Statistics by education
        $pendidikanStats = Penduduk::selectRaw('pendidikan, COUNT(*) as jumlah,
                (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM penduduks)) as persentase')
            ->groupBy('pendidikan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Statistics by occupation
        $pekerjaanStats = Penduduk::selectRaw('pekerjaan, COUNT(*) as jumlah,
                (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM penduduks)) as persentase')
            ->groupBy('pekerjaan')
            ->orderBy('jumlah', 'desc')
            ->limit(10)
            ->get();

        // Statistics by marital status
        $statusPerkawinanStats = Penduduk::selectRaw('status, COUNT(*) as jumlah,
                (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM penduduks)) as persentase')
            ->groupBy('status')
            ->orderBy('jumlah', 'desc')
            ->get();

        return [
            'agama' => $agamaStats,
            'pendidikan' => $pendidikanStats,
            'pekerjaan' => $pekerjaanStats,
            'status_perkawinan' => $statusPerkawinanStats,
        ];
    }

    /**
     * Get age group statistics
     */
    private function getAgeGroupStatistics(): array
    {
        $ageGroups = Penduduk::selectRaw("
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 5 THEN 'Balita (0-4 tahun)'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 14 THEN 'Anak (5-14 tahun)'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 24 THEN 'Remaja (15-24 tahun)'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 54 THEN 'Dewasa (25-54 tahun)'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 64 THEN 'Lansia Awal (55-64 tahun)'
                    ELSE 'Lansia (65+ tahun)'
                END as kelompok_umur,
                COUNT(*) as jumlah,
                SUM(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan,
                (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM penduduks)) as persentase
            ")
            ->groupBy('kelompok_umur')
            ->orderByRaw("
                CASE 
                    WHEN kelompok_umur = 'Balita (0-4 tahun)' THEN 1
                    WHEN kelompok_umur = 'Anak (5-14 tahun)' THEN 2
                    WHEN kelompok_umur = 'Remaja (15-24 tahun)' THEN 3
                    WHEN kelompok_umur = 'Dewasa (25-54 tahun)' THEN 4
                    WHEN kelompok_umur = 'Lansia Awal (55-64 tahun)' THEN 5
                    ELSE 6
                END
            ")
            ->get();

        // Calculate dependency ratio
        $totalPenduduk = Penduduk::count();
        $usiaProduktif = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 64')->count();
        $usiaTidakProduktif = $totalPenduduk - $usiaProduktif;
        $dependencyRatio = $usiaProduktif > 0 ? round(($usiaTidakProduktif / $usiaProduktif) * 100, 2) : 0;

        return [
            'kelompok_umur' => $ageGroups,
            'dependency_ratio' => $dependencyRatio,
            'usia_produktif' => $usiaProduktif,
            'usia_tidak_produktif' => $usiaTidakProduktif,
        ];
    }

    /**
     * Get regional statistics
     */
    private function getRegionalStatistics(): array
    {
        // Statistics by province
        $provinsiStats = DB::table('penduduks')
            ->join('k_k_s', 'penduduks.no_kk', '=', 'k_k_s.no_kk')
            ->selectRaw('k_k_s.provinsi, COUNT(*) as jumlah_penduduk, COUNT(DISTINCT k_k_s.no_kk) as jumlah_kk')
            ->groupBy('k_k_s.provinsi')
            ->orderBy('jumlah_penduduk', 'desc')
            ->get();

        // Statistics by kabupaten
        $kabupatenStats = DB::table('penduduks')
            ->join('k_k_s', 'penduduks.no_kk', '=', 'k_k_s.no_kk')
            ->selectRaw('k_k_s.kabupaten, COUNT(*) as jumlah_penduduk, COUNT(DISTINCT k_k_s.no_kk) as jumlah_kk')
            ->groupBy('k_k_s.kabupaten')
            ->orderBy('jumlah_penduduk', 'desc')
            ->get();

        // Statistics by kecamatan
        $kecamatanStats = DB::table('penduduks')
            ->join('k_k_s', 'penduduks.no_kk', '=', 'k_k_s.no_kk')
            ->selectRaw('k_k_s.kecamatan, COUNT(*) as jumlah_penduduk, COUNT(DISTINCT k_k_s.no_kk) as jumlah_kk')
            ->groupBy('k_k_s.kecamatan')
            ->orderBy('jumlah_penduduk', 'desc')
            ->get();

        // Statistics by desa
        $desaStats = DB::table('penduduks')
            ->join('k_k_s', 'penduduks.no_kk', '=', 'k_k_s.no_kk')
            ->selectRaw('k_k_s.desa, COUNT(*) as jumlah_penduduk, COUNT(DISTINCT k_k_s.no_kk) as jumlah_kk')
            ->groupBy('k_k_s.desa')
            ->orderBy('jumlah_penduduk', 'desc')
            ->get();

        return [
            'provinsi' => $provinsiStats,
            'kabupaten' => $kabupatenStats,
            'kecamatan' => $kecamatanStats,
            'desa' => $desaStats,
        ];
    }

    /**
     * Get yearly comparison data
     */
    private function getYearlyComparison(): array
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 4, $currentYear); // Last 5 years

        $yearlyData = [];

        foreach ($years as $year) {
            $startOfYear = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endOfYear = Carbon::createFromDate($year, 12, 31)->endOfYear();

            $pendudukCount = Penduduk::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
            $kkCount = KK::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

            // Calculate total population at end of year
            $totalPendudukEndOfYear = Penduduk::where('created_at', '<=', $endOfYear)->count();
            $totalKKEndOfYear = KK::where('created_at', '<=', $endOfYear)->count();

            $yearlyData[] = [
                'year' => $year,
                'penduduk_baru' => $pendudukCount,
                'kk_baru' => $kkCount,
                'total_penduduk' => $totalPendudukEndOfYear,
                'total_kk' => $totalKKEndOfYear,
                'rata_rata_anggota_kk' => $totalKKEndOfYear > 0 ? round($totalPendudukEndOfYear / $totalKKEndOfYear, 2) : 0,
            ];
        }

        // Calculate growth rates
        for ($i = 1; $i < count($yearlyData); $i++) {
            $prevYear = $yearlyData[$i - 1];
            $currentYearData = &$yearlyData[$i];

            if ($prevYear['total_penduduk'] > 0) {
                $currentYearData['growth_rate_penduduk'] = round(
                    (($currentYearData['total_penduduk'] - $prevYear['total_penduduk']) / $prevYear['total_penduduk']) * 100,
                    2
                );
            } else {
                $currentYearData['growth_rate_penduduk'] = 0;
            }

            if ($prevYear['total_kk'] > 0) {
                $currentYearData['growth_rate_kk'] = round(
                    (($currentYearData['total_kk'] - $prevYear['total_kk']) / $prevYear['total_kk']) * 100,
                    2
                );
            } else {
                $currentYearData['growth_rate_kk'] = 0;
            }
        }

        return $yearlyData;
    }

    /**
     * Export growth statistics to Excel/CSV
     */
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $period = $request->get('period', 'monthly');

        $growthData = $this->getGrowthData($startDate, $endDate, $period);
        $basicStats = $this->getBasicStatistics();
        $demographicStats = $this->getDemographicStatistics();

        $filename = 'statistik_pertumbuhan_penduduk_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($growthData, $basicStats, $demographicStats) {
            $file = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");

            // Basic statistics
            fputcsv($file, ['STATISTIK DASAR']);
            fputcsv($file, ['Total Penduduk', $basicStats['total_penduduk']]);
            fputcsv($file, ['Total KK', $basicStats['total_kk']]);
            fputcsv($file, ['Laki-laki', $basicStats['laki_laki']]);
            fputcsv($file, ['Perempuan', $basicStats['perempuan']]);
            fputcsv($file, ['Rata-rata Anggota KK', $basicStats['rata_rata_anggota_kk']]);
            fputcsv($file, []);

            // Growth data
            fputcsv($file, ['DATA PERTUMBUHAN']);
            fputcsv($file, [
                'Periode',
                'Penduduk Baru',
                'KK Baru',
                'Laki-laki Baru',
                'Perempuan Baru',
                'Kumulatif Penduduk',
                'Kumulatif KK',
                'Growth Rate (%)'
            ]);

            foreach ($growthData as $data) {
                fputcsv($file, [
                    $data['period'],
                    $data['penduduk_baru'],
                    $data['kk_baru'],
                    $data['laki_laki_baru'],
                    $data['perempuan_baru'],
                    $data['cumulative_penduduk'],
                    $data['cumulative_kk'],
                    $data['growth_rate']
                ]);
            }

            fputcsv($file, []);

            // Demographic statistics
            fputcsv($file, ['STATISTIK AGAMA']);
            fputcsv($file, ['Agama', 'Jumlah', 'Persentase']);
            foreach ($demographicStats['agama'] as $agama) {
                fputcsv($file, [$agama->agama, $agama->jumlah, round($agama->persentase, 2) . '%']);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get data for charts (AJAX)
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'growth');
        $period = $request->get('period', 'monthly');
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        switch ($type) {
            case 'growth':
                $data = $this->getGrowthData($startDate, $endDate, $period);
                break;
            case 'demographic':
                $data = $this->getDemographicStatistics();
                break;
            case 'age_group':
                $data = $this->getAgeGroupStatistics();
                break;
            case 'regional':
                $data = $this->getRegionalStatistics();
                break;
            case 'yearly':
                $data = $this->getYearlyComparison();
                break;
            default:
                $data = [];
        }

        return response()->json($data);
    }

    /**
     * Print statistics report
     */
    public function print(Request $request): View
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $period = $request->get('period', 'monthly');

        $basicStats = $this->getBasicStatistics();
        $growthData = $this->getGrowthData($startDate, $endDate, $period);
        $demographicStats = $this->getDemographicStatistics();
        $ageGroupStats = $this->getAgeGroupStatistics();
        $regionalStats = $this->getRegionalStatistics();
        $yearlyComparison = $this->getYearlyComparison();

        return view('admin.statistik.pertumbuhan.print', compact(
            'basicStats',
            'growthData',
            'demographicStats',
            'ageGroupStats',
            'regionalStats',
            'yearlyComparison',
            'startDate',
            'endDate',
            'period'
        ));
    }
}
