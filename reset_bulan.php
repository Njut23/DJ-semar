<?php
include 'koneksi.php';

$bulan = $_GET['bulan'] ?? date('Y-m');

/* =========================
   1. AMBIL DATA
========================= */
$data = mysqli_query($conn, "
SELECT * FROM transaksi 
WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$bulan'
");

/* =========================
   2. BUAT FILE EXCEL (DI SERVER DULU)
========================= */
$filename = "backup-$bulan.xls";

$file = fopen($filename, "w");

fwrite($file, "<table border='1'>");
fwrite($file, "<tr><th>ID</th><th>Tanggal</th><th>Total</th><th>Metode</th></tr>");

while($d = mysqli_fetch_assoc($data)){
    fwrite($file, "<tr>
        <td>{$d['id']}</td>
        <td>{$d['tanggal']}</td>
        <td>{$d['total']}</td>
        <td>{$d['metode']}</td>
    </tr>");
}

fwrite($file, "</table>");
fclose($file);

/* =========================
   3. HAPUS DATA
========================= */
mysqli_query($conn, "
DELETE FROM transaksi 
WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$bulan'
");

/* =========================
   4. DOWNLOAD FILE
========================= */
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);

/* OPTIONAL: hapus file setelah download
unlink($filename);
*/
exit;
?>