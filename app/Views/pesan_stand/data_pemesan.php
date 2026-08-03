<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Data Pemesan — Pesan untuk Acara') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    
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

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-page);
            color: var(--text-main);
            position: relative;
        }

        /* Hiasan Bulat Background + Gambar bg_2.png */
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

        /* Wrapper Form */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
            min-height: 100vh;
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.12);
            max-width: 650px; /* Dibuat sedikit lebih ramping agar proporsional */
            width: 100%;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Area Konten Putih */
        .form-body {
            padding: 40px 40px 40px 40px;
            background: #ffffff;
            border-radius: 24px;
        }

        /* Header (Ikon kembali bulat di kiri) */
        .page-header { margin-bottom: 32px; display: flex; align-items: flex-start; gap: 16px; }
        .btn-back-icon { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 44px; 
            height: 44px; 
            border-radius: 50%; 
            background-color: var(--primary-light); 
            color: var(--primary); 
            text-decoration: none; 
            transition: background 0.2s; 
            flex-shrink: 0; 
            margin-top: 4px; 
        }
        .btn-back-icon:hover { background-color: #E4D8FF; }
        .page-header-text h2 { color: var(--accent-red); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 6px 0; }
        .page-header-text h1 { font-size: 1.8rem; margin: 0 0 4px 0; color: var(--primary); font-weight: 700; }
        .page-header-text p { color: var(--text-muted); font-size: 0.85rem; margin: 0; }
        
        .alert-error {
            background: #FEE2E2;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Styling Form */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--primary);
        }

        /* Bintang Merah */
        .text-danger {
            color: var(--accent-red);
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--text-main);
            outline: none;
            transition: border var(--t-fast);
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        /* Info Box */
        .info-box {
            background: #F9FAFB;
            border: 1px solid var(--border-color);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        /* Map Styling */
        #map {
            height: 250px;
            border-radius: 12px;
            border: 1.5px solid var(--border-color);
            margin-top: 8px;
            z-index: 1;
        }

        /* Tombol Submit */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            box-shadow: 0 8px 24px rgba(59, 25, 143, 0.15);
        }
        .btn-submit:hover { background: var(--primary-hover); }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .form-wrapper { padding: 16px 12px; }
            .form-body { padding: 24px 20px 20px 20px; }
            
            .btn-back-icon { width: 38px; height: 38px; margin-top: 2px; }
            .btn-back-icon .material-symbols-outlined { font-size: 20px !important; }
            .page-header-text h2 { font-size: 0.75rem; }
            .page-header-text h1 { font-size: 1.3rem; }
            .page-header-text p { font-size: 0.75rem; }

            .form-group { margin-bottom: 20px; }
            .form-label { font-size: 0.85rem; margin-bottom: 6px; }
            .form-control { padding: 12px 14px; font-size: 0.9rem; }
            
            #map { height: 200px; }
            
            .btn-submit { padding: 14px; font-size: 0.95rem; }
        }
    </style>
</head>
<body>

    <!-- Hiasan Background -->
    <div class="bg-decoration">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <!-- Wrapper Tengah -->
    <div class="form-wrapper">
        <div class="form-card">
            <div class="form-body">
                
                <!-- Header -->
                <div class="page-header">
                    <a href="<?= base_url('pesan-stand/menu') ?>" class="btn-back-icon" aria-label="Kembali ke Menu">
                        <span class="material-symbols-outlined" style="font-size: 24px;">arrow_back</span>
                    </a>
                    <div class="page-header-text">
                        <h2>PESAN STAND ACARA</h2>
                        <h1>Langkah 2: Data Pemesan</h1>
                        <p>Lengkapi informasi identitas diri dan jadwal acara Anda.</p>
                    </div>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert-error">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('pesan-stand/proses-data-pemesan') ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemesan" class="form-control" required value="<?= esc(old('nama_pemesan') ?? $sessionBiodata['nama_pemesan'] ?? $pembeliNama) ?>" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. WhatsApp / Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control" required value="<?= esc(old('nomor_hp') ?? $sessionBiodata['nomor_hp'] ?? '') ?>" placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Acara (Minimal Besok) <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_acara" class="form-control" required min="<?= esc($besok) ?>" value="<?= esc(old('tanggal_acara') ?? $sessionBiodata['tanggal_acara'] ?? $besok) ?>">
                    </div>

                    <?php $metode = $orderData['metode_pengambilan'] ?? 'diantar'; ?>

                    <?php if ($metode === 'diantar'): ?>
                        <div class="form-group">
                            <label class="form-label">Patokan Maxim (Lokasi Driver) <span class="text-danger">*</span></label>
                            <input type="text" name="patokan_maxim" class="form-control" required value="<?= esc(old('patokan_maxim') ?? $sessionBiodata['patokan_maxim'] ?? '') ?>" placeholder="Contoh: Depan pagar hitam / RSUD Undata lobby utama">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap Pengantaran <span class="text-danger">*</span></label>
                            <input type="text" id="alamat_text" name="alamat" class="form-control" required value="<?= esc(old('alamat') ?? $sessionBiodata['alamat'] ?? '') ?>" placeholder="Geser pin pada peta di bawah atau ketik alamat">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tentukan Titik Peta (Pin Lokasi)</label>
                            <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:8px;">Geser marker/pin pada peta ke titik lokasi pengantaran Anda.</div>
                            <div id="map"></div>
                        </div>

                        <input type="hidden" id="alamat_lat" name="alamat_lat" value="<?= esc(old('alamat_lat') ?? $sessionBiodata['alamat_lat'] ?? '-0.8917') ?>">
                        <input type="hidden" id="alamat_lng" name="alamat_lng" value="<?= esc(old('alamat_lng') ?? $sessionBiodata['alamat_lng'] ?? '119.8707') ?>">
                    <?php else: ?>
                        <div class="info-box">
                            <div style="font-weight:700; color:var(--primary); margin-bottom:4px; font-size:0.95rem;">Lokasi Pengambilan</div>
                            <div style="font-size:0.9rem; color:var(--text-main);">Kantin RSUD Undata, Kota Palu</div>
                            <div style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">Pesanan porsi besar Anda dapat diambil langsung pada tanggal acara yang telah ditentukan.</div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-submit">
                        Lanjut ke Ringkasan <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- SCRIPT PETA & LOGIC (TIDAK ADA YANG DIUBAH) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <?php if ($metode === 'diantar'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var defaultLat = parseFloat(document.getElementById('alamat_lat').value) || -0.8917;
            var defaultLng = parseFloat(document.getElementById('alamat_lng').value) || 119.8707;

            var map = L.map('map').setView([defaultLat, defaultLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

            function updateCoords(lat, lng) {
                document.getElementById('alamat_lat').value = lat;
                document.getElementById('alamat_lng').value = lng;

                // Reverse geocoding via Nominatim API
                fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('alamat_text').value = data.display_name;
                        }
                    })
                    .catch(err => console.log('Geocoding error:', err));
            }

            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                updateCoords(position.lat, position.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>