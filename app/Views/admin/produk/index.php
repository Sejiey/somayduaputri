<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .product-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-info-group {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-img {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        object-fit: cover;
        background: #F3F4F6;
    }

    .product-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .product-meta {
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .product-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    /* TOGGLE SWITCH STYLING */
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
    }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: #E5E7EB; transition: .3s; border-radius: 34px;
    }
    .slider:before {
        position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white; transition: .3s; border-radius: 50%;
    }
    input:checked + .slider { background-color: var(--primary); }
    input:checked + .slider:before { transform: translateX(22px); }

    /* MODAL STYLING */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #fff; border-radius: 20px; width: 90%; max-width: 480px; padding: 28px;
    }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 6px; color: var(--primary); }
    .form-control {
        width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color);
        border-radius: 12px; font-size: 0.9rem; font-family: inherit; outline: none;
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Produk / Menu</h1>
        <p>Kelola menu yang tersedia di etalase.</p>
    </div>
    <button onclick="openAddModal()" class="btn-primary">
        <span class="material-symbols-outlined">add</span> + Tambah Menu
    </button>
</div>

<!-- TABS FILTER -->
<div class="custom-tabs">
    <a href="<?= base_url('admin/produk?tab=semua') ?>" class="tab-btn <?= $current_tab === 'semua' ? 'active' : '' ?>">
        Semua (<?= $count_semua ?>)
    </a>
    <a href="<?= base_url('admin/produk?tab=aktif') ?>" class="tab-btn <?= $current_tab === 'aktif' ? 'active' : '' ?>">
        Aktif (<?= $count_aktif ?>)
    </a>
    <a href="<?= base_url('admin/produk?tab=nonaktif') ?>" class="tab-btn <?= $current_tab === 'nonaktif' ? 'active' : '' ?>">
        Nonaktif (<?= $count_nonaktif ?>)
    </a>
</div>

<!-- FLASH NOTIFICATION -->
<?php if (session()->getFlashdata('success')): ?>
    <div style="background:#D1FAE5; color:#059669; padding:12px 18px; border-radius:14px; margin-bottom:20px; font-weight:600; font-size:0.85rem;">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<!-- PRODUCT LIST -->
<div class="product-list">
    <?php if (!empty($produk)): ?>
        <?php foreach ($produk as $p): ?>
            <?php 
                $namaLower = strtolower($p['nama']);
                $img = 'menu_1.png';
                if (strpos($namaLower, 'lumpia') !== false) $img = 'menu_2.jpeg';
                elseif (strpos($namaLower, 'siomay') !== false || strpos($namaLower, 'somay') !== false) $img = 'somay.png';
                elseif (strpos($namaLower, 'tahu') !== false) $img = 'tahu.png';
                elseif (strpos($namaLower, 'teh') !== false) $img = 'menu_1.png';
                elseif (strpos($namaLower, 'jeruk') !== false) $img = 'menu_1.png';
            ?>
            <div class="product-card">
                <div class="product-info-group">
                    <img src="<?= base_url('assets/img/' . $img) ?>" class="product-img" alt="<?= esc($p['nama']) ?>" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                    <div>
                        <div class="product-title">
                            <?= esc($p['nama']) ?>
                            <span class="badge-status <?= $p['status_aktif'] ? 'aktif' : 'nonaktif' ?>">
                                <?= $p['status_aktif'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </div>
                        <div class="product-meta">Kategori: <?= esc($p['kategori']) ?></div>
                        <div class="product-meta" style="font-weight:700; color:var(--text-dark); margin-top:2px;">
                            Harga: Rp<?= number_format($p['harga'], 0, ',', '.') ?>/porsi
                        </div>
                    </div>
                </div>

                <div class="product-actions">
                    <button onclick='openEditModal(<?= json_encode($p) ?>)' class="btn-secondary" style="padding:6px 12px; font-size:0.8rem;">
                        <span class="material-symbols-outlined" style="font-size:16px;">edit</span> Edit
                    </button>
                    <a href="<?= base_url('admin/produk/delete/' . $p['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" class="btn-secondary" style="padding:6px 12px; font-size:0.8rem; color:var(--accent-red); border-color:#FECACA;">
                        <span class="material-symbols-outlined" style="font-size:16px;">delete</span> Hapus
                    </a>

                    <!-- TOGGLE SWITCH FORM -->
                    <form action="<?= base_url('admin/produk/toggle-status/' . $p['id']) ?>" method="post" id="toggle-form-<?= $p['id'] ?>">
                        <?= csrf_field() ?>
                        <label class="switch">
                            <input type="checkbox" <?= $p['status_aktif'] ? 'checked' : '' ?> onchange="document.getElementById('toggle-form-<?= $p['id'] ?>').submit()">
                            <span class="slider"></span>
                        </label>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card-panel" style="text-align:center; padding: 40px; color: var(--text-muted);">
            Belum ada produk dalam kategori ini.
        </div>
    <?php endif; ?>
</div>

<!-- MODAL TAMBAH MENU -->
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <h3 style="color:var(--primary); margin-bottom:20px;">+ Tambah Menu Baru</h3>
        <form action="<?= base_url('admin/produk/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Siomay Isi">
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="Menu Pokok">Menu Pokok</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" required placeholder="10000">
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="status_aktif" value="1" checked id="status_add">
                <label for="status_add" style="font-size:0.85rem; font-weight:600;">Status Aktif</label>
            </div>
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" onclick="closeAddModal()" class="btn-secondary" style="flex:1; justify-content:center;">Batal</button>
                <button type="submit" class="btn-primary" style="flex:1; justify-content:center;">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT MENU -->
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <h3 style="color:var(--primary); margin-bottom:20px;">Edit Menu</h3>
        <form id="editForm" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" id="edit_kategori" class="form-control" required>
                    <option value="Menu Pokok">Menu Pokok</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="edit_harga" class="form-control" required>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="status_aktif" value="1" id="edit_status">
                <label for="edit_status" style="font-size:0.85rem; font-weight:600;">Status Aktif</label>
            </div>
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" onclick="closeEditModal()" class="btn-secondary" style="flex:1; justify-content:center;">Batal</button>
                <button type="submit" class="btn-primary" style="flex:1; justify-content:center;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.add('active');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.remove('active');
    }
    function openEditModal(data) {
        document.getElementById('editForm').action = '<?= base_url('admin/produk/update/') ?>' + data.id;
        document.getElementById('edit_nama').value = data.nama;
        document.getElementById('edit_kategori').value = data.kategori;
        document.getElementById('edit_harga').value = parseInt(data.harga);
        document.getElementById('edit_status').checked = data.status_aktif == 1;
        document.getElementById('editModal').classList.add('active');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }
</script>

<?= $this->endSection() ?>
