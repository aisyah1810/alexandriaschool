<?php
session_start();

// Mengatur timezone ke Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'presensi_aisyah');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Validasi session siswa
if (!isset($_SESSION["siswa"])) {
    echo "Data siswa tidak ditemukan. Silakan login kembali.";
    exit;
}

$siswa = $_SESSION["siswa"];
$nama = isset($siswa["nama"]) ? $siswa["nama"] : ''; // Default kosong jika nama tidak ada
$nisn_siswa = isset($siswa["nisn"]) ? $siswa["nisn"] : ''; // Default kosong jika nisn tidak ada
$waktu = date('Y-m-d H:i:s'); // Mengambil waktu saat ini dengan zona waktu WIB

// Menangani proses absensi siswa
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan sanitasi input
    $nisn = $conn->real_escape_string($_POST['nisn']);
    $status = $conn->real_escape_string($_POST['status']);

    // Validasi NISN tidak kosong
    if (!empty($nisn)) {
        // Menyimpan data absensi ke tabel presensi_siswa (termasuk waktu_absen)
        $stmt = $conn->prepare("INSERT INTO presensi_siswa (NISN, Status_Kehadiran, Waktu_Kehadiran) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nisn, $status, $waktu); // Mengirimkan nisn, status, dan waktu absensi

        // Eksekusi query
        if ($stmt->execute()) {
            $message = "Absensi berhasil disimpan!";
        } else {
            $message = "Terjadi kesalahan: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "NISN tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="css/style_absensi.css">
</head>
<body>
</div>
<!-- Background Color -->
<body>
    <!-- Header -->
    <header>
        <div class="topnav">
            <center>
                <br>
                <h1 style="color: white;">ABSENSI SISWA</h1><br>
            </center>
    </header>
    <div class="topnav">
  <a href="Homeuser.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Logo" class="nav-logo"> Home</a>
  <a href="absensi_siswa.php"> <img src="https://img.icons8.com/material-outlined/24/ffffff/clock.png" alt="Absensi Icon"> Absensi</a>
  <a href="data_siswa_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon"> Data Siswa</a>
  <a href="data_guru_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Guru</a>
  <a href="data_presensi_user.php"><img src="https://img.icons8.com/material-outlined/24/ffffff/data-configuration.png" alt="Data Icon">Data Presensi</a>
  <a href="logout_user.php"><img src="https://img.icons8.com/material-sharp/24/ffffff/exit.png" alt="Log Out Icon">Logout</a>
</div>

<br><br><br>
    <div class="container">
        <h1>Form Absensi Siswa</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="" method="POST" class="form-absensi">
            <label for="nisn">NISN:</label>
            <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN" value="<?= htmlspecialchars($nisn_siswa) ?>" required>

            <label for="status">Status Kehadiran:</label>
            <select id="status" name="status" required>
                <option value="Hadir">Hadir</option>
                <option value="Tidak Hadir">Alpa</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>

            <button type="submit" class="btn-simpan">Absen</button>
        </form>
         <!-- Tombol Logout di bawah form -->
    </div>
     <!-- Footer -->
     <footer>
        <center>
            <br><br><br><br>
            <div class="footer">
                <p style="color: white;">&copy; Copyright 2024 Aisyah Suci M</p>
            </div>
        </center>
    </footer>
</body>
</html>
