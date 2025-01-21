<?php
// Koneksi ke database
include 'database/db.php';

// Proses simpan data ketika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Query untuk menyimpan data pengguna baru
    $sql = "INSERT INTO users (username, nama_lengkap, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $nama_lengkap, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil ditambahkan'); window.location.href='?page=admin';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tampilan/profile.css">
  <title>Tambah Pengguna</title>
</head>

<body>
    <div class="head-title">
        <div class="left">
            <h1>Tambah Pengguna</h1>
            <ul class="breadcrumb">
                <li><a href="profile.php">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Add Users</a></li>
            </ul>
        </div>
    </div>
    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Tambah Pengguna</h3>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="add-profile-btn">Tambah Pengguna</button>
                    <a href="?page=admin"><button type="button" class="close-btn">Batal</button></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
