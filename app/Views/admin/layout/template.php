<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin — Siomay Dua Putri') ?></title>
    
    <!-- Google Fonts: Plus Jakarta Sans for ultra-clean legibility -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1069;
            --primary-soft: #F4EFFF;
            --primary-badge: #E4D8FF;
            --accent-red: #E11D48;
            --text-dark: #1E1B26;
            --text-muted: #64748B;
            --bg-body: #F8F7FC;
            --bg-card: #FFFFFF;
            --border-color: #E2E8F0;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-card: 0 4px 20px rgba(59, 25, 143, 0.05);
            --radius-card: 16px;
            --t-normal: all 0.2s ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 250px;
            background: var(--bg-card);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 18px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-bottom: 28px;
            padding-left: 6px;
        }

        .brand-logo .title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .brand-logo .title span {
            color: var(--accent-red);
            display: block;
        }

        .nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.88rem;
            border-radius: 12px;
            transition: var(--t-normal);
            position: relative;
        }

        .nav-item a:hover {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .nav-item.active a {
            color: var(--primary);
            background: var(--primary-soft);
            font-weight: 700;
        }

        .nav-item .badge-count {
            background: var(--accent-red);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }

        /* HELP WIDGET SIDEBAR */
        .help-widget {
            background: var(--primary-soft);
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            margin-top: 16px;
            border: 1px solid var(--primary-badge);
        }

        .help-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .help-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .btn-help {
            display: inline-block;
            width: 100%;
            padding: 7px 10px;
            background: #ffffff;
            border: 1.5px solid var(--primary);
            color: var(--primary);
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            transition: var(--t-normal);
        }

        .btn-help:hover {
            background: var(--primary);
            color: #ffffff;
        }

        /* MAIN CONTENT CONTAINER */
        .main-wrapper {
            margin-left: 250px;
            flex: 1;
            padding: 28px 36px;
            min-height: 100vh;
        }

        /* MOBILE HEADER */
        .mobile-header {
            display: none;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .btn-toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
        }

        /* COMMON UI COMPONENTS */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 14px;
        }

        .page-title-group h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.4px;
        }

        .page-title-group p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .date-badge {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* STAT CARDS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-card);
            padding: 20px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .stat-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .stat-subtext {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-subtext.positive { color: #059669; font-weight: 600; }
        .stat-subtext.highlight { color: var(--accent-red); font-weight: 600; }

        /* BUTTONS */
        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.84rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--t-normal);
        }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-secondary {
            background: var(--primary-soft);
            color: var(--primary);
            border: 1px solid var(--primary-badge);
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.82rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--t-normal);
        }
        .btn-secondary:hover { background: #E4D8FF; }

        /* TAB STYLING */
        .custom-tabs {
            display: flex;
            gap: 8px;
            background: #ffffff;
            padding: 5px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            width: fit-content;
        }

        .tab-btn {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--t-normal);
            border: none;
            background: none;
            cursor: pointer;
        }

        .tab-btn.active {
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 700;
        }

        /* STATUS BADGES - CLEAN HUMAN READABLE */
        .badge-status {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }
        .badge-status.baru, .badge-status.menunggu { background: #FEE2E2; color: #991B1B; }
        .badge-status.diproses { background: #FEF3C7; color: #92400E; }
        .badge-status.dikonfirmasi, .badge-status.lunas, .badge-status.aktif, .badge-status.selesai { background: #D1FAE5; color: #065F46; }
        .badge-status.nonaktif { background: #F1F5F9; color: #475569; }

        /* RESPONSIVE DESIGN */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; padding: 20px 16px; }
            .mobile-header { display: flex; }
        }

        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- MOBILE HEADER -->
    <div class="mobile-header">
        <a href="<?= base_url('admin/dashboard') ?>" class="brand-logo" style="margin-bottom:0;">
            <div class="title">Siomay <span>Dua Putri</span></div>
        </a>
        <button class="btn-toggle-sidebar" onclick="toggleSidebar()">
            <span class="material-symbols-outlined" style="font-size:26px;">menu</span>
        </button>
    </div>

    <!-- SIDEBAR LEFT -->
    <aside class="sidebar" id="adminSidebar">
        <div>
            <a href="<?= base_url('admin/dashboard') ?>" class="brand-logo">
                <div class="title">Siomay <span>Dua Putri</span></div>
            </a>

            <?php 
                $uri = service('uri')->getSegment(2) ?? 'dashboard';
                $db = \Config\Database::connect();
                $newAntar = $db->table('pesanan')->where('status', 'pending')->countAllResults();
            ?>

            <ul class="nav-list">
                <li class="nav-item <?= $uri === 'dashboard' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard') ?>">
                        <span class="material-symbols-outlined">grid_view</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'pesan-antar' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/pesan-antar') ?>">
                        <span class="material-symbols-outlined">two_wheeler</span>
                        Pesan Antar
                        <?php if ($newAntar > 0): ?>
                            <span class="badge-count"><?= $newAntar ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'pesan-acara' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/pesan-acara') ?>">
                        <span class="material-symbols-outlined">event</span>
                        Pesan Acara
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'laporan' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/laporan') ?>">
                        <span class="material-symbols-outlined">analytics</span>
                        Laporan Keuangan
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'produk' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/produk') ?>">
                        <span class="material-symbols-outlined">inventory_2</span>
                        Produk
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'pelanggan' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/pelanggan') ?>">
                        <span class="material-symbols-outlined">group</span>
                        Pelanggan
                    </a>
                </li>
                <li class="nav-item <?= $uri === 'pengaturan' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/pengaturan') ?>">
                        <span class="material-symbols-outlined">settings</span>
                        Pengaturan
                    </a>
                </li>
                <li class="nav-item">
                    <form action="<?= base_url('admin/logout') ?>" method="post" id="logoutForm">
                        <?= csrf_field() ?>
                    </form>
                    <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" style="color: var(--accent-red);">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- WIDGET BANTUAN -->
        <div class="help-widget">
            <div class="help-title">Butuh Bantuan?</div>
            <div class="help-desc">Hubungi kami jika ada kendala.</div>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Support" target="_blank" class="btn-help">Hubungi Admin</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-wrapper">
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
        }
    </script>
</body>
</html>
