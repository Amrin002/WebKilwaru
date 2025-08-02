<!-- Header -->
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

        <button class="notification-btn">
            <i class="bi bi-bell"></i>
            <span class="notification-badge">3</span>
        </button>

        <div class="user-profile" id="userProfile">
            <div class="user-avatar">AD</div>
            <span>Admin Desa</span>
            <i class="bi bi-chevron-down"></i>

            <!-- Profile Dropdown -->
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
