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

        // 1. Pesanan Antar Reguler
        $rowsAntar = $db->table('pesanan')
            ->select('id, kode_pesanan, metode, "pesan_antar" AS tipe_layanan, created_at, total, status')
            ->where('pembeli_id', $pembeliId)
            ->get()
            ->getResultArray();

        // 2. Pesanan Acara
        $rowsAcara = $db->table('pesanan_acara')
            ->select('id, kode_booking AS kode_pesanan, metode_pengambilan AS metode, "pesan_acara" AS tipe_layanan, created_at, total, status_pembayaran AS status')
            ->where('pembeli_id', $pembeliId)
            ->get()
            ->getResultArray();

        // Merge & Sort Descending by created_at
        $allOrders = array_merge($rowsAntar, $rowsAcara);
        usort($allOrders, function ($a, $b) {
            return strtotime($b['created_at'] ?? '0') - strtotime($a['created_at'] ?? '0');
        });

        return view('auth/pembeli/riwayat', [
            'pembeliNama'  => session()->get('pembeli_nama'),
            'pembeliEmail' => session()->get('pembeli_email'),
            'pesanan'      => $allOrders,
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

        // Cek di tabel pesanan (Pesan Antar)
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kodePesanan)
            ->where('pembeli_id', $pembeliId)
            ->get()
            ->getRowArray();

        if ($pesanan) {
            $pesanan['tipe_layanan'] = 'pesan_antar';

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

        // Fallback: Cek di tabel pesanan_acara (Pesan Acara)
        $pesananAcara = $db->table('pesanan_acara')
            ->where('kode_booking', $kodePesanan)
            ->where('pembeli_id', $pembeliId)
            ->get()
            ->getRowArray();

        if (! $pesananAcara) {
            return redirect()->to('/akun/riwayat')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Normalisasi array untuk pesanan acara
        $pesananNormalized = [
            'tipe_layanan'    => 'pesan_acara',
            'kode_pesanan'    => $pesananAcara['kode_booking'],
            'nama_pembeli'    => $pesananAcara['nama_pemesan'],
            'nomor_hp'        => $pesananAcara['nomor_hp'],
            'metode'          => $pesananAcara['metode_pengambilan'],
            'lokasi'          => null,
            'ruangan'         => null,
            'alamat'          => $pesananAcara['alamat'],
            'patokan_maxim'   => $pesananAcara['patokan_maxim'],
            'tanggal_acara'   => $pesananAcara['tanggal_acara'],
            'catatan'         => $pesananAcara['catatan'],
            'subtotal'        => (float) $pesananAcara['subtotal'],
            'ongkir'          => 0.0,
            'total'           => (float) $pesananAcara['total'],
            'status'          => $pesananAcara['status_pembayaran'],
            'created_at'      => $pesananAcara['created_at'],
        ];

        $itemsAcaraRaw = $db->table('item_pesanan_acara ipa')
            ->select('ipa.jumlah, ipa.harga_satuan_snapshot AS harga_satuan, ipa.subtotal_item, p.nama AS produk_nama')
            ->join('produk p', 'p.id = ipa.produk_id', 'left')
            ->where('ipa.pesanan_acara_id', (int) $pesananAcara['id'])
            ->get()
            ->getResultArray();

        $itemsNormalized = [];
        foreach ($itemsAcaraRaw as $it) {
            $itemsNormalized[] = [
                'produk_nama'   => $it['produk_nama'],
                'nama_varian'   => '',
                'jumlah'        => $it['jumlah'],
                'harga_satuan'  => $it['harga_satuan'],
                'subtotal_item' => $it['subtotal_item'],
            ];
        }

        return view('auth/pembeli/detail', [
            'title'   => 'Detail Pesanan Acara #' . $kodePesanan,
            'pesanan' => $pesananNormalized,
            'items'   => $itemsNormalized,
        ]);
    }
}
