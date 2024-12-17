<?php
session_start();
include 'koneksi.php';

// Cek apakah ID NISN ada di URL
if (isset($_GET['id'])) {
    $nisn = $_GET['id'];
    $query = "SELECT * FROM master_siswa WHERE NISN = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo '<script>
        alert("Data siswa tidak ditemukan!");
        document.location.href = "data_siswa.php";
        </script>';
        exit();
    }
    $stmt->close();
} else {
    header("Location: data_siswa.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = $_POST['NISN'];
    $nama = $_POST['Nama_Siswa'];
    $kelas = $_POST['Kelas'];
    $tanggal_lahir = $_POST['Tanggal_Lahir'];
    $umur = (new DateTime())->diff(new DateTime($tanggal_lahir))->y; // Hitung umur otomatis
    $alamat = $_POST['Alamat'];

    if (
        $nama == $data['Nama_Siswa'] &&
        $kelas == $data['Kelas'] &&
        $tanggal_lahir == $data['Tanggal_Lahir'] &&
        $umur == $data['Umur'] &&
        $alamat == $data['Alamat']
    ) {
        echo '<script>
        alert("Data anda belum diubah.");
        document.location.href = "edit.php?id=' . $nisn . '";
        </script>';
        exit();
    }

    $query = "UPDATE master_siswa 
              SET Nama_Siswa = ?, Kelas = ?, Tanggal_Lahir = ?, Umur = ?, Alamat = ?
              WHERE NISN = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssss", $nama, $kelas, $tanggal_lahir, $umur, $alamat, $nisn);
    
    if ($stmt->execute()) {
        echo '<script>
        alert("Data siswa berhasil diperbarui!");
        document.location.href = "data_siswa.php";
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    exit();
}
?>

<?php
// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) { // Gantilah 'username' dengan nama sesi yang sesuai
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit(); // Pastikan eksekusi script berhenti setelah alihan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style_edit.css">
</head>
<body>
<form method="post" action="">
    <label for="NISN">NISN:</label>
    <input type="text" id="NISN" name="NISN" value="<?php echo $data['NISN']; ?>" required><br>

    Nama Siswa: <input type="text" name="Nama_Siswa" value="<?php echo $data['Nama_Siswa']; ?>" required><br>
    
    <label for="Kelas">Kelas:</label>
    <select id="Kelas" name="Kelas" required>
         <option value="pilih">Pilih Kelas</option>
        <option value="X" <?php echo ($data['Kelas'] == 'X') ? 'selected' : ''; ?>>X</option>
        <option value="XI" <?php echo ($data['Kelas'] == 'XI') ? 'selected' : ''; ?>>XI</option>
        <option value="XII" <?php echo ($data['Kelas'] == 'XII') ? 'selected' : ''; ?>>XII</option>
    </select>
    <br><br>
    
    Tanggal Lahir: <input type="date" name="Tanggal_Lahir" value="<?php echo $data['Tanggal_Lahir']; ?>" required><br>
    <p>Umur: <?php echo $data['Umur']; ?></p>
    <textarea name="Alamat" required><?php echo $data['Alamat']; ?></textarea><br>

    <button type="submit" class="btn-update">Update</button>
    <a href="data_siswa.php" class="btn-kembali">Kembali</a>
