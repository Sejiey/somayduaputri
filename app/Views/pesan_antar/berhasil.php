<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<h1>Pesanan Berhasil!</h1>

<p>No. Pesanan: <?= esc($pesanan['kode_pesanan'] ?? '') ?></p>
<p>Status: <?= esc($pesanan['status'] ?? '') ?></p>

<a href="<?= base_url('akun/riwayat') ?>">Lihat Pesanan Saya</a>
<?php if (!empty($waUrl)): ?>
  <a href="<?= esc($waUrl) ?>" target="_blank">Chat WhatsApp Penjual</a>
<?php endif; ?>

<a href="<?= base_url('/') ?>">Kembali ke Beranda</a>
