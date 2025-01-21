<?php
session_start();
// Koneksi ke database
include 'database/db.php';

// Cek jika form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username dan password kosong
    if (empty($username) || empty($password)) {
        echo "Username atau password tidak boleh kosong";
        exit();
    }

    // Query untuk memeriksa apakah username ada di database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah username ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifikasi password (pastikan password di database sudah di-hash)
        if (password_verify($password, $row['password'])) {
            // Jika login berhasil, set session dan arahkan ke halaman dashboard
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Ganti dengan halaman yang diinginkan setelah login
            exit();
        } else {
            echo "Password salah";
        }
    } else {
        echo "Username tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/login.css">
    <link rel="website icon" type="png" href="tampilan/Pngtree book.png">
    <title>Login | Raport</title>
</head>

<body>

    <div class="container" id="container">
        <div class="toggle-container">
            <img src="tampilan/Pngtree book.png" alt="logo">
            <p>Raport Penilaian</p>
        </div>

        <div class="form-container sign-in">
            <form action="login.php" method="POST">
                <h1>Selamat Datang</h1>
                <span>Di Aplikasi Raport Penilaian</span>
                <div class="input-container">
                    <input type="text" placeholder="Username" name="username" required>
                    <img src="tampilan/icon/user-solid.svg" alt="email">
                </div>
                <div class="input-container">
                    <input type="password" placeholder="Password" name="password" required>
                    <img src="tampilan/icon/lock-solid.svg" alt="password">
                </div>
                <button>login</button>
                <div class="social-icons">
                    <a href="#" class="icon"><img src="tampilan/icon/facebook.svg" alt="Facebook"></a>
                    <a href="#" class="icon"><img src="tampilan/icon/instagram.svg" alt="Instagram"></a>
                    <a href="#" class="icon"><img src="tampilan/icon/github-brands-solid.svg" alt="GitHub"></a>
                    <a href="#" class="icon"><img src="tampilan/icon/x-twitter-brands-solid.svg" alt="Twitter"></a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
