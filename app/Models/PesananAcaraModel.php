<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananAcaraModel extends Model
{
    protected $table            = 'pesanan_acara';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = [
        'kode_booking',
        'pembeli_id',
        'nama_pemesan',
        'nomor_hp',
        'metode_pengambilan',
        'alamat',
        'patokan_maxim',
        'alamat_lat',
        'alamat_lng',
        'tanggal_acara',
        'catatan',
        'subtotal',
        'total',
        'snap_token',
        'status_pembayaran',
        'status_followup',
    ];
}
