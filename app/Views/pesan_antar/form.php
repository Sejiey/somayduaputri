<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pesanan — Siomay Dua Putri</title>
    
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
            --bg-page: #FBF9FF;
            --accent-red: #E11D48;
            --t-fast: 200ms ease;
        }

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg.png") ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-main);
            padding-bottom: 60px; 
            position: relative;
        }

        /* Hiasan Bulat Background */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
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
            padding: 40px 20px;
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
        
        /* Area Konten Putih */
        .form-body {
            padding: 40px 40px 30px 40px;
        }

        /* Header */
        .page-header { margin-bottom: 32px; text-align: left; }
        .page-header h2 { color: var(--accent-red); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 6px 0; }
        .page-header h1 { font-size: 1.8rem; margin: 0; color: var(--primary); font-weight: 700; }
        
        .alert { background: #FEE2E2; color: #991B1B; padding: 12px 16px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; }
        
        .section-title { font-size: 1.05rem; font-weight: 700; margin-bottom: 12px; color: var(--primary); }
        .form-section { margin-bottom: 32px; }

        /* Date Picker */
        .date-wrapper { position: relative; background: #ffffff; border: 1.5px solid var(--border-color); border-radius: 12px; padding: 14px 16px; display: inline-flex; align-items: center; justify-content: space-between; width: 280px; transition: border var(--t-fast); }
        .date-wrapper:focus-within { border-color: var(--primary); }
        .date-wrapper input { border: none; outline: none; font-family: inherit; font-size: 0.95rem; font-weight: 500; color: var(--text-main); background: transparent; width: 100%; cursor: pointer; }
        .date-wrapper input::-webkit-calendar-picker-indicator { background: transparent; bottom: 0; color: transparent; cursor: pointer; height: auto; left: 0; position: absolute; right: 0; top: 0; width: auto; z-index: 10; }
        .date-wrapper .material-symbols-outlined { color: var(--primary); font-size: 24px; z-index: 1; pointer-events: none; }

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
        
        /* Box Metode Penerimaan */
        .method-options { display: flex; gap: 16px; }
        .method-card { flex: 1; position: relative; background: #ffffff; border: none; border-radius: 12px; padding: 18px 16px; cursor: pointer; transition: all var(--t-fast); display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08); }
        .method-card input { position: absolute; opacity: 0; cursor: pointer; }
        .method-icon { color: #9CA3AF; font-size: 28px; transition: color var(--t-fast); font-variation-settings: 'FILL' 0; }
        
        .method-text strong { display: block; font-size: 0.95rem; color: var(--primary); margin-bottom: 4px; }
        .method-text span.desc { display: block; font-size: 0.8rem; color: var(--text-muted); line-height: 1.3; }
        
        /* Active State Metode */
        .method-card:has(input:checked) { background-color: var(--primary-light); box-shadow: 0 6px 20px rgba(59, 25, 143, 0.25); }
        .method-card:has(input:checked) .method-icon { color: var(--primary); font-variation-settings: 'FILL' 1; }

        /* AREA UNGU KERANJANG */
        .form-footer {
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
            .form-wrapper { padding: 20px 16px; }
            .form-body { padding: 24px 20px 16px 20px; }
            .form-footer { padding: 20px; }
            .date-wrapper { width: 100%; }
            .menu-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
            .menu-card { padding: 10px; border-radius: 12px; }
            .menu-img { height: 70px; margin-bottom: 10px; }
            .menu-card h3 { font-size: 0.85rem; margin-bottom: 10px; }
            .menu-select { padding: 6px; font-size: 0.75rem; margin-bottom: 10px; }
            .single-price-badge { font-size: 0.75rem; margin-bottom: 10px; }
            .menu-action { flex-direction: column; align-items: flex-start; gap: 8px; }
            .qty-control { width: 100%; justify-content: space-between; }
            .qty-btn { width: 28px; height: 28px; }
            .qty-input { width: 100%; }
            .item-price { font-size: 0.95rem; align-self: flex-start; }
            
            .method-options { flex-direction: column; }
            .page-header h1 { font-size: 1.5rem; }
            
            .form-footer { flex-direction: column; gap: 16px; align-items: center; text-align: center; }
            .footer-left { flex-direction: column; gap: 8px; }
            .cart-text-group { align-items: center; }
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
        <!-- Form Utama (Satu Frame Menyatu) -->
        <form class="form-card" id="orderForm" method="post" action="<?= base_url('pesan-antar/form') ?>" autocomplete="off" onsubmit="return validasiMinimum(event)">
            <?= csrf_field() ?>
            
            <!-- Area Putih -->
            <div class="form-body">
                <div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <h2>PESAN ANTAR</h2>
                        <h1 style="margin-bottom: 4px;">Lengkapi Pesanan Anda</h1>
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Pilih menu dan tentukan tanggal pesanan yang kamu butuhkan.</p>
                    </div>
                    <a href="<?= base_url('/') ?>" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 10px; border: 1.5px solid var(--primary); color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.85rem; background: #ffffff; transition: background 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                        Kembali ke Beranda
                    </a>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
                <?php if (isset($errors) && $errors): ?>
                    <div class="alert">
                        <ul style="margin:0; padding-left:20px;">
                            <?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Tanggal Pesanan -->
                <div class="form-section">
                    <div class="section-title">Tanggal Pesanan</div>
                    <div class="date-wrapper" onclick="document.getElementById('tgl_pesan').showPicker()">
                        <input type="date" id="tgl_pesan" name="tanggal_dibutuhkan" min="<?= esc($besok ?? '') ?>" value="<?= esc($tanggalValue ?? '') ?>" required>
                        <span class="material-symbols-outlined">event</span>
                    </div>
                </div>

                <!-- Menu (Berjejer 3 Kolom) -->
                <div class="form-section" id="menuSection">
                    <div class="section-title">Pilih Menu</div>
                    <div class="menu-grid">
                        
                        <?php if (isset($produkList) && is_array($produkList)): ?>
                            <?php foreach ($produkList as $item): ?>
                                <?php 
                                    $id_produk = (int) $item['id'];
                                    if (!in_array($id_produk, [1, 2, 4, 7, 8, 9])) {
                                        continue;
                                    }

                                    $isAktifAntar = in_array($id_produk, [1, 2, 4]);
                                    
                                    $nama_produk = strtolower($item['nama']);
                                    $img_name = 'menu_1.png';
                                    if (strpos($nama_produk, 'lumpia') !== false) {
                                        $img_name = 'menu_2.jpeg';
                                    } elseif (strpos($nama_produk, 'siomay') !== false || strpos($nama_produk, 'somay') !== false) {
                                        $img_name = 'somay.png';
                                    } elseif (strpos($nama_produk, 'tahu') !== false) {
                                        $img_name = 'tahu.png';
                                    }
                                ?>
                                <?php if ($isAktifAntar): ?>
                                    <div class="menu-card">
                                        <img src="<?= base_url('assets/img/' . $img_name) ?>" alt="<?= esc($item['nama']) ?>" class="menu-img" onerror="this.src='https://placehold.co/200x140?text=<?= urlencode($item['nama']) ?>'">
                                        <h3><?= esc($item['nama']) ?></h3>
                                        
                                        <?php if (!empty($item['varians'])): ?>
                                            <select class="menu-select" name="items[<?= esc($item['id']) ?>][varian_id]" onchange="updateHarga(this, 'price_<?= esc($item['id']) ?>', 'qty_<?= esc($item['id']) ?>')" autocomplete="off">
                                                <option value="" data-harga="0">Pilih <?= esc($item['satuan'] ?? 'Varian') ?></option>
                                                <?php foreach ($item['varians'] as $v): ?>
                                                    <option value="<?= esc($v['id']) ?>" data-harga="<?= esc($v['harga'] ?? $item['harga']) ?>" <?= isset($cartItems[$item['id']]['varian_id']) && (int)$cartItems[$item['id']]['varian_id'] === (int)$v['id'] ? 'selected' : '' ?>>
                                                        <?= esc($v['nama_varian']) ?> - Rp<?= esc(number_format((float)($v['harga'] ?? $item['harga']), 0, ',', '.')) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <input type="hidden" class="single-product-price" data-harga="<?= esc($item['harga']) ?>">
                                            <div class="single-price-badge">Rp<?= esc(number_format((float)$item['harga'], 0, ',', '.')) ?> / <?= esc($item['satuan'] ?? 'pcs') ?></div>
                                        <?php endif; ?>
                                        
                                        <div class="menu-action">
                                            <div class="qty-control">
                                                <button type="button" class="qty-btn" onclick="changeQty('qty_<?= esc($item['id']) ?>', -1, event)">−</button>
                                                <input type="number" id="qty_<?= esc($item['id']) ?>" name="items[<?= esc($item['id']) ?>][qty]" class="qty-input" value="<?= esc($cartItems[$item['id']]['jumlah'] ?? 0) ?>" min="0" oninput="manualInputQty(this, 'price_<?= esc($item['id']) ?>')" onfocus="if(this.value == '0') this.value = '';" onblur="if(this.value === '' || this.value < 0) { this.value = '0'; manualInputQty(this, 'price_<?= esc($item['id']) ?>'); }" autocomplete="off">
                                                <button type="button" class="qty-btn" onclick="changeQty('qty_<?= esc($item['id']) ?>', 1, event)">+</button>
                                            </div>
                                            <div class="item-price" id="price_<?= esc($item['id']) ?>">Rp0</div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="menu-card" style="opacity: 0.6; filter: grayscale(0.8); pointer-events: none;">
                                        <img src="<?= base_url('assets/img/' . $img_name) ?>" alt="<?= esc($item['nama']) ?>" class="menu-img" onerror="this.src='https://placehold.co/200x140?text=<?= urlencode($item['nama']) ?>'">
                                        <h3><?= esc($item['nama']) ?></h3>
                                        <div class="single-price-badge" style="color: #E11D48; font-weight: 700;">Close Order</div>
                                        <div class="menu-action">
                                            <div class="qty-control">
                                                <button type="button" class="qty-btn" disabled>−</button>
                                                <input type="number" class="qty-input" value="0" disabled>
                                                <button type="button" class="qty-btn" disabled>+</button>
                                            </div>
                                            <div class="item-price" style="color: #E11D48; font-weight: 700;">Close Order</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Catatan Pesanan -->
                <div class="form-section">
                    <div class="section-title">Catatan (Opsional)</div>
                    <div class="notes-input-wrapper">
                        <textarea id="catatanInput" class="notes-input" name="catatan" placeholder="Contoh: Tidak pedas, pisahkan sambal, extra jeruk nipis, dll." maxlength="200" oninput="updateCharCount(this)"><?= esc($catatanValue ?? '') ?></textarea>
                        <div class="char-count" id="charCountDisplay">0/200</div>
                    </div>
                </div>

                <!-- Metode Penerimaan -->
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-title">Metode Penerimaan</div>
                    <div class="method-options">
                        <label class="method-card">
                            <input type="radio" name="metode" value="diantar" <?= ($metodeValue ?? '') === 'diantar' ? 'checked' : '' ?> onchange="updateMethodIcon()">
                            <span class="material-symbols-outlined method-icon" id="iconDiantar">radio_button_unchecked</span>
                            <div class="method-text">
                                <strong>Diantar via Maxim</strong>
                                <span class="desc">Pesanan akan diantar ke alamat Anda</span>
                            </div>
                        </label>
                        <label class="method-card">
                            <input type="radio" name="metode" value="ambil_sendiri" <?= ($metodeValue ?? 'ambil_sendiri') === 'ambil_sendiri' ? 'checked' : '' ?> required onchange="updateMethodIcon()">
                            <span class="material-symbols-outlined method-icon" id="iconAmbil">storefront</span>
                            <div class="method-text">
                                <strong>Ambil Sendiri</strong>
                                <span class="desc">Ambil pesanan di lokasi Siomay Dua Putri</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div> <!-- Akhir Area Putih -->

            <!-- Area Ungu Keranjang (Bagian Bawah Frame) -->
            <button type="submit" class="form-footer">
                <div class="footer-left">
                    <div class="cart-icon-wrapper">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <div class="cart-badge" id="totalQtyBadge">0</div>
                    </div>
                    <div class="cart-text-group">
                        <span class="footer-items-text"><span id="totalItemsText">0</span> Item</span>
                        <span class="footer-price" id="grandTotalText">Rp0</span>
                    </div>
                </div>
                <div class="footer-right">
                    Lanjut <span class="material-symbols-outlined">arrow_forward</span>
                </div>
            </button>
        </form>
    </div>

    <script>
        // Mematikan fitur bawaan browser yang mengingat posisi scroll
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        // Memaksa halaman langsung ke kordinat 0,0 (Paling atas)
        window.scrollTo(0, 0);

        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

        // Update jumlah karakter catatan
        function updateCharCount(el) {
            document.getElementById('charCountDisplay').innerText = el.value.length + '/200';
        }

        // Transisi Ikon Metode Penerimaan
        function updateMethodIcon() {
            const diantar = document.querySelector('input[value="diantar"]').checked;
            
            document.getElementById('iconDiantar').textContent = diantar ? 'check_circle' : 'radio_button_unchecked';
            // Ikon Ambil Sendiri tetap pakai storefront
        }

        // Hitungan Qty & Harga
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
                if (selectElement) {
                    selectElement.selectedIndex = 0;
                }
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
                updateTotal();
            }
        }

        function manualInputQty(inputEl, priceId) {
            let qty = parseFloat(inputEl.value);
            if (isNaN(qty) || qty < 0) {
                qty = 0;
            }

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
            document.getElementById(priceId).innerText = formatRupiah(subtotal);
            updateTotal();
        }

        function onQtyInput(inputEl, priceId) {
            manualInputQty(inputEl, priceId);
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
            
            document.getElementById(priceId).innerText = formatRupiah(hargaSatuan * qty);
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
                
                if (priceEl) priceEl.innerText = formatRupiah(subtotal);
                grandTotal += subtotal;
                totalItems += qty;
            });

            // Update text di footer ungu
            const b = document.getElementById('totalQtyBadge');
            if (b) b.innerText = totalItems;
            const t = document.getElementById('totalItemsText');
            if (t) t.innerText = totalItems;
            const g = document.getElementById('grandTotalText');
            if (g) g.innerText = formatRupiah(grandTotal);
        }

        function validasiMinimum(e) {
            // Pastikan hitung ulang terkini sebelum validasi
            updateTotal();

            // Ambil text langsung dari elemen grandTotal keranjang bawah
            const grandTotalEl = document.getElementById('grandTotalText');
            
            if (!grandTotalEl) {
                console.error("Elemen grandTotalText tidak ditemukan!");
                return true; // Loloskan saja jika terjadi error UI ekstrem
            }

            const grandTotalText = grandTotalEl.innerText || "0";
            
            // Bersihkan text dari "Rp", titik, dan spasi (misal: "Rp 120.000" jadi "120000")
            const subtotalStr = grandTotalText.replace(/[^0-9]/g, '');
            const subtotalNumber = parseInt(subtotalStr, 10) || 0;
            
            // Jika total kurang dari Rp100.000
            if (subtotalNumber < 100000) {
                if (e) e.preventDefault();
                
                let alertDiv = document.getElementById('dynamicAlert');
                if (!alertDiv) {
                    alertDiv = document.createElement('div');
                    alertDiv.id = 'dynamicAlert';
                    alertDiv.className = 'alert';
                    const header = document.querySelector('.page-header');
                    if (header) header.after(alertDiv);
                }
                
                // Tampilkan notifikasi dengan nilai aktual yang sudah dibersihkan
                alertDiv.style.display = 'block';
                alertDiv.innerHTML = 'Keranjang kosong atau minimum order (Rp100.000) belum terpenuhi. Subtotal saat ini: <strong>Rp' + subtotalNumber.toLocaleString('id-ID') + '</strong>';
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return false;
            }
            
            // Jika memenuhi syarat, bersihkan alert
            let alertDiv = document.getElementById('dynamicAlert');
            if (alertDiv) {
                alertDiv.style.display = 'none';
            }
            
            return true;
        }

        window.onload = function() {
            updateCharCount(document.getElementById('catatanInput'));
            updateMethodIcon();

            if (window.performance && window.performance.navigation.type === 1) {
                const tglEl = document.getElementById('tgl_pesan');
                if (tglEl) tglEl.value = '';
                document.querySelectorAll('.qty-input').forEach(el => el.value = 0);
                document.querySelectorAll('.menu-select').forEach(el => el.value = "");
                document.querySelectorAll('.item-price').forEach(el => {
                    if (!el.innerText.includes('Close Order')) {
                        el.innerText = 'Rp0';
                    }
                });
                updateTotal();
            } else {
                const hasAlert = document.querySelector('.alert') !== null;
                if (hasAlert) {
                    document.querySelectorAll('.menu-select').forEach(sel => {
                        if (sel.value !== "") {
                            const matchPrice = sel.getAttribute('onchange') ? sel.getAttribute('onchange').match(/price_(\d+)/) : null;
                            const matchQty = sel.getAttribute('onchange') ? sel.getAttribute('onchange').match(/qty_(\d+)/) : null;
                            const priceId = matchPrice ? matchPrice[0] : null;
                            const inputId = matchQty ? matchQty[0] : null;
                            if (priceId && inputId) updateHarga(sel, priceId, inputId);
                        }
                    });
                }
                updateTotal();
            }
        }
    </script>
</body>
</html>