<header class="header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="header-title">{{ $titleHeader }}</h1>
    </div>
    <div class="header-right">
        <div class="header-clock" id="headerClock">
            <div class="clock-time"></div>
            <div class="clock-date"></div>
        </div>
        <div class="notification-area">
            <button class="notification-btn" id="notificationBtn">
                <i class="bi bi-bell"></i>
                <span class="notification-badge" id="notificationBadge">{{ $unreadNotifications->count() }}</span>
            </button>

            <div class="notification-dropdown" id="notificationDropdown">
                <div class="dropdown-header">
                    Notifikasi
                    <form action="{{ route('notifications.mark-as-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="mark-all-read-btn">Tandai sudah dibaca</button>
                    </form>
                </div>
                <div class="dropdown-body">
                    @forelse($notifications as $notification)
                        @php
                            $route = '#';
                            $params = [];

                            // Tentukan rute berdasarkan jenis notifikasi
                            if ($notification->type === 'App\Notifications\SuratBaruNotification') {
                                // Periksa apakah data 'jenis_surat' tersedia
                                if (
                                    isset($notification->data['jenis_surat']) &&
                                    $notification->data['jenis_surat'] === 'SuratKtu'
                                ) {
                                    $route = 'admin.surat-ktu.show';
                                    $params = ['id' => $notification->data['surat_id']];
                                } elseif (
                                    isset($notification->data['jenis_surat']) &&
                                    $notification->data['jenis_surat'] === 'SuratKtm'
                                ) {
                                    $route = 'admin.surat-ktm.show';
                                    $params = ['id' => $notification->data['surat_id']];
                                }
                            } elseif ($notification->type === 'App\Notifications\UmkmPermohonanNotification') {
                                $route = 'admin.umkm.show';
                                $params = ['id' => $notification->data['umkm_id']];
                            }
                        @endphp
                        <a href="{{ route($route, $params) }}" class="dropdown-item">
                            <div class="icon">
                                <i
                                    class="{{ isset($notification->data['icon_class']) ? $notification->data['icon_class'] : 'bi bi-info-circle' }}"></i>
                            </div>
                            <div class="content">
                                <div class="title">{{ $notification->data['pesan'] }}</div>
                                <small class="timestamp">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @empty
                        <div class="dropdown-item">Tidak ada notifikasi baru.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="user-profile" id="userProfile">
            <div class="user-avatar">AD</div>
            <span>Admin Desa</span>
            <i class="bi bi-chevron-down"></i>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-username">Admin Desa</div>
                    <div class="dropdown-role">Administrator</div>
                </div>

                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="bi
                    bi-person"></i>
                    <span>Profil</span>
                </a>

                <a href="#" class="dropdown-item" id="settingsBtn">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>

                <div class="dropdown-divider"></div>

                <div class="theme-toggle">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-moon"></i>
                        <span>Dark Mode</span>
                    </div>
                    <div class="theme-switch" id="themeSwitch"></div>
                </div>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item"
                        style="border: none; background: none; text-align: left; width: 100%;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
