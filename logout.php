<?php
session_start();
session_unset();   // hapus semua session
session_destroy(); // hancurkan session

// setelah logout, langsung balik ke halaman login
header("Location: index.php");
exit;
?>
