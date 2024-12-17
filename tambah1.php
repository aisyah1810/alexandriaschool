<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NIP = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $Nama_Guru = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $Jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $Tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $Umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $Alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Proses upload foto
    $foto = ''; // Variabel untuk menyimpan nama file foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Tentukan folder penyimpanan
        $folder = 'assetsguru/';

        // Generate nama file unik
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Ambil ekstensi file
        $foto = uniqid('foto_', true) . '.' . $ext; // Nama file unik, contoh: foto_123456.jpg
        $foto_path = $folder . $foto;

        // Pindahkan file ke folder tujuan
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            echo '<script>
                alert("Gagal mengupload foto!");
                document.location.href = "data_guru.php";
            </script>';
            exit;
        }
    }

    // Cek apakah NIP sudah ada di database
    $cek_query = "SELECT * FROM master_guru WHERE NIP = ?";
    $stmt = $koneksi->prepare($cek_query);
    $stmt->bind_param("s", $NIP);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika NIP sudah ada
        echo '<script>
            alert("NIP sudah terdaftar. Gunakan NIP yang berbeda.");
            document.location.href = "data_guru.php";
        </script>';
    } else {
        // Simpan data ke database
        $query = "INSERT INTO master_guru (NIP, Nama_Guru, Jabatan, Tanggal_lahir, Umur, Alamat, Foto) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query);

        if ($stmt_insert) {
            $stmt_insert->bind_param("sssssss", $NIP, $Nama_Guru, $Jabatan, $Tanggal_lahir, $Umur, $Alamat, $foto);
            if ($stmt_insert->execute()) {
                echo '<script>
                    alert("Data guru berhasil ditambahkan!");
                    document.location.href = "data_guru.php";
                </script>';
            } else {
                echo '<script>
                    alert("Gagal menambahkan data guru.");
                    document.location.href = "data_guru.php";
                </script>';
            }
            $stmt_insert->close(); // Tutup prepared statement
        } else {
            echo '<script>
                alert("Terjadi kesalahan saat memproses data.");
                document.location.href = "data_guru.php";
            </script>';
        }
    }
}
?>
<form method="POST" action="tambah1.php" enctype="multipart/form-data">
<link rel="stylesheet" type="text/css" href="css/style_edit.css">
    NIP: <input type="text" name="nip" required><br>
    Nama Guru: <input type="text" name="nama" required><br>
    Jabatan: <input type="text" name="jabatan" required><br>
    Tanggal Lahir: <input type="date" name="tanggal_lahir" required><br>
    Umur: <input type="text" name="umur" required><br>
    Alamat: <textarea name="alamat" required></textarea><br>
    Foto: <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit" class="btn-update">Tambah data</button>
    <a href="data_guru.php" class="btn-kembali">Kembali</a>
</form>


</body>
</html>
