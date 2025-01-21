<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tampilan/profile.css">
    <title>Rekap Nilai Mahasiswa</title>
</head>

<body>
    <div class="head-title">
        <div class="left">
            <h1>Rekap Nilai Mahasiswa</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Rekap Nilai</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="profile">
            <div class="head">
                <h3>Daftar Rata-rata Nilai Mahasiswa</h3>
            </div>
            <div class="table-data">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Rata-Rata Nilai</th>
                            <th>Keterangan</th>
                            <th>Aksi</th> <!-- Kolom untuk tombol print -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'database/db.php';

                        // Query untuk mengambil data mahasiswa, nilai rata-rata, dan keterangan
                        $sql = "
                            SELECT students.nim, students.nama, 
                                AVG(nilai.nilai) AS rata_rata
                            FROM students
                            JOIN nilai ON students.nim = nilai.nim
                            GROUP BY students.nim
                        ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                $rata_rata = round($row['rata_rata']);
                                
                                // Kategori nilai sesuai kriteria
                                if ($rata_rata >= 85 && $rata_rata <= 100) {
                                    $keterangan = "A";
                                } elseif ($rata_rata >= 75 && $rata_rata < 85) {
                                    $keterangan = "B";
                                } elseif ($rata_rata >= 60 && $rata_rata < 75) {
                                    $keterangan = "C";
                                } elseif ($rata_rata >= 30 && $rata_rata < 60) {
                                    $keterangan = "D";
                                } else {
                                    $keterangan = "E";
                                }

                                echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . htmlspecialchars($row['nim']) . "</td>
                                    <td>" . htmlspecialchars($row['nama']) . "</td>
                                    <td>" . htmlspecialchars($rata_rata) . "</td>
                                    <td>" . htmlspecialchars($keterangan) . "</td>
                                    <td><a href='?page=print-nilai-dokumen&nim=" . urlencode($row['nim']) . "' target='_blank'>
                                        <button class='print-btn'>Print Nilai</button>
                                    </a></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data nilai ditemukan.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
