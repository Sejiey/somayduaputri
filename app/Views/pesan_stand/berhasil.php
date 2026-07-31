<?= $this->include('partials/header') ?>

<main class="stand-form-container">
    <div class="berhasil-card">
        <span class="material-symbols-outlined check-icon">check_circle</span>
        <h2>Booking Stand Berhasil Dibuat!</h2>
        <p class="kode-info">Kode Booking Anda: <strong><?= esc($booking['kode_booking']) ?></strong></p>
        
        <div class="status-box">
            Status Pembayaran: <span class="badge-status"><?= esc(ucwords(str_replace('_', ' ', $booking['status_pembayaran']))) ?></span>
        </div>

        <p class="desc-text">
            Terima kasih telah memesan stand acara Siomay Dua Putri. Booking Anda telah tercatat dan saat ini sedang menunggu konfirmasi admin.
        </p>

        <div class="booking-summary-list">
            <p><strong>Nama Acara:</strong> <?= esc($booking['nama_acara']) ?></p>
            <p><strong>Tanggal Acara:</strong> <?= esc($booking['tanggal_acara']) ?></p>
            <p><strong>Lokasi:</strong> <?= esc($booking['lokasi_acara']) ?></p>
            <p><strong>Total Tagihan:</strong> Rp <?= number_format((float)$booking['total'], 0, ',', '.') ?></p>
        </div>

        <div class="action-buttons">
            <?php if ($waUrl !== '#'): ?>
            <a href="<?= esc($waUrl) ?>" target="_blank" class="btn-wa">
                <span class="material-symbols-outlined">chat</span>
                Chat WhatsApp Penjual
            </a>
            <?php endif; ?>

            <a href="<?= base_url() ?>" class="btn-home">
                <span class="material-symbols-outlined">home</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>

<style>
    .stand-form-container { max-width: 600px; margin: 120px auto 60px; padding: 0 20px; }
    .berhasil-card { background: #fff; border-radius: 16px; padding: 40px 24px; border: 1px solid #e7e0eb; text-align: center; box-shadow: 0 10px 30px rgba(76,29,149,0.08); }
    .check-icon { font-size: 64px; color: #059669; margin-bottom: 12px; }
    .berhasil-card h2 { color: #4C1D95; font-size: 1.6rem; margin: 0 0 8px; font-weight: 800; }
    .kode-info { font-size: 1.1rem; color: #1d1a22; margin-bottom: 16px; }
    .status-box { display: inline-block; background: #fef3c7; color: #92400e; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; margin-bottom: 20px; }
    .desc-text { color: #6B7280; font-size: 0.9rem; line-height: 1.5; margin-bottom: 24px; }
    .booking-summary-list { text-align: left; background: #f8f6ff; padding: 16px; border-radius: 10px; margin-bottom: 24px; font-size: 0.85rem; color: #4a4452; }
    .booking-summary-list p { margin: 4px 0; }
    .action-buttons { display: flex; flex-direction: column; gap: 12px; align-items: center; }
    .btn-wa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #25D366; color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 0.95rem; text-decoration: none; width: 100%; max-width: 320px; }
    .btn-wa:hover { background: #1eb956; }
    .btn-home { display: inline-flex; align-items: center; justify-content: center; gap: 6px; color: #4C1D95; font-weight: 600; font-size: 0.9rem; text-decoration: none; }
    .btn-home:hover { text-decoration: underline; }
</style>

<?= $this->include('partials/footer') ?>
