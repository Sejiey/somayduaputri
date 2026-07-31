<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<!-- TODO: frontend bisa menambahkan modal/dialog konfirmasi 'Yakin pesanan sudah benar?' di halaman ini sebelum submit -->
<h1>Data Pemesan (Ambil Sendiri)</h1>

<?php if (isset($errors) && $errors): ?>
  <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
<?php endif; ?>

<p>Lokasi Pengambilan: <?= esc($pengaturan['alamat_umkm'] ?? 'Siomay Dua Putri') ?></p>

<form method="post" action="<?= base_url('pesan-antar/data-ambil-sendiri') ?>">
    <?= csrf_field() ?>
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" value="<?= esc($nama ?? '') ?>" required>

    <label>No. WhatsApp:</label>
    <input type="text" name="nomor_hp" value="<?= esc($nomorHp ?? '') ?>" required>

    <label>Catatan Pesan (Opsional):</label>
    <textarea name="catatan_pemesan"><?= esc($catatanPemesan ?? '') ?></textarea>

    <button type="submit">Bayar Sekarang</button>
</form>

<a href="<?= base_url('pesan-antar/ringkasan') ?>">Kembali</a>
