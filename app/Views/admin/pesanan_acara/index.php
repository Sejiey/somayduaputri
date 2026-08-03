<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    .order-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        margin-bottom: 14px;
        overflow: hidden;
    }

    .order-card-header {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        background: #ffffff;
        user-select: none;
        transition: var(--t-normal);
    }
    .order-card-header:hover { background: #FAF9FE; }

    .customer-name-heading {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--text-dark);
        text-transform: capitalize;
    }

    .order-meta-info {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .order-card-body {
        padding: 20px 24px;
        border-top: 1px border-dashed var(--border-color);
        background: #FAFAFD;
        display: none;
    }

    .order-card.expanded .order-card-body { display: block; }
    .order-card.expanded .toggle-icon { transform: rotate(180deg); }

    .section-subhead {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 12px;
    }

    .items-table {
        width: 100%;
        margin-bottom: 16px;
        border-collapse: collapse;
    }

    .items-table td {
        padding: 8px 0;
        font-size: 0.85rem;
        border-bottom: 1px dashed var(--border-color);
    }
    .items-table td.price { text-align: right; font-weight: 700; color: var(--primary); }

    .calc-box-sm {
        max-width: 280px;
        margin-left: auto;
        margin-bottom: 18px;
    }

    .calc-row-sm {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-bottom: 4px;
        color: var(--text-muted);
    }
    .calc-row-sm.total {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--primary);
        border-top: 1px dashed var(--border-color);
        padding-top: 8px;
        margin-top: 6px;
    }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Pesan Acara <small style="font-size:0.9rem; font-weight:500; color:var(--text-muted);">(Catering)</small></h1>
        <p>Daftar pesanan acara porsi besar berdasarkan nama pemesan.</p>
    </div>
    <div class="date-badge">
        <span class="material-symbols-outlined" style="font-size:18px; color:var(--primary);">calendar_today</span>
        <?= date('d M Y') ?>
    </div>
</div>

<!-- TABS FILTER -->
<div class="custom-tabs">
    <a href="<?= base_url('admin/pesan-acara?tab=semua') ?>" class="tab-btn <?= $current_tab === 'semua' ? 'active' : '' ?>">
        Semua (<?= $count_semua ?>)
    </a>
    <a href="<?= base_url('admin/pesan-acara?tab=ambil_sendiri') ?>" class="tab-btn <?= $current_tab === 'ambil_sendiri' ? 'active' : '' ?>">
        Diambil Sendiri (<?= $count_ambil ?>)
    </a>
    <a href="<?= base_url('admin/pesan-acara?tab=maxim') ?>" class="tab-btn <?= $current_tab === 'maxim' ? 'active' : '' ?>">
        Diantar Maxim (<?= $count_maxim ?>)
    </a>
</div>

<!-- FLASH MESSAGE -->
<?php if (session()->getFlashdata('success')): ?>
    <div style="background:#D1FAE5; color:#059669; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-weight:600; font-size:0.85rem;">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<!-- ORDER CARDS LIST -->
<div>
    <?php if (!empty($pesanan)): ?>
        <?php foreach ($pesanan as $index => $row): ?>
            <?php 
                $statusRaw = strtolower($row['status_pembayaran'] ?? 'pending');
                
                // Human Readable Status
                if ($statusRaw === 'pending' || $statusRaw === 'menunggu_pembayaran') {
                    $humanStatus = 'Belum Bayar';
                    $badgeClass  = 'baru';
                } elseif ($statusRaw === 'lunas' || $statusRaw === 'selesai') {
                    $humanStatus = 'Lunas';
                    $badgeClass  = 'lunas';
                } else {
                    $humanStatus = ucfirst($statusRaw);
                    $badgeClass  = 'diproses';
                }

                $metodeLabel = ($row['metode_pengambilan'] ?? 'diantar') === 'diantar' ? 'Diantar Maxim' : 'Diambil Sendiri';
            ?>
            <div class="order-card <?= $index === 0 ? 'expanded' : '' ?>" id="card-acara-<?= $row['id'] ?>">
                <div class="order-card-header" onclick="toggleCard(<?= $row['id'] ?>)">
                    <div>
                        <!-- NAMA PEMESAN UTAMA -->
                        <div class="customer-name-heading"><?= esc($row['nama_pemesan'] ?? 'Pemesan Acara') ?></div>
                        <div class="order-meta-info">
                            Tanggal Acara: <?= date('d M Y', strtotime($row['tanggal_acara'])) ?> &nbsp;•&nbsp; <?= esc($metodeLabel) ?>
                        </div>
                    </div>

                    <div style="display:flex; align-items:center; gap:14px;">
                        <span class="badge-status <?= $badgeClass ?>"><?= $humanStatus ?></span>
                        <span class="material-symbols-outlined toggle-icon" style="transition:0.2s; color:var(--text-muted);">expand_more</span>
                    </div>
                </div>

                <div class="order-card-body">
                    <div class="section-subhead">Ringkasan Pesanan (Catering Porsi Besar)</div>

                    <table class="items-table">
                        <tbody>
                            <?php if (!empty($row['items'])): ?>
                                <?php foreach ($row['items'] as $item): ?>
                                    <tr>
                                        <td>• <?= esc($item['produk_nama'] ?? 'Menu Acara') ?> <?= !empty($item['nama_varian']) ? '('.esc($item['nama_varian']).')' : '' ?></td>
                                        <td style="color:var(--text-muted);"><?= $item['jumlah'] ?> porsi</td>
                                        <td class="price">Rp<?= number_format($item['subtotal_item'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="color:var(--text-muted);">Pesanan porsi besar untuk tanggal <?= date('d F Y', strtotime($row['tanggal_acara'])) ?>.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="calc-box-sm">
                        <div class="calc-row-sm">
                            <span>Subtotal</span>
                            <span>Rp<?= number_format($row['subtotal'] ?? $row['total'], 0, ',', '.') ?></span>
                        </div>
                        <div class="calc-row-sm">
                            <span>Fee Antar (Maxim)</span>
                            <span>-</span>
                        </div>
                        <div class="calc-row-sm total">
                            <span>Total Pembayaran</span>
                            <span>Rp<?= number_format($row['total'], 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <div class="action-bar">
                        <form action="<?= base_url('admin/pesan-acara/update-status/' . $row['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <?php if (($row['metode_pengambilan'] ?? '') === 'diantar'): ?>
                                <input type="hidden" name="status" value="lunas">
                                <button type="submit" class="btn-primary">Kirim Maxim</button>
                            <?php else: ?>
                                <input type="hidden" name="status" value="lunas">
                                <button type="submit" class="btn-primary">Konfirmasi Siap Ambil</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card-panel" style="text-align:center; padding: 40px; color: var(--text-muted); background:#ffffff; border-radius:var(--radius-card);">
            Belum ada pesanan acara pada kategori ini.
        </div>
    <?php endif; ?>
</div>

<script>
    function toggleCard(id) {
        document.getElementById('card-acara-' + id).classList.toggle('expanded');
    }
</script>

<?= $this->endSection() ?>
