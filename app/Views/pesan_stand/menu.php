<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Pilih Menu Acara — Siomay Dua Putri') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    
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

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-page);
            color: var(--text-main);
            position: relative;
        }

        /* Hiasan Bulat Background + Gambar bg_2.png */
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
        .circle-1 { position: absolute; top: -30px; left: -30px; width: 140px; height: 140px; background: rgba(59, 25, 143, 0.05); border-radius: 50%; }
        .circle-2 { position: absolute; top: 60px; left: 240px; width: 50px; height: 50px; background: rgba(59, 25, 143, 0.07); border-radius: 50%; }
        .circle-3 { position: absolute; top: 120px; right: 15%; width: 90px; height: 90px; background: rgba(59, 25, 143, 0.04); border-radius: 50%; }

        /* Wrapper Form (Satu Frame) */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
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
        }
        
        /* Area Konten Putih */
        .form-body {
            padding: 40px 40px 30px 40px;
            background: #ffffff;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
        }

        /* Header (Sama persis seperti Pesan Antar) */
        .page-header { margin-bottom: 32px; display: flex; align-items: flex-start; gap: 16px; }
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
        .btn-back-icon:hover { background-color: #E4D8FF; }
        .page-header-text h2 { color: var(--accent-red); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 6px 0; }
        .page-header-text h1 { font-size: 1.8rem; margin: 0 0 4px 0; color: var(--primary); font-weight: 700; }
        .page-header-text p { color: var(--text-muted); font-size: 0.85rem; margin: 0; }

        .alert-error {
            background: #FEE2E2;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .section-title { font-size: 1.05rem; font-weight: 700; margin-bottom: 12px; color: var(--primary); }
        .form-section { margin-bottom: 32px; }

        /* Box Metode Penerimaan */
        .method-options { display: flex; gap: 16px; }
        .method-card { flex: 1; position: relative; background: #ffffff; border: 1.5px solid var(--border-color); border-radius: 12px; padding: 18px 16px; cursor: pointer; transition: all var(--t-fast); display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04); }
        .method-card input { position: absolute; opacity: 0; cursor: pointer; }
        .method-icon { color: #9CA3AF; font-size: 28px; transition: color var(--t-fast); font-variation-settings: 'FILL' 0; }
        
        .method-text strong { display: block; font-size: 0.95rem; color: var(--primary); margin-bottom: 4px; }
        .method-text span.desc { display: block; font-size: 0.8rem; color: var(--text-muted); line-height: 1.3; }
        
        /* Active State Metode */
        .method-card:has(input:checked) { background-color: var(--primary-light); border-color: var(--primary); box-shadow: 0 6px 20px rgba(59, 25, 143, 0.15); }
        .method-card:has(input:checked) .method-icon { color: var(--primary); font-variation-settings: 'FILL' 1; }

        /* Menu Grid (Berjejer 3) */
        .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; scroll-margin-top: 20px; }
        .menu-card { background: #ffffff; border-radius: 16px; padding: 20px; border: 1.5px solid var(--border-color); display: flex; flex-direction: column; transition: transform var(--t-fast), border-color var(--t-fast); }
        .menu-card:hover { transform: translateY(-3px); border-color: #d8cbf5; }
        .menu-img { width: 100%; height: 140px; object-fit: contain; margin-bottom: 16px; border-radius: 8px; background: #F9FAFB; } 
        .menu-card h3 { margin: 0 0 12px 0; font-size: 1.1rem; color: var(--primary); font-weight: 700; }
        
        .menu-select { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1.5px solid var(--border-color); font-family: inherit; font-size: 0.85rem; font-weight: 500; color: var(--text-main); background-color: #ffffff; outline: none; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b198f' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; margin-bottom: 16px; transition: border var(--t-fast); }
        .menu-select:focus { border-color: var(--primary); }
        .single-price-badge { font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 16px; }
        
        .menu-action { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
        .qty-control { display: flex; align-items: center; border: 1.5px solid var(--border-color); border-radius: 8px; overflow: hidden; background: #ffffff; }
        .qty-btn { background: #F9FAFB; border: none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: var(--primary); cursor: pointer; font-size: 1.1rem; font-weight: 600; transition: background var(--t-fast); }
        .qty-btn:hover { background: var(--primary-light); }
        .qty-input { width: 40px; text-align: center; border: none; border-left: 1.5px solid var(--border-color); border-right: 1.5px solid var(--border-color); background: transparent; font-family: inherit; font-weight: 700; font-size: 0.95rem; color: var(--text-main); outline: none; -moz-appearance: textfield; }
        
        .item-price { color: var(--accent-red); font-weight: 700; font-size: 1.1rem; }

        /* Box Catatan */
        .notes-input-wrapper { position: relative; background: #ffffff; border-radius: 12px; border: 1.5px solid var(--border-color); transition: border var(--t-fast); }
        .notes-input-wrapper:focus-within { border-color: var(--primary); }
        textarea.notes-input { width: 100%; height: 100px; padding: 14px 14px 28px 14px; border: none; border-radius: 12px; font-family: inherit; font-size: 0.95rem; resize: none; background: transparent; outline: none; }
        .char-count { position: absolute; bottom: 8px; right: 12px; font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }

        /* AREA UNGU KERANJANG - STICKY FOOTER */
        .form-footer {
            position: -webkit-sticky; 
            position: sticky; 
            bottom: 0;
            z-index: 100;
            background: var(--primary); 
            padding: 24px 40px; 
            display: flex; 
            align-items: center;
            justify-content: space-between; 
            border: none; 
            width: 100%;
            cursor: pointer; 
            transition: background var(--t-fast); 
            text-align: left;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            box-shadow: 0 -10px 30px rgba(59, 25, 143, 0.15); 
        }
        .form-footer:hover { 
            background: var(--primary-hover); 
        }
        
        .footer-left { display: flex; align-items: center; gap: 16px; color: #ffffff; }
        .cart-icon-wrapper { position: relative; display: flex; align-items: center; }
        .cart-icon-wrapper .material-symbols-outlined { font-size: 36px; font-variation-settings: 'FILL' 0; }
        .cart-badge { 
            position: absolute; 
            top: -4px; 
            right: -8px; 
            background: var(--accent-red); 
            color: #ffffff; 
            font-size: 0.75rem; 
            font-weight: 700; 
            min-width: 20px; 
            height: 20px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 0 4px; 
            border: 2px solid var(--primary);
        }
        
        .cart-text-group { display: flex; flex-direction: column; align-items: flex-start; line-height: 1.2; }
        .footer-items-text { font-size: 0.85rem; font-weight: 600; opacity: 0.9; }
        .footer-price { font-size: 1.3rem; font-weight: 700; color: #ffffff; margin-top: 2px; }
        
        .footer-right { color: #ffffff; font-weight: 600; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .form-wrapper { padding: 16px 12px; }
            .form-body { padding: 24px 16px 16px 16px; }
            
            .btn-back-icon { width: 38px; height: 38px; margin-top: 2px; }
            .btn-back-icon .material-symbols-outlined { font-size: 20px !important; }
            .page-header-text h2 { font-size: 0.75rem; }
            .page-header-text h1 { font-size: 1.3rem; }
            .page-header-text p { font-size: 0.75rem; }
            
            .section-title { font-size: 0.95rem; margin-bottom: 10px; }
            .form-section { margin-bottom: 24px; }
            
            .method-options { flex-direction: column; gap: 10px; }
            .method-card { padding: 12px 14px; gap: 10px; }
            .method-icon { font-size: 24px; }
            .method-text strong { font-size: 0.85rem; margin-bottom: 2px; }
            .method-text span.desc { font-size: 0.7rem; }
            
            .menu-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } 
            .menu-card { padding: 12px; border-radius: 12px; }
            .menu-img { height: 80px; margin-bottom: 10px; border-radius: 6px; }
            .menu-card h3 { font-size: 0.85rem; margin-bottom: 8px; }
            .menu-select { padding: 6px; font-size: 0.75rem; margin-bottom: 10px; }
            .single-price-badge { font-size: 0.75rem; margin-bottom: 10px; }
            
            .menu-action { flex-direction: column; align-items: flex-start; gap: 8px; }
            .qty-control { width: 100%; justify-content: space-between; }
            .qty-btn { width: 28px; height: 28px; font-size: 1.1rem; }
            .qty-input { width: 36px; font-size: 0.9rem; }
            .item-price { font-size: 0.95rem; align-self: flex-start; }
            
            .notes-input-wrapper textarea.notes-input { font-size: 0.85rem; padding: 10px 10px 24px 10px; height: 80px; }
            
            .form-footer { 
                flex-direction: row; 
                padding: 14px 16px; 
                gap: 0; 
                align-items: center; 
                justify-content: space-between;
                text-align: left;
            }
            .footer-left { flex-direction: row; gap: 12px; }
            .cart-icon-wrapper .material-symbols-outlined { font-size: 28px; }
            .cart-badge { font-size: 0.65rem; min-width: 16px; height: 16px; top: -4px; right: -4px; border-width: 1.5px; }
            .cart-text-group { align-items: flex-start; }
            .footer-items-text { font-size: 0.75rem; }
            .footer-price { font-size: 1.1rem; }
            .footer-right { font-size: 0.95rem; }
        }
    </style>
</head>
<body>

    <!-- Hiasan Background -->
    <div class="bg-decoration">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <!-- Wrapper Tengah -->
    <div class="form-wrapper">
        
        <form class="form-card" action="<?= base_url('pesan-stand/menu') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Area Putih -->
            <div class="form-body">
                
                <!-- Header Presisi -->
                <div class="page-header">
                    <a href="<?= base_url('pesan-stand/tentang') ?>" class="btn-back-icon" aria-label="Kembali">
                        <span class="material-symbols-outlined" style="font-size: 24px;">arrow_back</span>
                    </a>
                    <div class="page-header-text">
                        <h2>PESAN ACARA</h2>
                        <h1>Langkah 1: Pilih Menu & Metode</h1>
                        <p>Tentukan pilihan menu porsi besar dan metode pengantaran pesanan acara Anda.</p>
                    </div>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert-error">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <!-- Metode Pengambilan -->
                <div class="form-section">
                    <div class="section-title">Metode Pengambilan</div>
                    <?php $selMetode = old('metode_pengambilan') ?? $sessionOrder['metode_pengambilan'] ?? 'diantar'; ?>
                    <div class="method-options">
                        <label class="method-card">
                            <input type="radio" name="metode_pengambilan" value="diantar" <?= $selMetode === 'diantar' ? 'checked' : '' ?> onchange="updateMethodIcon()">
                            <span class="material-symbols-outlined method-icon" id="iconDiantar">radio_button_unchecked</span>
                            <div class="method-text">
                                <strong>Diantar (via Maxim)</strong>
                                <span class="desc">Diantar langsung ke lokasi acara</span>
                            </div>
                        </label>
                        <label class="method-card">
                            <input type="radio" name="metode_pengambilan" value="ambil_sendiri" <?= $selMetode === 'ambil_sendiri' ? 'checked' : '' ?> onchange="updateMethodIcon()">
                            <span class="material-symbols-outlined method-icon" id="iconAmbil">storefront</span>
                            <div class="method-text">
                                <strong>Ambil Sendiri</strong>
                                <span class="desc">Jl. Rindai Permai Blok M No.30 (<a href="https://maps.app.goo.gl/dhxQZUKMSHdAQnNq7" target="_blank" onclick="event.stopPropagation()" style="color: var(--primary); text-decoration: underline; font-weight: 600;">Lihat Maps</a>)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Daftar Menu Porsi Besar -->
                <div class="form-section">
                    <div class="section-title">Pilih Menu Porsi Besar</div>
                    <div class="menu-grid">
                        <?php foreach ($produkList as $p): ?>
                            <?php 
                                $pId = (int) $p['id'];
                                $savedItem = $sessionOrder['items'][$pId] ?? null;
                                $savedQty = $savedItem['qty'] ?? 0;
                                $savedVarianId = $savedItem['varian_id'] ?? null;
                                
                                // Penentuan Gambar Otomatis
                                $namaLower = strtolower(trim($p['nama'] ?? ''));
                                $img_name = !empty($p['gambar']) ? $p['gambar'] : 'somay.png';

                                if (empty($p['gambar'])) {
                                    if (str_contains($namaLower, 'keju')) {
                                        $img_name = 'siomay_keju.jpeg';
                                    } elseif (str_contains($namaLower, 'telur')) {
                                        $img_name = 'simay_telur.png';
                                    } elseif (str_contains($namaLower, 'jumbo')) {
                                        $img_name = 'siomay_jumbo.jpeg';
                                    } elseif (str_contains($namaLower, 'urat')) {
                                        $img_name = 'siomay_urat.jpeg';
                                    } elseif (str_contains($namaLower, 'ikan')) {
                                        $img_name = 'somay_ikan.jpeg';
                                    } elseif (str_contains($namaLower, 'batagor')) {
                                        $img_name = 'menu_4.png';
                                    } elseif (str_contains($namaLower, 'lumpia')) {
                                        $img_name = 'menu_2.jpeg';
                                    } elseif (str_contains($namaLower, 'es jeruk') || str_contains($namaLower, 'jeruk')) {
                                        $img_name = 'menu_5.png';
                                    } elseif (str_contains($namaLower, 'mie')) {
                                        $img_name = 'menu_3.png';
                                    } elseif (str_contains($namaLower, 'pentol')) {
                                        $img_name = 'pentol.jpeg';
                                    } elseif (str_contains($namaLower, 'tahu')) {
                                        $img_name = 'tahu.png';
                                    } elseif (str_contains($namaLower, 'nugget')) {
                                        $img_name = 'nugget.jpeg';
                                    } elseif (str_contains($namaLower, 'sosis')) {
                                        $img_name = 'sosis.jpeg';
                                    } elseif (str_contains($namaLower, 'siomay') || str_contains($namaLower, 'somay')) {
                                        $img_name = 'somay.png';
                                    }
                                }
                            ?>
                            <div class="menu-card">
                                <img src="<?= base_url('assets/img/' . $img_name) ?>" alt="<?= esc($p['nama']) ?>" class="menu-img" onerror="this.src='https://placehold.co/200x140?text=<?= urlencode($p['nama']) ?>'">
                                <h3><?= esc($p['nama']) ?></h3>
                                
                                <?php if (!empty($p['varians'])): 
                                    $unitLabel = 'Pilih pcs';
                                    if (str_contains($namaLower, 'kukus') || str_contains($namaLower, 'tahu')) {
                                        $unitLabel = 'Pilih kg';
                                    }
                                ?>
                                    <!-- Menampilkan Dropdown Jika Ada Varian -->
                                    <select name="items[<?= $pId ?>][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_<?= $pId ?>', 'qty_<?= $pId ?>')" autocomplete="off">
                                        <option value="" disabled <?= empty($savedVarianId) ? 'selected' : '' ?>><?= $unitLabel ?></option>
                                        <?php foreach ($p['varians'] as $v): ?>
                                            <option value="<?= (int) $v['id'] ?>" data-harga="<?= (float)$v['harga'] ?>" <?= $savedVarianId == $v['id'] ? 'selected' : '' ?>>
                                                <?= esc($v['nama_varian']) ?> — Rp<?= number_format((float)$v['harga'], 0, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <!-- Menampilkan Harga Fix Jika Tidak Ada Varian -->
                                    <input type="hidden" class="single-product-price" data-harga="<?= (float)$p['harga'] ?>">
                                    <div class="single-price-badge">Rp <?= number_format((float)$p['harga'], 0, ',', '.') ?></div>
                                <?php endif; ?>
                                
                                <div class="menu-action">
                                    <div class="qty-control">
                                        <button type="button" class="qty-btn" onclick="changeQty('qty_<?= $pId ?>', -1, event)">−</button>
                                        <input type="number" id="qty_<?= $pId ?>" name="items[<?= $pId ?>][qty]" class="qty-input" value="<?= (float) $savedQty ?>" min="0" oninput="manualInputQty(this, 'price_<?= $pId ?>')" onfocus="if(this.value == '0') this.value = '';" onblur="if(this.value === '' || this.value < 0) { this.value = '0'; manualInputQty(this, 'price_<?= $pId ?>'); }" autocomplete="off">
                                        <button type="button" class="qty-btn" onclick="changeQty('qty_<?= $pId ?>', 1, event)">+</button>
                                    </div>
                                    <div class="item-price" id="price_<?= $pId ?>">Rp 0</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-title">Catatan Tambahan (Opsional)</div>
                    <div class="notes-input-wrapper">
                        <textarea id="catatanInput" class="notes-input" name="catatan" placeholder="Contoh: Tolong siomay dipisah dengan bumbu kacang, bumbu pedas dipisah..." maxlength="200" oninput="updateCharCount(this)"><?= esc(old('catatan') ?? $sessionOrder['catatan'] ?? '') ?></textarea>
                        <div class="char-count" id="charCountDisplay">0/200</div>
                    </div>
                </div>

            </div> <!-- Akhir Area Putih -->

            <!-- Area Ungu Keranjang (Bagian Bawah Frame - STICKY) -->
            <button type="submit" class="form-footer">
                <div class="footer-left">
                    <div class="cart-icon-wrapper">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <div class="cart-badge" id="totalQtyBadge">0</div>
                    </div>
                    <div class="cart-text-group">
                        <span class="footer-items-text"><span id="totalItemsText">0</span> Item</span>
                        <span class="footer-price" id="grandTotalText">Rp 0</span>
                    </div>
                </div>
                <div class="footer-right">
                    Lanjut <span class="material-symbols-outlined">arrow_forward</span>
                </div>
            </button>
            
        </form>
    </div>

    <!-- Script Tampilan (Tidak mengubah logika backend) -->
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);

        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

        function updateCharCount(el) {
            document.getElementById('charCountDisplay').innerText = el.value.length + '/200';
        }

        function updateMethodIcon() {
            const diantar = document.querySelector('input[value="diantar"]').checked;
            document.getElementById('iconDiantar').textContent = diantar ? 'check_circle' : 'radio_button_unchecked';
            const ambil = document.querySelector('input[value="ambil_sendiri"]').checked;
            document.getElementById('iconAmbil').textContent = ambil ? 'check_circle' : 'storefront';
        }

        function changeQty(inputId, delta, event) {
            if (event) event.preventDefault(); 
            
            const input = document.getElementById(inputId);
            let val = parseFloat(input.value) || 0;
            const selectElement = input.closest('.menu-card').querySelector('.menu-select');
            
            if (selectElement && selectElement.value === "" && delta > 0) {
                alert("Silakan pilih varian terlebih dahulu.");
                return;
            }

            val += delta;
            if (val <= 0) {
                val = 0;
            }
            input.value = val;
            
            if (selectElement) {
                const match = selectElement.getAttribute('onchange').match(/price_(\d+)/);
                if (match) {
                    updateHarga(selectElement, match[0], inputId);
                } else {
                    updateTotal();
                }
            } else {
                const match = inputId.match(/\d+/);
                if (match) {
                    manualInputQty(input, 'price_' + match[0]);
                } else {
                    updateTotal();
                }
            }
        }

        function manualInputQty(inputEl, priceId) {
            let qty = parseFloat(inputEl.value);
            if (isNaN(qty) || qty < 0) qty = 0;
            inputEl.value = qty; 

            const card = inputEl.closest('.menu-card');
            const selectEl = card.querySelector('.menu-select');
            const singlePriceEl = card.querySelector('.single-product-price');

            if (selectEl && selectEl.value === "" && qty > 0) {
                alert("Silakan pilih varian terlebih dahulu.");
                inputEl.value = 0;
                return;
            }

            let hargaSatuan = 0;
            if (selectEl && selectEl.selectedIndex >= 0) {
                hargaSatuan = parseFloat(selectEl.options[selectEl.selectedIndex].dataset.harga) || 0;
            } else if (singlePriceEl) {
                hargaSatuan = parseFloat(singlePriceEl.dataset.harga) || 0;
            }

            const subtotal = hargaSatuan * qty;
            
            let displayPrice = formatRupiah(subtotal);
            if(!displayPrice.includes("Rp ")) displayPrice = displayPrice.replace("Rp", "Rp ");
            document.getElementById(priceId).innerText = displayPrice;
            
            updateTotal();
        }

        function updateHarga(selectEl, priceId, inputId) {
            const inputEl = document.getElementById(inputId);
            
            if (selectEl.value === "") {
                inputEl.value = 0;
            } else if (parseFloat(inputEl.value) === 0) {
                inputEl.value = 1; 
            }

            const hargaSatuan = parseFloat(selectEl.options[selectEl.selectedIndex].dataset.harga) || 0;
            const qty = parseFloat(inputEl.value) || 0;
            
            let displayPrice = formatRupiah(hargaSatuan * qty);
            if(!displayPrice.includes("Rp ")) displayPrice = displayPrice.replace("Rp", "Rp ");
            document.getElementById(priceId).innerText = displayPrice;
            
            updateTotal();
        }

        function updateTotal() {
            let grandTotal = 0;
            let totalItems = 0;
            
            document.querySelectorAll('.menu-card').forEach(card => {
                const selectEl = card.querySelector('.menu-select');
                const singlePriceEl = card.querySelector('.single-product-price');
                const inputEl = card.querySelector('.qty-input');
                const priceEl = card.querySelector('.item-price');
                
                if (!inputEl) return;

                let hargaSatuan = 0;
                if (selectEl && selectEl.selectedIndex >= 0) {
                    const opt = selectEl.options[selectEl.selectedIndex];
                    if (opt) {
                        hargaSatuan = parseFloat(opt.getAttribute('data-harga') || opt.dataset.harga) || 0;
                    }
                } else if (singlePriceEl) {
                    hargaSatuan = parseFloat(singlePriceEl.getAttribute('data-harga') || singlePriceEl.dataset.harga) || 0;
                }

                const qty = parseFloat(inputEl.value) || 0;
                const subtotal = hargaSatuan * qty;
                
                if (priceEl) {
                    let disp = formatRupiah(subtotal);
                    if(!disp.includes("Rp ")) disp = disp.replace("Rp", "Rp ");
                    priceEl.innerText = disp;
                }
                
                grandTotal += subtotal;
                totalItems += qty;
            });

            const b = document.getElementById('totalQtyBadge');
            if (b) b.innerText = totalItems;
            
            const t = document.getElementById('totalItemsText');
            if (t) t.innerText = totalItems;
            
            const g = document.getElementById('grandTotalText');
            if (g) {
                let dispG = formatRupiah(grandTotal);
                if(!dispG.includes("Rp ")) dispG = dispG.replace("Rp", "Rp ");
                g.innerText = dispG;
            }
        }

        window.onload = function() {
            updateCharCount(document.getElementById('catatanInput'));
            updateMethodIcon();

            // Render existing values mapping on load
            document.querySelectorAll('.menu-select').forEach(sel => {
                if (sel.value !== "") {
                    const matchPrice = sel.getAttribute('onchange') ? sel.getAttribute('onchange').match(/price_(\d+)/) : null;
                    const matchQty = sel.getAttribute('onchange') ? sel.getAttribute('onchange').match(/qty_(\d+)/) : null;
                    const priceId = matchPrice ? matchPrice[0] : null;
                    const inputId = matchQty ? matchQty[0] : null;
                    if (priceId && inputId) updateHarga(sel, priceId, inputId);
                }
            });

            // Fallback render single item price
            document.querySelectorAll('.qty-input').forEach(input => {
                const match = input.id.match(/\d+/);
                if (match) {
                    manualInputQty(input, 'price_' + match[0]);
                }
            });

            updateTotal();
        }
    </script>
</body>
</html>