<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Konfirmasi — Pesan Antar</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts & Material Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b198f;       
            --primary-light: #F4EFFF; 
            --text-main: #1D1A22;
            --text-muted: #6B7280;
            --bg-page: #F4F0FF; 
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
            padding: 40px;
            text-align: center;
        }

        .spinner-wrapper {
            margin-bottom: 24px;
        }
        
        .spinner-border {
            color: var(--primary);
            width: 3.5rem;
            height: 3.5rem;
            border-width: 0.25em;
        }

        .status-box {
            background-color: var(--primary-light);
            border-radius: 12px;
            padding: 16px;
            margin-top: 24px;
            color: var(--primary);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
                
                <div class="card card-custom">
                    <!-- Animasi Loading -->
                    <div class="spinner-wrapper">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Informasi -->
                    <h3 class="fw-bold mb-2" style="color: var(--primary);">Menunggu Konfirmasi</h3>
                    <p class="text-muted mb-0">Kode Pesanan: <strong class="text-dark"><?= esc($pesanan['kode_pesanan'] ?? '') ?></strong></p>

                    <!-- Status Text Dinamis (ID Dipertahankan) -->
                    <div class="status-box">
                        <span class="material-symbols-outlined">hourglass_empty</span>
                        <span id="statusText">Menunggu konfirmasi pembayaran dari Midtrans...</span>
                    </div>

                    <p class="text-muted mt-4 mb-0" style="font-size: 0.8rem; line-height: 1.6;">
                        Halaman ini akan otomatis melakukan <i>refresh</i> setiap 3 detik sampai pembayaran Anda terkonfirmasi oleh sistem.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT LOGIC (TIDAK ADA YANG DIUBAH) -->
    <script>
        const kodePesanan = '<?= esc($pesanan['kode_pesanan'] ?? '') ?>';
        const cekStatusUrl = '<?= base_url('pesan-antar/cek-status/') ?>' + kodePesanan;
        const berhasilUrl  = '<?= base_url('pesan-antar/berhasil/') ?>' + kodePesanan;

        function cekStatus() {
            fetch(cekStatusUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.ok && data.data && data.data.status === 'lunas') {
                        document.getElementById('statusText').innerText = 'Pembayaran terkonfirmasi! Mengarahkan...';
                        window.location.href = berhasilUrl;
                    }
                })
                .catch(err => console.error('Gagal cek status:', err));
        }

        setInterval(cekStatus, 3000);
        cekStatus();
    </script>
</body>
</html>