<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    /* MAIN ADMIN PANEL CARD CONTAINER (Presisi Gambar Kanan) */
    .admin-panel-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #ECE7FE;
        box-shadow: 0 10px 40px rgba(59, 25, 143, 0.05);
        padding: 32px 36px;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* PAGE HEADER */
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .panel-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2D1A56;
        margin: 0 0 4px 0;
    }

    .panel-header p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .panel-date-badge {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* TOP STATS CARDS GRID (3 Cards) */
    .summary-tabs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .summary-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1.5px solid var(--border-color);
        text-decoration: none;
        color: var(--text-dark);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 96px;
        transition: all 0.2s ease;
    }

    .summary-card:hover {
        border-color: #CBD5E1;
    }

    .summary-card.active {
        background: #F4EFFF;
        border-color: #D4C4FC;
    }

    .summary-card .card-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .summary-card.active .card-title {
        color: #4A1E9E;
        font-weight: 700;
    }

    .summary-card .card-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-top: 6px;
    }

    .summary-card.active .card-value {
        color: #4A1E9E;
    }

    /* ACCORDION ORDER CARDS LIST */
    .order-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        margin-bottom: 14px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .order-card-header {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        background: #ffffff;
        user-select: none;
    }

    .order-card-header:hover {
        background: #FAF8FF;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .bullet-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #1E1B26;
    }

    .customer-title {
        font-weight: 800;
        font-size: 1rem;
        color: #1E1B26;
    }

    .service-method {
        font-weight: 700;
        font-size: 0.9rem;
        color: #4A1E9E;
    }

    .badge-lunas {
        background: #DCFCE7;
        color: #15803D;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .badge-baru {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #6B7280;
        font-size: 0.82rem;
        font-weight: 500;
    }

    .order-card-body {
        padding: 20px 24px;
        background: #FAF8FF;
        border-top: 1px solid #EFE9FE;
        display: none;
    }

    .order-card.expanded .order-card-body {
        display: block;
    }

    .order-card.expanded .toggle-icon {
        transform: rotate(180deg);
    }

    /* INNER CONTAINER FOR EXPANDED BODY */
    .catering-inner-box {
        background: #FAF8FF;
        border-radius: 14px;
    }

    .catering-content-grid {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 28px;
        align-items: flex-start;
    }

    .section-subhead {
        font-size: 0.88rem;
        font-weight: 800;
        color: #2D1A56;
        margin-bottom: 14px;
    }

    .items-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .item-name {
        color: #1E1B26;
        font-weight: 600;
    }

    .item-portion {
        color: #6B7280;
        font-weight: 500;
        text-align: center;
    }

    .item-price {
        color: #2D1A56;
        font-weight: 700;
        text-align: right;
    }

    /* CALCULATION & ACTION BOX RIGHT */
    .calc-side-box {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .calc-line {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #6B7280;
    }

    .calc-line.total-line {
        font-size: 1rem;
        font-weight: 800;
        color: #2D1A56;
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px dashed #D4C4FC;
    }

    .btn-maxim-action {
        background: #4A1E9E;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.2s ease;
        margin-top: 14px;
        width: 100%;
        text-decoration: none;
    }

    .btn-maxim-action:hover {
        background: #3b198f;
    }

    @media (max-width: 900px) {
        .admin-panel-card { padding: 20px 16px; }
        .summary-tabs-grid { grid-template-columns: 1fr; }
        .catering-content-grid { grid-template-columns: 1fr; gap: 18px; }
    }
</style>

<!-- MAIN OUTER WHITE CARD CONTAINER -->
<div class="admin-panel-card">
    
    <!-- PAGE HEADER -->
    <div class="panel-header">
        <div>
            <h1>Pesan Acara</h1>
            <p>Daftar pesanan acara (catering).</p>
        </div>
        <div class="panel-date-badge">
            <span class="material-symbols-outlined" style="font-size:18px; color:#4A1E9E;">calendar_today</span>
            <?= date('d M Y') ?>
        </div>
    </div>

    <!-- SUMMARY CARDS TAB FILTER -->
    <div class="summary-tabs-grid">
        <a href="<?= base_url('admin/pesan-acara?tab=semua') ?>" class="summary-card <?= $current_tab === 'semua' ? 'active' : '' ?>">
            <div class="card-title">Semua</div>
            <div class="card-value"><?= $count_semua ?></div>
        </a>
        <a href="<?= base_url('admin/pesan-acara?tab=ambil_sendiri') ?>" class="summary-card <?= $current_tab === 'ambil_sendiri' ? 'active' : '' ?>">
            <div class="card-title">Diambil Sendiri</div>
            <div class="card-value"><?= $count_ambil ?></div>
        </a>
        <a href="<?= base_url('admin/pesan-acara?tab=maxim') ?>" class="summary-card <?= $current_tab === 'maxim' ? 'active' : '' ?>">
            <div class="card-title">Diantar (Maxim)</div>
            <div class="card-value"><?= $count_maxim ?></div>
        </a>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#DCFCE7; color:#15803D; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-weight:700; font-size:0.85rem;">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background:#FEE2E2; color:#B91C1C; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-weight:700; font-size:0.85rem;">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- LIST PESANAN ACARA -->
    <div>
        <?php if (!empty($pesanan)): ?>
            <?php foreach ($pesanan as $index => $row): ?>
                <?php 
                    $isDiantar = ($row['metode_pengambilan'] ?? 'diantar') === 'diantar';
                    $metodeText = $isDiantar ? 'Diantar (Maxim)' : 'Diambil Sendiri';
                    $statusRaw = strtolower($row['status_pembayaran'] ?? 'diproses');
                    $isNew = ($statusRaw === 'diproses' || $statusRaw === 'pending');
                ?>
                <div class="order-card <?= $index === 0 ? 'expanded' : '' ?>" id="card-acara-<?= $row['id'] ?>">
                    <div class="order-card-header" onclick="toggleCard(<?= $row['id'] ?>)">
                        <div class="header-left">
                            <div class="bullet-dot"></div>
                            <span class="customer-title"><?= esc(strtolower($row['nama_pemesan'] ?? 'pemesan')) ?></span>
                            <span style="color:#6B7280; font-weight:500;">|</span>
                            <span class="service-method"><?= $metodeText ?></span>
                            <?php if ($isNew): ?>
                                <span class="badge-baru">Baru</span>
                            <?php else: ?>
                                <span class="badge-lunas">Lunas</span>
                            <?php endif; ?>
                        </div>

                        <div class="header-right">
                            <span><?= !empty($row['tanggal_acara']) ? date('d M Y, H:i', strtotime($row['tanggal_acara'])) : date('d M Y, H:i', strtotime($row['created_at'])) ?></span>
                            <span class="material-symbols-outlined toggle-icon" style="transition: transform 0.2s;">expand_more</span>
                        </div>
                    </div>

                    <div class="order-card-body">
                        <div class="section-subhead">Ringkasan Pesanan (Catering)</div>

                        <div class="catering-content-grid">
                            <!-- ITEMS LEFT TABLE -->
                        <table style="width: 100%; border-collapse: collapse;">
                            <tbody>
                                <?php if (!empty($row['items'])): ?>
                                    <?php foreach ($row['items'] as $item): ?>
                                        <tr>
                                            <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 600; color: #1E1B26;">• <?= esc($item['produk_nama'] ?? 'Menu') ?> <?= !empty($item['nama_varian']) ? '('.esc($item['nama_varian']).')' : '' ?></td>
                                            <td style="padding: 6px 16px; font-size: 0.85rem; color: #6B7280; text-align: center; white-space: nowrap; width: 100px;"><?= (int)$item['jumlah'] ?> porsi</td>
                                            <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 700; color: #2D1A56; text-align: right; white-space: nowrap; width: 110px;">Rp<?= number_format($item['subtotal_item'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 600; color: #1E1B26;">• Paket Siomay Catering Porsi Besar</td>
                                        <td style="padding: 6px 16px; font-size: 0.85rem; color: #6B7280; text-align: center; white-space: nowrap; width: 100px;">1 porsi</td>
                                        <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 700; color: #2D1A56; text-align: right; white-space: nowrap; width: 110px;">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                            <!-- CALC & ACTION RIGHT -->
                            <div class="calc-side-box">
                                <div class="calc-line">
                                    <span>Subtotal</span>
                                    <span>Rp<?= number_format($row['subtotal'] ?? $row['total'], 0, ',', '.') ?></span>
                                </div>
                                <div class="calc-line">
                                    <span>Fee Antar (Maxim)</span>
                                    <span>-</span>
                                </div>
                                <div class="calc-line total-line">
                                    <span>Total</span>
                                    <span>Rp<?= number_format($row['total'], 0, ',', '.') ?></span>
                                </div>

                                <div>
                                    <?php if ($isDiantar): ?>
                                        <form action="<?= base_url('admin/pesan-acara/kirim-maxim/' . $row['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn-maxim-action">
                                                Kirim Maxim
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= base_url('admin/pesan-acara/update-status/' . $row['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="lunas">
                                            <button type="submit" class="btn-maxim-action" style="background:#10B981;">
                                                Konfirmasi Siap Ambil
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center; padding:36px; color:var(--text-muted); font-size:0.9rem;">
                Belum ada pesanan acara pada kategori ini.
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    function toggleCard(id) {
        document.getElementById('card-acara-' + id).classList.toggle('expanded');
    }
</script>

<?= $this->endSection() ?>
