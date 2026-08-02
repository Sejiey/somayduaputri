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

        // --- Proses Pendaftaran ---
        $nama  = trim((string) $this->request->getPost('nama'));
        $email = trim((string) $this->request->getPost('email'));
        $plain = (string) $this->request->getPost('password');
        $redirectTarget = trim((string) $this->request->getPost('redirect'));

        $pembeli = new PembeliModel();
        $id = $pembeli->insert([
            'nama'          => $nama,
            'email'         => $email,
            'password_hash' => PembeliModel::hashPassword($plain),
        ], true);

        if (! $id) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal. Coba lagi.');
        }

        // Bawa parameter redirect ke halaman login jika user datang dari halaman pesan
        $loginUrl = base_url('login');
        if (!empty($redirectTarget)) {
            $loginUrl .= '?redirect=' . urlencode($redirectTarget);
        }

        return redirect()->to($loginUrl)->with('message', 'Akun berhasil dibuat! Silakan masuk menggunakan email dan kata sandi Anda.');
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
            'checkout_tanggal',
            'tanggal_dibutuhkan',
            'tanggal_pesanan',
            'checkout_metode',
            'checkout_catatan',
            'checkout_nama',
            'checkout_nomor_hp',
            'checkout_catatan_pemesan',
            'checkout_alamat',
            'checkout_catatan_kurir',
            'checkout_alamat_lat',
            'checkout_alamat_lng',
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

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $pembeliModel->update($pembeli['id'], [
            'reset_token'            => $token,
            'reset_token_expires_at' => $expiresAt,
        ]);

        $resetUrl = base_url('reset-password/' . $token);

        // TODO: ganti dengan pengiriman email asli setelah SMTP siap
        $infoMsg = 'Karena email belum aktif, gunakan link ini: <a href="' . $resetUrl . '">' . $resetUrl . '</a>';

        return redirect()->back()->with('info', $infoMsg);
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