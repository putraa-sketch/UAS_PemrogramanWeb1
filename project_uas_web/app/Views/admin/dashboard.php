<!-- Flash Message -->
<?php if(class_exists('Core\Flash')): ?>
    <?php \Core\Flash::display('message'); ?>
<?php endif; ?>

<!-- STATISTIK CARDS (Hanya untuk Admin) -->
<?php if($_SESSION['role'] == 'admin' && isset($total_barang)): ?>
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
<?php endif; ?>

<!-- TABEL DATA BARANG -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📦 Data Barang</h5>
        <?php if($_SESSION['role'] == 'admin'): ?>
        <a href="<?= \Config\Config::BASE_URL ?>/barang/create" class="btn btn-success btn-sm">
            ➕ Tambah Barang
        </a>
        <?php endif; ?>
    </div>
    
    <div class="card-body">
        <!-- Form Pencarian -->
        <form class="d-flex mb-3 gap-2" method="GET">
            <input type="text" 
                   name="q" 
                   class="form-control" 
                   value="<?= htmlspecialchars($q) ?>" 
                   placeholder="Cari nama atau kategori...">
            <button class="btn btn-primary" type="submit">
                🔍 Cari
            </button>
            <?php if($q): ?>
            <a href="<?= \Config\Config::BASE_URL ?>/barang" class="btn btn-secondary">
                ✖️ Reset
            </a>
            <?php endif; ?>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped bg-white align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th style="width: 100px;" class="text-center">Gambar</th>
                        <th>Nama Barang</th>
                        <th style="width: 120px;">Kategori</th>
                        <th style="width: 130px;" class="text-end">Harga Jual</th>
                        <th style="width: 80px;" class="text-center">Stok</th>
                        <?php if($_SESSION['role']=='admin'): ?>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($barang)): ?>
                    <tr>
                        <td colspan="<?= $_SESSION['role']=='admin' ? '7' : '6' ?>" class="text-center text-muted py-4">
                            <div style="font-size: 3rem; opacity: 0.3;">📭</div>
                            <i>Tidak ada data ditemukan</i>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1 + (($hal - 1) * 5); foreach($barang as $b): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center">
                                <?php if($b['gambar'] && file_exists(__DIR__ . '/../../../public/'.$b['gambar'])): ?>
                                    <img src="<?= \Config\Config::BASE_URL ?>/<?= $b['gambar'] ?>" 
                                         alt="<?= htmlspecialchars($b['nama']) ?>"
                                         class="rounded shadow-sm"
                                         style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #ddd;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; margin: 0 auto;">
                                        <span style="font-size: 24px;">📦</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($b['nama']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars($b['kategori']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <strong>Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></strong>
                            </td>
                            <td class="text-center">
                                <?php if($b['stok'] > 10): ?>
                                    <span class="badge bg-success"><?= $b['stok'] ?> ✓</span>
                                <?php elseif($b['stok'] > 0): ?>
                                    <span class="badge bg-warning text-dark"><?= $b['stok'] ?> ⚠️</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis ❌</span>
                                <?php endif; ?>
                            </td>
                            <?php if($_SESSION['role']=='admin'): ?>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?= \Config\Config::BASE_URL ?>/barang/edit/<?= $b['id_barang'] ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit">
                                        ✏️
                                    </a>
                                    <a href="<?= \Config\Config::BASE_URL ?>/barang/delete/<?= $b['id_barang'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('⚠️ Yakin ingin menghapus <?= htmlspecialchars($b['nama']) ?>?\n\nData yang dihapus tidak dapat dikembalikan!')"
                                       title="Hapus">
                                        🗑️
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($pages > 1): ?>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                <small>Halaman <strong><?= $hal ?></strong> dari <strong><?= $pages ?></strong></small>
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php if($hal > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?hal=<?= $hal-1 ?>&q=<?= urlencode($q) ?>">
                            « Prev
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php 
                    // Tampilkan maksimal 5 nomor halaman
                    $start = max(1, $hal - 2);
                    $end = min($pages, $hal + 2);
                    
                    if($start > 1): ?>
                        <li class="page-item"><a class="page-link" href="?hal=1&q=<?= urlencode($q) ?>">1</a></li>
                        <?php if($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php for($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= $hal == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?hal=<?= $i ?>&q=<?= urlencode($q) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if($end < $pages): ?>
                        <?php if($end < $pages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item"><a class="page-link" href="?hal=<?= $pages ?>&q=<?= urlencode($q) ?>"><?= $pages ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($hal < $pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?hal=<?= $hal+1 ?>&q=<?= urlencode($q) ?>">
                            Next »
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Tips untuk User (jika bukan admin) -->
<?php if($_SESSION['role'] != 'admin'): ?>
<div class="alert alert-info mt-3">
    <strong>ℹ️ Info:</strong> Anda login sebagai <strong>User</strong>. 
    Anda dapat melihat data barang tetapi tidak dapat menambah/edit/hapus data. 
    Hubungi Admin jika perlu akses lebih lanjut.
</div>
<?php endif; ?>