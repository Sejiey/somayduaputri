<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>

<style>
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    .chart-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--primary);
    }

    .table-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .data-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        border-bottom: 1.5px solid var(--border-color);
    }

    .data-table td {
        padding: 14px 16px;
        font-size: 0.85rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .date-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .date-input {
        padding: 8px 14px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.85rem;
        font-family: inherit;
        outline: none;
        background: #ffffff;
    }

    @media (max-width: 992px) {
        .charts-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Laporan Keuangan</h1>
        <p>Ringkasan pemasukan, pengeluaran, dan laba bersih usaha Anda.</p>
    </div>

    <div class="date-filter-form">
        <form action="<?= base_url('admin/laporan') ?>" method="get" style="display:flex; gap:8px; align-items:center;">
            <input type="date" name="dari" value="<?= esc($dari) ?>" class="date-input">
            <span style="font-size:0.85rem; color:var(--text-muted);">-</span>
            <input type="date" name="sampai" value="<?= esc($sampai) ?>" class="date-input">
            <button type="submit" class="btn-secondary" style="padding:8px 14px;">Filter</button>
        </form>

        <a href="<?= base_url('admin/laporan/export?dari=' . $dari . '&sampai=' . $sampai) ?>" class="btn-primary">
            <span class="material-symbols-outlined">download</span> Export Laporan
        </a>
    </div>
</div>

<!-- STAT CARDS (4 CARDS) -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Pendapatan</span>
            <div class="stat-icon green">
                <span class="material-symbols-outlined">payments</span>
            </div>
        </div>
        <div class="stat-value">Rp<?= number_format($total_pendapatan, 0, ',', '.') ?></div>
        <div class="stat-subtext positive">+15% dari periode lalu</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Pengeluaran</span>
            <div class="stat-icon pink">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
        </div>
        <div class="stat-value">Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
        <div class="stat-subtext highlight">-5% dari periode lalu</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Laba Bersih</span>
            <div class="stat-icon green">
                <span class="material-symbols-outlined">account_balance_wallet</span>
            </div>
        </div>
        <div class="stat-value" style="color:#10B981;">Rp<?= number_format($laba_bersih, 0, ',', '.') ?></div>
        <div class="stat-subtext positive">+20% dari periode lalu</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Transaksi</span>
            <div class="stat-icon blue">
                <span class="material-symbols-outlined">shopping_cart</span>
            </div>
        </div>
        <div class="stat-value"><?= $total_transaksi ?></div>
        <div class="stat-subtext positive">+18% dari periode lalu</div>
    </div>
</div>

<!-- CHARTS GRID -->
<div class="charts-grid">
    <!-- LEFT: GRAFIK PENDAPATAN -->
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">Grafik Pendapatan</div>
            <span style="font-size:0.8rem; font-weight:600; color:var(--text-muted); background:var(--primary-soft); padding:4px 12px; border-radius:8px;">7 Hari Terakhir</span>
        </div>
        <div style="height: 250px;">
            <canvas id="lineChartRevenue"></canvas>
        </div>
    </div>

    <!-- RIGHT: PERBANDINGAN KATEGORI -->
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">Perbandingan Kategori</div>
        </div>
        <div style="height: 200px; display:flex; align-items:center; justify-content:center;">
            <canvas id="donutChartCategory"></canvas>
        </div>
        <div style="margin-top:16px; font-size:0.8rem;">
            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span style="color:#3b198f; font-weight:600;">● Pesan Antar</span>
                <span style="font-weight:700;">Rp<?= number_format($pendapatan_antar, 0, ',', '.') ?></span>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#EC4899; font-weight:600;">● Pesan Acara</span>
                <span style="font-weight:700;">Rp<?= number_format($pendapatan_acara, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
</div>

<!-- RINCIAN KEUANGAN TABLE -->
<div class="table-card">
    <div class="chart-title" style="margin-bottom:16px;">Rincian Keuangan</div>

    <!-- TABS FILTER RINCIAN -->
    <div class="custom-tabs">
        <a href="<?= base_url('admin/laporan?tab=semua&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn <?= $current_tab === 'semua' ? 'active' : '' ?>">Semua</a>
        <a href="<?= base_url('admin/laporan?tab=pesan_antar&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn <?= $current_tab === 'pesan_antar' ? 'active' : '' ?>">Pesan Antar</a>
        <a href="<?= base_url('admin/laporan?tab=pesan_acara&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn <?= $current_tab === 'pesan_acara' ? 'active' : '' ?>">Pesan Acara</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Pendapatan</th>
                <th>Pengeluaran</th>
                <th>Laba</th>
                <th>Transaksi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rincian)): ?>
                <?php foreach ($rincian as $row): ?>
                    <tr>
                        <td style="font-weight:600;"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <span class="badge-status <?= $row['kategori'] === 'Pesan Antar' ? 'dikonfirmasi' : 'akan_datang' ?>">
                                <?= esc($row['kategori']) ?>
                            </span>
                        </td>
                        <td style="font-weight:700; color:var(--primary);">Rp<?= number_format($row['pendapatan'], 0, ',', '.') ?></td>
                        <td>Rp<?= number_format($row['pengeluaran'], 0, ',', '.') ?></td>
                        <td style="font-weight:700; color:#10B981;">Rp<?= number_format($row['laba'], 0, ',', '.') ?></td>
                        <td><?= $row['transaksi'] ?> pesanan</td>
                        <td><span class="material-symbols-outlined" style="color:var(--text-muted); cursor:pointer;">chevron_right</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">Tidak ada rincian data transaksi untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- SCRIPT CHARTS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Line Chart Revenue
        const ctxLine = document.getElementById('lineChartRevenue').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_dates) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode($chart_data) ?>,
                    borderColor: '#3b198f',
                    backgroundColor: 'rgba(59, 25, 143, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#EEECF6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Donut Chart Category
        const ctxDonut = document.getElementById('donutChartCategory').getContext('2d');
        const revAntar = <?= (float)$pendapatan_antar ?>;
        const revAcara = <?= (float)$pendapatan_acara ?>;
        const totalRev = revAntar + revAcara;

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Pesan Antar', 'Pesan Acara'],
                datasets: [{
                    data: [totalRev > 0 ? revAntar : 1, totalRev > 0 ? revAcara : 0],
                    backgroundColor: ['#3b198f', '#EC4899'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { legend: { display: false } }
            }
        });
    });
</script>

<?= $this->endSection() ?>
