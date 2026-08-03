<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\ProductAvailability;
use App\Models\PengaturanModel;
use App\Models\ProdukModel;
use App\Models\VarianProdukModel;
use App\Services\CartService;
use App\Services\MidtransService;
use Midtrans\Config;
use Midtrans\Snap;

class Checkout extends BaseController
{
    public function __construct()
    {
        $serverKey = env('midtrans.serverKey') 
                  ?? env('MIDTRANS_SERVER_KEY') 
                  ?? 'YOUR_SERVER_KEY';

        $isProduction = env('midtrans.isProduction') 
                     ?? env('MIDTRANS_IS_PRODUCTION') 
                     ?? false;

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
            $minOrderStr = number_format($cartView['minOrder'] ?? 50000, 0, ',', '.');
            return redirect()->to('/pesan-antar/form')
                ->with('error', 'Keranjang kosong atau minimum order (Rp' . $minOrderStr . ') belum terpenuhi.');
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

    private function computeOngkir(string $lokasi, string $metode): float
    {
        if ($metode === 'diantar' && $lokasi === 'Undata') {
            return 5000.0;
        }
        return 0.0;
    }

    // ====================================================================
    // Step 1: Form Pesanan
    // ====================================================================
    public function form()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan pesanan.');
        }

        $db    = \Config\Database::connect();
        $builder = $db->table('produk')->where('status_aktif', 1);

        if ($db->fieldExists('tampil_di_pesan_antar', 'produk')) {
            $builder->where('tampil_di_pesan_antar', 1);
        }

        $produkList = $builder->orderBy('id', 'ASC')->get()->getResultArray();

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

        $data = [
            'title'        => 'Form Pesanan — Pesan Antar',
            'produkList'   => $produkList,
            'cartItems'    => $cartItems,
            'lokasiValue'  => old('lokasi') ?? session('checkout_lokasi') ?? '',
            'catatanValue' => old('catatan') ?? session('checkout_catatan') ?? '',
            'metodeValue'  => old('metode') ?? session('checkout_metode') ?? 'diantar',
        ];

        return view('pesan_antar/form', $data);
    }

    public function saveForm()
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $lokasi = (string) $this->request->getPost('lokasi');
        if (! in_array($lokasi, ['Undata', 'Lainnya'], true)) {
            return redirect()->back()->withInput()->with('error', 'Pilih lokasi pengantaran yang valid.');
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
                $res = CartService::add((int) $produkId, $varianId, $qty, $produkModel, $varianModel);
                if (! ($res['ok'] ?? false)) {
                    return redirect()->back()->withInput()->with('error', $res['error'] ?? 'Gagal menambahkan produk ke keranjang.');
                }
            }
        }

        $cartView = CartService::hydrate($produkModel, $varianModel, $pengaturanModel);
        if (empty($cartView['rows']) || ! $cartView['canCheckout']) {
            $minOrderStr = number_format($cartView['minOrder'] ?? 50000, 0, ',', '.');
            return redirect()->back()->withInput()->with('error', 'Keranjang kosong atau minimum order (Rp' . $minOrderStr . ') belum terpenuhi. Subtotal saat ini: Rp' . number_format($cartView['total'] ?? 0, 0, ',', '.'));
        }

        session()->set('checkout_lokasi', $lokasi);
        session()->set('checkout_metode', $metode);
        session()->set('checkout_catatan', $catatan);

        return redirect()->to('/pesan-antar/data-pemesan');
    }

    // ====================================================================
    // Step 2: Data Pemesan
    // ====================================================================
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

        $lokasi = (string) (session('checkout_lokasi') ?? 'Undata');
        $metode = (string) (session('checkout_metode') ?? 'diantar');

        $nama   = trim((string) $this->request->getPost('nama'));
        $wa     = trim((string) $this->request->getPost('wa'));
        $ruangan = trim((string) $this->request->getPost('ruangan'));
        $alamat = trim((string) $this->request->getPost('alamat'));
        $lat    = trim((string) $this->request->getPost('koordinat_lat'));
        $lng    = trim((string) $this->request->getPost('koordinat_lng'));

        if ($nama === '' || $wa === '') {
            return redirect()->back()->withInput()->with('error', 'Nama Laporan dan No. WhatsApp wajib diisi.');
        }

        if ($metode === 'diantar') {
            if ($lokasi === 'Undata' && $ruangan === '') {
                return redirect()->back()->withInput()->with('error', 'Ruangan wajib diisi untuk pengantaran area Undata.');
            }
            if ($lokasi === 'Lainnya' && $alamat === '') {
                return redirect()->back()->withInput()->with('error', 'Alamat lengkap wajib diisi untuk pengantaran luar area.');
            }
        }

        session()->set('temp_biodata', [
            'nama'          => $nama,
            'wa'            => $wa,
            'ruangan'       => $ruangan,
            'alamat'        => $alamat,
            'koordinat_lat' => $lat,
            'koordinat_lng' => $lng,
        ]);

        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $wa);
        if ($ruangan !== '') session()->set('checkout_ruangan', $ruangan);
        if ($alamat !== '') session()->set('checkout_alamat', $alamat);
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

        $lokasi = (string) (session('checkout_lokasi') ?? 'Undata');
        $metode = (string) (session('checkout_metode') ?? 'diantar');

        $ongkirVal     = $this->computeOngkir($lokasi, $metode);
        $subtotalVal   = (float) ($totals['subtotal'] ?? $cartView['total']);
        $totalAkhirVal = $subtotalVal + $ongkirVal;

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

        $data = [
            'title'       => 'Ringkasan Pesanan — Pesan Antar',
            'rows'        => $cartView['rows'],
            'cartItems'   => $cartItems,
            'lokasi'      => $lokasi,
            'metode'      => $metode,
            'ruangan'     => session('checkout_ruangan') ?? '',
            'alamat'      => session('checkout_alamat') ?? '',
            'catatan'     => session('checkout_catatan') ?? '',
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

        $lokasi  = (string) (session('checkout_lokasi') ?? 'Undata');
        $metode  = (string) (session('checkout_metode') ?? 'diantar');
        $nama    = trim((string) ($this->request->getPost('nama_pemesan') ?? $this->request->getPost('nama') ?? session('checkout_nama') ?? ''));
        $nomorHp = trim((string) ($this->request->getPost('no_wa') ?? $this->request->getPost('nomor_hp') ?? session('checkout_nomor_hp') ?? ''));
        $ruangan = trim((string) (session('checkout_ruangan') ?? ''));
        $alamat  = trim((string) (session('checkout_alamat') ?? ''));

        if ($nama === '' || $nomorHp === '') {
            return redirect()->back()->withInput()->with('error', 'Nama dan No. WhatsApp wajib diisi.');
        }

        if ($metode === 'diantar') {
            if ($lokasi === 'Undata' && $ruangan === '') {
                return redirect()->back()->withInput()->with('error', 'Ruangan wajib diisi untuk pengantaran area Undata.');
            }
            if ($lokasi === 'Lainnya' && $alamat === '') {
                return redirect()->back()->withInput()->with('error', 'Alamat lengkap wajib diisi untuk pengantaran luar area.');
            }
        }

        session()->set('checkout_nama', $nama);
        session()->set('checkout_nomor_hp', $nomorHp);

        return $this->createOrderFromCart($metode, $lokasi, $nama, $nomorHp, $ruangan, $alamat);
    }

    // ====================================================================
    // Step 4: Buat Pesanan & Generasi Token Midtrans Snap QRIS
    // ====================================================================
    private function createOrderFromCart(string $metode, string $lokasi, string $nama, string $nomorHp, ?string $ruangan = null, ?string $alamat = null)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        $cartView  = $this->guardCart($pembeliId);
        if ($cartView instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $cartView;
        }

        $pengaturanModel = new PengaturanModel();
        $pengaturan      = $pengaturanModel->getSingleton();
        $totals          = $this->computeTotals($cartView, $pengaturan);

        $ongkir     = $this->computeOngkir($lokasi, $metode);
        $totalAkhir = $totals['total'] + $ongkir;

        $kodePesanan       = 'SDP' . date('Ymd') . sprintf('%04d', rand(1, 9999));
        $catatan           = (string) (session('checkout_catatan') ?? '');
        $tanggalDibutuhkan = date('Y-m-d');

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
                'name'     => 'Biaya Pengiriman (Undata)',
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
            'item_details'     => $itemDetails,
            'enabled_payments' => ['other_qris'],
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
            'lokasi'             => $lokasi,
            'ruangan'            => $ruangan !== '' ? $ruangan : null,
            'alamat'             => ($metode === 'ambil_sendiri') ? 'Kantin RSUD Undata' : ($alamat !== '' ? $alamat : null),
            'alamat_lat'         => ($metode === 'ambil_sendiri') ? '-0.857844' : (session('checkout_alamat_lat') ?? null),
            'alamat_lng'         => ($metode === 'ambil_sendiri') ? '119.884047' : (session('checkout_alamat_lng') ?? null),
            'catatan'            => $catatan !== '' ? $catatan : null,
            'tanggal_dibutuhkan' => $tanggalDibutuhkan,
            'subtotal'           => (float) $totals['subtotal'],
            'ongkir'             => (float) $ongkir,
            'pajak'              => (float) $totals['pajak'],
            'total'              => (float) $totalAkhir,
            'snap_token'         => $snapToken,
            'status'             => 'menunggu_pembayaran',
            'created_at'         => date('Y-m-d H:i:s'),
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

        // Insert ke tabel transaksi
        $db->table('transaksi')->insert([
            'pesanan_id'        => $pesananId,
            'midtrans_order_id' => $kodePesanan,
            'status_pembayaran' => 'pending',
            'mdr_persen'        => 0.0,
            'nominal_diterima'  => 0.0,
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan ke database. Silakan coba lagi.');
        }

        return redirect()->to('/pesan-antar/pembayaran/' . $kodePesanan);
    }

    // ====================================================================
    // Step 5: Pembayaran Midtrans Snap QRIS
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
            'title'     => 'Pembayaran QRIS — Pesan Antar',
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

        // Tandai pesanan lunas saat callback konfirmasi diterima dari Snap / Midtrans
        $db->table('pesanan')->where('id', (int) $pesanan['id'])->update(['status' => 'lunas']);

        // Clear cart & session
        CartService::clear();
        session()->remove([
            'checkout_lokasi',
            'checkout_metode',
            'checkout_catatan',
            'checkout_nama',
            'checkout_nomor_hp',
            'checkout_ruangan',
            'checkout_alamat',
            'checkout_catatan_pemesan',
            'checkout_catatan_kurir',
            'checkout_alamat_lat',
            'checkout_alamat_lng',
            'temp_biodata',
        ]);

        return redirect()->to('/pesan-antar/berhasil/' . $kodePesanan);
    }

    public function menungguKonfirmasi(string $kode)
    {
        // Alur menunggu-konfirmasi dihilangkan. Arahkan langsung ke pembayaran jika belum lunas, atau berhasil jika lunas.
        $pembeliId = (int) session()->get('pembeli_id');
        $db        = \Config\Database::connect();
        $pesanan   = $db->table('pesanan')
            ->where('kode_pesanan', $kode)
            ->get()->getRowArray();

        if ($pesanan && $pesanan['status'] === 'lunas') {
            return redirect()->to('/pesan-antar/berhasil/' . $kode);
        }

        return redirect()->to('/pesan-antar/pembayaran/' . $kode);
    }

    public function cekStatus(string $kode)
    {
        $pembeliId = (int) session()->get('pembeli_id');
        if (! $pembeliId) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'error' => 'Sesi login berakhir.']);
        }

        $db      = \Config\Database::connect();
        $pesanan = $db->table('pesanan')
            ->where('kode_pesanan', $kode)
            ->where('pembeli_id', $pembeliId)
            ->get()->getRowArray();

        if (! $pesanan) {
            return $this->response->setStatusCode(404)->setJSON(['ok' => false, 'error' => 'Pesanan tidak ditemukan.']);
        }

        if ($pesanan['status'] === 'lunas') {
            return $this->response->setJSON(['ok' => true, 'data' => ['status' => 'lunas']]);
        }

        $trx = $db->table('transaksi')
            ->where('pesanan_id', (int) $pesanan['id'])
            ->orderBy('id', 'DESC')
            ->get()->getRowArray();

        if ($trx && $trx['status_pembayaran'] !== 'lunas') {
            $check = MidtransService::getStatus($trx['midtrans_order_id']);
            if ($check['ok'] ?? false) {
                $trxStatus   = (string) ($check['data']['transaction_status'] ?? '');
                $fraudStatus = (string) ($check['data']['fraud_status'] ?? '');
                if (in_array($trxStatus, ['settlement', 'capture'], true) && $fraudStatus !== 'deny') {
                    $db->table('transaksi')->where('id', (int) $trx['id'])->update(['status_pembayaran' => 'lunas']);
                    $db->table('pesanan')->where('id', (int) $pesanan['id'])->update(['status' => 'lunas']);

                    CartService::clear();
                    session()->remove([
                        'checkout_lokasi',
                        'checkout_metode',
                        'checkout_catatan',
                        'checkout_nama',
                        'checkout_nomor_hp',
                        'checkout_ruangan',
                        'checkout_alamat',
                        'checkout_catatan_pemesan',
                        'checkout_catatan_kurir',
                        'checkout_alamat_lat',
                        'checkout_alamat_lng',
                        'temp_biodata',
                    ]);

                    return $this->response->setJSON(['ok' => true, 'data' => ['status' => 'lunas']]);
                }
            }
        }

        return $this->response->setJSON(['ok' => true, 'data' => ['status' => $pesanan['status']]]);
    }

    // ====================================================================
    // Step 6: Pesanan Berhasil
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

        if ($pesanan['status'] !== 'lunas') {
            return redirect()->to('/pesan-antar/pembayaran/' . $kode)
                ->with('error', 'Pembayaran belum terkonfirmasi atau belum diselesaikan.');
        }

        $waNum  = '6282237191496';
        $waText = "Halo%20penjual,%20saya%20sudah%20melakukan%20pesanan%20antar%20dengan%20kode%20pesanan%20*" . $kode . "*%20sebesar%20Rp" . number_format((float)$pesanan['total'], 0, ',', '.') . ".%20Mohon%20di-cek.";
        $waUrl  = "https://wa.me/" . $waNum . "?text=" . $waText;

        return view('pesan_antar/berhasil', [
            'title'   => 'Pesanan Berhasil — Siomay Dua Putri',
            'pesanan' => $pesanan,
            'waUrl'   => $waUrl,
        ]);
    }
}