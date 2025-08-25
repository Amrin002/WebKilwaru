{{-- APBDes Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* APBDes Management Styles */
        .page-header {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .page-title {
            color: var(--light-green);
        }

        .page-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
        }

        [data-theme="dark"] .breadcrumb-item a {
            color: var(--light-green);
        }

        .breadcrumb-item.active {
            color: var(--soft-gray);
        }

        /* Statistics Cards */
        .apbdes-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .apbdes-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .apbdes-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .apbdes-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin-bottom: 15px;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #4a7c59, #8fbc8f);
        }

        .stat-icon.latest {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.budget {
            background: linear-gradient(135deg, #2d5016, #4a7c59);
        }

        .stat-icon.files {
            background: linear-gradient(135deg, #6c757d, #8e9297);
        }

        .stat-icon.image {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            line-height: 1;
            margin-bottom: 5px;
        }

        [data-theme="dark"] .stat-number {
            color: var(--light-green);
        }

        .stat-label {
            color: var(--soft-gray);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Action Section */
        .action-section {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .action-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }

        .action-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .action-title {
            color: var(--light-green);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            border-color: var(--primary-green);
            transform: translateY(-2px);
        }

        [data-theme="dark"] .btn-outline-primary {
            color: var(--light-green);
            border-color: var(--light-green);
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background: var(--light-green);
            border-color: var(--light-green);
            color: var(--primary-green);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
        }

        /* Data Table */
        .data-table-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .table-title {
            color: var(--light-green);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px 12px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            color: inherit;
            vertical-align: middle;
        }

        [data-theme="dark"] .table tbody td {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        .table tbody tr:hover {
            background: var(--cream);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        .budget-amount {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
        }

        [data-theme="dark"] .budget-amount {
            color: var(--light-green);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* File Status Indicators */
        .file-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .file-indicator.has-file {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .file-indicator.no-file {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--soft-gray);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h5 {
            margin-bottom: 10px;
            color: var(--primary-green);
        }

        [data-theme="dark"] .empty-state h5 {
            color: var(--light-green);
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-left-color: #28a745;
            color: #155724;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: #721c24;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: #856404;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .apbdes-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-responsive {
                border-radius: 12px;
            }

            .action-section {
                padding: 20px;
            }

            .data-table-container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .btn-sm {
                width: 100%;
                font-size: 0.75rem;
            }

            .action-header {
                flex-direction: column;
                gap: 15px;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
        }

        @media (max-width: 576px) {
            .apbdes-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Transparansi</li>
                    <li class="breadcrumb-item active">APBDes</li>
                </ol>
            </nav>
            <h1 class="page-title">
                <i class="bi bi-bank me-3"></i>{{ $titleHeader }}
            </h1>
            <p class="page-subtitle">Kelola data Anggaran Pendapatan dan Belanja Desa untuk transparansi kepada masyarakat
            </p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="apbdes-stats">
            <div class="apbdes-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-calendar3"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['total_apbdes']) }}</div>
                <div class="stat-label">Total APBDes</div>
            </div>
            <div class="apbdes-stat-card">
                <div class="stat-icon latest">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="stat-number">{{ $statistics['tahun_terbaru'] ?? '-' }}</div>
                <div class="stat-label">Tahun Terbaru</div>
            </div>
            <div class="apbdes-stat-card">
                <div class="stat-icon budget">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['total_anggaran_terbaru'] / 1000000000, 1) }}M</div>
                <div class="stat-label">Total Anggaran</div>
            </div>
            <div class="apbdes-stat-card">
                <div class="stat-icon files">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div class="stat-number">{{ $statistics['dengan_pdf'] }}</div>
                <div class="stat-label">Dengan PDF</div>
            </div>
            <div class="apbdes-stat-card">
                <div class="stat-icon image">
                    <i class="bi bi-image"></i>
                </div>
                <div class="stat-number">{{ $statistics['dengan_baliho'] }}</div>
                <div class="stat-label">Dengan Baliho</div>
            </div>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <div class="action-header">
                <h4 class="action-title">
                    <i class="bi bi-gear me-2"></i>Manajemen APBDes
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.apbdes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah APBDes Baru
                    </a>
                    <a href="{{ route('apbdes.index') }}" class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-eye me-2"></i>Lihat Public View
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-table me-2"></i>Daftar APBDes
                </h4>
                @if ($apbdesList->total() > 0)
                    <div class="text-muted">
                        Menampilkan {{ $apbdesList->firstItem() }} - {{ $apbdesList->lastItem() }} dari
                        {{ $apbdesList->total() }} data
                    </div>
                @endif
            </div>

            @if ($apbdesList->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Total Anggaran</th>
                                <th>Breakdown Anggaran</th>
                                <th>Dokumen</th>
                                <th>Baliho</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apbdesList as $apbdes)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary fs-6">{{ $apbdes->tahun }}</span>
                                    </td>
                                    <td>
                                        <div class="budget-amount">{{ $apbdes->total_anggaran_formatted }}</div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <div>Pemerintahan: Rp
                                                {{ number_format($apbdes->pemerintahan_desa, 0, ',', '.') }}</div>
                                            <div>Pembangunan: Rp
                                                {{ number_format($apbdes->pembangunan_desa, 0, ',', '.') }}</div>
                                            <div>Kemasyarakatan: Rp
                                                {{ number_format($apbdes->kemasyarakatan, 0, ',', '.') }}</div>
                                            <div>Pemberdayaan: Rp {{ number_format($apbdes->pemberdayaan, 0, ',', '.') }}
                                            </div>
                                            <div>Bencana: Rp {{ number_format($apbdes->bencana_darurat, 0, ',', '.') }}
                                            </div>
                                        </small>
                                    </td>
                                    <td>
                                        @if ($apbdes->pdf_url)
                                            <div class="file-indicator has-file">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                                <span>Ada PDF</span>
                                            </div>
                                        @else
                                            <div class="file-indicator no-file">
                                                <i class="bi bi-file-earmark"></i>
                                                <span>Tidak Ada</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($apbdes->baliho_url)
                                            <div class="file-indicator has-file">
                                                <i class="bi bi-image"></i>
                                                <span>Ada Baliho</span>
                                            </div>
                                        @else
                                            <div class="file-indicator no-file">
                                                <i class="bi bi-image"></i>
                                                <span>Tidak Ada</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <small>{{ $apbdes->updated_at->diffForHumans() }}</small><br>
                                            <small>{{ $apbdes->updated_at->format('d M Y H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.apbdes.show', $apbdes) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.apbdes.edit', $apbdes) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if ($apbdes->pdf_url)
                                                <a href="{{ route('apbdes.download-pdf', $apbdes) }}"
                                                    class="btn btn-sm btn-success" title="Download PDF" target="_blank">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.apbdes.destroy', $apbdes) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus APBDes tahun {{ $apbdes->tahun }}? Data yang sudah dihapus tidak dapat dikembalikan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($apbdesList->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $apbdesList->firstItem() }} - {{ $apbdesList->lastItem() }} dari
                            {{ $apbdesList->total() }} data
                        </div>
                        {{ $apbdesList->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-bank"></i>
                    <h5>Belum Ada Data APBDes</h5>
                    <p class="mb-3">Belum ada data Anggaran Pendapatan dan Belanja Desa yang tersedia</p>
                    <a href="{{ route('admin.apbdes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah APBDes Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Format rupiah untuk display yang lebih baik
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        // Confirm delete dengan pesan yang jelas
        function confirmDelete(tahun) {
            return confirm(
                `Yakin ingin menghapus APBDes tahun ${tahun}?\n\nData yang sudah dihapus tidak dapat dikembalikan!\nTermasuk file PDF dan gambar baliho yang terupload.`
            );
        }
    </script>
@endpush
