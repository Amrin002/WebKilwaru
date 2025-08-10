<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArsipSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titleHeader = "Kelola Arsip Surat";
        $query = ArsipSurat::query();

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            if ($request->kategori === 'masuk') {
                $query->suratMasuk();
            } elseif ($request->kategori === 'keluar') {
                $query->suratKeluar();
            }
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->tahun($request->tahun);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->bulanTahun($request->bulan, $request->tahun);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $arsipSurat = $query->orderBy('tanggal_surat', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        // Data untuk filter dropdown
        $tahunList = ArsipSurat::selectRaw('YEAR(tanggal_surat) as tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->pluck('tahun');

        $statistik = ArsipSurat::totalPerKategori($request->tahun ?: date('Y'));

        return view('admin.arsip-surat.index', compact('arsipSurat', 'tahunList', 'statistik', 'titleHeader'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate suggestion nomor surat
        $titleHeader = "Tambah Arsip Surat";
        $nomorUrut = ArsipSurat::generateNomorUrut();
        $bulan = strtoupper(date('M'));
        $tahun = date('Y');
        $suggestedNomor = sprintf('%03d/NK/%s/%d', $nomorUrut, $bulan, $tahun);

        return view('admin.arsip-surat.create', compact('suggestedNomor', 'titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:100|unique:arsip_surat',
            'tanggal_surat' => 'required|date',
            'kategori' => 'required|in:masuk,keluar',
            'pengirim' => 'required_if:kategori,masuk|nullable|string|max:255',
            'perihal' => 'required_if:kategori,masuk|nullable|string',
            'tujuan_surat' => 'required_if:kategori,keluar|nullable|string|max:255',
            'tentang' => 'required_if:kategori,keluar|nullable|string',
            'keterangan' => 'nullable|string'
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah ada',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'pengirim.required_if' => 'Pengirim wajib diisi untuk surat masuk',
            'perihal.required_if' => 'Perihal wajib diisi untuk surat masuk',
            'tujuan_surat.required_if' => 'Tujuan surat wajib diisi untuk surat keluar',
            'tentang.required_if' => 'Tentang wajib diisi untuk surat keluar'
        ]);

        // Hapus field yang tidak sesuai kategori
        if ($validated['kategori'] === 'masuk') {
            $validated['tujuan_surat'] = null;
            $validated['tentang'] = null;
        } else {
            $validated['pengirim'] = null;
            $validated['perihal'] = null;
        }

        // Hapus field kategori karena tidak ada di database
        unset($validated['kategori']);

        $arsipSurat = ArsipSurat::create($validated);

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ArsipSurat $arsipSurat)
    {
        $titleHeader = "Detail Arsip Surat";

        return view('admin.arsip-surat.show', compact('arsipSurat', 'titleHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArsipSurat $arsipSurat)
    {
        $titleHeader = "Ubah Arsip Surat";

        return view('admin.arsip-surat.edit', compact('arsipSurat', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArsipSurat $arsipSurat)
    {
        $validated = $request->validate([
            'nomor_surat' => [
                'required',
                'string',
                'max:100',
                Rule::unique('arsip_surat')->ignore($arsipSurat->id)
            ],
            'tanggal_surat' => 'required|date',
            'kategori' => 'required|in:masuk,keluar',
            'pengirim' => 'required_if:kategori,masuk|nullable|string|max:255',
            'perihal' => 'required_if:kategori,masuk|nullable|string',
            'tujuan_surat' => 'required_if:kategori,keluar|nullable|string|max:255',
            'tentang' => 'required_if:kategori,keluar|nullable|string',
            'keterangan' => 'nullable|string'
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah ada',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'pengirim.required_if' => 'Pengirim wajib diisi untuk surat masuk',
            'perihal.required_if' => 'Perihal wajib diisi untuk surat masuk',
            'tujuan_surat.required_if' => 'Tujuan surat wajib diisi untuk surat keluar',
            'tentang.required_if' => 'Tentang wajib diisi untuk surat keluar'
        ]);

        // Hapus field yang tidak sesuai kategori
        if ($validated['kategori'] === 'masuk') {
            $validated['tujuan_surat'] = null;
            $validated['tentang'] = null;
        } else {
            $validated['pengirim'] = null;
            $validated['perihal'] = null;
        }

        // Hapus field kategori karena tidak ada di database
        unset($validated['kategori']);

        $arsipSurat->update($validated);

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArsipSurat $arsipSurat)
    {
        $arsipSurat->delete();

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil dihapus');
    }

    /**
     * Generate nomor surat berikutnya (AJAX)
     */
    public function generateNomor(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('n'));

        $nomorUrut = ArsipSurat::generateNomorUrut($tahun);

        // Format bulan ke romawi
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $suggestedNomor = sprintf(
            '%03d/NK/%s/%d',
            $nomorUrut,
            $bulanRomawi[$bulan],
            $tahun
        );

        return response()->json([
            'nomor_urut' => $nomorUrut,
            'nomor_surat' => $suggestedNomor
        ]);
    }

    /**
     * Halaman statistik
     */
    public function statistik(Request $request)
    {
        $titleHeader = "Statistik Arsip Surat";
        $tahun = $request->input('tahun', date('Y'));

        $statistikBulanan = ArsipSurat::statistikBulanan($tahun);
        $totalPerKategori = ArsipSurat::totalPerKategori($tahun);
        $suratTerbaru = ArsipSurat::suratTerbaru(10);

        // Data untuk chart
        $bulanLabels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $dataMasuk = array_fill(0, 12, 0);
        $dataKeluar = array_fill(0, 12, 0);

        foreach ($statistikBulanan as $data) {
            $bulanIndex = $data['bulan'] - 1;
            $dataMasuk[$bulanIndex] = $data['surat_masuk'];
            $dataKeluar[$bulanIndex] = $data['surat_keluar'];
        }

        $tahunList = ArsipSurat::selectRaw('YEAR(tanggal_surat) as tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->pluck('tahun');

        return view('admin.arsip-surat.statistik', compact(
            'tahun',
            'totalPerKategori',
            'suratTerbaru',
            'bulanLabels',
            'dataMasuk',
            'dataKeluar',
            'tahunList',
            'titleHeader'
        ));
    }

    /**
     * Export data (contoh sederhana)
     */
    public function export(Request $request)
    {
        $query = ArsipSurat::query();

        // Apply filters sama seperti index
        if ($request->filled('kategori')) {
            if ($request->kategori === 'masuk') {
                $query->suratMasuk();
            } elseif ($request->kategori === 'keluar') {
                $query->suratKeluar();
            }
        }

        if ($request->filled('tahun')) {
            $query->tahun($request->tahun);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->bulanTahun($request->bulan, $request->tahun);
        }

        $arsipSurat = $query->orderBy('tanggal_surat', 'DESC')->get();

        $filename = 'arsip-surat-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($arsipSurat) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'No',
                'Nomor Surat',
                'Tanggal',
                'Kategori',
                'Pengirim',
                'Perihal',
                'Tujuan Surat',
                'Tentang',
                'Keterangan'
            ]);

            // Data
            foreach ($arsipSurat as $index => $surat) {
                fputcsv($file, [
                    $index + 1,
                    $surat->nomor_surat,
                    $surat->tanggal_surat_formatted,
                    $surat->kategori_surat,
                    $surat->pengirim,
                    $surat->perihal,
                    $surat->tujuan_surat,
                    $surat->tentang,
                    $surat->keterangan
                ]);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Bulk import dari CSV/Excel (sederhana)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));

        // Skip header row
        $header = array_shift($rows);

        $imported = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            if (empty($row[0])) continue; // Skip empty rows

            try {
                ArsipSurat::create([
                    'nomor_surat' => $row[0] ?? '',
                    'tanggal_surat' => $row[1] ?? date('Y-m-d'),
                    'pengirim' => $row[2] ?? null,
                    'perihal' => $row[3] ?? null,
                    'tujuan_surat' => $row[4] ?? null,
                    'tentang' => $row[5] ?? null,
                    'keterangan' => $row[6] ?? null
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Berhasil import {$imported} data.";
        if (!empty($errors)) {
            $message .= " Ada " . count($errors) . " error.";
        }

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Halaman import
     */
    public function showImport()
    {
        return view('admin.arsip-surat.import');
    }

    /**
     * API endpoint untuk mobile app
     */
    public function api(Request $request)
    {
        $query = ArsipSurat::query();

        // Filter
        if ($request->filled('kategori')) {
            if ($request->kategori === 'masuk') {
                $query->suratMasuk();
            } elseif ($request->kategori === 'keluar') {
                $query->suratKeluar();
            }
        }

        if ($request->filled('tahun')) {
            $query->tahun($request->tahun);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $arsipSurat = $query->orderBy('tanggal_surat', 'DESC')
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $arsipSurat,
            'statistics' => ArsipSurat::totalPerKategori($request->tahun)
        ]);
    }

    /**
     * API store untuk mobile app
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:100|unique:arsip_surat',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'nullable|string|max:255',
            'perihal' => 'nullable|string',
            'tujuan_surat' => 'nullable|string|max:255',
            'tentang' => 'nullable|string',
            'keterangan' => 'nullable|string'
        ]);

        $arsipSurat = ArsipSurat::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Arsip surat berhasil ditambahkan',
            'data' => $arsipSurat
        ], 201);
    }
}
