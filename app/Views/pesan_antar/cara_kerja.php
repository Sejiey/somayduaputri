<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<?= $this->include('partials/header') ?>
<style>
    /* ==================================================
       HALAMAN CARA KERJA (HOW IT WORKS) STYLES
       ================================================== */
    .hiw-section {
        position: relative;
        padding: 60px 0 80px; /* Jarak atas dipangkas drastis agar tidak terlalu jauh */
        /* Latar belakang sangat soft cenderung putih dengan pola baru */
        background-color: #FDFBFF; 
        background-image: url('<?= base_url("bg_2.png") ?>');
        background-size: cover;
        background-position: top center;
        min-height: 100vh; /* Dikembalikan ke 100vh agar background mentok sampai bawah/footer */
        overflow: hidden; /* Memotong bulat layer di sisi kanan agar persis referensi */
        display: flex;
        align-items: flex-start; /* Konten langsung ditarik ke atas, tidak lagi di tengah */
    }
    /* ==================================================
       LAYER BULAT BAYANGAN (SAMA PERSIS GAMBAR 3)
       ================================================== */
    /* Ditempatkan absolute pada layar utama agar bisa terpotong di kanan */
    
    /* Layer 1 (Paling Luar / Besar) */
    .blob-layer-1 {
        position: absolute;
        top: 50%;
        right: -25%;
        transform: translateY(-50%);
        width: 1000px;
        height: 1000px;
        background-color: #F7F4FF; /* Sangat pudar */
        border-radius: 50%;
        z-index: 1;
    }
    /* Layer 2 (Tengah) */
    .blob-layer-2 {
        position: absolute;
        top: 50%;
        right: -15%;
        transform: translateY(-50%);
        width: 750px;
        height: 750px;
        background-color: #EFE8FF;
        border-radius: 50%;
        z-index: 2;
    }
    /* Layer 3 (Paling Dalam) */
    .blob-layer-3 {
        position: absolute;
        top: 50%;
        right: -5%;
        transform: translateY(-50%);
        width: 550px;
        height: 550px;
        background-color: #E4D8FF;
        border-radius: 50%;
        box-shadow: inset 10px -10px 30px rgba(255,255,255,0.7);
        z-index: 3;
    }
    /* Container untuk menjaga jarak agar tulisan tidak mepet layar */
    .hiw-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
        position: relative;
        z-index: 10;
    }
    .hiw-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }
    /* 1. BAGIAN TEKS (KIRI) */
    .hiw-text {
        display: flex;
        flex-direction: column;
        max-width: 540px;
    }
    .hiw-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0 0 16px;
        line-height: 1.3;
    }
    .hiw-desc {
        font-size: 0.95rem;
        color: var(--on-surface-variant);
        margin: 0 0 32px;
        line-height: 1.6;
    }
    /* 2. BAGIAN KOTAK FITUR */
    .hiw-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(59, 25, 143, 0.05);
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-bottom: 32px;
    }
    .hiw-step {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }
    .hiw-step-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background-color: #F4EFFF; 
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .hiw-step-icon .material-symbols-outlined {
        font-size: 20px;
    }
    .hiw-step-text h4 {
        margin: 0 0 6px;
        font-size: 0.95rem;
        color: var(--primary);
        font-weight: 700;
    }
    .hiw-step-text p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--on-surface-variant);
        line-height: 1.5;
    }
    /* 3. BAGIAN TOMBOL */
    .hiw-actions {
        display: flex;
        flex-direction: row; /* Berdampingan */
        gap: 12px;
    }
    .btn-hiw {
        display: flex;
        justify-content: center; /* Teks otomatis di tengah */
        align-items: center;
        padding: 10px 24px; /* Proporsional */
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all var(--t-fast);
        text-decoration: none;
        width: auto; /* Mengikuti ukuran konten */
        font-family: 'Poppins', sans-serif;
    }
    .btn-hiw.solid {
        background-color: var(--primary);
        color: #ffffff;
        border: 2px solid var(--primary);
    }
    .btn-hiw.solid:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        box-shadow: 0 4px 12px rgba(59, 25, 143, 0.2);
    }
    .btn-hiw.outline {
        background-color: #ffffff;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    .btn-hiw.outline:hover {
        background-color: #F8F6FF;
    }
    /* 4. BAGIAN GAMBAR (KANAN) */
    .hiw-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        z-index: 10;
    }
    .hiw-image {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 480px;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
        /* Animasi mengambang */
        animation: floatImage 4s ease-in-out infinite;
    }
    /* ==================================================
       ANIMASI
       ================================================== */
    /* Animasi halaman masuk */
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeUpAnim 0.8s forwards ease-out;
    }
    @keyframes fadeUpAnim {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Animasi gambar mengambang */
    @keyframes floatImage {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    /* ==================================================
       RESPONSIVE MOBILE
       ================================================== */
    @media (max-width: 992px) {
        .hiw-section {
            padding: 60px 0 60px; /* Space mobile juga disesuaikan */
            align-items: flex-start;
        }
        .hiw-container {
            padding: 0 24px; 
        }
        .hiw-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        /* Gambar naik ke atas saat di layar HP */
        .hiw-visual {
            order: -1; 
            min-height: 280px;
        }
        
        /* Menyesuaikan layer bulat di HP agar tetap cantik dan terpotong */
        .blob-layer-1 { width: 600px; height: 600px; top: -5%; right: -30%; transform: none; }
        .blob-layer-2 { width: 450px; height: 450px; top: 0%; right: -20%; transform: none; }
        .blob-layer-3 { width: 300px; height: 300px; top: 5%; right: -10%; transform: none; }
        
        .hiw-image {
            max-width: 300px;
        }
        .hiw-text {
            max-width: 100%;
        }
        .hiw-heading {
            text-align: center;
        }
        .hiw-desc {
            text-align: center;
        }
        .hiw-card {
            padding: 24px;
        }
        .hiw-actions {
            max-width: 100%;
            flex-direction: row; /* Tetap berdampingan di mode mobile */
            justify-content: center;
        }
    }
</style>
<!-- KONTEN HALAMAN CARA KERJA -->
<div class="hiw-section fade-up">
    
    <!-- 3 Layer Bulat diposisikan di layar utama agar membesar ke kanan -->
    <div class="blob-layer-1"></div>
    <div class="blob-layer-2"></div>
    <div class="blob-layer-3"></div>
    <div class="hiw-container hiw-grid">
        
        <!-- Kolom Teks (Kiri) -->
        <div class="hiw-text">
            <h1 class="hiw-heading">Atur Pengantaran Pesanan Anda</h1>
            
            <p class="hiw-desc">
                Layanan kirim cepat hari ini. Pilih opsi antar ke ruangan area Undata atau luar area via Maxim sesuai lokasi Anda. Praktis, terjamin, dan aman.
            </p>
            
            <div class="hiw-card">
                <div class="hiw-step">
                    <div class="hiw-step-icon"><span class="material-symbols-outlined">event</span></div>
                    <div class="hiw-step-text">
                        <h4>Pilih Lokasi</h4>
                        <p>Tentukan area pengiriman Anda, apakah di dalam lingkungan RSUD Undata atau untuk wilayah luar area.</p>
                    </div>
                </div>
                
                <div class="hiw-step">
                    <div class="hiw-step-icon"><span class="material-symbols-outlined">local_shipping</span></div>
                    <div class="hiw-step-text">
                        <h4>Metode Pengantaran</h4>
                        <p>Opsi ambil sendiri, diantar ke ruangan area Undata (fee Rp5k), atau kirim via Maxim untuk luar Undata.</p>
                    </div>
                </div>
                
                <div class="hiw-step">
                    <div class="hiw-step-icon"><span class="material-symbols-outlined">qr_code_scanner</span></div>
                    <div class="hiw-step-text">
                        <h4>Pembayaran Mudah</h4>
                        <p>Selesaikan pesanan dengan aman dan cepat menggunakan QRIS.</p>
                    </div>
                </div>
            </div>
            <div class="hiw-actions">
                <a href="<?= base_url('pesan-antar/form') ?>" class="btn-hiw solid">
                    Mulai Pesan
                </a>
                <a href="<?= base_url() ?>" class="btn-hiw outline">
                    Kembali
                </a>
            </div>
        </div>
        <!-- Kolom Visual (Kanan) -->
        <div class="hiw-visual">
            <img src="<?= base_url('icon_1.png') ?>" alt="Ilustrasi Pesanan" class="hiw-image" onerror="this.src='<?= base_url('assets/img/icon_1.png') ?>'">
        </div>
        
    </div>
</div>
<?= $this->include('partials/footer') ?>