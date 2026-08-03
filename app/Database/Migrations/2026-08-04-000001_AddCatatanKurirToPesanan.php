<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatatanKurirToPesanan extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('catatan_kurir', 'pesanan')) {
            $this->forge->addColumn('pesanan', [
                'catatan_kurir' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'status',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('catatan_kurir', 'pesanan')) {
            $this->forge->dropColumn('pesanan', ['catatan_kurir']);
        }
    }
}
