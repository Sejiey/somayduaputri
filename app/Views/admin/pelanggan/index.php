<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    /* MAIN ADMIN PANEL CARD CONTAINER (Matching Pesan Acara, Pesan Antar & Produk) */
    .admin-panel-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #ECE7FE;
        box-shadow: 0 10px 40px rgba(59, 25, 143, 0.05);
        padding: 32px 36px;
        max-width: 1050px;
        margin: 0 auto;
    }

    /* TOP HEADER & SEARCH FILTER BAR */
    .panel-header-pelanggan {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .panel-header-pelanggan h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2D1A56;
        margin: 0 0 4px 0;
    }

    .panel-header-pelanggan p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .search-filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        width: 240px;
    }

    .search-box .material-symbols-outlined {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 18px;
    }

    .search-input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.82rem;
        outline: none;
        background: #ffffff;
        font-family: inherit;
        color: var(--text-dark);
    }

    .select-dropdown {
        padding: 9px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.82rem;
        outline: none;
        background: #ffffff;
        font-family: inherit;
        color: var(--text-dark);
        font-weight: 600;
        cursor: pointer;
    }

    .btn-export-purple {
        background: #4A1E9E;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.82rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-export-purple:hover {
        background: #3b198f;
    }

    /* STATS GRID 4 CARDS (Presisi & Tidak Kebesaran) */
    .pelanggan-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card-clean {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 18px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 16px rgba(59, 25, 143, 0.03);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-card-clean .stat-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .stat-card-clean .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 4px 0 2px 0;
    }

    .stat-card-clean .stat-sub {
        font-size: 0.72rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .stat-icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-blue { background: #E0F2FE; color: #0284C7; }
    .icon-green { background: #DCFCE7; color: #166534; }
    .icon-purple { background: #F3E8FF; color: #7E22CE; }
    .icon-orange { background: #FEF3C7; color: #D97706; }

    /* TABLE CONTAINER */
    .table-container-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 16px rgba(59, 25, 143, 0.03);
        padding: 20px;
        overflow-x: auto;
    }

    .clean-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .clean-table th {
        font-size: 0.8rem;
        font-weight: 800;
        color: #2D1A56;
        padding: 12px 14px;
        border-bottom: 1.5px solid var(--border-color);
    }

    .clean-table td {
        font-size: 0.85rem;
        padding: 14px;
        border-bottom: 1px solid #F1F5F9;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .user-avatar-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F1F5F9;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .badge-aktif-clean {
        background: #DCFCE7;
        color: #15803D;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 12px;
        display: inline-block;
    }

    .badge-nonaktif-clean {
        background: #F1F5F9;
        color: #64748B;
        font-weight: 600;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 12px;
        display: inline-block;
    }

    @media (max-width: 1024px) {
        .admin-panel-card { padding: 20px 16px; }
        .pelanggan-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .pelanggan-stats-grid { grid-template-columns: 1fr; }
        .search-box { width: 100%; }
    }
</style>

<!-- MAIN OUTER PANEL CARD CONTAINER -->
<div class="admin-panel-card">

    <!-- PAGE HEADER -->
    <div class="panel-header-pelanggan">
        <div>
            <h1>Pelanggan</h1>
            <p>Kelola data pelanggan yang pernah melakukan pemesanan.</p>
        </div>

        <div class="search-filter-group">
            <form action="<?= base_url('admin/pelanggan') ?>" method="get" style="display:flex; gap:10px; flex-wrap:wrap;">
                <div class="search-box">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" name="q" value="<?= esc($search_query ?? '') ?>" class="search-input" placeholder="Cari nama, nomor, atau email...">
                </div>

                <select name="status" class="select-dropdown" onchange="this.form.submit()">
                    <option value="">Semua Pelanggan</option>
                    <option value="aktif" <?= ($status_filter ?? '') === 'aktif' ? 'selected' : '' ?>>Pelanggan Aktif</option>
                    <option value="tidak_aktif" <?= ($status_filter ?? '') === 'tidak_aktif' ? 'selected' : '' ?>>Pelanggan Tidak Aktif</option>
                </select>
            </form>

            <a href="<?= base_url('admin/pelanggan/export') ?>" class="btn-export-purple">
                Export Data
            </a>
        </div>
    </div>

    <!-- STATS GRID 4 CARDS (Presisi, Rapi, Compact) -->
    <div class="pelanggan-stats-grid">
        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Total Pelanggan</div>
                <div class="stat-value"><?= (int)$total_pelanggan ?></div>
                <div class="stat-sub">Semua waktu</div>
            </div>
            <div class="stat-icon-circle icon-blue">
                <span class="material-symbols-outlined" style="font-size:20px;">badge</span>
            </div>
        </div>

        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Pelanggan Aktif</div>
                <div class="stat-value"><?= (int)$pelanggan_aktif ?></div>
                <div class="stat-sub">30 hari terakhir</div>
            </div>
            <div class="stat-icon-circle icon-green">
                <span class="material-symbols-outlined" style="font-size:20px;">shopping_bag</span>
            </div>
        </div>

        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Pelanggan Baru</div>
                <div class="stat-value"><?= (int)$pelanggan_baru ?></div>
                <div class="stat-sub">30 hari terakhir</div>
            </div>
            <div class="stat-icon-circle icon-purple">
                <span class="material-symbols-outlined" style="font-size:20px;">person</span>
            </div>
        </div>

        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Repeat Order</div>
                <div class="stat-value"><?= (int)$repeat_rate ?>%</div>
                <div class="stat-sub">Persentase pelanggan</div>
            </div>
            <div class="stat-icon-circle icon-orange">
                <span class="material-symbols-outlined" style="font-size:20px;">local_mall</span>
            </div>
        </div>
    </div>

    <!-- DATA TABLE CONTAINER -->
    <div class="table-container-card">
        <table class="clean-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Total Pesanan</th>
                    <th>Total Belanja</th>
                    <th>Terakhir Order</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pelanggan)): ?>
                    <?php foreach ($pelanggan as $c): ?>
                        <?php 
                            $isAktif = ($c['status_label'] ?? 'Aktif') === 'Aktif';
                        ?>
                        <tr>
                            <td style="font-weight:700;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="user-avatar-small">
                                        <?= strtoupper(substr($c['nama'] ?? 'P', 0, 1)) ?>
                                    </div>
                                    <span><?= esc(strtolower($c['nama'])) ?></span>
                                </div>
                            </td>
                            <td style="color:var(--text-muted);"><?= esc($c['nomor_hp'] ?? '0812-3456-7890') ?></td>
                            <td style="font-weight:600;"><?= $c['total_pesanan'] ?? 0 ?></td>
                            <td style="font-weight:700; color:#2D1A56;">Rp<?= number_format($c['total_belanja'] ?? 0, 0, ',', '.') ?></td>
                            <td style="color:var(--text-muted);"><?= date('d M Y', strtotime($c['terakhir_order'] ?? $c['created_at'])) ?></td>
                            <td>
                                <span class="<?= $isAktif ? 'badge-aktif-clean' : 'badge-nonaktif-clean' ?>">
                                    <?= $isAktif ? 'Aktif' : 'Tidak Aktif' ?>
                                </span>
                            </td>
                            <td>
                                <span class="material-symbols-outlined" style="color:#CBD5E1; cursor:pointer; font-size:18px;">chevron_right</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">Tidak ada data pelanggan yang cocok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>
