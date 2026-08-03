<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class PesananAcaraAdmin extends BaseController
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tab = $this->request->getGet('tab') ?? 'semua';
        $builder = $this->db->table('pesanan_acara')->where('status_pembayaran !=', 'pending');

        if ($tab === 'ambil_sendiri') {
            $builder->where('metode_pengambilan', 'ambil_sendiri');
        } elseif ($tab === 'maxim') {
            $builder->where('metode_pengambilan', 'diantar');
        }

        $pesanan = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        // Attach items
        foreach ($pesanan as &$p) {
            $items = [];
            if ($this->db->tableExists('item_pesanan_acara')) {
                $items = $this->db->table('item_pesanan_acara i')
                    ->select('i.*, pr.nama as produk_nama, v.nama_varian')
                    ->join('produk pr', 'pr.id = i.produk_id', 'left')
                    ->join('varian_produk v', 'v.id = i.varian_id', 'left')
                    ->where('i.pesanan_acara_id', $p['id'])
                    ->get()->getResultArray();
            }
            $p['items'] = $items;
        }

        // Tab counts (only paid/valid orders)
        $countSemua = $this->db->table('pesanan_acara')->where('status_pembayaran !=', 'pending')->countAllResults();
        $countAmbil = $this->db->table('pesanan_acara')->where('status_pembayaran !=', 'pending')->where('metode_pengambilan', 'ambil_sendiri')->countAllResults();
        $countMaxim = $this->db->table('pesanan_acara')->where('status_pembayaran !=', 'pending')->where('metode_pengambilan', 'diantar')->countAllResults();

        $data = [
            'title'        => 'Kelola Pesan Acara — Siomay Dua Putri',
            'pesanan'      => $pesanan,
            'current_tab'  => $tab,
            'count_semua'  => $countSemua,
            'count_ambil'  => $countAmbil,
            'count_maxim'  => $countMaxim,
        ];

        return view('admin/pesanan_acara/index', $data);
    }

    public function updateStatus(int $id)
    {
        $status = $this->request->getPost('status');
        if (!in_array($status, ['diproses', 'dikonfirmasi', 'lunas', 'dikirim', 'selesai', 'dibatalkan'], true)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->db->table('pesanan_acara')->where('id', $id)->update(['status_pembayaran' => $status]);

        return redirect()->back()->with('success', 'Status pesanan acara berhasil diperbarui.');
    }
}
