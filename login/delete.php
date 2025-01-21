<?php
// Koneksi ke database
include 'database/db.php';

// Cek apakah 'id_user' ada di URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query untuk menghapus pengguna berdasarkan id_user
    $sql = "DELETE FROM users WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        // Jika berhasil, tampilkan pesan dan redirect ke halaman daftar pengguna
        echo "<script>alert('Pengguna berhasil dihapus'); window.location.href='?page=admin';</script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "'); window.location.href='?page=admin';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID pengguna tidak ditemukan!'); window.location.href='?page=admin';</script>";
}

// Tutup koneksi
$conn->close();
?>
