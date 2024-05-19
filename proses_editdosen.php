<?php
// mengecek apakah tombol edit telah diklik
if (isset($_POST['edit'])) {
// buat koneksi dengan database
include 'koneksi.php';

    // Membuat variabel untuk menampung data dari from edit
    $idDosen = $_POST['idDosen'];
    $namaDosen = $_POST['namaDosen'];
    $noHP = $_POST['noHP'];

    // buat jalankan query UPDATE
    $query = "UPDATE t_dosen SET namaDosen='$namaDosen', noHP='$noHP' WHERE idDosen='$idDosen'";
    $result = mysqli_query($link, $query);

    // Periksa hasil query apakah ada error
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// lakukan redirect ke halaman viewdosen.php
header("location:viewdosen.php");

?>