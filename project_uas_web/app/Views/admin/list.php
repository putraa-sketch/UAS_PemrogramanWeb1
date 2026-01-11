<!-- Flash Message -->
<?php if(class_exists('Core\Flash')): ?>
    <?php \Core\Flash::display('message'); ?>
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
            <a href="<?= \Config\Config::BASE_URL ?>/barang/list" class="btn btn-secondary">
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