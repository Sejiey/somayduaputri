<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Tracking Pesanan') ?> — Siomay Dua Putri</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4A1E9E;
            --primary-dark: #3b198f;
            --primary-light: #F4EFFF;
            --primary-soft: #ECE3FE;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --accent-green: #10B981;
            --accent-red: #E11D48;
            --bg-page: #FBF9FF;
            --card-shadow: 0 10px 30px rgba(74, 30, 158, 0.06);
            --radius-lg: 20px;
            --radius-md: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--text-dark);
            min-height: 100vh;
            line-height: 1.5;
            padding-bottom: 60px;
        }

        /* HEADER NAV BAR MODERN */
        header {
            background: linear-gradient(135deg, #4A1E9E 0%, #2E1069 100%);
            color: #ffffff;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 24px rgba(74, 30, 158, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: #FACC15;
            color: #1E1B4B;
            font-weight: 800;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .brand span.highlight {
            color: #FACC15;
        }

        .btn-header-back {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 14px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .btn-header-back:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* CONTAINER MAIN */
        .container {
            max-width: 820px;
            margin: 32px auto 0;
            padding: 0 16px;
        }

        .btn-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.88rem;
            text-decoration: none;
            margin-bottom: 20px;
            transition: color 0.2s;
        }

        .btn-back-link:hover {
            color: var(--primary-dark);
        }

        /* CARD STYLING */
        .card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #ECE7FE;
            box-shadow: var(--card-shadow);
            padding: 28px;
            margin-bottom: 24px;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            padding-bottom: 18px;
            border-bottom: 1px solid #F3F0FE;
            margin-bottom: 24px;
        }

        .order-title-code {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            font-family: monospace;
        }

        .order-meta-date {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .current-status-box {
            text-align: right;
        }

        .status-tag-big {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.88rem;
            background: #DCFCE7;
            color: #15803D;
        }

        /* STEPPER PROGRESS BAR MODERN */
        .card-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2D1A56;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stepper-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 28px 0 16px;
        }

        .stepper-container::before {
            content: '';
            position: absolute;
            top: 22px;
            left: 8%;
            right: 8%;
            height: 4px;
            background: #EFE9FE;
            z-index: 1;
        }

        .step-item {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
        }

        .step-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #F4EFFF;
            color: var(--primary);
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(74, 30, 158, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .step-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .step-item.active .step-icon {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(74, 30, 158, 0.3);
        }

        .step-item.active .step-label {
            color: var(--primary);
            font-weight: 700;
        }

        .step-item.completed .step-icon {
            background: #10B981;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .step-item.completed .step-label {
            color: #15803D;
            font-weight: 700;
        }

        /* GRID INFORMASI PEMESAN */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .info-box {
            background: #F9F7FE;
            border: 1px solid #EFE9FE;
            padding: 14px 16px;
            border-radius: 14px;
        }

        .info-box label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--primary);
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        .info-box span {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* ITEM RINCIAN MENU */
        .menu-list {
            margin-bottom: 20px;
        }

        .menu-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #EFE9FE;
        }

        .menu-item-row:last-child {
            border-bottom: none;
        }

        .menu-name {
            font-weight: 700;
            font-size: 0.92rem;
            color: #2D1A56;
        }

        .menu-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .menu-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .calc-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .calc-row.total {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            border-top: 2px solid #EFE9FE;
            padding-top: 14px;
            margin-top: 8px;
        }

        .btn-wa-support {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #ffffff;
            color: var(--accent-green);
            border: 2px solid var(--accent-green);
            border-radius: 12px;
            padding: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            margin-top: 20px;
            transition: all 0.2s ease;
        }

        .btn-wa-support:hover {
            background: var(--accent-green);
            color: #ffffff;
        }

        @media (max-width: 600px) {
            .stepper-container::before { display: none; }
            .stepper-container { flex-direction: column; gap: 16px; align-items: flex-start; }
            .step-item { flex-direction: row; gap: 12px; text-align: left; }
            .step-icon { margin-bottom: 0; }
        }
    </style>
</head>
<body>

<header>
    <a class="brand" href="<?= base_url('pesan-antar/form') ?>">
        <span class="brand-logo">S</span>
        Siomay <span class="highlight">Dua Putri</span>
    </a>
    <a href="<?= base_url('akun/riwayat') ?>" class="btn-header-back">
        <span class="material-symbols-outlined" style="font-size:18px;">receipt_long</span> Riwayat Saya
    </a>
</header>

<div class="container">
    
    <a href="<?= base_url('akun/riwayat') ?>" class="btn-back-link">
        <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span> Kembali ke Riwayat Pesanan
    </a>

    <?php 
        $status = strtolower($pesanan['status'] ?? 'lunas');
        $isAcara = ($pesanan['tipe_layanan'] ?? '') === 'pesan_acara';

        // Steps active state
        $step1 = 'completed';
        $step2 = 'completed';
        $step3 = 'active';
        $step4 = '';

        if ($status === 'menunggu_pembayaran') {
            $step1 = 'active';
            $step2 = '';
            $step3 = '';
        } elseif (in_array($status, ['lunas', 'diproses'], true)) {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'active';
        } elseif ($status === 'diantar') {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'completed';
            $step4 = 'active';
        } elseif ($status === 'selesai') {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'completed';
            $step4 = 'completed';
        }
    ?>

    <!-- CARD PROGRESS TRACKING -->
    <div class="card">
        <div class="card-header-flex">
            <div>
                <div class="order-title-code">No. Pesanan: #<?= esc($pesanan['kode_pesanan'] ?? '-') ?></div>
                <div class="order-meta-date">
                    Dibuat: <?= !empty($pesanan['created_at']) ? date('d F Y, H:i', strtotime($pesanan['created_at'])) : '-' ?>
                </div>
            </div>

            <div class="current-status-box">
                <span class="status-tag-big">
                    <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                    <?php 
                        if (in_array($status, ['lunas', 'diproses'], true)) {
                            echo 'Lunas (Pesanan Diproses)';
                        } elseif ($status === 'diantar') {
                            echo 'Sedang Diantar';
                        } elseif ($status === 'selesai') {
                            echo 'Pesanan Selesai';
                        } else {
                            echo 'Menunggu Pembayaran';
                        }
                    ?>
                </span>
            </div>
        </div>

        <div class="card-section-title">
            <span class="material-symbols-outlined" style="color:var(--primary);">radar</span> Progres Status Pesanan
        </div>

        <div class="stepper-container">
            <div class="step-item <?= $step1 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div class="step-label">Pesanan Dibuat</div>
            </div>

            <div class="step-item <?= $step2 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">verified</span>
                </div>
                <div class="step-label">Pembayaran Lunas</div>
            </div>

            <div class="step-item <?= $step3 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">skillet</span>
                </div>
                <div class="step-label">Pesanan Diproses</div>
            </div>

            <div class="step-item <?= $step4 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>
                <div class="step-label"><?= ($pesanan['metode'] ?? '') === 'diantar' ? 'Pengantaran' : 'Siap Diambil' ?></div>
            </div>
        </div>
    </div>

    <!-- CARD DETAIL PENGANTARAN & PEMESAN -->
    <div class="card">
        <div class="card-section-title">
            <span class="material-symbols-outlined" style="color:var(--primary);">person_pin</span> Detail Pemesan & Penerimaan
        </div>

        <div class="info-grid">
            <div class="info-box">
                <label>Nama Pemesan</label>
                <span><?= esc($pesanan['nama_pembeli'] ?? '-') ?></span>
            </div>

            <div class="info-box">
                <label>No. WhatsApp</label>
                <span><?= esc($pesanan['nomor_hp'] ?? '-') ?></span>
            </div>

            <div class="info-box">
                <label>Metode Penerimaan</label>
                <span><?= esc(($pesanan['metode'] ?? '') === 'diantar' ? 'Diantar Kurir (Maxim)' : 'Ambil Sendiri') ?></span>
            </div>

            <div class="info-box">
                <label><?= $isAcara ? 'Tanggal Acara' : 'Lokasi / Area' ?></label>
                <span>
                    <?php if ($isAcara): ?>
                        <?= !empty($pesanan['tanggal_acara']) ? date('d F Y', strtotime($pesanan['tanggal_acara'])) : '-' ?>
                    <?php else: ?>
                        <?= esc($pesanan['lokasi'] ?? 'Undata') ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <?php if (($pesanan['metode'] ?? '') === 'diantar'): ?>
            <?php if ($isAcara): ?>
                <?php if (!empty($pesanan['patokan_maxim'])): ?>
                    <div class="info-box" style="margin-bottom:14px;">
                        <label>Patokan Driver Maxim</label>
                        <span><?= esc($pesanan['patokan_maxim']) ?></span>
                    </div>
                <?php endif; ?>
                <div class="info-box" style="margin-bottom:14px;">
                    <label>Alamat Pengantaran</label>
                    <span><?= esc(!empty($pesanan['alamat']) ? $pesanan['alamat'] : '-') ?></span>
                </div>
            <?php else: ?>
                <div class="info-box" style="margin-bottom:14px;">
                    <label><?= ($pesanan['lokasi'] ?? '') === 'Undata' ? 'Ruangan' : 'Alamat Pengantaran' ?></label>
                    <span><?= esc(!empty($pesanan['ruangan']) ? $pesanan['ruangan'] : (!empty($pesanan['alamat']) ? $pesanan['alamat'] : '-')) ?></span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="info-box" style="margin-bottom:14px;">
                <label>Lokasi Pengambilan</label>
                <span>
                    Jl. Rindai Permai Blok M No.30 (Dekat Masjid) — 
                    <a href="https://maps.app.goo.gl/dhxQZUKMSHdAQnNq7" target="_blank" style="color:var(--primary); font-weight:700; text-decoration:underline;">Lihat Maps</a>
                </span>
            </div>
        <?php endif; ?>

        <?php if (!empty($pesanan['catatan'])): ?>
            <div class="info-box">
                <label>Catatan Pesanan</label>
                <span><?= esc($pesanan['catatan']) ?></span>
            </div>
        <?php endif; ?>

        <a href="https://wa.me/6282237191496" target="_blank" class="btn-wa-support">
            <span class="material-symbols-outlined">chat</span> Hubungi Penjual via WhatsApp
        </a>
    </div>

    <!-- CARD RINCIAN MENU & BAYAR -->
    <div class="card">
        <div class="card-section-title">
            <span class="material-symbols-outlined" style="color:var(--primary);">restaurant_menu</span> Rincian Item Pesanan
        </div>

        <div class="menu-list">
            <?php if (isset($items) && is_array($items) && !empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <div class="menu-item-row">
                        <div>
                            <div class="menu-name"><?= esc($item['produk_nama']) ?></div>
                            <div class="menu-sub">
                                <?= !empty($item['nama_varian']) ? 'Varian: ' . esc($item['nama_varian']) . ' · ' : '' ?>
                                Rp<?= number_format((float)$item['harga_satuan'], 0, ',', '.') ?> x <?= esc($item['jumlah']) ?>
                            </div>
                        </div>
                        <div class="menu-price">
                            Rp<?= number_format((float)$item['subtotal_item'], 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="color:var(--text-muted); font-size:0.88rem;">Detail item tidak tersedia.</div>
            <?php endif; ?>
        </div>

        <div class="calc-row">
            <span>Subtotal Menu</span>
            <span>Rp<?= number_format((float)($pesanan['subtotal'] ?? 0), 0, ',', '.') ?></span>
        </div>

        <?php if (! $isAcara): ?>
            <div class="calc-row">
                <span>Biaya Pengiriman (Ongkir)</span>
                <span>Rp<?= number_format((float)($pesanan['ongkir'] ?? 0), 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>

        <div class="calc-row total">
            <span>Total Pembayaran</span>
            <span>Rp<?= number_format((float)($pesanan['total'] ?? 0), 0, ',', '.') ?></span>
        </div>
    </div>

</div>

</body>
</html>
