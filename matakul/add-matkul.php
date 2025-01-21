<?php
// Koneksi ke database
include 'database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_matkul = $_POST['id_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $dosen = $_POST['dosen'];

    // Query untuk menambah data mata kuliah
    $sql = "INSERT INTO matkul (id_matkul, nama_matkul, dosen) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $id_matkul, $nama_matkul, $dosen);

    // Eksekusi query dan cek apakah berhasil
    if ($stmt->execute()) {
        // Redirect ke matkul.php setelah data berhasil ditambahkan
        header("Location: ?page=matkul");
        exit;
    } else {
        echo "Gagal menambah Mata Kuliah.";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css"> <!-- CSS file untuk styling -->
    <title>Tambah Mata Kuliah</title>
</head>
<body>
    <div class="head-title">
        <div class="left">
            <h1>Tambah Mata Kuliah</h1>
            <ul class="breadcrumb">
                <li><a href="profile.php">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Tambah Mata Kuliah</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Tambah Mata Kuliah</h3>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_matkul">ID Mata Kuliah:</label>
                    <input type="text" id="id_matkul" name="id_matkul" required>
                </div>
                <div class="form-group">
                    <label for="nama_matkul">Nama Mata Kuliah:</label>
                    <input type="text" id="nama_matkul" name="nama_matkul" required>
                </div>
                <div class="form-group">
                    <label for="dosen">Dosen:</label>
                    <input type="text" id="dosen" name="dosen" required>
                </div>
                <div class="form-buttons">
                    <button type="submit">Simpan</button>
                    <button type="button" class="close-btn" onclick="window.location.href='?page=matkul'">Batal</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
