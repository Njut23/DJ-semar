<?php
include 'koneksi.php';

/* =========================
   FILTER HARIAN
========================= */
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

/* =========================
   FILTER BULAN
========================= */
$bulan = $_GET['bulan'] ?? date('Y-m');

/* =========================
   DATA HARIAN
========================= */
$harian = mysqli_query($conn, "
SELECT t.*, d.qty, d.subtotal, p.nama_produk
FROM transaksi t
JOIN detail_transaksi d ON t.id = d.transaksi_id
JOIN produk p ON p.id = d.produk_id
WHERE DATE(t.tanggal) = '$tanggal'
ORDER BY t.id DESC
");

/* =========================
   DATA BULANAN (RINGKAS)
========================= */
$bulanan = mysqli_query($conn, "
SELECT DATE(tanggal) as tgl, SUM(total) as total_harian
FROM transaksi
WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$bulan'
GROUP BY DATE(tanggal)
ORDER BY tgl ASC
");

/* TOTAL BULAN */
$total_bulan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(total) as total
FROM transaksi
WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$bulan'
"))['total'];

$total = 0;
$total_cash = 0;
$total_qris = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-top: 30px;
        }

        form {
            margin: 10px 0;
        }

        input, button {
            padding: 8px 10px;
            margin-right: 5px;
        }

        button {
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .danger {
            background: #c0392b;
        }

        /* SUMMARY TEXT (NO CARD) */
        .summary {
            margin: 15px 0;
            line-height: 1.8;
        }

        .summary strong {
            display: inline-block;
            width: 150px;
        }

        /* TABLE CLEAN */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
        }

        th {
            background: #2c3e50;
            color: white;
            font-weight: normal;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .summary strong {
                width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="container">

<h2>Laporan Harian</h2>

<form method="GET">
    <input type="date" name="tanggal" value="<?= $tanggal ?>">
    <button>Tampilkan</button>
</form>

<a href="export_shift.php?tanggal=<?= $tanggal ?>">
    <button>Download Harian</button>
</a>

<!-- SUMMARY -->
<div class="summary">
    <div><strong>Total Harian:</strong> Rp <?= number_format($total) ?></div>
    <div><strong>Cash:</strong> Rp <?= number_format($total_cash) ?></div>
    <div><strong>QRIS:</strong> Rp <?= number_format($total_qris) ?></div>
</div>

<table>
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Produk</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Metode</th>
</tr>

<?php mysqli_data_seek($harian, 0); while($d = mysqli_fetch_assoc($harian)){ ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= $d['tanggal'] ?></td>
    <td><?= $d['nama_produk'] ?></td>
    <td><?= $d['qty'] ?></td>
    <td class="right">Rp<?= number_format($d['subtotal']) ?></td>
    <td><?= $d['metode'] ?></td>
</tr>
<?php } ?>

</table>

<h2>Laporan Bulanan (<?= $bulan ?>)</h2>

<form method="GET">
    <input type="month" name="bulan" value="<?= $bulan ?>">
    <button>Tampilkan</button>
</form>

<a href="export_bulan.php?bulan=<?= $bulan ?>">
    <button>Download Bulanan</button>
</a>

<div class="summary">
    <div><strong>Total Bulan:</strong> Rp <?= number_format($total_bulan ?? 0) ?></div>
</div>

<table>
<tr>
    <th>Tanggal</th>
    <th>Total Harian</th>
</tr>

<?php while($b = mysqli_fetch_assoc($bulanan)){ ?>
<tr>
    <td><?= $b['tgl'] ?></td>
    <td class="right">Rp<?= number_format($b['total_harian']) ?></td>
</tr>
<?php } ?>

</table>

<br>

<a href="reset_bulan.php?bulan=<?= $bulan ?>" 
onclick="return confirm('Yakin reset data bulan ini?')">
    <button class="danger">Reset Bulan Ini</button>
</a>

<br><br>

<a href="index.php"><button>Kembali</button></a>

</div>

</body>
</html>