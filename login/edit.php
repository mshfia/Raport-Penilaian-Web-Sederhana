<?php
// Koneksi ke database
include 'database/db.php';

// Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);  // Menggunakan tipe integer ('i') karena id_user adalah INT
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Ambil data pengguna sebagai array
    } else {
        echo "<script>alert('Pengguna tidak ditemukan!'); window.location.href='?page=admin';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID pengguna tidak ditemukan!'); window.location.href='?page=admin';</script>";
    exit;
}

// Proses simpan data setelah form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];

    // Hanya update password jika diisi
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        $password = $user['password'];  // Jika password kosong, gunakan password yang ada
    }

    // Query untuk mengupdate data pengguna
    $sql = "UPDATE users SET username = ?, nama_lengkap = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $nama_lengkap, $email, $password, $id);  // Menggunakan tipe 'i' untuk id

    if ($stmt->execute()) {
        echo "<script>alert('Data pengguna berhasil diperbarui'); window.location.href='?page=admin';</script>";
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
  <title>Edit Pengguna</title>
</head>

<body>
    <div class="head-title">
        <div class="left">
            <h1>Edit Pengguna</h1>
            <ul class="breadcrumb">
                <li><a href="profile.php">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Edit Users</a></li>
            </ul>
        </div>
    </div>
    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Edit Pengguna</h3>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password (Opsional):</label>
                    <input type="password" id="password" name="password">
                    <small>Biarkan kosong jika tidak ingin mengubah password</small>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="add-profile-btn">Update</button>
                    <a href="?page=admin"><button type="button" class="close-btn">Batal</button></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
