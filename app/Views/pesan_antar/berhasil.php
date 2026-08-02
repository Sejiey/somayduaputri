<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pesanan Berhasil') ?></title>

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
        .success-icon {
            font-size: 3.5rem;
            color: #198754;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card card-custom bg-white p-4 p-md-5 text-center">
                <!-- Icon Centang Sukses -->
                <div class="mb-3">
                    <i class="fa-solid fa-circle-check success-icon"></i>
                </div>

                <!-- Judul Utama -->
                <h2 class="fw-bold text-dark mb-4">Pesanan Berhasil!</h2>

                <!-- Ringkasan Informasi Pesanan -->
                <div class="bg-light p-3 rounded-3 mb-4 text-start border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">No. Pesanan:</span>
                        <span class="fw-bold text-dark"><?= esc($pesanan['kode_pesanan'] ?? '') ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Status:</span>
                        <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill fw-semibold">
                            <?= esc($pesanan['status'] ?? 'Menunggu Konfirmasi') ?>
                        </span>
                    </div>
                </div>

                <!-- Action / Navigasi Links -->
                <div class="d-grid gap-2 mb-3">
                    <!-- Link WhatsApp Penjual (Muncul jika $waUrl tersedia) -->
                    <?php if (!empty($waUrl)): ?>
                        <a href="<?= esc($waUrl) ?>" target="_blank" class="btn btn-success fw-bold py-2 rounded-3 shadow-sm">
                            <i class="fa-brands fa-whatsapp me-2"></i>Chat WhatsApp Penjual
                        </a>
                    <?php endif; ?>

                    <!-- Link Riwayat Pesanan Saya -->
                    <a href="<?= base_url('akun/riwayat') ?>" class="btn btn-outline-primary fw-bold py-2 rounded-3">
                        <i class="fa-solid fa-receipt me-2"></i>Lihat Pesanan Saya
                    </a>
                </div>

                <!-- Link Kembali ke Beranda -->
                <div class="mt-3">
                    <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted small">
                        <i class="fa-solid fa-house me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>