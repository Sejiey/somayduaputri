<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCheckoutFieldsToPesanan extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('lokasi', 'pesanan')) {
            $this->forge->addColumn('pesanan', [
                'lokasi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'metode',
                ],
            ]);
        }

        if (! $this->db->fieldExists('ruangan', 'pesanan')) {
            $this->forge->addColumn('pesanan', [
                'ruangan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'alamat',
                ],
            ]);
        }

        if (! $this->db->fieldExists('ongkir', 'pesanan')) {
            $this->forge->addColumn('pesanan', [
                'ongkir' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '12,2',
                    'default'    => 0,
                    'null'       => false,
                    'after'      => 'subtotal',
                ],
            ]);
        }

        if (! $this->db->fieldExists('snap_token', 'pesanan')) {
            $this->forge->addColumn('pesanan', [
                'snap_token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'total',
                ],
            ]);
        }

        if ($this->db->tableExists('pengaturan')) {
            $this->db->table('pengaturan')->where('id >', 0)->update(['minimum_order' => 50000.00]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('lokasi', 'pesanan')) {
            $this->forge->dropColumn('pesanan', ['lokasi']);
        }
        if ($this->db->fieldExists('ruangan', 'pesanan')) {
            $this->forge->dropColumn('pesanan', ['ruangan']);
        }
        if ($this->db->fieldExists('ongkir', 'pesanan')) {
            $this->forge->dropColumn('pesanan', ['ongkir']);
        }
        if ($this->db->fieldExists('snap_token', 'pesanan')) {
            $this->forge->dropColumn('pesanan', ['snap_token']);
        }
    }
}
