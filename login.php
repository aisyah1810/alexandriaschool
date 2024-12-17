<?php
session_start();
include 'koneksi.php';

// Variabel untuk pesan kesalahan
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Hash password dengan MD5
    $hashed_password = md5($password);

    // Periksa kecocokan username dan password
    $query = "SELECT * FROM login_aisyah WHERE user= '$username' AND password = '$hashed_password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika login berhasil
        $_SESSION['username'] = $username;
        header('Location: Home.php');
        exit();
    } else {
        // Jika login gagal
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css"> <!-- Link ke file CSS -->
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <!-- Menampilkan pesan kesalahan jika ada -->
        <?php if (!empty($error)) : ?>
            <p style="color: red; font-size: 14px; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <p>Masukkan username dan password untuk melanjutkan.</p>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="login_utama.php" class="btn-kembali">Kembali</a>
        </form>
    </div>
</body>
</html>
