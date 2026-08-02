<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Landing::index');

$routes->get('etalase', 'Etalase::index');
$routes->get('qris',    'Qris::index');
$routes->get('bantuan', 'Home::bantuan');

$routes->get('keranjang',              'Keranjang::index');
$routes->post('keranjang/tambah',      'Keranjang::tambah');
$routes->post('keranjang/kurang',      'Keranjang::kurang');
$routes->post('keranjang/hapus',       'Keranjang::hapus');
$routes->post('keranjang/catatan',     'Keranjang::simpanCatatan');

$routes->get('daftar',                 'PembeliAuth::register');
$routes->post('daftar',                'PembeliAuth::storeRegister');
$routes->get('login',                  'PembeliAuth::login');
$routes->post('login',                 'PembeliAuth::attemptLogin');
$routes->post('logout',                'PembeliAuth::logout');
$routes->get('syarat-ketentuan',       'PembeliAuth::terms');
$routes->get('lupa-password',               'PembeliAuth::lupaPassword');
$routes->post('lupa-password',              'PembeliAuth::prosesLupaPassword');
$routes->get('reset-password/(:segment)',   'PembeliAuth::resetPassword/$1');
$routes->post('reset-password/proses',      'PembeliAuth::prosesResetPassword');

$routes->get('akun/riwayat',            'PembeliAkun::riwayat', ['filter' => 'customerAuth']);
$routes->get('akun/riwayat/(:segment)', 'PembeliAkun::detail/$1', ['filter' => 'customerAuth']);

// ALUR 1 — PESAN ANTAR (10 Halaman Wireframe 1)
$routes->get('pesan-antar', 'Etalase::caraKerja');

$routes->group('pesan-antar', ['filter' => 'customerAuth'], static function ($routes): void {
    $routes->get('form',                      'Checkout::form');
    $routes->post('form',                     'Checkout::saveForm');
    $routes->get('data-pemesan',              'Checkout::dataPemesan');
    $routes->post('proses-data-pemesan',      'Checkout::saveDataPemesan');
    $routes->get('ringkasan',                 'Checkout::ringkasan');
    $routes->post('checkout',                 'Checkout::prosesCheckoutCombined');
    $routes->post('proses-checkout',          'Checkout::prosesCheckoutCombined');
    $routes->post('proses-qris',              'Checkout::prosesCheckoutCombined');
    $routes->get('data-ambil-sendiri',        'Checkout::dataAmbilSendiri');
    $routes->post('data-ambil-sendiri',       'Checkout::saveDataAmbilSendiri');
    $routes->get('data-diantar',              'Checkout::dataDiantar');
    $routes->post('data-diantar',             'Checkout::saveDataDiantar');
    $routes->get('pembayaran/(:segment)',     'Checkout::pembayaran/$1');
    $routes->get('konfirmasi-bayar/(:segment)', 'Checkout::konfirmasiBayar/$1'); // <-- Rute Baru
    $routes->get('berhasil/(:segment)',       'Checkout::berhasil/$1');
});

// Legacy /checkout group alias compatibility
$routes->group('checkout', ['filter' => 'customerAuth'], static function ($routes): void {
    $routes->get('catatan',           'Checkout::catatan');
    $routes->post('catatan',          'Checkout::saveCatatan');
    $routes->get('tanggal',           'Checkout::tanggal');
    $routes->post('tanggal',          'Checkout::saveTanggal');
    $routes->get('metode',            'Checkout::metode');
    $routes->post('metode',           'Checkout::saveMetode');
    $routes->get('jemput',            'Checkout::jemput');
    $routes->post('jemput',           'Checkout::saveJemput');
    $routes->get('antar',             'Checkout::antar');
    $routes->post('antar',            'Checkout::saveAntar');
    $routes->get('pembayaran',        'Checkout::pembayaran');
    $routes->get('sukses/(:segment)', 'Checkout::sukses/$1');
});

// ALUR 2 — PESAN STAND ACARA (6 Halaman Wireframe 2)
$routes->get('pesan-stand/tentang', 'PesanStand::tentang');

$routes->group('pesan-stand', ['filter' => 'customerAuth'], static function ($routes): void {
    $routes->get('form',                      'PesanStand::form');
    $routes->post('form',                     'PesanStand::saveForm');
    $routes->get('acara',                     'PesanStand::acara');
    $routes->post('acara',                    'PesanStand::saveAcara');
    $routes->get('menu',                      'PesanStand::menu');
    $routes->post('menu',                     'PesanStand::saveMenu');
    $routes->get('ringkasan',                 'PesanStand::ringkasan');
    $routes->post('simpan',                   'PesanStand::simpanBooking');
    $routes->get('pembayaran/(:segment)',     'PesanStand::pembayaran/$1');
    $routes->get('berhasil/(:segment)',       'PesanStand::berhasil/$1');
});

// Webhook Midtrans
$routes->post('webhook/midtrans', 'MidtransWebhook::index');

$routes->group('admin', static function ($routes): void {
    $routes->get('/', static fn () => redirect()->to('/admin/dashboard'));

    $routes->get('register',     'Admin\\Auth::register');
    $routes->post('register',    'Admin\\Auth::storeRegister');
    $routes->get('login',        'Admin\\Auth::login');
    $routes->post('login',       'Admin\\Auth::attemptLogin');
    $routes->post('logout',      'Admin\\Auth::logout');

    $routes->get('dashboard', 'Admin\\Dashboard::index', ['filter' => 'auth']);

    $routes->group('produk', ['filter' => 'auth'], static function ($routes): void {
        $routes->get('/',                 'Admin\\ProdukAdmin::index');
        $routes->get('create',            'Admin\\ProdukAdmin::create');
        $routes->post('store',            'Admin\\ProdukAdmin::store');
        $routes->get('edit/(:num)',       'Admin\\ProdukAdmin::edit/$1');
        $routes->post('update/(:num)',    'Admin\\ProdukAdmin::update/$1');
        $routes->get('delete/(:num)',     'Admin\\ProdukAdmin::delete/$1');
        $routes->post('(:num)/varian',         'Admin\\ProdukAdmin::storeVarian/$1');
        $routes->post('(:num)/varian/(:num)/delete', 'Admin\\ProdukAdmin::deleteVarian/$1/$2');
    });
});