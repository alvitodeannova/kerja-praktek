<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
  header('Location: login.php');
  exit;
}
require_once('../config/db.php');
$result = $conn->query('SELECT u.username, a.tanggal, a.jam_masuk, a.jam_keluar FROM absensi a JOIN users u ON u.id = a.user_id ORDER BY a.tanggal DESC');
$rows   = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Absensi — HRD</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Riwayat Absensi (Semua Karyawan)</h1>
    <a class="btn" href="dashboard.php">Kembali</a>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rows): $no = 1; foreach ($rows as $row): ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo $row['tanggal']; ?></td>
              <td><?php echo $row['jam_masuk'] ?: '-'; ?></td>
              <td><?php echo $row['jam_keluar'] ?: '-'; ?></td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="5">Belum ada data absensi.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>