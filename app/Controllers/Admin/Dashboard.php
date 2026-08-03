<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class Dashboard extends BaseController
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $today = date('Y-m-d');

        $excludeStatus = ['menunggu_pembayaran', 'dibatalkan', 'gagal', 'kedaluwarsa'];

        // 1. Stat Cards Data (Pesanan yang sudah lunas/berhasil)
        $antarTodayCount = $this->db->table('pesanan')
            ->where('DATE(created_at)', $today)
            ->whereNotIn('status', $excludeStatus)
            ->countAllResults();

        $antarBaruCount = $this->db->table('pesanan')
            ->where('DATE(created_at)', $today)
            ->whereIn('status', ['lunas', 'diproses'])
            ->countAllResults();

        // Pesan Acara (Aktif & Akan Datang)
        $acaraAktifCount = $this->db->table('pesanan_acara')
            ->whereNotIn('status_pembayaran', $excludeStatus)
            ->countAllResults();

        $acaraAkanDatangCount = $this->db->table('pesanan_acara')
            ->whereNotIn('status_pembayaran', $excludeStatus)
            ->where('tanggal_acara >=', $today)
            ->countAllResults();

        // Pendapatan Hari Ini
        $revAntarRow = $this->db->table('pesanan')
            ->selectSum('total')
            ->where('DATE(created_at)', $today)
            ->whereNotIn('status', $excludeStatus)
            ->get()->getRow();

        $revAcaraRow = $this->db->table('pesanan_acara')
            ->selectSum('total')
            ->where('DATE(created_at)', $today)
            ->whereNotIn('status_pembayaran', $excludeStatus)
            ->get()->getRow();

        $pendapatanToday = ($revAntarRow->total ?? 0) + ($revAcaraRow->total ?? 0);

        // Total Pesanan Semua Waktu
        $totalAntar = $this->db->table('pesanan')->whereNotIn('status', $excludeStatus)->countAllResults();
        $totalAcara = $this->db->table('pesanan_acara')->whereNotIn('status_pembayaran', $excludeStatus)->countAllResults();
        $totalPesananAll = $totalAntar + $totalAcara;

        // 2. Lists Recent Orders (Hanya yang sudah berhasil dibayar)
        $recentAntar = $this->db->table('pesanan')
            ->whereNotIn('status', $excludeStatus)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $recentAcara = $this->db->table('pesanan_acara')
            ->whereNotIn('status_pembayaran', $excludeStatus)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // 3. Ringkasan Keuangan (Bulan ini)
        $monthStart = date('Y-m-01');
        $revAntarMonth = $this->db->table('pesanan')
            ->selectSum('total')
            ->whereNotIn('status', $excludeStatus)
            ->where('created_at >=', $monthStart)
            ->get()->getRow()->total ?? 0;

        $revAcaraMonth = $this->db->table('pesanan_acara')
            ->selectSum('total')
            ->whereNotIn('status_pembayaran', $excludeStatus)
            ->where('created_at >=', $monthStart)
            ->get()->getRow()->total ?? 0;

        $totalPendapatanKotor = $revAntarMonth + $revAcaraMonth;

        $pengeluaranTotal = 0;
        if ($this->db->tableExists('pengeluaran')) {
            $pengeluaranRow = $this->db->table('pengeluaran')
                ->selectSum('jumlah')
                ->where('tanggal >=', $monthStart)
                ->get()->getRow();
            $pengeluaranTotal = $pengeluaranRow->jumlah ?? 0;
        }

        $labaBersih = $totalPendapatanKotor - $pengeluaranTotal;

        $data = [
            'title'                  => 'Dashboard Admin — Siomay Dua Putri',
            'antar_today_count'      => $antarTodayCount,
            'antar_baru_count'       => $antarBaruCount,
            'acara_aktif_count'      => $acaraAktifCount,
            'acara_akan_datang_count'=> $acaraAkanDatangCount,
            'pendapatan_today'       => $pendapatanToday,
            'total_pesanan_all'      => $totalPesananAll,
            'recent_antar'           => $recentAntar,
            'recent_acara'           => $recentAcara,
            'pendapatan_kotor'       => $totalPendapatanKotor,
            'total_pengeluaran'      => $pengeluaranTotal,
            'laba_bersih'            => $labaBersih,
            'total_transaksi'        => $totalPesananAll,
        ];

        return view('admin/dashboard', $data);
    }
}