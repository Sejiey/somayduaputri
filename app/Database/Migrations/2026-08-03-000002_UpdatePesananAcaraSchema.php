<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePesananAcaraSchema extends Migration
{
    public function up()
    {
        // 1. Alter tabel pesanan_acara
        if ($this->db->tableExists('pesanan_acara')) {
            $fieldsToDrop = [];
            foreach (['jenis_acara', 'nama_acara', 'lokasi_acara', 'estimasi_porsi', 'biaya_stand'] as $col) {
                if ($this->db->fieldExists($col, 'pesanan_acara')) {
                    $fieldsToDrop[] = $col;
                }
            }
            if (!empty($fieldsToDrop)) {
                $this->forge->dropColumn('pesanan_acara', $fieldsToDrop);
            }

            $fieldsToAdd = [];
            if (!$this->db->fieldExists('metode_pengambilan', 'pesanan_acara')) {
                $fieldsToAdd['metode_pengambilan'] = [
                    'type'       => 'ENUM',
                    'constraint' => ['diantar', 'ambil_sendiri'],
                    'default'    => 'diantar',
                    'null'       => false,
                    'after'      => 'nomor_hp',
                ];
            }
            if (!$this->db->fieldExists('alamat', 'pesanan_acara')) {
                $fieldsToAdd['alamat'] = [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'metode_pengambilan',
                ];
            }
            if (!$this->db->fieldExists('patokan_maxim', 'pesanan_acara')) {
                $fieldsToAdd['patokan_maxim'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'alamat',
                ];
            }
            if (!$this->db->fieldExists('alamat_lat', 'pesanan_acara')) {
                $fieldsToAdd['alamat_lat'] = [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,7',
                    'null'       => true,
                    'after'      => 'patokan_maxim',
                ];
            }
            if (!$this->db->fieldExists('alamat_lng', 'pesanan_acara')) {
                $fieldsToAdd['alamat_lng'] = [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,7',
                    'null'       => true,
                    'after'      => 'alamat_lat',
                ];
            }
            if (!$this->db->fieldExists('snap_token', 'pesanan_acara')) {
                $fieldsToAdd['snap_token'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'total',
                ];
            }

            if (!empty($fieldsToAdd)) {
                $this->forge->addColumn('pesanan_acara', $fieldsToAdd);
            }
        }

        // 2. Alter tabel pengaturan
        if ($this->db->tableExists('pengaturan')) {
            if ($this->db->fieldExists('biaya_stand', 'pengaturan')) {
                $this->forge->dropColumn('pengaturan', 'biaya_stand');
            }
        }
    }

    public function down()
    {
        // Revert pesanan_acara
        if ($this->db->tableExists('pesanan_acara')) {
            foreach (['metode_pengambilan', 'alamat', 'patokan_maxim', 'alamat_lat', 'alamat_lng', 'snap_token'] as $col) {
                if ($this->db->fieldExists($col, 'pesanan_acara')) {
                    $this->forge->dropColumn('pesanan_acara', $col);
                }
            }
        }
    }
}
