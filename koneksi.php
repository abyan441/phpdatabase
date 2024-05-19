<?php
$host = "localhost";
$user = "root";
$paswd = "";
$name = "db_kuliah";

// Membuat koneksi
$link = mysqli_connect($host, $user, $paswd, $name, 3307);

// Memeriksa koneksi
if (!$link) {
    die("Koneksi dengan database gagal: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}
?>
