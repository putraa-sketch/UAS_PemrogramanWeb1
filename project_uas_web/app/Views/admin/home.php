<!-- Flash Message -->
<?php if(class_exists('Core\Flash')): ?>
    <?php \Core\Flash::display('message'); ?>
<?php endif; ?>

<!-- Welcome Banner -->
<div class="alert alert-primary border-0 shadow-sm mb-4">
    <h4 class="alert-heading mb-2">
        👋 Selamat Datang, <strong><?= $_SESSION['username'] ?></strong>!
    </h4>
    <p class="mb-0">
        Anda login sebagai <span class="badge bg-dark"><?= strtoupper($_SESSION['role']) ?></span>
        • Dashboard Sistem Manajemen Inventory
    </p>
</div>

<!-- STATISTIK CARDS -->
<div class="row mb-4">
    <!-- Card 1: Total Barang -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Produk</h6>
                        <h2 class="mb-0 fw-bold"><?= $total_barang ?></h2>
                        <small>Jenis barang</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">📦</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 2: Total Stok -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Stok</h6>
                        <h2 class="mb-0 fw-bold"><?= number_format($total_stok) ?></h2>
                        <small>Unit tersedia</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">📊</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 3: Total Nilai -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Nilai Inventory</h6>
                        <h2 class="mb-0 fw-bold">
                            <?php if($total_nilai >= 1000000): ?>
                                Rp <?= number_format($total_nilai / 1000000, 1) ?>M
                            <?php else: ?>
                                Rp <?= number_format($total_nilai / 1000, 0) ?>K
                            <?php endif; ?>
                        </h2>
                        <small>Total aset</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">💰</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 4: Stok Habis/Menipis -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-warning text-dark shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Perlu Perhatian</h6>
                        <h2 class="mb-0 fw-bold"><?= $stok_habis + $stok_menipis ?></h2>
                        <small>
                            <?= $stok_habis ?> habis, <?= $stok_menipis ?> menipis
                        </small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">⚠️</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Kategori Terbanyak -->
<?php if($kategori_terbanyak): ?>
<div class="alert alert-light border shadow-sm mb-4">
    <div class="d-flex align-items-center">
        <span style="font-size: 2rem; margin-right: 15px;">🏆</span>
        <div>
            <strong>Kategori Terpopuler:</strong> 
            <span class="badge bg-primary ms-2"><?= $kategori_terbanyak['kategori'] ?></span>
            dengan <strong><?= $kategori_terbanyak['total'] ?></strong> produk
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Row untuk 2 Tabel -->
<div class="row">
    <!-- Tabel: Top 5 Barang Stok Terbanyak -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">📈 Top 5 Barang Stok Terbanyak</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Barang</th>
                                <th style="width: 100px;" class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($top_barang)): ?>
                                <?php $no=1; foreach($top_barang as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['nama']) ?></strong><br>
                                        <small class="text-muted"><?= $item['kategori'] ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><?= $item['stok'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        Tidak ada data
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel: Barang Perlu Restock -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0">⚠️ Barang Perlu Restock</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Barang</th>
                                <th style="width: 100px;" class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($perlu_restock)): ?>
                                <?php $no=1; foreach($perlu_restock as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['nama']) ?></strong><br>
                                        <small class="text-muted"><?= $item['kategori'] ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item['stok'] == 0): ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><?= $item['stok'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-success py-3">
                                        ✅ Semua barang stok aman!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<?php if($_SESSION['role'] == 'admin'): ?>
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <h6 class="mb-0">⚡ Quick Actions</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-2">
                <a href="<?= \Config\Config::BASE_URL ?>/barang/list" class="btn btn-primary w-100">
                    📋 Lihat Semua Barang
                </a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="<?= \Config\Config::BASE_URL ?>/barang/create" class="btn btn-success w-100">
                    ➕ Tambah Barang Baru
                </a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="<?= \Config\Config::BASE_URL ?>/auth/logout" class="btn btn-danger w-100">
                    🚪 Logout
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>