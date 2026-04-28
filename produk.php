<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// folder upload
$folder = "images/";

/* =========================
   TAMBAH PRODUK
========================= */
if(isset($_POST['tambah'])){
    $nama = aman($_POST['nama']);
    $harga = aman($_POST['harga']);
    $diskon = aman($_POST['diskon']);

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if($gambar != ""){
        move_uploaded_file($tmp, $folder.$gambar);
    }

    mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, diskon, gambar) 
    VALUES ('$nama','$harga','$diskon','$gambar')");
}

/* =========================
   EDIT PRODUK
========================= */
if(isset($_POST['edit'])){
    $id = aman($_POST['id']);
    $nama = aman($_POST['nama']);
    $harga = aman($_POST['harga']);
    $diskon = aman($_POST['diskon']);

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if($gambar != ""){
        move_uploaded_file($tmp, $folder.$gambar);

        mysqli_query($conn, "UPDATE produk 
        SET nama_produk='$nama', harga='$harga', diskon='$diskon', gambar='$gambar'
        WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE produk 
        SET nama_produk='$nama', harga='$harga', diskon='$diskon'
        WHERE id='$id'");
    }
}

/* =========================
   HAPUS PRODUK
========================= */
if(isset($_GET['hapus'])){
    $id = aman($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");
}

/* =========================
   AMBIL DATA
========================= */
$data = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f4f6f9; }
        table { width:100%; margin-top:20px; background:white; }
        th, td { padding:10px; text-align:center; }
        input { padding:5px; }
        button { padding:5px 10px; cursor:pointer; }
        img { width:60px; height:60px; object-fit:cover; }
    </style>
</head>
<body>

<h2>⚙️ Manajemen Produk</h2>

<a href="index.php"><button>⬅️ Kembali</button></a>
<a href="logout.php"><button>🚪 Logout</button></a>

<hr>

<h3>Tambah Produk</h3>

<form method="POST" enctype="multipart/form-data">
    Nama: <input type="text" name="nama" required>
    Harga: <input type="number" name="harga" required>
    Diskon (%): <input type="number" name="diskon" value="0" min="0" max="100">
    Foto: <input type="file" name="gambar" required>
    <button name="tambah">Tambah</button>
</form>

<hr>

<h3>Daftar Produk</h3>

<table border="1">
<tr>
    <th>ID</th>
    <th>Foto</th>
    <th>Nama</th>
    <th>Harga</th>
    <th>Diskon</th>
    <th>Harga Final</th>
    <th>Ganti Foto</th>
    <th>Aksi</th>
</tr>

<?php while($p = mysqli_fetch_assoc($data)){ 

$harga_final = $p['harga'] - ($p['harga'] * $p['diskon'] / 100);

?>
<tr>
<form method="POST" enctype="multipart/form-data">
    <td><?= $p['id'] ?></td>

    <td>
        <img src="images/<?= $p['gambar'] ?>" 
        onerror="this.src='https://via.placeholder.com/60'">
    </td>

    <td>
        <input type="text" name="nama" value="<?= $p['nama_produk'] ?>">
    </td>

    <td>
        <input type="number" name="harga" value="<?= $p['harga'] ?>">
    </td>

    <td>
        <input type="number" name="diskon" value="<?= $p['diskon'] ?>">
    </td>

    <td>
        Rp <?= number_format($harga_final) ?>
    </td>

    <td>
        <input type="file" name="gambar">
    </td>

    <td>
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <button name="edit">Update</button>
        <a href="?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus produk?')">
            Hapus
        </a>
    </td>
</form>
</tr>
<?php } ?>

</table>

</body>
</html>