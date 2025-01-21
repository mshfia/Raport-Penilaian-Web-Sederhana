<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="tampilan/dashboard.css">

    <title>AdminHub</title>
</head>

<body>
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Beranda</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <a href="#" class="btn-download">
                <i class='bx bxs-cloud-download'></i>
                <span class="text">Download PDF</span>
            </a>
        </div>
        <ul class="box-info">
            <li>
                <i class='bx bx-book-open'></i>
                <span class="text">
                    <h3><?php
                        // Koneksi ke database
                        include 'database/db.php';

                        // Query untuk menghitung jumlah mata kuliah
                        $sql = "SELECT COUNT(*) AS total_matkul FROM matkul";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['total_matkul'];
                        ?>
                    </h3>
                    <p>Mata Kuliah</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-group'></i>
                <span class="text">
                    <h3><?php
                        // Koneksi ke database
                        include 'database/db.php';

                        // Query untuk menghitung jumlah mahasiswa
                        $sql = "SELECT COUNT(*) AS total_mahasiswa FROM students";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['total_mahasiswa'];
                        ?>
                    </h3>
                    <p>Mahasiswa</p>
                </span>
            </li>
            <li>
            <i class='bx bx-trending-up'></i>
                <span class="text">
                    <h3><?php
                        include 'database/db.php';
                        $row = $conn->query("SELECT nama, AVG(nilai) AS rata FROM students JOIN nilai ON students.nim = nilai.nim GROUP BY students.nim ORDER BY rata DESC LIMIT 1")->fetch_assoc();
                        echo round($row['rata'], 2);
                        ?>
                    </h3>
                    <p><?php echo htmlspecialchars($row['nama']); ?></p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Kabar Terkini</h3>
                    <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
// Koneksi ke database
include 'database/db.php';

// Query untuk mengambil data mahasiswa, foto, NIM, nilai rata-rata, dan keterangan
$sql = "
    SELECT students.nim, students.nama, students.foto, 
           AVG(nilai.nilai) AS rata_rata
    FROM students
    JOIN nilai ON students.nim = nilai.nim
    GROUP BY students.nim
";
$result = $conn->query($sql);

// Menampilkan data mahasiswa dan keterangan berdasarkan nilai rata-rata
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rata_rata = round($row['rata_rata']); // Membulatkan nilai rata-rata
        $status = '';
        $status_class = '';

        // Menentukan status berdasarkan rentang nilai
        if ($rata_rata >= 85 && $rata_rata <= 100) {
            $status = 'A';
            $status_class = 'completed'; // Warna hijau
        } elseif ($rata_rata >= 75 && $rata_rata < 85) {
            $status = 'B';
            $status_class = 'process'; // Warna biru
        } elseif ($rata_rata >= 60 && $rata_rata < 75) {
            $status = 'C';
            $status_class = 'warning'; // Warna kuning
        } elseif ($rata_rata >= 30 && $rata_rata < 60) {
            $status = 'D';
            $status_class = 'alert'; // Warna oranye
        } else {
            $status = 'E';
            $status_class = 'pending'; // Warna merah
        }

        // Menampilkan data ke tabel dengan nilai rata-rata di samping status
        echo "
        <tr>
            <td>
                <img src='" . htmlspecialchars($row['foto']) . "' alt='foto mahasiswa'>
                <p>" . htmlspecialchars($row['nama']) . "</p>
            </td>
            <td>" . htmlspecialchars($row['nim']) . "</td>
            <td><span class='status " . $status_class . "'>" . $status . " (Nilai: " . htmlspecialchars($rata_rata) . ")</span></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='3'>Tidak ada data ditemukan.</td></tr>";
}
?>
                    </tbody>
                </table>
            </div>
            <div class="todo">
                <div class="head">
                    <h3>Tugas UAS</h3>
                    <i class='bx bx-plus'></i>
                    <i class='bx bx-filter'></i>
                </div>
                <ul class="todo-list">
                    <img src="tampilan/tugas.jpg" alt="tugas">
                </ul>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
</body>

</html>