<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pesanan — Siomay Dua Putri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1373;
            --bg-page: #F8FAFC;
            --bg-card: #FFFFFF;
            --brand-merah: #DC2626;
            --brand-kuning: #FACC15;
            --ink: #1E293B;
            --ink-soft: #64748B;
            --line: #E2E8F0;
            --ok-bg: #DCFCE7;
            --ok-fg: #166534;
            --warn-bg: #FEF3C7;
            --warn-fg: #92400E;
            --err-bg: #FEE2E2;
            --err-fg: #991B1B;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-md: 0 4px 16px rgba(59, 25, 143, 0.08);
            --t-fast: 150ms ease-out;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.5;
        }
        header {
            background: linear-gradient(135deg, #3b198f 0%, #2e1373 100%);
            color: #fff;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        header .brand {
            display: flex; align-items: center; gap: 10px;
            font-weight: 700; font-size: 1.1rem;
            text-decoration: none; color: #fff;
        }
        header .duaputri { color: var(--brand-kuning); }
        header .brand-mark {
            width: 32px; height: 32px;
            background: var(--brand-kuning);
            border-radius: var(--radius-md);
            display: inline-flex; align-items: center; justify-content: center;
            color: #1F1611; font-weight: 800;
        }
        header .account {
            display: flex; align-items: center; gap: 16px;
            font-size: 0.95rem;
        }
        header .account .name { font-weight: 600; }
        header .account .email {
            color: rgba(255,255,255,0.75);
            font-size: 0.85rem;
        }
        header .account .links { display: flex; gap: 8px; align-items: center; }
        header .account .account-link {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.15);
            transition: background var(--t-fast);
        }
        header .account .account-link:hover { background: rgba(255, 255, 255, 0.25); }
        header .account .logout-form { display: inline; margin: 0; }
        header .account button.logout {
            color: #fff;
            background: rgba(220, 38, 38, 0.85);
            border: none;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            font-size: 0.9rem;
            font-family: inherit;
        }
        header .account button.logout:hover { background: #B91C1C; }

        main {
            max-width: 900px;
            margin: 32px auto;
            padding: 0 16px 64px;
        }
        .flash {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-weight: 500;
        }
        .flash-ok { background: var(--ok-bg); color: var(--ok-fg); }
        .flash-err { background: var(--err-bg); color: var(--err-fg); }

        h1 {
            color: var(--primary);
            margin: 0 0 4px;
            font-size: 1.6rem;
            font-weight: 700;
        }
        p.lead { color: var(--ink-soft); margin: 0 0 24px; }

        .pesanan-list {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-lg);
            border: 1px solid var(--line);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }
        .empty {
            padding: 48px 24px;
            text-align: center;
            color: var(--ink-soft);
        }
        .empty p { margin: 0 0 16px; font-size: 1.05rem; }
        .empty a.btn-link {
            display: inline-block;
            padding: 12px 24px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 600;
        }
        .empty a.btn-link:hover { background: var(--primary-hover); }

        .pesanan-item {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            transition: background 0.15s ease;
        }
        .pesanan-item:hover {
            background: rgba(248, 250, 252, 0.8);
        }
        .pesanan-item:last-child { border-bottom: none; }
        .pesanan-item .info { flex: 1; min-width: 200px; }
        .pesanan-item .kode {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.05rem;
            font-family: ui-monospace, "SF Mono", Consolas, monospace;
        }
        .pesanan-item .meta {
            font-size: 0.88rem;
            color: var(--ink-soft);
            margin-top: 4px;
        }
        .pesanan-item .right {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .pesanan-item .total {
            font-weight: 700;
            color: var(--ink);
            font-size: 1.1rem;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-menunggu_pembayaran, .status-pending { background: var(--warn-bg); color: var(--warn-fg); }
        .status-menunggu_konfirmasi { background: #E0F2FE; color: #0369A1; }
        .status-lunas, .status-selesai { background: var(--ok-bg); color: var(--ok-fg); }
        .status-gagal, .status-kedaluwarsa, .status-batal { background: var(--err-bg); color: var(--err-fg); }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            padding: 4px 10px;
            border-radius: 8px;
            background: #F1F5F9;
            transition: all 0.2s ease;
        }
        .btn-detail:hover {
            background: var(--primary);
            color: #FFFFFF;
        }
    </style>
</head>
<body>
<header>
    <a class="brand" href="<?= base_url('pesan-antar/form') ?>">
        <span class="brand-mark" aria-hidden="true">S</span>
        Siomay <span class="duaputri">Dua Putri</span>
    </a>
    <div class="account">
        <div>
            <div class="name"><?= esc($pembeliNama) ?></div>
            <div class="email"><?= esc($pembeliEmail) ?></div>
        </div>
        <div class="links">
            <a class="account-link" href="<?= base_url('pesan-antar/form') ?>">Pesan Antar</a>
            <form method="post" action="<?= base_url('logout') ?>" class="logout-form">
                <?= csrf_field() ?>
                <button type="submit" class="logout">Logout</button>
            </form>
        </div>
    </div>
</header>
<main>
    <?php if (session()->getFlashdata('message')): ?>
        <div class="flash flash-ok"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-err"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <h1>Riwayat Pesanan Saya</h1>
    <p class="lead">Daftar pesanan Anda dan status progres pengantaran real-time.</p>

    <div class="pesanan-list">
        <?php if (empty($pesanan)): ?>
            <div class="empty">
                <p>Belum ada riwayat pesanan. Yuk, pesan siomay favoritmu!</p>
                <a class="btn-link" href="<?= base_url('pesan-antar/form') ?>">Buat Pesanan Baru</a>
            </div>
        <?php else: ?>
            <?php foreach ($pesanan as $p): ?>
                <div class="pesanan-item">
                    <div class="info">
                        <div class="kode">
                            <?= esc($p['kode_pesanan']) ?>
                            <span style="font-size:0.75rem; font-weight:600; padding:2px 8px; border-radius:6px; background:<?= ($p['tipe_layanan'] ?? '') === 'pesan_acara' ? '#F5F3FF; color:#3b198f;' : '#F1F5F9; color:#475569;' ?>; margin-left:6px;">
                                <?= ($p['tipe_layanan'] ?? '') === 'pesan_acara' ? 'Pesan Acara' : 'Pesan Antar' ?>
                            </span>
                        </div>
                        <div class="meta">
                            Metode: <strong><?= esc(ucfirst(str_replace('_', ' ', $p['metode']))) ?></strong>
                            <?php if(!empty($p['created_at'])): ?>
                                · <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('akun/riwayat/' . esc($p['kode_pesanan'])) ?>" class="btn-detail">
                            Detail Tracking <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                        </a>
                    </div>
                    <div class="right">
                        <div class="total">Rp <?= number_format((float) $p['total'], 0, ',', '.') ?></div>
                        <span class="status status-<?= esc($p['status']) ?>">
                            <?php 
                                $statusLabel = [
                                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                    'lunas'               => 'Lunas / Diproses',
                                    'diproses'            => 'Sedang Diproses',
                                    'diantar'             => 'Sedang Diantar',
                                    'selesai'             => 'Selesai',
                                    'batal'               => 'Batal'
                                ];
                                echo esc($statusLabel[$p['status']] ?? ucfirst($p['status']));
                            ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
