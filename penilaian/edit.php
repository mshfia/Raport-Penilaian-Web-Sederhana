<?php
// Koneksi ke database
include 'database/db.php';

// Jika form telah disubmit untuk menyimpan perubahan nilai
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nilai = $_POST['nilai'];

    // Loop untuk setiap mata kuliah dan nilai yang diedit
    foreach ($nilai as $id_matkul => $nilaiMatkul) {
        // Update nilai untuk setiap mata kuliah
        $sql = "UPDATE nilai SET nilai = '$nilaiMatkul' WHERE nim = '$nim' AND id_matkul = '$id_matkul'";
        // Eksekusi query
        $conn->query($sql);
    }

    echo "Nilai berhasil diperbarui!";
    header("Location: ?page=nilai");
    exit;
}

// Ambil NIM mahasiswa yang dipilih dari parameter URL
if (isset($_GET['nim'])) {
    $nimSelected = $_GET['nim'];

    // Query untuk mengambil data mahasiswa dan nilai-nilai yang terkait
    $studentQuery = "SELECT * FROM students WHERE nim = '$nimSelected'";
    $studentResult = $conn->query($studentQuery);
    $student = $studentResult->fetch_assoc();

    // Query untuk mengambil data mata kuliah dan nilai yang sudah ada
    $nilaiQuery = "
        SELECT matkul.id_matkul, matkul.nama_matkul, nilai.nilai
        FROM matkul
        JOIN nilai ON matkul.id_matkul = nilai.id_matkul
        WHERE nilai.nim = '$nimSelected'
    ";
    $nilaiResult = $conn->query($nilaiQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Edit Nilai</title>
</head>

<body>
    <div class="head-title">
        <div class="left">
            <h1>Edit Nilai</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Edit Nilai</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Form Edit Nilai Mata Kuliah</h3>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="nim" value="<?php echo htmlspecialchars($student['nim']); ?>">
                <p>Mahasiswa: <?php echo htmlspecialchars($student['nama']) . " (" . htmlspecialchars($student['nim']) . ")"; ?></p>

                <div class="form-group">
                    <table>
                        <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $nilaiResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                                    <td><input type="text" name="nilai[<?php echo $row['id_matkul']; ?>]" value="<?php echo htmlspecialchars($row['nilai']); ?>" required></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-buttons">
                    <button type="submit">Update</button>
                    <button type="button" class="close-btn" onclick="window.location.href='?page=nilai'">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
