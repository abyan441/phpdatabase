<?php
if (isset($_POST['input'])) {
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

    // Mengambil data dari form
    $nama_dosen = mysqli_real_escape_string($link, $_POST['namaDosen']);
    $no_hp = mysqli_real_escape_string($link, $_POST['noHP']);

    // Membuat query untuk insert data
    $query = "INSERT INTO t_dosen (namaDosen, noHP) VALUES ('$nama_dosen', '$no_hp')";

    // Menjalankan query
    if (mysqli_query($link, $query)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }

    // Menutup koneksi
    mysqli_close($link);
}
?>
