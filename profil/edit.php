<?php
// Koneksi ke database
include 'database/db.php';

// Cek apakah ada 'nim' di URL
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk mendapatkan data mahasiswa berdasarkan NIM
    $sql = "SELECT * FROM students WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "NIM tidak ditemukan!";
    exit;
}

// Jika form di-submit, update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];
    $status = $_POST['status'];
    $semester = $_POST['semester'];
    $domisili = $_POST['domisili'];
    $foto_new_name = $student['foto']; // Default ke nama foto lama

    // Jika ada foto baru yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $folder = "uploads/";

        // Buat nama unik untuk file baru
        $foto_new_name = uniqid() . "_" . $foto;

        // Pindahkan file ke folder 'uploads'
        move_uploaded_file($tmp_name, $folder . $foto_new_name);
    }

    // Query untuk update data
    $sql = "UPDATE students SET nama = ?, prodi = ?, fakultas = ?, status = ?, semester = ?, domisili = ?, foto = ? WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $nama, $prodi, $fakultas, $status, $semester, $domisili, $foto_new_name, $nim);
    $stmt->execute();

    // Redirect ke halaman profil setelah berhasil update
    header("Location: ?page=profil");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="head-title">
        <div class="left">
            <h1>Edit Profile</h1>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Edit Student Profile</h3>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nim" value="<?= htmlspecialchars($student['nim']) ?>">

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($student['nama']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="prodi">Prodi:</label>
                    <input type="text" id="prodi" name="prodi" value="<?= htmlspecialchars($student['prodi']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="fakultas">Fakultas:</label>
                    <input type="text" id="fakultas" name="fakultas" value="<?= htmlspecialchars($student['fakultas']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="mahasiswa" <?= $student['status'] == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                        <option value="mahasiswi" <?= $student['status'] == 'mahasiswi' ? 'selected' : '' ?>>Mahasiswi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select id="semester" name="semester" required>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            $selected = $student['semester'] == $i ? 'selected' : '';
                            echo "<option value='$i' $selected>Semester $i</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="domisili">Domisili:</label>
                    <input type="text" id="domisili" name="domisili" value="<?= htmlspecialchars($student['domisili']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="foto">Foto:</label>
                    <input type="file" id="foto" name="foto">
                    <?php if (!empty($student['foto'])): ?>
                        <img src="uploads/<?= htmlspecialchars($student['foto']) ?>" alt="Foto" width="100">
                    <?php endif; ?>
                </div>

                <div class="form-buttons">
                    <button type="submit">Update</button>
                    <button type="button" class="close-btn" onclick="window.location.href='?page=profil'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
