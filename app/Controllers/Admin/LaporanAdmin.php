<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class LaporanAdmin extends BaseController
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $dari   = $this->request->getGet('dari') ?? date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?? date('Y-m-d');
        $tab    = $this->request->getGet('tab') ?? 'semua';

        // 1. Total Metrics
        $revAntarRow = $this->db->table('pesanan')
            ->selectSum('total')
            ->where('status', 'lunas')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->get()->getRow();

        $revAcaraRow = $this->db->table('pesanan_acara')
            ->selectSum('total')
            ->where('status_pembayaran', 'lunas')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->get()->getRow();

        $totalPendapatanAntar = $revAntarRow->total ?? 0;
        $totalPendapatanAcara = $revAcaraRow->total ?? 0;
        $totalPendapatan      = $totalPendapatanAntar + $totalPendapatanAcara;

        $pengeluaranTotal = 0;
        if ($this->db->tableExists('pengeluaran')) {
            $pengeluaranRow = $this->db->table('pengeluaran')
                ->selectSum('jumlah')
                ->where('tanggal >=', $dari)
                ->where('tanggal <=', $sampai)
                ->get()->getRow();
            $pengeluaranTotal = $pengeluaranRow->jumlah ?? 0;
        }

        $labaBersih = $totalPendapatan - $pengeluaranTotal;

        $countAntar = $this->db->table('pesanan')
            ->where('status', 'lunas')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->countAllResults();

        $countAcara = $this->db->table('pesanan_acara')
            ->where('status_pembayaran', 'lunas')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->countAllResults();

        $totalTransaksi = $countAntar + $countAcara;

        // 2. Chart Data 7 Hari Terakhir
        $chartDates = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-$i days"));
            $chartDates[] = date('d M', strtotime($d));

            $sum1 = $this->db->table('pesanan')
                ->selectSum('total')
                ->where('status', 'lunas')
                ->where('DATE(created_at)', $d)
                ->get()->getRow()->total ?? 0;

            $sum2 = $this->db->table('pesanan_acara')
                ->selectSum('total')
                ->where('status_pembayaran', 'lunas')
                ->where('DATE(created_at)', $d)
                ->get()->getRow()->total ?? 0;

            $chartData[] = (float)($sum1 + $sum2);
        }

        // 3. Rincian Table Data
        $rincian = [];
        // Group by Date for summary table
        for ($i = 0; $i < 7; $i++) {
            $d = date('Y-m-d', strtotime("-$i days"));

            $rev1 = $this->db->table('pesanan')
                ->selectSum('total')
                ->where('status', 'lunas')
                ->where('DATE(created_at)', $d)
                ->get()->getRow()->total ?? 0;

            $cnt1 = $this->db->table('pesanan')
                ->where('status', 'lunas')
                ->where('DATE(created_at)', $d)
                ->countAllResults();

            $rev2 = $this->db->table('pesanan_acara')
                ->selectSum('total')
                ->where('status_pembayaran', 'lunas')
                ->where('DATE(created_at)', $d)
                ->get()->getRow()->total ?? 0;

            $cnt2 = $this->db->table('pesanan_acara')
                ->where('status_pembayaran', 'lunas')
                ->where('DATE(created_at)', $d)
                ->countAllResults();

            if ($tab === 'semua' || $tab === 'pesan_antar') {
                if ($rev1 > 0 || $cnt1 > 0) {
                    $rincian[] = [
                        'tanggal'     => $d,
                        'kategori'    => 'Pesan Antar',
                        'pendapatan'  => $rev1,
                        'pengeluaran' => 0,
                        'laba'        => $rev1,
                        'transaksi'   => $cnt1,
                    ];
                }
            }

            if ($tab === 'semua' || $tab === 'pesan_acara') {
                if ($rev2 > 0 || $cnt2 > 0) {
                    $rincian[] = [
                        'tanggal'     => $d,
                        'kategori'    => 'Pesan Acara',
                        'pendapatan'  => $rev2,
                        'pengeluaran' => 0,
                        'laba'        => $rev2,
                        'transaksi'   => $cnt2,
                    ];
                }
            }
        }

        $data = [
            'title'                 => 'Laporan Keuangan — Siomay Dua Putri',
            'dari'                  => $dari,
            'sampai'                => $sampai,
            'current_tab'           => $tab,
            'total_pendapatan'      => $totalPendapatan,
            'total_pengeluaran'     => $pengeluaranTotal,
            'laba_bersih'           => $labaBersih,
            'total_transaksi'       => $totalTransaksi,
            'pendapatan_antar'      => $totalPendapatanAntar,
            'pendapatan_acara'      => $totalPendapatanAcara,
            'chart_dates'           => $chartDates,
            'chart_data'            => $chartData,
            'rincian'               => $rincian,
        ];

        return view('admin/laporan/index', $data);
    }

    public function export()
    {
        $dari   = $this->request->getGet('dari') ?? date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?? date('Y-m-d');

        $antar = $this->db->table('pesanan')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->get()->getResultArray();

        $acara = $this->db->table('pesanan_acara')
            ->where('DATE(created_at) >=', $dari)
            ->where('DATE(created_at) <=', $sampai)
            ->get()->getResultArray();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Laporan_Keuangan_'.$dari.'_'.$sampai.'.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Tipe Pesanan', 'Kode', 'Nama Pemesan', 'Tanggal', 'Metode', 'Total', 'Status']);

        foreach ($antar as $r) {
            fputcsv($output, ['Pesan Antar', $r['kode_pesanan'], $r['nama_pembeli'], $r['created_at'], $r['metode'], $r['total'], $r['status']]);
        }
        foreach ($acara as $a) {
            fputcsv($output, ['Pesan Acara', $a['kode_booking'], $a['nama_pemesan'], $a['created_at'], $a['metode_pengambilan'], $a['total'], $a['status_pembayaran']]);
        }

        fclose($output);
        exit;
    }
}
