let printerDevice = null;
let printerChar = null;

// Koneksi ke MK5880
async function connectPrinter() {
    try {
        printerDevice = await navigator.bluetooth.requestDevice({
            filters: [{ name: 'MK5880' }],
            // kalau namanya beda coba:
            // filters: [{ namePrefix: 'MK' }]
            // atau: acceptAllDevices: true
            optionalServices: ['000018f0-0000-1000-8000-00805f9b34fb']
        });

        const server = await printerDevice.gatt.connect();
        const service = await server.getPrimaryService('000018f0-0000-1000-8000-00805f9b34fb');
        printerChar = await service.getCharacteristic('00002af1-0000-1000-8000-00805f9b34fb');

        alert('Printer terhubung!');
    } catch(err) {
        alert('Gagal connect: ' + err.message);
    }
}

// Kirim bytes ke printer
async function sendToPrinter(data) {
    if(!printerChar){ alert('Printer belum terhubung!'); return; }

    // Kirim per 20 bytes (limit BLE)
    const chunkSize = 20;
    for(let i = 0; i < data.length; i += chunkSize){
        const chunk = data.slice(i, i + chunkSize);
        await printerChar.writeValue(chunk);
        await new Promise(r => setTimeout(r, 30)); // delay antar chunk
    }
}

// ESC/POS helper
function escpos(){
    const cmds = [];

    return {
        init()        { cmds.push(0x1B, 0x40); return this; },
        center()      { cmds.push(0x1B, 0x61, 0x01); return this; },
        left()        { cmds.push(0x1B, 0x61, 0x00); return this; },
        bold(on)      { cmds.push(0x1B, 0x45, on ? 1 : 0); return this; },
        feed(n=1)     { for(let i=0;i<n;i++) cmds.push(0x0A); return this; },
        cut()         { cmds.push(0x1D, 0x56, 0x42, 0x00); return this; },
        text(str)     {
            for(const c of str){
                cmds.push(c.charCodeAt(0));
            }
            return this;
        },
        // teks kiri kanan dalam 1 baris (32 char)
        textLR(left, right, width=32){
            const spasi = width - left.length - right.length;
            return this.text(left + ' '.repeat(Math.max(1, spasi)) + right + '\n');
        },
        line(width=32){ return this.text('-'.repeat(width) + '\n'); },
        bytes()       { return new Uint8Array(cmds); }
    };
}

// Main print function
async function printStruk(transaksiId) {
    if(!printerChar){
        alert('Hubungkan printer dulu!');
        return;
    }

    // Ambil data dari struk.php
    const res = await fetch(`struk.php?id=${transaksiId}`);
    const data = await res.json();

    if(data.error){ alert(data.error); return; }

    const ep = escpos()
        .init()
        .center()
        .bold(true)
        .text('TOKO MINUMAN\n')
        .bold(false)
        .text(data.tanggal + '\n')
        .line()
        .left();

    data.items.forEach(item => {
        ep.text(item.nama_produk + '\n')
          .textLR('  x' + item.qty, 'Rp' + parseInt(item.subtotal).toLocaleString('id-ID'));
    });

    ep.line()
      .bold(true)
      .textLR('Total', 'Rp' + parseInt(data.total).toLocaleString('id-ID'))
      .bold(false)
      .textLR('Metode', data.metode.toUpperCase())
      .line()
      .center()
      .text('Terima Kasih!\n')
      .feed(3)
      .cut();

    await sendToPrinter(ep.bytes());
}