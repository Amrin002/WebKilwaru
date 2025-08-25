@extends('layouts.main')

@section('content')
    <div class="dashboard-content">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="header-title mb-2">{{ $titleHeader }}</h2>
                <p class="text-muted mb-0">Kelola data pejabat dan struktur organisasi desa</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.struktur-desa.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Pejabat
                </a>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots"></i> Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.struktur-desa.export') }}">
                                <i class="bi bi-download"></i> Export CSV
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.struktur-desa.print') }}" target="_blank">
                                <i class="bi bi-printer"></i> Cetak Struktur
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Pejabat</div>
                    <div class="stat-icon population">
                        <i class="bi bi-person-badge"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $statistics['total_pejabat'] }}</div>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    {{ $statistics['aktif'] }} Aktif
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Kepala Desa</div>
                    <div class="stat-icon services">
                        <i class="bi bi-award"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $statistics['kepala_desa'] }}</div>
                <div class="stat-change positive">
                    <i class="bi bi-check-circle"></i>
                    Aktif
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Perangkat Desa</div>
                    <div class="stat-icon families">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $statistics['kaur'] + $statistics['kasi'] + $statistics['sekretaris'] }}</div>
                <div class="stat-change">
                    <i class="bi bi-briefcase"></i>
                    Kaur & Kasi
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Masa Jabatan Rata-rata</div>
                    <div class="stat-icon news">
                        <i class="bi bi-clock"></i>
                    </div>
                </div>
                <div class="stat-number" style="font-size: 1.5rem;">{{ $statistics['masa_jabatan_rata_rata'] }}</div>
                <div class="stat-change">
                    <i class="bi bi-calendar"></i>
                    Periode
                </div>
            </div>
        </div>

        <!-- Filter and Search Section -->
        <div class="activity-card mb-4">
            <form method="GET" action="{{ route('admin.struktur-desa.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, posisi, atau kategori...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori Jabatan</label>
                    <select class="form-select" name="kategori">
                        <option value="all">Semua Kategori</option>
                        @foreach ($kategoriList as $key => $value)
                            <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="aktif">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Data Table -->
        <div class="activity-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="chart-title mb-0">Daftar Pejabat Desa</h5>
                <div class="d-flex gap-2">
                    <!-- Bulk Actions -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" id="bulkActionsBtn" disabled>
                            <i class="bi bi-check2-square"></i> Aksi Terpilih
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="submitBulkAction('activate')">
                                    <i class="bi bi-check-circle text-success"></i> Aktifkan
                                </a></li>
                            <li><a class="dropdown-item" href="#" onclick="submitBulkAction('deactivate')">
                                    <i class="bi bi-x-circle text-warning"></i> Nonaktifkan
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="submitBulkAction('delete')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if ($strukturDesa->count() > 0)
                <!-- Bulk Actions Form -->
                <form id="bulkActionsForm" action="{{ route('admin.struktur-desa.bulk-action') }}" method="POST"
                    style="display: none;">
                    @csrf
                    <input type="hidden" name="action" id="bulkAction">
                    <input type="hidden" name="selected_ids" id="selectedIds">
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th width="80">Foto</th>
                                <th>Nama & Posisi</th>
                                <th>Kategori</th>
                                <th>Kontak</th>
                                <th>Status</th>
                                <th>Masa Jabatan</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($strukturDesa as $pejabat)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input select-item" type="checkbox"
                                                value="{{ $pejabat->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $pejabat->image_url }}" alt="{{ $pejabat->nama }}"
                                                class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $pejabat->nama }}</h6>
                                            <p class="text-muted mb-1 small">{{ $pejabat->posisi }}</p>
                                            @if ($pejabat->pendidikan_terakhir)
                                                <small class="text-info">{{ $pejabat->pendidikan_terakhir }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $pejabat->kategori_display }}</span>
                                        <div class="small text-muted">Urutan: {{ $pejabat->urutan }}</div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            @if ($pejabat->telepon)
                                                <div><i class="bi bi-telephone"></i> {{ $pejabat->telepon }}</div>
                                            @endif
                                            @if ($pejabat->email)
                                                <div><i class="bi bi-envelope"></i> {{ $pejabat->email }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            @if ($pejabat->aktif)
                                                <span class="badge bg-success mb-1">{{ $pejabat->status_jabatan }}</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary mb-1">{{ $pejabat->status_jabatan }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            @if ($pejabat->mulai_menjabat)
                                                <div class="text-muted">
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{ $pejabat->mulai_menjabat->format('d M Y') }}
                                                </div>
                                            @endif
                                            @if ($pejabat->masa_jabatan)
                                                <div class="text-info">
                                                    <i class="bi bi-clock"></i> {{ $pejabat->masa_jabatan }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.struktur-desa.show', $pejabat) }}"
                                                class="btn btn-outline-primary btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.struktur-desa.edit', $pejabat) }}"
                                                class="btn btn-outline-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST"
                                                            action="{{ route('admin.struktur-desa.toggle-status', $pejabat) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                @if ($pejabat->aktif)
                                                                    <i class="bi bi-x-circle text-warning"></i> Nonaktifkan
                                                                @else
                                                                    <i class="bi bi-check-circle text-success"></i>
                                                                    Aktifkan
                                                                @endif
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form method="POST"
                                                            action="{{ route('admin.struktur-desa.destroy', $pejabat) }}"
                                                            onsubmit="return confirm('Yakin ingin menghapus pejabat ini?')"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $strukturDesa->firstItem() }} - {{ $strukturDesa->lastItem() }}
                        dari {{ $strukturDesa->total() }} pejabat
                    </div>
                    {{ $strukturDesa->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-person-x display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Belum ada data pejabat</h5>
                    <p class="text-muted">Mulai dengan menambahkan pejabat desa baru</p>
                    <a href="{{ route('admin.struktur-desa.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Pejabat Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('script')
        <script>
            // Bulk Actions Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('selectAll');
                const selectItemCheckboxes = document.querySelectorAll('.select-item');
                const bulkActionsBtn = document.getElementById('bulkActionsBtn');

                // Select All functionality
                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        selectItemCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateBulkActionsButton();
                    });
                }

                // Individual checkbox functionality
                selectItemCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAllCheckbox();
                        updateBulkActionsButton();
                    });
                });

                function updateSelectAllCheckbox() {
                    const checkedCount = document.querySelectorAll('.select-item:checked').length;
                    const totalCount = selectItemCheckboxes.length;

                    selectAllCheckbox.checked = checkedCount === totalCount;
                    selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
                }

                function updateBulkActionsButton() {
                    const checkedCount = document.querySelectorAll('.select-item:checked').length;
                    bulkActionsBtn.disabled = checkedCount === 0;

                    if (checkedCount > 0) {
                        bulkActionsBtn.innerHTML =
                            `<i class="bi bi-check2-square"></i> Aksi Terpilih (${checkedCount})`;
                    } else {
                        bulkActionsBtn.innerHTML = '<i class="bi bi-check2-square"></i> Aksi Terpilih';
                    }
                }
            });

            // Submit bulk action
            function submitBulkAction(action) {
                const checkedBoxes = document.querySelectorAll('.select-item:checked');

                if (checkedBoxes.length === 0) {
                    alert('Pilih minimal satu pejabat!');
                    return;
                }

                const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

                let confirmMessage = '';
                switch (action) {
                    case 'activate':
                        confirmMessage = `Aktifkan ${selectedIds.length} pejabat terpilih?`;
                        break;
                    case 'deactivate':
                        confirmMessage = `Nonaktifkan ${selectedIds.length} pejabat terpilih?`;
                        break;
                    case 'delete':
                        confirmMessage = `Hapus ${selectedIds.length} pejabat terpilih? Tindakan ini tidak dapat dibatalkan!`;
                        break;
                }

                if (confirm(confirmMessage)) {
                    document.getElementById('bulkAction').value = action;
                    document.getElementById('selectedIds').value = JSON.stringify(selectedIds);
                    document.getElementById('bulkActionsForm').submit();
                }
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        </script>
    @endpush

    @push('style')
        <style>
            .table th {
                border-top: none;
                font-weight: 600;
                color: var(--primary-green);
                background: var(--cream) !important;
            }

            .table td {
                vertical-align: middle;
            }

            .btn-group .dropdown-toggle {
                border-left: none;
            }

            .badge {
                font-size: 0.75em;
            }

            .form-check-input:checked {
                background-color: var(--accent-orange);
                border-color: var(--accent-orange);
            }

            .activity-card .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }

            .dropdown-menu {
                border-radius: 10px;
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .pagination .page-link {
                color: var(--primary-green);
                border-color: var(--cream);
            }

            .pagination .page-item.active .page-link {
                background-color: var(--accent-orange);
                border-color: var(--accent-orange);
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            img.rounded-circle {
                border: 2px solid var(--cream);
            }
        </style>
    @endpush
@endsection
