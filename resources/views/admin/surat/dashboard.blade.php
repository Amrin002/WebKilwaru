@extends('layouts.main')

@push('style')
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            height: 400px;
            padding: 15px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chart-container canvas {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            max-width: 100%;
            max-height: 100%;
        }

        .activity-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chart-title {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        /* Loading state yang lebih baik */
        .chart-container::before {
            content: "Memuat chart...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #6b7280;
            font-size: 14px;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Sembunyikan loading ketika chart sudah loaded */
        .chart-container.loaded::before {
            display: none !important;
        }

        /* Pastikan canvas terlihat */
        .chart-container canvas {
            position: relative !important;
            z-index: 2;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
                padding: 10px;
            }

            .chart-title {
                font-size: 1rem;
            }
        }

        /* Fix untuk Bootstrap grid */
        .row .col-lg-7,
        .row .col-lg-5,
        .row .col-lg-12 {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Styling untuk stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--warm-white, #fefefe);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green, #2d5016), var(--accent-orange, #ff8c42));
            border-radius: 20px 20px 0 0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--soft-gray, #6c757d);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.population {
            background: linear-gradient(135deg, #4a7c59, #8fbc8f);
        }

        .stat-icon.families {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.success {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .stat-icon.warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .stat-icon.danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .stat-icon.info {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green, #2d5016);
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        /* Activity item styling */
        .activity-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .activity-icon.success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .activity-icon.warning {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .activity-icon.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .activity-icon.info {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .activity-time {
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Permohonan</div>
                    <div class="stat-icon population">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalPermohonan, 0, ',', '.') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Disetujui</div>
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalDisetujui, 0, ',', '.') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Diproses</div>
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalDiproses, 0, ',', '.') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Ditolak</div>
                    <div class="stat-icon danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalDitolak, 0, ',', '.') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Arsip Surat</div>
                    <div class="stat-icon families">
                        <i class="fas fa-archive"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalArsip, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="activity-card">
                    <h3 class="chart-title mb-3">Tren Permohonan Surat per Bulan ({{ date('Y') }})</h3>
                    <div class="chart-container loaded" style="position: relative; height: 400px; width: 100%;">
                        <canvas id="permohonanChart" width="800" height="400"
                            style="display: block; box-sizing: border-box;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="activity-card">
                    <h3 class="chart-title mb-3">Aktivitas Terbaru</h3>
                    @if ($latestActivities->isEmpty())
                        <p>Tidak ada aktivitas terbaru.</p>
                    @else
                        @foreach ($latestActivities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon {{ $activity->status_class }}">
                                    @php
                                        // Konversi icon class ke Font Awesome
                                        $iconMapping = [
                                            'fa-file-lines' => 'fa-file-alt',
                                            'fa-check' => 'fa-check',
                                            'fa-clock' => 'fa-clock',
                                            'fa-xmark' => 'fa-times',
                                            'fa-certificate' => 'fa-certificate',
                                            'fa-circle-check' => 'fa-check-circle',
                                            'fa-box-archive' => 'fa-archive',
                                            'fa-eye' => 'fa-eye',
                                            'fa-edit' => 'fa-edit',
                                            'fa-trash' => 'fa-trash',
                                            'fa-plus' => 'fa-plus',
                                            'fa-download' => 'fa-download',
                                            'fa-upload' => 'fa-upload',
                                            'fa-user' => 'fa-user',
                                            'fa-users' => 'fa-users',
                                        ];

                                        $iconClass = $iconMapping[$activity->icon_class] ?? 'fa-circle';
                                    @endphp
                                    <i class="fas {{ $iconClass }}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $activity->jenis_aktivitas }}</div>
                                    <div class="activity-time">{{ $activity->timestamp->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="quick-actions mt-4">
            <a href="{{ route('admin.surat-ktm.create') }}" class="action-btn">
                <i class="fas fa-file"></i>
                <span>Buat Surat KTM Baru</span>
            </a>
            <a href="{{ route('admin.surat-ktu.create') }}" class="action-btn">
                <i class="fas fa-file"></i>
                <span>Buat Surat KTU Baru</span>
            </a>
            <a href="{{ route('admin.surat-ktm.index') }}" class="action-btn">
                <i class="fas fa-list-alt"></i>
                <span>Daftar Permohonan</span>
            </a>
            <a href="#" class="action-btn">
                <i class="fas fa-qrcode"></i>
                <span>Log Verifikasi</span>
            </a>
        </div>

        <style>
            /* Quick Actions Styling */
            .quick-actions {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-top: 30px;
            }

            .action-btn {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 25px 20px;
                background: var(--warm-white, #fefefe);
                border: 2px solid rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                text-decoration: none;
                color: var(--primary-green, #2d5016);
                transition: all 0.3s ease;
                text-align: center;
            }

            .action-btn:hover {
                border-color: var(--accent-orange, #ff8c42);
                color: var(--accent-orange, #ff8c42);
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                text-decoration: none;
            }

            .action-btn i {
                font-size: 2rem;
                margin-bottom: 10px;
                display: block;
            }

            .action-btn span {
                font-weight: 600;
                font-size: 0.9rem;
            }
        </style>
    </div>
@endsection

@push('script')
    <script>
        setTimeout(function() {
            const permohonanData = {!! json_encode($permohonanPerBulan) !!};

            if (typeof Chart === 'undefined') {
                console.error('❌ Chart.js is not available.');
                return;
            }

            const canvas1 = document.getElementById('permohonanChart');
            if (canvas1) {
                try {
                    const ctx1 = canvas1.getContext('2d');

                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: permohonanData.labels,
                            datasets: [{
                                label: 'Total Permohonan',
                                data: permohonanData.datasets.total,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                pointBackgroundColor: '#3b82f6',
                                pointRadius: 5,
                                fill: true
                            }, {
                                label: 'Surat KTM',
                                data: permohonanData.datasets.ktm,
                                borderColor: '#ef4444',
                                borderWidth: 2,
                                tension: 0.4,
                                pointRadius: 4
                            }, {
                                label: 'Surat KTU',
                                data: permohonanData.datasets.ktu,
                                borderColor: '#10b981',
                                borderWidth: 2,
                                tension: 0.4,
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Tren Permohonan Surat per Bulan ({{ date('Y') }})',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    padding: 20
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 2
                                    },
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });

                    console.log('✅ Chart has been successfully created!');
                } catch (error) {
                    console.error('❌ Error creating chart:', error);
                }
            } else {
                console.error('❌ Canvas element not found.');
            }
        }, 200);
    </script>
@endpush
