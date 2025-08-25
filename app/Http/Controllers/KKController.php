<?php

namespace App\Http\Controllers;

use App\Exports\KKExport;
use App\Exports\Templates\KKTemplateExport;
use App\Imports\KKImport;
use App\Models\KK;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

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
     * Export data to Excel
     */
    public function export(Request $request)
    {
        // Debug: Log untuk memastikan method dipanggil
        Log::info('Export method called', [
            'user' => Auth::user()->id ?? 'guest',
            'query' => $request->all()
        ]);

        try {
            // Debug: Cek apakah KKExport class ada
            if (!class_exists(\App\Exports\KKExport::class)) {
                throw new \Exception('KKExport class not found');
            }

            $filename = 'data_kk_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Debug: Log sebelum download
            Log::info('Attempting to download', ['filename' => $filename]);

            return Excel::download(new KKExport($request), $filename);
        } catch (\Exception $e) {
            Log::error('Export failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Import data from Excel
     */
    public function import(Request $request)
    {
        // Validasi request
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240' // Max 10MB
        ], [
            'file.required' => 'File wajib dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls)',
            'file.max' => 'Ukuran file maksimal 10MB'
        ]);

        try {
            DB::beginTransaction();

            $import = new KKImport();
            Excel::import($import, $request->file('file'));

            DB::commit();

            $importedCount = $import->getImportedCount();
            $skippedCount = $import->getSkippedCount();
            $errorCount = count($import->failures()) + count($import->errors());

            $message = "Import selesai! ";
            $message .= "Berhasil: {$importedCount} data, ";
            $message .= "Dilewati: {$skippedCount} data";

            if ($errorCount > 0) {
                $message .= ", Error: {$errorCount} data";
            }

            // Store detailed errors in session for display
            if (count($import->failures()) > 0 || count($import->errors()) > 0) {
                session(['import_details' => [
                    'failures' => $import->failures(),
                    'errors' => $import->errors()
                ]]);
            }

            // Return JSON response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'imported' => $importedCount,
                        'skipped' => $skippedCount,
                        'errors' => $errorCount
                    ]
                ]);
            }

            return redirect()->route('admin.kk.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            // Return JSON response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal import data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import
     */
    public function downloadTemplate()
    {
        try {
            $filename = 'template_import_kk.xlsx';

            // Gunakan KKTemplateExport yang sudah dibuat
            return Excel::download(new KKTemplateExport, $filename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mendownload template: ' . $e->getMessage());
        }
    }

    /**
     * Show import errors/failures detail
     */
    public function showImportErrors()
    {
        $details = session('import_details');

        if (!$details) {
            return redirect()->route('admin.kk.index')
                ->with('error', 'Tidak ada detail error yang tersedia');
        }

        return view('admin.kk.import-errors', [
            'failures' => $details['failures'] ?? [],
            'errors' => $details['errors'] ?? [],
            'titleHeader' => 'Detail Error Import KK'
        ]);
    }

    /**
     * Validate import file (AJAX endpoint)
     */
    public function validateImportFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240'
        ]);

        try {
            $file = $request->file('file');

            // Basic file validation
            $data = Excel::toArray(new HeadingRowImport(), $file);

            if (empty($data) || empty($data[0])) {
                return response()->json([
                    'valid' => false,
                    'message' => 'File Excel kosong atau tidak valid'
                ]);
            }

            $headers = array_keys($data[0][0] ?? []);
            $requiredHeaders = [
                'no_kk',
                'nama_kepala_keluarga',
                'alamat',
                'rt',
                'rw',
                'desa',
                'kecamatan',
                'kabupaten',
                'provinsi',
                'kode_pos'
            ];

            $missingHeaders = array_diff($requiredHeaders, $headers);

            if (!empty($missingHeaders)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Header tidak lengkap. Missing: ' . implode(', ', $missingHeaders)
                ]);
            }

            $rowCount = count($data[0]) - 1; // Exclude header row

            return response()->json([
                'valid' => true,
                'message' => 'File valid',
                'preview' => [
                    'headers' => $headers,
                    'row_count' => $rowCount,
                    'sample_data' => array_slice($data[0], 1, 3) // First 3 rows as preview
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Error validating file: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get import progress (for real-time updates)
     */
    public function getImportProgress(Request $request)
    {
        $sessionKey = $request->get('session_key');

        // This would typically use cache or session to track progress
        // For now, return a simple response
        return response()->json([
            'progress' => 100,
            'status' => 'completed',
            'message' => 'Import completed'
        ]);
    }
}
