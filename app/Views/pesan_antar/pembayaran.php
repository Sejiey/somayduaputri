<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pembayaran') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Card Utama -->
            <div class="card card-custom bg-white overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="fw-bold mb-1"><i class="fa-solid fa-receipt me-2"></i>Pembayaran</h4>
                    <p class="mb-0 text-white-50 small">Selesaikan pembayaran untuk memproses pesanan Anda</p>
                </div>

                <div class="card-body p-4">

                    <!-- Ringkasan Singkat Pesanan -->
                    <div class="bg-light p-3 rounded-3 mb-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">No. Pesanan:</span>
                            <span class="fw-bold text-dark"><?= esc($pesanan['kode_pesanan'] ?? '') ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Total Pembayaran:</span>
                            <span class="fs-5 fw-bold text-primary">Rp<?= esc(number_format((float)($pesanan['total'] ?? 0), 0, ',', '.')) ?></span>
                        </div>
                    </div>

                    <!-- Pembayaran Utama via Midtrans -->
                    <div class="text-center my-3">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="fa-solid fa-credit-card text-primary me-1"></i> Bayar Via Midtrans Gateway
                        </h6>
                        <p class="text-muted small mb-4">
                            Mendukung QRIS, Transfer Bank (VA), ShopeePay, GoPay, & Kartu Kredit/Debit.
                        </p>
                        <button id="btn-bayar-snap" class="btn btn-primary btn-lg w-100 fw-bold py-2 shadow-sm rounded-3">
                            <i class="fa-solid fa-lock me-2"></i>Bayar Sekarang (Midtrans)
                        </button>
                    </div>

                    <hr class="my-4">

                    <!-- Tombol Kembali -->
                    <div class="text-center">
                        <a href="<?= base_url('pesan-antar/form') ?>" class="text-decoration-none text-muted small">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Form Pesanan
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- SDK Midtrans Snap -->
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
                        // Mengarah ke route konfirmasi-bayar setelah route ditambahkan di Routes.php
                        window.location.href = '<?= base_url('pesan-antar/konfirmasi-bayar/') ?>' + kodePesanan;
                    },
                    onPending: function (result) {
                        window.location.href = '<?= base_url('pesan-antar/konfirmasi-bayar/') ?>' + kodePesanan;
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
    });
</script>

</body>
</html>