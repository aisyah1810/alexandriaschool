<?php
session_start();
include 'koneksi.php';

$nip = $_GET['id']; // Mengambil NIP dari parameter URL
if (!$nip) {
    echo '<script>
        alert("NIP tidak valid.");
        document.location.href = "data_guru.php";
    </script>';
    exit;
}

// Ambil data guru berdasarkan NIP
$data = mysqli_query($koneksi, "SELECT * FROM master_guru WHERE NIP = '$nip'");
$d = mysqli_fetch_assoc($data);

if (!$d) {
    echo '<script>
        alert("Data tidak ditemukan.");
        document.location.href = "data_guru.php";
    </script>';
    exit;
}

if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nip_baru = mysqli_real_escape_string($koneksi, $_POST['NIP']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $foto_lama = $d['Foto'];

    // Proses upload foto baru jika ada
    $foto_baru = $foto_lama; // Default foto tetap
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $folder = 'assetsguru/';
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed_extensions)) {
            echo '<script>
                alert("Hanya file dengan format JPG, JPEG, dan PNG yang diperbolehkan.");
                document.location.href = "edit1.php?id=' . $nip . '";
            </script>';
            exit;
        }

        $foto_baru = uniqid('foto_', true) . '.' . $ext;
        $foto_path = $folder . $foto_baru;

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            // Hapus file lama jika ada
            if ($foto_lama && file_exists($folder . $foto_lama)) {
                unlink($folder . $foto_lama);
            }
        } else {
            echo '<script>
                alert("Gagal mengunggah foto.");
                document.location.href = "edit1.php?id=' . $nip . '";
            </script>';
            exit;
        }
    }

    // Menggunakan prepared statement untuk update data
    $query = "UPDATE master_guru 
              SET Nama_Guru = ?, NIP = ?, Jabatan = ?, Tanggal_lahir = ?, Umur = ?, Alamat = ?, Foto = ? 
              WHERE NIP = ?";
    $stmt = $koneksi->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $nama, $nip_baru, $jabatan, $tanggal_lahir, $umur, $alamat, $foto_baru, $nip);

        if ($stmt->execute()) {
            echo '<script>
                alert("Data berhasil diperbarui.");
                document.location.href = "data_guru.php";
            </script>';
        } else {
            echo '<script>
                alert("Gagal memperbarui data. Silakan coba lagi.");
                document.location.href = "edit1.php?id=' . $nip . '";
            </script>';
        }
        $stmt->close();
    } else {
        echo '<script>
            alert("Terjadi kesalahan pada server. Silakan coba lagi.");
            document.location.href = "edit1.php?id=' . $nip . '";
        </script>';
    }
}
?>

<?php
// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style_edit.css">
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    Nama: <input type="text" name="nama" value="<?php echo $d['Nama_Guru']; ?>" required><br>
    NIP: <input type="text" name="NIP" value="<?php echo $d['NIP']; ?>" required><br>
    Jabatan: <input type="text" name="jabatan" value="<?php echo $d['Jabatan']; ?>" required><br>
    Tanggal Lahir: <input type="date" name="tanggal_lahir" value="<?php echo $d['Tanggal_lahir']; ?>" required><br>
    Umur: <input type="text" name="umur" value="<?php echo $d['Umur']; ?>" required><br>
    Alamat: <input type="text" name="alamat" value="<?php echo $d['Alamat']; ?>" required><br>
    <label for="foto">Foto:</label>
    <input type="file" class="form-control" id="foto" name="foto" accept="image/jpeg, image/png"><br><br>
    <button type="submit" name="submit" class="btn-update">Update</button>
    <a href="data_guru.php" class="btn-kembali">Kembali</a>
</form>
</body>
</html>
