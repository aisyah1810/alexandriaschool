<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

if (isset($_POST["submit"])) {
    $nisn = $_POST["nisn"];
    $status = $_POST["Status_Kehadiran"]; // Konsisten dengan name di HTML
    $waktu = $_POST["waktu"];

    // Langsung melakukan proses insert data
    $insertQuery = $koneksi->prepare("INSERT INTO vpressiswakelas (NISN, Status_Kehadiran, Waktu_Kehadiran) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $nisn, $status, $waktu);

    if ($insertQuery->execute()) {
        echo '<script>
            alert("Data berhasil ditambahkan.");
            document.location.href = "data_presensi.php";
        </script>';
    } else {
        echo '<script>
            alert("Terjadi kesalahan saat menambahkan data.");
            document.location.href = "data_presensi.php";
        </script>';
    }
    $insertQuery->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style_edit.css">
    <title>Tambah Data Presensi</title>
</head>
<body>

<form method="POST" action="">
<br><br><br>
<label for="nisn">NISN</label>
<select name="nisn" required>
            <option value="">Pilih NISN</option>
            <?php
            // Ambil data NISN dari tabel siswa (pastikan tabelnya sesuai dengan database Anda)
            $result = mysqli_query($koneksi, "SELECT NISN, Nama_Siswa FROM master_siswa");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['NISN'] . "'>" . $row['NISN'] . " - " . $row['Nama_Siswa'] . "</option>";
            }
            ?>
            </select>
            <br><br><br>
<label for="status">Status Kehadiran:</label>
    <select name="Status_Kehadiran" required>
            <option value="">Pilih Kehadiran</option>
            <?php
            // Ambil data NISN dari tabel siswa (pastikan tabelnya sesuai dengan database Anda)
            $result = mysqli_query($koneksi, "SELECT Status_Kehadiran FROM vPresSiswaKelas");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Status_Kehadiran'] . "'>" . $row['Status_Kehadiran']. "</option>";
            }
            ?>
    </select><br><br><br>

    <label for="waktu">Waktu Kehadiran:</label>
    <?php
    // Mengambil waktu saat ini dari server
    $current_time = date('Y-m-d\TH:i'); // Format untuk datetime-local
    ?>
    <input type="datetime-local" name="waktu" id="waktu" value="<?php echo $current_time; ?>" required><br><br>

    <button type="submit" name="submit">Tambah Data</button>
    <a href="data_presensi.php" class="btn-kembali">Kembali</a>
</form>

</body>
</html>
