<?php
// Koneksi ke database
include 'koneksi.php'; // Pastikan koneksi.php berisi informasi koneksi database

// Variabel untuk pesan kesalahan dan sukses
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    // Validasi: pastikan password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        // Hash password menggunakan password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah terdaftar
        $query = "SELECT * FROM login_user WHERE user = '$username'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            // Jika username sudah terdaftar
            $error = "Username sudah terdaftar, coba yang lain!";
        } else {
            // Jika username belum terdaftar, simpan data ke database
            $query = "INSERT INTO login_user (user, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($koneksi, $query)) {
                $success = "Registrasi berhasil! Silakan <a href='login_user.php'>login</a>.";
            } else {
                $error = "Terjadi kesalahan saat mendaftar: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style_register.css"> <!-- Link ke file CSS -->
</head>
<body>
    <div class="register-container">
        <h2>Registrasi Pengguna Baru</h2>

        <!-- Menampilkan pesan kesalahan jika ada -->
        <?php if (!empty($error)): ?>
            <p style="color: red; font-size: 14px; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Menampilkan pesan sukses jika registrasi berhasil -->
        <?php if (!empty($success)): ?>
            <p style="color: green; font-size: 14px; margin-bottom: 15px;"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Form untuk registrasi -->
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit">Daftar</button>
            <a href="login_user.php" class="btn-kembali">Sudah punya akun? Login</a>
        </form>
    </div>
</body>
</html>
