<?php
include "koneksi.php";

$sql = "SELECT 
            p.kode_peminjaman, 
            a.nama AS nama_anggota, 
            b.judul AS judul_buku, 
            p.tgl_pinjam, 
            p.batas_kembali,
            p.cetak, 
            p.pengembalian, 
            p.rusak_hilang, 
            p.perpanjangan
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id_anggota
        JOIN buku b ON p.id_buku = b.id_buku
        ORDER BY p.tgl_pinjam ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peminjaman Buku - SMK Negeri 1 Babat Supat</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">

  <style>
    /* Tambahan styling khusus tombol ikon */
    .icon-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 6px;
      color: #fff;
      font-size: 14px;
      cursor: default;
    }
    .icon-purple { background-color: #6f42c1; } /* Cetak */
    .icon-green  { background-color: #28a745; } /* Pengembalian */
    .icon-red    { background-color: #dc3545; } /* Rusak/Hilang */
    .icon-blue   { background-color: #007bff; } /* Perpanjangan */
    .table-peminjaman td, 
    .table-peminjaman th {
      text-align: center;
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
          <li><a href="peminjaman.php" class="active">Peminjaman Buku</a></li>
          <li><a href="laporan.php">Laporan</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <main>
        <section class="peminjaman">
          <div class="welcome-box">
            <h2>TABEL PEMINJAMAN BUKU</h2>
          </div>

          <div class="filter-box">
            <label>Dari Tanggal <input type="date" id="dariTanggal"></label>
            <label>Ke Tanggal <input type="date" id="keTanggal"></label>
            <button class="btn-filter" onclick="filterTabel()">Cari</button>
          </div>

          <div class="table-wrapper">
            <table class="table-peminjaman">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Kode</th>
                  <th>Nama Anggota</th>
                  <th>Judul Buku</th>
                  <th>Tanggal Pinjam</th>
                  <th>Batas Kembali</th>
                  <th>Cetak</th>
                  <th>Pengembalian</th>
                  <th>Rusak/Hilang</th>
                  <th>Perpanjangan</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo "<tr>
                      <td>".$no++."</td>
                      <td>".$row['kode_peminjaman']."</td>
                      <td>".$row['nama_anggota']."</td>
                      <td>".$row['judul_buku']."</td>
                      <td>".$row['tgl_pinjam']."</td>
                      <td>".$row['batas_kembali']."</td>

                      <td><span class='icon-btn icon-purple' title='Cetak'><i class='fas fa-print'></i></span></td>

                      <td>".($row['pengembalian'] 
                          ? "<span class='icon-btn icon-green' title='Sudah Dikembalikan'><i class='fas fa-check'></i></span>" 
                          : "<span class='icon-btn icon-red' title='Belum Dikembalikan'><i class='fas fa-times'></i></span>")."</td>

                      <td>".($row['rusak_hilang'] 
                          ? "<span class='icon-btn icon-red' title='Rusak/Hilang'><i class='fas fa-times'></i></span>" 
                          : "<span class='icon-btn icon-green' title='Normal'><i class='fas fa-check'></i></span>")."</td>

                      <td><span class='icon-btn icon-blue' title='Perpanjang'><i class='fas fa-undo'></i></span></td>
                    </tr>";
                  }
                } else {
                  echo "<tr><td colspan='10'>Belum ada data peminjaman</td></tr>";
                }
                ?>
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
    function filterTabel() {
      let dari = document.getElementById("dariTanggal").value;
      let ke = document.getElementById("keTanggal").value;
      let rows = document.querySelectorAll(".table-peminjaman tbody tr");

      let dariDate = dari ? new Date(dari) : null;
      let keDate = ke ? new Date(ke) : null;

      rows.forEach(row => {
        let tanggalPinjam = row.cells[4].innerText;
        let datePinjam = new Date(tanggalPinjam);
        let tampil = true;

        if (dariDate && datePinjam < dariDate) tampil = false;
        if (keDate && datePinjam > keDate) tampil = false;

        row.style.display = tampil ? "" : "none";
      });
    }

    function toggleMenu() {
      const nav = document.querySelector("nav ul");
      nav.classList.toggle("show");
    }
  </script>
</body>
</html>
