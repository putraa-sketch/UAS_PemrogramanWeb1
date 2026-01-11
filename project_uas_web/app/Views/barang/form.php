<h3><?= $title ?></h3>
<?php
use Core\Form;
$form = new Form($action);
$form->setEnctype('multipart/form-data');
$form->addTextField('nama', 'Nama Barang', $item['nama']??'', true);
$form->addSelectField('kategori', 'Kategori', ['Elektronik'=>'Elektronik','Lainnya'=>'Lainnya'], $item['kategori']??'', true);
$form->addNumberField('harga_beli', 'Harga Beli', $item['harga_beli']??'', true);
$form->addNumberField('harga_jual', 'Harga Jual', $item['harga_jual']??'', true);
$form->addNumberField('stok', 'Stok', $item['stok']??'', true);
$form->addFileField('file_gambar', 'Gambar');
$form->display();
?>