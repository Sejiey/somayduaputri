<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table         = 'pesanan';
    protected $primaryKey    = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $allowedFields  = [
        'kode_pesanan',
        'nama_pembeli',
        'nomor_hp',
        'metode',
        'pembeli_id',
        'alamat',
        'alamat_lat',
        'alamat_lng',
        'catatan',
        'tanggal_dibutuhkan',
        'subtotal',
        'pajak',
        'total',
        'status',
    ];

    protected $validationRules = [
        'kode_pesanan'        => 'required|max_length[50]',
        'nama_pembeli'        => 'required|max_length[255]',
        'nomor_hp'            => 'required|max_length[30]',
        'metode'              => 'required|max_length[30]',
        'pembeli_id'          => 'required|is_natural_no_zero',
        'tanggal_dibutuhkan'  => 'required|valid_date',
        'subtotal'            => 'required|decimal',
        'total'               => 'required|decimal',
        'status'              => 'required|max_length[20]',
    ];

    public function findByKode(string $kodePesanan): ?array
    {
        $row = $this->where('kode_pesanan', $kodePesanan)->first();
        return $row ?: null;
    }
}
