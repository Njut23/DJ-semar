<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$data = mysqli_query($conn, "SELECT tanggal, total, metode FROM transaksi WHERE id='$id'");
$transaksi = mysqli_fetch_assoc($data);

if(!$transaksi){ echo "Transaksi tidak ditemukan!"; exit; }

$detail = mysqli_query($conn, "
    SELECT p.nama_produk, d.qty, d.subtotal 
    FROM detail_transaksi d
    JOIN produk p ON d.produk_id = p.id
    WHERE d.transaksi_id='$id'
");

$items = [];
while($d = mysqli_fetch_assoc($detail)){
    $items[] = $d;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; }
body { background: #eee; display: flex; flex-direction: column; align-items: center; padding: 20px; }
canvas { background: white; }
button {
    margin-top: 12px;
    padding: 10px 24px;
    font-size: 16px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>
<body>

<canvas id="struk"></canvas>
<button onclick="printStruk()">🖨️ Print Struk</button>

<script>
const items = <?= json_encode($items) ?>;
const transaksi = <?= json_encode($transaksi) ?>;

// 58mm = 220px pada 96dpi, tapi kita pakai 2x untuk kualitas
const SCALE = 2;
const WIDTH = 220 * SCALE;
const FONT = 13 * SCALE;
const PADDING = 8 * SCALE;
const LINE = 18 * SCALE;

function drawStruk() {
    const canvas = document.getElementById('struk');
    const ctx = canvas.getContext('2d');

    // Hitung tinggi dulu
    const totalLines = 4 + (items.length * 2) + 6;
    const HEIGHT = (totalLines * LINE) + (PADDING * 4);

    canvas.width = WIDTH;
    canvas.height = HEIGHT;
    canvas.style.width = (WIDTH / SCALE) + 'px';
    canvas.style.height = (HEIGHT / SCALE) + 'px';

    // Background putih
    ctx.fillStyle = 'white';
    ctx.fillRect(0, 0, WIDTH, HEIGHT);

    ctx.fillStyle = 'black';
    ctx.textBaseline = 'top';

    let y = PADDING;

    // Header
    ctx.font = `bold ${FONT + 2}px 'Courier New', monospace`;
    ctx.textAlign = 'center';
    ctx.fillText('TOKO MINUMAN', WIDTH / 2, y); y += LINE;

    ctx.font = `${FONT - 2}px 'Courier New', monospace`;
    ctx.fillText(transaksi.tanggal, WIDTH / 2, y); y += LINE;

    // Garis
    y = drawDash(ctx, y, WIDTH, PADDING);

    // Items
    ctx.textAlign = 'left';
    items.forEach(item => {
        // Baris 1: nama produk
        ctx.font = `${FONT}px 'Courier New', monospace`;
        ctx.fillText(item.nama_produk, PADDING, y); y += LINE;

        // Baris 2: qty kiri, harga kanan
        ctx.fillText(`  x${item.qty}`, PADDING, y);
        ctx.textAlign = 'right';
        ctx.fillText(`Rp${formatRupiah(item.subtotal)}`, WIDTH - PADDING, y);
        ctx.textAlign = 'left';
        y += LINE;
    });

    // Garis
    y = drawDash(ctx, y, WIDTH, PADDING);

    // Total
    ctx.font = `${FONT}px 'Courier New', monospace`;
    ctx.fillText('Total', PADDING, y);
    ctx.font = `bold ${FONT + 1}px 'Courier New', monospace`;
    ctx.textAlign = 'right';
    ctx.fillText(`Rp${formatRupiah(transaksi.total)}`, WIDTH - PADDING, y);
    ctx.textAlign = 'left';
    y += LINE;

    // Metode
    ctx.font = `${FONT}px 'Courier New', monospace`;
    ctx.fillText('Metode', PADDING, y);
    ctx.textAlign = 'right';
    ctx.fillText(transaksi.metode.toUpperCase(), WIDTH - PADDING, y);
    ctx.textAlign = 'left';
    y += LINE;

    // Garis
    y = drawDash(ctx, y, WIDTH, PADDING);

    // Footer
    ctx.font = `${FONT}px 'Courier New', monospace`;
    ctx.textAlign = 'center';
    ctx.fillText('Terima Kasih 🙏', WIDTH / 2, y);
}

function drawDash(ctx, y, width, padding) {
    ctx.font = `${13 * SCALE}px 'Courier New', monospace`;
    const dash = '- '.repeat(18);
    ctx.textAlign = 'left';
    ctx.fillText(dash, padding, y);
    return y + (18 * SCALE);
}

function formatRupiah(num) {
    return parseInt(num).toLocaleString('id-ID');
}

function printStruk() {
    const canvas = document.getElementById('struk');
    const img = canvas.toDataURL('image/png');

    const win = window.open('', '_blank');
    win.document.write(`
        <html><head>
        <style>
            @page { size: 58mm auto; margin: 0; }
            body { margin: 0; padding: 0; }
            img { width: 58mm; display: block; }
        </style>
        </head><body>
        <img src="${img}">
        <script>
            window.onload = () => {
                setTimeout(() => { window.print(); window.close(); }, 300);
            }
        <\/script>
        </body></html>
    `);
    win.document.close();
}

drawStruk();
</script>

</body>
</html>