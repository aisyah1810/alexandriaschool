<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Menghubungkan ke database

// Cek apakah pengguna sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION["siswa"])) {
    header("Location: login_user.php");
    exit(); // Pastikan script berhenti setelah pengalihan
}

// Mendapatkan kata kunci pencarian
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Menyimpan kata kunci pencarian
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_data33.css"> <!-- Link ke file CSS -->
    <title>Data Presensi</title>
</head>
<body>

<!-- UNTUK NAVBAR -->
<div class="topnav">
    <center>
        <font color="white"><h1>DATA PRESENSI</h1></font>
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
        <input type="text" name="search" placeholder="Cari Nama, NISN, Status..." value="<?php echo $search; ?>">
        <button type="submit">Cari</button>
    </form>
</center>
<br><br>

<!-- TABEL PRESENSI SISWA -->
<table class="tb">
    <tr>
        <th>NO</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>NISN</th>
        <th>Status Kehadiran</th>
        <th>Waktu Kehadiran</th>
    </tr>
    <?php 
    $no = 1;
    // Query untuk mengambil data presensi siswa yang sesuai dengan pencarian
    $query = "SELECT * FROM vPresSiswaKelas WHERE 
              Nama_Siswa LIKE '%$search%' OR 
              NISN LIKE '%$search%' OR 
              Status_Kehadiran LIKE '%$search%'";

    $data = mysqli_query($koneksi, $query);
    while ($d = mysqli_fetch_array($data)) {
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['Nama_Siswa']; ?></td>
        <td><?php echo $d['Kelas']; ?></td>
        <td><?php echo $d['NISN']; ?></td>
        <td><?php echo $d['Status_Kehadiran']; ?></td>
        <td><?php echo $d['Waktu_Kehadiran']; ?></td>
    </tr>
    <?php 
    }
    ?>
</table>

<!-- FOOTER -->
<center>
    <div class="footer">
        <font color="white"><p>&copy; Copyright 2024 Aisyah Suci M</p></font>
    </div>
</center>

</body>
</html>
