<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tampilan/profile.css">
  <title>Profile</title>
</head>

<body>
  <div class="head-title">
    <div class="left">
      <h1>Profile Mahasiswa</h1>
      <ul class="breadcrumb">
        <li>
          <a href="#">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" href="#">Profile</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="table-data">
    <div class="profile">
      <div class="head">
        <h3>Profile Mahasiswa</h3>
      </div>
      <div class="table-data">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>NIM</th>
              <th>Nama</th>
              <th>Prodi</th>
              <th>Fakultas</th>
              <th>Semester</th>
              <th>Domisili</th>
              <th>Actions</th>
            </tr>
          </thead>
          <?php
        // Koneksi ke database
        include 'database/db.php';

        // Query untuk mengambil semua data mahasiswa
        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);

        // Jika query berhasil, simpan hasilnya dalam array
        $students = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
        ?>

        <tbody id="profile-body">
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($student['nim']) ?></td>
                        <td><?= htmlspecialchars($student['nama']) ?></td>
                        <td><?= htmlspecialchars($student['prodi']) ?></td>
                        <td><?= htmlspecialchars($student['fakultas']) ?></td>
                        <td><?= htmlspecialchars($student['semester']) ?></td>
                        <td><?= htmlspecialchars($student['domisili']) ?></td>
                        <td>
                            <a href="?page=edit-profil&nim=<?= urlencode($student['nim']) ?>">
                                <button class="edit-btn">Edit</button>
                            </a>
                            <a href="?page=delete-profil&nim=<?= urlencode($student['nim']) ?>">
                                <button class="delete-btn">Delete</button>
                            </a>
                            <a href="?page=student-card-profil&nim=<?= urlencode($student['nim']) ?>">
                                <button class="print-btn">Print</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada data mahasiswa ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
      </div>
      <div class="buttons">
          <a href="?page=add-profil"><button class="add-profile-btn">Tambah Profil</button></a>
          <a href="?page=print-profil"><button class="print-all-btn">Print</button></a>
      </div>
    </div>
  </div>
  <iframe id="print-frame" style="display: none;"></iframe>
  <script src="tampilan/profile.js"></script>
</body>

</html>
