<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<!-- TODO: frontend bisa menambahkan modal/dialog konfirmasi 'Yakin pesanan sudah benar?' di halaman ini sebelum submit -->
<h1>Data Pemesan (Diantar via Maxim)</h1>

<?php if (isset($errors) && $errors): ?>
  <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
<?php endif; ?>

<form method="post" action="<?= base_url('pesan-antar/data-diantar') ?>">
    <?= csrf_field() ?>
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" value="<?= esc($nama ?? '') ?>" required>

    <label>No. WhatsApp:</label>
    <input type="text" name="nomor_hp" value="<?= esc($nomorHp ?? '') ?>" required>

    <label>Alamat Lengkap:</label>
    <textarea name="alamat" required><?= esc($alamat ?? '') ?></textarea>

    <label>Catatan Kurir (Opsional):</label>
    <textarea name="catatan_kurir"><?= esc($catatanKurir ?? '') ?></textarea>

    <input type="hidden" name="alamat_lat" value="<?= esc($alamatLat ?? '-0.891684') ?>">
    <input type="hidden" name="alamat_lng" value="<?= esc($alamatLng ?? '119.870732') ?>">

    <button type="submit">Bayar Sekarang</button>
</form>

<a href="<?= base_url('pesan-antar/ringkasan') ?>">Kembali</a>
