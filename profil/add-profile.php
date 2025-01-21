<?php
// Koneksi ke database
include 'database/db.php';

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];
    $status = $_POST['status'];
    $semester = $_POST['semester'];
    $domisili = $_POST['domisili'];

    // Mengambil informasi file yang diunggah
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    // Tentukan folder tujuan penyimpanan file
    $target_dir = "C:/xampp/htdocs/raport/uploads/"; // Gunakan path absolut
    // Pastikan folder ini sudah ada
    $target_file = $target_dir . basename($foto);

    // Cek apakah NIM sudah ada di database
    $checkNIM = "SELECT nim FROM students WHERE nim = '$nim'";
    $result = $conn->query($checkNIM);

    if ($result->num_rows > 0) {
        // Jika NIM sudah ada, tampilkan pesan error
        echo "<script>alert('NIM sudah ada, silakan gunakan NIM yang berbeda.');</script>";
    } else {
        // Jika file berhasil diunggah, lanjutkan menyimpan ke database
        if (move_uploaded_file($foto_tmp, $target_file)) {
            $sql = "INSERT INTO students (nim, nama, prodi, fakultas, status, semester, domisili, foto) 
                    VALUES ('$nim', '$nama', '$prodi', '$fakultas', '$status', '$semester', '$domisili', '$foto')";

            if ($conn->query($sql) === TRUE) {
                // Jika penyimpanan berhasil, redirect ke profile.php
                header("Location: ?page=profil");
                exit; // Pastikan kode berhenti setelah redirect
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah foto.";
        }
    }
}

// Tutup koneksi
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Tambah Profil</title>
</head>
<body>
    <div class="head-title">
        <div class="left">
            <h1>Tambah Profil</h1>
            <ul class="breadcrumb">
                <li><a href="profile.php">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Tambah Profil</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Tambah Profil</h3>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="prodi">Prodi</label>
                    <input type="text" id="prodi" name="prodi" required>
                </div>
                <div class="form-group">
                    <label for="fakultas">Fakultas</label>
                    <input type="text" id="fakultas" name="fakultas" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="" disabled selected>Status</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="mahasiswi">Mahasiswi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="" disabled selected>Pilih Semester</option>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            echo "<option value='$i'>Semester $i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="domisili">Domisili</label>
                    <input type="text" id="domisili" name="domisili" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="form-buttons">
                    <button type="submit">Simpan</button>
                    <button type="button" class="close-btn" onclick="window.location.href='?page=profil'">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
