<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Pesanan Acara — Admin') ?></title>
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
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background: var(--bg-page); color: var(--text-main); padding: 24px; }

        .container { max-width: 800px; margin: 0 auto; }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            padding: 28px;
            margin-bottom: 24px;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .order-code { font-size: 1.3rem; font-weight: 700; color: var(--primary); font-family: monospace; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-box {
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            padding: 12px 16px;
            border-radius: 12px;
        }

        .info-box label { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 2px; }
        .info-box span { font-weight: 600; font-size: 0.95rem; }

        .btn-maxim {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #FFC107;
            color: #000;
            font-weight: 700;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
            transition: transform 0.15s ease;
        }
        .btn-maxim:hover { transform: translateY(-2px); }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--border-color);
        }
    </style>
</head>
<body>

<div class="container">
    <div style="margin-bottom:20px;">
        <a href="<?= base_url('admin/pesanan-acara') ?>" style="color:var(--primary); font-weight:600; text-decoration:none;">&larr; Kembali ke Daftar Pesanan Acara</a>
    </div>

    <div class="card">
        <div class="header-flex">
            <div>
                <div class="order-code">#<?= esc($pesanan['kode_booking']) ?></div>
                <div style="font-size:0.85rem; color:var(--text-muted);">
                    Dibuat: <?= !empty($pesanan['created_at']) ? date('d M Y, H:i', strtotime($pesanan['created_at'])) : '-' ?>
                </div>
            </div>
            <div>
                <span style="font-weight:700; color:var(--primary); font-size:1.1rem; text-transform:uppercase;">
                    <?= esc(str_replace('_', ' ', $pesanan['status_pembayaran'])) ?>
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <label>Nama Pemesan</label>
                <span><?= esc($pesanan['nama_pemesan']) ?></span>
            </div>
            <div class="info-box">
                <label>No. WhatsApp</label>
                <span><?= esc($pesanan['nomor_hp']) ?></span>
            </div>
            <div class="info-box">
                <label>Metode Pengambilan</label>
                <span><?= esc(($pesanan['metode_pengambilan'] ?? 'diantar') === 'diantar' ? 'Diantar (Maxim)' : 'Ambil Sendiri') ?></span>
            </div>
            <div class="info-box">
                <label>Tanggal Acara</label>
                <span><?= date('d M Y', strtotime($pesanan['tanggal_acara'])) ?></span>
            </div>
        </div>

        <?php if (($pesanan['metode_pengambilan'] ?? 'diantar') === 'diantar'): ?>
            <?php if (!empty($pesanan['patokan_maxim'])): ?>
                <div class="info-box" style="margin-bottom:12px;">
                    <label>Patokan Maxim Driver</label>
                    <span><?= esc($pesanan['patokan_maxim']) ?></span>
                </div>
            <?php endif; ?>
            <div class="info-box" style="margin-bottom:20px;">
                <label>Alamat Lengkap</label>
                <span><?= esc($pesanan['alamat']) ?></span>
            </div>

            <?php 
                $lat = $pesanan['alamat_lat'] ?? '-0.8917';
                $lng = $pesanan['alamat_lng'] ?? '119.8707';
                $maximUrl = "https://taxsee.com/id-ID/order?start_lat=-0.8917&start_lng=119.8707&end_lat=" . esc($lat) . "&end_lng=" . esc($lng);
            ?>

            <!-- TOMBOL ADMIN KIRIM VIA MAXIM DEEP LINK -->
            <div style="margin-bottom:24px;">
                <a href="<?= $maximUrl ?>" target="_blank" class="btn-maxim">
                    <span class="material-symbols-outlined">local_shipping</span> Kirim via Maxim Driver
                </a>
            </div>
        <?php endif; ?>

        <!-- RINCIAN MENU -->
        <h3 style="font-size:1.05rem; color:var(--primary); margin-bottom:12px;">Rincian Menu Pesanan</h3>
        <?php foreach ($items as $it): ?>
            <div class="item-row">
                <div>
                    <div style="font-weight:600;"><?= esc($it['produk_nama']) ?></div>
                    <div style="font-size:0.82rem; color:var(--text-muted);">
                        Rp<?= number_format((float)$it['harga_satuan_snapshot'], 0, ',', '.') ?> x <?= esc($it['jumlah']) ?>
                    </div>
                </div>
                <div style="font-weight:700; color:var(--primary);">
                    Rp<?= number_format((float)$it['subtotal_item'], 0, ',', '.') ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; justify-content:space-between; font-size:1.2rem; font-weight:700; color:var(--primary); margin-top:16px; padding-top:12px; border-top:2px solid var(--border-color);">
            <span>Total Pembayaran</span>
            <span>Rp<?= number_format((float)$pesanan['total'], 0, ',', '.') ?></span>
        </div>
    </div>
</div>

</body>
</html>
