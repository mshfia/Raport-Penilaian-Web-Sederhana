<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tampilan/profile.css">
  <title>Users</title>
</head>

<body>
  <div class="head-title">
    <div class="left">
      <h1>Daftar Pengguna</h1>
      <ul class="breadcrumb">
        <li>
          <a href="#">Dashboard</a>
        </li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <a class="active" href="#">Users</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="table-data">
    <div class="profile">
      <div class="head">
        <h3>Daftar Pengguna</h3>
      </div>
      <div class="table-data">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <?php
        // Koneksi ke database
        include 'database/db.php';

        // Query untuk mengambil semua data pengguna
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        // Jika query berhasil, simpan hasilnya dalam array
        $users = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
        ?>

        <tbody id="users-body">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="?page=edit-admin&id_user=<?= urlencode($user['id_user']) ?>">
                                <button class="edit-btn">Edit</button>
                            </a>
                            <a href="?page=delete-admin&id_user=<?= urlencode($user['id_user']) ?>">
                                <button class="delete-btn">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada data pengguna ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
      </div>
      <div class="buttons">
          <a href="?page=add-admin"><button class="add-profile-btn">Tambah Pengguna</button></a>
      </div>
    </div>
  </div>
  <script src="tampilan/profile.js"></script>
</body>

</html>
