<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\ProductAvailability;
use App\Models\AdminModel;
use App\Models\PengaturanModel;
use App\Models\ProdukModel;
use App\Models\VarianProdukModel;
use App\Services\CartService;
use Midtrans\Config;
use Midtrans\Snap;

class Checkout extends BaseController
{
    public function __construct()
    {
        // Konfigurasi Midtrans SDK
        // Mendukung format 'midtrans.serverKey' maupun 'MIDTRANS_SERVER_KEY' di file .env
        $serverKey = env('midtrans.serverKey') 
                  ?? env('MIDTRANS_SERVER_KEY') 
                  ?? 'YOUR_SERVER_KEY';

        $isProduction = env('midtrans.isProduction') 
                     ?? env('MIDTRANS_IS_PRODUCTION') 
                     ?? false;

        // trim() untuk menghapus spasi tak sengaja saat copy-paste dari Midtrans
        Config::$serverKey    = trim((string) $serverKey);
        Config::$isProduction = filter_var($isProduction, FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    private function guardCart(int $pembeliId = 0)
    {
        if (! $pembeliId) {
            $pembeliId = (int) session()->get('pembeli_id');
        }
        if (! $pembeliId) {
            return redirect()->to('/login')
                ->with('error', 'Sesi login berakhir. Silakan login lagi.');
        }

        $produkModel     = new ProdukModel();
        $varianModel     = new VarianProdukModel();
        $pengaturanModel = new PengaturanModel();

        $cartView = CartService::hydrate($produkModel, $varianModel, $pengaturanModel);
        if (empty($cartView['rows']) || ! $cartView['canCheckout']) {
            return redirect()->to('/pesan-antar/form')
                ->with('error', 'Keranjang kosong atau minimum order (Rp100.000) belum terpenuhi.');
        }

        $pengaturan = $pengaturanModel->getSingleton();
        $now        = date('H:i:s');
        $avail      = ProductAvailability::resolve(
            $pengaturan['jam_buka'] ?? null,
            $pengaturan['jam_tutup'] ?? null,
            $now
        );

        $tokoBuka    = $avail['tokoBuka'];
        $unavailable = [];

        foreach ($cartView['rows'] as $row) {
            if (! ProductAvailability::isProductTersedia($row['produk'], $tokoBuka)) {
                $namaVarian    = ! empty($row['varian']['nama_varian']) ? ' (varian: ' . $row['varian']['nama_varian'] . ')' : '';
                $unavailable[] = $row['produk']['nama'] . $namaVarian;
            }
        }

        if (! empty($unavailable)) {
            $reason = $tokoBuka
                ? 'Produk berikut sudah tidak aktif dan tidak bisa dipesan: '
                : 'Toko sedang tutup (' . ($avail['alasan'] ?? 'di luar jam operasional') . '). Produk: ';
            return redirect()->to('/pesan-antar/form')
                ->with('error', $reason . implode(', ', $unavailable));
        }

        return $cartView;
    }

    private function computeTotals(array $cartView, array $pengaturan): array
    {
        $subtotal = (float) ($cartView['total'] ?? 0);
        return [
            'subtotal'    => $subtotal,
            'pajak'       => 0.0,
            'total'       => $subtotal,
            'pajakAktif'  => false,
            'pajakPersen' => 0,
        ];
    }

    // ====================================================================
    // Step 2: Form Pesanan
    // ====================================================================
    public function form()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan pesanan.');
        }

        $db         = \Config\Database::connect();
        $produkList = $db->table('produk')
            ->whereIn('id', [1, 2, 4, 7, 8, 9])
            ->where('status_aktif', 1)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();

        foreach ($produkList as &$p) {
            $p['varians'] = $db->table('varian_produk')
                ->where('produk_id', (int) $p['id'])
                ->get()->getResultArray();
        }

        $cart      = CartService::get();
        $cartItems = [];
        foreach ($cart as $line) {
            if (isset($line['produk_id'])) {
                $cartItems[$line['produk_id']] = $line;
            }
        }

        $oldItems = old('items');
        if (is_array($oldItems) && ! empty($oldItems)) {
            foreach ($oldItems as $pId => $itemData) {
                $qty                   = (float) ($itemData['qty'] ?? 0);
                $vId                   = ! empty($itemData['varian_id']) ? (int) $itemData['varian_id'] : null;
                $cartItems[(int) $pId] = [
                    'produk_id' => (int) $pId,
                    'varian_id' => $vId,
                    'jumlah'    => $qty,
                ];
            }
        }

        $besok = (new \DateTime('tomorrow'))->format('Y-m-d');

        $data = [
            'title'        => 'Form Pesanan — Pesan Antar',
            'besok'        => $besok,
            'produkList'   => $produkList,
            'cartItems'    => $cartItems,
            'tanggalValue' => old('tanggal_dibutuhkan') ?? session('checkout_tanggal') ?? '',
            'catatanValue' => old('catatan') ?? session('checkout_catatan') ?? '',
            'metodeValue'  => old('metode') ?? session('checkout_metode') ?? 'ambil_sendiri',
        ];

        return view('pesan_antar/form', $data);
    }

    public function saveForm()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $tanggal = (string) $this->request->getPost('tanggal_dibutuhkan');
        $today   = (new \DateTime('today'))->format('Y-m-d');
        if ($tanggal === '' || $tanggal <= $today) {
            return redirect()->back()->withInput()->with('error', 'Tanggal pesanan harus setelah hari ini (minimal H+1).');
        }

        $metode = (string) $this->request->getPost('metode');
        if (! in_array($metode, ['ambil_sendiri', 'diantar'], true)) {
            return redirect()->back()->withInput()->with('error', 'Pilih metode penerimaan yang valid.');
        }

        $catatan = trim((string) $this->request->getPost('catatan'));
        if (mb_strlen($catatan) > 250) {
            return redirect()->back()->withInput()->with('error', 'Catatan maksimal 250 karakter.');
        }

        $rawItems        = (array) $this->request->getPost('items');
        $produkModel     = new ProdukModel();
        $varianModel     = new VarianProdukModel();
        $pengaturanModel = new PengaturanModel();

        CartService::clear();

        foreach ($rawItems as $produkId => $itemData) {
            $qty      = (float) ($itemData['qty'] ?? 0);
            $varianId = ! empty($itemData['varian_id']) ? (int) $itemData['varian_id'] : null;
            if ($qty > 0) {
                CartService::add((int) $produkId, $varianId, $qty, $produkModel, $varianModel);
            }
        }

        $cartView = CartService::hydrate($produkModel, $varianModel, $pengaturanModel);
        if (empty($cartView['rows']) || ! $cartView['canCheckout']) {
            return redirect()->back()->withInput()->with('error', 'Keranjang kosong atau minimum order (Rp100.000) belum terpenuhi. Subtotal saat ini: Rp' . number_format($cartView['total'] ?? 0, 0, ',', '.'));
        }

        session()->set('checkout_tanggal', $tanggal);
        session()->set('tanggal_dibutuhkan', $tanggal);
        session()->set('checkout_metode', $metode);
        session()->set('metode', $metode);
        session()->set('checkout_catatan', $catatan);
        session()->set('catatan_pesanan', $catatan);

        return redirect()->to('/pesan-antar/data-pemesan');
    }

    public function dataPemesan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        return view('pesan_antar/data_pemesan');
    }

    public function saveDataPemesan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $nama   = trim((string) $this->request->getPost('nama'));
        $wa     = trim((string) $this->request->getPost('wa'));
        $alamat = trim((string) $this->request->getPost('alamat'));
        $lat    = trim((string) $this->request->getPost('koordinat_lat'));
        $lng    = trim((string) $this->request->getPost('koordinat_lng'));

        session()->set('temp_biodata', [
            'nama'          => $nama,
            'wa'            => $wa,
            'alamat'        => $alamat,
            'koordinat_lat' => $lat,
            'koordinat_lng' => $lng,
        ]);

        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $wa);
        session()->set('checkout_alamat', $alamat);
        if ($lat !== '') session()->set('checkout_alamat_lat', $lat);
        if ($lng !== '') session()->set('checkout_alamat_lng', $lng);

        return redirect()->to('/pesan-antar/ringkasan');
    }

    // ====================================================================
    // Step 3: Ringkasan Pesanan
    // ====================================================================
    public function ringkasan()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $pengaturanModel = new PengaturanModel();
        $pengaturan      = $pengaturanModel->getSingleton();
        $totals          = $this->computeTotals($cartView, $pengaturan);

        $sessionData = [
            'tanggal_dibutuhkan' => session('checkout_tanggal') ?? session('tanggal_dibutuhkan') ?? '',
            'metode'             => session('checkout_metode') ?? session('metode') ?? 'ambil_sendiri',
            'catatan'            => session('checkout_catatan') ?? session('catatan_pesanan') ?? '',
        ];

        $cartItems = [];
        foreach ($cartView['rows'] as $r) {
            $img_name  = 'menu_1.png';
            $namaLower = strtolower($r['produk']['nama'] ?? '');
            if (str_contains($namaLower, 'lumpia')) {
                $img_name = 'menu_2.jpeg';
            } elseif (str_contains($namaLower, 'siomay') || str_contains($namaLower, 'somay')) {
                $img_name = 'somay.png';
            } elseif (str_contains($namaLower, 'tahu')) {
                $img_name = 'tahu.png';
            }

            $cartItems[] = [
                'nama'        => $r['produk']['nama'] ?? '',
                'nama_varian' => ! empty($r['varian']['nama_varian']) ? $r['varian']['nama_varian'] : ($r['produk']['satuan'] ?? 'Porsi'),
                'harga'       => (float) ($r['harga'] ?? 0),
                'jumlah'      => (float) ($r['jumlah'] ?? 0),
                'subtotal'    => (float) ($r['subtotal'] ?? 0),
                'gambar'      => $img_name,
            ];
        }

        $metodeVal     = $sessionData['metode'] ?? session('checkout_metode') ?? 'ambil_sendiri';
        $ongkirVal     = $metodeVal === 'diantar' ? 10000.0 : 0.0;
        $subtotalVal   = (float) ($totals['subtotal'] ?? $cartView['total']);
        $totalAkhirVal = $subtotalVal + $ongkirVal;

        $data = [
            'title'       => 'Ringkasan Pesanan — Pesan Antar',
            'rows'        => $cartView['rows'],
            'cartItems'   => $cartItems,
            'sessionData' => $sessionData,
            'tanggal'     => session('checkout_tanggal'),
            'metode'      => $sessionData['metode'] ?? session('checkout_metode') ?? 'ambil_sendiri',
            'catatan'     => session('checkout_catatan'),
            'subtotal'    => $subtotalVal,
            'ongkir'      => $ongkirVal,
            'pajak'       => $totals['pajak'] ?? 0,
            'pajakAktif'  => $totals['pajakAktif'] ?? false,
            'pajakPersen' => $totals['pajakPersen'] ?? 0,
            'total'       => $totalAkhirVal,
            'grandTotal'  => $totalAkhirVal,
        ];

        return view('pesan_antar/ringkasan', $data);
    }

    public function prosesCheckoutCombined()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $metode  = (string) (session('checkout_metode') ?? 'ambil_sendiri');
        $nama    = trim((string) ($this->request->getPost('nama_pemesan') ?? $this->request->getPost('nama') ?? session('checkout_nama') ?? ''));
        $nomorHp = trim((string) ($this->request->getPost('no_wa') ?? $this->request->getPost('nomor_hp') ?? session('checkout_nomor_hp') ?? ''));

        if ($nama === '' || $nomorHp === '') {
            return redirect()->back()->withInput()->with('error', 'Nama dan No. WhatsApp wajib diisi.');
        }

        if ($metode === 'diantar') {
            $alamat = trim((string) ($this->request->getPost('alamat_lengkap') ?? $this->request->getPost('alamat') ?? session('checkout_alamat') ?? ''));
            if ($alamat === '') {
                return redirect()->back()->withInput()->with('error', 'Alamat lengkap wajib diisi untuk metode pengantaran.');
            }
            $catatanKurir = trim((string) $this->request->getPost('catatan_kurir'));
            if ($catatanKurir !== '') {
                session()->set('checkout_catatan_kurir', $catatanKurir);
            }
            session()->set('checkout_nama', $nama);
            session()->set('checkout_nomor_hp', $nomorHp);
            session()->set('checkout_alamat', $alamat);

            return $this->createOrderFromCart('diantar', $nama, $nomorHp, $alamat);
        }

        $catatanPenjual = trim((string) $this->request->getPost('catatan_penjual'));
        if ($catatanPenjual !== '') {
            session()->set('checkout_catatan', $catatanPenjual);
        }
        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $nomorHp);

        return $this->createOrderFromCart('ambil_sendiri', $nama, $nomorHp, null);
    }

    // ====================================================================
    // Step 4A & 4B: Data Pemesan
    // ====================================================================
    public function dataAmbilSendiri()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $metode = (string) session()->get('checkout_metode');
        if ($metode !== 'ambil_sendiri') {
            return redirect()->to('/pesan-antar/form');
        }

        $pengaturan = (new PengaturanModel())->getSingleton();

        $data = [
            'title'          => 'Data Pemesan (Ambil Sendiri) — Pesan Antar',
            'pengaturan'     => $pengaturan,
            'nama'           => session('checkout_nama') ?? session('pembeli_nama') ?? '',
            'nomorHp'        => session('checkout_nomor_hp') ?? '',
            'catatanPemesan' => session('checkout_catatan_pemesan') ?? '',
        ];

        return view('pesan_antar/data_ambil_sendiri', $data);
    }

    public function saveDataAmbilSendiri()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $rules = [
            'nama'     => 'required|max_length[255]',
            'nomor_hp' => 'required|max_length[30]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama           = trim((string) $this->request->getPost('nama'));
        $nomorHp        = trim((string) $this->request->getPost('nomor_hp'));
        $catatanPemesan = trim((string) $this->request->getPost('catatan_pemesan'));

        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $nomorHp);
        if ($catatanPemesan !== '') {
            session()->set('checkout_catatan', $catatanPemesan);
        }

        return $this->createOrderFromCart('ambil_sendiri', $nama, $nomorHp, null);
    }

    public function dataDiantar()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $metode = (string) session()->get('checkout_metode');
        if ($metode !== 'diantar') {
            return redirect()->to('/pesan-antar/form');
        }

        $data = [
            'title'        => 'Data Pemesan (Diantar via Maxim) — Pesan Antar',
            'nama'         => session('checkout_nama') ?? session('pembeli_nama') ?? '',
            'nomorHp'      => session('checkout_nomor_hp') ?? '',
            'alamat'       => session('checkout_alamat') ?? '',
            'catatanKurir' => session('checkout_catatan_kurir') ?? '',
            'alamatLat'    => session('checkout_alamat_lat') ?? '-0.891684',
            'alamatLng'    => session('checkout_alamat_lng') ?? '119.870732',
        ];

        return view('pesan_antar/data_diantar', $data);
    }

    public function saveDataDiantar()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $rules = [
            'nama'     => 'required|max_length[255]',
            'nomor_hp' => 'required|max_length[30]',
            'alamat'   => 'required|max_length[500]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama         = trim((string) $this->request->getPost('nama'));
        $nomorHp      = trim((string) $this->request->getPost('nomor_hp'));
        $alamat       = trim((string) $this->request->getPost('alamat'));
        $catatanKurir = trim((string) $this->request->getPost('catatan_kurir'));

        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $nomorHp);
        session()->set('checkout_alamat', $alamat);
        if ($catatanKurir !== '') {
            session()->set('checkout_catatan_kurir', $catatanKurir);
        }

        return $this->createOrderFromCart('diantar', $nama, $nomorHp, $alamat);
    }

    // ====================================================================
    // Step 5: Buat Pesanan & Generasi Token Midtrans Snap
    // ====================================================================
    private function createOrderFromCart(string $metode, string $nama, string $nomorHp, ?string $alamat = null)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $pengaturanModel = new PengaturanModel();
        $pengaturan      = $pengaturanModel->getSingleton();
        $totals          = $this->computeTotals($cartView, $pengaturan);

        $ongkir     = $metode === 'diantar' ? 10000.0 : 0.0;
        $totalAkhir = $totals['total'] + $ongkir;

        $kodePesanan       = 'SDP' . date('Ymd') . sprintf('%04d', rand(1, 9999));
        $catatan           = (string) (session('checkout_catatan') ?? '');
        $tanggalDibutuhkan = (string) (session('checkout_tanggal') ?? (new \DateTime('tomorrow'))->format('Y-m-d'));

        $itemDetails = [];
        foreach ($cartView['rows'] as $row) {
            $namaProduk    = $row['produk']['nama'] ?? 'Produk';
            $namaVarian    = ! empty($row['varian']['nama_varian']) ? ' - ' . $row['varian']['nama_varian'] : '';
            $namaFormatted = mb_substr($namaProduk . $namaVarian, 0, 50);

            $itemDetails[] = [
                'id'       => (string) ($row['produk']['id'] ?? rand(100, 999)),
                'price'    => (int) round($row['harga']),
                'quantity' => (int) round($row['jumlah']),
                'name'     => $namaFormatted,
            ];
        }

        if ($ongkir > 0) {
            $itemDetails[] = [
                'id'       => 'ONGKIR',
                'price'    => (int) round($ongkir),
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman',
            ];
        }

        $snapParams = [
            'transaction_details' => [
                'order_id'     => $kodePesanan,
                'gross_amount' => (int) round($totalAkhir),
            ],
            'customer_details' => [
                'first_name' => $nama,
                'phone'      => $nomorHp,
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($snapParams);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $pesananData = [
            'pembeli_id'         => $pembeliId,
            'kode_pesanan'       => $kodePesanan,
            'nama_pembeli'       => $nama,
            'nomor_hp'           => $nomorHp,
            'metode'             => $metode,
            'alamat'             => $alamat,
            'catatan'            => $catatan !== '' ? $catatan : null,
            'tanggal_dibutuhkan' => $tanggalDibutuhkan,
            'subtotal'           => (float) $totals['subtotal'],
            'pajak'              => (float) $totals['pajak'],
            'total'              => (float) $totalAkhir,
            'snap_token'         => $snapToken,
            'status'             => 'menunggu_pembayaran',
        ];

        $db->table('pesanan')->insert($pesananData);
        $pesananId = $db->insertID();

        foreach ($cartView['rows'] as $row) {
            $itemData = [
                'pesanan_id'    => $pesananId,
                'produk_id'     => (int) $row['produk']['id'],
                'varian_id'     => ! empty($row['varian']['id']) ? (int) $row['varian']['id'] : null,
                'jumlah'        => (float) $row['jumlah'],
                'harga_satuan'  => (float) $row['harga'],
                'subtotal_item' => (float) $row['subtotal'],
            ];
            $db->table('item_pesanan')->insert($itemData);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan ke database. Silakan coba lagi.');
        }

        CartService::clear();
        session()->remove([
            'checkout_catatan',
            'checkout_tanggal',
            'checkout_metode',
            'checkout_nama',
            'checkout_nomor_hp',
            'checkout_alamat',
            'checkout_catatan_pemesan',
            'checkout_catatan_kurir',
            'checkout_alamat_lat',
            'checkout_alamat_lng',
        ]);

        return redirect()->to('/pesan-antar/pembayaran/' . $kodePesanan);
    }

    // ====================================================================
    // Step 6: Pembayaran Midtrans Snap
    // ====================================================================
    public function pembayaran(?string $kode = null)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Sesi login berakhir.');
        }

        $kodePesanan = $kode ?? (string) $this->request->getGet('kode');
        if ($kodePesanan === '') {
            return redirect()->to('/pesan-antar/form')->with('error', 'Kode pesanan tidak valid.');
        }

        $db      = \Config\Database::connect();
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kodePesanan)
            ->where('pembeli_id', $pembeliId)
            ->get()->getRowArray();

        if (! $pesanan) {
            return redirect()->to('/pesan-antar/form')->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = $db->table('item_pesanan ip')
            ->select('ip.jumlah, ip.harga_satuan, ip.subtotal_item, p.nama AS produk_nama, vp.nama_varian')
            ->join('produk p', 'p.id = ip.produk_id', 'left')
            ->join('varian_produk vp', 'vp.id = ip.varian_id', 'left')
            ->where('ip.pesanan_id', (int) $pesanan['id'])
            ->get()->getResultArray();

        $clientKey = env('midtrans.clientKey') 
                  ?? env('MIDTRANS_CLIENT_KEY') 
                  ?? 'YOUR_CLIENT_KEY';

        return view('pesan_antar/pembayaran', [
            'title'     => 'Pembayaran Midtrans — Pesan Antar',
            'pesanan'   => $pesanan,
            'items'     => $items,
            'snapToken' => $pesanan['snap_token'] ?? '',
            'clientKey' => trim((string) $clientKey),
        ]);
    }

    public function konfirmasiBayar(?string $kode = null)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Sesi login berakhir.');
        }

        $kodePesanan = $kode ?? (string) $this->request->getGet('kode');

        $db      = \Config\Database::connect();
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kodePesanan)
            ->where('pembeli_id', $pembeliId)
            ->get()->getRowArray();

        if (! $pesanan) {
            return redirect()->to('/pesan-antar/form')->with('error', 'Pesanan tidak ditemukan.');
        }

        $db->table('pesanan')->where('id', (int) $pesanan['id'])
            ->update(['status' => 'menunggu_konfirmasi']);

        return redirect()->to('/pesan-antar/berhasil/' . $kodePesanan);
    }

    // ====================================================================
    // Step 7: Pesanan Berhasil
    // ====================================================================
    public function berhasil(string $kode)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melihat pesanan Anda.');
        }

        $db      = \Config\Database::connect();
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kode)
            ->where('pembeli_id', $pembeliId)
            ->get()->getRowArray();

        if (! $pesanan) {
            return redirect()->to('/pesan-antar/form')->with('error', 'Pesanan tidak ditemukan.');
        }

        $pengaturan = (new PengaturanModel())->getSingleton();
        $adminHp    = (string) ($pengaturan['admin_hp'] ?? '');
        if ($adminHp === '') {
            $admin = (new AdminModel())->first();
            if ($admin && ! empty($admin['nomor_hp'])) {
                $adminHp = (string) $admin['nomor_hp'];
            }
        }

        $waNum = preg_replace('/[^0-9]/', '', $adminHp);
        if (str_starts_with($waNum, '0')) {
            $waNum = '62' . substr($waNum, 1);
        }

        $waText = "Halo%20penjual,%20saya%20sudah%20melakukan%20pesanan%20antar%20dengan%20kode%20pesanan%20*" . $kode . "*%20sebesar%20Rp" . number_format((float)$pesanan['total'], 0, ',', '.') . ".%20Mohon%20di-cek.";
        $waUrl  = $waNum !== '' ? "https://wa.me/" . $waNum . "?text=" . $waText : "#";

        return view('pesan_antar/berhasil', [
            'title'   => 'Pesanan Berhasil — Siomay Dua Putri',
            'pesanan' => $pesanan,
            'waUrl'   => $waUrl,
        ]);
    }

    // Legacy method backward-compatibility helpers:
    public function catatan() { return redirect()->to('/pesan-antar/form'); }
    public function saveCatatan() { return redirect()->to('/pesan-antar/form'); }
    public function tanggal() { return redirect()->to('/pesan-antar/form'); }
    public function saveTanggal() { return redirect()->to('/pesan-antar/form'); }
    public function metode() { return redirect()->to('/pesan-antar/form'); }
    public function saveMetode() { return redirect()->to('/pesan-antar/form'); }
    public function jemput() { return redirect()->to('/pesan-antar/data-ambil-sendiri'); }
    public function saveJemput() { return $this->saveDataAmbilSendiri(); }
    public function antar() { return redirect()->to('/pesan-antar/data-diantar'); }
    public function saveAntar() { return $this->saveDataDiantar(); }
    public function sukses(string $kode) { return redirect()->to('/pesan-antar/berhasil/' . $kode); }
}