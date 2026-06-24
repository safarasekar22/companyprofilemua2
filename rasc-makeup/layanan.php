<?php
$page_title = 'Layanan & Portofolio';
$active = 'layanan';
require 'includes/koneksi.php';
$layanan_list = mysqli_query($koneksi, 'SELECT * FROM layanan ORDER BY urutan, id');
include 'includes/header.php';
?>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Layanan Kami</span>
      <h2>Pilih Momen, Kami Sempurnakan</h2>
    </div>

    <div class="service-list">
      <?php while ($l = mysqli_fetch_assoc($layanan_list)):
        $foto_path = 'assets/img/layanan/' . ($l['foto'] ?: '');
        $nama_esc = htmlspecialchars($l['nama']);
      ?>
      <div class="service-card">
        <div class="service-img-wrap">
          <?php if ($l['foto']): ?>
            <img src="<?php echo $foto_path; ?>" alt="<?php echo $nama_esc; ?>" class="service-img-photo"
                 onerror="this.parentElement.querySelector('.service-img-fallback').style.display='flex'; this.style.display='none';">
          <?php endif; ?>
          <div class="service-img service-img-fallback" <?php echo $l['foto'] ? 'style="display:none;"' : ''; ?>>
            <?php echo $nama_esc; ?>
          </div>
        </div>
        <div class="service-body">
          <h3><?php echo $nama_esc; ?></h3>
          <p><?php echo htmlspecialchars($l['deskripsi']); ?></p>
          <span class="service-price"><?php echo htmlspecialchars($l['harga']); ?></span>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <div class="section-head center" style="margin-top:88px;">
      <span class="eyebrow">Portofolio</span>
      <h2>Hasil Karya Kami</h2>
    </div>
    <div class="portfolio-grid">
      <div class="portfolio-item-wrap">
        <img src="assets/img/portofolio/wedding-look.jpg" alt="Wedding Look" class="portfolio-photo" onerror="this.parentElement.querySelector('.portfolio-item').style.display='flex'; this.style.display='none';">
        <div class="portfolio-item" style="display:none;">Wedding Look</div>
      </div>
      <div class="portfolio-item-wrap">
        <img src="assets/img/portofolio/graduation-look.jpg" alt="Graduation Look" class="portfolio-photo" onerror="this.parentElement.querySelector('.portfolio-item').style.display='flex'; this.style.display='none';">
        <div class="portfolio-item" style="display:none;">Graduation Look</div>
      </div>
      <div class="portfolio-item-wrap">
        <img src="assets/img/portofolio/editorial-look.jpg" alt="Editorial Look" class="portfolio-photo" onerror="this.parentElement.querySelector('.portfolio-item').style.display='flex'; this.style.display='none';">
        <div class="portfolio-item" style="display:none;">Editorial Look</div>
      </div>
      <div class="portfolio-item-wrap">
        <img src="assets/img/portofolio/party-glam.jpg" alt="Party Glam" class="portfolio-photo" onerror="this.parentElement.querySelector('.portfolio-item').style.display='flex'; this.style.display='none';">
        <div class="portfolio-item" style="display:none;">Party Glam</div>
      </div>
    </div>
    <p style="text-align:center; font-size:13px; color:#7a7372; margin-top:18px;">
  </div>
</section>

<section class="section alt">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Testimoni</span>
      <h2>Kata Mereka Tentang RASC</h2>
    </div>
    <div class="testi-grid">
      <div class="testi-card">
        <span class="quote-mark">&ldquo;</span>
        <p class="testi-text">Makeup-nya tahan dari pagi sampai resepsi malam, sama sekali gak luntur. Tim-nya juga super sabar dengerin request aku.</p>
        <div class="testi-name">Bella Pratiwi</div>
        <div class="testi-role">Wedding Client</div>
      </div>
      <div class="testi-card">
        <span class="quote-mark">&ldquo;</span>
        <p class="testi-text">Hasil makeup wisuda natural banget tapi tetap glowing di foto. Bakal balik lagi buat acara berikutnya!</p>
        <div class="testi-name">Nadia Putri</div>
        <div class="testi-role">Graduation Client</div>
      </div>
      <div class="testi-card">
        <span class="quote-mark">&ldquo;</span>
        <p class="testi-text">Profesional dari konsultasi sampai eksekusi. Hasil photoshoot jadi jauh lebih hidup di kamera.</p>
        <div class="testi-name">Sarah Amelia</div>
        <div class="testi-role">Photoshoot Client</div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
