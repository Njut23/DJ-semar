<?php
include 'koneksi.php';

$data = json_decode($_POST['data'], true);
$metode = aman($_POST['metode']);

if(!$data || count($data) == 0){
    die("Keranjang kosong!");
}

// hitung total
$total = 0;
foreach($data as $d){
    $total += $d['harga'] * $d['qty'];
}

// simpan transaksi (pakai tanggal biar laporan bisa jalan)
mysqli_query($conn, "
INSERT INTO transaksi (tanggal, total, metode) 
VALUES (NOW(), '$total', '$metode')
");

$id_transaksi = mysqli_insert_id($conn);

// simpan detail transaksi
foreach($data as $d){

    $id_produk = aman($d['id']);
    $qty = aman($d['qty']);
    $harga = aman($d['harga']);
    $subtotal = $harga * $qty;

    mysqli_query($conn, "
    INSERT INTO detail_transaksi 
    (transaksi_id, produk_id, qty, subtotal)
    VALUES ('$id_transaksi','$id_produk','$qty','$subtotal')
    ");
}

// redirect ke struk
header("Location: struk.php?id=$id_transaksi");
exit;
?>