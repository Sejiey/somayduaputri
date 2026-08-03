<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Pengaturan UMKM</h1>
        <p>Kelola informasi toko, jam operasional, dan parameter sistem.</p>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div style="background:#D1FAE5; color:#059669; padding:12px 18px; border-radius:14px; margin-bottom:20px; font-weight:600; font-size:0.85rem;">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>

<div class="table-card" style="max-width:700px; background:#ffffff; border-radius:var(--radius-card); padding:32px; box-shadow:var(--shadow-card); border:1px solid var(--border-color);">
    <form action="<?= base_url('admin/pengaturan/save') ?>" method="post">
        <?= csrf_field() ?>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Pajak Aktif?</label>
            <select name="pajak_aktif" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;">
                <option value="0" <?= ($p['pajak_aktif'] ?? 0) == 0 ? 'selected' : '' ?>>Non-Aktif (0%)</option>
                <option value="1" <?= ($p['pajak_aktif'] ?? 0) == 1 ? 'selected' : '' ?>>Aktif</option>
            </select>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Persentase Pajak (%)</label>
            <input type="number" step="0.01" name="pajak_persen" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;" value="<?= esc($p['pajak_persen'] ?? 0) ?>">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Minimum Order Pesan Antar (Rp)</label>
            <input type="number" step="1000" name="minimum_order" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;" value="<?= esc($p['minimum_order'] ?? 50000) ?>">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Alamat UMKM (Kantin Undata / Toko)</label>
            <input type="text" name="alamat_umkm" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;" value="<?= esc($p['alamat_umkm'] ?? 'Kantin RSUD Undata, Palu') ?>">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
            <div>
                <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Jam Buka</label>
                <input type="time" name="jam_buka" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;" value="<?= esc($p['jam_buka'] ?? '08:00') ?>">
            </div>
            <div>
                <label style="display:block; font-weight:600; font-size:0.85rem; margin-bottom:6px; color:var(--primary);">Jam Tutup</label>
                <input type="time" name="jam_tutup" style="width:100%; padding:10px 14px; border:1.5px solid var(--border-color); border-radius:12px; font-size:0.9rem; font-family:inherit; outline:none;" value="<?= esc($p['jam_tutup'] ?? '21:00') ?>">
            </div>
        </div>

        <button type="submit" class="btn-primary">Simpan Pengaturan</button>
    </form>
</div>

<?= $this->endSection() ?>
