<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table         = 'pengeluaran';
    protected $primaryKey    = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    protected $allowedFields  = [
        'tanggal',
        'kategori',
        'deskripsi',
        'jumlah',
    ];

    protected $validationRules = [
        'tanggal'   => 'required|valid_date',
        'kategori'  => 'required|in_list[bahan_baku,operasional,lainnya]',
        'deskripsi' => 'required|max_length[255]',
        'jumlah'    => 'required|decimal|greater_than_equal_to[0]',
    ];
}
