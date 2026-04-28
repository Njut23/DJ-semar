<?php
include 'koneksi.php';

$bulan = $_GET['bulan'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-bulan-$bulan.xls");

$data = mysqli_query($conn, "
SELECT * FROM transaksi 
WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$bulan'
");

echo "<table border='1'>";
echo "<tr><th>Tanggal</th><th>Total</th><th>Metode</th></tr>";

while($d = mysqli_fetch_assoc($data)){
    echo "<tr>
        <td>{$d['tanggal']}</td>
        <td>{$d['total']}</td>
        <td>{$d['metode']}</td>
    </tr>";
}

echo "</table>";
?>