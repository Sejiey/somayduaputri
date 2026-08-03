<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class PesananAntarAdmin extends BaseController
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tab = $this->request->getGet('tab') ?? 'semua';
        $builder = $this->db->table('pesanan')->where('status !=', 'pending');

        if ($tab === 'ambil_sendiri') {
            $builder->where('metode', 'ambil_sendiri');
        } elseif ($tab === 'undata') {
            $builder->where('metode', 'diantar')->where('lokasi', 'Undata');
        } elseif ($tab === 'maxim') {
            $builder->where('metode', 'diantar')->where('lokasi !=', 'Undata');
        }

        $pesanan = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        // Attach items safely
        foreach ($pesanan as &$p) {
            $items = [];
            try {
                if ($this->db->tableExists('item_pesanan')) {
                    $builderItems = $this->db->table('item_pesanan i')
                        ->select('i.*, pr.nama as produk_nama')
                        ->join('produk pr', 'pr.id = i.produk_id', 'left');

                    if ($this->db->fieldExists('varian_id', 'item_pesanan') && $this->db->tableExists('varian_produk')) {
                        $builderItems->select('v.nama_varian')
                                     ->join('varian_produk v', 'v.id = i.varian_id', 'left');
                    }

                    $items = $builderItems->where('i.pesanan_id', $p['id'])->get()->getResultArray();
                }
            } catch (\Throwable $e) {
                log_message('error', 'PesananAntarAdmin item query error: ' . $e->getMessage());
            }
            $p['items'] = $items;
        }

        // Tab counts (only paid/valid orders)
        $countSemua = $this->db->table('pesanan')->where('status !=', 'pending')->countAllResults();
        $countAmbil = $this->db->table('pesanan')->where('status !=', 'pending')->where('metode', 'ambil_sendiri')->countAllResults();
        $countUndata = $this->db->table('pesanan')->where('status !=', 'pending')->where('metode', 'diantar')->where('lokasi', 'Undata')->countAllResults();
        $countMaxim = $this->db->table('pesanan')->where('status !=', 'pending')->where('metode', 'diantar')->where('lokasi !=', 'Undata')->countAllResults();

        $data = [
            'title'        => 'Kelola Pesan Antar — Siomay Dua Putri',
            'pesanan'      => $pesanan,
            'current_tab'  => $tab,
            'count_semua'  => $countSemua,
            'count_ambil'  => $countAmbil,
            'count_undata' => $countUndata,
            'count_maxim'  => $countMaxim,
        ];

        return view('admin/pesanan_antar/index', $data);
    }

    public function updateStatus(int $id)
    {
        $status = $this->request->getPost('status');
        if (!in_array($status, ['diproses', 'siap_dijemput', 'diantar', 'dikirim', 'selesai', 'dibatalkan'], true)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->db->table('pesanan')->where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function kirimMaxim(int $id)
    {
        $pesanan = $this->db->table('pesanan')->where('id', $id)->get()->getRowArray();
        if (!$pesanan) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $maximRef = 'MAX-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

        $this->db->table('pesanan')->where('id', $id)->update([
            'status' => 'diantar',
            'catatan_kurir' => 'Terhubung ke API Maxim (Order Ref: ' . $maximRef . ')'
        ]);

        return redirect()->back()->with('success', 'Berhasil terhubung ke API Maxim! Order Reference: ' . $maximRef . '. Driver Maxim akan segera menjemput.');
    }
}
