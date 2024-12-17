<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari database untuk ditampilkan
$query = "SELECT * FROM master_siswa";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/print.css"> <!-- Pastikan jalur ini benar -->
</head>
<body>
<center>
    <br><br>
    <a href="javascript:void(0);" class="print-button" onclick="printTable()">Cetak Data</a>
    <br><br>

    <!-- Tabel Data Siswa -->
    <table border="1" cellpadding="10" cellspacing="0" class="data-table">
        <h1> Data Siswa </h1>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <!-- Mengatur ukuran gambar dengan CSS -->
                    <td><img src="<?php echo $row['foto']; ?>" alt="Foto Siswa"></td>
                    <td><?php echo $row['Nama_Siswa']; ?></td>
                    <td><?php echo $row['NISN']; ?></td>
                    <td><?php echo $row['Kelas']; ?></td>
                    <td><?php echo $row['Tanggal_Lahir']; ?></td>
                    <td><?php echo $row['Umur']; ?></td>
                    <td><?php echo $row['Alamat']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</center>


<!-- Fungsi untuk mencetak -->
<script>
    function printTable() {
        // Menyembunyikan elemen yang tidak ingin dicetak
        document.querySelector(".print-button").style.display = "none"; // Menyembunyikan tombol cetak

        // Mencetak hanya bagian tabel
        window.print();

        // Menampilkan kembali elemen yang disembunyikan setelah pencetakan selesai
        document.querySelector(".print-button").style.display = "inline-block"; // Menampilkan tombol cetak kembali
    }
</script>

</body>
</html>
