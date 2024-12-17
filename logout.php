<?php
session_start(); // Memulai sesi

// Menghapus semua data sesi yang ada
session_unset(); 

// Menghancurkan sesi
session_destroy();

// Menampilkan alert sebelum mengarahkan ke halaman lain
echo '<script>
alert("Anda yakin logout?");
document.location.href = "login.php"; // Redirect ke halaman Home setelah alert
</script>';
exit(); // Pastikan eksekusi script berhenti setelah JavaScript dijalankan
?>
