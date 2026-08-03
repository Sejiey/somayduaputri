<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pesanan Berhasil — Siomay Dua Putri') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <style>
        :root {
            --primary: #5731B6;
            --primary-dark: #432296;
            --primary-light: #F4EFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --accent-red: #E11D48;
            --accent-green: #10B981;
            --bg-page: #FBF9FF;
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
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 16px;
        }

        .main-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(87, 49, 182, 0.08);
            border: 1px solid #ECE7FE;
            max-width: 440px;
            width: 100%;
            padding: 32px 28px;
            text-align: center;
            position: relative;
        }

        /* Tombol Close X di Pojok Kanan Atas Card */
        .btn-close-card {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 32px;
            height: 32px;
            background-color: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            z-index: 10;
        }
        .btn-close-card:hover {
            background-color: #E4D8FF;
            color: var(--primary-dark);
        }
        .btn-close-card .material-symbols-outlined {
            font-size: 18px;
            font-weight: 600;
        }

        /* Confetti Ringan & Icon Centang Presisi */
        .confetti-container {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .check-circle {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(87, 49, 182, 0.2);
            z-index: 2;
        }
        .check-circle .material-symbols-outlined {
            font-size: 34px;
            font-weight: 700;
        }
        .dot {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
        }
        .d1 { width: 6px; height: 6px; background: #F59E0B; top: 8px; left: 16px; }
        .d2 { width: 5px; height: 5px; background: #8B5CF6; top: 32px; left: 6px; }
        .d3 { width: 6px; height: 6px; background: #EC4899; top: 16px; right: 18px; }
        .d4 { width: 7px; height: 7px; background: #10B981; top: 62px; left: 10px; }
        .d5 { width: 5px; height: 5px; background: #3B82F6; top: 6px; right: 38px; }
        .d6 { width: 7px; height: 7px; background: #F43F5E; top: 70px; right: 16px; }
        .d7 { width: 5px; height: 5px; background: #8B5CF6; top: 48px; right: 8px; }
        .d8 { width: 5px; height: 5px; background: #F59E0B; top: 76px; left: 40px; }

        .page-heading {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2D1A56;
            margin-bottom: 4px;
        }

        .page-subheading {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.4;
        }

        /* Box Ringkasan Kompak */
        .info-card-box {
            background: #F9F7FE;
            border: 1px solid #EFE9FE;
            border-radius: 16px;
            padding: 18px 16px;
            text-align: center;
            margin-bottom: 18px;
        }
        .info-group {
            margin-bottom: 12px;
        }
        .info-group:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 2px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-code {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--accent-red);
            letter-spacing: 0.5px;
        }
        .info-val {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1F2937;
        }
        .info-status {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--accent-red);
        }

        .hint-text {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.4;
        }
        .hint-text strong {
            color: #2D1A56;
        }

        /* Tombol Berjejer Presisi */
        .btn-grid-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-solid-purple {
            background: var(--primary);
            color: #ffffff;
            border-radius: 10px;
            height: 44px;
            padding: 0 12px;
            font-weight: 600;
            font-size: 0.82rem;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            transition: background 0.2s;
            border: none;
        }
        .btn-solid-purple:hover {
            background: var(--primary-dark);
            color: #ffffff;
        }

        .btn-outline-wa {
            background: #ffffff;
            color: var(--accent-green);
            border: 1.5px solid var(--accent-green);
            border-radius: 10px;
            height: 44px;
            padding: 0 12px;
            font-weight: 600;
            font-size: 0.82rem;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
            transition: background 0.2s, color 0.2s;
        }
        .btn-outline-wa:hover {
            background: var(--accent-green);
            color: #ffffff;
        }
        .btn-outline-wa .material-symbols-outlined {
            font-size: 18px;
        }

        @media (max-width: 400px) {
            .main-card { padding: 24px 18px; }
            .btn-grid-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="main-card">
        <!-- Tombol Close X Langsung ke Beranda -->
        <a href="<?= base_url('/') ?>" class="btn-close-card" title="Kembali ke Beranda">
            <span class="material-symbols-outlined">close</span>
        </a>
        
        <!-- Icon Centang Ungu + Konfeti Presisi -->
        <div class="confetti-container">
            <span class="dot d1"></span>
            <span class="dot d2"></span>
            <span class="dot d3"></span>
            <span class="dot d4"></span>
            <span class="dot d5"></span>
            <span class="dot d6"></span>
            <span class="dot d7"></span>
            <span class="dot d8"></span>
            <div class="check-circle">
                <span class="material-symbols-outlined">check</span>
            </div>
        </div>

        <h1 class="page-heading">Pesanan Berhasil!</h1>
        <p class="page-subheading">Pembayaran berhasil! Pesanan Anda telah diterima dan saat ini sedang disiapkan oleh penjual.</p>

        <!-- Box Ringkasan Kompak -->
        <div class="info-card-box">
            <div class="info-group">
                <span class="info-label">No. Pesanan</span>
                <div class="info-code">#<?= esc($pesanan['kode_pesanan'] ?? '') ?></div>
            </div>

            <div class="info-group">
                <span class="info-label">Tanggal Pesanan</span>
                <div class="info-val"><?= date('d F Y', strtotime($pesanan['created_at'] ?? date('Y-m-d'))) ?></div>
            </div>

            <div class="info-group">
                <span class="info-label">Status</span>
                <div class="info-status">
                    <span style="color: #10B981;">Lunas (Pesanan Diproses)</span>
                </div>
            </div>
        </div>

        <p class="hint-text">Pantau status pesanan Anda atau hubungi kami via WhatsApp.</p>

        <!-- Tombol Aksi Berjejer Samping Sesuai Gambar -->
        <div class="btn-grid-row">
            <a href="<?= base_url('akun/riwayat') ?>" class="btn-solid-purple">
                Lihat Pesanan Saya
            </a>
            <?php if (!empty($waUrl)): ?>
                <a href="<?= esc($waUrl) ?>" target="_blank" class="btn-outline-wa">
                    <span class="material-symbols-outlined">chat</span> Chat WhatsApp Penjual
                </a>
            <?php else: ?>
                <a href="https://wa.me/6282237191496" target="_blank" class="btn-outline-wa">
                    <span class="material-symbols-outlined">chat</span> Chat WhatsApp Penjual
                </a>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>