<?php
// $page_title dan $active harus di-set di file pemanggil sebelum include ini
if (!isset($page_title)) { $page_title = 'RASC Makeup'; }
if (!isset($active)) { $active = ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($page_title); ?> — RASC Makeup</title>
<meta name="description" content="RASC Makeup — Jasa makeup artist profesional untuk wedding, graduation, photoshoot, dan acara spesial Anda.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="site-header">
  <div class="nav-wrap">
    <a href="index.php" class="brand"><img src="assets/logo.svg" alt="" width="34" height="34">RASC <span>Makeup</span></a>
    <button class="nav-toggle" aria-label="Buka menu" onclick="document.getElementById('navLinks').classList.toggle('open')">&#9776;</button>
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" class="<?php echo $active==='cover' ? 'active' : ''; ?>">Beranda</a></li>
      <li><a href="tentang-kami.php" class="<?php echo $active==='tentang' ? 'active' : ''; ?>">Tentang Kami</a></li>
      <li><a href="layanan.php" class="<?php echo $active==='layanan' ? 'active' : ''; ?>">Layanan</a></li>
      <li><a href="kontak.php" class="<?php echo $active==='kontak' ? 'active' : ''; ?>">Kontak</a></li>
    </ul>
  </div>
</header>
