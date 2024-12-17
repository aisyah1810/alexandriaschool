<?php
include 'koneksi.php'; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/style_form.css"> <!-- Add CSS for styling -->
</head>
<body>
    <div class="form-container">
        <h2>Tambah Data Siswa</h2>
        <form action="tambah_aksi.php" method="POST" enctype="multipart/form-data">
            <label for="nisn">NISN:</label>
            <input type="text" id="nisn" name="nisn" required>

            <label for="nama">Nama Siswa:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="kelas">Kelas:</label>
            <input type="text" id="kelas" name="kelas" required>

            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

            <label for="umur">Umur:</label>
            <input type="number" id="umur" name="umur" required>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="4" required></textarea>

            <label for="foto">Foto Siswa:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <button type="submit">Simpan</button>
            <a href="data_siswa.php" class="btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
