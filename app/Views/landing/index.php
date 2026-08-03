<?= $this->include('partials/header') ?>

<div class="landing-page-wrapper">
    
    <svg style="position: absolute; width: 0; height: 0;" aria-hidden="true">
        <defs>
            <clipPath id="hero-blob" clipPathUnits="objectBoundingBox">
                <path d="M 0.08,0.08 C 0.3,0 0.8,0.02 0.95,0.15 C 1,0.4 1,0.8 0.9,0.92 C 0.7,1 0.25,1 0.05,0.85 C -0.05,0.6 0,0.3 0.08,0.08 Z" />
            </clipPath>
        </defs>
    </svg>

    <section class="hero-premium">
        <div class="container hero-grid">
            
            <div class="hero-content fade-up">
                <h1 class="hero-title">
                    <span class="text-primary">SIOMAY</span><br>
                    <span class="text-accent">DUA PUTRI</span>
                </h1>
                
                <div class="hero-subtitle-line">
                    <span class="line"></span>
                    <span class="text">Sejak 2018</span>
                    <span class="line"></span>
                </div>
                
                <p class="hero-desc">
                    Menyajikan siomay, batagor, lumpia dan<br>berbagai jajanan favorit dengan cita rasa rumahan.
                </p>
                
                <div class="hero-buttons">
                    <a href="<?= base_url('pesan-antar') ?>" class="btn-hero outline">
                        <div class="icon-wrap"><span class="material-symbols-outlined">moped</span></div>
                        <span class="text-btn">PESAN ANTAR<br><strong>Hari Ini</strong></span>
                    </a>
                    <a href="<?= base_url('pesan-stand/tentang') ?>" class="btn-hero solid">
                        <div class="icon-wrap"><span class="material-symbols-outlined">storefront</span></div>
                        <span class="text-btn">PESAN UNTUK<br><strong>Acara</strong></span>
                    </a>
                </div>
            </div>

            <div class="hero-visual fade-up delay-1">
                <div class="hero-composition">
                    <div class="main-image-shadow-wrapper">
                        <div class="main-image-wrapper">
                            <img src="<?= base_url('assets/img/foto_1.png') ?>" alt="Gerobak Siomay Dua Putri" class="main-image">
                        </div>
                    </div>
                    
                    <img src="<?= base_url('assets/img/foto_2.png') ?>" alt="Sajian Utama" class="float-img float-1">
                    <img src="<?= base_url('assets/img/foto_3.png') ?>" alt="Sajian Pendamping" class="float-img float-2">
                    <img src="<?= base_url('assets/img/foto_4.png') ?>" alt="Minuman" class="float-img float-3">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION TENGAH (BACKGROUND PUTIH) -->
    <section class="features-section">
        <div class="container features-grid">
            
            <div class="features-content fade-up">
                <h2 class="section-title">Kenapa Memilih Kami?</h2>
                <div class="features-cards">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="material-symbols-outlined">workspace_premium</span>
                        </div>
                        <h4>Sejak 2018</h4>
                        <p>Berpengalaman lebih dari 6 tahun menyajikan jajanan favorit keluarga.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="material-symbols-outlined">eco</span>
                        </div>
                        <h4>Bahan Segar</h4>
                        <p>Menggunakan bahan-bahan segar dan pilihan terbaik setiap hari.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="material-symbols-outlined">storefront</span>
                        </div>
                        <h4>Menerima Porsi Besar</h4>
                        <p>Melayani pesanan dalam jumlah banyak untuk berbagai acara Anda. Pembayaran praktis, opsi pengiriman via Maxim atau ambil sendiri.</p>
                    </div>
                </div>
            </div>

            <div class="features-visual fade-up delay-1">
                <div class="purple-blob"></div>
                <img src="<?= base_url('assets/img/foto_5.png') ?>" alt="Sajian Siomay Premium" class="feature-main-img">
            </div>
        </div>
    </section>

    <!-- KATEGORI MENU (BACKGROUND PUTIH) -->
    <section id="menu-section" class="menu-section fade-up">
        <div class="container">
            <h2 class="section-title text-center" style="text-align: center;">Kategori Menu</h2>
            <div class="menu-grid">
                
                <div class="menu-item" onclick="toggleMenuDesc(this)">
                    <div class="menu-img-wrapper"><img src="<?= base_url('assets/img/menu_1.png') ?>" alt="Siomay & Tahu"></div>
                    <h3 class="menu-name">Siomay & Tahu</h3>
                    <div class="menu-desc-box">
                        Terbuat dari daging sapi segar pilihan yang digiling lembut. Khusus varian tahu, kami menghadirkan isian unik berisikan paduan daging sapi, wortel, dan daun bawang. Solusi cerdas menikmati sayuran dengan cita rasa gurih yang tidak membuat eneg.
                    </div>
                </div>
                
                <div class="menu-item" onclick="toggleMenuDesc(this)">
                    <div class="menu-img-wrapper"><img src="<?= base_url('assets/img/menu_2.jpeg') ?>" alt="Lumpia"></div>
                    <h3 class="menu-name">Lumpia</h3>
                    <div class="menu-desc-box">
                        Sajian renyah di luar dan bernutrisi di dalam. Berisi paduan suwiran daging ayam gurih, buncis segar, dan irisan wortel pilihan.
                    </div>
                </div>
                
                <div class="menu-item" onclick="toggleMenuDesc(this)">
                    <div class="menu-img-wrapper"><img src="<?= base_url('assets/img/menu_3.png') ?>" alt="Aneka Gorengan"></div>
                    <h3 class="menu-name">Aneka Gorengan</h3>
                    <div class="menu-desc-box">
                        Pilihan pelengkap nikmat yang beragam. Tersedia nugget ayam, sosis, pentol goreng, siomay ikan, dan sempol ayam.
                    </div>
                </div>
                
                <div class="menu-item" onclick="toggleMenuDesc(this)">
                    <div class="menu-img-wrapper"><img src="<?= base_url('assets/img/menu_4.png') ?>" alt="Batagor"></div>
                    <h3 class="menu-name">Batagor</h3>
                    <div class="menu-desc-box">
                        Olahan handmade autentik dengan isian paduan tahu, daging giling, dan daun bawang. Menawarkan cita rasa gurih yang dijamin membuat ketagihan.
                    </div>
                </div>
                
                <div class="menu-item" onclick="toggleMenuDesc(this)">
                    <div class="menu-img-wrapper"><img src="<?= base_url('assets/img/menu_5.png') ?>" alt="Es jeruk"></div>
                    <h3 class="menu-name">Es jeruk</h3>
                    <div class="menu-desc-box">
                        Sajian es rasa jeruk manis yang pas dan tidak berlebihan tanpa tambahan gula biang. Pelepas dahaga segar dengan harga hemat hanya Rp2.000/cup.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION BAWAH (BACKGROUND UNGU POLA) -->
    <section id="layanan-section" class="services-section fade-up">
        <div class="container position-relative">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="services-grid">

                <div class="service-card">
                    <img src="<?= base_url('assets/img/maxim.png') ?>" alt="Maxim Delivery" class="service-img maxim-img">
                    <div class="service-info">
                        <h3>Pesan Antar</h3>
                        <p>Pesan menu favorit Anda untuk dikirim hari ini. Antar langsung ke ruangan area Undata, atau kirim via Maxim untuk luar area.</p>
                        <span class="courier-note">Pengantaran via maxim <span class="badge-maxim">maxim</span></span>
                        <a href="<?= base_url('pesan-antar') ?>" class="btn-service">Pesan Antar</a>
                    </div>
                </div>

                <div class="service-card">
                    <img src="<?= base_url('assets/img/stand.png') ?>" alt="Pesan Porsi Besar" class="service-img stand-img">
                    <div class="service-info">
                        <h3>Pesan Untuk Acara</h3>
                        <p>Melayani pesanan dalam jumlah banyak untuk berbagai acara Anda. Pembayaran praktis, opsi pengiriman via Maxim atau ambil sendiri.</p>
                        <a href="<?= base_url('pesan-stand/tentang') ?>" class="btn-service mt-auto">Atur Tanggal</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<?= $this->include('partials/footer') ?>

<style>
    /* Variabel Warna Global */
    :root {
        --c-primary: #3b198f;       
        --c-primary-soft: #f8f6ff;  
        --c-accent: #e31e3f;        
        --c-text: #2D2D2D;
        --c-text-muted: #6B7280;
        --c-white: #FFFFFF;
        
        --shadow-light: 0 8px 24px rgba(59, 25, 143, 0.08);
        --shadow-float: 0 15px 35px rgba(0, 0, 0, 0.15);
        --t-smooth: all 0.3s ease;
    }

    .landing-page-wrapper {
        background-color: var(--c-white);
        overflow-x: hidden;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 40px;
    }
    
    .position-relative { position: relative; z-index: 10; }

    .section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--c-primary);
        margin-bottom: 2rem;
    }

    /* 1. HERO SECTION (BACKGROUND UNGU POLA) */
    .hero-premium {
        position: relative;
        padding: 120px 0 160px;
        background-color: var(--c-primary-soft);
        background-image: url('<?= base_url("bg.png") ?>');
        background-size: cover;
        background-position: top center;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 20px;
        align-items: center;
        position: relative;
        z-index: 10;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3.5rem, 6vw, 6rem);
        line-height: 1;
        margin: 0 0 10px;
        letter-spacing: -1px;
    }
    .hero-title .text-primary { color: var(--c-primary); }
    .hero-title .text-accent { color: var(--c-accent); }
    
    .hero-subtitle-line {
        display: flex;
        align-items: center;
        gap: 15px;
        max-width: 280px;
        margin-bottom: 20px;
    }
    .hero-subtitle-line .line { flex: 1; height: 1.5px; background-color: var(--c-primary); opacity: 0.4; }
    .hero-subtitle-line .text { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--c-primary); font-size: 1rem; }
    .hero-desc { font-size: 1.1rem; color: var(--c-text); max-width: 450px; margin-bottom: 40px; line-height: 1.6; }

    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .btn-hero {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 18px;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        text-align: left;
        line-height: 1.3;
        cursor: pointer;
        transition: var(--t-smooth);
        border: 2px solid var(--c-primary);
    }
    .btn-hero .icon-wrap { display: flex; align-items: center; justify-content: center; }
    .btn-hero .material-symbols-outlined { font-size: 28px; }
    
    .btn-hero.outline { background-color: var(--c-white); color: var(--c-primary); }
    .btn-hero.outline:hover { background-color: var(--c-primary-soft); }
    
    .btn-hero.solid { background-color: var(--c-primary); color: var(--c-white); }
    .btn-hero.solid:hover { background-color: #2e1069; border-color: #2e1069; }

    /* Visual Kanan */
    .hero-visual { display: flex; justify-content: flex-end; align-items: center; width: 100%; }
    .hero-composition { position: relative; width: 100%; max-width: 580px; height: 500px; margin-right: 20px; }
    .main-image-shadow-wrapper { width: 100%; height: 100%; filter: drop-shadow(0 15px 35px rgba(0, 0, 0, 0.15)); position: relative; z-index: 1; }
    .main-image-wrapper { width: 100%; height: 100%; clip-path: url(#hero-blob); -webkit-clip-path: url(#hero-blob); background-color: var(--c-white); }
    .main-image { width: 100%; height: 100%; object-fit: cover; }
    .float-img { position: absolute; border: none; background-color: transparent; border-radius: 0; box-shadow: none; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.4)); }
    .float-1 { width: 250px; bottom: -50px; right: 140px; z-index: 10; }
    .float-2 { width: 200px; bottom: 0px; right: -10px; z-index: 9; }
    .float-3 { width: 130px; bottom: 50px; right: -30px; z-index: 8; transform: rotate(12deg); }

    /* 2. KENAPA MEMILIH KAMI (STATIS & PUTIH) */
    .features-section { padding: 60px 0 80px; background-color: var(--c-white); }
    .features-grid { display: grid; grid-template-columns: 1.3fr 1fr; gap: 40px; align-items: center; }
    .features-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .feature-card { background: var(--c-white); border: 1px solid rgba(59, 25, 143, 0.1); padding: 24px 16px; border-radius: 12px; text-align: center; }
    .feature-icon-wrapper { width: 55px; height: 55px; margin: 0 auto 15px; border-radius: 50%; border: 2px solid var(--c-primary); display: flex; align-items: center; justify-content: center; position: relative; }
    .feature-icon-wrapper::after { content: ''; position: absolute; width: 40px; height: 40px; background-color: var(--c-primary); border-radius: 50%; z-index: 0; }
    .feature-icon-wrapper .material-symbols-outlined { color: var(--c-white); font-size: 24px; z-index: 1; }
    .feature-card h4 { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--c-primary); margin: 0 0 8px; font-size: 0.95rem; }
    .feature-card p { font-size: 0.75rem; color: var(--c-text-muted); margin: 0; line-height: 1.5; }

    .features-visual { position: relative; display: flex; justify-content: flex-end; align-items: center; width: 100%; height: 100%; }
    .purple-blob { position: absolute; right: -40px; width: 350px; height: 450px; background-color: var(--c-primary-soft); border-radius: 200px 0 0 200px; z-index: 0; }
    .feature-main-img { width: 100%; max-width: 420px; border-radius: 50%; object-fit: cover; box-shadow: var(--shadow-float); position: relative; z-index: 1; }

    /* 3. KATEGORI MENU (INTERAKTIF & PUTIH) */
    .menu-section { padding: 20px 0 80px; background-color: var(--c-white); }
    .menu-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; justify-items: center; align-items: start; }
    @media (min-width: 768px) { .menu-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1024px) { .menu-grid { grid-template-columns: repeat(5, 1fr); gap: 20px; } }
    
    .menu-item {
        width: 100%; max-width: 220px; text-align: center; cursor: pointer;
        display: flex; flex-direction: column; align-items: center;
    }
    
    @keyframes floatMenu {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .menu-img-wrapper {
        width: 160px; height: 160px; margin: 0 auto 15px; border-radius: 50%;
        padding: 8px; background: var(--c-white); box-shadow: var(--shadow-light);
        animation: floatMenu 3.5s ease-in-out infinite; transition: all 0.3s ease;
    }
    .menu-item:nth-child(1) .menu-img-wrapper { animation-delay: 0s; }
    .menu-item:nth-child(2) .menu-img-wrapper { animation-delay: 0.7s; }
    .menu-item:nth-child(3) .menu-img-wrapper { animation-delay: 1.4s; }
    .menu-item:nth-child(4) .menu-img-wrapper { animation-delay: 2.1s; }
    .menu-item:nth-child(5) .menu-img-wrapper { animation-delay: 2.8s; }
    
    .menu-img-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .menu-name { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--c-primary); font-size: 1.05rem; margin: 0; transition: 0.3s; }

    /* STATE AKTIF KETIKA DITEKAN (POP UP & BERHENTI GERAK) */
    .menu-item.active .menu-img-wrapper {
        animation-play-state: paused;
        transform: translateY(-15px);
        box-shadow: 0 15px 30px rgba(59, 25, 143, 0.2);
    }
    .menu-item.active .menu-name { transform: translateY(-10px); }

    /* KOTAK DESKRIPSI (SLIDE DOWN ACCORDION) */
    .menu-desc-box {
        max-height: 0; opacity: 0; overflow: hidden; font-size: 0.8rem;
        color: var(--c-text-muted); line-height: 1.5; padding: 0 10px;
        transition: all 0.4s ease-in-out; text-align: center;
    }
    .menu-item.active .menu-desc-box {
        max-height: 250px; opacity: 1; margin-top: 0px;
    }

    /* 4. LAYANAN KAMI (BACKGROUND UNGU POLA) */
    .services-section {
        position: relative; padding: 100px 0 100px;
        background-color: var(--c-primary-soft);
        background-image: url('<?= base_url("bg.png") ?>'); 
        background-size: cover; background-repeat: no-repeat; background-position: center;
    }

    .services-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; max-width: 960px; margin: 0 auto; }
    .service-card { background: var(--c-white); border-radius: 12px; padding: 24px; display: flex; gap: 16px; box-shadow: var(--shadow-light); align-items: center; border: 1px solid rgba(255, 255, 255, 0.4); }
    .service-img { width: 100px; height: 100px; object-fit: contain; flex-shrink: 0; border-radius: 8px; }
    .qris-img { border: 1px solid #eee; }
    
    .service-info { display: flex; flex-direction: column; flex: 1; }
    .service-info h3 { color: var(--c-primary); font-size: 1.1rem; font-weight: 700; margin: 0 0 6px; }
    .service-info p { font-size: 0.8rem; color: var(--c-text-muted); margin: 0 0 10px; line-height: 1.4; }
    .courier-note { font-size: 0.7rem; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; color: var(--c-text); }
    .badge-maxim { background-color: #FFEB3B; color: #000; padding: 2px 6px; border-radius: 4px; font-weight: 800; }
    .btn-service { background-color: var(--c-primary); color: var(--c-white); padding: 8px 16px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer; text-align: center; transition: var(--t-smooth); align-self: flex-start; text-decoration: none; }
    .btn-service:hover { background-color: #2e1069; }

    /* Animasi Bawaan */
    .fade-up { opacity: 0; transform: translateY(30px); animation: fadeUpAnim 0.8s forwards ease-out; }
    .delay-1 { animation-delay: 0.2s; }
    @keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

    /* RESPONSIVE (HP & TABLET) - PERBAIKAN SPACING DAN UKURAN */
    @media (max-width: 1024px) {
        .container { padding: 0 24px; }
        .hero-grid, .features-grid { grid-template-columns: 1fr; text-align: center; }
        .hero-content { align-items: center; display: flex; flex-direction: column; }
        
        .section-title { font-size: 1.5rem; margin-bottom: 1.5rem; }
        
        .hero-title { font-size: 2.2rem; }
        .hero-desc { font-size: 0.85rem; text-align: center; margin-bottom: 24px; max-width: 320px; }
        
        .hero-buttons { 
            display: flex; flex-direction: row; flex-wrap: wrap; 
            justify-content: center; gap: 10px; width: 100%;
        }
        .btn-hero { 
            flex-direction: row; padding: 8px 14px; text-align: left; 
            flex: unset; width: auto; font-size: 0.75rem; justify-content: center;
        }
        .btn-hero .icon-wrap { margin-bottom: 0; margin-right: 8px; }
        .btn-hero .material-symbols-outlined { font-size: 22px; }

        /* PERBAIKAN 1: Background ungu dipotong agar berhenti pas di bawah foto gerobak */
        .hero-premium { padding: 100px 0 40px; }
        
        /* PERBAIKAN 2: Posisi gambar melayang agar tidak menutupi teks/tombol */
        .hero-visual { justify-content: center; margin-top: 20px; padding-right: 0; }
        .hero-composition { max-width: 260px; height: 280px; margin: 0 auto 30px; }
        .float-1 { width: 130px; bottom: -10px; right: 40px; }
        .float-2 { width: 100px; bottom: 10px; right: -10px; }
        .float-3 { width: 60px; bottom: 30px; right: -10px; transform: rotate(12deg); }
        
        /* PERBAIKAN 3: Jarak dan ukuran mangkok siomay dikurangi */
        .features-section { padding: 40px 0 40px; }
        .features-cards { grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .feature-card { padding: 16px 12px; }
        .feature-icon-wrapper { width: 45px; height: 45px; margin: 0 auto 10px; }
        .feature-icon-wrapper::after { width: 32px; height: 32px; }
        .feature-icon-wrapper .material-symbols-outlined { font-size: 20px; }
        .feature-card h4 { font-size: 0.85rem; }
        .feature-card p { font-size: 0.75rem; }
        
        .features-visual { margin-top: 20px; }
        .feature-main-img { max-width: 180px; margin-top: 10px; } /* Mangkok lebih kecil */
        .purple-blob { width: 250px; height: 250px; right: -20px; }
        
        .menu-img-wrapper { width: 130px; height: 130px; }
        .menu-name { font-size: 0.9rem; }
        
        /* PERBAIKAN 4: Kotak layanan diperkecil agar tidak raksasa */
        .services-section { padding: 50px 0 60px; }
        .services-grid { grid-template-columns: 1fr; gap: 12px; }
        .service-card { flex-direction: column; align-items: center; text-align: center; padding: 16px 12px; gap: 10px; }
        .service-img { width: 55px; height: 55px; } /* Ikon layanan lebih kecil */
        .service-info h3 { font-size: 0.9rem; margin-bottom: 4px; }
        .service-info p { font-size: 0.7rem; margin-bottom: 8px; }
        .btn-service { align-self: center; font-size: 0.7rem; padding: 6px 12px; margin-top: 0; }
    }
</style>

<script>
// Fungsi untuk memunculkan teks di bawah menu saat di-klik (Accordion style)
function toggleMenuDesc(element) {
    document.querySelectorAll('.menu-item').forEach(item => {
        if (item !== element) {
            item.classList.remove('active');
        }
    });
    
    element.classList.toggle('active');
}

// Navigasi Scrollspy
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-menu a');
    if (!navLinks || navLinks.length < 4) return;
    
    const sections = [
        { id: 'top', link: navLinks[0] },
        { id: 'menu-section', link: navLinks[1] },
        { id: 'layanan-section', link: navLinks[2] },
        { id: 'kontak', link: navLinks[3] }
    ];

    function updateScrollspy() {
        const scrollPosition = window.scrollY + 200;
        let currentSection = 'top';

        sections.forEach(sec => {
            if (sec.id !== 'top') {
                const el = document.getElementById(sec.id);
                if (el && el.offsetTop <= scrollPosition) {
                    currentSection = sec.id;
                }
            }
        });

        sections.forEach(sec => {
            if (sec.link) {
                if (sec.id === currentSection) {
                    sec.link.classList.add('active');
                } else {
                    sec.link.classList.remove('active');
                }
            }
        });
    }

    window.addEventListener('scroll', updateScrollspy);
    updateScrollspy();
});
</script>