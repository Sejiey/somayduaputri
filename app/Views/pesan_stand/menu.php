<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Menu Stand — Siomay Dua Putri</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        
        body, input, select, textarea, button { font-family: 'Poppins', sans-serif; }
        
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }
        
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

        /* Struktur Pembungkus Utama (Sama Persis Pesan Antar) */
        .form-wrapper { display: flex; justify-content: center; padding: 40px 20px; }
        .form-card { 
            background: #ffffff; 
            border-radius: 24px; 
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.12); 
            max-width: 1100px; 
            width: 100%; 
            position: relative; 
            z-index: 1; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden; 
        }
        
        .form-body { padding: 40px 40px 30px 40px; }

        /* Header */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 32px; border-bottom: 1px dashed var(--border-color); padding-bottom: 24px; }
        .header-text h2 { color: var(--accent-red); font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 6px 0; }
        .header-text h1 { font-size: 1.8rem; margin: 0 0 4px 0; color: var(--primary); font-weight: 700; }
        .header-text p { color: var(--text-muted); font-size: 0.85rem; margin: 0; }
        .btn-back-outline { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 10px; border: 1.5px solid var(--primary); color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.85rem; background: #ffffff; transition: background 0.2s; }
        .btn-back-outline:hover { background: var(--primary-light); }

        /* AREA UNGU KERANJANG (SAMA PERSIS PESAN ANTAR) */
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
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
        }
        .form-footer:hover { background: var(--primary-hover); }
        .footer-left { display: flex; align-items: center; gap: 16px; color: #ffffff; }
        .cart-icon-wrapper { position: relative; display: flex; align-items: center; }
        .cart-icon-wrapper .material-symbols-outlined { font-size: 36px; font-variation-settings: 'FILL' 0; }
        .cart-badge { 
            position: absolute; top: -4px; right: -8px; background: var(--accent-red); color: #ffffff; 
            font-size: 0.75rem; font-weight: 700; min-width: 20px; height: 20px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid var(--primary);
            box-sizing: border-box;
        }
        .cart-text-group { display: flex; flex-direction: column; align-items: flex-start; line-height: 1.2; }
        .footer-items-text { font-size: 0.85rem; font-weight: 600; opacity: 0.9; color: #ffffff; }
        .footer-price { font-size: 1.3rem; font-weight: 700; color: #ffffff; margin-top: 2px; }
        .footer-right { color: #ffffff; font-weight: 600; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }

        .alert-error {
            background: #FEE2E2; border: 1px solid #FCA5A5; padding: 14px 16px;
            border-radius: 12px; color: #991B1B; font-size: 0.9rem; margin-bottom: 24px;
        }

        /* Grid Responsive Sempurna */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        /* Card Menu (Persis Pesan Antar) */
        .menu-card {
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 16px;
            background: #fff;
            transition: border 0.2s, box-shadow 0.2s;
            display: flex; flex-direction: column;
        }
        .menu-card:hover {
            border-color: #d8cbf5;
            box-shadow: 0 10px 30px rgba(59, 25, 143, 0.05);
        }
        .menu-img {
            width: 100%; height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;
            background: #F3F4F6;
        }
        .menu-title {
            font-size: 1.1rem; font-weight: 700; color: var(--primary); margin: 0 0 16px 0;
        }

        /* Input Dropdown / Fix Price */
        .menu-select {
            width: 100%; padding: 10px 12px; border-radius: 8px; border: 1.5px solid var(--border-color);
            font-family: inherit; font-size: 0.9rem; margin-bottom: 16px; outline: none; background: #fff;
        }
        .menu-select:focus { border-color: var(--primary); }
        .fixed-price-label {
            font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px; display: block; font-weight: 500;
        }

        /* Kontrol Qty & Harga Realtime */
        .qty-controls {
            display: flex; justify-content: space-between; align-items: center; margin-top: auto;
        }
        .qty-group {
            display: flex; align-items: center; gap: 0; border: 1.5px solid var(--border-color); border-radius: 8px; overflow: hidden;
        }
        .btn-qty {
            background: #F9FAFB; border: none; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1.2rem; color: var(--primary); font-weight: 600;
        }
        .btn-qty:hover { background: var(--primary-light); }
        .qty-input {
            width: 44px; height: 36px; border: none; border-left: 1.5px solid var(--border-color); border-right: 1.5px solid var(--border-color);
            text-align: center; font-family: inherit; font-weight: 600; outline: none; -moz-appearance: textfield;
        }
        .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .item-price {
            font-size: 1.1rem; font-weight: 800; color: var(--accent-red);
        }

        @media (max-width: 768px) {
            .form-body { padding: 24px 20px 16px 20px; }
            .form-footer { padding: 20px; flex-direction: column; gap: 16px; align-items: center; text-align: center; }
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

    <!-- Wrapper Utama -->
    <div class="form-wrapper">
        <form class="form-card" id="formMenuStand" action="<?= base_url('pesan-stand/menu') ?>" method="post">
            <?= csrf_field() ?>
            
            <!-- Area Putih -->
            <div class="form-body">
                
                <!-- Header -->
                <div class="page-header">
                    <div class="header-text">
                        <h2>PESANAN STAND</h2>
                        <h1>Pilih Menu Stand</h1>
                        <p>Tentukan jumlah porsi/item menu yang ingin dihidangkan di stand acara Anda.</p>
                    </div>
                    <a href="<?= base_url('pesan-stand/acara') ?>" class="btn-back-outline">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                        Kembali
                    </a>
                </div>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-error">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>
            <div class="menu-grid">
                
                <!-- 1. Siomay Kukus (Dropdown Variasi Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/somay.png') ?>" class="menu-img" alt="Siomay Kukus" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Kukus</h3>
                    
                    <select name="items[siomay_kukus][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_siomay_kukus', 'qty_siomay_kukus')">
                        <option value="" data-harga="0">Pilih Variasi (Kiloan)</option>
                        <option value="1kg" data-harga="80000">1 kg - Rp80.000</option>
                        <option value="2kg" data-harga="160000">2 kg - Rp160.000</option>
                        <option value="3kg" data-harga="240000">3 kg - Rp240.000</option>
                        <option value="5kg" data-harga="400000">5 kg - Rp400.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_kukus" name="items[siomay_kukus][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_kukus">Rp 0</span>
                    </div>
                </div>

                <!-- 2. Tahu Kukus Sayur (Dropdown Variasi Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/tahu.png') ?>" class="menu-img" alt="Tahu Kukus Sayur" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Tahu Kukus Sayur</h3>
                    
                    <select name="items[tahu_kukus][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_tahu_kukus', 'qty_tahu_kukus')">
                        <option value="" data-harga="0">Pilih Variasi (Kiloan)</option>
                        <option value="1kg" data-harga="80000">1 kg - Rp80.000</option>
                        <option value="2kg" data-harga="160000">2 kg - Rp160.000</option>
                        <option value="3kg" data-harga="240000">3 kg - Rp240.000</option>
                        <option value="5kg" data-harga="400000">5 kg - Rp400.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_tahu_kukus" name="items[tahu_kukus][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_tahu_kukus">Rp 0</span>
                    </div>
                </div>

                <!-- 3. Siomay Keju (Dropdown Paket) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Siomay Keju" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Keju</h3>
                    
                    <select name="items[siomay_keju][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_siomay_keju', 'qty_siomay_keju')">
                        <option value="" data-harga="0">Pilih Paket</option>
                        <option value="paket_50" data-harga="100000">Paket 50 pcs - Rp100.000</option>
                        <option value="paket_100" data-harga="200000">Paket 100 pcs - Rp200.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_keju" name="items[siomay_keju][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_keju">Rp 0</span>
                    </div>
                </div>

                <!-- 4. Siomay Isi Telur (Dropdown Paket) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Siomay Isi Telur" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Isi Telur</h3>
                    
                    <select name="items[siomay_telur][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_siomay_telur', 'qty_siomay_telur')">
                        <option value="" data-harga="0">Pilih Paket</option>
                        <option value="paket_50" data-harga="100000">Paket 50 pcs - Rp100.000</option>
                        <option value="paket_100" data-harga="200000">Paket 100 pcs - Rp200.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_telur" name="items[siomay_telur][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_telur">Rp 0</span>
                    </div>
                </div>

                <!-- 5. Siomay Urat (Dropdown Paket) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Siomay Urat" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Urat</h3>
                    
                    <select name="items[siomay_urat][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_siomay_urat', 'qty_siomay_urat')">
                        <option value="" data-harga="0">Pilih Paket</option>
                        <option value="paket_50" data-harga="100000">Paket 50 pcs - Rp100.000</option>
                        <option value="paket_100" data-harga="200000">Paket 100 pcs - Rp200.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_urat" name="items[siomay_urat][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_urat">Rp 0</span>
                    </div>
                </div>

                <!-- 6. Siomay Jumbo (Satu-satunya Fix Price) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Siomay Jumbo" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Jumbo</h3>
                    
                    <span class="fixed-price-label">Rp6.000 / pcs</span>
                    <input type="hidden" name="items[siomay_jumbo][harga]" value="6000" data-baseprice="6000" class="fix-price-input">
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_jumbo" name="items[siomay_jumbo][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_jumbo">Rp 0</span>
                    </div>
                </div>

                <!-- 7. Pentol Goreng (Dropdown Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_3.png') ?>" class="menu-img" alt="Pentol Goreng" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Pentol Goreng</h3>
                    
                    <select name="items[pentol_goreng][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_pentol_goreng', 'qty_pentol_goreng')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="setengah_kg" data-harga="25000">1/2 kg - Rp25.000</option>
                        <option value="satu_kg" data-harga="50000">1 kg - Rp50.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_pentol_goreng" name="items[pentol_goreng][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_pentol_goreng">Rp 0</span>
                    </div>
                </div>

                <!-- 8. Lumpia Isi Ayam+Sayur (Dropdown Paket) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_2.jpeg') ?>" class="menu-img" alt="Lumpia Isi Ayam+Sayur" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Lumpia Isi Ayam+Sayur</h3>
                    
                    <select name="items[lumpia][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_lumpia', 'qty_lumpia')">
                        <option value="" data-harga="0">Pilih Paket</option>
                        <option value="paket_25" data-harga="50000">Paket 25 pcs - Rp50.000</option>
                        <option value="paket_50" data-harga="100000">Paket 50 pcs - Rp100.000</option>
                        <option value="paket_100" data-harga="200000">Paket 100 pcs - Rp200.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_lumpia" name="items[lumpia][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_lumpia">Rp 0</span>
                    </div>
                </div>

                <!-- 9. Nugget Ayam (Dropdown Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_4.png') ?>" class="menu-img" alt="Nugget Ayam" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Nugget Ayam</h3>
                    
                    <select name="items[nugget_ayam][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_nugget_ayam', 'qty_nugget_ayam')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="setengah_kg" data-harga="25000">1/2 kg - Rp25.000</option>
                        <option value="satu_kg" data-harga="50000">1 kg - Rp50.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_nugget_ayam" name="items[nugget_ayam][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_nugget_ayam">Rp 0</span>
                    </div>
                </div>

                <!-- 10. Sosis (Dropdown Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Sosis" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Sosis</h3>
                    
                    <select name="items[sosis][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_sosis', 'qty_sosis')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="setengah_kg" data-harga="25000">1/2 kg - Rp25.000</option>
                        <option value="satu_kg" data-harga="50000">1 kg - Rp50.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_sosis" name="items[sosis][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_sosis">Rp 0</span>
                    </div>
                </div>

                <!-- 11. Siomay Ikan Goreng (Dropdown Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Siomay Ikan Goreng" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Siomay Ikan Goreng</h3>
                    
                    <select name="items[siomay_ikan_goreng][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_siomay_ikan_goreng', 'qty_siomay_ikan_goreng')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="setengah_kg" data-harga="25000">1/2 kg - Rp25.000</option>
                        <option value="satu_kg" data-harga="50000">1 kg - Rp50.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_siomay_ikan_goreng" name="items[siomay_ikan_goreng][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_siomay_ikan_goreng">Rp 0</span>
                    </div>
                </div>

                <!-- 12. Batagor (Dropdown Kiloan) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Batagor" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Batagor</h3>
                    
                    <select name="items[batagor][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_batagor', 'qty_batagor')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="setengah_kg" data-harga="25000">1/2 kg - Rp25.000</option>
                        <option value="satu_kg" data-harga="50000">1 kg - Rp50.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_batagor" name="items[batagor][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_batagor">Rp 0</span>
                    </div>
                </div>

                <!-- 13. Mie Gelas (Dropdown Renceng) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_5.png') ?>" class="menu-img" alt="Mie Gelas" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Mie Gelas</h3>
                    
                    <select name="items[mie_gelas][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_mie_gelas', 'qty_mie_gelas')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="renceng_1" data-harga="30000">1 Renceng (10 sachet) - Rp30.000</option>
                        <option value="renceng_2" data-harga="60000">2 Renceng (20 sachet) - Rp60.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_mie_gelas" name="items[mie_gelas][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_mie_gelas">Rp 0</span>
                    </div>
                </div>

                <!-- 14. Es Jeruk Cup (Dropdown Pack) -->
                <div class="menu-card">
                    <img src="<?= base_url('assets/img/menu_1.png') ?>" class="menu-img" alt="Es Jeruk Cup Kecil" onerror="this.src='<?= base_url('img/menu_default.png') ?>'">
                    <h3 class="menu-title">Es Jeruk Cup Kecil</h3>
                    
                    <select name="items[es_jeruk_cup][varian_id]" class="menu-select" onchange="updateHarga(this, 'price_es_jeruk_cup', 'qty_es_jeruk_cup')">
                        <option value="" data-harga="0">Pilih Ukuran</option>
                        <option value="pack_1" data-harga="100000">1 Pack (50 cup) - Rp100.000</option>
                        <option value="pack_2" data-harga="200000">2 Pack (100 cup) - Rp200.000</option>
                    </select>
                    
                    <div class="qty-controls">
                        <div class="qty-group">
                            <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                            <input type="number" id="qty_es_jeruk_cup" name="items[es_jeruk_cup][qty]" class="qty-input" value="0"
                                   onfocus="if(this.value == '0') this.value = '';"
                                   onblur="if(this.value === '' || this.value < 0) this.value = '0'; updateCart();"
                                   oninput="updateCart()">
                            <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <span class="item-price" id="price_es_jeruk_cup">Rp 0</span>
                    </div>
                </div>
            </div> <!-- Akhir menu-grid -->
        </div> <!-- Akhir form-body -->

        <!-- Area Ungu Keranjang (Bagian Bawah Frame Menyatu) -->
        <button type="submit" class="form-footer">
            <div class="footer-left">
                <div class="cart-icon-wrapper">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <div class="cart-badge" id="badgeItemCount">0</div>
                </div>
                <div class="cart-text-group">
                    <span class="footer-items-text"><span id="textItemCount">0</span> Item</span>
                    <span class="footer-price" id="grandTotalText">Rp 0</span>
                </div>
            </div>
            <div class="footer-right">
                Lanjut <span class="material-symbols-outlined">arrow_forward</span>
            </div>
        </button>
        
    </form> <!-- Akhir form-card -->
</div> <!-- Akhir form-wrapper -->

    <script>
        function formatRupiah(angka) {
            return 'Rp' + angka.toLocaleString('id-ID');
        }

        function updateHarga(selectEl, priceId, inputId) {
            const inputEl = document.getElementById(inputId);
            
            if (selectEl.value === "") {
                inputEl.value = 0; // Reset ke 0 jika pilih opsi kosong
            } else if (parseFloat(inputEl.value) === 0) {
                inputEl.value = 1; // OTOMATIS JADI 1 JIKA VARIAN DIPILIH
            }

            const opt = selectEl.options[selectEl.selectedIndex];
            const hargaSatuan = parseFloat(opt.getAttribute('data-harga') || opt.dataset.harga || opt.getAttribute('data-price')) || 0;
            const qty = parseFloat(inputEl.value) || 0;
            
            const priceEl = document.getElementById(priceId);
            if (priceEl) priceEl.innerText = formatRupiah(hargaSatuan * qty);
            updateTotal();
        }

        function changeQty(btn, amount) {
            let container = btn.closest('.qty-group');
            let input = container.querySelector('.qty-input');
            let currentVal = parseInt(input.value) || 0;
            let newVal = currentVal + amount;
            
            if (newVal < 0) newVal = 0;
            input.value = newVal;
            
            updateCart();
        }

        function updateCart() {
            let totalHarga = 0;
            let totalItemType = 0;

            document.querySelectorAll('.menu-card').forEach(card => {
                let qtyInput = card.querySelector('.qty-input');
                let qty = parseInt(qtyInput.value) || 0;
                let price = 0;

                let selectBox = card.querySelector('.menu-select');
                let fixPriceBox = card.querySelector('.fix-price-input');

                if (selectBox) {
                    let selected = selectBox.options[selectBox.selectedIndex];
                    price = parseFloat(selected.getAttribute('data-harga') || selected.dataset.harga || selected.getAttribute('data-price')) || 0;
                    if (selected.value === "" && qty > 0) {
                        // Reset if no option selected
                        qtyInput.value = 0;
                        qty = 0;
                    }
                } else if (fixPriceBox) {
                    price = parseFloat(fixPriceBox.getAttribute('data-baseprice')) || 0;
                }

                let subtotal = qty * price;
                totalHarga += subtotal;
                
                let itemPriceSpan = card.querySelector('.item-price');
                if (itemPriceSpan) itemPriceSpan.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

                if (qty > 0 && price > 0) {
                    totalItemType++;
                }
            });

            let formattedTotal = 'Rp ' + totalHarga.toLocaleString('id-ID');
            let gtText = document.getElementById('grandTotalText');
            if (gtText) gtText.innerText = formattedTotal;
            let gt = document.getElementById('grandTotal');
            if (gt) gt.innerText = formattedTotal;

            let bic = document.getElementById('badgeItemCount');
            if (bic) bic.innerText = totalItemType;
            let tic = document.getElementById('textItemCount');
            if (tic) tic.innerText = totalItemType;
        }

        function updateTotal() {
            updateCart();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCart();
        });
    </script>

</body>
</html>
