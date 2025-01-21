<?php
include 'database/db.php';  // Pastikan sudah koneksi dengan database

// Cek apakah ada 'id_matkul' di URL untuk menampilkan data sebelum diedit
if (isset($_GET['id_matkul'])) {
    $id_matkul = $_GET['id_matkul'];

    // Query untuk mengambil data berdasarkan id_matkul
    $sql = "SELECT * FROM matkul WHERE id_matkul = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $id_matkul);  // Menggunakan tipe string untuk id_matkul (VARCHAR)
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $matkul = $result->fetch_assoc();  // Simpan hasil query dalam variabel $matkul
        } else {
            echo "Matkul tidak ditemukan!";
            exit;
        }
    } else {
        echo "Terjadi kesalahan pada query.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses update data jika form disubmit
    $id_matkul = $_POST['id_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $dosen = $_POST['dosen'];

    // Debug: cek apakah data POST sudah diterima
    if (empty($id_matkul) || empty($nama_matkul) || empty($dosen)) {
        echo "Semua data harus diisi!";
        exit;
    }

    // Query untuk mengupdate data
    $sql = "UPDATE matkul SET nama_matkul = ?, dosen = ? WHERE id_matkul = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter
        $stmt->bind_param("sss", $nama_matkul, $dosen, $id_matkul);  // Semua parameter adalah string

        // Eksekusi query
        if ($stmt->execute()) {
            // Mengecek apakah ada perubahan yang terjadi
            if ($stmt->affected_rows > 0) {
                // Redirect ke halaman lain setelah update berhasil
                header("Location: ?page=matkul");
                exit;
            } else {
                echo "Data tidak ada perubahan.";
            }
        } else {
            // Debug: tampilkan pesan error dari MySQL
            echo "Gagal mengupdate data: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Debug: tampilkan pesan error dari MySQL
        echo "Terjadi kesalahan pada query: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
    exit;  // Menghentikan eksekusi script setelah proses POST selesai
} else {
    echo "Id Matkul tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Edit Matkul</title>
</head>
<body>
    <div class="head-title">
        <div class="left">
            <h1>Edit Mata Kuliah</h1>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Edit Mata Kuliah</h3>
            </div>
            <div class="table-data">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Menggunakan variabel $matkul -->
                    <input type="hidden" name="id_matkul" value="<?= htmlspecialchars($matkul['id_matkul']) ?>">

                    <div class="form-group">
                        <label for="nama">Nama Mata Kuliah:</label>
                        <input type="text" id="nama_matkul" name="nama_matkul" value="<?= htmlspecialchars($matkul['nama_matkul']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="dosen">Dosen:</label>
                        <input type="text" id="dosen" name="dosen" value="<?= htmlspecialchars($matkul['dosen']) ?>" required>
                    </div>

                    <div class="form-buttons">
                        <button type="submit">Update</button>
                        <button type="button" class="close-btn" onclick="window.location.href='?page=matkul'">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
