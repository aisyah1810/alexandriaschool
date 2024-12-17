<!-- edit2.php -->
<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM vpressiswakelas WHERE id='$id'");
$d = mysqli_fetch_array($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];
    $status = $_POST['Status_Kehadiran'];
    $waktu = $_POST['waktu'];

    // Jika status belum diubah atau 'Belum di rumah'
    if ($status == "Belum diubah") {
        echo '<script>
            alert("Data Anda belum diubah.");
            document.location.href = "edit2.php?id=' . $nisn . '";
        </script>';
    }

    // Update data menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $koneksi->prepare("UPDATE vpressiswakelas SET NISN=?, Status_Kehadiran=?, Waktu_Kehadiran=? WHERE id=?");
    $stmt->bind_param("sssi", $nisn, $status, $waktu, $id);

    if ($stmt->execute()) {
        // Redirect setelah berhasil
        echo '<script>
                alert("Data berhasil diperbarui.");
                window.location.href = "data_presensi.php"; // Menggunakan window.location.href untuk menghindari masalah dengan redirect
              </script>';
        exit; // Jangan lanjutkan eksekusi script setelah redirect
    } else {
        // Jika gagal update
        echo '<script>
                alert("Terjadi kesalahan saat memperbarui data.");
                window.location.href = "data_presensi.php";
              </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style_edit.css">
</head>
<body>

<?php
include 'koneksi.php'; // Pastikan file koneksi sudah disertakan
?>

<form method="POST" action="edit2.php?id=<?php echo $id; ?>">
    <label for="nisn">NISN</label>
    <select name="nisn" required>
        <option value="">Pilih NISN</option>
        <?php
        $result = mysqli_query($koneksi, "SELECT NISN, Nama_Siswa FROM master_siswa") or die(mysqli_error($koneksi));
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . htmlspecialchars($row['NISN'], ENT_QUOTES) . "'>" 
            . htmlspecialchars($row['NISN'], ENT_QUOTES) . " - " . htmlspecialchars($row['Nama_Siswa'], ENT_QUOTES) . "</option>";
        }
        ?>
    </select>
    <br><br><br>

    <label for="status">Status Kehadiran:</label>
    <select name="Status_Kehadiran" required>
        <option value="">Pilih Kehadiran</option>
        <?php
        $result = mysqli_query($koneksi, "SELECT Status_Kehadiran FROM presensi_siswa") or die(mysqli_error($koneksi));
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . htmlspecialchars($row['Status_Kehadiran'], ENT_QUOTES) . "'>" 
            . htmlspecialchars($row['Status_Kehadiran'], ENT_QUOTES) . "</option>";
        }
        ?>
    </select>
    <br><br><br>

    <label for="waktu">Waktu Kehadiran:</label><br><br>
    <?php
    $current_time = date('Y-m-d\TH:i'); // Format untuk datetime-local
    ?>
    <input type="datetime-local" name="waktu" value="<?php echo $current_time; ?>" required>
    <br><br><br>

    <button type="submit" class="form-control">Update</button>
    <a href="data_presensi.php" class="btn-kembali">Kembali</a>
</form>

<?php
// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) { // Gantilah 'username' dengan nama sesi yang sesuai
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan eksekusi script berhenti setelah alihan
}
?>
</body>
</html>
