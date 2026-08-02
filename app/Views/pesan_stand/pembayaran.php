<?= $this->include('partials/header') ?>

<main class="stand-form-container">
    <div class="step-indicator">
        <span class="step">1. Data Acara</span>
        <span class="step-line"></span>
        <span class="step">2. Menu Stand</span>
        <span class="step-line"></span>
        <span class="step">3. Ringkasan</span>
        <span class="step-line"></span>
        <span class="step active">4. Pembayaran</span>
    </div>

    <div class="form-card">
        <h2 class="form-title">Langkah 4: Pembayaran QRIS Booking Stand</h2>
        <p class="form-sub">Scan QRIS di bawah ini sebesar <strong>Rp <?= number_format((float)$booking['total'], 0, ',', '.') ?></strong> untuk menyelesaikan booking stand.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="flash-err"><p><?= esc(session()->getFlashdata('error')) ?></p></div>
        <?php endif; ?>

        <div class="pembayaran-grid" style="grid-template-columns: 1fr;">
            <div class="summary-card-box">
                <h3>Detail Booking Stand</h3>
                <p>Kode Booking: <strong><?= esc($booking['kode_booking']) ?></strong></p>
                <p>Nama Acara: <strong><?= esc($booking['nama_acara']) ?></strong></p>
                <p>Tanggal Acara: <strong><?= esc($booking['tanggal_acara']) ?></strong></p>
                <p>Subtotal Menu: Rp <?= number_format((float)$booking['subtotal'], 0, ',', '.') ?></p>
                <p>Biaya Stand: Rp <?= number_format((float)$booking['biaya_stand'], 0, ',', '.') ?></p>
                <div class="total-highlight">
                    Total: Rp <?= number_format((float)$booking['total'], 0, ',', '.') ?>
                </div>

                <button id="btn-bayar-snap" class="btn-konfirmasi" style="margin-top: 20px;">
                    <span class="material-symbols-outlined">payment</span>
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</main>

<style>
    .stand-form-container { max-width: 720px; margin: 120px auto 60px; padding: 0 20px; }
    .step-indicator { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; font-size: 0.8rem; font-weight: 600; color: #6B7280; }
    .step.active { color: #4C1D95; font-weight: 800; }
    .step-line { flex: 1; height: 2px; background: #e7e0eb; margin: 0 8px; }
    .form-card { background: #fff; border-radius: 16px; padding: 32px 24px; border: 1px solid #e7e0eb; box-shadow: 0 10px 30px rgba(76,29,149,0.08); }
    .form-title { color: #4C1D95; margin: 0 0 4px; font-size: 1.4rem; font-weight: 800; }
    .form-sub { color: #6B7280; margin: 0 0 20px; font-size: 0.85rem; }
    .pembayaran-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    @media (max-width: 600px) { .pembayaran-grid { grid-template-columns: 1fr; } }
    .qris-card-box { background: #f8f6ff; padding: 16px; border-radius: 12px; border: 2px dashed #4C1D95; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .qris-img-stand { width: 100%; max-width: 200px; border-radius: 8px; margin-bottom: 12px; }
    .timer-box { font-size: 0.85rem; color: #4C1D95; margin-bottom: 12px; }
    .btn-download { display: inline-flex; align-items: center; gap: 4px; padding: 8px 14px; background: #4C1D95; color: #fff; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
    .summary-card-box h3 { margin: 0 0 12px; font-size: 1.1rem; color: #4C1D95; font-weight: 700; }
    .summary-card-box p { margin: 0 0 6px; font-size: 0.85rem; color: #4a4452; }
    .total-highlight { font-size: 1.1rem; font-weight: 800; color: #4C1D95; margin-top: 12px; padding: 10px; background: #ebddff; border-radius: 8px; text-align: center; }
    .btn-konfirmasi { display: flex; align-items: center; justify-content: center; gap: 6px; width: 100%; background: #059669; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; }
    .btn-konfirmasi:hover { background: #047857; }
</style>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= esc($clientKey) ?>"></script>
<script>
document.getElementById('btn-bayar-snap').addEventListener('click', function () {
    snap.pay('<?= esc($snapToken) ?>', {
        onSuccess: function (result) {
            window.location.href = '<?= base_url('pesan-stand/berhasil/' . $booking['kode_booking']) ?>';
        },
        onPending: function (result) {
            window.location.href = '<?= base_url('pesan-stand/berhasil/' . $booking['kode_booking']) ?>';
        },
        onError: function (result) {
            alert('Pembayaran gagal, silakan coba lagi.');
        },
        onClose: function () {
            alert('Anda menutup popup sebelum menyelesaikan pembayaran. Klik tombol Bayar Sekarang untuk mencoba lagi.');
        }
    });
});
</script>

<?= $this->include('partials/footer') ?>
