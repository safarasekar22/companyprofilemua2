<?php
$page_title = 'Kontak';
$active = 'kontak';

require 'includes/koneksi.php';

$form_sent = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if ($nama === '') { $errors[] = 'Nama wajib diisi.'; }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Email tidak valid.'; }
    if ($pesan === '') { $errors[] = 'Pesan wajib diisi.'; }

    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, 'INSERT INTO pesan_masuk (nama, email, pesan) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $nama, $email, $pesan);

        if (mysqli_stmt_execute($stmt)) {
            $form_sent = true;
            $_POST = []; // kosongkan form setelah berhasil
        } else {
            $errors[] = 'Gagal menyimpan pesan, silakan coba lagi.';
        }
        mysqli_stmt_close($stmt);
    }
}

include 'includes/header.php';
?>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Kontak</span>
      <h2>Mari Wujudkan Tampilan Impianmu</h2>
    </div>

    <div class="contact-grid">
      <div class="contact-info">
        <dl>
          <dt>Studio</dt>
          <dd>Jl. Kemuning No. 12, Jakarta Selatan</dd>

          <dt>Telepon / WhatsApp</dt>
          <dd>+62 812-3456-7890</dd>

          <dt>Email</dt>
          <dd>hello@rascmakeup.com</dd>

          <dt>Jam Operasional</dt>
          <dd>Senin – Sabtu, 09.00 – 18.00 WIB</dd>
        </dl>

        <div class="social-row">
          <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram">IG</a>
          <a href="https://tiktok.com" target="_blank" rel="noopener" aria-label="TikTok">TT</a>
          <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>
        </div>

        <div class="map-box">
          <iframe
            src="https://www.google.com/maps?q=Jl.+Kemuning+Raya+No.12,+RT.9/RW.6,+Pejaten+Timur,+Pasar+Minggu,+Jakarta+Selatan,+12510&output=embed"            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Peta Lokasi Studio RASC Makeup">
          </iframe>
        </div>
      </div>

      <div>
        <?php if ($form_sent): ?>
          <div class="form-msg ok">Terima kasih! Pesanmu sudah kami terima, tim RASC akan segera menghubungi.</div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
          <div class="form-msg" style="background:#f4e3e3; color:#7a2c2c;">
            <?php foreach ($errors as $err) { echo htmlspecialchars($err) . '<br>'; } ?>
          </div>
        <?php endif; ?>

        <form class="contact-form" method="post" action="kontak.php">
          <div>
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
          </div>
          <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
          </div>
          <div>
            <label for="pesan">Ulasan</label>
            <textarea id="pesan" name="pesan" required><?php echo htmlspecialchars($_POST['pesan'] ?? ''); ?></textarea>
          </div>
          <button type="submit" class="submit-btn">Kirim Ulasan</button>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="section alt">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">FAQ</span>
      <h2>Pertanyaan yang Sering Ditanyakan</h2>
    </div>
    <div class="faq-list">
      <details class="faq-item" open>
        <summary>Apakah perlu booking jauh-jauh hari?</summary>
        <p>Untuk wedding sebaiknya booking minimal 1 bulan sebelumnya, sedangkan untuk graduation atau photoshoot bisa H-1 minggu tergantung ketersediaan jadwal.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah RASC bisa datang ke lokasi klien?</summary>
        <p>Bisa, melalui layanan Makeup On Call. Biaya transportasi menyesuaikan jarak lokasi dari studio.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah ada sesi trial makeup sebelum hari-H?</summary>
        <p>Untuk paket wedding, trial makeup sudah termasuk dalam paket agar look yang dipilih benar-benar sesuai keinginan.</p>
      </details>
      <details class="faq-item">
        <summary>Apa metode pembayaran yang tersedia?</summary>
        <p>Kami menerima transfer bank dan QRIS, dengan DP minimal 30% untuk mengamankan jadwal.</p>
      </details>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
