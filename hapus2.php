<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Menghubungkan ke database

// Memeriksa apakah ID dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Mengambil ID dari URL

    // Query untuk menghapus data
    $sql = "DELETE FROM presensi_siswa WHERE id = ?"; // Pastikan nama tabel sesuai dengan yang Anda gunakan

    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter, "i" untuk integer

    // Menjalankan query dan memeriksa hasilnya
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
    $_SESSION['notifikasi'] = "ID siswa tidak ditemukan.";
}

// Redirect kembali ke halaman data presensi
header("Location: data_presensi.php");
exit();
?>