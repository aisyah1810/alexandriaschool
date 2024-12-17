<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION["siswa"])) {
    header("Location: login_user.php");
    exit(); // Pastikan script berhenti setelah pengalihan
}

include 'koneksi.php'; // Koneksi ke database

// Mendapatkan kata kunci pencarian
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Menyimpan kata kunci pencarian

// Query untuk mengambil data siswa yang sesuai dengan pencarian
$query = "SELECT * FROM master_siswa WHERE Nama_Siswa LIKE '%$search%' OR NISN LIKE '%$search%'";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <!-- Link CSS Bootstrap di dalam <head> halaman HTML -->
    <link rel="stylesheet" href="css/style_data11.css"> <!-- Pastikan jalur ini benar -->
</head>
<body>

<!-- NAVBAR -->
<div class="topnav">
    <center>
        <font color="white"><h1>DATA SISWA</h1></font>
    </center>
</div>

<div class="topnav">
  <a href="Homeuser.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Logo" class="nav-logo"> Home</a>
  <a href="absensi_siswa.php"> <img src="https://img.icons8.com/material-outlined/24/ffffff/clock.png" alt="Absensi Icon"> Absensi</a>
  <a href="data_siswa_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon"> Data Siswa</a>
  <a href="data_guru_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Guru</a>
  <a href="data_presensi_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Presensi</a>
  <a href="logout_user.php"><img src="https://img.icons8.com/material-sharp/24/ffffff/exit.png" alt="Log Out Icon">Logout</a>
    
</div>

<!-- FORM PENCARIAN -->
<center>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari Data Siswa..." value="<?php echo $search; ?>">
        <button type="submit">Cari</button>
    </form>
</center>

<!-- Data Siswa -->
<center>
    <br><br>
    <link rel="stylesheet" href="css/style_tabelfoto.css"> <!-- Pastikan jalur ini benar -->
    <br><br>
    <div class="container">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="card">
                <!-- Foto -->
                <img src="<?php echo $row['foto']; ?>" alt="Foto Siswa">
                
                <!-- Nama dan NISN -->
                <h3><?php echo $row['Nama_Siswa']; ?></h3>
                <p>NISN: <?php echo $row['NISN']; ?></p>

                <!-- Tombol Detail -->
                <a href="detail_user.php?id=<?php echo $row['NISN']; ?>" class="btn-detail">Detail</a>
            </div>
        <?php endwhile; ?>
    </div>
</center>

<!-- FOOTER -->
<center>
    <div class="footer">
       <font color="white"><p>&copy; Copyright 2024 Aisyah Suci M</p></font>
    </div>
</center>

<!--link javascript print-->
<script src="print.js"></script>

</body>
</html>
