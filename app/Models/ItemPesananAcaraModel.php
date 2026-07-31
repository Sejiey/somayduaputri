<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemPesananAcaraModel extends Model
{
    protected $table            = 'item_pesanan_acara';
    protected $primaryKey       = 'id';
    protected $returnType        = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields    = [
        'pesanan_acara_id',
        'produk_id',
        'jumlah',
        'harga_satuan_snapshot',
        'subtotal_item',
    ];
}
