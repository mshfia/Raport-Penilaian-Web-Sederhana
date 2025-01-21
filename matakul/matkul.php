<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tampilan/profile.css">
  <title>Mata Kuliah</title>
</head>

<body>
  <div class="head-title">
    <div class="left">
      <h1>Mata Kuliah</h1>
      <ul class="breadcrumb">
        <li>
          <a href="#">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" href="#">Mata Kuliah</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="table-data">
    <div class="profile">
      <div class="head">
        <h3>Nama Mata Kuliah</h3>
      </div>
      <div class="table-data">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>Mata Kuliah</th>
              <th>Dosen</th>
              <th>Actions</th>
            </tr>
          </thead>
          <?php
          // Koneksi ke database
          include 'database/db.php';

          $sql = "SELECT * FROM matkul";  // Query untuk mengambil semua Mata Kuliah
          $result = $conn->query($sql);    // Eksekusi query

          // Jika query berhasil, simpan hasilnya dalam array
          $matkul = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
          ?>
          <tbody id="profile-body">
          <?php foreach ($matkul as $index => $row): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($row['id_matkul']) ?></td>
            <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
            <td><?= htmlspecialchars($row['dosen']) ?></td>
            <td>
              <a href="?page=edit-matkul&id_matkul=<?= $row['id_matkul'] ?>"><button class="edit-btn">Edit</button></a>
              <a href="?page=delete-matkul&id_matkul=<?= $row['id_matkul'] ?>"><button class="delete-btn">Delete</button></a>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="buttons">
        <a href="?page=add-matkul"><button class="add-profile-btn">Tambah Mata Kuliah</button></a>
      </div>
    </div>
  </div>
  <iframe id="print-frame" style="display: none;"></iframe>
  <script src="profile.js"></script>
</body>

</html>