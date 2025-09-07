<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMK Negeri 1 Babat Supat</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
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
          <li><a href="beranda.php" class="active">Beranda</a></li>
          <li><a href="koleksi.php">Koleksi Buku</a></li>
          <li><a href="anggota.php">Anggota</a></li>
          <li><a href="peminjaman.php">Peminjaman Buku</a></li>
          <li><a href="laporan.php">Laporan</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
 
      <main>
        <section class="welcome">
          <div class="welcome-box"> 
            <h2>SELAMAT DATANG, <?php echo htmlspecialchars($_SESSION['username']); ?> </h2>
          </div>

          <p>
            SMK Negeri 1 Babat Supat adalah salah satu dari sekian banyak sekolah menengah keatas yang berada di Jambi. 
            SMK Negeri 1 Babat Supat didirikan pada tanggal 29 April 2008 dan beralamatkan di Jl. Palembang – Jambi Km 102, 
            Suka Banyuasin, Prov. Sumatera Selatan. ABDUL RAHMAN, S.Pd., M.Si.
          </p>

          <p>
            Asal mula adanya ruang perpustakaan SMK Negeri 1 Babat Supat dikarenakan minat pembaca yang cukup tinggi, 
            sehingga ditambahkan ruang khusus perpustakaan yang berukuran cukup luas agar dapat menampung banyak buku 
            sehingga dapat menunjang pembelajaran para siswanya, hingga sekarang tahun 2025 buku di perpustakaan mencapai 
            30.000 eksemplar.
          </p>

          <p>
            Untuk menangani jalannya kegiatan perpustakaan dengan baik, perpustakaan yang bertugas untuk mengamati dan 
            mencatat data yang berhubungan dengan perpustakaan serta juga data denda bila buku terlambat dikembalikan oleh siswa.
          </p>
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
