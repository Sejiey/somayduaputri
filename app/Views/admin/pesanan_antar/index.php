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

    /* SUMMARY CARDS 4 GRID */
    .summary-cards-4grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .summary-card-antar {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1.5px solid var(--border-color);
        text-decoration: none;
        color: var(--text-dark);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 98px;
        transition: all 0.2s ease;
    }

    .summary-card-antar:hover {
        border-color: #CBD5E1;
    }

    .summary-card-antar.active {
        background: #F4EFFF;
        border-color: #D4C4FC;
    }

    .card-top-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .summary-card-antar.active .card-top-title {
        color: #4A1E9E;
        font-weight: 700;
    }

    .card-big-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-top: 6px;
    }

    .summary-card-antar.active .card-big-value {
        color: #4A1E9E;
    }

    .pill-tag {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .pill-fee { background: #E0F2FE; color: #0369A1; }
    .pill-maxim { background: #F1F5F9; color: #475569; }

    /* ACCORDION ORDER CARDS */
    .order-card-antar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        margin-bottom: 14px;
        overflow: hidden;
    }

    .order-card-header-antar {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        background: #ffffff;
        user-select: none;
    }

    .order-card-header-antar:hover {
        background: #FAF8FF;
    }

    .header-left-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .bullet-dot-antar {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #1E1B26;
    }

    .customer-name-bold {
        font-weight: 800;
        font-size: 1rem;
        color: #1E1B26;
    }

    .location-text {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1E1B26;
    }

    .method-text {
        font-weight: 700;
        font-size: 0.9rem;
        color: #4A1E9E;
    }

    .badge-baru-red {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .badge-fee-green {
        background: #DCFCE7;
        color: #15803D;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .badge-maxim-yellow {
        background: #FEF3C7;
        color: #B45309;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .header-right-time {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #6B7280;
        font-size: 0.82rem;
        font-weight: 500;
    }

    .order-card-body-antar {
        padding: 20px 24px;
        background: #FAF8FF;
        border-top: 1px solid #EFE9FE;
        display: none;
    }

    .order-card-antar.expanded .order-card-body-antar {
        display: block;
    }

    .order-card-antar.expanded .toggle-icon {
        transform: rotate(180deg);
    }

    /* RINCIAN PESANAN LAYOUT */
    .order-content-grid {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 28px;
        align-items: flex-start;
    }

    .section-subhead-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: #2D1A56;
        margin-bottom: 14px;
    }

    .items-list-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .item-row-antar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .item-name-txt {
        color: #1E1B26;
        font-weight: 600;
    }

    .item-qty-txt {
        color: #6B7280;
        font-weight: 500;
    }

    .item-price-txt {
        color: #2D1A56;
        font-weight: 700;
    }

    .calc-box-right {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .calc-row-line {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #6B7280;
    }

    .calc-row-line.total-bold-line {
        font-size: 1rem;
        font-weight: 800;
        color: #2D1A56;
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px dashed #D4C4FC;
    }

    .btn-action-purple {
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

    .btn-action-purple:hover {
        background: #3b198f;
    }

    @media (max-width: 1024px) {
        .admin-panel-card { padding: 20px 16px; }
        .summary-cards-4grid { grid-template-columns: repeat(2, 1fr); }
        .order-content-grid { grid-template-columns: 1fr; gap: 18px; }
    }
    @media (max-width: 640px) {
        .summary-cards-4grid { grid-template-columns: 1fr; }
    }
</style>

<!-- MAIN OUTER WHITE CARD CONTAINER -->
<div class="admin-panel-card">

    <!-- PAGE HEADER -->
    <div class="panel-header">
        <div>
            <h1>Pesan Antar <small style="font-size:0.85rem; font-weight:500; color:var(--text-muted);">(Hari Ini)</small></h1>
            <p>Daftar semua pesanan antar untuk hari ini.</p>
        </div>
        <div class="panel-date-badge">
            <span class="material-symbols-outlined" style="font-size:18px; color:#4A1E9E;">calendar_today</span>
            <?= date('d M Y') ?>
        </div>
    </div>

    <!-- SUMMARY CARDS 4 GRID (Presisi Foto Screenshot Kanan) -->
    <div class="summary-cards-4grid">
        <a href="<?= base_url('admin/pesan-antar?tab=semua') ?>" class="summary-card-antar <?= $current_tab === 'semua' ? 'active' : '' ?>">
            <div class="card-top-title">Semua</div>
            <div class="card-big-value"><?= $count_semua ?></div>
        </a>

        <a href="<?= base_url('admin/pesan-antar?tab=ambil_sendiri') ?>" class="summary-card-antar <?= $current_tab === 'ambil_sendiri' ? 'active' : '' ?>">
            <div class="card-top-title">Ambil Sendiri</div>
            <div class="card-big-value"><?= $count_ambil ?></div>
        </a>

        <a href="<?= base_url('admin/pesan-antar?tab=undata') ?>" class="summary-card-antar <?= $current_tab === 'undata' ? 'active' : '' ?>">
            <div class="card-top-title">
                <span>Diantar (Undata)</span>
                <span class="pill-tag pill-fee">Fee 5rb</span>
            </div>
            <div class="card-big-value"><?= $count_undata ?></div>
        </a>

        <a href="<?= base_url('admin/pesan-antar?tab=maxim') ?>" class="summary-card-antar <?= $current_tab === 'maxim' ? 'active' : '' ?>">
            <div class="card-top-title">
                <span>Diantar (Luar Undata)</span>
                <span class="pill-tag pill-maxim">Maxim</span>
            </div>
            <div class="card-big-value"><?= $count_maxim ?></div>
        </a>
    </div>

    <!-- FLASH NOTIFICATION -->
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

    <!-- LIST PESANAN ANTAR -->
    <div>
        <?php if (!empty($pesanan)): ?>
            <?php foreach ($pesanan as $index => $row): ?>
                <?php 
                    $isDiantar = ($row['metode'] ?? '') === 'diantar';
                    $isUndata  = ($row['lokasi'] ?? '') === 'Undata';
                    $statusRaw = strtolower($row['status'] ?? 'diproses');
                    $isNew     = ($statusRaw === 'diproses' || $statusRaw === 'pending');
                    $lokasiRuangan = esc($row['ruangan'] ?? $row['alamat'] ?? 'Kantin Undata');
                ?>
                <div class="order-card-antar <?= $index === 0 ? 'expanded' : '' ?>" id="card-antar-<?= $row['id'] ?>">
                    <div class="order-card-header-antar" onclick="toggleCard(<?= $row['id'] ?>)">
                        <div class="header-left-group">
                            <div class="bullet-dot-antar"></div>
                            <span class="customer-name-bold"><?= esc(strtolower($row['nama_pembeli'] ?? 'pemesan')) ?></span>
                            <span style="color:#6B7280; font-weight:500;">|</span>
                            <span class="method-text"><?= $isDiantar ? 'Diantar' : 'Ambil Sendiri' ?></span>

                            <?php if ($isNew): ?>
                                <span class="badge-baru-red">Baru</span>
                            <?php elseif ($isDiantar && $isUndata): ?>
                                <span class="badge-fee-green">Fee 5rb</span>
                            <?php elseif ($isDiantar && !$isUndata): ?>
                                <span class="badge-maxim-yellow">Maxim</span>
                            <?php else: ?>
                                <span class="badge-fee-green">Lunas</span>
                            <?php endif; ?>
                        </div>

                        <div class="header-right-time">
                            <span><?= date('H:i', strtotime($row['created_at'])) ?> WIB</span>
                            <span class="material-symbols-outlined toggle-icon" style="transition: transform 0.2s;">expand_more</span>
                        </div>
                    </div>

                    <div class="order-card-body-antar">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
                            <div class="section-subhead-title" style="margin-bottom:0;">Ringkasan Pesanan</div>
                            <div style="font-size: 0.82rem; font-weight: 700; color: #4A1E9E; background: #F3E8FF; padding: 4px 12px; border-radius: 8px;">
                                📍 Ruangan / Lokasi: <?= $lokasiRuangan ?>
                            </div>
                        </div>

                        <div class="order-content-grid">
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
                                        <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 600; color: #1E1B26;">• Menu Siomay Antar</td>
                                        <td style="padding: 6px 16px; font-size: 0.85rem; color: #6B7280; text-align: center; white-space: nowrap; width: 100px;">1 porsi</td>
                                        <td style="padding: 6px 0; font-size: 0.85rem; font-weight: 700; color: #2D1A56; text-align: right; white-space: nowrap; width: 110px;">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                            <div class="calc-box-right">
                                <div class="calc-row-line">
                                    <span>Subtotal</span>
                                    <span>Rp<?= number_format($row['subtotal'] ?? $row['total'], 0, ',', '.') ?></span>
                                </div>
                                <div class="calc-row-line">
                                    <span>Fee Antar</span>
                                    <span><?= ($row['ongkir'] ?? 0) > 0 ? 'Rp' . number_format($row['ongkir'], 0, ',', '.') : '-' ?></span>
                                </div>
                                <div class="calc-row-line total-bold-line">
                                    <span>Total</span>
                                    <span>Rp<?= number_format($row['total'], 0, ',', '.') ?></span>
                                </div>

                                <div>
                                    <?php if ($isDiantar && !$isUndata && $row['status'] !== 'diantar'): ?>
                                        <form action="<?= base_url('admin/pesan-antar/kirim-maxim/' . $row['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn-action-purple">
                                                Kirim Maxim
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= base_url('admin/pesan-antar/update-status/' . $row['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <?php if ($row['status'] === 'diproses'): ?>
                                                <input type="hidden" name="status" value="siap_dijemput">
                                                <button type="submit" class="btn-action-purple">
                                                    Siap Dijemput
                                                </button>
                                            <?php else: ?>
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="btn-action-purple" style="background:#10B981;">
                                                    Tandai Selesai
                                                </button>
                                            <?php endif; ?>
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
                Belum ada pesanan antar pada kategori ini.
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    function toggleCard(id) {
        document.getElementById('card-antar-' + id).classList.toggle('expanded');
    }
</script>

<?= $this->endSection() ?>
