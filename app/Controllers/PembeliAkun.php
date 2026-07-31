<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PembeliAkun extends BaseController
{
    public function riwayat()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login untuk melihat riwayat pesanan.');
        }

        $db = \Config\Database::connect();
        $rows = $db->table('pesanan')
            ->select('id, kode_pesanan, metode, alamat, catatan, tanggal_dibutuhkan, subtotal, pajak, total, status, created_at')
            ->where('pembeli_id', $pembeliId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('auth/pembeli/riwayat', [
            'pembeliNama'  => session()->get('pembeli_nama'),
            'pembeliEmail' => session()->get('pembeli_email'),
            'pesanan'      => $rows,
        ]);
    }

    public function detail(string $kodePesanan)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login untuk melihat detail pesanan.');
        }

        $db = \Config\Database::connect();
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kodePesanan)
            ->where('pembeli_id', $pembeliId)
            ->get()
            ->getRowArray();

        if (! $pesanan) {
            return redirect()->to('/akun/riwayat')->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = $db->table('item_pesanan ip')
            ->select('ip.jumlah, ip.harga_satuan, ip.subtotal_item, p.nama AS produk_nama, vp.nama_varian')
            ->join('produk p', 'p.id = ip.produk_id', 'left')
            ->join('varian_produk vp', 'vp.id = ip.varian_id', 'left')
            ->where('ip.pesanan_id', (int) $pesanan['id'])
            ->get()
            ->getResultArray();

        return view('auth/pembeli/detail', [
            'title'   => 'Detail Pesanan #' . $kodePesanan,
            'pesanan' => $pesanan,
            'items'   => $items,
        ]);
    }
}
