<?php
include "koneksi.php";

// Tambah Anggota
if (isset($_POST['simpan'])) {
  $nama   = trim($_POST['nama']);
  $kelas  = trim($_POST['kelas']);
  $alamat = trim($_POST['alamat']);
  $no_hp  = trim($_POST['no_hp']);

  mysqli_query($conn, "INSERT INTO anggota (nama, kelas, alamat, no_hp) 
                       VALUES ('$nama','$kelas','$alamat','$no_hp')");
}

// Update Anggota
if (isset($_POST['update'])) {
  $id     = intval($_POST['id']);
  $nama   = trim($_POST['nama']);
  $kelas  = trim($_POST['kelas']);
  $alamat = trim($_POST['alamat']);
  $no_hp  = trim($_POST['no_hp']);

  mysqli_query($conn, "UPDATE anggota SET 
              nama='$nama',
              kelas='$kelas',
              alamat='$alamat',
              no_hp='$no_hp'
            WHERE id_anggota='$id'");
}

// Hapus Anggota
if (isset($_POST['hapus'])) {
  $id = intval($_POST['id']);
  mysqli_query($conn, "DELETE FROM anggota WHERE id_anggota='$id'");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anggota - SMK Negeri 1 Babat Supat</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* tombol aksi */
    .btn-action {
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin: 0 2px;
      color: #fff;
    }
    .btn-edit { background-color: #38a169; }
    .btn-edit:hover { background-color: #2f855a; }
    .btn-delete { background-color: #e53e3e; }
    .btn-delete:hover { background-color: #c53030; }
    .btn-action i { pointer-events: none; }

    /* floating add button */
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
    .fab:hover { background-color: #225e5f; transform: scale(1.1); }

    /* modal */
    .modal { display: none; position: fixed; z-index: 999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
    .modal-content { background:#fff; padding:20px 25px; border-radius:12px; width:420px; max-width:95%; box-shadow:0 8px 20px rgba(0,0,0,0.25); animation:fadeIn 0.3s ease-in-out; }
    .modal-header { font-size:20px; font-weight:bold; margin-bottom:15px; padding-bottom:8px; border-bottom:2px solid #2c7a7b; color:#2c7a7b; text-align:center; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; margin-bottom:6px; font-weight:600; font-size:14px; color:#333; }
    .form-group input { width:100%; padding:10px; border:1px solid #bbb; border-radius:8px; font-size:14px; transition:border 0.2s; }
    .form-group input:focus { border-color:#2c7a7b; outline:none; }
    .modal-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:15px; }
    .btn { padding:8px 16px; border:none; border-radius:8px; cursor:pointer; font-weight:600; transition:0.2s; }
    .btn-save { background:#2c7a7b; color:#fff; }
    .btn-save:hover { background:#225e5f; }
    .btn-cancel { background:#e53e3e; color:#fff; }
    .btn-cancel:hover { background:#c53030; }
    @keyframes fadeIn { from{opacity:0; transform:translateY(-20px);} to{opacity:1; transform:translateY(0);} }
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
          <li><a href="koleksi.php">Koleksi Buku</a></li>
          <li><a href="anggota.php" class="active">Anggota</a></li>
          <li><a href="peminjaman.php">Peminjaman Buku</a></li>
          <li><a href="laporan.php">Laporan</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li class="nav-logout"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <!-- CONTENT -->
      <main>
        <section class="anggota">
          <div class="welcome-box">
            <h2>TABEL ANGGOTA</h2>
          </div>

          <!-- Pencarian -->
          <div class="search-box">
            <label for="cariAnggota">Cari Anggota:</label>
            <input id="cariAnggota" type="text" placeholder="Ex. Ahmad, Siti..." onkeyup="searchTable()">
            <button type="button" onclick="searchTable()">Cari</button>
          </div>

          <!-- Tabel -->
          <div class="table-wrapper">
            <table class="table-anggota" id="anggotaTable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Alamat</th>
                  <th>No. HP</th>
                  <th>Pengaturan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id_anggota DESC");
                while ($row = mysqli_fetch_assoc($query)) {
                  echo "<tr>
                          <td>".$no++."</td>
                          <td>".$row['nama']."</td>
                          <td>".$row['kelas']."</td>
                          <td>".$row['alamat']."</td>
                          <td>".$row['no_hp']."</td>
                          <td class='action'>
                            <button class='btn-action btn-edit' onclick='openEditModal(".json_encode($row).")'><i class=\"fas fa-pen\"></i></button>
                            <button class='btn-action btn-delete' onclick='openDeleteModal(".$row['id_anggota'].")'><i class=\"fas fa-trash\"></i></button>
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
      <div class="modal-header" id="modalTitle">Tambah Anggota</div>
      <form method="post" id="formModal">
        <input type="hidden" name="id" id="id">
        <div class="form-group"><label>Nama</label><input type="text" name="nama" id="nama" required></div>
        <div class="form-group"><label>Kelas</label><input type="text" name="kelas" id="kelas" required></div>
        <div class="form-group"><label>Alamat</label><input type="text" name="alamat" id="alamat" required></div>
        <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" id="no_hp" required></div>
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
        <input type="hidden" name="id" id="deleteId">
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
      let input = document.getElementById("cariAnggota").value.toLowerCase();
      let rows = document.querySelectorAll("#anggotaTable tbody tr");

      rows.forEach(row => {
        let cells = row.getElementsByTagName("td");
        let match = false;
        for (let j = 1; j < cells.length - 1; j++) {
          if (cells[j].innerText.toLowerCase().includes(input)) {
            match = true;
            break;
          }
        }
        row.style.display = match ? "" : "none";
      });
    }

    function openAddModal() {
      document.getElementById("modalTitle").innerText = "Tambah Anggota";
      document.getElementById("btnSubmit").name = "simpan";
      document.getElementById("formModal").reset();
      document.getElementById("modalForm").style.display = "flex";
    }
    function openEditModal(data) {
      document.getElementById("modalTitle").innerText = "Edit Anggota";
      document.getElementById("btnSubmit").name = "update";
      document.getElementById("id").value = data.id_anggota;
      document.getElementById("nama").value = data.nama;
      document.getElementById("kelas").value = data.kelas;
      document.getElementById("alamat").value = data.alamat;
      document.getElementById("no_hp").value = data.no_hp;
      document.getElementById("modalForm").style.display = "flex";
    }
    function openDeleteModal(id) {
      document.getElementById("deleteId").value = id;
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

    document.getElementById("formModal").onsubmit = function() {
      setTimeout(() => { location.reload(); }, 500);
    };
    document.querySelector("#modalDelete form").onsubmit = function() {
      setTimeout(() => { location.reload(); }, 500);
    };
  </script>
</body>
</html>
