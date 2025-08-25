<style>
    :root {
        --primary-green: #2d5016;
        --secondary-green: #4a7c59;
        --light-green: #8fbc8f;
        --cream: #f8f6f0;
        --warm-white: #fefefe;
        --soft-gray: #6c757d;
        --accent-orange: #ff8c42;
        --sidebar-width: 280px;
    }

    [data-theme="dark"] {
        --cream: #1a1a1a;
        --warm-white: #2d2d2d;
        --soft-gray: #adb5bd;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--cream);
        color: #333;
        line-height: 1.6;
        overflow-x: hidden;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    [data-theme="dark"] body {
        color: #e9ecef;
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        z-index: 1000;
        transition: all 0.3s ease;
        overflow-y: auto;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar-header .logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
    }

    .sidebar.collapsed .logo {
        font-size: 1.2rem;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .nav-item {
        margin: 5px 15px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: var(--accent-orange);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
    }

    .nav-link i {
        font-size: 1.2rem;
        width: 25px;
        margin-right: 15px;
        transition: all 0.3s ease;
    }

    .nav-link .dropdown-arrow {
        margin-left: auto;
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .nav-link.has-submenu.expanded .dropdown-arrow {
        transform: rotate(180deg);
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 12px;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
    }

    .sidebar.collapsed .nav-text,
    .sidebar.collapsed .dropdown-arrow {
        display: none;
    }

    /* Sub Menu Styles */
    .sub-menu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: rgba(0, 0, 0, 0.1);
        margin: 5px 0;
        border-radius: 10px;
    }

    .sub-menu.expanded {
        max-height: 300px;
    }

    .sidebar.collapsed .sub-menu {
        display: none;
    }

    .sub-menu-item {
        margin: 0;
    }

    .sub-menu-link {
        display: flex;
        align-items: center;
        padding: 10px 20px 10px 50px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 3px 10px;
    }

    .sub-menu-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }

    .sub-menu-link.active {
        background: rgba(255, 140, 66, 0.7);
        color: white;
    }

    .sub-menu-link i {
        font-size: 1rem;
        width: 20px;
        margin-right: 10px;
    }

    /* Main Content */
    .main-content {
        margin-left: var(--sidebar-width);
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    .main-content.expanded {
        margin-left: 80px;
    }

    /* Header */
    .header {
        background: var(--warm-white);
        padding: 20px 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        transition: background-color 0.3s ease;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--primary-green);
        cursor: pointer;
        padding: 10px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: var(--cream);
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-green);
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .header-title {
        color: var(--light-green);
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .notification-btn {
        position: relative;
        background: none;
        border: none;
        font-size: 1.3rem;
        color: var(--soft-gray);
        cursor: pointer;
        padding: 10px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .notification-btn:hover {
        background: var(--cream);
        color: var(--primary-green);
    }

    .notification-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background: var(--accent-orange);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* User Profile Dropdown */
    .user-profile {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 8px 15px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .user-profile:hover {
        background: var(--cream);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--light-green), var(--secondary-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }

    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--warm-white);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 15px 0;
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1001;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .profile-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 10px 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
    }

    .dropdown-username {
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 5px;
    }

    [data-theme="dark"] .dropdown-username {
        color: var(--light-green);
    }

    .dropdown-role {
        font-size: 0.85rem;
        color: var(--soft-gray);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: inherit;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: var(--cream);
        color: var(--primary-green);
    }

    [data-theme="dark"] .dropdown-item:hover {
        color: var(--light-green);
    }

    .dropdown-item i {
        width: 16px;
        font-size: 1rem;
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(0, 0, 0, 0.1);
        margin: 10px 0;
    }

    .theme-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
    }

    .theme-switch {
        position: relative;
        width: 50px;
        height: 24px;
        background: #ccc;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .theme-switch.active {
        background: var(--accent-orange);
    }

    .theme-switch::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .theme-switch.active::before {
        transform: translateX(26px);
    }

    /* Dashboard Content */
    .dashboard-content {
        padding: 30px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--warm-white);
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
        background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
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
        color: var(--soft-gray);
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

    .stat-icon.services {
        background: linear-gradient(135deg, #2d5016, #4a7c59);
    }

    .stat-icon.news {
        background: linear-gradient(135deg, #6c757d, #8e9297);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 5px;
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .stat-number {
        color: var(--light-green);
    }

    .stat-change {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stat-change.positive {
        color: #28a745;
    }

    .stat-change.negative {
        color: #dc3545;
    }

    /* Activity Section */
    .activity-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .activity-card {
        background: var(--warm-white);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-green);
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .chart-title {
        color: var(--light-green);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    [data-theme="dark"] .activity-item {
        border-bottom-color: #404040;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: var(--cream);
        border-radius: 10px;
        padding: 15px;
        margin: 5px 0;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }

    .activity-icon.success {
        background: #28a745;
    }

    .activity-icon.warning {
        background: #ffc107;
    }

    .activity-icon.info {
        background: #17a2b8;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 5px;
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .activity-title {
        color: var(--light-green);
    }

    .activity-time {
        font-size: 0.8rem;
        color: var(--soft-gray);
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .action-btn {
        background: var(--warm-white);
        border: 2px solid var(--cream);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        color: var(--primary-green);
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .action-btn:hover {
        border-color: var(--accent-orange);
        color: var(--accent-orange);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    [data-theme="dark"] .action-btn {
        color: var(--light-green);
    }

    [data-theme="dark"] .action-btn:hover {
        color: var(--accent-orange);
    }

    .action-btn i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    .action-btn span {
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .activity-section {
            grid-template-columns: 1fr;
        }

        .header {
            padding: 15px 20px;
        }

        .dashboard-content {
            padding: 20px;
        }

        .header-title {
            font-size: 1.2rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .header-right {
            gap: 10px;
        }

        .user-profile span {
            display: none;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .action-btn {
            padding: 15px;
        }

        .action-btn i {
            font-size: 1.5rem;
        }
    }

    /* GANTI CSS notification-dropdown yang ada dengan yang ini: */

    .notification-dropdown {
        position: absolute;
        top: 100%;
        right: 20px;
        /* <-- PERUBAHAN DI SINI */
        width: 350px;
        background: var(--warm-white);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 15px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1001;
        border: 1px solid rgba(0, 0, 0, 0.1);

        /* Default state, controlled by JS */
    }

    .notification-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        /* Gunakan visibility dan opacity untuk kontrol tampilan */
    }

    /* Dark theme support */
    [data-theme="dark"] .notification-dropdown {
        background: var(--warm-white);
        border: 1px solid #404040;
        color: #333;
    }

    .notification-dropdown .dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--primary-green);
    }

    [data-theme="dark"] .notification-dropdown .dropdown-header {
        color: var(--primary-green);
        border-bottom-color: #404040;
    }

    .mark-all-read-btn {
        background: none;
        border: none;
        color: var(--soft-gray);
        font-size: 0.8rem;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .mark-all-read-btn:hover {
        color: var(--accent-orange);
    }

    .notification-dropdown .dropdown-body {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-dropdown .dropdown-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 20px;
        color: inherit;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .notification-dropdown .dropdown-item {
        border-bottom-color: #333;
    }

    .notification-dropdown .dropdown-item:last-child {
        border-bottom: none;
    }

    .notification-dropdown .dropdown-item:hover {
        background: var(--cream);
        color: var(--primary-green);
    }

    [data-theme="dark"] .notification-dropdown .dropdown-item:hover {
        background: #f5f5f5;
        color: var(--primary-green);
    }

    .notification-dropdown .dropdown-item .icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--light-green);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .notification-dropdown .dropdown-item .content {
        flex: 1;
    }

    .notification-dropdown .dropdown-item .title {
        font-weight: 600;
        margin-bottom: 3px;
        color: var(--primary-green);
    }

    [data-theme="dark"] .notification-dropdown .dropdown-item .title {
        color: var(--primary-green);
    }

    .notification-dropdown .dropdown-item .timestamp {
        font-size: 0.75rem;
        color: var(--soft-gray);
    }

    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Clock Styles */
    .header-clock {
        font-size: 0.9rem;
        color: var(--soft-gray);
        text-align: right;
        line-height: 1.2;
    }

    .clock-time {
        font-weight: 600;
    }

    .clock-date {
        font-size: 0.8rem;
    }
</style>
