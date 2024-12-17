<?php
session_start();
include 'koneksi.php';
?>

<?php
// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/style_data.css">
</head>
<body>

<!-- UNTUK NAVBAR -->
<div class="topnav">
    <center>
        <font color="white"><h1>DATA SISWA</h1></font>
    </center>
</div>

<div class="topnav">
<a href="Home.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Logo" class="nav-logo"> Home</a>
  <a href="data_siswa.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon"> Data Siswa</a>
  <a href="data_guru.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Guru</a>
  <a href="data_presensi.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Presensi</a>
  <a href="logout.php"><img src="https://img.icons8.com/material-sharp/24/ffffff/exit.png" alt="Log Out Icon">Logout</a>
    
</div>

<br><br>
<!-- Form Pencarian -->
<center>
    <form method="GET" action="data_siswa.php">
        <input type="text" name="search" placeholder="Cari siswa..." class="search-input" required>
        <input type="submit" value="Cari" class="search-button">
    </form>
</center>

<!-- Data Siswa -->
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM master_siswa WHERE Nama_Siswa LIKE '%$search%' OR NISN LIKE '%$search%'";
$result = mysqli_query($koneksi, $query);
?>

<center>
    <br><br>
    <link rel="stylesheet" href="css/style_tabelfoto.css">
    <a href="tambah.php" class="add-button">Tambah Data</a>
    <a href="#" class="print-button" onclick="printTable()">Cetak Data</a>
    <br><br>
    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="card">
                    <img src="<?php echo $row['foto']; ?>" alt="Foto Siswa">
                    <h3><?php echo $row['Nama_Siswa']; ?></h3>
                    <p>NISN: <?php echo $row['NISN']; ?></p>
                    <a href="detail.php?id=<?php echo $row['NISN']; ?>" class="btn-detail">Detail</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Data siswa tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</center>

<!-- UNTUK FOOTER -->
<center>
    <div class="footer">
        <font color="white"><p>Copyright 2024 Aisyah Suci M</p></font>
    </div>
</center>

<!-- Link JavaScript untuk fungsi print -->
<script src="print.js"></script>

</body>
</html>
