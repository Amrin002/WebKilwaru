@extends('layouts.main')

@section('title', $titleHeader)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $titleHeader }}</h1>
            <a href="{{ str_contains($titleHeader, 'KK') ? route('admin.kk.index') : route('admin.penduduk.index') }}"
                class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        @if (count($failures) > 0)
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Error Validasi ({{ count($failures) }} baris)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="80">Baris</th>
                                    <th width="150">Kolom</th>
                                    <th>Error</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($failures as $failure)
                                    <tr>
                                        <td>
                                            <span class="badge bg-danger">{{ $failure->row() }}</span>
                                        </td>
                                        <td>
                                            <code>{{ $failure->attribute() }}</code>
                                        </td>
                                        <td>
                                            @foreach ($failure->errors() as $error)
                                                <div class="text-danger small">{{ $error }}</div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="text-muted font-monospace">
                                                @if (is_array($failure->values()))
                                                    {{ $failure->values()[$failure->attribute()] ?? '-' }}
                                                @else
                                                    {{ $failure->values() ?? '-' }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Error Sistem ({{ count($errors) }} error)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>Error Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($errors as $index => $error)
                                    <tr>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <code class="text-danger">{{ $error }}</code>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (count($failures) == 0 && count($errors) == 0)
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Tidak Ada Error</h4>
                    <p class="text-muted">Semua data berhasil diimport tanpa error.</p>
                </div>
            </div>
        @endif

        <!-- Tips Section -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Tips Mengatasi Error
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Error Validasi Umum:</h6>
                        <ul class="small">
                            <li><strong>unique:</strong> Data sudah ada di sistem</li>
                            <li><strong>required:</strong> Kolom wajib diisi</li>
                            <li><strong>size:</strong> Panjang karakter tidak sesuai</li>
                            <li><strong>exists:</strong> Data referensi tidak ditemukan</li>
                            <li><strong>in:</strong> Nilai tidak sesuai pilihan yang tersedia</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Cara Mengatasi:</h6>
                        <ul class="small">
                            <li>Periksa format data sesuai template</li>
                            <li>Pastikan NIK/No.KK belum terdaftar</li>
                            <li>Gunakan format tanggal DD/MM/YYYY</li>
                            <li>Periksa nilai enum (Jenis Kelamin, dll)</li>
                            <li>Download template terbaru jika perlu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .font-monospace {
            font-family: 'Courier New', monospace;
        }
    </style>
@endsection
