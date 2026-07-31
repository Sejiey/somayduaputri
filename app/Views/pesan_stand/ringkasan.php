<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ringkasan Booking Stand — Siomay Dua Putri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #3b198f; --border-color: #E5E7EB; --text-main: #1D1A22; --text-muted: #6B7280; --accent-red: #E11D48; }
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { margin: 0; background-color: #FBF9FF; background-image: url('<?= base_url("bg.png") ?>'); background-size: cover; background-attachment: fixed; color: var(--text-main); padding-bottom: 60px; }
        
        .wrapper { max-width: 650px; margin: 40px auto; background: #fff; padding: 40px; border-radius: 24px; box-shadow: 0 20px 60px rgba(59,25,143,0.08); }
        
        /* Top Nav */
        .top-nav { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; border-bottom: 1px dashed var(--border-color); padding-bottom: 16px; }
        .btn-back { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #F4EFFF; color: var(--primary); border-radius: 50%; text-decoration: none; transition: 0.2s; }
        .btn-back:hover { background: var(--primary); color: #fff; }
        .page-title { font-size: 1.4rem; font-weight: 800; color: var(--primary); margin: 0; letter-spacing: -0.5px; }
        
        /* Section Styling */
        .section-title { font-size: 1.1rem; font-weight: 700; color: var(--primary); margin: 24px 0 16px 0; }
        
        /* Detail Acara */
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
        .info-label { color: var(--text-muted); font-weight: 500; }
        .info-value { font-weight: 600; color: var(--text-main); text-align: right; max-width: 60%; }
        
        /* Detail Menu */
        .menu-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px; }
        .menu-item { display: flex; align-items: center; gap: 16px; padding: 12px; border: 1px solid #f3f4f6; border-radius: 16px; }
        .menu-img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; background: #f3f4f6; }
        .menu-details { flex: 1; }
        .menu-name { font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; color: var(--primary); }
        .menu-variant { font-size: 0.85rem; color: var(--text-muted); }
        .menu-price-qty { display: flex; align-items: center; gap: 12px; text-align: right; }
        .menu-price { font-weight: 700; font-size: 0.95rem; }
        .menu-qty { font-weight: 700; color: var(--text-muted); font-size: 0.95rem; }

        /* Ringkasan Biaya (Dibawah, Sesuai Pesan Antar) */
        .calc-box { padding-top: 24px; border-top: 1px dashed var(--border-color); }
        .calc-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; font-weight: 500; }
        .calc-total { display: flex; justify-content: space-between; margin-top: 20px; font-size: 1.1rem; font-weight: 700; color: var(--primary); align-items: center; padding-top: 16px; border-top: 1px solid var(--border-color); }
        .calc-total .total-price { color: var(--accent-red); font-size: 1.5rem; font-weight: 800; }

        /* Tombol Lanjut */
        .btn-solid { width: 100%; padding: 16px; background: var(--primary); border: none; color: white; border-radius: 12px; font-weight: 600; font-size: 1.05rem; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 32px; transition: background 0.2s; }
        .btn-solid:hover { background: #2e1069; }
        
        /* Modal Konfirmasi */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; opacity: 0; transition: opacity 0.2s; }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal-box { background: #fff; padding: 32px; border-radius: 20px; width: 90%; max-width: 400px; text-align: center; transform: scale(0.95); transition: transform 0.2s; }
        .modal-overlay.active .modal-box { transform: scale(1); }
        .modal-icon { font-size: 48px; color: #F59E0B; margin-bottom: 16px; font-variation-settings: 'FILL' 1; }
        .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
        .btn-batal { flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 12px; cursor: pointer; background: #fff; font-weight:600; color: var(--text-muted); }
        .btn-yakin { flex: 1; padding: 12px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-weight:600; }

        @media (max-width: 768px) {
            .wrapper { margin: 20px; padding: 24px; }
            .menu-item { flex-direction: column; align-items: flex-start; gap: 12px; }
            .menu-price-qty { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="top-nav">
            <a href="<?= base_url('pesan-stand/menu') ?>" class="btn-back"><span class="material-symbols-outlined">arrow_back</span></a>
            <h1 class="page-title">Ringkasan Booking Stand</h1>
        </div>

        <h3 class="section-title" style="margin-top: 0;">Detail Acara</h3>
        <div class="info-row">
            <span class="info-label">Nama Acara</span>
            <span class="info-value"><?= esc($formData['nama_acara'] ?? $formData['jenis_acara'] ?? 'Ulang Tahun') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Acara</span>
            <span class="info-value"><?= esc($formData['tanggal_acara'] ?? $formData['tanggal'] ?? 'dd/mm/yyyy') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Lokasi Acara</span>
            <span class="info-value"><?= esc($formData['lokasi_acara'] ?? $formData['lokasi'] ?? 'Alamat Gedung') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Estimasi Tamu</span>
            <span class="info-value"><?= esc($formData['estimasi_porsi'] ?? $formData['jumlah_tamu'] ?? '0') ?> Orang</span>
        </div>
        <div class="info-row">
            <span class="info-label">Catatan</span>
            <span class="info-value" style="font-weight: 400;"><?= esc($formData['catatan'] ?? 'Tidak ada catatan') ?></span>
        </div>

        <h3 class="section-title">Detail Menu</h3>
        <div class="menu-list">
            <?php if (!empty($itemsDetail)): ?>
                <?php foreach ($itemsDetail as $it): ?>
                <div class="menu-item">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <div class="menu-details">
                        <div class="menu-name"><?= esc($it['nama']) ?></div>
                        <div class="menu-variant"><?= esc(!empty($it['varian_nama']) ? $it['varian_nama'] : ($it['kategori'] ?? '')) ?></div>
                    </div>
                    <div class="menu-price-qty">
                        <span class="menu-price">Rp<?= number_format((float)$it['subtotal_item'], 0, ',', '.') ?></span>
                        <span class="menu-qty">x<?= (int)$it['qty'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--text-muted);">Belum ada menu yang dipilih.</p>
            <?php endif; ?>
        </div>

        <div class="calc-box">
            <div class="calc-row">
                <span>Subtotal Menu</span>
                <span>Rp<?= number_format((float)($subtotal ?? 0), 0, ',', '.') ?></span>
            </div>
            <div class="calc-row">
                <span>Biaya Stand / Pelayanan</span>
                <span>Rp<?= number_format((float)($biayaStand ?? 50000), 0, ',', '.') ?></span>
            </div>

            <div class="calc-total">
                <span>Total Pembayaran</span>
                <span class="total-price">Rp<?= number_format((float)($total ?? 0), 0, ',', '.') ?></span>
            </div>
        </div>

        <button type="button" class="btn-solid" onclick="document.getElementById('modalKonfirmasi').classList.add('active')">
            Lanjut <span class="material-symbols-outlined">arrow_forward</span>
        </button>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="modalKonfirmasi" class="modal-overlay">
        <div class="modal-box">
            <span class="material-symbols-outlined modal-icon">error</span>
            <h3 style="margin:0 0 10px 0; color:var(--primary);">Konfirmasi Booking</h3>
            <p style="font-size:0.95rem; color:var(--text-muted); margin-bottom:24px;">Apakah Anda yakin data acara dan pesanan menu stand sudah benar?</p>
            
            <form action="<?= base_url('pesan-stand/simpan') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-actions">
                    <button type="button" class="btn-batal" onclick="document.getElementById('modalKonfirmasi').classList.remove('active')">Batal</button>
                    <button type="submit" class="btn-yakin">Ya, Lanjut</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
