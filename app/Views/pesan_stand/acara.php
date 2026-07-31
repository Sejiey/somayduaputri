<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Isi Data Acara — Siomay Dua Putri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1069;
            --border-color: #E5E7EB;
            --text-main: #1D1A22;
            --accent-red: #E11D48;
        }
        
        body {
            background-color: #FBF9FF;
            background-image: url('<?= base_url("bg.png") ?>');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            margin: 0; padding-bottom: 60px;
        }

        .wrapper {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            padding: 32px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(59, 25, 143, 0.08);
        }

        /* Top Nav dengan Icon Kembali */
        .top-nav {
            display: flex; align-items: center; gap: 16px; 
            margin-bottom: 24px; border-bottom: 1px dashed var(--border-color); 
            padding-bottom: 16px;
        }
        .btn-back {
            display: inline-flex; align-items: center; justify-content: center; 
            width: 40px; height: 40px; background: #F4EFFF; color: var(--primary); 
            border-radius: 50%; text-decoration: none; transition: 0.2s;
        }
        .btn-back:hover { background: var(--primary); color: #fff; }
        .page-title { font-size: 1.3rem; font-weight: 700; color: var(--primary); margin: 0; }

        /* Alert Warning */
        .alert-warning {
            background: #FFFBEB; border: 1px solid #FDE68A; padding: 16px; 
            border-radius: 12px; display: flex; gap: 12px; margin-bottom: 24px;
            align-items: flex-start;
        }
        .alert-warning .material-symbols-outlined { color: #B45309; font-variation-settings: 'FILL' 1; }
        .alert-text { color: #92400E; font-size: 0.9rem; line-height: 1.5; }
        .alert-text strong { display: block; margin-bottom: 4px; }

        .alert-error {
            background: #FEE2E2; border: 1px solid #FCA5A5; padding: 14px 16px;
            border-radius: 12px; color: #991B1B; font-size: 0.9rem; margin-bottom: 20px;
        }

        /* Form Styles */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { position: relative; margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--primary); margin-bottom: 8px; }
        .form-label span.req { color: var(--accent-red); }
        .form-control { 
            width: 100%; padding: 14px 16px; border-radius: 12px; 
            border: 1.5px solid var(--border-color); font-family: inherit; 
            font-size: 0.95rem; outline: none; transition: border 0.2s ease; 
            box-sizing: border-box; background: #fff;
        }
        .form-control:focus { border-color: var(--primary); }
        select.form-control { appearance: none; cursor: pointer; }
        textarea.form-control { resize: none; height: 100px; }
        
        .char-count { position: absolute; bottom: 12px; right: 16px; font-size: 0.75rem; color: #9CA3AF; }

        .btn-submit {
            width: 100%; padding: 16px; background: var(--primary); color: #fff; 
            border: none; border-radius: 12px; font-weight: 600; font-size: 1rem; 
            cursor: pointer; display: flex; justify-content: center; align-items: center; 
            gap: 8px; margin-top: 10px; transition: background 0.2s; font-family: 'Poppins', sans-serif;
        }
        .btn-submit:hover { background: var(--primary-hover); }

        @media (max-width: 768px) {
            .wrapper { margin: 20px; padding: 24px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Top Nav Baru -->
        <div class="top-nav">
            <a href="<?= base_url('pesan-stand/tentang') ?>" class="btn-back"><span class="material-symbols-outlined">arrow_back</span></a>
            <h1 class="page-title">Isi Data Acara</h1>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <div class="alert-warning">
            <span class="material-symbols-outlined">warning</span>
            <div class="alert-text">
                <strong>Pastikan tanggal dan lokasi acara sudah benar.</strong>
                Booking stand akan disesuaikan dengan data yang Anda isi.
            </div>
        </div>

        <form action="<?= base_url('pesan-stand/acara') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-grid">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required value="<?= esc(old('nama') ?? old('nama_pemesan') ?? $formData['nama_pemesan'] ?? $pembeliNama ?? '') ?>">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">No. WhatsApp <span class="req">*</span></label>
                    <input type="tel" name="no_wa" class="form-control" placeholder="Masukkan nomor WhatsApp" required value="<?= esc(old('no_wa') ?? old('nomor_hp') ?? $formData['nomor_hp'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Acara <span class="req">*</span></label>
                <?php $selJenis = old('jenis_acara') ?? $formData['jenis_acara'] ?? ''; ?>
                <select name="jenis_acara" class="form-control" required>
                    <option value="" disabled <?= empty($selJenis) ? 'selected' : '' ?>>Pilih jenis acara</option>
                    <option value="Pernikahan" <?= in_array($selJenis, ['Pernikahan', 'pernikahan']) ? 'selected' : '' ?>>Pernikahan</option>
                    <option value="Ulang Tahun" <?= in_array($selJenis, ['Ulang Tahun', 'ulang_tahun']) ? 'selected' : '' ?>>Ulang Tahun</option>
                    <option value="Arisan" <?= in_array($selJenis, ['Arisan', 'arisan']) ? 'selected' : '' ?>>Arisan</option>
                    <option value="Perusahaan" <?= in_array($selJenis, ['Perusahaan', 'acara_perusahaan']) ? 'selected' : '' ?>>Acara Perusahaan</option>
                    <option value="Lainnya" <?= in_array($selJenis, ['Lainnya', 'lainnya']) ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>

            <div class="form-grid">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tanggal Acara <span class="req">*</span></label>
                    <input type="date" name="tanggal" class="form-control" required min="<?= esc($besok ?? date('Y-m-d', strtotime('+1 day'))) ?>" value="<?= esc(old('tanggal') ?? old('tanggal_acara') ?? $formData['tanggal_acara'] ?? '') ?>">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Lokasi Acara <span class="req">*</span></label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi acara" required value="<?= esc(old('lokasi') ?? old('lokasi_acara') ?? $formData['lokasi_acara'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Estimasi Jumlah Tamu <span class="req">*</span></label>
                <input type="number" name="jumlah_tamu" class="form-control" placeholder="Masukkan perkiraan jumlah tamu" required value="<?= esc(old('jumlah_tamu') ?? old('estimasi_porsi') ?? $formData['estimasi_porsi'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea name="catatan" class="form-control" placeholder="Contoh: kebutuhan meja tambahan, dll." maxlength="200" oninput="document.getElementById('charCount').innerText = this.value.length + '/200'"><?= esc(old('catatan') ?? $formData['catatan'] ?? '') ?></textarea>
                <div class="char-count" id="charCount">0/200</div>
            </div>

            <button type="submit" class="btn-submit">
                Lanjut <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </div>

</body>
</html>
