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

        .demographic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .demographic-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .demographic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .demographic-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--cream);
            transition: all 0.3s ease;
        }

        .demographic-item:last-child {
            border-bottom: none;
        }

        .demographic-item:hover {
            background: var(--cream);
            margin: 0 -10px;
            padding: 10px;
            border-radius: 8px;
        }

        .demographic-label {
            font-weight: 500;
            color: var(--soft-gray);
        }

        .demographic-value {
            font-weight: 600;
            color: var(--primary-green);
            transition: color 0.3s ease;
        }

        [data-theme="dark"] .demographic-value {
            color: var(--light-green);
        }

        .demographic-percentage {
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

        .growth-table {
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

        .growth-rate-positive {
            color: #28a745;
            font-weight: 600;
        }

        .growth-rate-negative {
            color: #dc3545;
            font-weight: 600;
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

        @media (max-width: 768px) {
            .demographic-grid {
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
        <!-- Filter Section -->
        <div class="filter-section">
            <h5 class="chart-title mb-3">
                <i class="bi bi-funnel me-2"></i>Filter Data
            </h5>
            <form method="GET" action="{{ route('admin.statistik.pertumbuhan') }}">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="period" class="form-label">Periode</label>
                        <select class="form-select" id="period" name="period">
                            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="quarterly" {{ $period == 'quarterly' ? 'selected' : '' }}>Triwulan</option>
                            <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="bi bi-search me-2"></i>Filter Data
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-value">{{ number_format($basicStats['total_penduduk']) }}</div>
                <div class="summary-label">Total Penduduk</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ number_format($basicStats['total_kk']) }}</div>
                <div class="summary-label">Total KK</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ number_format($basicStats['laki_laki']) }}</div>
                <div class="summary-label">Laki-laki</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ number_format($basicStats['perempuan']) }}</div>
                <div class="summary-label">Perempuan</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $basicStats['rata_rata_anggota_kk'] }}</div>
                <div class="summary-label">Rata-rata Anggota KK</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="tabs-container">
            <div class="custom-tabs">
                <button class="custom-tab active" data-tab="growth">
                    <i class="bi bi-graph-up me-2"></i>Pertumbuhan
                </button>
                <button class="custom-tab" data-tab="demographic">
                    <i class="bi bi-people me-2"></i>Demografi
                </button>
                <button class="custom-tab" data-tab="age">
                    <i class="bi bi-person-badge me-2"></i>Kelompok Umur
                </button>
                <button class="custom-tab" data-tab="regional">
                    <i class="bi bi-geo-alt me-2"></i>Regional
                </button>
            </div>

            <div class="tab-content">
                <!-- Growth Tab -->
                <div class="tab-pane active" id="growth">
                    <div class="chart-placeholder">
                        <div class="text-center">
                            <i class="bi bi-graph-up" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                            Grafik Pertumbuhan Penduduk
                            <div style="font-size: 0.9rem; margin-top: 5px;">
                                Data dari {{ date('d/m/Y', strtotime($startDate)) }} -
                                {{ date('d/m/Y', strtotime($endDate)) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demographic Tab -->
                <div class="tab-pane" id="demographic">
                    <div class="demographic-grid">
                        <!-- Agama -->
                        <div class="demographic-card">
                            <h6 class="chart-title">Berdasarkan Agama</h6>
                            @foreach ($demographicStats['agama'] as $agama)
                                <div class="demographic-item">
                                    <span class="demographic-label">{{ $agama->agama }}</span>
                                    <div>
                                        <span class="demographic-value">{{ number_format($agama->jumlah) }}</span>
                                        <span
                                            class="demographic-percentage">({{ number_format($agama->persentase, 1) }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pendidikan -->
                        <div class="demographic-card">
                            <h6 class="chart-title">Berdasarkan Pendidikan</h6>
                            @foreach ($demographicStats['pendidikan'] as $pendidikan)
                                <div class="demographic-item">
                                    <span class="demographic-label">{{ $pendidikan->pendidikan }}</span>
                                    <div>
                                        <span class="demographic-value">{{ number_format($pendidikan->jumlah) }}</span>
                                        <span
                                            class="demographic-percentage">({{ number_format($pendidikan->persentase, 1) }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Status Perkawinan -->
                        <div class="demographic-card">
                            <h6 class="chart-title">Status Perkawinan</h6>
                            @foreach ($demographicStats['status_perkawinan'] as $status)
                                <div class="demographic-item">
                                    <span class="demographic-label">{{ $status->status }}</span>
                                    <div>
                                        <span class="demographic-value">{{ number_format($status->jumlah) }}</span>
                                        <span
                                            class="demographic-percentage">({{ number_format($status->persentase, 1) }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pekerjaan -->
                        <div class="demographic-card">
                            <h6 class="chart-title">Top 10 Pekerjaan</h6>
                            @foreach ($demographicStats['pekerjaan'] as $pekerjaan)
                                <div class="demographic-item">
                                    <span class="demographic-label">{{ $pekerjaan->pekerjaan }}</span>
                                    <div>
                                        <span class="demographic-value">{{ number_format($pekerjaan->jumlah) }}</span>
                                        <span
                                            class="demographic-percentage">({{ number_format($pekerjaan->persentase, 1) }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Age Tab -->
                <div class="tab-pane" id="age">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="demographic-card">
                                <h6 class="chart-title">Distribusi Kelompok Umur</h6>
                                @foreach ($ageGroupStats['kelompok_umur'] as $kelompok)
                                    <div class="demographic-item">
                                        <span class="demographic-label">{{ $kelompok->kelompok_umur }}</span>
                                        <div>
                                            <span class="demographic-value">{{ number_format($kelompok->jumlah) }}</span>
                                            <span
                                                class="demographic-percentage">({{ number_format($kelompok->persentase, 1) }}%)</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="demographic-card">
                                <h6 class="chart-title">Rasio Ketergantungan</h6>
                                <div class="text-center">
                                    <div class="summary-value" style="font-size: 3rem;">
                                        {{ $ageGroupStats['dependency_ratio'] }}%</div>
                                    <div class="summary-label mb-3">Dependency Ratio</div>
                                    <div class="demographic-item">
                                        <span class="demographic-label">Usia Produktif (15-64)</span>
                                        <span
                                            class="demographic-value">{{ number_format($ageGroupStats['usia_produktif']) }}</span>
                                    </div>
                                    <div class="demographic-item">
                                        <span class="demographic-label">Usia Tidak Produktif</span>
                                        <span
                                            class="demographic-value">{{ number_format($ageGroupStats['usia_tidak_produktif']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regional Tab -->
                <div class="tab-pane" id="regional">
                    <div class="demographic-grid">
                        @if ($regionalStats['desa']->isNotEmpty())
                            <div class="demographic-card">
                                <h6 class="chart-title">Berdasarkan Desa</h6>
                                @foreach ($regionalStats['desa'] as $desa)
                                    <div class="demographic-item">
                                        <span class="demographic-label">{{ $desa->desa }}</span>
                                        <div>
                                            <span
                                                class="demographic-value">{{ number_format($desa->jumlah_penduduk) }}</span>
                                            <span class="demographic-percentage">({{ number_format($desa->jumlah_kk) }}
                                                KK)</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($regionalStats['kecamatan']->isNotEmpty())
                            <div class="demographic-card">
                                <h6 class="chart-title">Berdasarkan Kecamatan</h6>
                                @foreach ($regionalStats['kecamatan'] as $kecamatan)
                                    <div class="demographic-item">
                                        <span class="demographic-label">{{ $kecamatan->kecamatan }}</span>
                                        <div>
                                            <span
                                                class="demographic-value">{{ number_format($kecamatan->jumlah_penduduk) }}</span>
                                            <span
                                                class="demographic-percentage">({{ number_format($kecamatan->jumlah_kk) }}
                                                KK)</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Growth Data Table -->
        @if (!empty($growthData))
            <div class="chart-container">
                <h5 class="chart-title">
                    <i class="bi bi-table me-2"></i>Data Pertumbuhan Detail
                </h5>
                <div class="table-responsive">
                    <table class="table growth-table">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Penduduk Baru</th>
                                <th>KK Baru</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total Kumulatif</th>
                                <th>Growth Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($growthData as $data)
                                <tr>
                                    <td><strong>{{ $data['period'] }}</strong></td>
                                    <td>{{ number_format($data['penduduk_baru']) }}</td>
                                    <td>{{ number_format($data['kk_baru']) }}</td>
                                    <td>{{ number_format($data['laki_laki_baru']) }}</td>
                                    <td>{{ number_format($data['perempuan_baru']) }}</td>
                                    <td>{{ number_format($data['cumulative_penduduk']) }}</td>
                                    <td>
                                        <span
                                            class="{{ $data['growth_rate'] >= 0 ? 'growth-rate-positive' : 'growth-rate-negative' }}">
                                            {{ $data['growth_rate'] >= 0 ? '+' : '' }}{{ number_format($data['growth_rate'], 2) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pertumbuhan untuk periode yang
                                        dipilih</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Export Section -->
        <div class="export-section">
            <h5 class="chart-title mb-3">
                <i class="bi bi-download me-2"></i>Export Data
            </h5>
            <p class="text-muted mb-4">Unduh data statistik dalam berbagai format</p>

            <a href="{{ route('admin.statistik.pertumbuhan.export') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&period={{ $period }}"
                class="export-btn">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                Export CSV
            </a>

            <a href="{{ route('admin.statistik.pertumbuhan.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&period={{ $period }}"
                class="export-btn orange" target="_blank">
                <i class="bi bi-printer"></i>
                Print Laporan
            </a>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                });
            });

            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                        e.preventDefault();
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                        return false;
                    }
                });
            }

            // Auto-refresh data setiap 5 menit
            setInterval(function() {
                // Bisa ditambahkan AJAX call untuk refresh data real-time
                console.log('Auto refresh data...');
            }, 300000); // 5 menit

            // Smooth scrolling untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Loading state untuk export buttons
            document.querySelectorAll('.export-btn').forEach(btn => {
                btn.addEventListener('click', function() {
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
                        // Update chart colors based on theme
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
                console.log('Theme changed to:', isDark ? 'dark' : 'light');
            }

            // Tooltips untuk demographic items
            document.querySelectorAll('.demographic-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            console.log('Statistik Pertumbuhan loaded successfully');
        });
    </script>
@endpush
