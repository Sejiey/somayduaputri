<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\PengaturanModel;

class Landing extends BaseController
{
    public function index(): string
    {
        $pengaturan = (new PengaturanModel())->getSingleton();

        // Footer kontak: ambil dari pengaturan kalau ada, fallback ke admin (nomor HP).
        $kontakAlamat = trim((string) ($pengaturan['alamat_umkm'] ?? ''));
        if ($kontakAlamat === '') {
            $kontakAlamat = '';
        }

        $kontakHp = '';
        if (! empty($pengaturan['admin_hp'] ?? null)) {
            $kontakHp = (string) $pengaturan['admin_hp'];
        } else {
            // Fallback: ambil dari admin yang baru saja login/terdaftar.
            $admin = (new AdminModel())->first();
            if ($admin && ! empty($admin['nomor_hp'])) {
                $kontakHp = (string) $admin['nomor_hp'];
            }
        }

        $isLoggedIn = (bool) session()->get('pembeli_id');
        $qrisUrl          = base_url('qris');
        $pesanAntarUrl    = $isLoggedIn ? base_url('etalase') : base_url('daftar');
        $pesanStandUrl    = $isLoggedIn ? base_url('pesan-stand/tentang') : base_url('daftar');
        $pesanSekarangUrl = $isLoggedIn ? base_url('etalase') : base_url('daftar');

        $data = [
            'title'            => 'Siomay Dua Putri — Siomay Segar Setiap Hari',
            'footerDeskripsi'  => 'Siomay & bakso ikan segar, dibuat setiap hari dengan bahan berkualitas.',
            'kontakAlamat'     => $kontakAlamat,
            'kontakHp'         => $kontakHp,
            'qrisUrl'          => $qrisUrl,
            'pesanAntarUrl'    => $pesanAntarUrl,
            'pesanStandUrl'    => $pesanStandUrl,
            'pesanSekarangUrl' => $pesanSekarangUrl,
        ];

        return view('landing/index', $data);
    }
}
