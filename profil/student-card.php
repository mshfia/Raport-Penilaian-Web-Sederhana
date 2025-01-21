<?php
include 'database/db.php';  // Koneksi database

// Cek apakah ada 'nim' di URL
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $sql = "SELECT * FROM students WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "NIM tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Tanda Mahasiswa - <?= htmlspecialchars($student['nama']) ?></title>
    <style>
        /* Styling KTM */
        body {
            background: #f7f7f7;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            width: 350px;
            height: auto;
            padding: 20px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            align-items: center;
            color: #333;
        }

        .card .left {
            flex: 1;
            text-align: left;
        }

        .card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #eee;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card .right {
            flex: 2;
            padding-left: 20px;
        }

        .card h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card p {
            margin: 5px 0;
            font-size: 16px;
        }

        .card .info {
            font-size: 14px;
            margin-top: 15px;
            background: #f1f1f1;
            padding: 10px;
            border-radius: 8px;
        }

        .card .info span {
            font-weight: bold;
        }

        .print-btn {
            margin-top: 20px;
            text-align: center;
        }

        .print-btn button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .print-btn button:hover {
            background-color: #218838;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .card {
                width: 90%;
                flex-direction: column;
                align-items: center;
            }

            .card .right {
                padding-left: 0;
                text-align: center;
                margin-top: 20px;
            }

            .card img {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis mencetak saat halaman terbuka -->
    <div class="card">
        <div class="left">
            <img src="uploads/<?= htmlspecialchars($student['foto']) ?>" alt="Foto Mahasiswa"> <!-- Asumsikan foto di-upload di folder uploads -->
        </div>
        <div class="right">
            <h2><?= htmlspecialchars($student['nama']) ?></h2>
            <p>NIM: <?= htmlspecialchars($student['nim']) ?></p>
            <div class="info">
                <p><span>Prodi:</span> <?= htmlspecialchars($student['prodi']) ?></p>
                <p><span>Fakultas:</span> <?= htmlspecialchars($student['fakultas']) ?></p>
                <p><span>Status:</span> <?= htmlspecialchars($student['status']) ?></p>
                <p><span>Tahun Masuk:</span> <?= htmlspecialchars($student['masuk']) ?></p>
            </div>
            <div class="print-btn">
                <button onclick="window.print()">Print KTM</button>
            </div>
        </div>
    </div>
</body>
</html>
