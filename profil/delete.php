<?php
include 'database/db.php';  // Koneksi ke database

// Cek apakah ada 'nim' di URL
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk menghapus data berdasarkan nim
    $stmt = $conn->prepare("DELETE FROM students WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();

    // Jika data terhapus
    if ($stmt->affected_rows > 0) {
        // Hapus file foto (jika ada)
        $filePath = "../uploads/" . $row['foto']; // Sesuaikan direktori upload
        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file foto
        }
        // Redirect ke profil setelah penghapusan
        header("Location: index.php?page=profil");
        exit;
    } else {
        echo "Gagal menghapus data.";
    }

    $stmt->close();
} else {
    echo "NIM tidak ditemukan!";
}

$conn->close();
?>
