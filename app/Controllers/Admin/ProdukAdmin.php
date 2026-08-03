<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\VarianProdukModel;

class ProdukAdmin extends BaseController
{
    protected ProdukModel $produk;
    protected VarianProdukModel $varian;

    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->varian = new VarianProdukModel();
    }

    public function index()
    {
        $tab = $this->request->getGet('tab') ?? 'semua';
        $builder = $this->produk->builder();

        if ($tab === 'aktif') {
            $builder->where('status_aktif', 1);
        } elseif ($tab === 'nonaktif') {
            $builder->where('status_aktif', 0);
        }

        $listProduk = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        // Attach varian
        foreach ($listProduk as &$p) {
            $p['varians'] = $this->varian->where('produk_id', $p['id'])->findAll();
        }

        // Tab counts
        $countSemua = $this->produk->countAllResults();
        $countAktif = $this->produk->where('status_aktif', 1)->countAllResults();
        $countNonaktif = $this->produk->where('status_aktif', 0)->countAllResults();

        $data = [
            'title'         => 'Produk / Menu — Siomay Dua Putri',
            'produk'        => $listProduk,
            'current_tab'   => $tab,
            'count_semua'   => $countSemua,
            'count_aktif'   => $countAktif,
            'count_nonaktif'=> $countNonaktif,
        ];

        return view('admin/produk/index', $data);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[2]|max_length[255]',
            'kategori' => 'required|max_length[50]',
            'harga'    => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon isi semua field dengan benar.');
        }

        $data = [
            'nama'         => $this->request->getPost('nama'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => (float) $this->request->getPost('harga'),
            'status_aktif' => $this->request->getPost('status_aktif') ? 1 : 0,
        ];

        $this->produk->insert($data);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $p = $this->produk->find($id);
        if (!$p) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'nama'         => $this->request->getPost('nama'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => (float) $this->request->getPost('harga'),
            'status_aktif' => $this->request->getPost('status_aktif') ? 1 : 0,
        ];

        $this->produk->update($id, $data);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $db = \Config\Database::connect();
        
        // Disable FK checks temporarily for physical deletion
        $db->query('SET FOREIGN_KEY_CHECKS=0;');
        
        if ($db->tableExists('item_pesanan_acara')) {
            $db->table('item_pesanan_acara')->where('produk_id', $id)->delete();
        }
        if ($db->tableExists('item_pesanan')) {
            $db->table('item_pesanan')->where('produk_id', $id)->delete();
        }
        if ($db->tableExists('varian_produk')) {
            $db->table('varian_produk')->where('produk_id', $id)->delete();
        }
        
        $this->produk->delete($id);
        
        $db->query('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->back()->with('success', 'Produk berhasil dihapus secara permanen dari etalase.');
    }

    public function toggleStatus(int $id)
    {
        $p = $this->produk->find($id);
        if ($p) {
            $newStatus = $p['status_aktif'] ? 0 : 1;
            $this->produk->update($id, ['status_aktif' => $newStatus]);
        }
        return redirect()->back()->with('success', 'Status ketersediaan produk berhasil diubah.');
    }
}
