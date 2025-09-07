<?php
session_start();
include "koneksi.php";

// Ambil filter tanggal dari form dengan sanitasi
$tglDari = isset($_GET['tglDari']) ? mysqli_real_escape_string($conn, $_GET['tglDari']) : '';
$tglKe   = isset($_GET['tglKe']) ? mysqli_real_escape_string($conn, $_GET['tglKe']) : '';

// Query dasar -> ambil dari tabel laporan
$sql = "SELECT l.id_laporan, a.nama AS nama_anggota, b.judul AS judul_buku,
               l.tgl_pinjam, l.tgl_kembali, l.status, l.denda
        FROM laporan l
        JOIN peminjaman p ON l.id_peminjaman = p.id_peminjaman
        JOIN anggota a ON p.id_anggota = a.id_anggota
        JOIN buku b ON p.id_buku = b.id_buku";

// Filter tanggal (flexibel)
if (!empty($tglDari) && !empty($tglKe)) {
    $sql .= " WHERE l.tgl_pinjam BETWEEN '$tglDari' AND '$tglKe'";
} elseif (!empty($tglDari)) {
    $sql .= " WHERE l.tgl_pinjam >= '$tglDari'";
} elseif (!empty($tglKe)) {
    $sql .= " WHERE l.tgl_pinjam <= '$tglKe'";
}

$sql .= " ORDER BY l.tgl_pinjam DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan - SMK Negeri 1 Babat Supat</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .status-selesai {
      color: #155724;
      background-color: #d4edda;
      font-weight: bold;
      padding: 3px 8px;
      border-radius: 5px;
      display: inline-block;
    }
    .status-terlambat {
      color: #721c24;
      background-color: #f8d7da;
      font-weight: bold;
      padding: 3px 8px;
      border-radius: 5px;
      display: inline-block;
    }
    .status-dipinjam {
      color: #0c5460;
      background-color: #bcf5ffff;
      font-weight: bold;
      padding: 3px 8px;
      border-radius: 5px;
      display: inline-block;
    }
  </style>
</head>

<body>
  <div class="frame">
    <div class="container">

      <header class="header">
        <h1 class="judul-header">SMK NEGERI 1 BABAT SUPAT</h1>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
      </header>

      <nav id="navbar">
        <ul>
          <li><a href="beranda.php">Beranda</a></li>
          <li><a href="koleksi.php">Koleksi Buku</a></li>
          <li><a href="anggota.php">Anggota</a></li>
          <li><a href="peminjaman.php">Peminjaman Buku</a></li>
          <li><a href="laporan.php" class="active">Laporan</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <main>
        <section class="welcome">
          <div class="welcome-box">
            <h2>LAPORAN PEMINJAMAN BUKU</h2>
          </div>

          <div class="filter-box">
            <form method="GET" action="">
              <label>Dari Tanggal <input type="date" name="tglDari" value="<?= $tglDari ?>"></label>
              <label>Ke Tanggal <input type="date" name="tglKe" value="<?= $tglKe ?>"></label>
              <button class="btn-filter" type="submit">Cari</button>
            </form>
          </div>

          <div class="table-wrapper">
            <table class="table-laporan">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Anggota</th>
                  <th>Judul Buku</th>
                  <th>Tgl Pinjam</th>
                  <th>Tgl Kembali</th>
                  <th>Status</th>
                  <th>Denda</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                  <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?= $row['id_laporan'] ?></td>
                      <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                      <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                      <td><?= $row['tgl_pinjam'] ?></td>
                      <td><?= $row['tgl_kembali'] ? $row['tgl_kembali'] : '-' ?></td>
                      <td>
                        <?php
                          if ($row['status'] == "Selesai") {
                              echo '<span class="status-selesai">Selesai</span>';
                          } elseif ($row['status'] == "Terlambat") {
                              echo '<span class="status-terlambat">Terlambat</span>';
                          } else {
                              echo '<span class="status-dipinjam">Dipinjam</span>';
                          }
                        ?>
                      </td>
                      <td><?= $row['denda'] > 0 ? "Rp " . number_format($row['denda'],0,",",".") : "-" ?></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr><td colspan="7" style="text-align:center;">Tidak ada data</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </section>
      </main>

      <footer>
        <p>&copy; Copyright 2025 SMK Negeri 1 Babat Supat</p>
      </footer>
    </div>
  </div>

  <script>
  function toggleMenu() {
    const nav = document.querySelector("nav ul");
    nav.classList.toggle("show");
  }
  </script>
</body>
</html>
