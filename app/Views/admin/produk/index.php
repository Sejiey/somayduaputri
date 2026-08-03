<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    /* MAIN ADMIN PANEL CARD CONTAINER */
    .admin-panel-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #ECE7FE;
        box-shadow: 0 10px 40px rgba(59, 25, 143, 0.05);
        padding: 32px 36px;
        max-width: 1050px;
        margin: 0 auto;
    }

    /* HEADER & ACTION */
    .panel-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .panel-header-row h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2D1A56;
        margin: 0 0 4px 0;
    }

    .panel-header-row p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .btn-add-menu {
        background: #4A1E9E;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(74, 30, 158, 0.2);
    }

    .btn-add-menu:hover {
        background: #3b198f;
    }

    /* SEARCH & FILTER BAR */
    .catalog-filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .custom-tabs-clean {
        display: flex;
        gap: 8px;
        background: #F4EFFF;
        padding: 4px;
        border-radius: 12px;
    }

    .tab-btn-clean {
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 0.82rem;
        font-weight: 700;
        color: #6B7280;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .tab-btn-clean.active {
        background: #ffffff;
        color: #4A1E9E;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .catalog-search-box {
        position: relative;
        width: 280px;
    }

    .catalog-search-box .material-symbols-outlined {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 18px;
    }

    .catalog-search-input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.85rem;
        outline: none;
        background: #ffffff;
        font-family: inherit;
    }

    /* PRODUCT CATALOG GRID (2 Kolom Rapi) */
    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .menu-card-item {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(59, 25, 143, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: border-color 0.2s ease, transform 0.2s ease;
    }

    .menu-card-item:hover {
        border-color: #CBD5E1;
        transform: translateY(-2px);
    }

    .menu-card-top {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .menu-img-thumb {
        width: 76px;
        height: 76px;
        border-radius: 14px;
        object-fit: cover;
        background: #F3F4F6;
        flex-shrink: 0;
        border: 1px solid #E5E7EB;
    }

    .menu-info-detail {
        flex: 1;
    }

    .menu-name-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }

    .menu-title-name {
        font-size: 1rem;
        font-weight: 800;
        color: #1E1B26;
    }

    .status-badge-sale {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 12px;
        white-space: nowrap;
    }

    .badge-sale-on { background: #DCFCE7; color: #15803D; }
    .badge-sale-off { background: #F1F5F9; color: #64748B; }

    .menu-category-tag {
        font-size: 0.8rem;
        color: #6B7280;
        margin-bottom: 6px;
    }

    .menu-price-tag {
        font-size: 0.95rem;
        font-weight: 800;
        color: #4A1E9E;
    }

    /* CARD FOOTER ACTIONS */
    .menu-card-footer {
        padding-top: 14px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .toggle-label-group {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
    }

    /* TOGGLE SWITCH */
    .switch-clean {
        position: relative;
        display: inline-block;
        width: 42px;
        height: 22px;
    }
    .switch-clean input { opacity: 0; width: 0; height: 0; }
    .slider-clean {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: #CBD5E1; transition: .3s; border-radius: 34px;
    }
    .slider-clean:before {
        position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px;
        background-color: white; transition: .3s; border-radius: 50%;
    }
    input:checked + .slider-clean { background-color: #4A1E9E; }
    input:checked + .slider-clean:before { transform: translateX(20px); }

    .btn-icon-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        border: 1px solid var(--border-color);
        background: #ffffff;
        color: #334155;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-icon-action:hover {
        background: #F4EFFF;
        color: #4A1E9E;
        border-color: #D4C4FC;
    }

    .btn-icon-action.delete-btn {
        color: #DC2626;
        border-color: #FCA5A5;
        background: #FEF2F2;
    }

    .btn-icon-action.delete-btn:hover {
        background: #DC2626;
        color: #ffffff;
    }

    /* MODAL STYLING */
    .modal-overlay-clean {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-overlay-clean.active { display: flex; }
    .modal-box-clean {
        background: #fff; border-radius: 20px; width: 90%; max-width: 460px; padding: 28px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    .form-group-clean { margin-bottom: 16px; }
    .form-label-clean { display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 6px; color: #2D1A56; }
    .form-control-clean {
        width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color);
        border-radius: 10px; font-size: 0.88rem; font-family: inherit; outline: none;
    }

    @media (max-width: 850px) {
        .admin-panel-card { padding: 20px 16px; }
        .catalog-grid { grid-template-columns: 1fr; }
        .catalog-search-box { width: 100%; }
    }
</style>

<!-- MAIN OUTER PANEL CARD CONTAINER -->
<div class="admin-panel-card">

    <!-- PAGE HEADER -->
    <div class="panel-header-row">
        <div>
            <h1>Etalase Menu Toko</h1>
            <p>Kelola daftar menu, atur harga, dan aktifkan menu yang dijual kepada pembeli.</p>
        </div>
        <button onclick="openAddModal()" class="btn-add-menu">
            <span class="material-symbols-outlined">add</span> + Tambah Menu Baru
        </button>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="catalog-filter-bar">
        <div class="custom-tabs-clean">
            <a href="<?= base_url('admin/produk?tab=semua') ?>" class="tab-btn-clean <?= $current_tab === 'semua' ? 'active' : '' ?>">
                Semua (<?= $count_semua ?>)
            </a>
            <a href="<?= base_url('admin/produk?tab=aktif') ?>" class="tab-btn-clean <?= $current_tab === 'aktif' ? 'active' : '' ?>">
                Menu Aktif (<?= $count_aktif ?>)
            </a>
            <a href="<?= base_url('admin/produk?tab=nonaktif') ?>" class="tab-btn-clean <?= $current_tab === 'nonaktif' ? 'active' : '' ?>">
                Nonaktif (<?= $count_nonaktif ?>)
            </a>
        </div>

        <div class="catalog-search-box">
            <span class="material-symbols-outlined">search</span>
            <input type="text" id="searchInput" onkeyup="filterMenuCatalog()" class="catalog-search-input" placeholder="Cari nama menu etalase...">
        </div>
    </div>

    <!-- FLASH NOTIFICATION -->
    <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#DCFCE7; color:#15803D; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-weight:700; font-size:0.85rem;">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- PRODUCT CATALOG GRID (2 Kolom Rapi) -->
    <div class="catalog-grid" id="catalogGrid">
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
                    $isAktif = (int)$p['status_aktif'] === 1;
                ?>
                <div class="menu-card-item" data-name="<?= esc(strtolower($p['nama'])) ?>">
                    <div class="menu-card-top">
                        <img src="<?= base_url('assets/img/' . $img) ?>" class="menu-img-thumb" alt="<?= esc($p['nama']) ?>" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                        
                        <div class="menu-info-detail">
                            <div class="menu-name-row">
                                <span class="menu-title-name"><?= esc($p['nama']) ?></span>
                                <span class="status-badge-sale <?= $isAktif ? 'badge-sale-on' : 'badge-sale-off' ?>">
                                    <?= $isAktif ? '● Aktif (Dijual)' : '● Nonaktif' ?>
                                </span>
                            </div>
                            
                            <div class="menu-category-tag">Kategori: <strong><?= esc($p['kategori']) ?></strong></div>
                            <div class="menu-price-tag">Rp <?= number_format((float)$p['harga'], 0, ',', '.') ?> <small style="font-weight:500; font-size:0.75rem; color:#6B7280;">/ porsi</small></div>
                        </div>
                    </div>

                    <div class="menu-card-footer">
                        <form action="<?= base_url('admin/produk/toggle-status/' . $p['id']) ?>" method="post" id="toggle-form-<?= $p['id'] ?>">
                            <?= csrf_field() ?>
                            <label class="toggle-label-group" title="Aktifkan atau sembunyikan dari pembeli">
                                <span class="switch-clean">
                                    <input type="checkbox" <?= $isAktif ? 'checked' : '' ?> onchange="document.getElementById('toggle-form-<?= $p['id'] ?>').submit()">
                                    <span class="slider-clean"></span>
                                </span>
                                <span>Tampil di Toko</span>
                            </label>
                        </form>

                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick='openEditModal(<?= json_encode($p) ?>)' class="btn-icon-action">
                                <span class="material-symbols-outlined" style="font-size:16px;">edit</span> Edit
                            </button>
                            <a href="<?= base_url('admin/produk/delete/' . $p['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini dari etalase?')" class="btn-icon-action delete-btn" title="Hapus menu">
                                <span class="material-symbols-outlined" style="font-size:16px;">delete</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align:center; padding: 40px; color: var(--text-muted); font-size:0.9rem;">
                Belum ada produk menu dalam etalase toko.
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- MODAL TAMBAH MENU -->
<div id="addModal" class="modal-overlay-clean">
    <div class="modal-box-clean">
        <h3 style="color:#2D1A56; margin-bottom:20px; font-weight:800;">+ Tambah Menu Baru</h3>
        <form action="<?= base_url('admin/produk/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group-clean">
                <label class="form-label-clean">Nama Menu</label>
                <input type="text" name="nama" class="form-control-clean" required placeholder="Contoh: Siomay Kukus Spesial">
            </div>
            <div class="form-group-clean">
                <label class="form-label-clean">Kategori</label>
                <select name="kategori" class="form-control-clean" required>
                    <option value="Menu Pokok">Menu Pokok</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                    <option value="Lumpia">Lumpia</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>
            <div class="form-group-clean">
                <label class="form-label-clean">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control-clean" required placeholder="10000">
            </div>
            <div class="form-group-clean" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="status_aktif" value="1" checked id="status_add" style="width:18px; height:18px;">
                <label for="status_add" style="font-size:0.85rem; font-weight:700; color:#2D1A56; cursor:pointer;">Langsung Tampilkan di Etalase Toko</label>
            </div>
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" onclick="closeAddModal()" class="btn-icon-action" style="flex:1; justify-content:center; padding:10px;">Batal</button>
                <button type="submit" class="btn-add-menu" style="flex:1; justify-content:center; padding:10px;">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT MENU -->
<div id="editModal" class="modal-overlay-clean">
    <div class="modal-box-clean">
        <h3 style="color:#2D1A56; margin-bottom:20px; font-weight:800;">Edit Menu Etalase</h3>
        <form id="editForm" method="post">
            <?= csrf_field() ?>
            <div class="form-group-clean">
                <label class="form-label-clean">Nama Menu</label>
                <input type="text" name="nama" id="edit_nama" class="form-control-clean" required>
            </div>
            <div class="form-group-clean">
                <label class="form-label-clean">Kategori</label>
                <select name="kategori" id="edit_kategori" class="form-control-clean" required>
                    <option value="Menu Pokok">Menu Pokok</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                    <option value="Lumpia">Lumpia</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>
            <div class="form-group-clean">
                <label class="form-label-clean">Harga (Rp)</label>
                <input type="number" name="harga" id="edit_harga" class="form-control-clean" required>
            </div>
            <div class="form-group-clean" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="status_aktif" value="1" id="edit_status" style="width:18px; height:18px;">
                <label for="edit_status" style="font-size:0.85rem; font-weight:700; color:#2D1A56; cursor:pointer;">Tampilkan di Etalase Toko</label>
            </div>
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" onclick="closeEditModal()" class="btn-icon-action" style="flex:1; justify-content:center; padding:10px;">Batal</button>
                <button type="submit" class="btn-add-menu" style="flex:1; justify-content:center; padding:10px;">Simpan Perubahan</button>
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

    function filterMenuCatalog() {
        var input = document.getElementById("searchInput").value.toLowerCase();
        var cards = document.querySelectorAll("#catalogGrid .menu-card-item");
        cards.forEach(function(card) {
            var name = card.getAttribute("data-name") || "";
            if (name.indexOf(input) > -1) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

<?= $this->endSection() ?>
