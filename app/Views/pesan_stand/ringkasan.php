<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ringkasan Pesanan — Siomay Dua Putri</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --primary: #3b198f; 
            --primary-hover: #2e1069; 
            --primary-light: #F4EFFF;
            --border-color: #E5E7EB; 
            --text-main: #1D1A22; 
            --text-muted: #6B7280; 
            --accent-red: #E11D48; 
            --bg-page: #F4F0FF;
            --t-fast: 200ms ease;
        }
        
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            margin: 0; 
            background-color: var(--bg-page); 
            background-image: url('<?= base_url("bg_2.png") ?>'); 
            background-size: cover; 
            background-position: top center;
            background-attachment: fixed; 
            color: var(--text-main); 
            padding-bottom: 60px; 
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
        }
        
        .wrapper { 
            width: 100%;
            max-width: 650px; 
            margin: 40px 20px; 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 60px rgba(59,25,143,0.08); 
            position: relative;
        }
        
        /* Alert Flash Message */
        .alert-error {
            background: #FEE2E2; 
            color: #B91C1C; 
            padding: 12px 16px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            font-size: 0.9rem;
            border: 1px solid #FECACA;
            font-weight: 500;
        }

        /* Top Nav Icon (Sesuai Gambar) */
        .top-nav { 
            display: flex; 
            align-items: center; 
            gap: 16px; 
            margin-bottom: 24px; 
            border-bottom: 1px dashed var(--border-color); 
            padding-bottom: 24px; 
        }
        .btn-back { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 44px; 
            height: 44px; 
            background: var(--primary-light); 
            color: var(--primary); 
            border-radius: 50%; 
            text-decoration: none; 
            transition: 0.2s; 
            flex-shrink: 0;
        }
        .btn-back:hover { background: #E4D8FF; }
        .page-title { 
            font-size: 1.4rem; 
            font-weight: 800; 
            color: var(--primary); 
            margin: 0; 
            letter-spacing: -0.5px; 
        }
        
        /* Section Styling */
        .section-title { font-size: 1.1rem; font-weight: 700; color: var(--primary); margin: 24px 0 16px 0; }
        
        /* Detail Informasi */
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
        .info-label { color: var(--text-muted); font-weight: 500; }
        .info-value { font-weight: 600; color: var(--text-main); text-align: right; max-width: 60%; word-break: break-word; }
        
        /* Detail Menu Card */
        .menu-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px; }
        .menu-item { display: flex; align-items: center; gap: 16px; padding: 12px; border: 1px solid #f3f4f6; border-radius: 16px; }
        .menu-img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; background: #f3f4f6; flex-shrink: 0; }
        .menu-details { flex: 1; }
        .menu-name { font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; color: var(--primary); }
        .menu-variant { font-size: 0.85rem; color: var(--text-muted); }
        .menu-price-qty { display: flex; align-items: center; gap: 12px; text-align: right; }
        .menu-price { font-weight: 700; font-size: 0.95rem; }
        .menu-qty { font-weight: 700; color: var(--text-muted); font-size: 0.95rem; }

        /* Ringkasan Biaya */
        .calc-box { padding-top: 24px; border-top: 1px dashed var(--border-color); }
        .calc-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; font-weight: 500; }
        .calc-total { display: flex; justify-content: space-between; margin-top: 20px; font-size: 1.1rem; font-weight: 700; color: var(--primary); align-items: center; padding-top: 16px; border-top: 1px dashed var(--border-color); }
        .calc-total .total-price { color: var(--accent-red); font-size: 1.5rem; font-weight: 800; }

        /* Tombol Aksi Bawah (Full Width Lanjut Saja) */
        .action-box { display: flex; margin-top: 32px; width: 100%; }
        .btn-solid { flex: 1; padding: 16px; background: var(--primary); border: none; color: white; border-radius: 12px; font-weight: 600; font-size: 1.05rem; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px; transition: 0.2s; font-family: 'Poppins', sans-serif; box-shadow: 0 8px 24px rgba(59, 25, 143, 0.15); }
        .btn-solid:hover { background: var(--primary-hover); }

        /* Modal Konfirmasi */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; opacity: 0; transition: opacity 0.2s ease-in-out; }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal-box { background: #fff; padding: 32px; border-radius: 20px; width: 90%; max-width: 400px; text-align: center; transform: scale(0.95); transition: transform 0.2s ease-in-out; }
        .modal-overlay.active .modal-box { transform: scale(1); }
        .modal-icon { font-size: 54px; color: #F59E0B; margin-bottom: 12px; font-variation-settings: 'FILL' 1; }
        .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
        .btn-batal { flex: 1; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 12px; cursor: pointer; background: #fff; font-weight: 600; font-size: 0.95rem; color: var(--text-muted); font-family: 'Poppins', sans-serif; transition: 0.2s; }
        .btn-batal:hover { background: #f9fafb; color: var(--text-main); }
        .btn-yakin { flex: 1; padding: 12px; border: none; border-radius: 12px; cursor: pointer; background: var(--primary); color: #fff; font-weight: 600; font-size: 0.95rem; font-family: 'Poppins', sans-serif; transition: 0.2s; }
        .btn-yakin:hover { background: var(--primary-hover); }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .wrapper { margin: 20px 16px; padding: 24px; border-radius: 20px; }
            .top-nav { margin-bottom: 20px; gap: 12px; padding-bottom: 16px; }
            .btn-back { width: 38px; height: 38px; }
            .btn-back .material-symbols-outlined { font-size: 20px; }
            .page-title { font-size: 1.25rem; }
            
            .menu-item { flex-direction: column; align-items: flex-start; gap: 12px; }
            .menu-price-qty { width: 100%; justify-content: space-between; }
            
            .info-row { flex-direction: column; gap: 4px; margin-bottom: 16px; }
            .info-value { text-align: left; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Notifikasi Pesan Error / Flashdata -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- TOP NAV: Hanya Icon Panah -->
        <div class="top-nav">
            <!-- Link disesuaikan kembali ke halaman data pemesan pesan stand -->
            <a href="<?= base_url('pesan-stand/data-pemesan') ?>" class="btn-back">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="page-title">Ringkasan Pesanan</h1>
        </div>

        <h3 class="section-title" style="margin-top: 0;">Detail Pesanan</h3>
        <?php 
            $metodeAcara = $orderData['metode_pengambilan'] ?? 'diantar';
            $tglAcara    = $biodataData['tanggal_acara'] ?? date('Y-m-d');
            $catatanText = $orderData['catatan'] ?? '';
            $alamatAcara = $biodataData['alamat'] ?? '';
        ?>
        <div class="info-row">
            <span class="info-label">Tanggal Acara</span>
            <span class="info-value"><?= date('d F Y', strtotime($tglAcara)) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Metode Penerimaan</span>
            <span class="info-value">
                <?php if ($metodeAcara === 'ambil_sendiri'): ?>
                    Ambil Sendiri (Jl. Rindai Permai Blok M No.30 — <a href="https://maps.app.goo.gl/dhxQZUKMSHdAQnNq7" target="_blank" style="color: var(--primary); text-decoration: underline; font-weight: 600;">Lihat Maps</a>)
                <?php else: ?>
                    Diantar via Maxim
                <?php endif; ?>
            </span>
        </div>
        <?php if ($metodeAcara === 'diantar' && !empty($alamatAcara)): ?>
            <div class="info-row">
                <span class="info-label">Alamat Pengantaran</span>
                <span class="info-value"><?= esc($alamatAcara) ?></span>
            </div>
        <?php endif; ?>
        <div class="info-row">
            <span class="info-label">Catatan</span>
            <span class="info-value" style="font-weight: 400;">
                <?= !empty($catatanText) ? esc($catatanText) : 'Tidak ada catatan.' ?>
            </span>
        </div>

        <h3 class="section-title">Detail Menu</h3>
        <div class="menu-list">
            <?php 
                $itemsList = !empty($orderData['items']) ? $orderData['items'] : (!empty($cartItems) ? $cartItems : []);
            ?>
            <?php if (!empty($itemsList)): ?>
                <?php foreach ($itemsList as $item): ?>
                    <?php 
                        $namaItem = $item['nama'] ?? ($item['produk']['nama'] ?? 'Menu');
                        $varianNama = !empty($item['varian_nama']) ? $item['varian_nama'] : (!empty($item['nama_varian']) ? $item['nama_varian'] : 'Porsi');
                        $namaLower = strtolower($namaItem);
                        $img_name = !empty($item['gambar']) ? $item['gambar'] : 'somay.png';
                        if (empty($item['gambar'])) {
                            if (str_contains($namaLower, 'keju')) { $img_name = 'siomay_keju.jpeg'; }
                            elseif (str_contains($namaLower, 'telur')) { $img_name = 'simay_telur.png'; }
                            elseif (str_contains($namaLower, 'jumbo')) { $img_name = 'siomay_jumbo.jpeg'; }
                            elseif (str_contains($namaLower, 'urat')) { $img_name = 'siomay_urat.jpeg'; }
                            elseif (str_contains($namaLower, 'ikan')) { $img_name = 'somay_ikan.jpeg'; }
                            elseif (str_contains($namaLower, 'batagor')) { $img_name = 'menu_4.png'; }
                            elseif (str_contains($namaLower, 'lumpia')) { $img_name = 'menu_2.jpeg'; }
                            elseif (str_contains($namaLower, 'es jeruk') || str_contains($namaLower, 'jeruk')) { $img_name = 'menu_5.png'; }
                            elseif (str_contains($namaLower, 'mie')) { $img_name = 'menu_3.png'; }
                            elseif (str_contains($namaLower, 'pentol')) { $img_name = 'pentol.jpeg'; }
                            elseif (str_contains($namaLower, 'tahu')) { $img_name = 'tahu.png'; }
                            elseif (str_contains($namaLower, 'nugget')) { $img_name = 'nugget.jpeg'; }
                            elseif (str_contains($namaLower, 'sosis')) { $img_name = 'sosis.jpeg'; }
                            elseif (str_contains($namaLower, 'siomay') || str_contains($namaLower, 'somay')) { $img_name = 'somay.png'; }
                        }
                        $sub = $item['subtotal'] ?? (($item['harga'] ?? 0) * ($item['qty'] ?? $item['jumlah'] ?? 1));
                        $qty = $item['qty'] ?? $item['jumlah'] ?? 1;
                    ?>
                    <div class="menu-item">
                        <img src="<?= base_url('assets/img/' . $img_name) ?>" class="menu-img" alt="<?= esc($namaItem) ?>" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                        <div class="menu-details">
                            <div class="menu-name"><?= esc($namaItem) ?></div>
                            <div class="menu-variant"><?= esc($varianNama) ?></div>
                        </div>
                        <div class="menu-price-qty">
                            <span class="menu-price">Rp<?= number_format((float)$sub, 0, ',', '.') ?></span>
                            <span class="menu-qty">x<?= esc($qty) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center; padding: 20px; color: var(--text-muted);">Keranjang pesanan kosong.</div>
            <?php endif; ?>
        </div>

        <div class="calc-box">
            <div class="calc-row">
                <span>Subtotal Menu</span>
                <span>Rp<?= number_format($subtotal ?? 0, 0, ',', '.') ?></span>
            </div>
            <div class="calc-row">
                <span>Ongkir</span>
                <?php if ($curMetode === 'diantar' && $curLokasi === 'Undata'): ?>
                    <span>Rp<?= number_format($ongkir ?? 5000, 0, ',', '.') ?></span>
                <?php elseif ($curMetode === 'diantar'): ?>
                    <span style="color: var(--text-muted); font-weight: 400;">Rp0 (Dibayar langsung ke kurir Maxim)</span>
                <?php else: ?>
                    <span>Rp0</span>
                <?php endif; ?>
            </div>

            <div class="calc-total">
                <span>Total Pembayaran</span>
                <span class="total-price">Rp<?= number_format($total ?? $grandTotal ?? ($subtotal + ($ongkir ?? 0)), 0, ',', '.') ?></span>
            </div>
        </div>

        <!-- TOMBOL AKSI BAWAH (Hanya Tombol Lanjut) -->
        <div class="action-box">
            <button type="button" class="btn-solid" onclick="openModal()">
                Lanjut <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </div>

    <!-- Modal Konfirmasi Pesan Antar -->
    <div id="modalKonfirmasi" class="modal-overlay" onclick="closeModalOnOverlay(event)">
        <div class="modal-box">
            <span class="material-symbols-outlined modal-icon">error</span>
            <h3 style="margin:0 0 10px 0; color:var(--primary); font-size: 1.4rem;">Konfirmasi Pesanan</h3>
            <p style="font-size:0.95rem; color:var(--text-muted); margin-bottom:24px;">Apakah Anda yakin detail pesanan dan menu sudah benar?</p>
            
            <form action="<?= base_url('pesan-stand/simpan') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-actions">
                    <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-yakin">Ya, Lanjut</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalKonfirmasi').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modalKonfirmasi').classList.remove('active');
        }

        function closeModalOnOverlay(event) {
            if (event.target.id === 'modalKonfirmasi') {
                closeModal();
            }
        }
    </script>
</body>
</html>