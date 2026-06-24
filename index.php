<?php
$page_title = 'Beranda';
$active = 'cover';
include 'includes/header.php';
?>

<section class="hero">
  <img src="assets/logo.svg" alt="Logo RASC Makeup" class="hero-logo-img" width="118" height="118">
  <h1 class="display">RASC <em>Makeup</em></h1>
  <p class="slogan">Cantik adalah caramu sendiri</p>

  <div class="shade-strip" aria-hidden="true">
    <span style="background:#e8c4c0"></span>
    <span style="background:#c97b84"></span>
    <span style="background:#8c3b46"></span>
    <span style="background:#a9824c"></span>
    <span style="background:#1c1a1a"></span>
  </div>

  <a href="tentang-kami.php" class="hero-cta">Kenali Kami</a>

  <div class="hero-highlights">
    <div><span class="display">6+</span><p>Tahun Pengalaman</p></div>
    <div><span class="display">500+</span><p>Klien Puas</p></div>
    <div><span class="display">12</span><p>Makeup Artist</p></div>
  </div>
</section>

<section class="section why-strip">
  <div class="container why-grid">
    <div class="why-item">
      <span class="eyebrow">01</span>
      <h3>Produk Aman &amp; Bersertifikat</h3>
      <p>Seluruh produk yang kami gunakan berlabel BPOM dan rutin diganti sesuai masa pakai.</p>
    </div>
    <div class="why-item">
      <span class="eyebrow">02</span>
      <h3>Tim Berpengalaman</h3>
      <p>Setiap MUA RASC telah melalui pelatihan dan menangani ratusan klien dari berbagai acara.</p>
    </div>
    <div class="why-item">
      <span class="eyebrow">03</span>
      <h3>Konsultasi Personal</h3>
      <p>Sesi konsultasi sebelum hari-H untuk memastikan look yang dipilih sesuai karakter wajahmu.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
