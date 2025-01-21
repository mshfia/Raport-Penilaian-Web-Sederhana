<?php
// Koneksi ke database
include 'database/db.php';

// Jika ada parameter 'nim' pada URL
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk menghapus nilai mahasiswa berdasarkan NIM
    $deleteQuery = "DELETE FROM nilai WHERE nim = '$nim'";

    if ($conn->query($deleteQuery)) {
        // Redirect kembali ke halaman nilai setelah penghapusan
        header("Location: ?page=nilai");
        exit;
    } else {
        echo "Gagal menghapus nilai mahasiswa.";
    }
} else {
    echo "Data tidak valid.";
}
?>
