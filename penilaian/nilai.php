<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tampilan/profile.css">
  <title>Nilai Mahasiswa</title>
</head>

<body>
  <div class="head-title">
    <div class="left">
      <h1>Nilai Mahasiswa</h1>
      <ul class="breadcrumb">
        <li>
          <a href="#">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" href="#">Nilai</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="table-data">
    <div class="profile">
      <div class="head">
        <h3>Daftar Nilai Mahasiswa</h3>
      </div>
      <div class="table-data">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Mata Kuliah</th>
              <th>Nilai</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="profile-body">
            <?php
            // Koneksi ke database
            include 'database/db.php';

            // Query untuk mengambil data nilai, mahasiswa, dan mata kuliah
            $sql = "SELECT students.nim, students.nama, GROUP_CONCAT(matkul.id_matkul ORDER BY matkul.nama_matkul) AS matkul_ids, 
                    GROUP_CONCAT(matkul.nama_matkul ORDER BY matkul.nama_matkul) AS matkul_list, 
                    GROUP_CONCAT(nilai.nilai ORDER BY matkul.nama_matkul) AS nilai_list
                    FROM nilai
                    JOIN students ON nilai.nim = students.nim
                    JOIN matkul ON nilai.id_matkul = matkul.id_matkul
                    GROUP BY students.nim";
            $result = $conn->query($sql);

            // Jika query berhasil, tampilkan datanya
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    // Pisahkan mata kuliah dan nilai menjadi array
                    $matkulList = explode(',', $row['matkul_list']);
                    $nilaiList = explode(',', $row['nilai_list']);
                    
                    // Pisahkan ID mata kuliah menjadi array
                    $matkulIds = explode(',', $row['matkul_ids']);
                    
                    // Baris pertama dengan NIM dan Nama Mahasiswa
                    echo "<tr>
                            <td rowspan='" . count($matkulList) . "'>" . $no++ . "</td>
                            <td rowspan='" . count($matkulList) . "'>" . htmlspecialchars($row['nim']) . "</td>
                            <td rowspan='" . count($matkulList) . "'>" . htmlspecialchars($row['nama']) . "</td>";

                    // Menampilkan baris pertama mata kuliah dan nilai
                    echo "<td>" . htmlspecialchars($matkulList[0]) . "</td>
                          <td>" . htmlspecialchars($nilaiList[0]) . "</td>";

                    // Kolom edit dan delete
                    echo "<td rowspan='" . count($matkulList) . "'>
                            <a href='?page=edit-nilai&nim=" . urlencode($row['nim']) . "'>
                                <button class='edit-btn'>Edit</button>
                            </a>
                            <a href='?page=delete-nilai&nim=" . urlencode($row['nim']) . "'>
                                <button class='delete-btn'>Delete</button>
                            </a>
                        </td>
                    </tr>";

                    // Menampilkan baris selanjutnya untuk mata kuliah dan nilai (tanpa NIM dan Nama Mahasiswa)
                    for ($i = 1; $i < count($matkulList); $i++) {
                        echo "<tr>
                                <td>" . htmlspecialchars($matkulList[$i]) . "</td>
                                <td>" . htmlspecialchars($nilaiList[$i]) . "</td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data nilai ditemukan.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="buttons">
        <a href="?page=add-nilai"><button class="add-profile-btn">Tambah Nilai</button></a>
      </div>
    </div>
  </div>
  <script src="tampilan/nilai.js"></script>
</body>

</html>
