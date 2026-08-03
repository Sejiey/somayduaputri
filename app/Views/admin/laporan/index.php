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

    /* HEADER ROW */
    .panel-header-laporan {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .panel-header-laporan h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2D1A56;
        margin: 0 0 4px 0;
    }

    .panel-header-laporan p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .date-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .date-input {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.82rem;
        font-family: inherit;
        outline: none;
        background: #ffffff;
        cursor: pointer;
    }

    .btn-catat-pasar {
        background: #10B981;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    .btn-catat-pasar:hover { background: #059669; }

    .btn-filter-action {
        background: #4A1E9E;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.82rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .btn-filter-action:hover { background: #3b198f; }

    .btn-export-purple {
        background: #4A1E9E;
        color: #ffffff;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.82rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-export-purple:hover { background: #3b198f; }

    /* STAT CARDS 4 GRID */
    .laporan-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card-clean {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
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
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 4px 0 2px 0;
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
    .icon-green { background: #DCFCE7; color: #166534; }
    .icon-red { background: #FEE2E2; color: #DC2626; } /* KOREKSI WARNA MERAH UNTUK PENGELUARAN */
    .icon-wallet { background: #D1FAE5; color: #047857; }
    .icon-blue { background: #E0F2FE; color: #0284C7; }

    /* CHARTS GRID */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(59, 25, 143, 0.03);
        border: 1px solid var(--border-color);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .chart-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #2D1A56;
    }

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
        margin-top: 12px;
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

    /* EASY EXPENSE MODAL FOR DAD */
    .modal-expense-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-expense-overlay.active { display: flex; }
    .modal-expense-box {
        background: #ffffff; border-radius: 20px; width: 90%; max-width: 440px; padding: 28px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    }

    .expense-input-big {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #DC2626;
        border-radius: 12px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #DC2626;
        outline: none;
        font-family: inherit;
        background: #FEF2F2;
    }

    @media (max-width: 992px) {
        .admin-panel-card { padding: 20px 16px; }
        .laporan-stats-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .laporan-stats-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- MAIN OUTER PANEL CARD CONTAINER -->
<div class="admin-panel-card">

    <!-- PAGE HEADER -->
    <div class="panel-header-laporan">
        <div>
            <h1>Laporan Keuangan</h1>
            <p>Ringkasan pemasukan omzet, belanja pengeluaran pasar, dan laba bersih usaha.</p>
        </div>

        <div class="date-filter-form">
            <button type="button" onclick="openExpenseModal()" class="btn-catat-pasar" title="Klik untuk mencatat uang belanja cash di pasar">
                <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span> Catat Belanja Pasar (Cash)
            </button>

            <!-- FORM FILTER TANGGAL PERIODE (Otomatis Filter Saat Tanggal Dipilih) -->
            <form action="<?= base_url('admin/laporan') ?>" method="get" id="dateFilterForm" style="display:flex; gap:6px; align-items:center;">
                <input type="date" name="dari" value="<?= esc($dari) ?>" class="date-input" onchange="document.getElementById('dateFilterForm').submit()" title="Tanggal Awal">
                <span style="font-size:0.8rem; color:var(--text-muted);">-</span>
                <input type="date" name="sampai" value="<?= esc($sampai) ?>" class="date-input" onchange="document.getElementById('dateFilterForm').submit()" title="Tanggal Akhir">
            </form>

            <a href="<?= base_url('admin/laporan/export?dari=' . $dari . '&sampai=' . $sampai) ?>" class="btn-export-purple">
                <span class="material-symbols-outlined" style="font-size:16px;">download</span> Export
            </a>
        </div>
    </div>

    <!-- STAT CARDS (4 CARDS) -->
    <div class="laporan-stats-grid">
        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value" id="displayPendapatan">Rp<?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                <div style="font-size:0.72rem; color:#10B981; font-weight:600;">Omzet Penjualan</div>
            </div>
            <div class="stat-icon-circle icon-green">
                <span class="material-symbols-outlined" style="font-size:20px;">payments</span>
            </div>
        </div>

        <!-- TOTAL PENGELUARAN (KOREKSI WARNA MERAH) -->
        <div class="stat-card-clean" style="border-color:#FCA5A5;">
            <div>
                <div class="stat-title">Total Pengeluaran</div>
                <div class="stat-value" id="displayPengeluaran" style="color:#DC2626;">Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
                <div style="font-size:0.72rem; color:#DC2626; font-weight:600;">Belanja Pasar & Operasional</div>
            </div>
            <div class="stat-icon-circle icon-red">
                <span class="material-symbols-outlined" style="font-size:20px;">receipt_long</span>
            </div>
        </div>

        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Laba Bersih</div>
                <div class="stat-value" id="displayLaba" style="color:#10B981;">Rp<?= number_format($laba_bersih, 0, ',', '.') ?></div>
                <div style="font-size:0.72rem; color:#047857; font-weight:600;">Uang Bersih Diterima</div>
            </div>
            <div class="stat-icon-circle icon-wallet">
                <span class="material-symbols-outlined" style="font-size:20px;">account_balance_wallet</span>
            </div>
        </div>

        <div class="stat-card-clean">
            <div>
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value"><?= (int)$total_transaksi ?></div>
                <div style="font-size:0.72rem; color:var(--text-muted); font-weight:500;">Pesanan Berhasil</div>
            </div>
            <div class="stat-icon-circle icon-blue">
                <span class="material-symbols-outlined" style="font-size:20px;">shopping_cart</span>
            </div>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik Omzet Penjualan</div>
                <span style="font-size:0.78rem; font-weight:700; color:#4A1E9E; background:#F4EFFF; padding:4px 12px; border-radius:8px;">Periode <?= date('d M Y', strtotime($dari)) ?> - <?= date('d M Y', strtotime($sampai)) ?></span>
            </div>
            <div style="height: 220px;">
                <canvas id="lineChartRevenue"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Perbandingan Kategori</div>
            </div>
            <div style="height: 160px; display:flex; align-items:center; justify-content:center;">
                <canvas id="donutChartCategory"></canvas>
            </div>
            <div style="margin-top:14px; font-size:0.8rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span style="color:#4A1E9E; font-weight:700;">● Pesan Antar</span>
                    <span style="font-weight:700;">Rp<?= number_format($pendapatan_antar, 0, ',', '.') ?></span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#DC2626; font-weight:700;">● Pesan Acara</span>
                    <span style="font-weight:700;">Rp<?= number_format($pendapatan_acara, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- DATA TABLE CONTAINER -->
    <div class="table-container-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <div class="chart-title">Rincian Keuangan & Pengeluaran Pasar</div>
        </div>

        <div class="custom-tabs-clean" style="display:flex; gap:8px; margin-bottom:16px;">
            <a href="<?= base_url('admin/laporan?tab=semua&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn-clean <?= $current_tab === 'semua' ? 'active' : '' ?>" style="padding:6px 14px; text-decoration:none; font-size:0.8rem; font-weight:700; border-radius:8px; background:<?= $current_tab === 'semua' ? '#4A1E9E' : '#F1F5F9' ?>; color:<?= $current_tab === 'semua' ? '#fff' : '#475569' ?>;">Semua</a>
            <a href="<?= base_url('admin/laporan?tab=pesan_antar&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn-clean <?= $current_tab === 'pesan_antar' ? 'active' : '' ?>" style="padding:6px 14px; text-decoration:none; font-size:0.8rem; font-weight:700; border-radius:8px; background:<?= $current_tab === 'pesan_antar' ? '#4A1E9E' : '#F1F5F9' ?>; color:<?= $current_tab === 'pesan_antar' ? '#fff' : '#475569' ?>;">Pesan Antar</a>
            <a href="<?= base_url('admin/laporan?tab=pesan_acara&dari='.$dari.'&sampai='.$sampai) ?>" class="tab-btn-clean <?= $current_tab === 'pesan_acara' ? 'active' : '' ?>" style="padding:6px 14px; text-decoration:none; font-size:0.8rem; font-weight:700; border-radius:8px; background:<?= $current_tab === 'pesan_acara' ? '#4A1E9E' : '#F1F5F9' ?>; color:<?= $current_tab === 'pesan_acara' ? '#fff' : '#475569' ?>;">Pesan Acara</a>
        </div>

        <table class="clean-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori / Catatan</th>
                    <th>Pendapatan</th>
                    <th>Pengeluaran</th>
                    <th>Laba Bersih</th>
                    <th>Transaksi / Info</th>
                </tr>
            </thead>
            <tbody id="laporanTableBody">
                <?php if (!empty($rincian)): ?>
                    <?php foreach ($rincian as $row): ?>
                        <tr>
                            <td style="font-weight:600;"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                            <td>
                                <span class="badge-status <?= $row['kategori'] === 'Pesan Antar' ? 'dikonfirmasi' : 'akan_datang' ?>" style="font-size:0.75rem; padding:3px 10px; border-radius:10px;">
                                    <?= esc($row['kategori']) ?>
                                </span>
                            </td>
                            <td style="font-weight:700; color:#4A1E9E;">Rp<?= number_format($row['pendapatan'], 0, ',', '.') ?></td>
                            <td style="color:#DC2626;">Rp<?= number_format($row['pengeluaran'], 0, ',', '.') ?></td>
                            <td style="font-weight:700; color:#10B981;">Rp<?= number_format($row['laba'], 0, ',', '.') ?></td>
                            <td style="color:var(--text-muted);"><?= $row['transaksi'] ?> pesanan</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="emptyRow">
                        <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">Belum ada rincian data transaksi untuk periode tanggal yang dipilih.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL SIMPEL PAPA CATAT BELANJA PASAR (CASH) -->
<div id="expenseModal" class="modal-expense-overlay">
    <div class="modal-expense-box">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="color:#2D1A56; margin:0; font-weight:800; font-size:1.15rem;">🛒 Catat Belanja Pasar (Cash)</h3>
            <span onclick="closeExpenseModal()" style="cursor:pointer; color:#94A3B8; font-weight:700; font-size:1.2rem;">&times;</span>
        </div>
        <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:20px;">Masukkan jumlah uang cash yang Papa keluarkan di pasar hari ini.</p>

        <form id="expenseForm" onsubmit="saveCashExpense(event)">
            <div style="margin-bottom:16px;">
                <label style="display:block; font-weight:700; font-size:0.85rem; color:#2D1A56; margin-bottom:6px;">Uang Belanja (Rp)</label>
                <input type="number" id="cashNominal" class="expense-input-big" required placeholder="Contoh: 300000" min="500">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-weight:700; font-size:0.85rem; color:#2D1A56; margin-bottom:6px;">Jenis Belanja / Catatan</label>
                <select id="cashKategori" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:0.88rem; font-family:inherit; outline:none;" required>
                    <option value="Belanja Bahan Pasar (Ikan, Daging, Telur, dll)">Belanja Bahan Pasar (Ikan, Daging, Telur, dll)</option>
                    <option value="Gas LPG / Es Batu / Listrik">Gas LPG / Es Batu / Listrik</option>
                    <option value="Plastik & Mika Packaging">Plastik & Mika Packaging</option>
                    <option value="Pengeluaran Cash Lainnya">Pengeluaran Cash Lainnya</option>
                </select>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-weight:700; font-size:0.85rem; color:#2D1A56; margin-bottom:6px;">Tanggal Belanja</label>
                <input type="date" id="cashTanggal" value="<?= date('Y-m-d') ?>" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:0.88rem; font-family:inherit; outline:none;">
            </div>

            <div style="display:flex; gap:10px;">
                <button type="button" onclick="closeExpenseModal()" style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--border-color); background:#fff; font-weight:700; font-size:0.88rem; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-catat-pasar" style="flex:1.5; justify-content:center; padding:12px; font-size:0.9rem;">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT CHARTS & EASY CASH LOGIC FOR DAD -->
<script>
    var basePendapatan = <?= (float)$total_pendapatan ?>;
    var basePengeluaran = <?= (float)$total_pengeluaran ?>;

    function openExpenseModal() {
        document.getElementById('expenseModal').classList.add('active');
    }
    function closeExpenseModal() {
        document.getElementById('expenseModal').classList.remove('active');
    }

    function formatRupiah(num) {
        return 'Rp' + num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function loadSavedExpenses() {
        var saved = localStorage.getItem('siomay_cash_expenses');
        if (!saved) return;
        var list = JSON.parse(saved);
        var totalTambahExpense = 0;
        var tbody = document.getElementById('laporanTableBody');

        list.forEach(function(item) {
            totalTambahExpense += parseFloat(item.nominal);
            
            var tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:600;">${item.tanggal_formatted}</td>
                <td>
                    <span style="font-size:0.75rem; padding:3px 10px; border-radius:10px; background:#FEE2E2; color:#DC2626; font-weight:700;">
                        ${item.kategori}
                    </span>
                </td>
                <td style="font-weight:700; color:#4A1E9E;">Rp0</td>
                <td style="color:#DC2626; font-weight:700;">${formatRupiah(parseFloat(item.nominal))}</td>
                <td style="font-weight:700; color:#DC2626;">-${formatRupiah(parseFloat(item.nominal))}</td>
                <td style="color:var(--text-muted); font-weight:600;">Pengeluaran Cash Pasar</td>
            `;
            var emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();
            tbody.insertBefore(tr, tbody.firstChild);
        });

        var newTotalPengeluaran = basePengeluaran + totalTambahExpense;
        var newLabaBersih = basePendapatan - newTotalPengeluaran;

        document.getElementById('displayPengeluaran').innerText = formatRupiah(newTotalPengeluaran);
        var labaEl = document.getElementById('displayLaba');
        labaEl.innerText = formatRupiah(newLabaBersih);
        labaEl.style.color = newLabaBersih >= 0 ? '#10B981' : '#DC2626';
    }

    function saveCashExpense(e) {
        e.preventDefault();
        var nominal = parseFloat(document.getElementById('cashNominal').value);
        var kategori = document.getElementById('cashKategori').value;
        var tglVal = document.getElementById('cashTanggal').value;
        
        if (!nominal || nominal <= 0) return;

        var d = new Date(tglVal);
        var options = { day: '2-digit', month: 'short', year: 'numeric' };
        var tglFormatted = d.toLocaleDateString('id-ID', options);

        var newItem = {
            nominal: nominal,
            kategori: kategori,
            tanggal_formatted: tglFormatted,
            timestamp: new Date().getTime()
        };

        var saved = localStorage.getItem('siomay_cash_expenses');
        var list = saved ? JSON.parse(saved) : [];
        list.push(newItem);
        localStorage.setItem('siomay_cash_expenses', JSON.stringify(list));

        closeExpenseModal();
        alert('Berhasil mencatat pengeluaran belanja pasar sebesar ' + formatRupiah(nominal) + '!');
        location.reload();
    }

    document.addEventListener("DOMContentLoaded", function () {
        loadSavedExpenses();

        // Line Chart Revenue
        const ctxLine = document.getElementById('lineChartRevenue').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_dates) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode($chart_data) ?>,
                    borderColor: '#4A1E9E',
                    backgroundColor: 'rgba(74, 30, 158, 0.08)',
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
                    y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
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
                    backgroundColor: ['#4A1E9E', '#DC2626'],
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
