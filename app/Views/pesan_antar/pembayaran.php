<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<h1>Pembayaran QRIS</h1>

<p>No. Pesanan: <?= esc($pesanan['kode_pesanan'] ?? '') ?></p>
<p>Total Pembayaran: Rp<?= esc(number_format((float)($pesanan['total'] ?? 0), 0, ',', '.')) ?></p>

<p>Scan QRIS di bawah ini untuk membayar:</p>
<img src="<?= esc(base_url('assets/img/qris.jpeg')) ?>" alt="QRIS Placeholder" width="200">

<p>Waktu tersisa: <span id="countdown">15:00</span></p>

<form method="post" action="<?= base_url('pesan-antar/konfirmasi/' . ($pesanan['kode_pesanan'] ?? '')) ?>">
    <?= csrf_field() ?>
    <button type="submit">Saya Sudah Bayar</button>
</form>

<a href="<?= base_url('pesan-antar/form') ?>">Kembali</a>
