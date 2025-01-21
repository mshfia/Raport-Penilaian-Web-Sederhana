<?php
// Mulai Sesi
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["username"]) || $_SESSION["username"] == "") {
    header("location: login.php");
    exit(); // Tambahkan exit setelah header
} else {
    $username = $_SESSION["username"];
    $nama_lengkap = isset($_SESSION["nama_lengkap"]) ? $_SESSION["nama_lengkap"] : ''; // Tambahkan pengecekan
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : ''; // Tambahkan pengecekan
}

// Koneksi ke database
include 'database/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="tampilan/style.css">
    <link rel="website icon" type="png" href="tampilan/Pngtree book.png">
    <title>RAPORT</title>
</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <img src="tampilan/Pngtree book.png" alt="logo">
            <span class="text">Raport</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="?page=dashboard">
                    <i class='bx bx-home-alt'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="?page=profil">
                    <i class='bx bxs-group'></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <a href="?page=matkul">
                    <i class='bx bx-book-open'></i>
                    <span class="text">Mata Kuliah</span>
                </a>
            </li>
            <li>
                <a href="?page=nilai">
                    <i class='bx bx-calculator'></i>
                    <span class="text">Nilai</span>
                </a>
            </li>
            <li>
                <a href="?page=raport">
                    <i class='bx bxs-food-menu'></i>
                    <span class="text">Raport</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="?page=admin">
                    <i class='bx bxs-user'></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout" onclick="return confirm('Yakin mau keluar dari aplikasi ini?\nJangan ya dek ya..\nReepooot... 😅')">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN CONTENT -->
        <main id="main-content">
            <?php
            // Cek apakah ada parameter 'page' di URL
            if (isset($_GET['page'])) {
                $page = $_GET['page'];

                // Muat file PHP sesuai dengan parameter 'page'
                switch ($page) {
                    case 'dashboard':
                        include 'home/dashboard.php';
                        break;

                        //profil
                    case 'profil':
                        include 'profil/profile.php';
                        break;
                    case 'add-profil':
                        include 'profil/add-profile.php';
                        break;
                    case 'edit-profil':
                        include 'profil/edit.php';
                        break;
                    case 'delete-profil':
                        include 'profil/delete.php';
                        break;
                    case 'print-mahasiswa':
                        include 'profil/print.php';
                        break;
                    case 'print-profil':
                        include 'profil/student-card.php';
                        break;

                        //matkul
                    case 'matkul':
                        include 'matakul/matkul.php';
                        break;
                    case 'add-matkul':
                        include 'matakul/add-matkul.php';
                        break;
                    case 'edit-matkul':
                        include 'matakul/edit.php';
                        break;
                    case 'delete-matkul':
                        include 'matakul/delete.php';
                        break;


                        //nilai
                    case 'nilai':
                        include 'penilaian/nilai.php';
                        break;
                    case 'add-nilai':
                        include 'penilaian/add-nilai.php';
                        break;
                    case 'edit-nilai':
                        include 'penilaian/edit.php';
                        break;
                    case 'delete-nilai':
                        include 'penilaian/delete.php';
                        break;

                        //raport
                    case 'raport':
                        include 'dokumen/raport.php';
                        break;
                    case 'raport':
                        include 'dokumen/print-nilai.php';
                        break;

                        //Users-Pengguna
                    case 'admin':
                        include 'login/admin.php';
                        break;
                    case 'add-admin':
                        include 'login/add-admin.php';
                        break;
                    case 'edit-admin':
                        include 'login/edit.php';
                        break;
                    case 'delete-admin':
                        include 'login/delete.php';
                        break;

                    default:
                        echo "<center><br><br><br><br><br><br><br><br><br>
                            <h1> Halaman tidak ditemukan !</h1></center>";
                        break;
                }
            } else {
                // Jika tidak ada parameter 'page', tampilkan dashboard sebagai default
                include 'home/dashboard.php';
            }
            ?>
        </main>
        <!-- MAIN CONTENT -->
    </section>
    <!-- CONTENT -->

    <script src="tampilan/script.js"></script>

</body>

</html>
