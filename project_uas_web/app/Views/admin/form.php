<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><?= $title ?></h5>
    </div>
    <div class="card-body">
        <!-- Preview Gambar Lama -->
        <?php if(isset($item['gambar']) && $item['gambar']): ?>
        <div class="alert alert-info">
            <strong>Gambar Saat Ini:</strong><br>
            <img src="<?= \Config\Config::BASE_URL . '/' . $item['gambar'] ?>" 
                 alt="Current Image" 
                 class="mt-2"
                 style="max-width: 300px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <br><small class="text-muted mt-2">Upload gambar baru jika ingin mengganti</small>
        </div>
        <?php endif; ?>
        
        <?php
        use Core\Form;
        $form = new Form($action);
        $form->setEnctype('multipart/form-data');
        $form->addTextField('nama', 'Nama Barang', $item['nama'] ?? '', true);
        $form->addSelectField('kategori', 'Kategori', [
            'Elektronik' => 'Elektronik',
            'Pakaian' => 'Pakaian',
            'Makanan' => 'Makanan',
            'Minuman' => 'Minuman',
            'Lainnya' => 'Lainnya'
        ], $item['kategori'] ?? '', true);
        $form->addNumberField('harga_beli', 'Harga Beli', $item['harga_beli'] ?? '', true);
        $form->addNumberField('harga_jual', 'Harga Jual', $item['harga_jual'] ?? '', true);
        $form->addNumberField('stok', 'Stok', $item['stok'] ?? '', true);
        $form->addFileField('file_gambar', 'Gambar Produk');
        
        $form->display();
        ?>
    </div>
</div>