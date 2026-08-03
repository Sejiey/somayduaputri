<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    .search-filter-box {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .search-input-wrap .material-symbols-outlined {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 20px;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px 10px 42px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.85rem;
        outline: none;
        background: #ffffff;
        font-family: inherit;
    }

    .select-filter {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.85rem;
        outline: none;
        background: #ffffff;
        font-family: inherit;
        color: var(--text-dark);
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Pelanggan</h1>
        <p>Kelola data pelanggan yang pernah melakukan pemesanan.</p>
    </div>

    <div class="search-filter-box">
        <form action="<?= base_url('admin/pelanggan') ?>" method="get" style="display:flex; gap:12px; flex:1;">
            <div class="search-input-wrap">
                <span class="material-symbols-outlined">search</span>
                <input type="text" name="q" value="<?= esc($search_query) ?>" class="search-input" placeholder="Cari nama, nomor, atau email...">
            </div>

            <select name="status" class="select-filter" onchange="this.form.submit()">
                <option value="">Semua Pelanggan</option>
                <option value="aktif" <?= $status_filter === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="tidak_aktif" <?= $status_filter === 'tidak_aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </form>

        <a href="<?= base_url('admin/pelanggan/export') ?>" class="btn-primary">
            <span class="material-symbols-outlined">download</span> Export Data
        </a>
    </div>
</div>

<!-- STAT CARDS (4 CARDS) -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Pelanggan</span>
            <div class="stat-icon blue">
                <span class="material-symbols-outlined">person</span>
            </div>
        </div>
        <div class="stat-value"><?= $total_pelanggan ?></div>
        <div class="stat-subtext">Semua waktu</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Pelanggan Aktif</span>
            <div class="stat-icon green">
                <span class="material-symbols-outlined">person_check</span>
            </div>
        </div>
        <div class="stat-value"><?= $pelanggan_aktif ?></div>
        <div class="stat-subtext positive">30 hari terakhir</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Pelanggan Baru</span>
            <div class="stat-icon purple">
                <span class="material-symbols-outlined">person_add</span>
            </div>
        </div>
        <div class="stat-value"><?= $pelanggan_baru ?></div>
        <div class="stat-subtext">30 hari terakhir</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Repeat Order</span>
            <div class="stat-icon pink">
                <span class="material-symbols-outlined">published_with_changes</span>
            </div>
        </div>
        <div class="stat-value"><?= $repeat_rate ?>%</div>
        <div class="stat-subtext">Persentase pelanggan</div>
    </div>
</div>

<!-- CUSTOMER TABLE -->
<div class="table-card" style="background:#ffffff; border-radius:var(--radius-card); padding:24px; box-shadow:var(--shadow-card); border:1px solid var(--border-color);">
    <table class="data-table">
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
                    <tr>
                        <td style="font-weight:700; color:var(--text-dark);">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:var(--primary-soft); color:var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem;">
                                    <?= strtoupper(substr($c['nama'], 0, 1)) ?>
                                </div>
                                <?= esc($c['nama']) ?>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);"><?= esc($c['nomor_hp']) ?></td>
                        <td style="font-weight:600;"><?= $c['total_pesanan'] ?? 1 ?></td>
                        <td style="font-weight:700; color:var(--primary);">Rp<?= number_format($c['total_belanja'] ?? 50000, 0, ',', '.') ?></td>
                        <td style="color:var(--text-muted);"><?= date('d M Y', strtotime($c['terakhir_order'] ?? $c['created_at'])) ?></td>
                        <td>
                            <span class="badge-status <?= ($c['status_label'] ?? 'Aktif') === 'Aktif' ? 'aktif' : 'nonaktif' ?>">
                                <?= esc($c['status_label'] ?? 'Aktif') ?>
                            </span>
                        </td>
                        <td><span class="material-symbols-outlined" style="color:var(--text-muted); cursor:pointer;">chevron_right</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">Tidak ada data pelanggan yang cocok.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
