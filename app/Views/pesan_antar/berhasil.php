<?php // TODO: didesain oleh frontend, JANGAN diedit oleh Antigravity ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pesanan Berhasil') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts, FontAwesome & Material Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .circle-1 { position: absolute; top: -30px; left: -30px; width: 140px; height: 140px; background: rgba(59, 25, 143, 0.05); border-radius: 50%; }
        .circle-2 { position: absolute; top: 60px; left: 240px; width: 50px; height: 50px; background: rgba(59, 25, 143, 0.07); border-radius: 50%; }
        .circle-3 { position: absolute; top: 120px; right: 15%; width: 90px; height: 90px; background: rgba(59, 25, 143, 0.04); border-radius: 50%; }

        /* Card Custom */
        .card-custom {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.12);
            background: #ffffff;
        }

        /* Ikon Sukses Elegan */
        .success-icon-wrapper {
            width: 90px;
            height: 90px;
            background-color: #E8F5E9;
            color: #10B981;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.15);
        }
        .success-icon-wrapper i {
            font-size: 45px;
        }

        /* Ringkasan Pesanan */
        .order-summary {
            background-color: #F9FAFB;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        /* Tombol-tombol Custom */
        .btn-custom-wa {
            background-color: #10B981;
            color: #ffffff;
            border: none;
            transition: all var(--t-fast);
        }
        .btn-custom-wa:hover {
            background-color: #059669;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-custom-history {
            color: var(--primary);
            border: 2px solid var(--primary);
            background: transparent;
            transition: all var(--t-fast);
        }
        .btn-custom-history:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .link-home {
            color: var(--text-muted);
            font-weight: 500;
            transition: color var(--t-fast);
        }
        .link-home:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <!-- Background Pattern -->
    <div class="bg-decoration">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">

                <div class="card card-custom p-4 p-md-5 text-center">
                    
                    <!-- Icon Centang Sukses -->
                    <div class="success-icon-wrapper">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <!-- Judul Utama -->
                    <h2 class="fw-bold mb-4" style="color: var(--primary);">Pesanan Berhasil!</h2>

                    <!-- Ringkasan Informasi Pesanan -->
                    <div class="order-summary text-start">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small fw-medium">No. Pesanan</span>
                            <span class="fw-bold text-dark"><?= esc($pesanan['kode_pesanan'] ?? '') ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-medium">Status</span>
                            <span class="badge" style="background-color: #FEF3C7; color: #D97706; padding: 6px 12px; font-weight: 600; border-radius: 8px;">
                                <?= esc($pesanan['status'] ?? 'Menunggu Konfirmasi') ?>
                            </span>
                        </div>
                    </div>

                    <!-- Action / Navigasi Links -->
                    <div class="d-grid gap-3 mb-4">
                        <!-- Link WhatsApp Penjual -->
                        <?php if (!empty($waUrl)): ?>
                            <a href="<?= esc($waUrl) ?>" target="_blank" class="btn btn-custom-wa fw-bold py-3 rounded-3">
                                <i class="fa-brands fa-whatsapp me-2 fs-5 align-middle"></i>Chat WhatsApp Penjual
                            </a>
                        <?php endif; ?>

                        <!-- Link Riwayat Pesanan Saya -->
                        <a href="<?= base_url('akun/riwayat') ?>" class="btn btn-custom-history fw-bold py-3 rounded-3">
                            <span class="material-symbols-outlined me-2 align-middle" style="font-size: 20px;">receipt_long</span>Lihat Pesanan Saya
                        </a>
                    </div>

                    <!-- Link Kembali ke Beranda -->
                    <div class="mt-2">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none link-home small d-inline-flex align-items-center justify-content-center gap-1">
                            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Beranda
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>