<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan — Admin Siomay Dua Putri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #F9FAFB; padding: 30px; margin: 0; }
        .card { background: #fff; border-radius: 16px; padding: 24px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { color: #3b198f; font-size: 1.3rem; margin-top: 0; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Detail Pesanan #<?= esc($order->kode_pesanan ?? $pesanan['kode_pesanan'] ?? '-') ?></h1>
        <div class="row">
            <span>Pemesan:</span>
            <strong><?= esc($order->nama_pembeli ?? $pesanan['nama_pembeli'] ?? '-') ?></strong>
        </div>
        <div class="row">
            <span>Metode:</span>
            <strong><?= esc($order->metode ?? $pesanan['metode'] ?? '-') ?></strong>
        </div>
        <div class="row">
            <span>Alamat:</span>
            <strong><?= esc($order->alamat ?? $pesanan['alamat'] ?? '-') ?></strong>
        </div>

        <?php 
            $lat = $order->lat ?? $pesanan['alamat_lat'] ?? '-0.8917';
            $lng = $order->lng ?? $pesanan['alamat_lng'] ?? '119.8707';
        ?>

        <!-- Tombol Admin Kirim via Maxim -->
        <a href="https://taxsee.com/id-ID/order?start_lat=-0.8917&start_lng=119.8707&end_lat=<?= esc($lat) ?>&end_lng=<?= esc($lng) ?>" 
           target="_blank" 
           class="btn btn-warning" 
           style="background-color:#FFC107; color:#000; font-weight:bold; padding: 10px 15px; border-radius: 8px; text-decoration:none;">
            Kirim via Maxim
        </a>
    </div>
</body>
</html>
