<?php
session_start();

// Jika sudah login langsung ke beranda
if (isset($_SESSION['username'])) {
  header("Location: beranda.php");
  exit;
}

// Kalau form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Bebas: asal ada isinya
  if (!empty($username) && !empty($password)) {
    $_SESSION['username'] = $username;
    header("Location: beranda.php");
    exit;
  } else {
    $error = "Username & Password wajib diisi!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-title">
      <h1>Perpustakaan Digital</h1>
      <h2>SMK Negeri 1 Babat Supat</h2>
    </div>

    <?php if (!empty($error)): ?>
      <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" class="login-form">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukkan username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password" required>

      <button type="submit" class="btn-login">Login</button>
    </form>

    <p class="footer-text">&copy; Copyright 2025 SMK Negeri 1 Babat Supat</p>
  </div>
</body>
</html>
