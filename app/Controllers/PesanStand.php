<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\ItemPesananAcaraModel;
use App\Models\PengaturanModel;
use App\Models\PesananAcaraModel;
use App\Models\ProdukModel;

class PesanStand extends BaseController
{
    // ====================================================================
    // STEP 1: Tentang Stand Acara
    // ====================================================================
    public function tentang()
    {
        $data = [
            'title' => 'Tentang Stand Acara — Siomay Dua Putri',
        ];
        return view('pesan_stand/tentang', $data);
    }

    public function form()
    {
        return $this->acara();
    }

    public function saveForm()
    {
        return $this->saveAcara();
    }

    // ====================================================================
    // STEP 2: Form Data Acara
    // ====================================================================
    public function acara()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu untuk booking stand acara.');
        }

        $besok = (new \DateTime('tomorrow'))->format('Y-m-d');
        $sessionData = session('pesan_stand_data') ?? [];

        $data = [
            'title'        => 'Form Data Acara — Stand Acara Siomay Dua Putri',
            'besok'        => $besok,
            'formData'     => $sessionData,
            'pembeliNama'  => session('pembeli_nama') ?? '',
        ];
        return view('pesan_stand/acara', $data);
    }

    public function saveAcara()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $namaPemesan = trim((string) ($this->request->getPost('nama_pemesan') ?? $this->request->getPost('nama') ?? ''));
        $nomorHp     = trim((string) ($this->request->getPost('nomor_hp') ?? $this->request->getPost('no_wa') ?? ''));
        $jenisRaw    = (string) ($this->request->getPost('jenis_acara') ?? 'Lainnya');
        
        $jenisMap = [
            'Pernikahan'      => 'pernikahan',
            'Ulang Tahun'     => 'ulang_tahun',
            'Arisan'          => 'arisan',
            'Perusahaan'      => 'acara_perusahaan',
            'Lainnya'         => 'lainnya',
            'ulang_tahun'      => 'ulang_tahun',
            'pernikahan'       => 'pernikahan',
            'acara_perusahaan' => 'acara_perusahaan',
            'pembukaan_kantor' => 'pembukaan_kantor',
            'arisan'           => 'arisan',
            'acara_keagamaan'  => 'acara_keagamaan',
            'acara_kedukaan'   => 'acara_kedukaan',
            'lainnya'          => 'lainnya',
        ];
        $jenisAcara = $jenisMap[$jenisRaw] ?? 'lainnya';

        $namaAcara   = trim((string) ($this->request->getPost('nama_acara') ?? $jenisRaw));
        if ($namaAcara === '') {
            $namaAcara = 'Acara ' . $jenisRaw;
        }

        $tanggal = (string) ($this->request->getPost('tanggal_acara') ?? $this->request->getPost('tanggal') ?? '');
        $lokasi  = trim((string) ($this->request->getPost('lokasi_acara') ?? $this->request->getPost('lokasi') ?? ''));
        $estimasiPorsi = (int) ($this->request->getPost('estimasi_porsi') ?? $this->request->getPost('jumlah_tamu') ?? 0);
        $catatan = trim((string) $this->request->getPost('catatan'));

        if ($namaPemesan === '' || $nomorHp === '' || $tanggal === '' || $lokasi === '') {
            return redirect()->back()->withInput()->with('error', 'Semua field dengan tanda bintang (*) wajib diisi.');
        }

        $today = (new \DateTime('today'))->format('Y-m-d');
        if ($tanggal <= $today) {
            return redirect()->back()->withInput()->with('error', 'Tanggal acara harus minimal H+1.');
        }

        $formData = [
            'nama_pemesan'   => $namaPemesan,
            'nomor_hp'       => $nomorHp,
            'jenis_acara'    => $jenisAcara,
            'nama_acara'     => $namaAcara,
            'tanggal_acara'  => $tanggal,
            'lokasi_acara'   => $lokasi,
            'estimasi_porsi' => $estimasiPorsi,
            'catatan'        => $catatan,
        ];

        session()->set('pesan_stand_data', $formData);

        return redirect()->to('/pesan-stand/menu');
    }

    // ====================================================================
    // STEP 3: Pilih Menu Stand
    // ====================================================================
    public function menu()
    {
        $formData = session('pesan_stand_data');
        if (empty($formData)) {
            return redirect()->to('/pesan-stand/acara')->with('error', 'Silakan isi data acara terlebih dahulu.');
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

        $sessionItems = session('pesan_stand_items') ?? [];

        $data = [
            'title'        => 'Pilih Menu Stand — Stand Acara Siomay Dua Putri',
            'produkList'   => $produkList,
            'sessionItems' => $sessionItems,
        ];
        return view('pesan_stand/menu', $data);
    }

    public function saveMenu()
    {
        $formData = session('pesan_stand_data');
        if (empty($formData)) {
            return redirect()->to('/pesan-stand/acara')->with('error', 'Silakan isi data acara terlebih dahulu.');
        }

        $rawItems = (array) $this->request->getPost('items');
        $selectedItems = [];

        foreach ($rawItems as $key => $itemData) {
            if (is_array($itemData)) {
                $qtyVal = (float) ($itemData['qty'] ?? 0);
                $varianId = ! empty($itemData['varian']) ? (int) $itemData['varian'] : (! empty($itemData['varian_id']) ? (int) $itemData['varian_id'] : null);
                $produkId = is_numeric($key) ? (int) $key : (! empty($itemData['produk_id']) ? (int) $itemData['produk_id'] : (int) $key);
                if ($qtyVal > 0) {
                    $selectedItems[$key] = [
                        'produk_id' => $produkId,
                        'qty'       => $qtyVal,
                        'varian_id' => $varianId,
                    ];
                }
            } else {
                $qtyVal = (float) $itemData;
                if ($qtyVal > 0) {
                    $selectedItems[(int) $key] = [
                        'produk_id' => (int) $key,
                        'qty'       => $qtyVal,
                        'varian_id' => null,
                    ];
                }
            }
        }

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 menu stand untuk melanjutkan.');
        }

        session()->set('pesan_stand_items', $selectedItems);

        return redirect()->to('/pesan-stand/ringkasan');
    }

    // ====================================================================
    // STEP 4: Ringkasan Booking
    // ====================================================================
    public function ringkasan()
    {
        $formData = session('pesan_stand_data');
        $selectedItems = session('pesan_stand_items');

        if (empty($formData) || empty($selectedItems)) {
            return redirect()->to('/pesan-stand/acara')->with('error', 'Silakan lengkapi data acara dan pilihan menu.');
        }

        $pengaturan = (new PengaturanModel())->getSingleton();
        $biayaStand = (float) ($pengaturan['biaya_stand'] ?? 0.0);

        $db = \Config\Database::connect();
        $itemsDetail = [];
        $subtotal = 0.0;

        foreach ($selectedItems as $key => $itemData) {
            $produkId = is_array($itemData) ? (int) ($itemData['produk_id'] ?? (is_numeric($key) ? $key : 0)) : (int) $key;
            $qty = is_array($itemData) ? (float) ($itemData['qty'] ?? 0) : (float) $itemData;
            $varianId = is_array($itemData) ? ($itemData['varian_id'] ?? null) : null;

            if ($produkId <= 0 && is_string($key)) {
                $pRow = $db->table('produk')->like('nama', str_replace('_', ' ', $key))->get()->getRowArray();
                if ($pRow) $produkId = (int) $pRow['id'];
            }

            $p = $db->table('produk')->where('id', $produkId)->get()->getRowArray();
            if (! $p) continue;

            $harga = (float) $p['harga'];
            $namaVarian = '';
            if ($varianId) {
                $v = $db->table('varian_produk')->where('id', (int) $varianId)->get()->getRowArray();
                if ($v) {
                    if (! empty($v['harga']) && (float) $v['harga'] > 0) {
                        $harga = (float) $v['harga'];
                    }
                    $namaVarian = $v['nama_varian'];
                }
            }

            $itemSubtotal = $qty * $harga;
            $subtotal += $itemSubtotal;

            $itemsDetail[] = [
                'produk_id'     => $produkId,
                'nama'          => $p['nama'],
                'varian_nama'   => $namaVarian,
                'kategori'      => $p['kategori'],
                'harga'         => $harga,
                'qty'           => $qty,
                'subtotal_item' => $itemSubtotal,
            ];
        }

        $total = $subtotal + $biayaStand;

        $data = [
            'title'         => 'Ringkasan Booking — Stand Acara Siomay Dua Putri',
            'formData'      => $formData,
            'itemsDetail'   => $itemsDetail,
            'subtotal'      => $subtotal,
            'biayaStand'    => $biayaStand,
            'total'         => $total,
        ];

        return view('pesan_stand/ringkasan', $data);
    }

    public function simpanBooking()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/daftar')->with('error', 'Silakan login terlebih dahulu.');
        }

        $formData = session('pesan_stand_data');
        $selectedItems = session('pesan_stand_items');

        if (empty($formData) || empty($selectedItems)) {
            return redirect()->to('/pesan-stand/acara')->with('error', 'Data booking tidak lengkap.');
        }

        $pengaturan = (new PengaturanModel())->getSingleton();
        $biayaStand = (float) ($pengaturan['biaya_stand'] ?? 0.0);

        $db = \Config\Database::connect();
        $produkIds = array_keys($selectedItems);
        $rows = $db->table('produk')->whereIn('id', $produkIds)->get()->getResultArray();

        $subtotal = 0.0;
        $itemsToInsert = [];

        foreach ($rows as $p) {
            $id = (int) $p['id'];
            $qty = (float) ($selectedItems[$id] ?? 0);
            $harga = (float) $p['harga'];
            $itemSubtotal = $qty * $harga;
            $subtotal += $itemSubtotal;

            $itemsToInsert[] = [
                'produk_id'             => $id,
                'jumlah'                => $qty,
                'harga_satuan_snapshot' => $harga,
                'subtotal_item'         => $itemSubtotal,
            ];
        }

        $total = $subtotal + $biayaStand;
        $kodeBooking = 'STN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $db->transStart();

        $pesananAcaraData = [
            'kode_booking'      => $kodeBooking,
            'pembeli_id'        => $pembeliId,
            'nama_pemesan'      => $formData['nama_pemesan'],
            'nomor_hp'          => $formData['nomor_hp'],
            'jenis_acara'       => $formData['jenis_acara'],
            'nama_acara'        => $formData['nama_acara'],
            'tanggal_acara'     => $formData['tanggal_acara'],
            'lokasi_acara'      => $formData['lokasi_acara'],
            'estimasi_porsi'    => $formData['estimasi_porsi'] > 0 ? $formData['estimasi_porsi'] : null,
            'catatan'           => $formData['catatan'] !== '' ? $formData['catatan'] : null,
            'subtotal'          => $subtotal,
            'biaya_stand'       => $biayaStand,
            'total'             => $total,
            'status_pembayaran' => 'menunggu_pembayaran',
            'status_followup'   => 'baru',
        ];

        $pesananAcaraModel = new PesananAcaraModel();
        $pesananAcaraId = $pesananAcaraModel->insert($pesananAcaraData, true);

        foreach ($itemsToInsert as &$it) {
            $it['pesanan_acara_id'] = (int) $pesananAcaraId;
            $db->table('item_pesanan_acara')->insert($it);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan booking. Silakan coba lagi.');
        }

        session()->remove(['pesan_stand_data', 'pesan_stand_items']);

        return redirect()->to('/pesan-stand/pembayaran/' . $kodeBooking);
    }

    // ====================================================================
    // STEP 5: Pembayaran QRIS Dummy
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
            return redirect()->to('/pesan-stand/tentang')->with('error', 'Data booking tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $items = $db->table('item_pesanan_acara ipa')
            ->select('ipa.jumlah, ipa.harga_satuan_snapshot, ipa.subtotal_item, p.nama AS produk_nama, p.kategori')
            ->join('produk p', 'p.id = ipa.produk_id', 'left')
            ->where('ipa.pesanan_acara_id', (int) $booking['id'])
            ->get()->getResultArray();

        $data = [
            'title'   => 'Pembayaran QRIS — Stand Acara',
            'booking' => $booking,
            'items'   => $items,
            'qrisImg' => base_url('assets/img/qris.jpeg'),
        ];

        return view('pesan_stand/pembayaran', $data);
    }

    public function konfirmasiBayar(string $kodeBooking)
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
            return redirect()->to('/pesan-stand/tentang')->with('error', 'Data booking tidak ditemukan.');
        }

        $pesananAcaraModel->update((int) $booking['id'], [
            'status_pembayaran' => 'menunggu_konfirmasi',
        ]);

        return redirect()->to('/pesan-stand/berhasil/' . $kodeBooking)
            ->with('message', 'Terima kasih! Pembayaran Anda sedang menunggu konfirmasi admin.');
    }

    // ====================================================================
    // STEP 6: Berhasil
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
            return redirect()->to('/pesan-stand/tentang')->with('error', 'Data booking tidak ditemukan.');
        }

        $pengaturan = (new PengaturanModel())->getSingleton();
        $adminHp = (string) ($pengaturan['admin_hp'] ?? '');
        if ($adminHp === '') {
            $admin = (new AdminModel())->first();
            if ($admin && ! empty($admin['nomor_hp'])) {
                $adminHp = (string) $admin['nomor_hp'];
            }
        }

        // Sanitasi nomor WhatsApp
        $waNum = preg_replace('/[^0-9]/', '', $adminHp);
        if (str_starts_with($waNum, '0')) {
            $waNum = '62' . substr($waNum, 1);
        }

        $waText = "Halo%20penjual,%20saya%20sudah%20melakukan%20booking%20stand%20acara%20dengan%20kode%20booking%20*" . $kodeBooking . "*%20sebesar%20Rp" . number_format((float)$booking['total'], 0, ',', '.') . ".%20Mohon%20di-cek.";
        $waUrl = $waNum !== '' ? "https://wa.me/" . $waNum . "?text=" . $waText : "#";

        $data = [
            'title'   => 'Booking Stand Berhasil — Siomay Dua Putri',
            'booking' => $booking,
            'waUrl'   => $waUrl,
        ];

        return view('pesan_stand/berhasil', $data);
    }
}
