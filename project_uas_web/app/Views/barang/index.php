<div class="d-flex justify-content-between mb-3">
    <h3>Data Barang</h3>
    <?php if($_SESSION['role'] == 'admin'): ?>
    <a href="<?= \Config\Config::BASE_URL ?>/barang/create" class="btn btn-success">Tambah</a>
    <?php endif; ?>
</div>

<form class="d-flex mb-3 gap-2">
    <input type="text" name="q" class="form-control" value="<?= $q ?>" placeholder="Cari...">
    <button class="btn btn-primary">Cari</button>
</form>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>No</th><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><?php if($_SESSION['role']=='admin') echo "<th>Aksi</th>"; ?></tr>
    </thead>
    <tbody>
        <?php $no=1+(($hal-1)*5); foreach($barang as $b): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?php if($b['gambar']) echo "<img src='".\Config\Config::BASE_URL."/".$b['gambar']."' width='50'>"; ?></td>
            <td><?= $b['nama'] ?></td>
            <td><?= $b['kategori'] ?></td>
            <td><?= number_format($b['harga_jual']) ?></td>
            <td><?= $b['stok'] ?></td>
            <?php if($_SESSION['role']=='admin'): ?>
            <td>
                <a href="<?= \Config\Config::BASE_URL ?>/barang/delete/<?= $b['id_barang'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <?php for($i=1; $i<=$pages; $i++): ?>
        <a href="?hal=<?= $i ?>&q=<?= $q ?>" class="btn btn-sm <?= $hal==$i?'btn-primary':'btn-outline-primary' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>