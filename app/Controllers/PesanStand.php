<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\PengaturanModel;
use App\Models\PesananAcaraModel;
use App\Models\ProdukModel;
use App\Models\VarianProdukModel;
use App\Services\MidtransService;

class PesanStand extends BaseController
{
    // ====================================================================
    // STEP 0: Tentang Pesan untuk Acara
    // ====================================================================
    public function tentang()
    {
        $data = [
            'title' => 'Tentang Pesan untuk Acara — Siomay Dua Putri',
        ];
        return view('pesan_stand/tentang', $data);
    }

    // ====================================================================
    // STEP 1: Form Menu & Metode Pengambilan
    // ====================================================================
    public function menu()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu untuk pesan menu acara.');
        }

        $db = \Config\Database::connect();
        $produkList = $db->table('produk')
            ->where('tampil_di_pesan_stand', 1)
            ->where('status_aktif', 1)
            ->orderBy('kategori', 'ASC')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();

        foreach ($produkList as &$p) {
            $p['varians'] = $db->table('varian_produk')
                ->where('produk_id', (int) $p['id'])
                ->get()->getResultArray();
        }

        $sessionOrder = session('pesan_stand_order') ?? [];

        $data = [
            'title'        => 'Pilih Menu & Metode — Pesan untuk Acara',
            'produkList'   => $produkList,
            'sessionOrder' => $sessionOrder,
        ];
        return view('pesan_stand/menu', $data);
    }

    public function saveMenu()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $metode = (string) $this->request->getPost('metode_pengambilan');
        if (! in_array($metode, ['diantar', 'ambil_sendiri'], true)) {
            $metode = 'diantar';
        }

        $catatan = trim((string) $this->request->getPost('catatan'));
        $rawItems = (array) $this->request->getPost('items');

        if (empty($rawItems)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal 1 menu acara untuk melanjutkan.');
        }

        $db = \Config\Database::connect();
        $selectedItems = [];

        foreach ($rawItems as $produkId => $itemData) {
            $pId = (int) $produkId;
            $qty = (float) ($itemData['qty'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            // Validasi langsung dari Database
            $produk = $db->table('produk')
                ->where('id', $pId)
                ->where('tampil_di_pesan_stand', 1)
                ->where('status_aktif', 1)
                ->get()->getRowArray();

            if (! $produk) {
                continue;
            }

            $varianId = ! empty($itemData['varian_id']) ? (int) $itemData['varian_id'] : null;
            $harga = (float) $produk['harga'];
            $varianNama = '';

            if ($varianId) {
                $varian = $db->table('varian_produk')
                    ->where('id', $varianId)
                    ->where('produk_id', $pId)
                    ->get()->getRowArray();

                if ($varian) {
                    $harga = (float) $varian['harga'];
                    $varianNama = (string) $varian['nama_varian'];
                }
            }

            $selectedItems[$pId] = [
                'produk_id'   => $pId,
                'nama'        => $produk['nama'],
                'varian_id'   => $varianId,
                'varian_nama' => $varianNama,
                'harga'       => $harga,
                'qty'         => $qty,
                'subtotal'    => $harga * $qty,
            ];
        }

        if (empty($selectedItems)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal 1 menu acara yang valid.');
        }

        $orderData = [
            'metode_pengambilan' => $metode,
            'catatan'            => $catatan,
            'items'              => $selectedItems,
        ];

        session()->set('pesan_stand_order', $orderData);

        return redirect()->to('/pesan-stand/data-pemesan');
    }

    // ====================================================================
    // STEP 2: Data Pemesan & Tanggal Acara
    // ====================================================================
    public function dataPemesan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderData = session('pesan_stand_order');
        if (empty($orderData) || empty($orderData['items'])) {
            return redirect()->to('/pesan-stand/menu')->with('error', 'Silakan pilih menu acara terlebih dahulu.');
        }

        $besok = (new \DateTime('tomorrow'))->format('Y-m-d');
        $sessionBiodata = session('pesan_stand_biodata') ?? [];

        $data = [
            'title'          => 'Data Pemesan — Pesan untuk Acara',
            'besok'          => $besok,
            'orderData'      => $orderData,
            'sessionBiodata' => $sessionBiodata,
            'pembeliNama'    => session('pembeli_nama') ?? '',
        ];
        return view('pesan_stand/data_pemesan', $data);
    }

    public function saveDataPemesan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderData = session('pesan_stand_order');
        if (empty($orderData) || empty($orderData['items'])) {
            return redirect()->to('/pesan-stand/menu')->with('error', 'Silakan pilih menu acara terlebih dahulu.');
        }

        $namaPemesan  = trim((string) $this->request->getPost('nama_pemesan'));
        $nomorHp      = trim((string) $this->request->getPost('nomor_hp'));
        $tanggalAcara = (string) $this->request->getPost('tanggal_acara');
        $metode       = $orderData['metode_pengambilan'] ?? 'diantar';

        if ($namaPemesan === '' || $nomorHp === '' || $tanggalAcara === '') {
            return redirect()->back()->withInput()->with('error', 'Nama pemesan, no WhatsApp, dan tanggal acara wajib diisi.');
        }

        $today = (new \DateTime('today'))->format('Y-m-d');
        if ($tanggalAcara <= $today) {
            return redirect()->back()->withInput()->with('error', 'Tanggal acara harus minimal H+1 (mulai besok).');
        }

        $patokanMaxim = null;
        $alamat       = null;
        $alamatLat    = null;
        $alamatLng    = null;

        if ($metode === 'diantar') {
            $patokanMaxim = trim((string) $this->request->getPost('patokan_maxim'));
            $alamat       = trim((string) $this->request->getPost('alamat'));
            $alamatLat    = $this->request->getPost('alamat_lat') !== null && $this->request->getPost('alamat_lat') !== '' ? (float) $this->request->getPost('alamat_lat') : null;
            $alamatLng    = $this->request->getPost('alamat_lng') !== null && $this->request->getPost('alamat_lng') !== '' ? (float) $this->request->getPost('alamat_lng') : null;

            if ($alamat === '') {
                return redirect()->back()->withInput()->with('error', 'Alamat pengantaran wajib diisi untuk metode Diantar.');
            }
        }

        $biodataData = [
            'nama_pemesan'  => $namaPemesan,
            'nomor_hp'      => $nomorHp,
            'tanggal_acara' => $tanggalAcara,
            'patokan_maxim' => $patokanMaxim,
            'alamat'        => $alamat,
            'alamat_lat'    => $alamatLat,
            'alamat_lng'    => $alamatLng,
        ];

        session()->set('pesan_stand_biodata', $biodataData);

        return redirect()->to('/pesan-stand/ringkasan');
    }

    // ====================================================================
    // STEP 3: Ringkasan Pesanan Acara
    // ====================================================================
    public function ringkasan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderData   = session('pesan_stand_order');
        $biodataData = session('pesan_stand_biodata');

        if (empty($orderData) || empty($orderData['items']) || empty($biodataData)) {
            return redirect()->to('/pesan-stand/menu')->with('error', 'Silakan lengkapi data pesanan dan pemesan.');
        }

        $subtotal = 0.0;
        foreach ($orderData['items'] as $item) {
            $subtotal += (float) $item['subtotal'];
        }

        $total = $subtotal; // Tanpa ongkir/biaya stand

        $data = [
            'title'       => 'Ringkasan Pesanan — Pesan untuk Acara',
            'orderData'   => $orderData,
            'biodataData' => $biodataData,
            'subtotal'    => $subtotal,
            'total'       => $total,
        ];

        return view('pesan_stand/ringkasan', $data);
    }

    // ====================================================================
    // SIMPAN BOOKING & GENERATE SNAP TOKEN PRE-TRANSACTION
    // ====================================================================
    public function simpanBooking()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderData   = session('pesan_stand_order');
        $biodataData = session('pesan_stand_biodata');

        if (empty($orderData) || empty($orderData['items']) || empty($biodataData)) {
            return redirect()->to('/pesan-stand/menu')->with('error', 'Data pesanan tidak lengkap.');
        }

        $subtotal = 0.0;
        $itemsForSnap = [];
        $itemsToInsert = [];

        foreach ($orderData['items'] as $item) {
            $itemSub = (float) $item['subtotal'];
            $subtotal += $itemSub;

            $itemsForSnap[] = [
                'id'       => (string) $item['produk_id'],
                'price'    => (int) round($item['harga']),
                'quantity' => (int) round($item['qty']),
                'name'     => substr($item['nama'] . (!empty($item['varian_nama']) ? ' (' . $item['varian_nama'] . ')' : ''), 0, 50),
            ];

            $itemsToInsert[] = [
                'produk_id'             => (int) $item['produk_id'],
                'jumlah'                => (float) $item['qty'],
                'harga_satuan_snapshot' => (float) $item['harga'],
                'subtotal_item'         => $itemSub,
            ];
        }

        $total = $subtotal;
        $kodeBooking = 'STN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        // Customers for Midtrans
        $customerDetails = [
            'first_name' => $biodataData['nama_pemesan'],
            'phone'      => $biodataData['nomor_hp'],
        ];

        // 1. GENERATE SNAP TOKEN BEFORE DB TRANSACTION
        $snap = MidtransService::createSnapToken($kodeBooking, (int) round($total), $itemsForSnap, $customerDetails);

        if (! ($snap['ok'] ?? false)) {
            return redirect()->back()->with('error', 'Gagal menghubungkan ke pembayaran QRIS Midtrans: ' . ($snap['error'] ?? 'Terjadi kesalahan pada layanan pembayaran.'));
        }

        $snapToken = (string) $snap['token'];

        // 2. ATOMIC DB TRANSACTION AFTER TOKEN VERIFIED
        $db = \Config\Database::connect();
        $db->transStart();

        $pesananAcaraData = [
            'kode_booking'       => $kodeBooking,
            'pembeli_id'         => $pembeliId,
            'nama_pemesan'       => $biodataData['nama_pemesan'],
            'nomor_hp'           => $biodataData['nomor_hp'],
            'metode_pengambilan' => $orderData['metode_pengambilan'],
            'alamat'             => $biodataData['alamat'],
            'patokan_maxim'      => $biodataData['patokan_maxim'],
            'alamat_lat'         => $biodataData['alamat_lat'],
            'alamat_lng'         => $biodataData['alamat_lng'],
            'tanggal_acara'      => $biodataData['tanggal_acara'],
            'catatan'            => $orderData['catatan'] !== '' ? $orderData['catatan'] : null,
            'subtotal'           => $subtotal,
            'total'              => $total,
            'snap_token'         => $snapToken,
            'status_pembayaran'  => 'menunggu_pembayaran',
            'status_followup'    => 'baru',
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $pesananAcaraModel = new PesananAcaraModel();
        $pesananAcaraId = $pesananAcaraModel->insert($pesananAcaraData, true);

        foreach ($itemsToInsert as &$it) {
            $it['pesanan_acara_id'] = (int) $pesananAcaraId;
            $db->table('item_pesanan_acara')->insert($it);
        }

        // Insert ke tabel transaksi
        $db->table('transaksi')->insert([
            'pesanan_acara_id'  => (int) $pesananAcaraId,
            'midtrans_order_id' => $kodeBooking,
            'status_pembayaran' => 'pending',
            'mdr_persen'        => 0.0,
            'nominal_diterima'  => 0.0,
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan ke database. Silakan coba lagi.');
        }

        session()->remove(['pesan_stand_order', 'pesan_stand_biodata']);

        return redirect()->to('/pesan-stand/pembayaran/' . $kodeBooking);
    }

    // ====================================================================
    // STEP 4: Halaman Pembayaran QRIS
    // ====================================================================
    public function pembayaran(string $kodeBooking)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pesananAcaraModel = new PesananAcaraModel();
        $booking = $pesananAcaraModel
            ->where('kode_booking', $kodeBooking)
            ->where('pembeli_id', $pembeliId)
            ->first();

        if (! $booking) {
            return redirect()->to('/pesan-stand/tentang')->with('error', 'Data booking pesanan acara tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $items = $db->table('item_pesanan_acara ipa')
            ->select('ipa.jumlah, ipa.harga_satuan_snapshot, ipa.subtotal_item, p.nama AS produk_nama, p.kategori')
            ->join('produk p', 'p.id = ipa.produk_id', 'left')
            ->where('ipa.pesanan_acara_id', (int) $booking['id'])
            ->get()->getResultArray();

        $data = [
            'title'      => 'Pembayaran QRIS — Pesan untuk Acara',
            'booking'    => $booking,
            'items'      => $items,
            'snapToken'  => $booking['snap_token'],
            'clientKey'  => env('MIDTRANS_CLIENT_KEY'),
        ];

        return view('pesan_stand/pembayaran', $data);
    }

    // ====================================================================
    // STEP 5: Konfirmasi Berhasil
    // ====================================================================
    public function berhasil(string $kodeBooking)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pesananAcaraModel = new PesananAcaraModel();
        $booking = $pesananAcaraModel
            ->where('kode_booking', $kodeBooking)
            ->where('pembeli_id', $pembeliId)
            ->first();

        if (! $booking) {
            return redirect()->to('/pesan-stand/tentang')->with('error', 'Data pesanan acara tidak ditemukan.');
        }

        $adminHp = '082237191496';
        $waNum = preg_replace('/[^0-9]/', '', $adminHp);
        if (str_starts_with($waNum, '0')) {
            $waNum = '62' . substr($waNum, 1);
        }

        $waText = "Halo%20penjual,%20saya%20sudah%20melakukan%20pesanan%20menu%20acara%20dengan%20kode%20booking%20*" . $kodeBooking . "*%20sebesar%20Rp" . number_format((float)$booking['total'], 0, ',', '.') . ".%20Mohon%20di-cek.";
        $waUrl = "https://wa.me/" . $waNum . "?text=" . $waText;

        $data = [
            'title'   => 'Pesanan Acara Berhasil — Siomay Dua Putri',
            'booking' => $booking,
            'waUrl'   => $waUrl,
        ];

        return view('pesan_stand/berhasil', $data);
    }
}