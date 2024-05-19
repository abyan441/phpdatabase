<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_kuliah";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// CRUD Operations for t_dosen
// Create or Update Dosen
if (isset($_POST['submit_dosen'])) {
    $namaDosen = sanitize_input($_POST['namaDosen']);
    $noHPDosen = sanitize_input($_POST['noHPDosen']);
    
    if (!empty($_POST['idDosen'])) {
        $idDosen = $_POST['idDosen'];
        $sql = "UPDATE t_dosen SET namaDosen='$namaDosen', noHP='$noHPDosen' WHERE idDosen=$idDosen";
    } else {
        $sql = "INSERT INTO t_dosen (namaDosen, noHP) VALUES ('$namaDosen', '$noHPDosen')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated/created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Dosen
if (isset($_GET['delete_dosen'])) {
    $idDosen = $_GET['delete_dosen'];
    $sql = "DELETE FROM t_dosen WHERE idDosen=$idDosen";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// CRUD Operations for t_mahasiswa
// Create or Update Mahasiswa
if (isset($_POST['submit_mahasiswa'])) {
    $namaMhs = sanitize_input($_POST['namaMhs']);
    $prodi = sanitize_input($_POST['prodi']);
    $alamat = sanitize_input($_POST['alamat']);
    $noHPMhs = sanitize_input($_POST['noHPMhs']);
    
    if (!empty($_POST['npm'])) {
        $npm = $_POST['npm'];
        $sql = "UPDATE t_mahasiswa SET namaMhs='$namaMhs', prodi='$prodi', alamat='$alamat', noHP='$noHPMhs' WHERE npm=$npm";
    } else {
        $sql = "INSERT INTO t_mahasiswa (namaMhs, prodi, alamat, noHP) VALUES ('$namaMhs', '$prodi', '$alamat', '$noHPMhs')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated/created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Mahasiswa
if (isset($_GET['delete_mahasiswa'])) {
    $npm = $_GET['delete_mahasiswa'];
    $sql = "DELETE FROM t_mahasiswa WHERE npm=$npm";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// CRUD Operations for t_matakuliah
// Create or Update Mata Kuliah
if (isset($_POST['submit_matakuliah'])) {
    $namaMK = sanitize_input($_POST['namaMK']);
    $sks = sanitize_input($_POST['sks']);
    $jam = sanitize_input($_POST['jam']);
    
    if (!empty($_POST['kodeMK'])) {
        $kodeMK = $_POST['kodeMK'];
        $sql = "UPDATE t_matakuliah SET namaMK='$namaMK', sks='$sks', jam='$jam' WHERE kodeMK=$kodeMK";
    } else {
        $sql = "INSERT INTO t_matakuliah (namaMK, sks, jam) VALUES ('$namaMK', '$sks', '$jam')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated/created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Mata Kuliah
if (isset($_GET['delete_matakuliah'])) {
    $kodeMK = $_GET['delete_matakuliah'];
    $sql = "DELETE FROM t_matakuliah WHERE kodeMK=$kodeMK";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Search function
if (isset($_POST['search'])) {
    $search = sanitize_input($_POST['search']);
    $sql_dosen = "SELECT * FROM t_dosen WHERE namaDosen LIKE '%$search%'";
    $sql_mahasiswa = "SELECT * FROM t_mahasiswa WHERE namaMhs LIKE '%$search%'";
    $sql_matakuliah = "SELECT * FROM t_matakuliah WHERE namaMK LIKE '%$search%'";
} else {
    $sql_dosen = "SELECT * FROM t_dosen";
    $sql_mahasiswa = "SELECT * FROM t_mahasiswa";
    $sql_matakuliah = "SELECT * FROM t_matakuliah";
}

$result_dosen = $conn->query($sql_dosen);
$result_mahasiswa = $conn->query($sql_mahasiswa);
$result_matakuliah = $conn->query($sql_matakuliah);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Web App</title>
    <style>
/* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

h1, h2 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* Form Styling */
form {
    margin-bottom: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

input[type="text"], button[type="submit"] {
    padding: 10px;
    margin-right: 10px;
    width: calc(50% - 15px);
    border: 1px solid #ccc;
    border-radius: 4px;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    width: auto;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Action Links Styling */
.action-links a {
    text-decoration: none;
    padding: 6px 10px;
    margin-right: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
}

.action-links a:hover {
    background-color: #f2f2f2;
}
    </style>
</head>
<body>
    <h1>CRUD Web App</h1>
    <h2>Search</h2>
<form method="post" action="">
    <input type="text" name="search" placeholder="Search by Name">
    <button type="submit">Search</button>
</form>
    <h2>Data Dosen</h2>
    <form method="post" action="">
        <input type="hidden" name="idDosen" value="">
        <input type="text" name="namaDosen" placeholder="Nama Dosen">
        <input type="text" name="noHPDosen" placeholder="Nomor HP Dosen">
        <button type="submit" name="submit_dosen">Submit</button>
    </form>
    <br>
    <table border="1">
        <tr>
            <th>Nama Dosen</th>
            <th>Nomor HP</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result_dosen->fetch_assoc()): ?>
            <tr>
    <td><?php echo $row['namaDosen']; ?></td>
    <td><?php echo $row['noHP']; ?></td>
    <td>
        <a href="?delete_dosen=<?php echo $row['idDosen']; ?>">Delete</a>
        <a href="?edit_dosen=<?php echo $row['idDosen']; ?>">Edit</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<h2>Data Mahasiswa</h2>
<form method="post" action="">
    <input type="hidden" name="npm" value="">
    <input type="text" name="namaMhs" placeholder="Nama Mahasiswa">
    <input type="text" name="prodi" placeholder="Program Studi">
    <input type="text" name="alamat" placeholder="Alamat Mahasiswa">
    <input type="text" name="noHPMhs" placeholder="Nomor HP Mahasiswa">
    <button type="submit" name="submit_mahasiswa">Submit</button>
</form>
<br>
<table border="1">
    <tr>
        <th>Nama Mahasiswa</th>
        <th>Program Studi</th>
        <th>Alamat</th>
        <th>Nomor HP</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result_mahasiswa->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['namaMhs']; ?></td>
            <td><?php echo $row['prodi']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['noHP']; ?></td>
            <td>
                <a href="?delete_mahasiswa=<?php echo $row['npm']; ?>">Delete</a>
                <a href="?edit_mahasiswa=<?php echo $row['npm']; ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Data Mata Kuliah</h2>
<form method="post" action="">
    <input type="hidden" name="kodeMK" value="">
    <input type="text" name="namaMK" placeholder="Nama Mata Kuliah">
    <input type="text" name="sks" placeholder="Jumlah SKS">
    <input type="text" name="jam" placeholder="Jumlah Jam">
    <button type="submit" name="submit_matakuliah">Submit</button>
</form>
<br>
<table border="1">
    <tr>
        <th>Nama Mata Kuliah</th>
        <th>Jumlah SKS</th>
        <th>Jumlah Jam</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result_matakuliah->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['namaMK']; ?></td>
            <td><?php echo $row['sks']; ?></td>
            <td><?php echo $row['jam']; ?></td>
            <td>
                <a href="?delete_matakuliah=<?php echo $row['kodeMK']; ?>">Delete</a>
                <a href="?edit_matakuliah=<?php echo $row['kodeMK']; ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>