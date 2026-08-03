<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .card-panel {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .card-panel-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .link-action {
        color: var(--primary);
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
    }
    .link-action:hover { text-decoration: underline; }

    .order-ledger-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* PAPER LEDGER ROW ITEM */
    .ledger-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: var(--t-normal);
        text-decoration: none;
        color: inherit;
    }
    .ledger-row:hover {
        background: var(--primary-soft);
        border-color: var(--primary-badge);
    }

    .customer-name {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 2px;
        text-transform: capitalize;
    }

    .order-details-text {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .right-status-group {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    .price-text {
        font-weight: 800;
        font-size: 0.95rem;
        color: var(--primary);
    }

    .btn-block-action {
        width: 100%;
        padding: 13px;
        background: var(--primary);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: var(--t-normal);
    }
    .btn-block-action:hover { background: var(--primary-hover); }

    @media (max-width: 992px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Selamat datang, Admin 👋</h1>
        <p>Kelola pesanan dan laporan usaha dengan mudah.</p>
    </div>
    <div class="date-badge">
        <span class="material-symbols-outlined" style="font-size:18px; color:var(--primary);">calendar_today</span>
        Hari ini, <?= date('d M Y') ?>
    </div>
</div>

<!-- STAT CARDS TOP (4 CARDS) -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Pesan Antar <small>(Hari ini)</small></span>
        </div>
        <div class="stat-value"><?= $antar_today_count ?></div>
        <div class="stat-subtext highlight"><?= $antar_baru_count ?> pesanan baru</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Pesan Acara <small>(Aktif)</small></span>
        </div>
        <div class="stat-value"><?= $acara_aktif_count ?></div>
        <div class="stat-subtext highlight"><?= $acara_akan_datang_count ?> akan datang</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Pendapatan <small>(Hari Ini)</small></span>
        </div>
        <div class="stat-value">Rp<?= number_format($pendapatan_today, 0, ',', '.') ?></div>
        <div class="stat-subtext positive">+12% dari kemarin</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Pesanan</span>
        </div>
        <div class="stat-value"><?= $total_pesanan_all ?></div>
        <div class="stat-subtext">Semua waktu</div>
    </div>
</div>

<!-- DASHBOARD MAIN 2 COLUMNS -->
<div class="dashboard-grid">
    <!-- LEFT COLUMN: PESAN ANTAR (HARI INI) -->
    <div class="card-panel">
        <div>
            <div class="card-panel-header">
                <div class="card-panel-title">
                    Pesan Antar <small style="color:var(--text-muted); font-weight:500;">(Hari ini)</small>
                </div>
                <a href="<?= base_url('admin/pesan-antar') ?>" class="link-action">Lihat semua</a>
            </div>

            <div class="order-ledger-list">
                <?php if (!empty($recent_antar)): ?>
                    <?php foreach ($recent_antar as $item): ?>
                        <?php 
                            $statusRaw = strtolower($item['status'] ?? 'lunas');
                            
                            if ($statusRaw === 'diproses') {
                                $humanStatus = 'Diproses';
                                $badgeClass  = 'diproses';
                            } elseif ($statusRaw === 'selesai') {
                                $humanStatus = 'Selesai';
                                $badgeClass  = 'selesai';
                            } else {
                                $humanStatus = 'Lunas';
                                $badgeClass  = 'lunas';
                            }

                            $metodeLabel = ($item['metode'] ?? 'diantar') === 'diantar' 
                                ? (($item['lokasi'] ?? '') === 'Undata' ? 'Antar (Fee 5rb)' : 'Antar (Maxim)') 
                                : 'Ambil Sendiri';
                        ?>
                        <a href="<?= base_url('admin/pesan-antar') ?>" class="ledger-row">
                            <div>
                                <!-- NAMA PEMESAN UTAMA -->
                                <div class="customer-name"><?= esc($item['nama_pembeli'] ?? 'Pelanggan') ?></div>
                                <div class="order-details-text">
                                    <?= date('H:i', strtotime($item['created_at'])) ?> WIB &nbsp;•&nbsp; <?= esc($item['ruangan'] ?? $item['alamat'] ?? 'Undata') ?>
                                </div>
                            </div>

                            <div class="right-status-group">
                                <span class="badge-status <?= $badgeClass ?>"><?= $humanStatus ?></span>
                                <span style="font-size:0.75rem; font-weight:600; color:var(--text-muted);"><?= esc($metodeLabel) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center; padding: 32px; color: var(--text-muted); font-size: 0.85rem;">Belum ada pesanan antar terkonfirmasi hari ini.</div>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('admin/pesan-antar') ?>" class="btn-block-action">Kelola Pesan Antar</a>
    </div>

    <!-- RIGHT COLUMN: PESAN ACARA (CATERING) -->
    <div class="card-panel">
        <div>
            <div class="card-panel-header">
                <div class="card-panel-title">
                    Pesan Acara <small style="color:var(--text-muted); font-weight:500;">(Catering)</small>
                </div>
                <a href="<?= base_url('admin/pesan-acara') ?>" class="link-action">Lihat semua</a>
            </div>

            <div class="order-ledger-list">
                <?php if (!empty($recent_acara)): ?>
                    <?php foreach ($recent_acara as $acara): ?>
                        <?php 
                            $statusRaw = strtolower($acara['status_pembayaran'] ?? 'lunas');
                            
                            if ($statusRaw === 'diproses') {
                                $humanStatus = 'Diproses';
                                $badgeClass  = 'diproses';
                            } elseif ($statusRaw === 'selesai') {
                                $humanStatus = 'Selesai';
                                $badgeClass  = 'selesai';
                            } else {
                                $humanStatus = 'Lunas';
                                $badgeClass  = 'lunas';
                            }
                        ?>
                        <a href="<?= base_url('admin/pesan-acara') ?>" class="ledger-row">
                            <div>
                                <!-- NAMA PEMESAN UTAMA -->
                                <div class="customer-name"><?= esc($acara['nama_pemesan'] ?? 'Pelanggan') ?></div>
                                <div class="order-details-text">
                                    Acara: <?= date('d M Y', strtotime($acara['tanggal_acara'])) ?>
                                </div>
                            </div>

                            <div class="right-status-group">
                                <span class="badge-status <?= $badgeClass ?>"><?= $humanStatus ?></span>
                                <div class="price-text">Rp<?= number_format($acara['total'], 0, ',', '.') ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center; padding: 32px; color: var(--text-muted); font-size: 0.85rem;">Belum ada pesanan acara terkonfirmasi.</div>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('admin/pesan-acara') ?>" class="btn-block-action">Kelola Pesan Acara</a>
    </div>
</div>

<!-- BOTTOM SECTION: LAPORAN KEUANGAN (RINGKASAN) -->
<div class="card-panel">
    <div class="card-panel-header">
        <div class="card-panel-title">
            Laporan Keuangan <small style="color:var(--text-muted); font-weight:500;">(Ringkasan)</small>
        </div>
        <a href="<?= base_url('admin/laporan') ?>" class="link-action">Lihat laporan lengkap</a>
    </div>

    <div class="stats-grid" style="margin-bottom:0;">
        <div class="stat-card" style="background:#F9FAFB;">
            <span class="stat-title">Pendapatan Kotor</span>
            <div class="stat-value" style="font-size:1.3rem; color:var(--primary);">Rp<?= number_format($pendapatan_kotor, 0, ',', '.') ?></div>
            <div class="stat-subtext positive">+15% dari bulan lalu</div>
        </div>

        <div class="stat-card" style="background:#F9FAFB;">
            <span class="stat-title">Total Pengeluaran</span>
            <div class="stat-value" style="font-size:1.3rem;">Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
            <div class="stat-subtext highlight">-5% dari bulan lalu</div>
        </div>

        <div class="stat-card" style="background:#F9FAFB;">
            <span class="stat-title">Laba Bersih</span>
            <div class="stat-value" style="font-size:1.3rem; color:#059669;">Rp<?= number_format($laba_bersih, 0, ',', '.') ?></div>
            <div class="stat-subtext positive">+20% dari bulan lalu</div>
        </div>

        <div class="stat-card" style="background:#F9FAFB;">
            <span class="stat-title">Total Transaksi</span>
            <div class="stat-value" style="font-size:1.3rem; color:var(--primary);"><?= $total_transaksi ?></div>
            <div class="stat-subtext positive">+18% dari bulan lalu</div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
