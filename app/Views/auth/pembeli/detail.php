<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Tracking Pesanan') ?> — Siomay Dua Putri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1373;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --bg-page: #F8FAFC;
            --border-color: #E2E8F0;
            --card-shadow: 0 10px 25px -5px rgba(59, 25, 143, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-dark);
            padding-bottom: 60px;
        }

        header {
            background: linear-gradient(135deg, #3b198f 0%, #2e1373 100%);
            color: #fff;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 16px rgba(59, 25, 143, 0.15);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        header .brand {
            display: flex; align-items: center; gap: 10px;
            font-weight: 700; font-size: 1.1rem;
            text-decoration: none; color: #fff;
        }
        header .duaputri { color: #FACC15; }
        header .brand-mark {
            width: 32px; height: 32px;
            background: #FACC15;
            border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            color: #1F1611; font-weight: 800;
        }

        .container {
            max-width: 800px;
            margin: 32px auto 0;
            padding: 0 16px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 28px;
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-meta-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .order-code {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            font-family: ui-monospace, "SF Mono", Consolas, monospace;
        }

        .order-date {
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        /* TRACKER STEPPER STYLES */
        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 32px 0 24px;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--border-color);
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
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #F1F5F9;
            color: var(--text-muted);
            border: 3px solid #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .step-item.active .step-icon {
            background: var(--primary);
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(59, 25, 143, 0.3);
        }

        .step-item.active .step-label {
            color: var(--primary);
            font-weight: 700;
        }

        .step-item.completed .step-icon {
            background: #22C55E;
            color: #FFFFFF;
        }

        .step-item.completed .step-label {
            color: #166534;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .info-box {
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            padding: 14px 16px;
            border-radius: 12px;
        }

        .info-box label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .info-box span {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* MENU ITEMS TABLE */
        .menu-list {
            margin-bottom: 20px;
        }

        .menu-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed var(--border-color);
        }

        .menu-item-row:last-child {
            border-bottom: none;
        }

        .menu-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .menu-sub {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .menu-price {
            font-weight: 700;
            color: var(--primary);
        }

        .calc-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .calc-row.total {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            border-top: 2px solid var(--border-color);
            padding-top: 14px;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<header>
    <a class="brand" href="<?= base_url('pesan-antar/form') ?>">
        <span class="brand-mark">S</span>
        Siomay <span class="duaputri">Dua Putri</span>
    </a>
    <a href="<?= base_url('akun/riwayat') ?>" style="color:#fff; text-decoration:none; font-weight:600; font-size:0.9rem;">
        Riwayat Saya
    </a>
</header>

<div class="container">
    <a href="<?= base_url('akun/riwayat') ?>" class="btn-back">
        <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span> Kembali ke Riwayat Pesanan
    </a>

    <?php 
        $status = $pesanan['status'] ?? 'menunggu_pembayaran';
        
        // Define stepper active states
        // Steps: 1: Menunggu Pembayaran, 2: Menunggu Konfirmasi, 3: Lunas / Diproses, 4: Selesai
        $step1 = 'completed';
        $step2 = '';
        $step3 = '';
        $step4 = '';

        if ($status === 'menunggu_pembayaran') {
            $step1 = 'active';
        } elseif ($status === 'menunggu_konfirmasi') {
            $step1 = 'completed';
            $step2 = 'active';
        } elseif (in_array($status, ['lunas', 'diproses', 'diantar'], true)) {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'active';
        } elseif ($status === 'selesai') {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'completed';
            $step4 = 'completed';
        }
    ?>

    <!-- CARD TRACKER PROGRESS -->
    <div class="card">
        <div class="order-meta-header">
            <div>
                <div class="order-code">No. Pesanan: <?= esc($pesanan['kode_pesanan'] ?? '-') ?></div>
                <div class="order-date">
                    Dibuat: <?= !empty($pesanan['created_at']) ? date('d F Y, H:i', strtotime($pesanan['created_at'])) : '-' ?>
                </div>
            </div>
            <div style="text-align:right;">
                <span style="font-size:0.8rem; color:var(--text-muted); font-weight:600; display:block;">STATUS SEKARANG</span>
                <span style="font-weight:700; color:var(--primary); font-size:1.05rem;">
                    <?php 
                        $statusText = [
                            'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            'menunggu_konfirmasi' => 'Menunggu Konfirmasi Midtrans',
                            'lunas'               => 'Lunas / Diproses',
                            'diproses'            => 'Sedang Diproses Penjual',
                            'diantar'             => 'Sedang Diantar Kurir',
                            'selesai'             => 'Pesanan Selesai',
                            'batal'               => 'Dibatalkan'
                        ];
                        echo esc($statusText[$status] ?? ucfirst($status));
                    ?>
                </span>
            </div>
        </div>

        <div class="card-title">
            <span class="material-symbols-outlined">local_shipping</span> Progres Pesanan
        </div>

        <div class="stepper">
            <div class="step-item <?= $step1 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div class="step-label">Menunggu Pembayaran</div>
            </div>
            <div class="step-item <?= $step2 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">verified</span>
                </div>
                <div class="step-label">Konfirmasi Midtrans</div>
            </div>
            <div class="step-item <?= $step3 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">skillet</span>
                </div>
                <div class="step-label">Diproses / Diantar</div>
            </div>
            <div class="step-item <?= $step4 ?>">
                <div class="step-icon">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div class="step-label">Selesai</div>
            </div>
        </div>
    </div>

    <!-- CARD DETAIL PEMESAN & LOKASI -->
    <div class="card">
        <div class="card-title">
            <span class="material-symbols-outlined">person_pin</span> Detail Pengantaran & Pemesan
        </div>

        <?php $isAcara = ($pesanan['tipe_layanan'] ?? '') === 'pesan_acara'; ?>

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
                <div class="info-box" style="margin-bottom:16px;">
                    <label>Alamat Pengantaran</label>
                    <span><?= esc(!empty($pesanan['alamat']) ? $pesanan['alamat'] : '-') ?></span>
                </div>
            <?php else: ?>
                <div class="info-box" style="margin-bottom:16px;">
                    <label><?= ($pesanan['lokasi'] ?? '') === 'Undata' ? 'Ruangan' : 'Alamat Pengantaran' ?></label>
                    <span><?= esc(!empty($pesanan['ruangan']) ? $pesanan['ruangan'] : (!empty($pesanan['alamat']) ? $pesanan['alamat'] : '-')) ?></span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="info-box" style="margin-bottom:16px;">
                <label>Lokasi Pengambilan</label>
                <span>Kantin RSUD Undata, Palu</span>
            </div>
        <?php endif; ?>

        <?php if (!empty($pesanan['catatan'])): ?>
            <div class="info-box">
                <label>Catatan Pesanan</label>
                <span><?= esc($pesanan['catatan']) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- CARD DETAIL MENU & BIAYA -->
    <div class="card">
        <div class="card-title">
            <span class="material-symbols-outlined">restaurant_menu</span> Rincian Pesanan
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
                <div style="color:var(--text-muted); font-size:0.9rem;">Detail item tidak tersedia.</div>
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
