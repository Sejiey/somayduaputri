<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pesanan Acara Berhasil — Siomay Dua Putri') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1069;
            --border-color: #E2E8F0;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --bg-page: #F8FAFC;
            --ok-color: #166534;
            --ok-bg: #DCFCE7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }

        body {
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--text-main);
            padding-bottom: 60px;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(59, 25, 143, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 36px 28px;
            text-align: center;
        }

        .icon-success {
            width: 72px;
            height: 72px;
            background: var(--ok-bg);
            color: var(--ok-color);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .order-info {
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px;
            text-align: left;
            margin-bottom: 28px;
            font-size: 0.9rem;
        }

        .order-info div {
            margin-bottom: 6px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s ease;
        }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-wa {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            background: #25D366;
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s ease;
        }
        .btn-wa:hover { background: #1EBE5D; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="icon-success">
            <span class="material-symbols-outlined" style="font-size: 40px;">check_circle</span>
        </div>

        <h1 class="title">Pesanan Acara Berhasil Dicatat!</h1>
        <p class="desc">Terima kasih, pesanan menu porsi besar acara Anda telah berhasil kami terima.</p>

        <div class="order-info">
            <div><strong>Kode Booking:</strong> <span style="color:var(--primary); font-weight:700; font-family:monospace;"><?= esc($booking['kode_booking']) ?></span></div>
            <div><strong>Nama Pemesan:</strong> <?= esc($booking['nama_pemesan']) ?></div>
            <div><strong>Tanggal Acara:</strong> <?= date('d F Y', strtotime($booking['tanggal_acara'])) ?></div>
            <div><strong>Metode:</strong> <?= esc(($booking['metode_pengambilan'] ?? 'diantar') === 'diantar' ? 'Diantar (via Maxim)' : 'Ambil Sendiri') ?></div>
            <div><strong>Total Biaya:</strong> Rp<?= number_format((float)$booking['total'], 0, ',', '.') ?></div>
        </div>

        <div class="btn-group">
            <a href="<?= base_url('akun/riwayat') ?>" class="btn-primary">
                <span class="material-symbols-outlined">receipt_long</span> Lihat Pesanan Saya
            </a>
            <a href="<?= esc($waUrl) ?>" target="_blank" class="btn-wa">
                <span class="material-symbols-outlined">chat</span> Chat WhatsApp Penjual
            </a>
        </div>
    </div>
</div>

</body>
</html>
