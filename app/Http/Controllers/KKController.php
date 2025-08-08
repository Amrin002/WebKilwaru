<?php

namespace App\Http\Controllers;

use App\Models\KK;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Query builder
        $query = KK::query();
        $titleHeader = "Kelola Kartu Keluarga";

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by location
        $filters = [
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
        ];

        $query->filterByLocation(array_filter($filters));

        // Get paginated results
        $kkData = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get unique location data for filters
        $locationData = $this->getLocationData();

        // Get statistics
        $statistics = $this->getStatistics();

        return view('admin.kk.index', compact('kkData', 'locationData', 'statistics', 'titleHeader'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titleHeader = "Buat Kartu Keluarga";
        return view('admin.kk.create', compact('titleHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]+$/',
                'unique:k_k_s,no_kk'
            ],
            'nama_kepala_keluarga' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5|regex:/^[0-9]+$/',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi',
            'no_kk.size' => 'Nomor KK harus 16 digit',
            'no_kk.regex' => 'Nomor KK hanya boleh berisi angka',
            'no_kk.unique' => 'Nomor KK sudah terdaftar',
            'nama_kepala_keluarga.required' => 'Nama kepala keluarga wajib diisi',
            'nama_kepala_keluarga.max' => 'Nama kepala keluarga maksimal 100 karakter',
            'nama_kepala_keluarga.regex' => 'Nama kepala keluarga hanya boleh berisi huruf dan spasi',
            'alamat.required' => 'Alamat wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'desa.required' => 'Desa wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten.required' => 'Kabupaten wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'kode_pos.required' => 'Kode pos wajib diisi',
            'kode_pos.size' => 'Kode pos harus 5 digit',
            'kode_pos.regex' => 'Kode pos hanya boleh berisi angka',
        ]);

        try {
            KK::create($validated);

            return redirect()->route('admin.kk.index')
                ->with('success', 'Data Kartu Keluarga berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $no_kk)
    {
        $kk = KK::findOrFail($no_kk);
        $titleHeader = "Detail Kartu Keluarga";

        return view('admin.kk.show', compact('kk', "titleHeader"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $no_kk)
    {
        $titleHeader = "Edit Kartu Keluarga";
        $kk = KK::findOrFail($no_kk);

        return view('admin.kk.edit', compact('kk', 'titleHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $no_kk)
    {
        $kk = KK::findOrFail($no_kk);

        $validated = $request->validate([
            'no_kk' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]+$/',
                Rule::unique('k_k_s', 'no_kk')->ignore($kk->no_kk, 'no_kk')
            ],
            'nama_kepala_keluarga' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5|regex:/^[0-9]+$/',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi',
            'no_kk.size' => 'Nomor KK harus 16 digit',
            'no_kk.regex' => 'Nomor KK hanya boleh berisi angka',
            'no_kk.unique' => 'Nomor KK sudah terdaftar',
            'nama_kepala_keluarga.required' => 'Nama kepala keluarga wajib diisi',
            'nama_kepala_keluarga.max' => 'Nama kepala keluarga maksimal 100 karakter',
            'nama_kepala_keluarga.regex' => 'Nama kepala keluarga hanya boleh berisi huruf dan spasi',
            'alamat.required' => 'Alamat wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'desa.required' => 'Desa wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten.required' => 'Kabupaten wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'kode_pos.required' => 'Kode pos wajib diisi',
            'kode_pos.size' => 'Kode pos harus 5 digit',
            'kode_pos.regex' => 'Kode pos hanya boleh berisi angka',
        ]);

        try {
            $kk->update($validated);

            return redirect()->route('admin.kk.index')
                ->with('success', 'Data Kartu Keluarga berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_kk)
    {
        try {
            $kk = KK::findOrFail($no_kk);
            $kk->delete();

            return redirect()->route('admin.kk.index')
                ->with('success', 'Data Kartu Keluarga berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Get location data for filters
     */
    private function getLocationData()
    {
        return [
            'provinsi' => KK::distinct()->pluck('provinsi')->sort()->values(),
            'kabupaten' => KK::distinct()->pluck('kabupaten')->sort()->values(),
            'kecamatan' => KK::distinct()->pluck('kecamatan')->sort()->values(),
            'desa' => KK::distinct()->pluck('desa')->sort()->values(),
        ];
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics()
    {
        return [
            'total_kk' => KK::count(),
            'total_provinsi' => KK::distinct('provinsi')->count(),
            'total_kabupaten' => KK::distinct('kabupaten')->count(),
            'total_kecamatan' => KK::distinct('kecamatan')->count(),
        ];
    }

    /**
     * Export data to CSV
     */
    public function export(Request $request)
    {
        $query = KK::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $filters = [
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
        ];

        $query->filterByLocation(array_filter($filters));

        $kkData = $query->orderBy('created_at', 'desc')->get();

        $filename = 'data_kk_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($kkData) {
            $file = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'No. KK',
                'Nama Kepala Keluarga',
                'Alamat',
                'RT',
                'RW',
                'Desa',
                'Kecamatan',
                'Kabupaten',
                'Provinsi',
                'Kode Pos',
                'Alamat Lengkap',
                'Tanggal Dibuat'
            ]);

            // Data rows
            foreach ($kkData as $kk) {
                fputcsv($file, [
                    $kk->no_kk,
                    $kk->nama_kepala_keluarga,
                    $kk->alamat,
                    $kk->rt,
                    $kk->rw,
                    $kk->desa,
                    $kk->kecamatan,
                    $kk->kabupaten,
                    $kk->provinsi,
                    $kk->kode_pos,
                    $kk->alamat_lengkap,
                    $kk->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import data from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');

            // Skip header row
            fgetcsv($handle);

            $imported = 0;
            $errors = [];

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                try {
                    KK::create([
                        'no_kk' => $data[0],
                        'nama_kepala_keluarga' => $data[1],
                        'alamat' => $data[2],
                        'rt' => $data[3],
                        'rw' => $data[4],
                        'desa' => $data[5],
                        'kecamatan' => $data[6],
                        'kabupaten' => $data[7],
                        'provinsi' => $data[8],
                        'kode_pos' => $data[9],
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris dengan No. KK {$data[0]}: " . $e->getMessage();
                }
            }

            fclose($handle);

            $message = "Berhasil import {$imported} data";
            if (count($errors) > 0) {
                $message .= ". " . count($errors) . " data gagal import.";
            }

            return redirect()->route('admin.kk.index')
                ->with('success', $message)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }
}
