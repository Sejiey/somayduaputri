<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembeliModel;

class PembeliAuth extends BaseController
{
    private const ADMIN_MAX_ATTEMPTS   = 5;
    private const ADMIN_WINDOW_SECONDS = 600;
    private const ADMIN_LOCK_SECONDS   = 600;

    public function register()
    {
        $redirect = (string) $this->request->getGet('redirect');
        if (session()->get('pembeli_id')) {
            return redirect()->to(base_url(! empty($redirect) ? $redirect : '/'));
        }

        $data['redirect'] = $redirect;

        return view('auth/pembeli/register', $data);
    }

    public function storeRegister()
    {
        // 1. Tentukan Rules Validasi
        $rules = [
            'nama'             => 'required|max_length[255]',
            'email'            => 'required|valid_email|max_length[255]|is_unique[pembeli.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'terms'            => 'required',
        ];

        // 2. Pesan Error Spesifik Bahasa Indonesia
        $messages = [
            'nama' => [
                'required' => 'Nama lengkap wajib diisi.',
            ],
            'email' => [
                'required'    => 'Email wajib diisi.',
                'is_unique'   => 'Email sudah terdaftar. Silakan gunakan email lain.',
                'valid_email' => 'Format email tidak valid (pastikan pakai @ dan .com).',
            ],
            'password' => [
                'required'   => 'Kata sandi wajib diisi.',
                'min_length' => 'Kata sandi terlalu pendek (minimal 6 karakter).',
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches'  => 'Konfirmasi kata sandi tidak cocok.',
            ],
            'terms' => [
                'required' => 'Anda harus menyetujui Syarat & Ketentuan terlebih dahulu.',
            ],
        ];

        // 3. Jalankan Validasi
        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Proses Pendaftaran (Gunakan OTP) ---
        $nama  = trim((string) $this->request->getPost('nama'));
        $email = trim((string) $this->request->getPost('email'));
        $plain = (string) $this->request->getPost('password');
        $redirectTarget = trim((string) $this->request->getPost('redirect'));

        $otpCode = sprintf('%06d', rand(0, 999999));
        session()->set([
            'temp_register' => [
                'nama'          => $nama,
                'email'         => $email,
                'password_hash' => PembeliModel::hashPassword($plain),
                'redirect'      => $redirectTarget,
            ],
            'otp_code'       => $otpCode,
            'otp_email'      => $email,
            'otp_purpose'    => 'register',
            'otp_expires_at' => time() + 900,
        ]);

        $this->sendOtpEmail($email, $otpCode);

        return redirect()->to('/verifikasi-otp')->with('info', 'Kode OTP verifikasi telah dikirimkan ke email <strong>' . esc($email) . '</strong>.');
    }

    public function login()
    {
        $redirect = (string) $this->request->getGet('redirect');
        if (session()->get('pembeli_id')) {
            return redirect()->to(base_url(! empty($redirect) ? $redirect : '/'));
        }

        $data['redirect'] = $redirect;

        return view('auth/pembeli/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email|max_length[255]',
            'password' => 'required',
        ];

        $loginMessages = [
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
            ],
            'password' => [
                'required' => 'Kata sandi wajib diisi.',
            ],
        ];

        if (! $this->validate($rules, $loginMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $plain = (string) $this->request->getPost('password');
        $redirectTarget = trim((string) $this->request->getPost('redirect'));

        // Cek dulu apakah email ini terdaftar sebagai admin.
        if ($this->adminRemainingLockSeconds() > 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Terlalu banyak percobaan gagal. Coba lagi nanti.');
        }

        $adminModel = new \App\Models\AdminModel();
        $adminRow   = $adminModel->findByEmail($email);

        if ($adminRow) {
            if (! password_verify($plain, $adminRow['password_hash'])) {
                $this->registerAdminFailedAttempt();
                return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
            }

            $this->clearAdminFailedAttempts();
            session()->regenerate();
            session()->set([
                'admin_id'   => (int) $adminRow['id'],
                'admin_user' => $adminRow['username'],
                'admin_nama' => $adminRow['nama_toko'],
            ]);

            return redirect()->to(base_url('admin/dashboard'))
                ->with('message', 'Berhasil login. Selamat datang, ' . $adminRow['nama_toko'] . '!');
        }

        $pembeli = (new PembeliModel())->findByEmail($email);

        if (! $pembeli || ! PembeliModel::verifyPassword($plain, $pembeli['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->set([
            'pembeli_id'    => (int) $pembeli['id'],
            'pembeli_nama'  => $pembeli['nama'],
            'pembeli_email' => $pembeli['email'],
        ]);

        // Arahkan kembali ke halaman asal jika ada parameter redirect
        if (!empty($redirectTarget)) {
            return redirect()->to(base_url($redirectTarget))->with('message', 'Berhasil login. Selamat datang, ' . $pembeli['nama'] . '!');
        }

        return redirect()->to(base_url('/'))->with('message', 'Berhasil login. Selamat datang, ' . $pembeli['nama'] . '!');
    }

    public function googleLogin()
    {
        $clientId = trim((string) env('GOOGLE_CLIENT_ID'), " \t\n\r\0\x0B'\"");
        if (empty($clientId)) {
            return redirect()->to('/login')->with('error', 'Google OAuth Client ID belum dikonfigurasi pada file .env.');
        }

        $redirectUri = base_url('auth/google/callback');
        $scope       = urlencode('email profile');

        $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'email profile',
            'access_type'   => 'online',
            'prompt'        => 'select_account',
        ]);

        return redirect()->to($url);
    }

    public function googleCallback()
    {
        $code = (string) $this->request->getGet('code');
        if (empty($code)) {
            return redirect()->to('/login')->with('error', 'Gagal melakukan otentikasi Google.');
        }

        $clientId     = trim((string) env('GOOGLE_CLIENT_ID'), " \t\n\r\0\x0B'\"");
        $clientSecret = trim((string) env('GOOGLE_CLIENT_SECRET'), " \t\n\r\0\x0B'\"");
        $redirectUri  = base_url('auth/google/callback');

        // Exchange code for token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code'          => $code,
            'client_id'     => trim((string) $clientId),
            'client_secret' => trim((string) $clientSecret),
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code',
        ]));
        $response = curl_exec($ch);
        curl_close($ch);

        $tokenData = json_decode((string) $response, true);
        $accessToken = $tokenData['access_token'] ?? null;

        if (empty($accessToken)) {
            $errDetail = $tokenData['error_description'] ?? 'Token tidak didapatkan';
            log_message('error', 'Google OAuth Error: ' . json_encode($tokenData));
            return redirect()->to('/login')->with('error', 'Gagal mendapatkan token akses dari Google (' . esc($errDetail) . ').');
        }

        // Fetch User Profile
        $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
        $userResponse = curl_exec($ch);
        curl_close($ch);

        $userData = json_decode((string) $userResponse, true);
        $email    = $userData['email'] ?? null;
        $nama     = $userData['name'] ?? 'Pengguna Google';

        if (empty($email)) {
            return redirect()->to('/login')->with('error', 'Gagal mendapatkan email dari akun Google.');
        }

        $pembeliModel = new PembeliModel();
        $pembeli = $pembeliModel->findByEmail($email);

        if (! $pembeli) {
            // Create user account automatically
            $randomPass = bin2hex(random_bytes(8));
            $id = $pembeliModel->insert([
                'nama'          => $nama,
                'email'         => $email,
                'password_hash' => PembeliModel::hashPassword($randomPass),
            ], true);
            $pembeli = $pembeliModel->find($id);
        }

        session()->set([
            'pembeli_id'    => (int) $pembeli['id'],
            'pembeli_nama'  => $pembeli['nama'],
            'pembeli_email' => $pembeli['email'],
        ]);

        return redirect()->to(base_url('/'))->with('message', 'Berhasil login via Google. Selamat datang, ' . $pembeli['nama'] . '!');
    }

    private function registerAdminFailedAttempt(): void
    {
        $session  = session();
        $attempts = (int) ($session->get('admin_login_attempts') ?? 0) + 1;
        $firstAt  = $session->get('admin_login_first_at') ?? time();
        if ($attempts === 1) {
            $firstAt = time();
        }
        $session->set('admin_login_attempts', $attempts);
        $session->set('admin_login_first_at', $firstAt);
        if ($attempts >= self::ADMIN_MAX_ATTEMPTS) {
            $session->set('admin_login_locked_until', time() + self::ADMIN_LOCK_SECONDS);
        }
    }

    private function clearAdminFailedAttempts(): void
    {
        session()->remove(['admin_login_attempts', 'admin_login_first_at', 'admin_login_locked_until']);
    }

    private function adminRemainingLockSeconds(): int
    {
        $lockedUntil = session()->get('admin_login_locked_until');
        if (! $lockedUntil) {
            return 0;
        }
        $remaining = (int) $lockedUntil - time();
        if ($remaining <= 0) {
            session()->remove(['admin_login_attempts', 'admin_login_first_at', 'admin_login_locked_until']);
            return 0;
        }
        return $remaining;
    }

    public function logout()
    {
        \App\Services\CartService::clear();
        session()->remove([
            'pembeli_id',
            'pembeli_nama',
            'pembeli_email',
            'checkout_lokasi',
            'checkout_metode',
            'checkout_catatan',
            'checkout_nama',
            'checkout_nomor_hp',
            'checkout_ruangan',
            'checkout_alamat',
            'checkout_catatan_pemesan',
            'checkout_catatan_kurir',
            'checkout_alamat_lat',
            'checkout_alamat_lng',
            'temp_biodata',
            'checkout_tanggal',
            'tanggal_dibutuhkan',
            'tanggal_pesanan',
            'pesan_stand_data',
            'pesan_stand_items',
            'pesan_stand_items_varian',
            'redirect_url',
            'redirect',
        ]);
        return redirect()->to(base_url('/'))->with('message', 'Anda telah logout.');
    }

    public function terms()
    {
        return view('auth/pembeli/syarat_ketentuan');
    }

    public function lupaPassword()
    {
        return view('auth/pembeli/lupa_password');
    }

    public function prosesLupaPassword()
    {
        $email = trim((string) $this->request->getPost('email'));
        $pembeliModel = new PembeliModel();
        $pembeli = $pembeliModel->findByEmail($email);

        if (! $pembeli) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
        }

        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $pembeliModel->update($pembeli['id'], [
            'reset_token'            => $token,
            'reset_token_expires_at' => $expiresAt,
        ]);

        $otpCode = sprintf('%06d', rand(0, 999999));
        session()->set([
            'otp_code'       => $otpCode,
            'otp_email'      => $email,
            'otp_purpose'    => 'reset_password',
            'otp_reset_token'=> $token,
            'otp_expires_at' => time() + 900,
        ]);

        $this->sendOtpEmail($email, $otpCode);

        return redirect()->to('/verifikasi-otp')->with('info', 'Kode OTP reset kata sandi telah dikirimkan ke email <strong>' . esc($email) . '</strong>.');
    }

    public function verifikasiOtp()
    {
        $otpEmail = session('otp_email');
        if (! $otpEmail) {
            return redirect()->to('/login')->with('error', 'Sesi verifikasi OTP tidak ditemukan.');
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            if ($this->request->getPost('resend')) {
                $newOtp = sprintf('%06d', rand(0, 999999));
                session()->set([
                    'otp_code'       => $newOtp,
                    'otp_expires_at' => time() + 900,
                ]);
                $this->sendOtpEmail($otpEmail, $newOtp);
                return redirect()->back()->with('info', 'Kode OTP baru telah dikirimkan ulang ke email Anda.');
            }

            $inputOtp = trim((string) $this->request->getPost('otp_code'));
            $savedOtp = session('otp_code');
            $expiresAt = session('otp_expires_at');
            $purpose   = session('otp_purpose');

            if (time() > $expiresAt) {
                return redirect()->back()->with('error', 'Kode OTP telah kadaluarsa. Silakan klik kirim ulang.');
            }

            if ($inputOtp !== $savedOtp) {
                return redirect()->back()->with('error', 'Kode OTP yang Anda masukkan salah.');
            }

            if ($purpose === 'register') {
                $tempReg = session('temp_register');
                if (! $tempReg) {
                    return redirect()->to('/daftar')->with('error', 'Data pendaftaran tidak ditemukan.');
                }

                $pembeliModel = new PembeliModel();
                $id = $pembeliModel->insert([
                    'nama'          => $tempReg['nama'],
                    'email'         => $tempReg['email'],
                    'password_hash' => $tempReg['password_hash'],
                ], true);

                $redirectTarget = $tempReg['redirect'] ?? '';
                session()->remove(['temp_register', 'otp_code', 'otp_email', 'otp_purpose', 'otp_expires_at']);

                $loginUrl = base_url('login');
                if (! empty($redirectTarget)) {
                    $loginUrl .= '?redirect=' . urlencode($redirectTarget);
                }

                return redirect()->to($loginUrl)->with('message', 'Email berhasil diverifikasi & akun berhasil dibuat! Silakan masuk.');
            } elseif ($purpose === 'reset_password') {
                $token = session('otp_reset_token');
                session()->remove(['otp_code', 'otp_email', 'otp_purpose', 'otp_reset_token', 'otp_expires_at']);
                return redirect()->to('/reset-password/' . $token)->with('message', 'OTP Berhasil diverifikasi. Silakan buat kata sandi baru Anda.');
            }
        }

        return view('auth/pembeli/otp');
    }

    private function sendOtpEmail(string $toEmail, string $otpCode): bool
    {
        try {
            $emailService = \Config\Services::email();
            $emailService->setTo($toEmail);
            $emailService->setSubject('Kode OTP Verifikasi - Siomay Dua Putri');
            
            $message = "<div style='font-family: Arial, sans-serif; padding: 20px; color: #1E293B;'>";
            $message .= "<h2 style='color: #3b198f;'>Siomay Dua Putri</h2>";
            $message .= "<p>Kode OTP verifikasi Anda adalah:</p>";
            $message .= "<h1 style='color: #3b198f; font-size: 32px; letter-spacing: 4px;'>" . esc($otpCode) . "</h1>";
            $message .= "<p>Kode ini berlaku selama 15 menit. Jangan berikan kode ini kepada siapapun.</p>";
            $message .= "</div>";

            $emailService->setMessage($message);
            return @$emailService->send();
        } catch (\Exception $e) {
            log_message('error', 'Gagal kirim email OTP: ' . $e->getMessage());
            return false;
        }
    }

    public function resetPassword($token = null)
    {
        if (empty($token)) {
            return redirect()->to('/login')->with('error', 'Token reset tidak valid.');
        }

        $db = \Config\Database::connect();
        $pembeli = $db->table('pembeli')
            ->where('reset_token', $token)
            ->where('reset_token_expires_at >=', date('Y-m-d H:i:s'))
            ->get()->getRowArray();

        if (! $pembeli) {
            return redirect()->to('/lupa-password')->with('error', 'Token reset sudah kadaluarsa atau tidak valid.');
        }

        return view('auth/pembeli/reset_password', ['token' => $token]);
    }

    public function prosesResetPassword()
    {
        $token = (string) $this->request->getPost('token');
        $password = (string) $this->request->getPost('password');
        $confirm = (string) $this->request->getPost('password_confirm');

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Kata sandi minimal 6 karakter.');
        }
        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi kata sandi tidak cocok.');
        }

        $db = \Config\Database::connect();
        $pembeli = $db->table('pembeli')
            ->where('reset_token', $token)
            ->where('reset_token_expires_at >=', date('Y-m-d H:i:s'))
            ->get()->getRowArray();

        if (! $pembeli) {
            return redirect()->to('/lupa-password')->with('error', 'Token reset sudah kadaluarsa.');
        }

        $pembeliModel = new PembeliModel();
        $pembeliModel->update($pembeli['id'], [
            'password_hash'          => PembeliModel::hashPassword($password),
            'reset_token'            => null,
            'reset_token_expires_at' => null,
        ]);

        return redirect()->to('/login')->with('message', 'Kata sandi berhasil diperbarui! Silakan masuk.');
    }
}