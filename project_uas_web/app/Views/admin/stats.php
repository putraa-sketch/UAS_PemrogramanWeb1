<?php
// Hitung statistik
$model = new \Models\ProductModel();
$db = new \Config\Database();

$total_barang = $db->count('data_barang');
$total_stok = $db->query("SELECT SUM(stok) as total FROM data_barang")->fetch_assoc()['total'] ?? 0;
$total_nilai = $db->query("SELECT SUM(harga_jual * stok) as total FROM data_barang")->fetch_assoc()['total'] ?? 0;
$stok_habis = $db->count('data_barang', 'stok = 0');
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h6 class="card-title">Total Barang</h6>
                <h2 class="mb-0"><?= $total_barang ?></h2>
                <small>Jenis produk</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6 class="card-title">Total Stok</h6>
                <h2 class="mb-0"><?= number_format($total_stok) ?></h2>
                <small>Unit tersedia</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h6 class="card-title">Total Nilai</h6>
                <h2 class="mb-0">Rp <?= number_format($total_nilai / 1000000, 1) ?>M</h2>
                <small>Nilai inventory</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h6 class="card-title">Stok Habis</h6>
                <h2 class="mb-0"><?= $stok_habis ?></h2>
                <small>Perlu restock</small>
            </div>
        </div>
    </div>
</div>