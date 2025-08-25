@extends('layouts.main')

@push('style')
    <style>
        .stats-overview {
            margin-bottom: 30px;
        }

        .filter-section {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .filter-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .chart-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            min-height: 400px;
        }

        .chart-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .chart-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--cream);
            transition: color 0.3s ease;
        }

        [data-theme="dark"] .chart-title {
            color: var(--light-green);
        }

        .surat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .surat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .surat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }

        .surat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .surat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--cream);
            transition: all 0.3s ease;
        }

        .surat-item:last-child {
            border-bottom: none;
        }

        .surat-item:hover {
            background: var(--cream);
            margin: 0 -10px;
            padding: 10px;
            border-radius: 8px;
        }

        .surat-label {
            font-weight: 500;
            color: var(--soft-gray);
        }

        .surat-value {
            font-weight: 600;
            color: var(--primary-green);
            transition: color 0.3s ease;
        }

        [data-theme="dark"] .surat-value {
            color: var(--light-green);
        }

        .surat-percentage {
            font-size: 0.9rem;
            color: var(--accent-orange);
            margin-left: 8px;
        }

        .export-section {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .export-btn {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
            color: white;
        }

        .export-btn.orange {
            background: linear-gradient(135deg, var(--accent-orange), #ff7b2c);
        }

        .export-btn.orange:hover {
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid var(--cream);
            padding: 10px 15px;
            transition: all 0.3s ease;
            background: var(--warm-white);
            color: inherit;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            background: var(--warm-white);
            color: inherit;
        }

        .btn-filter {
            background: var(--accent-orange);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background: #ff7b2c;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(255, 140, 66, 0.3);
            color: white;
        }

        .recent-table {
            background: var(--warm-white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
        }

        .table {
            margin: 0;
            color: inherit;
        }

        .table th {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
            padding: 15px;
            border: none;
            text-align: center;
        }

        .table td {
            padding: 12px 15px;
            border-color: var(--cream);
            text-align: center;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--cream);
        }

        .badge-kategori {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-masuk {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge-keluar {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
        }

        .chart-placeholder {
            width: 100%;
            height: 300px;
            background: var(--cream);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--soft-gray);
            font-size: 1.1rem;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .chart-placeholder canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        [data-theme="dark"] .summary-value {
            color: var(--light-green);
        }

        .summary-label {
            font-size: 0.9rem;
            color: var(--soft-gray);
            font-weight: 500;
        }

        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .icon-masuk {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .icon-keluar {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
        }

        .icon-total {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        }

        .icon-tahun {
            background: linear-gradient(135deg, var(--accent-orange), #ff7b2c);
        }

        .tabs-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .custom-tabs {
            border-bottom: 2px solid var(--cream);
            margin-bottom: 20px;
        }

        .custom-tab {
            background: none;
            border: none;
            padding: 10px 20px;
            margin-right: 10px;
            border-radius: 10px 10px 0 0;
            color: var(--soft-gray);
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .custom-tab.active {
            background: var(--accent-orange);
            color: white;
        }

        .custom-tab:hover:not(.active) {
            background: var(--cream);
            color: var(--primary-green);
        }

        .tab-content {
            min-height: 300px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .growth-indicator {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .growth-up {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .growth-down {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .growth-neutral {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .surat-grid {
                grid-template-columns: 1fr;
            }

            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-section .row {
                flex-direction: column;
            }

            .filter-section .col-md-3 {
                margin-bottom: 15px;
            }

            .export-section {
                text-align: left;
            }

            .export-btn {
                display: block;
                margin: 10px 0;
                text-align: center;
            }

            .table-responsive {
                margin: 0 -15px;
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
                    <li class="breadcrumb-item">Administrasi</li>
                    <li class="breadcrumb-item active">Statistik Arsip Surat</li>
                </ol>
            </nav>
            <h1 class="page-title">Statistik Arsip Surat</h1>
            <p class="page-subtitle">Analisis data dan statistik arsip surat</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h5 class="chart-title mb-3">
                <i class="bi bi-funnel me-2"></i>Filter Data
            </h5>
            <form method="GET" action="{{ route('admin.arsip-surat.statistik') }}">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select class="form-select" id="tahun" name="tahun">
                            @foreach ($tahunList as $tahunOption)
                                <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                    {{ $tahunOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="">Semua Kategori</option>
                            <option value="masuk" {{ request('kategori') == 'masuk' ? 'selected' : '' }}>Surat Masuk
                            </option>
                            <option value="keluar" {{ request('kategori') == 'keluar' ? 'selected' : '' }}>Surat Keluar
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="bi bi-search me-2"></i>Filter Data
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-icon icon-total">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="summary-value">{{ number_format($totalPerKategori['total']) }}</div>
                <div class="summary-label">Total Arsip Surat</div>
            </div>
            <div class="summary-card">
                <div class="summary-icon icon-masuk">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="summary-value">{{ number_format($totalPerKategori['surat_masuk']) }}</div>
                <div class="summary-label">Surat Masuk</div>
            </div>
            <div class="summary-card">
                <div class="summary-icon icon-keluar">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div class="summary-value">{{ number_format($totalPerKategori['surat_keluar']) }}</div>
                <div class="summary-label">Surat Keluar</div>
            </div>
            <div class="summary-card">
                <div class="summary-icon icon-tahun">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="summary-value">{{ $tahun }}</div>
                <div class="summary-label">Tahun Aktif</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="tabs-container">
            <div class="custom-tabs">
                <button class="custom-tab active" data-tab="bulanan">
                    <i class="bi bi-bar-chart me-2"></i>Bulanan
                </button>
                <button class="custom-tab" data-tab="perbandingan">
                    <i class="bi bi-pie-chart me-2"></i>Perbandingan
                </button>
                <button class="custom-tab" data-tab="trend">
                    <i class="bi bi-graph-up me-2"></i>Trend
                </button>
            </div>

            <div class="tab-content">
                <!-- Bulanan Tab -->
                <div class="tab-pane active" id="bulanan">
                    <div class="chart-container">
                        <h5 class="chart-title">
                            <i class="bi bi-bar-chart me-2"></i>Statistik Bulanan {{ $tahun }}
                        </h5>
                        <div class="chart-placeholder" id="chartBulanan">
                            <canvas id="chartBulananCanvas"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Perbandingan Tab -->
                <div class="tab-pane" id="perbandingan">
                    <div class="chart-container">
                        <h5 class="chart-title">
                            <i class="bi bi-pie-chart me-2"></i>Perbandingan Kategori Surat
                        </h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-placeholder" id="chartPerbandingan">
                                    <canvas id="chartPerbandinganCanvas"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="surat-card">
                                    <h6 class="chart-title">Detail Perbandingan</h6>
                                    <div class="surat-item">
                                        <span class="surat-label">Surat Masuk</span>
                                        <div>
                                            <span
                                                class="surat-value">{{ number_format($totalPerKategori['surat_masuk']) }}</span>
                                            <span class="surat-percentage">
                                                ({{ $totalPerKategori['total'] > 0 ? number_format(($totalPerKategori['surat_masuk'] / $totalPerKategori['total']) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="surat-item">
                                        <span class="surat-label">Surat Keluar</span>
                                        <div>
                                            <span
                                                class="surat-value">{{ number_format($totalPerKategori['surat_keluar']) }}</span>
                                            <span class="surat-percentage">
                                                ({{ $totalPerKategori['total'] > 0 ? number_format(($totalPerKategori['surat_keluar'] / $totalPerKategori['total']) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="surat-item">
                                        <span class="surat-label">Rasio Masuk/Keluar</span>
                                        <div>
                                            <span class="surat-value">
                                                @if ($totalPerKategori['surat_keluar'] > 0)
                                                    {{ number_format($totalPerKategori['surat_masuk'] / $totalPerKategori['surat_keluar'], 2) }}:1
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trend Tab -->
                <div class="tab-pane" id="trend">
                    <div class="chart-container">
                        <h5 class="chart-title">
                            <i class="bi bi-graph-up me-2"></i>Trend Arsip Surat
                        </h5>
                        <div class="chart-placeholder" id="chartTrend">
                            <canvas id="chartTrendCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Letters Table -->
        <div class="chart-container">
            <h5 class="chart-title">
                <i class="bi bi-clock-history me-2"></i>Arsip Surat Terbaru
            </h5>
            <div class="table-responsive">
                <table class="table recent-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Pengirim/Tujuan</th>
                            <th>Perihal/Tentang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratTerbaru as $index => $surat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $surat->nomor_surat }}</strong></td>
                                <td>{{ $surat->tanggal_surat_formatted }}</td>
                                <td>
                                    <span
                                        class="badge-kategori {{ $surat->kategori_surat === 'masuk' ? 'badge-masuk' : 'badge-keluar' }}">
                                        <i
                                            class="bi bi-{{ $surat->kategori_surat === 'masuk' ? 'arrow-down' : 'arrow-up' }}-circle me-1"></i>
                                        {{ ucfirst($surat->kategori_surat) }}
                                    </span>
                                </td>
                                <td>{{ $surat->pihak_terkait }}</td>
                                <td>{{ Str::limit($surat->konten_utama, 50) }}</td>
                                <td>
                                    <a href="{{ route('admin.arsip-surat.show', $surat->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data arsip surat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Export Section -->
        <div class="export-section">
            <h5 class="chart-title mb-3">
                <i class="bi bi-download me-2"></i>Export Data
            </h5>
            <p class="text-muted mb-4">Unduh data statistik arsip surat dalam berbagai format</p>

            <a href="{{ route('admin.arsip-surat.export') }}?tahun={{ $tahun }}" class="export-btn">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                Export CSV
            </a>

            <button type="button" class="export-btn orange" onclick="window.print()">
                <i class="bi bi-printer"></i>
                Print Statistik
            </button>

            <a href="{{ route('admin.arsip-surat.index') }}" class="export-btn"
                style="background: linear-gradient(135deg, #6c757d, #495057);">
                <i class="bi bi-table"></i>
                Lihat Semua Data
            </a>
        </div>
    </div>
@endsection

@push('script')
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari PHP ke JavaScript
            const bulanLabels = @json($bulanLabels);
            const dataMasuk = @json($dataMasuk);
            const dataKeluar = @json($dataKeluar);
            const totalPerKategori = @json($totalPerKategori);

            // Tab functionality
            const tabs = document.querySelectorAll('.custom-tab');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all tabs and panes
                    tabs.forEach(t => t.classList.remove('active'));
                    tabPanes.forEach(pane => pane.classList.remove('active'));

                    // Add active class to clicked tab and corresponding pane
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');

                    // Reinitialize charts when tab changes
                    setTimeout(() => {
                        initializeCharts();
                    }, 100);
                });
            });

            // Chart configurations
            const chartColors = {
                primary: getComputedStyle(document.documentElement).getPropertyValue('--primary-green').trim(),
                secondary: getComputedStyle(document.documentElement).getPropertyValue('--accent-orange')
                    .trim(),
                success: '#28a745',
                danger: '#dc3545',
                background: getComputedStyle(document.documentElement).getPropertyValue('--cream').trim()
            };

            function initializeCharts() {
                // Pastikan Chart.js sudah loaded
                if (typeof Chart === 'undefined') {
                    console.log('Chart.js belum loaded, menunggu...');
                    setTimeout(initializeCharts, 100);
                    return;
                }

                // Chart Bulanan
                const ctxBulanan = document.getElementById('chartBulananCanvas');
                if (ctxBulanan && ctxBulanan.offsetParent !== null) {
                    destroyChart('chartBulanan');
                    try {
                        window.chartBulanan = new Chart(ctxBulanan, {
                            type: 'bar',
                            data: {
                                labels: bulanLabels,
                                datasets: [{
                                    label: 'Surat Masuk',
                                    data: dataMasuk,
                                    backgroundColor: chartColors.success + '80',
                                    borderColor: chartColors.success,
                                    borderWidth: 2,
                                    borderRadius: 5
                                }, {
                                    label: 'Surat Keluar',
                                    data: dataKeluar,
                                    backgroundColor: chartColors.danger + '80',
                                    borderColor: chartColors.danger,
                                    borderWidth: 2,
                                    borderRadius: 5
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Distribusi Surat per Bulan'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error creating chart bulanan:', error);
                    }
                }

                // Chart Perbandingan (Pie Chart)
                const ctxPerbandingan = document.getElementById('chartPerbandinganCanvas');
                if (ctxPerbandingan && ctxPerbandingan.offsetParent !== null) {
                    destroyChart('chartPerbandingan');
                    try {
                        window.chartPerbandingan = new Chart(ctxPerbandingan, {
                            type: 'doughnut',
                            data: {
                                labels: ['Surat Masuk', 'Surat Keluar'],
                                datasets: [{
                                    data: [totalPerKategori.surat_masuk, totalPerKategori
                                        .surat_keluar
                                    ],
                                    backgroundColor: [chartColors.success + '80', chartColors
                                        .danger + '80'
                                    ],
                                    borderColor: [chartColors.success, chartColors.danger],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Perbandingan Kategori Surat'
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error creating chart perbandingan:', error);
                    }
                }

                // Chart Trend (Line Chart)
                const ctxTrend = document.getElementById('chartTrendCanvas');
                if (ctxTrend && ctxTrend.offsetParent !== null) {
                    destroyChart('chartTrend');
                    try {
                        window.chartTrend = new Chart(ctxTrend, {
                            type: 'line',
                            data: {
                                labels: bulanLabels,
                                datasets: [{
                                    label: 'Total Surat',
                                    data: dataMasuk.map((masuk, index) => masuk + dataKeluar[
                                        index]),
                                    backgroundColor: chartColors.primary + '20',
                                    borderColor: chartColors.primary,
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: chartColors.primary,
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5
                                }, {
                                    label: 'Surat Masuk',
                                    data: dataMasuk,
                                    backgroundColor: chartColors.success + '20',
                                    borderColor: chartColors.success,
                                    borderWidth: 2,
                                    fill: false,
                                    tension: 0.4
                                }, {
                                    label: 'Surat Keluar',
                                    data: dataKeluar,
                                    backgroundColor: chartColors.danger + '20',
                                    borderColor: chartColors.danger,
                                    borderWidth: 2,
                                    fill: false,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Trend Arsip Surat'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error creating chart trend:', error);
                    }
                }
            }

            function destroyChart(chartName) {
                if (window[chartName] && typeof window[chartName].destroy === 'function') {
                    window[chartName].destroy();
                    window[chartName] = null;
                }
            }

            // Initialize charts
            initializeCharts();

            // Reset filter function
            window.resetFilter = function() {
                window.location.href = "{{ route('admin.arsip-surat.statistik') }}";
            };

            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const tahun = document.getElementById('tahun').value;
                    if (!tahun) {
                        e.preventDefault();
                        alert('Silakan pilih tahun terlebih dahulu!');
                        return false;
                    }
                });
            }

            // Loading state untuk export buttons
            document.querySelectorAll('.export-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.getAttribute('onclick')) return; // Skip for print button

                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                    this.style.pointerEvents = 'none';

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.pointerEvents = 'auto';
                    }, 3000);
                });
            });

            // Dark/Light theme compatibility untuk charts
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                        updateChartTheme();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['data-theme']
            });

            function updateChartTheme() {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

                // Update chart colors based on theme
                const textColor = isDark ? '#ffffff' : '#333333';
                const gridColor = isDark ? '#444444' : '#e0e0e0';

                // Reinitialize charts with new theme colors
                setTimeout(() => {
                    initializeCharts();
                }, 100);
            }

            // Auto-refresh data setiap 5 menit untuk real-time updates
            let autoRefreshInterval;

            function startAutoRefresh() {
                autoRefreshInterval = setInterval(function() {
                    // AJAX call to refresh data
                    refreshStatistikData();
                }, 300000); // 5 menit
            }

            function stopAutoRefresh() {
                if (autoRefreshInterval) {
                    clearInterval(autoRefreshInterval);
                }
            }

            function refreshStatistikData() {
                const currentParams = new URLSearchParams(window.location.search);

                fetch(window.location.pathname + '?' + currentParams.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update summary cards
                            updateSummaryCards(data.totalPerKategori);

                            // Update charts data
                            updateChartsData(data.dataMasuk, data.dataKeluar);

                            // Show notification
                            showNotification('Data statistik berhasil diperbarui', 'success');
                        }
                    })
                    .catch(error => {
                        console.log('Auto-refresh error:', error);
                    });
            }

            function updateSummaryCards(data) {
                // Update summary card values
                const cards = document.querySelectorAll('.summary-card .summary-value');
                if (cards.length >= 4) {
                    cards[0].textContent = Number(data.total).toLocaleString();
                    cards[1].textContent = Number(data.surat_masuk).toLocaleString();
                    cards[2].textContent = Number(data.surat_keluar).toLocaleString();
                }
            }

            function updateChartsData(newDataMasuk, newDataKeluar) {
                // Update existing charts with new data
                if (window.chartBulanan) {
                    window.chartBulanan.data.datasets[0].data = newDataMasuk;
                    window.chartBulanan.data.datasets[1].data = newDataKeluar;
                    window.chartBulanan.update();
                }

                if (window.chartTrend) {
                    window.chartTrend.data.datasets[0].data = newDataMasuk.map((masuk, index) => masuk +
                        newDataKeluar[index]);
                    window.chartTrend.data.datasets[1].data = newDataMasuk;
                    window.chartTrend.data.datasets[2].data = newDataKeluar;
                    window.chartTrend.update();
                }
            }

            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 5000);
            }

            // Start auto-refresh
            startAutoRefresh();

            // Stop auto-refresh when user navigates away
            window.addEventListener('beforeunload', stopAutoRefresh);

            // Tooltips untuk summary cards
            document.querySelectorAll('.summary-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Enhanced table interactions
            document.querySelectorAll('.table tbody tr').forEach(row => {
                row.addEventListener('click', function(e) {
                    if (!e.target.closest('.btn')) {
                        // Highlight clicked row
                        document.querySelectorAll('.table tbody tr').forEach(r => r.classList
                            .remove('table-active'));
                        this.classList.add('table-active');
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + P for print
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }

                // Ctrl + E for export
                if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                    e.preventDefault();
                    const exportBtn = document.querySelector('.export-btn');
                    if (exportBtn) {
                        exportBtn.click();
                    }
                }

                // Ctrl + R for refresh
                if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                    e.preventDefault();
                    refreshStatistikData();
                }
            });

            // Print optimization
            window.addEventListener('beforeprint', function() {
                // Hide unnecessary elements for print
                document.querySelectorAll('.export-section, .page-header nav, .btn').forEach(el => {
                    el.style.display = 'none';
                });
            });

            window.addEventListener('afterprint', function() {
                // Restore elements after print
                document.querySelectorAll('.export-section, .page-header nav, .btn').forEach(el => {
                    el.style.display = '';
                });
            });

            // Chart interaction enhancements
            function addChartInteractions() {
                // Add click handlers for chart elements
                if (window.chartBulanan) {
                    window.chartBulanan.options.onClick = function(event, elements) {
                        if (elements.length > 0) {
                            const dataIndex = elements[0].index;
                            const month = dataIndex + 1;
                            const year = {{ $tahun }};

                            // Redirect to filtered view
                            const url = "{{ route('admin.arsip-surat.index') }}?tahun=" + year + "&bulan=" +
                                month;
                            window.open(url, '_blank');
                        }
                    };
                }
            }

            // Add chart interactions after initialization
            setTimeout(addChartInteractions, 500);

            // Responsive chart handling
            function handleResize() {
                setTimeout(() => {
                    if (window.chartBulanan) window.chartBulanan.resize();
                    if (window.chartPerbandingan) window.chartPerbandingan.resize();
                    if (window.chartTrend) window.chartTrend.resize();
                }, 100);
            }

            window.addEventListener('resize', handleResize);

            // Performance monitoring
            function logPerformance() {
                if (performance.mark) {
                    performance.mark('statistik-loaded');
                    console.log('Statistik Arsip Surat loaded successfully');
                }
            }

            // Log performance after everything is loaded
            setTimeout(logPerformance, 1000);

            console.log('Statistik Arsip Surat initialized with data:', {
                tahun: {{ $tahun }},
                totalSurat: {{ $totalPerKategori['total'] }},
                suratMasuk: {{ $totalPerKategori['surat_masuk'] }},
                suratKeluar: {{ $totalPerKategori['surat_keluar'] }}
            });
        });
    </script>
@endpush
