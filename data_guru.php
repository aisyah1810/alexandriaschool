<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Menghubungkan ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) { // Gantilah 'username' dengan nama sesi yang sesuai
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan eksekusi script berhenti setelah alihan
}

// Mendapatkan kata kunci pencarian
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Menyimpan kata kunci pencarian
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_data2.css"> <!-- Link ke file CSS -->
    <title>Data Guru</title>
</head>

<body>

    <!-- NAVBAR -->
    <div class="topnav">
        <center>
            <font color="white"><h1>DATA GURU</h1></font>
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
            <input type="text" name="search" placeholder="Cari Data Guru..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Cari</button>
        </form>
    </center>

    <!-- TOMBOL AKSI -->
    <br><br>
    <center>
        <div class="action-buttons">
            <center>
                <a href="tambah1.php" class="add-button">Tambah Data</a>
                <button class="print-button" onclick="printTable()">Cetak Data</button>
            </center>
        </div>
    </center>
    <br/><br/>

    <!-- TABEL DATA GURU -->
    <div class="table-responsive">
        <table class="tb">
            <tr>
                <th>NO</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th class="no-print">Aksi</th>
            </tr>
            <?php 
            $no = 1;
            // Query pencarian data guru
            $query = "SELECT * FROM master_guru WHERE 
                      Nama_Guru LIKE '%$search%' OR 
                      NIP LIKE '%$search%' OR 
                      Jabatan LIKE '%$search%' OR 
                      Tanggal_lahir LIKE '%$search%' OR 
                      Umur LIKE '%$search%' OR 
                      Alamat LIKE '%$search%'";

            $data = mysqli_query($koneksi, $query);
            while ($d = mysqli_fetch_array($data)) {
                // Tentukan path gambar
                $file_path = "assetsguru/" . $d['foto'];

                // Debugging: Cek apakah file ada dan pathnya benar
                if (!file_exists($file_path)) {
                    echo "File gambar tidak ditemukan: " . $file_path . "<br>"; // Menampilkan pesan error
                    $file_path = "assetsguru/default.jpg"; // Gambar default jika tidak ditemukan
                }
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <!-- Menampilkan foto dari folder assetsguru -->
                <td>
                    <img src="<?php echo $file_path; ?>" alt="Foto Guru" width="90" height="120">
                </td>
                <td><?php echo $d['Nama_Guru']; ?></td>
                <td><?php echo $d['NIP']; ?></td>
                <td><?php echo $d['Jabatan']; ?></td>
                <td><?php echo $d['Tanggal_lahir']; ?></td>
                <td><?php echo $d['Umur']; ?></td>
                <td><?php echo $d['Alamat']; ?></td>
                <td class="action-buttons no-print">
                    <a href="edit1.php?id=<?php echo $d['NIP']; ?>" onclick="return confirm('Apakah Anda yakin ingin mengedit data guru ini?');">EDIT</a>
                    <a href="hapus1.php?id=<?php echo $d['NIP']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data guru ini?');">HAPUS</a>
                </td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </div>

    <!-- FOOTER -->
    <center>
        <div class="footer">
            <font color="white"><p>&copy; Copyright 2024 Aisyah Suci M</p></font>
        </div>
    </center>

<!--link javascript print-->
<script src="print1.js"></script>

</body>
</html>
