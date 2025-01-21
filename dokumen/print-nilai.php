<?php
// Koneksi ke database
include 'database/db.php';

// Mengambil NIM dari URL
$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

if ($nim) {
    // Query untuk mengambil data mahasiswa dan nilai mereka
    $sql = "
        SELECT students.nim, students.nama, matkul.nama_matkul, nilai.nilai
        FROM nilai
        JOIN students ON nilai.nim = students.nim
        JOIN matkul ON nilai.id_matkul = matkul.id_matkul
        WHERE students.nim = '$nim'
    ";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Nilai Mahasiswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .container {
            margin: 0 auto;
            width: 80%;
        }

        .heading {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <h1 class="heading">Rekap Nilai Mahasiswa</h1>

        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Mengambil nama mahasiswa
            echo "<h2>Nama: " . htmlspecialchars($row['nama']) . "</h2>";
            echo "<h3>NIM: " . htmlspecialchars($row['nim']) . "</h3>";
        ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_nilai = 0;
                $jumlah_matkul = 0;

                // Mengulang query untuk menampilkan nilai per mata kuliah
                do {
                    echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>" . htmlspecialchars($row['nama_matkul']) . "</td>
                        <td>" . htmlspecialchars($row['nilai']) . "</td>
                    </tr>";
                    $total_nilai += $row['nilai'];
                    $jumlah_matkul++;
                } while ($row = $result->fetch_assoc());

                // Menghitung rata-rata nilai
                $rata_rata = $jumlah_matkul > 0 ? round($total_nilai / $jumlah_matkul) : 0;
                $keterangan = ($rata_rata >= 76) ? "Lulus" : (($rata_rata >= 50) ? "Perbaikan" : "Tidak Lulus");
                ?>
            </tbody>
        </table>

        <h3>Rata-rata Nilai: <?= htmlspecialchars($rata_rata) ?></h3>
        <h3>Keterangan: <?= htmlspecialchars($keterangan) ?></h3>

        <?php
        } else {
            echo "<p>Tidak ada data nilai untuk mahasiswa ini.</p>";
        }
        ?>

    </div>
</body>

</html>
