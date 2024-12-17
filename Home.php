<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) { // Gantilah 'username' dengan nama sesi yang sesuai
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan eksekusi script berhenti setelah alihan
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_Home.css"> <!-- Link ke file CSS -->
    <title>Home</title>
    <video autoplay muted loop id="yuriVideo">
        <source src="assets/background1.mp4" type="video/mp4">
    </video>
</head>
<body>

<div class="topnav">
    <center>
        <div class="logo-container">
            <img src="assetsguru/logo.png" alt="Logo Alexandria" class="logo-alexandria">
            <h1 class="school-title">ALEXANDRIA SCHOOL</h1>
        </div>
    </center>
</div>

<div class="topnav">
<a href="Home.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Logo" class="nav-logo"> Home</a>
  <a href="data_siswa.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon"> Data Siswa</a>
  <a href="data_guru.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Guru</a>
  <a href="data_presensi.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Presensi</a>
  <a href="logout.php"><img src="https://img.icons8.com/material-sharp/24/ffffff/exit.png" alt="Log Out Icon">Logout</a>
    
</div>

<center>
    <div class="content"><br><br><br><br><br><br><br>
        <h1>SELAMAT DATANG</h1>
        <p>ALEXANDRIA SCHOOL</p>
        <img src="assetsguru/logo.png" alt="Logo Alexandria" class="logo-alexandria-large">
    </div>
</center>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center>
    <div class="footer">
        <h3>Copyright 2024 Aisyah Suci M</h3>
    </div>
</center>

</body>
</html>
