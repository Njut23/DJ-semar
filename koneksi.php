<?php
$conn = mysqli_connect("localhost", "root", "", "kasir_minuman");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// fungsi keamanan
function aman($data){
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}
?>