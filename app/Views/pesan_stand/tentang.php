<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>

<?= $this->include('partials/header') ?>

<style>
    /* ==================================================
       HALAMAN STAND ACARA STYLES (ADAPTASI DARI CARA KERJA)
       ================================================== */
    .hiw-section {
        position: relative;
        padding: 140px 0 80px;
        background-color: #FDFBFF; 
        background-image: url('<?= base_url("bg_2.png") ?>');
        background-size: cover;
        background-position: top center;
        min-height: 100vh;
        overflow: hidden; 
        display: flex;
        align-items: center;
    }

    /* LAYER BULAT BAYANGAN (SAMA PERSIS) */
    .blob-layer-1 {
        position: absolute; top: 50%; right: -25%; transform: translateY(-50%);
        width: 1000px; height: 1000px; background-color: #F7F4FF; border-radius: 50%; z-index: 1;
    }
    .blob-layer-2 {
        position: absolute; top: 50%; right: -15%; transform: translateY(-50%);
        width: 750px; height: 750px; background-color: #EFE8FF; border-radius: 50%; z-index: 2;
    }
    .blob-layer-3 {
        position: absolute; top: 50%; right: -5%; transform: translateY(-50%);
        width: 550px; height: 550px; background-color: #E4D8FF; border-radius: 50%;
        box-shadow: inset 10px -10px 30px rgba(255,255,255,0.7); z-index: 3;
    }

    /* CONTAINER & GRID (SAMA PERSIS) */
    .hiw-container {
        max-width: 1280px; margin: 0 auto; padding: 0 40px; width: 100%; position: relative; z-index: 10;
    }
    .hiw-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;
    }

    /* BAGIAN TEKS (KIRI) */
    .hiw-text {
        display: flex; flex-direction: column; max-width: 540px;
    }
    .hiw-heading {
        font-family: 'Poppins', sans-serif; font-size: 2.2rem; font-weight: 800;
        color: var(--primary); margin: 0 0 16px; line-height: 1.3;
    }
    .hiw-desc {
        font-size: 0.95rem; color: var(--on-surface-variant); margin: 0 0 32px; line-height: 1.6;
    }

    /* KOTAK FITUR (ADAPTASI UNTUK LIST ACARA) */
    .hiw-card {
        background: #ffffff; border-radius: 16px; padding: 32px;
        box-shadow: 0 10px 40px rgba(59, 25, 143, 0.05); margin-bottom: 32px;
    }
    .stand-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        list-style: none; padding: 0; margin: 0;
    }
    .stand-grid li {
        display: flex; align-items: center; gap: 12px;
        font-size: 0.95rem; color: var(--on-surface-variant); font-weight: 500;
    }
    .stand-grid .material-symbols-outlined {
        color: var(--primary); font-size: 22px;
    }

    /* BAGIAN TOMBOL */
    .hiw-actions {
        display: flex; flex-direction: column; gap: 12px; max-width: 250px;
    }
    .btn-hiw {
        display: flex; justify-content: center; align-items: center; gap: 8px;
        padding: 14px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem;
        cursor: pointer; transition: all var(--t-fast); text-decoration: none; width: 100%;
        font-family: 'Poppins', sans-serif;
    }
    .btn-hiw.solid {
        background-color: var(--primary); color: #ffffff; border: 2px solid var(--primary);
    }
    .btn-hiw.solid:hover {
        background-color: var(--primary-hover); border-color: var(--primary-hover);
        box-shadow: 0 4px 12px rgba(59, 25, 143, 0.2);
    }
    
    .stand-guarantee {
        display: flex; align-items: center; gap: 8px; margin-top: 8px;
        font-size: 0.85rem; font-weight: 500; color: var(--on-surface-variant);
    }
    .stand-guarantee .material-symbols-outlined {
        color: #E11D48; font-size: 18px;
    }

    /* BAGIAN GAMBAR (KANAN) */
    .hiw-visual {
        position: relative; display: flex; justify-content: center; align-items: center;
        width: 100%; height: 100%; z-index: 10;
    }
    .hiw-image {
        position: relative; z-index: 10; width: 100%; max-width: 480px; object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
    }

    /* RESPONSIVE MOBILE */
    @media (max-width: 992px) {
        .hiw-section { padding: 120px 0 60px; align-items: flex-start; }
        .hiw-container { padding: 0 24px; }
        .hiw-grid { grid-template-columns: 1fr; gap: 40px; }
        .hiw-visual { order: -1; min-height: 280px; }
        
        .blob-layer-1 { width: 600px; height: 600px; top: -5%; right: -30%; transform: none; }
        .blob-layer-2 { width: 450px; height: 450px; top: 0%; right: -20%; transform: none; }
        .blob-layer-3 { width: 300px; height: 300px; top: 5%; right: -10%; transform: none; }
        
        .hiw-image { max-width: 320px; }
        .hiw-text { max-width: 100%; }
        .hiw-heading, .hiw-desc { text-align: center; }
        .hiw-card { padding: 24px; }
        .stand-grid { grid-template-columns: 1fr; gap: 16px; }
        .hiw-actions { max-width: 100%; align-items: center; }
    }
</style>

<!-- KONTEN HALAMAN STAND ACARA -->
<div class="hiw-section fade-up">
    
    <!-- 3 Layer Bulat -->
    <div class="blob-layer-1"></div>
    <div class="blob-layer-2"></div>
    <div class="blob-layer-3"></div>

    <div class="hiw-container hiw-grid">
        
        <!-- Kolom Teks (Kiri) -->
        <div class="hiw-text">
            <h1 class="hiw-heading">Stand Acara</h1>
            
            <p class="hiw-desc">
                Siap meramaikan acara spesial Anda dengan stand Siomay Dua Putri berkualitas, praktis, dan lezat!
            </p>
            
            <div class="hiw-card">
                <ul class="stand-grid">
                    <li><span class="material-symbols-outlined">favorite</span> Pernikahan</li>
                    <li><span class="material-symbols-outlined">cake</span> Ulang Tahun</li>
                    <li><span class="material-symbols-outlined">group</span> Arisan</li>
                    <li><span class="material-symbols-outlined">menu_book</span> Pengajian</li>
                    <li><span class="material-symbols-outlined">campaign</span> Seminar</li>
                    <li><span class="material-symbols-outlined">storefront</span> Grand Opening</li>
                    <li><span class="material-symbols-outlined">add_circle</span> Dan lainnya</li>
                </ul>
            </div>

            <div class="hiw-actions">
                <a href="<?= base_url('pesan-stand/acara') ?>#formBooking" class="btn-hiw solid">
                    Booking Sekarang <span class="material-symbols-outlined">arrow_forward</span>
                </a>
                <div class="stand-guarantee">
                    <span class="material-symbols-outlined">verified</span> Stand berkualitas, rasa selalu juara! ✨
                </div>
            </div>
        </div>

        <!-- Kolom Visual (Kanan) -->
        <div class="hiw-visual">
            <img src="<?= base_url('img/stand_rv.png') ?>" alt="Stand Siomay Dua Putri" class="hiw-image" onerror="this.src='<?= base_url('assets/img/stand_rv.png') ?>'">
        </div>
        
    </div>
</div>

<?= $this->include('partials/footer') ?>
