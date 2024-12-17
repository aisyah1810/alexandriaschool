<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nama_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    
   // Proses upload foto
$foto_path = ''; // Inisialisasi variabel foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    // Ambil nama file foto
    $foto = basename($_FILES['foto']['name']); // Nama file asli
    $foto = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $foto); // Sanitasi nama file
    $folder = 'assets/';
    $foto_path = $folder . $foto; // Path untuk database

    // Validasi ekstensi file
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        echo '<script>
        alert("Hanya file JPG, JPEG, dan PNG yang diperbolehkan.");
        document.location.href = "data_siswa.php";
        </script>';
        exit;
    }

    // Tambahkan timestamp jika file sudah ada
    if (file_exists($foto_path)) {
        $foto = time() . '_' . $foto;
        $foto_path = $folder . $foto; // Update path untuk database
    }

    // Pindahkan foto ke folder tujuan
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
        echo '<script>
        alert("Gagal mengupload foto!");
        document.location.href = "data_siswa.php";
        </script>';
        exit;
    }
}


    // Cek apakah NISN sudah ada di database
    $cek_query = "SELECT * FROM master_siswa WHERE NISN = ?";
    $stmt = $koneksi->prepare($cek_query);
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika NISN sudah ada
        echo '<script>
        alert("NISN sudah terdaftar. Gunakan NISN yang berbeda.");
        document.location.href = "data_siswa.php";
        </script>';
    } else {
        // Simpan data ke database
        $insert_query = "INSERT INTO master_siswa (NISN, Nama_Siswa, Kelas, Tanggal_Lahir, Umur, Alamat, Foto) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($insert_query);
        $stmt_insert->bind_param("sssssss", $nisn, $nama_siswa, $kelas, $tanggal_lahir, $umur, $alamat, $foto_path);

        if ($stmt_insert->execute()) {
            echo '<script>
            alert("Data siswa berhasil ditambahkan!");
            document.location.href = "data_siswa.php";
            </script>';
        } else {
            echo '<script>
            alert("Gagal menambahkan data siswa: ' . $stmt_insert->error . '");
            document.location.href = "data_siswa.php";
            </script>';
        }
        $stmt_insert->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/style_tambah.css">
</head>
<body>

<div class="container">
    <h2>Tambah Data Siswa</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nisn">NISN:</label>
            <input type="text" class="form-control" id="nisn" name="nisn" required>
        </div>
        <div class="form-group">
            <label for="nama_siswa">Nama Siswa:</label>
            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>
        <div class="form-group">
            <label for="umur">Umur:</label>
            <input type="number" class="form-control" id="umur" name="umur" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
        </div>
        <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="assets/*">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
        <a href="data_siswa.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>

