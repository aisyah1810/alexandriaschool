<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
        echo "<script>alert('Data tidak ditemukan!'); window.location='data_siswa.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID siswa tidak ditemukan!'); window.location='data_siswa.php';</script>";
    exit();
}

// Proses jika form dikirim (edit atau hapus)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        // Ambil data dari form
        $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
        $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
        $tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
        $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

        // Proses update foto (jika diunggah)
        $foto = $row['foto']; // Gunakan foto lama sebagai default
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $foto_name = strtolower(basename($_FILES['foto']['name'])); // Nama file menjadi lowercase
            $foto = "assets/" . $foto_name;
            $target = __DIR__ . "/" . $foto;

            // Validasi ekstensi file
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));

            if (!in_array($file_extension, $allowed_extensions)) {
                echo "<script>alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan!');</script>";
                exit();
            }

            // Pindahkan file ke folder assets
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                // Hapus foto lama jika ada
                if (!empty($row['foto']) && file_exists(__DIR__ . "/" . $row['foto'])) {
                    unlink(__DIR__ . "/" . $row['foto']);
                }
            } else {
                echo "<script>alert('Gagal mengunggah foto! Periksa izin folder atau ukuran file.');</script>";
            }
        }

        // Update data siswa
        $update_query = "UPDATE master_siswa SET Nama_Siswa = ?, Kelas = ?, Tanggal_Lahir = ?, Umur = ?, Alamat = ?, foto = ? WHERE NISN = ?";
        $stmt_update = $koneksi->prepare($update_query);
        $stmt_update->bind_param("sssssss", $nama_siswa, $kelas, $tanggal_lahir, $umur, $alamat, $foto, $nisn);

        if ($stmt_update->execute()) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location='data_siswa.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data.');</script>";
        }
        $stmt_update->close();
    } elseif (isset($_POST['hapus'])) {
        // Hapus data siswa
        if (!empty($row['foto']) && file_exists(__DIR__ . "/" . $row['foto'])) {
            unlink(__DIR__ . "/" . $row['foto']); // Hapus file foto
        }

        $delete_query = "DELETE FROM master_siswa WHERE NISN = ?";
        $stmt_delete = $koneksi->prepare($delete_query);
        $stmt_delete->bind_param("s", $nisn);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='data_siswa.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data.');</script>";
        }
        $stmt_delete->close();
    }
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
    <form method="POST" enctype="multipart/form-data">
        <div class="detail-container">
            <!-- Menampilkan foto siswa -->
            <img src="<?php echo file_exists($row['foto']) ? $row['foto'] : 'assets/default.jpg'; ?>" 
                 alt="Foto Siswa" 
                 width="150" height="150">

            <p>
                <label>Nama Siswa:</label>
                <input type="text" name="nama_siswa" value="<?php echo htmlspecialchars($row['Nama_Siswa']); ?>" required>
            </p>
            <p>
                <label>Kelas:</label>
                <select name="kelas" required>
                    <option value="X" <?php echo $row['Kelas'] == "X" ? "selected" : ""; ?>>X</option>
                    <option value="XI" <?php echo $row['Kelas'] == "XI" ? "selected" : ""; ?>>XI</option>
                    <option value="XII" <?php echo $row['Kelas'] == "XII" ? "selected" : ""; ?>>XII</option>
                </select>
            </p>
            <p>
                <label>Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars($row['Tanggal_Lahir']); ?>" required>
            </p>
            <p>
                <label>Umur:</label>
                <input type="number" name="umur" value="<?php echo htmlspecialchars($row['Umur']); ?>" required>
            </p>
            <p>
                <label>Alamat:</label>
                <textarea name="alamat" rows="3" required><?php echo htmlspecialchars($row['Alamat']); ?></textarea>
            </p>
            <p>
                <label for="foto">Upload Foto</label>
                <input type="file" id="foto" name="foto">
            </p>
            <button type="submit" name="edit">Update</button>
        </div>
    </form>

    <!-- Form Hapus -->
    <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        <button type="submit" name="hapus">Hapus Data</button>
    </form>

    <a href="data_siswa.php">Kembali</a>
</body>
</html>
