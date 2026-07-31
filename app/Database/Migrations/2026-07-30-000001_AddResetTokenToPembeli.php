<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResetTokenToPembeli extends Migration
{
    public function up()
    {
        $fields = [
            'reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'password_hash',
            ],
            'reset_token_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'reset_token',
            ],
        ];

        if (! $this->db->fieldExists('reset_token', 'pembeli')) {
            $this->forge->addColumn('pembeli', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('reset_token', 'pembeli')) {
            $this->forge->dropColumn('pembeli', ['reset_token', 'reset_token_expires_at']);
        }
    }
}
