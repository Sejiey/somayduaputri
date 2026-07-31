<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Siomay Dua Putri</title>
    
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
        .input-wrapper input::placeholder {
            color: #9CA3AF;
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
            transition: color var(--t-fast);
        }
        .btn-eye:hover .material-symbols-outlined { color: var(--primary); }

        .forgot-password-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: -10px;
            margin-bottom: 24px;
        }
        .forgot-password-wrapper a {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .forgot-password-wrapper a:hover { text-decoration: underline; }

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

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        .divider::before { margin-right: 16px; }
        .divider::after { margin-left: 16px; }

        .btn-google {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: 100%;
            height: 48px;
            background: #ffffff;
            color: var(--text-main);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background var(--t-fast);
        }
        .btn-google:hover { background: #F9FAFB; }
        .btn-google svg { width: 20px; height: 20px; }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }

        @keyframes errorShake {
            0% { transform: translateX(0); opacity: 0; }
            20% { transform: translateX(-8px); opacity: 1; }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
            100% { transform: translateX(0); opacity: 1; }
        }

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
            animation: errorShake 0.5s ease-out forwards;
        }
        .alert-box .material-symbols-outlined {
            font-size: 20px;
            margin-top: 1px;
        }
        .alert-content {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .error-item {
            display: flex;
            gap: 6px;
            align-items: flex-start;
        }
        .error-item::before {
            content: '•';
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <a href="<?= base_url() ?>" class="btn-close" title="Tutup">
            <span class="material-symbols-outlined">close</span>
        </a>

        <div class="auth-header">
            <h1>Masuk</h1>
            <p>Selamat datang kembali!</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-box">
                <span class="material-symbols-outlined">error</span>
                <div class="alert-content">
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php $fieldErrors = session()->getFlashdata('errors'); ?>
        <?php if (! empty($fieldErrors) && is_array($fieldErrors)): ?>
            <div class="alert-box">
                <span class="material-symbols-outlined">error</span>
                <div class="alert-content">
                    <?php foreach ($fieldErrors as $msg): ?>
                        <span class="error-item"><?= esc($msg) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="post" action="<?= base_url('login') ?>" novalidate>
            <?= csrf_field() ?>
            
            <!-- Hidden Redirect -->
            <?php if (!empty($redirect)): ?>
                <input type="hidden" name="redirect" value="<?= esc($redirect) ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <span class="material-symbols-outlined">mail</span>
                    <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" placeholder="Masukkan email Anda" required maxlength="255">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <span class="material-symbols-outlined">lock</span>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                    <button type="button" class="btn-eye" onclick="togglePassword('password', 'eye-icon-1')">
                        <span class="material-symbols-outlined" id="eye-icon-1">visibility_off</span>
                    </button>
                </div>
            </div>

            <div class="forgot-password-wrapper">
                <a href="<?= base_url('lupa-password') ?>">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn-primary">Masuk</button>
        </form>

        <div class="divider">atau</div>

        <button type="button" class="btn-google">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Masuk dengan Google
        </button>

        <div class="auth-footer">
            Belum punya akun? <a href="<?= base_url('daftar' . (!empty($redirect) ? '?redirect=' . urlencode($redirect) : '')) ?>">Daftar di sini</a>
        </div>
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
    </script>
</body>
</html>