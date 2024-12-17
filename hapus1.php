<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Menghubungkan ke database

if (isset($_GET['id'])) {
    $nip = $_GET['id']; // Mengambil NIP dari URL

    // Query untuk menghapus data
    $sql = "DELETE FROM master_guru WHERE NIP = ?";
    
    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $nip);
    
    if ($stmt->execute()) {
        // Menampilkan alert berhasil dihapus
        echo '<script>
                alert("Data berhasil dihapus.");
                document.location.href = "data_guru.php";
              </script>';
    } else {
        // Menampilkan alert gagal dihapus
        echo '<script>
                alert("Gagal menghapus data.");
                document.location.href = "data_guru.php";
              </script>';
    }
    
    $stmt->close(); // Menutup statement
} else {
    // Jika tidak ada ID yang diberikan
    echo '<script>
            alert("ID guru tidak ditemukan.");
            document.location.href = "data_guru.php";
          </script>';
}
?>
