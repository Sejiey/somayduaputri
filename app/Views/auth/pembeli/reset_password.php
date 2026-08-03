<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Kata Sandi Baru — Siomay Dua Putri</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #5731B6;       
            --primary-light: #F4EFFF; 
            --text-main: #1D1A22;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --bg-page: #FBF9FF;
            --err-bg: #FEE2E2;
            --err-fg: #991B1B;
            --t-fast: 200ms ease;
        }

        * { box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            color: var(--text-main);
            min-height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(87, 49, 182, 0.08);
            max-width: 460px;
            width: 100%;
            position: relative;
        }

        .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            background-color: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background-color var(--t-fast);
        }
        .btn-close:hover { background-color: #E4D8FF; }
        .btn-close .material-symbols-outlined { font-size: 20px; }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-header h1 {
            color: #2D1A56; 
            margin: 0 0 8px;
            font-size: 1.6rem;
            font-weight: 700;
        }
        .auth-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            background: #ffffff;
            padding: 0 14px;
            height: 48px;
            transition: border-color var(--t-fast), box-shadow var(--t-fast);
        }
        .input-wrapper:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(87, 49, 182, 0.1);
        }
        .input-wrapper .material-symbols-outlined {
            color: var(--primary);
            font-size: 20px;
            margin-right: 12px;
        }
        .input-wrapper input {
            border: none;
            outline: none;
            width: 100%;
            height: 100%;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            background: transparent;
        }

        .btn-eye {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }
        .btn-eye .material-symbols-outlined {
            color: var(--text-muted);
            margin-right: 0;
            font-size: 20px;
        }

        .btn-primary {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 48px;
            background: linear-gradient(90deg, #4A1E9E 0%, #6338C4 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: opacity var(--t-fast), transform var(--t-fast);
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        .alert-box {
            background: var(--err-bg);
            color: var(--err-fg);
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <a href="<?= base_url('login') ?>" class="btn-close" title="Tutup">
            <span class="material-symbols-outlined">close</span>
        </a>

        <div class="auth-header">
            <h1>Buat Kata Sandi Baru</h1>
            <p>Silakan buat kata sandi baru untuk akun Anda.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-box">
                <span class="material-symbols-outlined">error</span>
                <div><?= esc(session()->getFlashdata('error')) ?></div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('reset-password/proses') ?>" autocomplete="off" novalidate>
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">

            <div class="form-group">
                <label for="password">Kata Sandi Baru</label>
                <div class="input-wrapper">
                    <span class="material-symbols-outlined">lock</span>
                    <input type="password" id="password" name="password" value="" placeholder="Minimal 6 karakter" autocomplete="new-password" required minlength="6">
                    <button type="button" class="btn-eye" onclick="togglePassword('password', 'eye-icon-1')">
                        <span class="material-symbols-outlined" id="eye-icon-1">visibility_off</span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirm">Konfirmasi Kata Sandi Baru</label>
                <div class="input-wrapper">
                    <span class="material-symbols-outlined">lock</span>
                    <input type="password" id="password_confirm" name="password_confirm" value="" placeholder="Ulangi kata sandi" autocomplete="new-password" required minlength="6">
                    <button type="button" class="btn-eye" onclick="togglePassword('password_confirm', 'eye-icon-2')">
                        <span class="material-symbols-outlined" id="eye-icon-2">visibility_off</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary">Simpan Kata Sandi Baru</button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const clearInputs = function() {
                const p1 = document.getElementById('password');
                const p2 = document.getElementById('password_confirm');
                if (p1) p1.value = '';
                if (p2) p2.value = '';
            };
            clearInputs();
            window.addEventListener('pageshow', clearInputs);
        });
    </script>
</body>
</html>
