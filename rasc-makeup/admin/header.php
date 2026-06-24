<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? htmlspecialchars($page_title).' — ' : ''; ?>Admin RASC Makeup</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-layout">
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="logo-wrap">
      <img src="../assets/logo.svg" alt="RASC" width="36" height="36">
      <div>
        <h2>RASC <span>Makeup</span></h2>
        <p>Admin Panel</p>
      </div>
    </div>
  </div>
  <nav class="sidebar-nav">
    <div class="divider">Menu</div>
    <a href="index.php" class="<?php echo ($active ?? '')==='dashboard' ? 'active' : ''; ?>">
      Dashboard
    </a>
    <a href="pesan.php" class="<?php echo ($active ?? '')==='pesan' ? 'active' : ''; ?>">
      Ulasan Masuk
    </a>
    <div class="divider">Kelola Konten</div>
    <a href="layanan.php" class="<?php echo ($active ?? '')==='layanan' ? 'active' : ''; ?>">
      Layanan
    </a>
    <a href="tim.php" class="<?php echo ($active ?? '')==='tim' ? 'active' : ''; ?>">
      Tim
    </a>
    <div class="divider">Lainnya</div>
    <a href="../index.php" target="_blank">
      Lihat Website
    </a>
    <a href="logout.php">
      Logout
    </a>
  </nav>
  <div class="sidebar-footer">
    Login sebagai <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin'); ?></strong>
  </div>
</aside>
