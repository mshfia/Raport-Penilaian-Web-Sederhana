<?php
$servername = "localhost";  // atau bisa IP server
$username = "root";         // Ganti dengan username MySQL kamu
$password = "";             // Ganti dengan password MySQL kamu jika ada
$dbname = "raport";     // Ganti dengan nama database yang kamu buat

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
