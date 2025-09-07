<?php
include "koneksi.php";

$pesanSukses = "";
$pesanError  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $sql = "INSERT INTO pesan_kontak (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    if (mysqli_query($conn, $sql)) {
        $pesanSukses = "Terima kasih! Pesan kamu sudah dikirim.";
    } else {
        $pesanError = "Gagal mengirim pesan: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontak - Perpustakaan</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .message-box {
      display: block;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      font-weight: bold;
      opacity: 1;
      transition: opacity 1s ease;
    }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }
    .fade-out { opacity: 0; }
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
          <li><a href="laporan.php">Laporan</a></li>
          <li><a href="kontak.php" class="active">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <main>
        <section class="contact-section">
          <div class="contact-container">
            
            <div class="contact-info">
              <h2>Hubungi Kami</h2>
              <p class="intro">Kamu dapat menghubungi kami melalui informasi di bawah ini.</p>
              <p><i class="fas fa-envelope"></i> Perpustakaan@gmail.com</p>
              <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
              <p><i class="fas fa-map-marker-alt"></i> SMKN 1 Babat Supat, Jl. Pendidikan No.1</p>
            </div>

            <div class="contact-form">
              <?php if ($pesanSukses): ?>
                <div id="msgBox" class="message-box success"><?php echo $pesanSukses; ?></div>
              <?php elseif ($pesanError): ?>
                <div id="msgBox" class="message-box error"><?php echo $pesanError; ?></div>
              <?php endif; ?>

              <form id="kontakForm" action="kontak.php" method="post">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required />

                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="Email" required />

                <label for="pesan">Pesan <span class="required">*</span></label>
                <textarea id="pesan" name="pesan" placeholder="Pesan" rows="6" required></textarea>

                <button type="submit">Kirim Pesan</button>
              </form>
            </div>
          </div>
        </section>
      </main>
        
      <footer>
        <p>&copy; Copyright 2025 SMK Negeri 1 Babat Supat</p>
      </footer>

      <script>
        function toggleMenu() {
          const nav = document.querySelector("nav ul");
          nav.classList.toggle("show");
        }

        // Fade out pesan sukses/error setelah 5 detik
        window.onload = function() {
          const msg = document.getElementById("msgBox");
          if (msg) {
            setTimeout(() => {
              msg.classList.add("fade-out");
              setTimeout(() => { msg.style.display = "none"; }, 1000);
            }, 5000);
          }
        }
      </script>

    </div>
  </div>
</body>
</html>
