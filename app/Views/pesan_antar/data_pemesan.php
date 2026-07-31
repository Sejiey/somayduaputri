<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pemesan — Siomay Dua Putri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root { --primary: #3b198f; --primary-hover: #2e1069; --border-color: #E5E7EB; --bg-page: #FBF9FF; --accent-red: #E11D48; }
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { margin: 0; background-color: var(--bg-page); background-image: url('<?= base_url("bg.png") ?>'); background-size: cover; background-attachment: fixed; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0 20px 60px rgba(59,25,143,0.08); position: relative; }
        
        .top-nav { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; border-bottom: 1px dashed var(--border-color); padding-bottom: 16px; }
        .btn-back { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #F4EFFF; color: var(--primary); border-radius: 50%; text-decoration: none; transition: 0.2s; }
        .btn-back:hover { background: var(--primary); color: #fff; }
        .page-title { font-size: 1.25rem; font-weight: 700; color: var(--primary); margin: 0; }
        
        .form-group { margin-bottom: 20px; position: relative; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; color: var(--primary); }
        .form-control { width: 100%; padding: 12px; border: 1.5px solid var(--border-color); border-radius: 12px; outline: none; }
        .form-control:focus { border-color: var(--primary); }
        .error-msg { color: var(--accent-red); font-size: 0.8rem; margin-top: 5px; display: none; }
        
        #map { height: 250px; border-radius: 12px; border: 1px solid var(--border-color); z-index: 1; }
        .btn-maps-link { display: block; text-align: center; background: #F4EFFF; color: var(--primary); padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 10px; }
        .btn-submit { width: 100%; padding: 14px; background: var(--primary); color: #fff; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; margin-top: 20px; font-size: 1rem; }
        
        .saran-lokasi { position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid var(--border-color); border-radius: 8px; max-height: 200px; overflow-y: auto; z-index: 999; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .saran-item { padding: 10px 12px; cursor: pointer; font-size: 0.85rem; border-bottom: 1px solid #f3f4f6; }
        .saran-item:hover { background: #F4EFFF; color: var(--primary); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-nav">
            <a href="<?= base_url('pesan-antar/form') ?>" class="btn-back"><span class="material-symbols-outlined">arrow_back</span></a>
            <h1 class="page-title">Data Pemesan</h1>
        </div>

        <form id="formPemesan" action="<?= base_url('pesan-antar/proses-data-pemesan') ?>" method="post" onsubmit="return validateForm(event)">
            <?= csrf_field() ?>
            <input type="hidden" name="koordinat_lat" id="lat-val" value="<?= esc(session('temp_biodata')['koordinat_lat'] ?? session('checkout_alamat_lat') ?? '') ?>">
            <input type="hidden" name="koordinat_lng" id="lng-val" value="<?= esc(session('temp_biodata')['koordinat_lng'] ?? session('checkout_alamat_lng') ?? '') ?>">

            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="nama" class="form-control" required value="<?= esc(old('nama') ?? session('temp_biodata')['nama'] ?? session('checkout_nama') ?? session('pembeli_nama') ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">No. WhatsApp *</label>
                <input type="text" id="inputWa" name="wa" class="form-control" placeholder="Contoh: 0812... atau +62812..." required value="<?= esc(old('wa') ?? session('temp_biodata')['wa'] ?? session('checkout_nomor_hp') ?? '') ?>">
                <div id="waError" class="error-msg">Nomor harus diawali 08 atau +62 dengan total 11-12 digit angka.</div>
            </div>

            <?php 
                $metode = session('temp_order')['metode'] ?? session('metode') ?? session('checkout_metode') ?? 'diantar'; 
            ?>
            
            <?php if($metode == 'ambil_sendiri'): ?>
                <div class="form-group">
                    <label class="form-label">Lokasi Pengambilan</label>
                    <div style="background:#F9FAFB; padding:12px; border-radius:8px; border:1px solid var(--border-color); margin-bottom:10px;">
                        <strong style="color:var(--primary);">Siomay Dua Putri</strong><br>
                        <span style="font-size:0.85rem; color:#666;">Jl. Rinda Permai, Kec. Mantikulore, Kota Palu, Sulawesi Tengah 94119</span>
                    </div>
                    <div id="map"></div>
                    <!-- Link Google Maps menggunakan parameter query alamat akurat -->
                    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Rinda+Permai,+Kec.+Mantikulore,+Kota+Palu,+Sulawesi+Tengah+94119" target="_blank" class="btn-maps-link">Buka Navigasi di Google Maps</a>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap * (Ketik untuk mencari)</label>
                    <input type="text" id="inputAlamat" name="alamat" class="form-control" placeholder="Ketik nama jalan/daerah di Palu..." autocomplete="off" required value="<?= esc(old('alamat') ?? session('temp_biodata')['alamat'] ?? session('checkout_alamat') ?? '') ?>">
                    <div id="saranWadah" class="saran-lokasi"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Peta Lokasi Pengantaran (Bisa digeser)</label>
                    <div id="map"></div>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn-submit">Lanjut ke Ringkasan</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const isAmbilSendiri = <?= $metode == 'ambil_sendiri' ? 'true' : 'false' ?>;
        
        // Koordinat Spesifik Jl. Rinda Permai, Mantikulore (Ambil Sendiri)
        const defaultLat = isAmbilSendiri ? -0.8872 : (parseFloat("<?= esc(session('temp_biodata')['koordinat_lat'] ?? session('checkout_alamat_lat') ?? '-0.8917') ?>") || -0.8917);
        const defaultLng = isAmbilSendiri ? 119.8975 : (parseFloat("<?= esc(session('temp_biodata')['koordinat_lng'] ?? session('checkout_alamat_lng') ?? '119.8707') ?>") || 119.8707);

        let map = L.map('map').setView([defaultLat, defaultLng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        let marker = L.marker([defaultLat, defaultLng], {draggable: !isAmbilSendiri}).addTo(map);

        function updateCoord(lat, lng) {
            document.getElementById('lat-val').value = lat;
            document.getElementById('lng-val').value = lng;
        }
        
        if(!isAmbilSendiri) {
            marker.on('dragend', function(e) {
                let pos = marker.getLatLng();
                updateCoord(pos.lat, pos.lng);
            });
        }
        updateCoord(defaultLat, defaultLng);

        // AUTOCMPLETE DENGAN BATASAN WILAYAH PALU
        if(!isAmbilSendiri) {
            const inputAlamat = document.getElementById('inputAlamat');
            const saranWadah = document.getElementById('saranWadah');
            let timeout = null;

            inputAlamat.addEventListener('input', function() {
                clearTimeout(timeout);
                let q = this.value;
                if(q.length < 4) { saranWadah.style.display = 'none'; return; }
                
                timeout = setTimeout(() => {
                    // Bounding Box untuk area Palu agar hasil lebih akurat
                    const viewbox = "119.7800,-0.9500,119.9500,-0.8000"; 
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}&countrycodes=id&viewbox=${viewbox}&bounded=1`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        data.forEach(item => {
                            let cleanName = item.display_name.replace(/'/g, "\\'");
                            html += `<div class="saran-item" onclick="pilihLokasi(${item.lat}, ${item.lon}, '${cleanName}')">${item.display_name}</div>`;
                        });
                        saranWadah.innerHTML = html;
                        saranWadah.style.display = data.length > 0 ? 'block' : 'none';
                    });
                }, 600);
            });

            window.pilihLokasi = function(lat, lng, nama) {
                inputAlamat.value = nama;
                saranWadah.style.display = 'none';
                map.setView([lat, lng], 17);
                marker.setLatLng([lat, lng]);
                updateCoord(lat, lng);
            };
        }

        // VALIDASI WHATSAPP
        function validateForm(e) {
            const waInput = document.getElementById('inputWa').value.replace(/\s|-/g, '');
            const waError = document.getElementById('waError');
            
            // Regex: Diawali 08 atau +628, panjang total digit angka (tanpa +) adalah 11-12.
            const waRegex = /^(08|\+628)[0-9]{8,10}$/;

            if (!waRegex.test(waInput)) {
                waError.style.display = 'block';
                document.getElementById('inputWa').focus();
                e.preventDefault();
                return false;
            }
            waError.style.display = 'none';
            return true;
        }
    </script>
</body>
</html>
