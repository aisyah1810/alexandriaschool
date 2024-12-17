<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Menghubungkan ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) { // Gantilah 'username' dengan nama sesi yang sesuai
    header("Location: login.php");
    exit();
}

// Mendapatkan kata kunci pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = mysqli_real_escape_string($koneksi, $search); // Escape input pengguna
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_data3.css">
    <title>Data Presensi</title>
</head>
<body>

    <!-- NAVBAR -->
    <div class="topnav">
        <center>
            <font color="white"><h1>DATA PRESENSI</h1></font>
        </center>
    </div>

    <div class="topnav">
<a href="Home.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Logo" class="nav-logo"> Home</a>
  <a href="data_siswa.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon"> Data Siswa</a>
  <a href="data_guru.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Guru</a>
  <a href="data_presensi.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Presensi</a>
  <a href="logout.php"><img src="https://img.icons8.com/material-sharp/24/ffffff/exit.png" alt="Log Out Icon">Logout</a>
    
</div>

    <!-- FORM PENCARIAN -->
    <center>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari Data Presensi..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>
    </center>

    <!-- TOMBOL AKSI -->
    <br><br>
    <center>
        <div class="action-buttons">
            <center>
                <a href="tambah2.php" class="add-button">Tambah Data</a>
                <button class="print-button" onclick="printTable()">Cetak Data</button>
            </center>
        </div>
    </center>
    <br/><br/>

    <!-- TABEL DATA PRESENSI -->
    <table class="tb">
        <tr>
            <th>NO</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>NISN</th>
            <th>Status Kehadiran</th>
            <th>Waktu Kehadiran</th>
            <th class="no-print">Aksi</th>
        </tr>
        <?php 
        $no = 1;
        // Query pencarian data presensi
        $query = "SELECT * FROM vPresSiswaKelas WHERE 
                  Nama_Siswa LIKE '%$search%' OR 
                  Kelas LIKE '%$search%' OR 
                  NISN LIKE '%$search%' OR 
                  Status_Kehadiran LIKE '%$search%' OR 
                  Waktu_Kehadiran LIKE '%$search%'";

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
            <td class="action-buttons no-print">
                <a href="edit2.php?id=<?php echo $d['id']; ?>">EDIT</a>
            </td>
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

<script src="print2.js"></script>

</body>
</html>
