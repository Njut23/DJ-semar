<?php 
session_start();
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kasir POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: 'Segoe UI';
    margin: 0;
    background: #f4f6f9;
}

/* 🔴 TOPBAR RED SUBTLE */
.topbar {
    padding: 15px;
    background: #c0392b;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.topbar button {
    margin: 5px;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

/* CONTAINER */
.container {
    display: flex;
    min-height: 100vh;
}

/* PRODUK */
.produk {
    flex: 3;
    padding: 20px;
    overflow-y: auto;
}

.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: 0.2s;
}

.card:hover {
    transform: scale(1.03);
}

.card:active {
    transform: scale(0.97);
}

/* 🖼️ IMAGE FIX */
.card img {
    width: 100%;
    height: 140px;
    object-fit: contain;
    background: #fff;
    border-radius: 10px;
}

/* CART */
.cart {
    flex: 1;
    background: white;
    padding: 20px;
    border-left: 2px solid #eee;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

table {
    width: 100%;
    margin-bottom: 10px;
}

th, td {
    padding: 8px;
    text-align: center;
}

.total {
    font-size: 20px;
    font-weight: bold;
}

button {
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-save {
    width: 100%;
    background: #c0392b;
    color: white;
    font-size: 16px;
}

select {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .produk {
        width: 100%;
    }

    .cart {
        width: 100%;
        position: relative;
        height: auto;
        border-left: none;
    }

    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .grid {
        grid-template-columns: repeat(1, 1fr);
    }

    .card img {
        height: 160px;
    }
}
</style>

</head>
<body>

<div class="topbar">

    <h3>Toko Minuman Koko Grup</h3>

    <!-- 🔍 SEARCH BAR (TAMBAHAN BARU) -->
    <input type="text" id="search" placeholder="🔍 Cari produk..." 
    style="padding:8px; border-radius:6px; border:none; width:200px;">

    <div>
        <a href="laporan.php"><button> Laporan</button></a>
        <a href="produk.php"><button>⚙️ Produk</button></a>

        <?php if(isset($_SESSION['login'])){ ?>
            <a href="logout.php"><button> Logout</button></a>
        <?php } else { ?>
            <a href="login.php"><button> Login</button></a>
        <?php } ?>
    </div>
</div>

<div class="container">

<!-- PRODUK -->
<div class="produk">
    <h3>Produk</h3>

    <div class="grid">

    <?php
    $data = mysqli_query($conn, "SELECT * FROM produk");
    while($p = mysqli_fetch_assoc($data)){
    ?>
        <div class="card" 
        data-name="<?= strtolower($p['nama_produk']) ?>"
        onclick="tambahCart(<?= $p['id'] ?>,'<?= $p['nama_produk'] ?>',<?= $p['harga'] ?>)">

            <img src="images/<?= $p['gambar'] ?>" onerror="this.src='https://via.placeholder.com/150'">
            <h4><?= $p['nama_produk'] ?></h4>
            <p>Rp<?= number_format($p['harga']) ?></p>

        </div>
    <?php } ?>

    </div>
</div>

<!-- CART -->
<div class="cart">
    <h3>Keranjang</h3>

    <form method="POST" action="simpan.php" onsubmit="return cekCart()">
        <table border="1" id="cartTable">
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </table>

        <p class="total">Total: Rp <span id="total">0</span></p>

        <label>Metode Pembayaran</label>
        <select name="metode">
            <option value="cash">Cash</option>
            <option value="qris">QRIS</option>
        </select>

        <input type="hidden" name="data" id="data">

        <br><br>

        <button class="btn-save">Simpan Transaksi</button>
    </form>
</div>

</div>

<script>
let cart = [];

function tambahCart(id, nama, harga){
    let item = cart.find(i => i.id === id);

    if(item){
        item.qty++;
    } else {
        cart.push({id, nama, harga, qty:1});
    }

    renderCart();
}

function renderCart(){
    let table = document.getElementById("cartTable");
    table.innerHTML = `
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    `;

    let total = 0;

    cart.forEach(item => {
        let subtotal = item.qty * item.harga;
        total += subtotal;

        table.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
                <td>${subtotal}</td>
            </tr>
        `;
    });

    document.getElementById("total").innerText = total;
    document.getElementById("data").value = JSON.stringify(cart);
}

/* 🔍 SEARCH FUNCTION */
document.getElementById("search").addEventListener("input", function(){
    let keyword = this.value.toLowerCase();
    let items = document.querySelectorAll(".card");

    items.forEach(item => {
        let name = item.getAttribute("data-name");

        if(name.includes(keyword)){
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
});

function cekCart(){
    if(cart.length === 0){
        alert("Keranjang kosong!");
        return false;
    }
    return true;
}
</script>

</body>
</html>