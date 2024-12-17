<?php

session_start();

include 'koneksi.php';

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Sanitasi input pengguna (optional)
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    // Cek apakah username ada di database
    $stmt = $koneksi->prepare("SELECT * FROM login_user WHERE user = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Username tidak ditemukan
        $error = "Username Tidak Ditemukan";
    } else {
        $user = $result->fetch_assoc();

        // Cek apakah password cocok
        if (!password_verify($password, $user["password"])) {
            // Password tidak cocok
            $error = "Password Tidak Ditemukan";
        } else {
            // Login berhasil, simpan session
            $_SESSION["siswa"] = [
                "nama" => $user["nama"]
            ];

            echo "
            <script>
                alert('Anda Berhasil Login');
                document.location.href = 'absensi_siswa.php'; // Redirect ke halaman absensi
            </script>
            ";
        }
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
        <h2>Login User</h2>
        
        <!-- Menampilkan pesan kesalahan jika ada -->
        <?php if (isset($error)) : ?>
            <p style="color: red; font-size: 14px; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <p>Masukkan username dan password untuk melanjutkan.</p>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Login</button>
            <a href="login_utama.php" class="btn-kembali">Kembali</a>
        </form>
    </div>
</body>
</html>
