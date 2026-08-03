<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pembayaran QRIS — Pesan untuk Acara') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <script type="text/javascript" 
            src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="<?= esc($clientKey) ?>"></script>
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1069;
            --border-color: #E2E8F0;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --bg-page: #F8FAFC;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }

        body {
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--text-main);
            padding-bottom: 60px;
        }

        .container {
            max-width: 650px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(59, 25, 143, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 32px;
            text-align: center;
        }

        .qris-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F5F3FF;
            color: var(--primary);
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        .order-code {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            font-family: ui-monospace, "SF Mono", Consolas, monospace;
            margin-bottom: 8px;
        }

        .amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 24px;
        }

        .info-card {
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px;
            text-align: left;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        .btn-pay {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-pay:hover { background: var(--primary-hover); }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="qris-badge">
            <span class="material-symbols-outlined" style="font-size:18px;">qr_code_scanner</span> Pembayaran QRIS Midtrans
        </div>

        <div style="font-size:0.9rem; color:var(--text-muted);">Kode Pesanan Acara</div>
        <div class="order-code"><?= esc($booking['kode_booking']) ?></div>
        
        <div class="amount">Rp<?= number_format((float)$booking['total'], 0, ',', '.') ?></div>

        <div class="info-card">
            <div style="margin-bottom:6px;"><strong>Nama Pemesan:</strong> <?= esc($booking['nama_pemesan']) ?></div>
            <div style="margin-bottom:6px;"><strong>Metode:</strong> <?= esc(($booking['metode_pengambilan'] ?? 'diantar') === 'diantar' ? 'Diantar (via Maxim)' : 'Ambil Sendiri') ?></div>
            <div style="margin-bottom:6px;"><strong>Tanggal Acara:</strong> <?= date('d F Y', strtotime($booking['tanggal_acara'])) ?></div>
            <?php if (($booking['metode_pengambilan'] ?? 'diantar') === 'diantar'): ?>
                <div><strong>Alamat:</strong> <?= esc($booking['alamat']) ?></div>
            <?php endif; ?>
        </div>

        <button id="pay-button" class="btn-pay">
            Bayar Sekarang via QRIS <span class="material-symbols-outlined">arrow_forward</span>
        </button>

        <div style="margin-top: 20px; text-align: center;">
            <a href="<?= base_url('pesan-stand/form') ?>" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500;">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Form Pesanan
            </a>
        </div>
    </div>
</div>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    var snapToken = "<?= esc($snapToken) ?>";

    payButton.addEventListener('click', function () {
        if (!snapToken) {
            alert('Token pembayaran tidak valid.');
            return;
        }
        snap.pay(snapToken, {
            onSuccess: function (result) {
                window.location.href = "<?= base_url('pesan-stand/berhasil/' . esc($booking['kode_booking'])) ?>";
            },
            onPending: function (result) {
                window.location.href = "<?= base_url('pesan-stand/berhasil/' . esc($booking['kode_booking'])) ?>";
            },
            onError: function (result) {
                alert("Pembayaran gagal! Silakan coba lagi.");
            },
            onClose: function () {
                alert('Anda menutup jendela pembayaran.');
            }
        });
    });

    // Otomatis picu dialog Snap saat pertama kali buka
    window.addEventListener('load', function() {
        if (snapToken) {
            snap.pay(snapToken, {
                onSuccess: function (result) {
                    window.location.href = "<?= base_url('pesan-stand/berhasil/' . esc($booking['kode_booking'])) ?>";
                },
                onPending: function (result) {
                    console.log("Snap pending:", result);
                },
                onError: function (result) {
                    console.log("Snap payment error:", result);
                }
            });
        }
    });

    // Polling otomatis tiap 2 detik untuk deteksi pembayaran lunas di Simulator Midtrans
    setInterval(function() {
        fetch("<?= base_url('pesan-stand/cek-status/' . esc($booking['kode_booking'])) ?>")
            .then(response => response.json())
            .then(res => {
                if (res.ok && res.data && res.data.status === 'lunas') {
                    window.location.href = "<?= base_url('pesan-stand/berhasil/' . esc($booking['kode_booking'])) ?>";
                }
            })
            .catch(err => console.error("Error polling payment status:", err));
    }, 2000);
</script>
</body>
</html>
