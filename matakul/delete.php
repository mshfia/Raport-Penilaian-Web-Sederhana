<?php
// Koneksi ke database
include 'database/db.php';  // Pastikan sudah koneksi dengan database

// Memeriksa apakah halaman yang diminta adalah 'delete-matakul' dan parameter 'id_matkul' ada
if (isset($_GET['page']) && $_GET['page'] == 'delete-matakul' && isset($_GET['id_matkul'])) {
    // Debugging: Cek parameter GET
    var_dump($_GET);  // Ini akan menampilkan seluruh parameter URL

    $id_matkul = $_GET['id_matkul'];

    // Query untuk menghapus mata kuliah berdasarkan id_matkul
    $sql = "DELETE FROM matkul WHERE id_matkul = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_matkul);
    $stmt->execute();

    // Cek apakah data berhasil dihapus
    if ($stmt->affected_rows > 0) {
        echo "Mata kuliah berhasil dihapus!";
        // Redirect atau tampilkan pesan sukses
        header("Location: ?page=matkul");
        exit;
    } else {
        echo "Gagal menghapus mata kuliah.";
    }

    $stmt->close();
} else {
    echo "Parameter 'id_matkul' tidak ditemukan.";
}
?>
