<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — Siomay Dua Putri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary: #3b198f;
            --primary-hover: #2e1373;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --bg-page: #F8FAFC;
            --border-color: #E2E8F0;
            --card-shadow: 0 10px 25px -5px rgba(59, 25, 143, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            background-image: url('<?= base_url("bg_2.png") ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 440px;
            padding: 40px 32px;
            position: relative;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #F1F5F9;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            background: #E2E8F0;
            color: var(--text-dark);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-header h1 {
            color: var(--primary);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .otp-email-badge {
            display: inline-block;
            background: #F1F5F9;
            color: var(--primary);
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .alert-box {
            background: #FEF2F2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-info {
            background: #EFF6FF;
            border-color: #93C5FD;
            color: #1E40AF;
        }

        .otp-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 24px 0;
        }

        .otp-input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: #FFFFFF;
            outline: none;
            transition: all 0.2s ease;
        }

        .otp-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 25, 143, 0.15);
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            box-shadow: 0 4px 12px rgba(59, 25, 143, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .auth-footer button {
            background: none;
            border: none;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <a href="<?= base_url() ?>" class="btn-close" title="Tutup">
            <span class="material-symbols-outlined">close</span>
        </a>

        <div class="auth-header">
            <h1>Verifikasi OTP</h1>
            <p>Masukkan 6 digit kode verifikasi yang telah kami kirimkan ke email Anda:</p>
            <div class="otp-email-badge"><?= esc(session('otp_email') ?? 'email@anda.com') ?></div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-box">
                <span class="material-symbols-outlined">error</span>
                <span><?= esc(session()->getFlashdata('error')) ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert-box alert-info">
                <span class="material-symbols-outlined">info</span>
                <span><?= session()->getFlashdata('info') ?></span>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('verifikasi-otp') ?>" id="otpForm">
            <?= csrf_field() ?>
            <input type="hidden" id="fullOtp" name="otp_code">

            <div class="otp-container">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="one-time-code" autofocus>
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
            </div>

            <button type="submit" class="btn-primary">Verifikasi Sekarang</button>
        </form>

        <div class="auth-footer">
            Tidak menerima kode? 
            <form method="post" action="<?= base_url('verifikasi-otp') ?>" style="display:inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="resend" value="1">
                <button type="submit">Kirim Ulang OTP</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const fullOtpInput = document.getElementById('fullOtp');
            const form = document.getElementById('otpForm');

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateFullOtp();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                    if (/^\d{6}$/.test(pasteData)) {
                        pasteData.split('').forEach((char, i) => {
                            if (inputs[i]) inputs[i].value = char;
                        });
                        inputs[5].focus();
                        updateFullOtp();
                    }
                });
            });

            function updateFullOtp() {
                let code = '';
                inputs.forEach(input => code += input.value);
                fullOtpInput.value = code;
            }

            form.addEventListener('submit', function(e) {
                updateFullOtp();
                if (fullOtpInput.value.length < 6) {
                    e.preventDefault();
                    alert('Silakan masukkan 6 digit kode OTP secara lengkap.');
                }
            });
        });
    </script>
</body>
</html>
