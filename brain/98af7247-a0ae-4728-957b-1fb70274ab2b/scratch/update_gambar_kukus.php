<?php
define('FCPATH', __DIR__ . '/../../public/');
require __DIR__ . '/../../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootTest($paths);

$db = \Config\Database::connect();
if ($db->tableExists('produk')) {
    $items = $db->table('produk')->get()->getResultArray();
    echo "Produk Count: " . count($items) . "\n";
    foreach ($items as $p) {
        echo "ID: {$p['id']} | Nama: {$p['nama']} | Gambar: " . ($p['gambar'] ?? 'NULL') . "\n";
        if (strpos(strtolower($p['nama']), 'kukus') !== false || strpos(strtolower($p['nama']), 'siomay kukus') !== false) {
            if ($db->fieldExists('gambar', 'produk')) {
                $db->table('produk')->where('id', $p['id'])->update(['gambar' => 'somay.png']);
                echo "--> Updated gambar to somay.png for ID {$p['id']}\n";
            }
        }
    }
}
