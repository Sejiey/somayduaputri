<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pembayaran') ?></title>

    <!-- Bootstrap 5 CSS (Tetap dipertahankan untuk layouting dasar) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts & Material Icons (Sesuai tema web) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b198f;       
            --primary-light: #F4EFFF; 
            --primary-hover: #2e1069;
            --text-main: #1D1A22;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --bg-page: #F4F0FF; 
            --accent-red: #E11D48;
            --t-fast: 200ms ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Background Pola Konsisten */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: top center;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        /* Hiasan Bulat Soft */
        .circle-1 { position: absolute; top: -30px; left: -30px; width: 140px; height: 140px; background: rgba(59, 25, 143, 0.05); border-radius: 50%; }
        .circle-2 { position: absolute; top: 60px; left: 240px; width: 50px; height: 50px; background: rgba(59, 25, 143, 0.07); border-radius: 50%; }
        .circle-3 { position: absolute; top: 120px; right: 15%; width: 90px; height: 90px; background: rgba(59, 25, 143, 0.04); border-radius: 50%; }

        /* Styling Card Pembayaran */
        .card-custom {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.12);
            background: #ffffff;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--primary-light);
            padding: 32px 24px;
            text-align: center;
            border-bottom: 2px dashed #E4D8FF;
        }

        .card-header-custom .icon-wrapper {
            width: 60px;
            height: 60px;
            background-color: #ffffff;
            color: var(--primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 8px 24px rgba(59, 25, 143, 0.08);
        }

        .card-header-custom .icon-wrapper span {
            font-size: 32px;
        }

        .card-header-custom h4 {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 4px;
        }

        .card-header-custom p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        /* Ringkasan Pesanan */
        .order-summary {
            background-color: #F9FAFB;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .summary-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .summary-value {
            color: var(--text-main);
            font-weight: 700;
            font-size: 1rem;
        }

        .summary-total {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.4rem;
        }

        .divider {
            height: 1.5px;
            background-color: var(--border-color);
            margin: 16px 0;
        }

        /* Tombol Bayar */
        .btn-pay {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-weight: 600;
            font-size: 1.05rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all var(--t-fast);
            box-shadow: 0 8px 24px rgba(59, 25, 143, 0.15);
        }

        .btn-pay:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(59, 25, 143, 0.25);
            color: #ffffff;
        }

        .btn-pay span {
            font-size: 24px;
        }

        /* Tombol Kembali */
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color var(--t-fast);
            margin-top: 16px;
        }

        .btn-back:hover {
            color: var(--primary);
        }

        .btn-back span {
            font-size: 18px;
        }
    </style>
</head>
<body>

    <!-- Background Pattern Khas Website -->
    <div class="bg-decoration">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">

                <!-- Card Utama -->
                <div class="card-custom">
                    <!-- Header Custom -->
                    <div class="card-header-custom">
                        <div class="icon-wrapper">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <h4>Pembayaran</h4>
                        <p>Selesaikan pembayaran untuk memproses pesanan Anda</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        <!-- Ringkasan Singkat Pesanan -->
                        <div class="order-summary">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="summary-label">No. Pesanan</span>
                                <span class="summary-value"><?= esc($pesanan['kode_pesanan'] ?? '') ?></span>
                            </div>
                            <div class="divider"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="summary-label">Total Pembayaran</span>
                                <span class="summary-total">Rp <?= esc(number_format((float)($pesanan['total'] ?? 0), 0, ',', '.')) ?></span>
                            </div>
                        </div>

                        <!-- Instruksi & Tombol Pembayaran Midtrans -->
                        <div class="text-center mb-4">
                            <h6 class="fw-bold mb-2" style="color: var(--primary); font-size: 1rem;">
                                Pembayaran QRIS Midtrans
                            </h6>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">
                                Pindai kode QRIS menggunakan GoPay, OVO, Dana, ShopeePay, LinkAja, BCA, Mandiri, atau Mobile Banking pilihan Anda.
                            </p>
                            
                            <!-- TOMBOL MIDTRANS (ID JANGAN DIUBAH) -->
                            <button id="btn-bayar-snap" class="btn-pay">
                                <span class="material-symbols-outlined">qr_code_scanner</span>
                                Bayar Sekarang via QRIS
                            </button>
                        </div>

                        <!-- Tombol Kembali -->
                        <?php 
                            $kodeCheck = $pesanan['kode_pesanan'] ?? $pesanan['kode_booking'] ?? '';
                            $backUrl = (strpos($kodeCheck, 'SDP-STAND') !== false || strpos($kodeCheck, 'STAND') !== false) 
                                ? base_url('pesan-stand/form') 
                                : base_url('pesan-antar/form');
                        ?>
                        <div class="text-center mt-4">
                            <a href="<?= $backUrl ?>" class="btn-back">
                                <span class="material-symbols-outlined">arrow_back</span>
                                Kembali ke Form Pesanan
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ==========================================
         SDK & SCRIPT MIDTRANS (TIDAK ADA YANG DIHAPUS) 
         ========================================== -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= esc($clientKey ?? '') ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnSnap = document.getElementById('btn-bayar-snap');
            const snapToken = '<?= esc($snapToken ?? '') ?>';
            const kodePesanan = '<?= esc($pesanan['kode_pesanan'] ?? '') ?>';

            if (btnSnap) {
                btnSnap.addEventListener('click', function () {
                    if (!snapToken) {
                        alert('Token pembayaran tidak ditemukan. Silakan muat ulang halaman.');
                        return;
                    }

                    snap.pay(snapToken, {
                        onSuccess: function (result) {
                            window.location.href = '<?= base_url('pesan-antar/konfirmasi-bayar/') ?>' + kodePesanan;
                        },
                        onPending: function (result) {
                            console.log("Snap pending:", result);
                        },
                        onError: function (result) {
                            alert('Pembayaran gagal, silakan coba lagi.');
                        },
                        onClose: function () {
                            alert('Anda menutup jendela pembayaran.');
                        }
                    });
                });
            }

            // Polling otomatis tiap 2 detik untuk deteksi pembayaran lunas di Simulator Midtrans
            setInterval(function() {
                if (kodePesanan) {
                    fetch('<?= base_url('pesan-antar/cek-status/') ?>' + kodePesanan)
                        .then(response => response.json())
                        .then(res => {
                            if (res.ok && res.data && res.data.status === 'lunas') {
                                window.location.href = '<?= base_url('pesan-antar/berhasil/') ?>' + kodePesanan;
                            }
                        })
                        .catch(err => console.error("Error polling status:", err));
                }
            }, 2000);
        });
    </script>

</body>
</html>