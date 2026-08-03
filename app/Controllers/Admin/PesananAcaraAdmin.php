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
        $excludeStatus = ['menunggu_pembayaran', 'dibatalkan', 'gagal', 'kedaluwarsa'];
        $builder = $this->db->table('pesanan_acara')->whereNotIn('status_pembayaran', $excludeStatus);

        if ($tab === 'ambil_sendiri') {
            $builder->where('metode_pengambilan', 'ambil_sendiri');
        } elseif ($tab === 'maxim') {
            $builder->where('metode_pengambilan', 'diantar');
        }

        $pesanan = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        // Attach items safely
        foreach ($pesanan as &$p) {
            $items = [];
            try {
                if ($this->db->tableExists('item_pesanan_acara')) {
                    $builderItems = $this->db->table('item_pesanan_acara i')
                        ->select('i.*, pr.nama as produk_nama')
                        ->join('produk pr', 'pr.id = i.produk_id', 'left');

                    if ($this->db->fieldExists('varian_id', 'item_pesanan_acara') && $this->db->tableExists('varian_produk')) {
                        $builderItems->select('v.nama_varian')
                                     ->join('varian_produk v', 'v.id = i.varian_id', 'left');
                    }

                    $items = $builderItems->where('i.pesanan_acara_id', $p['id'])->get()->getResultArray();
                }
            } catch (\Throwable $e) {
                log_message('error', 'PesananAcaraAdmin item query error: ' . $e->getMessage());
            }
            $p['items'] = $items;
        }

        // Tab counts (only paid/valid orders)
        $countSemua = $this->db->table('pesanan_acara')->whereNotIn('status_pembayaran', $excludeStatus)->countAllResults();
        $countAmbil = $this->db->table('pesanan_acara')->whereNotIn('status_pembayaran', $excludeStatus)->where('metode_pengambilan', 'ambil_sendiri')->countAllResults();
        $countMaxim = $this->db->table('pesanan_acara')->whereNotIn('status_pembayaran', $excludeStatus)->where('metode_pengambilan', 'diantar')->countAllResults();

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
        if (!in_array($status, ['diproses', 'dikonfirmasi', 'lunas', 'diantar', 'dikirim', 'selesai', 'dibatalkan'], true)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->db->table('pesanan_acara')->where('id', $id)->update(['status_pembayaran' => $status]);

        return redirect()->back()->with('success', 'Status pesanan acara berhasil diperbarui.');
    }

    public function kirimMaxim(int $id)
    {
        $pesanan = $this->db->table('pesanan_acara')->where('id', $id)->get()->getRowArray();
        if (!$pesanan) {
            return redirect()->back()->with('error', 'Pesanan acara tidak ditemukan.');
        }

        $maximRef = 'MAX-ACARA-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

        $this->db->table('pesanan_acara')->where('id', $id)->update([
            'status_pembayaran' => 'diantar'
        ]);

        return redirect()->back()->with('success', 'Berhasil terhubung ke API Maxim! Booking Order Acara: ' . $maximRef . '. Driver Maxim akan segera menuju lokasi.');
    }
}
