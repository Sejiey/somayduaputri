<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananAcaraModel extends Model
{
    protected $table            = 'pesanan_acara';
    protected $primaryKey       = 'id';
    protected $returnType        = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = [
        'kode_booking',
        'pembeli_id',
        'nama_pemesan',
        'nomor_hp',
        'jenis_acara',
        'nama_acara',
        'tanggal_acara',
        'lokasi_acara',
        'estimasi_porsi',
        'catatan',
        'subtotal',
        'biaya_stand',
        'total',
        'status_pembayaran',
        'status_followup',
    ];
}
