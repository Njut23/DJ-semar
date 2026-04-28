<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_shift.xls");

$query = mysqli_query($conn, "
SELECT 
    t.id,
    t.tanggal,
    t.metode,
    p.nama_produk,
    d.qty,
    d.subtotal
FROM transaksi t
JOIN detail_transaksi d ON t.id = d.transaksi_id
JOIN produk p ON d.produk_id = p.id
WHERE t.tanggal BETWEEN 
DATE_SUB(CURDATE(), INTERVAL 1 DAY) + INTERVAL 14 HOUR
AND 
CURDATE() + INTERVAL 2 HOUR
ORDER BY t.id DESC
");

echo "ID\tTanggal\tMetode\tProduk\tQty\tSubtotal\n";

while($data = mysqli_fetch_assoc($query)){
    echo $data['id']."\t".
         $data['tanggal']."\t".
         $data['metode']."\t".
         $data['nama_produk']."\t".
         $data['qty']."\t".
         $data['subtotal']."\n";
}
?>