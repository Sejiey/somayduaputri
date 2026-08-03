<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Siomay Dua Putri') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b198f;       
            --primary-hover: #2e1069;
            --accent-red: #E11D48;    
            --background: #EAE2FF;    
            --surface: #ffffff;
            --on-surface: #1d1a22;
            --on-surface-variant: #4a4452;
            --t-fast: 200ms ease-in-out;
        }

        * { box-sizing: border-box; }
        
        html { 
            -webkit-text-size-adjust: 100%; 
            scroll-behavior: smooth; 
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--background);
            color: var(--on-surface);
            line-height: 1.55;
            min-height: 100dvh;
        }
        
        a { text-decoration: none; }
        button, input, select, textarea { font: inherit; color: inherit; }
        
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
            vertical-align: middle;
            user-select: none;
        }

        .main-header {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            padding: 15px 0;
            background-color: var(--background); 
            background-image: url('<?= base_url("bg_2.png") ?>'); 
            background-size: cover;
            background-position: top center;
            border-bottom: 1px solid rgba(59, 25, 143, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-text-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 0.95;
            user-select: none;
        }
        .logo-siomay {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        .logo-duaputri {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--accent-red);
            letter-spacing: -0.5px;
            margin-top: 2px;
        }
        .logo-since {
            font-family: 'Poppins', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }
        .logo-since::before,
        .logo-since::after {
            content: "";
            height: 1.5px;
            flex-grow: 1;
            background-color: var(--primary);
            opacity: 0.5;
        }

        .nav-menu {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .nav-menu a {
            color: var(--on-surface-variant);
            font-size: 0.9rem;
            font-weight: 600;
            transition: color var(--t-fast);
            position: relative;
            padding-bottom: 4px;
        }
        .nav-menu a:hover { color: var(--primary); }
        .nav-menu a.active { color: var(--primary); }
        .nav-menu a.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
            border-radius: 2px;
        }

        .nav-action {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-btn {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #ffffff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(59, 25, 143, 0.08);
            transition: all var(--t-fast);
            padding: 0;
        }
        .icon-btn:hover {
            background-color: var(--primary);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 25, 143, 0.15);
        }
        .icon-btn .material-symbols-outlined {
            font-size: 22px;
            font-variation-settings: 'FILL' 1;
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background-color: var(--accent-red);
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        .profile-wrapper {
            position: relative;
        }
        .profile-dropdown, .tracking-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(59, 25, 143, 0.12);
            min-width: 250px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            z-index: 1000;
        }
        .profile-dropdown.show, .tracking-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background-color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .greeting {
            font-size: 0.75rem;
            color: var(--on-surface-variant);
            line-height: 1.2;
        }
        .dropdown-name {
            font-weight: 700;
            color: var(--on-surface);
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }
        
        .dropdown-item-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            color: #DC2626; 
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
            transition: background var(--t-fast);
        }
        .dropdown-item-logout:hover {
            background-color: #FEF2F2; 
        }
        .dropdown-item-logout .material-symbols-outlined {
            font-size: 20px;
        }

        /* Tombol Masuk & Daftar (Saat belum login) */
        .btn-nav-login {
            display: inline-flex;
            align-items: center;
            background-color: var(--primary);
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all var(--t-fast);
        }
        .btn-nav-login:hover { background-color: var(--primary-hover); }

        .btn-nav-register {
            display: inline-flex;
            align-items: center;
            background-color: #ffffff;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 22px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all var(--t-fast);
        }
        .btn-nav-register:hover { background-color: var(--primary-light, #F4EFFF); }

        @media (max-width: 992px) {
            .nav-menu { display: none; }
            .header-container { padding: 0 20px; }
        }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <a href="<?= base_url() ?>" class="logo-text-wrapper">
                <span class="logo-siomay">Siomay</span>
                <span class="logo-duaputri">Dua Putri</span>
                <span class="logo-since">Sejak 2018</span>
            </a>
            
            <?php 
                $currentUri = uri_string();
                $isHome = ($currentUri === '' || $currentUri === '/');
                $isLayanan = (str_contains($currentUri, 'pesan-antar') || str_contains($currentUri, 'pesan-stand'));
                $activeMenu = $isLayanan ? 'layanan' : 'beranda';
            ?>
            <nav class="nav-menu">
                <?php if ($isHome): ?>
                    <a href="#" onclick="window.scrollTo({top:0, behavior:'smooth'}); return false;" class="<?= $activeMenu === 'beranda' ? 'active' : '' ?>">Beranda</a>
                    <a href="#menu-section">Menu</a>
                    <a href="#layanan-section" class="<?= $activeMenu === 'layanan' ? 'active' : '' ?>">Layanan</a>
                    <a href="#kontak">Kontak</a>
                <?php else: ?>
                    <a href="<?= base_url() ?>" class="<?= $activeMenu === 'beranda' ? 'active' : '' ?>">Beranda</a>
                    <a href="<?= base_url('#menu-section') ?>">Menu</a>
                    <a href="<?= base_url('#layanan-section') ?>" class="<?= $activeMenu === 'layanan' ? 'active' : '' ?>">Layanan</a>
                    <a href="<?= base_url('#kontak') ?>">Kontak</a>
                <?php endif; ?>
            </nav>

            <div class="nav-action">
                <?php if (session()->get('pembeli_id')): ?>
                    <?php 
                        $pembeliId = session()->get('pembeli_id');
                        $activeOrdersCount = 0;
                        $latestActiveOrder = null;

                        if ($pembeliId) {
                            try {
                                $db = \Config\Database::connect();
                                
                                // Query pesanan (Pesan Antar)
                                if ($db->tableExists('pesanan')) {
                                    $antarActive = $db->table('pesanan')
                                        ->where('pembeli_id', $pembeliId)
                                        ->whereNotIn('status', ['selesai', 'batal'])
                                        ->orderBy('id', 'DESC')
                                        ->get()
                                        ->getResultArray();
                                    $activeOrdersCount += count($antarActive);
                                    if (!empty($antarActive)) {
                                        $latestActiveOrder = [
                                            'kode' => $antarActive[0]['kode_pesanan'] ?? 'ORD-ACTIVE',
                                            'status' => 'Lunas (Pesanan Diproses)'
                                        ];
                                    }
                                }

                                // Query pesan_stand_booking / pesanan_acara
                                $standTable = $db->tableExists('pesan_stand_booking') ? 'pesan_stand_booking' : ($db->tableExists('pesanan_acara') ? 'pesanan_acara' : null);
                                if ($standTable) {
                                    $colStatus = ($standTable === 'pesan_stand_booking') ? 'status_pembayaran' : 'status';
                                    $colCode   = ($standTable === 'pesan_stand_booking') ? 'kode_booking' : 'kode_pesanan';
                                    $standActive = $db->table($standTable)
                                        ->where('pembeli_id', $pembeliId)
                                        ->whereNotIn($colStatus, ['selesai', 'batal', 'gagal'])
                                        ->orderBy('id', 'DESC')
                                        ->get()
                                        ->getResultArray();
                                    $activeOrdersCount += count($standActive);
                                    if (!$latestActiveOrder && !empty($standActive)) {
                                        $latestActiveOrder = [
                                            'kode' => $standActive[0][$colCode] ?? 'STN-ACTIVE',
                                            'status' => 'Lunas (Pesanan Diproses)'
                                        ];
                                    }
                                }
                            } catch (\Throwable $e) {
                                log_message('error', 'Header tracking count error: ' . $e->getMessage());
                            }
                        }
                    ?>
                    
                    <!-- Ikon Tracking / Pesanan (Hanya muncul jika sudah login) -->
                    <div class="tracking-wrapper" style="position: relative;">
                        <button type="button" class="icon-btn tracking-toggle" onclick="toggleTrackingMenu(event)" title="Tracking Pesanan Saya">
                            <span class="material-symbols-outlined">shopping_bag</span>
                            <?php if ($activeOrdersCount > 0): ?>
                                <span class="notif-badge"><?= $activeOrdersCount ?></span>
                            <?php endif; ?>
                        </button>
                        
                        <div class="tracking-dropdown" id="trackingMenu">
                            <div class="dropdown-header" style="flex-direction: column; align-items: flex-start; gap: 4px; padding: 14px 16px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                    <span style="font-size: 0.75rem; color: #6B7280; font-weight: 600;">Status Pesanan</span>
                                    <?php if ($activeOrdersCount > 0): ?>
                                        <span style="font-size: 0.72rem; font-weight: 700; color: #10B981; background: #DCFCE7; padding: 2px 8px; border-radius: 12px;">Aktif (<?= $activeOrdersCount ?>)</span>
                                    <?php else: ?>
                                        <span style="font-size: 0.72rem; font-weight: 600; color: #6B7280; background: #F3F4F6; padding: 2px 8px; border-radius: 12px;">Tidak Ada Aktif</span>
                                    <?php endif; ?>
                                </div>
                                <div style="font-weight: 800; color: #3b198f; font-size: 0.88rem; margin-top: 2px;">
                                    <?php if ($latestActiveOrder): ?>
                                        #<?= esc($latestActiveOrder['kode']) ?> — <?= esc($latestActiveOrder['status']) ?>
                                    <?php else: ?>
                                        Belum Ada Pesanan Diproses
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= base_url('akun/riwayat') ?>" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; color: #3b198f; font-weight: 700; font-size: 0.85rem; text-decoration: none; border-top: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#F8F5FF'" onmouseout="this.style.background='transparent'">
                                <span>Lihat Semua Riwayat</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Ikon Profil & Dropdown Logout (Hanya muncul jika sudah login) -->
                    <div class="profile-wrapper">
                        <button class="icon-btn profile-toggle" onclick="toggleDropdown(event)" title="Profil Saya">
                            <span class="material-symbols-outlined">person</span>
                        </button>
                        
                        <div class="profile-dropdown" id="profileMenu">
                            <div class="dropdown-header">
                                <div class="user-avatar">
                                    <?= strtoupper(substr(session()->get('pembeli_nama') ?? 'P', 0, 1)) ?>
                                </div>
                                <div class="user-info">
                                    <span class="greeting">Halo,</span>
                                    <span class="dropdown-name"><?= esc(session()->get('pembeli_nama') ?? 'Pengguna') ?></span>
                                </div>
                            </div>
                            <form action="<?= base_url('logout') ?>" method="post" style="margin: 0;">
                                <?= csrf_field() ?>
                                <button type="submit" class="dropdown-item-logout">
                                    <span class="material-symbols-outlined">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Jika belum login: Tangkap path saat ini untuk redirect otomatis -->
                    <?php 
                        $currentPath = service('uri')->getPath();
                        $isAuthPage = str_contains($currentPath, 'login') || str_contains($currentPath, 'daftar');
                        $redirectParam = (!$isAuthPage && !empty($currentPath)) ? '?redirect=' . ltrim($currentPath, '/') : '';
                    ?>
                    <a href="<?= base_url('login' . $redirectParam) ?>" class="btn-nav-login">Masuk</a>
                    <a href="<?= base_url('daftar' . $redirectParam) ?>" class="btn-nav-register">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        function toggleTrackingMenu(event) {
            event.stopPropagation();
            const profileMenu = document.getElementById('profileMenu');
            if (profileMenu) profileMenu.classList.remove('show');
            const trackingMenu = document.getElementById('trackingMenu');
            if (trackingMenu) trackingMenu.classList.toggle('show');
        }

        function toggleDropdown(event) {
            event.stopPropagation();
            const trackingMenu = document.getElementById('trackingMenu');
            if (trackingMenu) trackingMenu.classList.remove('show');
            document.getElementById('profileMenu').classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.profile-wrapper')) {
                var dropdowns = document.getElementsByClassName("profile-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.remove('show');
                }
            }
            if (!event.target.closest('.tracking-wrapper')) {
                var trackings = document.getElementsByClassName("tracking-dropdown");
                for (var i = 0; i < trackings.length; i++) {
                    trackings[i].classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>