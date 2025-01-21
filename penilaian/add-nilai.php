<?php
// Koneksi ke database
include 'database/db.php';

// Jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nilai = $_POST['nilai'];

    // Loop untuk setiap mata kuliah dan nilai
    foreach ($nilai as $id_matkul => $nilaiMatkul) {
        // Cek apakah data nilai sudah ada untuk mahasiswa dan mata kuliah tersebut
        $checkQuery = "SELECT * FROM nilai WHERE nim = '$nim' AND id_matkul = '$id_matkul'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // Jika sudah ada, update nilainya
            $sql = "UPDATE nilai SET nilai = '$nilaiMatkul' WHERE nim = '$nim' AND id_matkul = '$id_matkul'";
        } else {
            // Jika belum ada, masukkan nilainya
            $sql = "INSERT INTO nilai (nim, id_matkul, nilai) VALUES ('$nim', '$id_matkul', '$nilaiMatkul')";
        }

        // Eksekusi query
        $conn->query($sql);
    }

    echo "Nilai berhasil disimpan!";
    header("Location: ?page=nilai");
    exit;
}

// Query untuk mendapatkan mahasiswa yang belum memiliki nilai lengkap untuk semua mata kuliah
$students = $conn->query("
    SELECT s.nim, s.nama
    FROM students s
    WHERE EXISTS (
        SELECT 1
        FROM matkul m
        LEFT JOIN nilai n ON s.nim = n.nim AND m.id_matkul = n.id_matkul
        WHERE n.nilai IS NULL
    )
");

// Jika mahasiswa telah dipilih, ambil mata kuliah yang belum dinilai
$matkul = [];
if (isset($_POST['nim'])) {
    $nimSelected = $_POST['nim'];
    $matkulQuery = "SELECT * FROM matkul WHERE id_matkul NOT IN (SELECT id_matkul FROM nilai WHERE nim = '$nimSelected')";
    $matkul = $conn->query($matkulQuery);
} else {
    // Query untuk mengambil semua mata kuliah (default)
    $matkul = $conn->query("SELECT * FROM matkul");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Tambah Nilai</title>
</head>

<body>
    <div class="head-title">
        <div class="left">
            <h1>Tambah Nilai</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Tambah Nilai</a></li>
            </ul>
        </div>
    </div>
    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Tambah Nilai Mata Kuliah</h3>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nim">Mahasiswa</label>
                    <select name="nim" id="nim">
                        <option value="">Pilih Mahasiswa</option>
                        <?php
                        // Menampilkan semua mahasiswa dalam dropdown
                        while ($student = $students->fetch_assoc()) {
                            $selected = isset($_POST['nim']) && $_POST['nim'] == $student['nim'] ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($student['nim']) . "' $selected>" . htmlspecialchars($student['nama']) . " (" . htmlspecialchars($student['nim']) . ")</option>";
                        }
                        ?>
                    </select>
                </div>

                <?php if (!empty($matkul) && $matkul->num_rows > 0): ?>
                    <div class="form-group">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($mk = $matkul->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($mk['nama_matkul']); ?></td>
                                        <td><input type="text" name="nilai[<?php echo $mk['id_matkul']; ?>]" placeholder="Masukkan Nilai" required></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="form-buttons">
                    <button type="submit">Simpan</button>
                    <button type="button" class="close-btn" onclick="window.location.href='?page=nilai'">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
