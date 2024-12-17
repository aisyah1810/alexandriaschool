<?php
session_start(); // Memulai sesi

// Menghapus semua data sesi yang ada
session_unset(); 

// Menghancurkan sesi
session_destroy();

// Menampilkan alert sebelum mengarahkan ke halaman login
echo '<script>
alert("Anda telah logout!");
document.location.href = "login_user.php"; // Redirect ke halaman login setelah logout
</script>';
exit(); // Pastikan eksekusi script berhenti setelah JavaScript dijalankan
?>
