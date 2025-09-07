<?php
include "koneksi.php";

// Tambah Buku
if (isset($_POST['simpan'])) {
  $judul        = trim($_POST['judul']);
  $penulis      = trim($_POST['penulis']);
  $penerbit     = trim($_POST['penerbit']);
  $tahun_terbit = intval(trim($_POST['tahun_terbit']));
  $stok         = intval(trim($_POST['stok']));

  // Validasi agar tahun dan stok masuk akal
  if ($tahun_terbit >= 1000 && $stok >= 0) {
    mysqli_query($conn, "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) 
                         VALUES ('$judul','$penulis','$penerbit','$tahun_terbit','$stok')");
  } else {
    echo "<script>alert('Tahun terbit minimal 1000 dan stok tidak boleh minus!');</script>";
  }
}

// Update Buku
if (isset($_POST['update'])) {
  $id_buku      = intval($_POST['id_buku']);
  $judul        = trim($_POST['judul']);
  $penulis      = trim($_POST['penulis']);
  $penerbit     = trim($_POST['penerbit']);
  $tahun_terbit = intval(trim($_POST['tahun_terbit']));
  $stok         = intval(trim($_POST['stok']));

  if ($tahun_terbit >= 1000 && $stok >= 0) {
    mysqli_query($conn, "UPDATE buku SET 
                judul='$judul',
                penulis='$penulis',
                penerbit='$penerbit',
                tahun_terbit='$tahun_terbit',
                stok='$stok'
              WHERE id_buku='$id_buku'");
  } else {
    echo "<script>alert('Tahun terbit minimal 1000 dan stok tidak boleh minus!');</script>";
  }
}

// Hapus Buku
if (isset($_POST['hapus'])) {
  $id_buku = intval($_POST['id_buku']);
  mysqli_query($conn, "DELETE FROM buku WHERE id_buku='$id_buku'");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koleksi Buku - SMK Negeri 1 Babat Supat</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* Floating Add Button */
    .fab {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 55px;
      height: 55px;
      background-color: #2c7a7b;
      border: none;           
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 28px;
      text-decoration: none;
      transition: 0.3s;
      z-index: 1000;
    }
    .fab:hover { 
      background-color: #225e5f; 
      transform: scale(1.1); 
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center; align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px 25px;
      border-radius: 12px;
      width: 420px;
      max-width: 95%;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      animation: fadeIn 0.3s ease-in-out;
    }
    .modal-header {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
      padding-bottom: 8px;
      border-bottom: 2px solid #2c7a7b;
      color: #2c7a7b;
      text-align: center;
    }
    .form-group { margin-bottom: 14px; }
    .form-group label { 
      display:block; 
      margin-bottom:6px; 
      font-weight: 600;
      font-size: 14px;
      color: #333;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border:1px solid #bbb;
      border-radius: 8px;
      font-size: 14px;
      transition: border 0.2s;
    }
    .form-group input:focus {
      border-color: #2c7a7b;
      outline: none;
    }

    /* Footer tombol */
    .modal-footer { 
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 15px; 
    }
    .btn { 
      padding: 8px 16px; 
      border:none; 
      border-radius:8px; 
      cursor:pointer; 
      font-weight: 600;
      transition: 0.2s;
    }
    .btn-save { 
      background:#2c7a7b; 
      color:#fff; 
    }
    .btn-save:hover { background:#225e5f; }
    .btn-cancel { 
      background:#e53e3e; 
      color:#fff; 
    }
    .btn-cancel:hover { background:#c53030; }

    /* Tombol aksi (edit & hapus) */
    .btn-action {
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin: 0 2px;
      color: #fff;
    }
    .btn-edit { background-color: #38a169; }   /* Hijau */
    .btn-edit:hover { background-color: #2f855a; }
    .btn-delete { background-color: #e53e3e; } /* Merah */
    .btn-delete:hover { background-color: #c53030; }
    .btn-action i { pointer-events: none; }

    /* Animasi modal */
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body>
  <div class="frame">
    <div class="container">

      <!-- HEADER -->
      <header class="header">
        <h1 class="judul-header">SMK NEGERI 1 BABAT SUPAT</h1>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
      </header>

      <!-- NAVBAR -->
      <nav id="navbar">
        <ul>
          <li><a href="beranda.php">Beranda</a></li>
          <li><a href="koleksi.php" class="active">Koleksi Buku</a></li>
          <li><a href="anggota.php">Anggota</a></li>
          <li><a href="peminjaman.php">Peminjaman Buku</a></li>
          <li><a href="laporan.php">Laporan</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <!-- CONTENT -->
      <main>
        <section class="koleksi">
          <div class="welcome-box">
            <h2>TABEL KOLEKSI BUKU</h2>
          </div>

          <!-- pencarian -->
          <div class="search-box">
            <label for="cariBuku">Judul Buku:</label>
            <input id="cariBuku" type="text" placeholder="Ex. Matematika, Bahasa Indonesia…" onkeyup="searchTable()">
            <button type="button" onclick="searchTable()">Cari</button>
          </div>

          <!-- tabel koleksi -->
          <div class="table-wrapper">
            <table class="table-koleksi" id="koleksiTable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Judul</th>
                  <th>Penulis</th>
                  <th>Penerbit</th>
                  <th>Tahun Terbit</th>
                  <th>Stok</th>
                  <th>Pengaturan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
                while ($row = mysqli_fetch_assoc($query)) {
                  echo "<tr>
                          <td>".$no++."</td>
                          <td>".$row['judul']."</td>
                          <td>".$row['penulis']."</td>
                          <td>".$row['penerbit']."</td>
                          <td>".$row['tahun_terbit']."</td>
                          <td>".$row['stok']."</td>
                          <td class='action'>
                            <button class='btn-action btn-edit' onclick='openEditModal(".json_encode($row).")'><i class='fas fa-pen'></i></button>
                            <button class='btn-action btn-delete' onclick='openDeleteModal(".$row['id_buku'].")'><i class='fas fa-trash'></i></button>
                          </td>
                        </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </section>
      </main>

      <!-- FOOTER -->
      <footer>
        <p>&copy; Copyright 2025 SMK Negeri 1 Babat Supat</p>
      </footer>
    </div>
  </div>

  <!-- Floating Add Button -->
  <button class="fab" onclick="openAddModal()">+</button>

  <!-- Modal Tambah/Edit -->
  <div id="modalForm" class="modal">
    <div class="modal-content">
      <div class="modal-header" id="modalTitle">Tambah Buku</div>
      <form method="post" id="formModal">
        <input type="hidden" name="id_buku" id="id_buku">
        <div class="form-group"><label>Judul</label><input type="text" name="judul" id="judul" required></div>
        <div class="form-group"><label>Penulis</label><input type="text" name="penulis" id="penulis" required></div>
        <div class="form-group"><label>Penerbit</label><input type="text" name="penerbit" id="penerbit" required></div>
        <div class="form-group"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" id="tahun_terbit" required></div>
        <div class="form-group"><label>Stok</label><input type="number" name="stok" id="stok" required></div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-save" id="btnSubmit" name="simpan">Simpan</button>
          <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Hapus -->
  <div id="modalDelete" class="modal">
    <div class="modal-content">
      <div class="modal-header">Konfirmasi Hapus</div>
      <form method="post">
        <input type="hidden" name="id_buku" id="deleteId">
        <p>Yakin ingin menghapus data ini?</p>
        <div class="modal-footer">
          <button type="submit" class="btn btn-save" name="hapus">Ya, Hapus</button>
          <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JS -->
  <script>
    function searchTable() {
      let input = document.getElementById("cariBuku").value.toLowerCase();
      let table = document.getElementById("koleksiTable");
      let rows = table.getElementsByTagName("tr");

      for (let i = 1; i < rows.length; i++) { 
        let cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
          if (cells[j].innerText.toLowerCase().includes(input)) {
            match = true;
            break;
          }
        }
        rows[i].style.display = match ? "" : "none";
      }
    }

    function openAddModal() {
      document.getElementById("modalTitle").innerText = "Tambah Buku";
      document.getElementById("btnSubmit").name = "simpan";
      document.getElementById("formModal").reset();
      document.getElementById("modalForm").style.display = "flex";
    }
    function openEditModal(data) {
      document.getElementById("modalTitle").innerText = "Edit Buku";
      document.getElementById("btnSubmit").name = "update";
      document.getElementById("id_buku").value = data.id_buku;
      document.getElementById("judul").value = data.judul;
      document.getElementById("penulis").value = data.penulis;
      document.getElementById("penerbit").value = data.penerbit;
      document.getElementById("tahun_terbit").value = data.tahun_terbit;
      document.getElementById("stok").value = data.stok;
      document.getElementById("modalForm").style.display = "flex";
    }
    function openDeleteModal(id_buku) {
      document.getElementById("deleteId").value = id_buku;
      document.getElementById("modalDelete").style.display = "flex";
    }
    function closeModal() {
      document.querySelectorAll(".modal").forEach(m => m.style.display = "none");
    }

    function toggleMenu() {
      const nav = document.querySelector("nav ul");
      nav.classList.toggle("show");
    }

    function logout() {
      localStorage.removeItem("isLoggedIn");
      window.location.href = "index.php";
    }

    window.onclick = function(e) {
      if (e.target.classList.contains("modal")) closeModal();
    }

    // reload otomatis setelah submit form tambah/edit
    document.getElementById("formModal").onsubmit = function() {
      setTimeout(() => { location.reload(); }, 500);
    };
    // reload otomatis setelah submit hapus
    document.querySelector("#modalDelete form").onsubmit = function() {
      setTimeout(() => { location.reload(); }, 500);
    };
  </script>
</body>
</html>
