<?php
session_start();
include 'koneksi.php';

// Ambil ID siswa dari URL
if (isset($_GET['id'])) {
    $nisn = $_GET['id'];

    // Query untuk mendapatkan data siswa berdasarkan NISN
    $query = "SELECT * FROM master_siswa WHERE NISN = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='data_siswa_user.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID siswa tidak ditemukan!'); window.location='data_siswa_user.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_detail.css">
    <title>Detail Siswa</title>
</head>
<body>
    <h1>Detail Siswa</h1>
    <div class="detail-container">
       <!-- Menampilkan foto siswa -->
       <img src="<?php echo file_exists($row['foto']) ? $row['foto'] : 'assets/default.jpg'; ?>" 
                 alt="Foto Siswa" 
                 width="150" height="150">

        <p><strong>Nama Siswa:</strong> <?php echo htmlspecialchars($row['Nama_Siswa']); ?></p>
        <p><strong>Kelas:</strong> <?php echo htmlspecialchars($row['Kelas']); ?></p>
        <p><strong>Tanggal Lahir:</strong> <?php echo htmlspecialchars($row['Tanggal_Lahir']); ?></p>
        <p><strong>Umur:</strong> <?php echo htmlspecialchars($row['Umur']); ?></p>
        <p><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($row['Alamat'])); ?></p>
    </div>

    <a href="data_siswa_user.php">Kembali</a>
</body>
</html>
