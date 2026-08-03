<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pesanan Saya — Siomay Dua Putri</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b198f;       
            --primary-light: #F4EFFF; 
            --primary-hover: #2e1069;
            --text-main: #1D1A22;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --bg-page: #F4F0FF; 
            --accent-red: #E11D48;
            --t-fast: 200ms ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            position: relative;
            min-height: 100vh;
        }

        /* Hiasan Latar bg_2.png */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: top center;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        /* Wrapper & Frame Putih Utama Konsisten Sesuai Halaman Lain */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 16px;
            min-height: 100vh;
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.12);
            max-width: 900px;
            width: 100%;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .form-body {
            padding: 40px;
            background: #ffffff;
        }

        /* Header & Tombol Back Konsisten Presisi */
        .page-header {
            margin-bottom: 32px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .btn-back-icon { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 44px; 
            height: 44px; 
            border-radius: 50%; 
            background-color: var(--primary-light); 
            color: var(--primary); 
            text-decoration: none; 
            transition: background 0.2s; 
            flex-shrink: 0; 
            margin-top: 4px; 
        }

        .btn-back-icon:hover { 
            background-color: #E4D8FF; 
            color: var(--primary-hover);
        }

        .page-header-text h2 { 
            color: var(--accent-red); 
            font-size: 0.85rem; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            margin: 0 0 6px 0; 
        }

        .page-header-text h1 { 
            font-size: 1.8rem; 
            margin: 0 0 4px 0; 
            color: var(--primary); 
            font-weight: 700; 
        }

        .page-header-text p { 
            color: var(--text-muted); 
            font-size: 0.88rem; 
            margin: 0; 
        }

        /* FLASH ALERT */
        .flash {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .flash-ok { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .flash-err { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

        /* LIST DAFTAR PESANAN */
        .pesanan-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .empty-box {
            background: #F9FAFB;
            border-radius: 16px;
            border: 1.5px dashed var(--border-color);
            padding: 48px 24px;
            text-align: center;
        }

        .empty-icon {
            font-size: 52px;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .empty-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .btn-new-order {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-new-order:hover {
            background: var(--primary-hover);
        }

        /* KARTU PESANAN MODERN */
        .order-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1.5px solid var(--border-color);
            padding: 24px;
            transition: all var(--t-fast);
        }

        .order-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 10px 24px rgba(59, 25, 143, 0.06);
        }

        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
        }

        .order-code-badge {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-code {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
            font-family: ui-monospace, "SF Mono", Consolas, monospace;
        }

        .service-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-acara {
            background: #F3E8FF;
            color: #6B21A8;
        }

        .badge-antar {
            background: #E0F2FE;
            color: #0369A1;
        }

        .order-date {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #DCFCE7;
            color: #166534;
        }

        .status-badge .material-symbols-outlined {
            font-size: 16px;
        }

        .status-batal {
            background: #FEE2E2;
            color: #991B1B;
        }

        .order-card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .order-details-meta {
            font-size: 0.88rem;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-row .material-symbols-outlined {
            font-size: 18px;
            color: var(--primary);
        }

        .order-price-box {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .order-total-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .btn-tracking-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all var(--t-fast);
        }

        .btn-tracking-detail:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .btn-tracking-detail .material-symbols-outlined {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .form-body { padding: 24px 20px; }
            .order-card-body { flex-direction: column; align-items: flex-start; }
            .order-price-box { align-items: flex-start; text-align: left; width: 100%; margin-top: 8px; }
        }
    </style>
</head>
<body>

    <!-- Latar Pola bg_2.png -->
    <div class="bg-decoration"></div>

    <div class="form-wrapper">
        <div class="form-card">
            <div class="form-body">

                <!-- Header Presisi dengan Tombol Back Bulat Khas -->
                <div class="page-header">
                    <a href="<?= base_url('/') ?>" class="btn-back-icon" title="Kembali ke Beranda">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <div class="page-header-text">
                        <h2>Riwayat & Tracking</h2>
                        <h1>Riwayat Pesanan Saya</h1>
                        <p>Daftar seluruh transaksi pesanan dan status progres pengantaran Anda.</p>
                    </div>
                </div>

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="flash flash-ok"><?= esc(session()->getFlashdata('message')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash flash-err"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>

                <div class="pesanan-list">
                    <?php if (empty($pesanan)): ?>
                        <div class="empty-box">
                            <span class="material-symbols-outlined empty-icon">receipt_long</span>
                            <h3 class="empty-title">Belum Ada Riwayat Pesanan</h3>
                            <p class="empty-desc">Anda belum memiliki transaksi pesanan. Yuk, nikmati jajanan siomay favoritmu sekarang!</p>
                            <a href="<?= base_url('pesan-antar/form') ?>" class="btn-new-order">
                                <span class="material-symbols-outlined">add_shopping_cart</span> Buat Pesanan Baru
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($pesanan as $p): ?>
                            <?php $isAcara = ($p['tipe_layanan'] ?? '') === 'pesan_acara'; ?>
                            <div class="order-card">
                                
                                <div class="order-card-header">
                                    <div>
                                        <div class="order-code-badge">
                                            <span class="order-code">#<?= esc($p['kode_pesanan']) ?></span>
                                            <span class="service-badge <?= $isAcara ? 'badge-acara' : 'badge-antar' ?>">
                                                <?= $isAcara ? 'Pesan Acara' : 'Pesan Antar' ?>
                                            </span>
                                        </div>
                                        <div class="order-date">
                                            Dibuat: <?= !empty($p['created_at']) ? date('d F Y, H:i', strtotime($p['created_at'])) : '-' ?>
                                        </div>
                                    </div>

                                    <div>
                                        <?php 
                                            $st = strtolower($p['status'] ?? '');
                                            $statusLabel = 'Lunas (Pesanan Diproses)';
                                            $statusClass = 'status-badge';

                                            if ($st === 'diantar') {
                                                $statusLabel = 'Sedang Diantar';
                                            } elseif ($st === 'selesai') {
                                                $statusLabel = 'Pesanan Selesai';
                                            } elseif ($st === 'batal') {
                                                $statusLabel = 'Dibatalkan';
                                                $statusClass = 'status-badge status-batal';
                                            }
                                        ?>
                                        <span class="<?= $statusClass ?>">
                                            <span class="material-symbols-outlined">check_circle</span>
                                            <?= $statusLabel ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="order-card-body">
                                    <div class="order-details-meta">
                                        <div class="meta-row">
                                            <span class="material-symbols-outlined">local_shipping</span>
                                            <span>Metode: <strong><?= esc(ucfirst(str_replace('_', ' ', $p['metode']))) ?></strong></span>
                                        </div>
                                        <?php if ($isAcara && !empty($p['tanggal_acara'])): ?>
                                            <div class="meta-row">
                                                <span class="material-symbols-outlined">event</span>
                                                <span>Tgl Acara: <strong><?= date('d M Y', strtotime($p['tanggal_acara'])) ?></strong></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="order-price-box">
                                        <div class="order-total-price">
                                            Rp <?= number_format((float)$p['total'], 0, ',', '.') ?>
                                        </div>
                                        <a href="<?= base_url('akun/riwayat/' . esc($p['kode_pesanan'])) ?>" class="btn-tracking-detail">
                                            Detail Tracking <span class="material-symbols-outlined">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
