<?= $this->include('partials/header') ?>

<main class="qris-page-container">
    <div class="qris-card">
        <div class="qris-card-header">
            <span class="material-symbols-outlined qris-header-icon">qr_code_2</span>
            <h2>Pembayaran QRIS Merchant</h2>
            <p>Scan QRIS di bawah ini menggunakan aplikasi Mobile Banking atau E-Wallet pilihan Anda (GoPay, OVO, Dana, ShopeePay, BCA, Mandiri, dll).</p>
        </div>

        <div class="qris-image-wrapper">
            <img src="<?= esc($qrisImg) ?>" alt="QRIS Siomay Dua Putri" class="qris-img">
        </div>

        <div class="qris-actions">
            <a href="<?= esc($qrisImg) ?>" download="QRIS_Siomay_Dua_Putri.jpeg" class="btn-download-qris">
                <span class="material-symbols-outlined">download</span>
                Unduh Gambar QRIS
            </a>
        </div>

        <div class="qris-instructions">
            <h3>Cara Pembayaran:</h3>
            <ol>
                <li>Buka aplikasi pembayaran (BCA, Mandiri, GoPay, Dana, ShopeePay, dll).</li>
                <li>Pilih menu <strong>Scan QRIS</strong>.</li>
                <li>Arahkan kamera ke gambar QRIS di atas atau unggah hasil unduhan QRIS.</li>
                <li>Masukkan nominal pembayaran sesuai tagihan Anda.</li>
                <li>Konfirmasi dan selesaikan pembayaran.</li>
            </ol>
        </div>

        <div class="qris-footer-action">
            <a href="<?= base_url() ?>" class="btn-back-home">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>

<style>
    .qris-page-container {
        max-width: 600px;
        margin: 120px auto 60px;
        padding: 0 20px;
    }
    .qris-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(76, 29, 149, 0.08);
        padding: 32px 24px;
        text-align: center;
        border: 1px solid #e7e0eb;
    }
    .qris-card-header h2 {
        color: #3b198f;
        font-size: 1.5rem;
        margin: 8px 0;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }
    .qris-header-icon {
        font-size: 48px;
        color: #3b198f;
    }
    .qris-card-header p {
        color: #6B7280;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 24px;
    }
    .qris-image-wrapper {
        background: #f8f6ff;
        padding: 16px;
        border-radius: 12px;
        display: inline-block;
        border: 2px dashed #3b198f;
        margin-bottom: 20px;
    }
    .qris-img {
        max-width: 280px;
        width: 100%;
        height: auto;
        border-radius: 8px;
        display: block;
    }
    .qris-actions {
        margin-bottom: 28px;
    }
    .btn-download-qris {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #3b198f;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }
    .btn-download-qris:hover {
        background-color: #2e1069;
    }
    .qris-instructions {
        text-align: left;
        background-color: #f8f6ff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 24px;
    }
    .qris-instructions h3 {
        font-size: 1rem;
        color: #3b198f;
        margin: 0 0 10px;
    }
    .qris-instructions ol {
        margin: 0;
        padding-left: 20px;
        color: #4a4452;
        font-size: 0.85rem;
        line-height: 1.6;
    }
    .btn-back-home {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #3b198f;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .btn-back-home:hover {
        text-decoration: underline;
    }
</style>

<?= $this->include('partials/footer') ?>
