<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHargaVarianPesanAntar extends Migration
{
    public function up()
    {
        // 1. Tambah kolom harga pada varian_produk jika belum ada (additive)
        if (! $this->db->fieldExists('harga', 'varian_produk')) {
            $this->forge->addColumn('varian_produk', [
                'harga' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '12,2',
                    'null'       => true,
                    'after'      => 'nama_varian',
                ],
            ]);
        }

        // 2. Insert/Update varian berat untuk Siomay Kukus (produk_id = 1) & Tahu Kukus (produk_id = 4)
        $targetKgProducts = [1, 4];
        $kgVarians = [
            ['nama_varian' => '1/2 kg', 'harga' => 40000.00],
            ['nama_varian' => '1 kg',   'harga' => 80000.00],
            ['nama_varian' => '3 kg',   'harga' => 240000.00],
            ['nama_varian' => '5 kg',   'harga' => 400000.00],
        ];

        foreach ($targetKgProducts as $pId) {
            foreach ($kgVarians as $v) {
                $exists = $this->db->table('varian_produk')
                    ->where('produk_id', $pId)
                    ->where('nama_varian', $v['nama_varian'])
                    ->get()->getRowArray();

                if (! $exists) {
                    $this->db->table('varian_produk')->insert([
                        'produk_id'   => $pId,
                        'nama_varian' => $v['nama_varian'],
                        'harga'       => $v['harga'],
                    ]);
                } else {
                    $this->db->table('varian_produk')
                        ->where('id', $exists['id'])
                        ->update(['harga' => $v['harga']]);
                }
            }
        }

        // 3. Insert/Update varian Mentah & Masak untuk Siomay Keju (7), Siomay Isi Telur (8), Siomay Urat (9)
        $targetPcsProducts = [7, 8, 9];
        $pcsVarians = [
            ['nama_varian' => 'Mentah', 'harga' => 2000.00],
            ['nama_varian' => 'Masak',  'harga' => 2000.00],
        ];

        foreach ($targetPcsProducts as $pId) {
            foreach ($pcsVarians as $v) {
                $exists = $this->db->table('varian_produk')
                    ->where('produk_id', $pId)
                    ->where('nama_varian', $v['nama_varian'])
                    ->get()->getRowArray();

                if (! $exists) {
                    $this->db->table('varian_produk')->insert([
                        'produk_id'   => $pId,
                        'nama_varian' => $v['nama_varian'],
                        'harga'       => $v['harga'],
                    ]);
                } else {
                    $this->db->table('varian_produk')
                        ->where('id', $exists['id'])
                        ->update(['harga' => $v['harga']]);
                }
            }
        }

        // Update harga varian Lumpia (produk_id = 2) jika ada
        $this->db->table('varian_produk')
            ->where('produk_id', 2)
            ->update(['harga' => 2000.00]);

        // 4. Cek hapus duplikat Lumpia Ayam Sayur jika ada
        $duplikat = $this->db->table('produk')
            ->like('nama', 'Lumpia Ayam Sayur')
            ->get()->getResultArray();

        foreach ($duplikat as $dup) {
            $ref1 = $this->db->table('item_pesanan')->where('produk_id', $dup['id'])->countAllResults();
            $ref2 = $this->db->table('item_pesanan_acara')->where('produk_id', $dup['id'])->countAllResults();
            if ($ref1 === 0 && $ref2 === 0) {
                $this->db->table('varian_produk')->where('produk_id', $dup['id'])->delete();
                $this->db->table('produk')->where('id', $dup['id'])->delete();
            }
        }
    }

    public function down()
    {
        // Additive migration, roll back Column if needed
        if ($this->db->fieldExists('harga', 'varian_produk')) {
            $this->forge->dropColumn('varian_produk', 'harga');
        }
    }
}
