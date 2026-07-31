<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;

class Qris extends BaseController
{
    public function index()
    {
        $pengaturan = (new PengaturanModel())->getSingleton();

        $data = [
            'title'       => 'Tampilkan QRIS — Siomay Dua Putri',
            'pengaturan'  => $pengaturan,
            'qrisImg'     => base_url('assets/img/qris.jpeg'),
        ];

        return view('qris/index', $data);
    }
}
