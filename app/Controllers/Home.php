<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function bantuan()
    {
        $pengaturan = (new \App\Models\PengaturanModel())->getSingleton();
        $adminHp = (string) ($pengaturan['admin_hp'] ?? '');
        if ($adminHp === '') {
            $admin = (new \App\Models\AdminModel())->first();
            if ($admin && ! empty($admin['nomor_hp'])) {
                $adminHp = (string) $admin['nomor_hp'];
            }
        }
        $waNum = preg_replace('/[^0-9]/', '', $adminHp);
        if (str_starts_with($waNum, '0')) {
            $waNum = '62' . substr($waNum, 1);
        }
        $waUrl = $waNum !== '' ? "https://wa.me/" . $waNum . "?text=Halo%20penjual,%20saya%20butuh%20bantuan%20mengenai%20pesanan%20saya." : "#";

        return view('bantuan/index', [
            'title' => 'Bantuan — Siomay Dua Putri',
            'waUrl' => $waUrl,
        ]);
    }
}
