<?php
require 'auth.php';
require '../includes/koneksi.php';
$page_title = 'Dashboard';
$active = 'dashboard';

$jml_pesan = mysqli_fetch_row(mysqli_query($koneksi, 'SELECT COUNT(*) FROM pesan_masuk'))[0];
$jml_layanan = mysqli_fetch_row(mysqli_query($koneksi, 'SELECT COUNT(*) FROM layanan'))[0];
$jml_tim = mysqli_fetch_row(mysqli_query($koneksi, 'SELECT COUNT(*) FROM tim'))[0];

$pesan_terbaru = mysqli_query($koneksi, 'SELECT * FROM pesan_masuk ORDER BY dikirim_pada DESC LIMIT 5');
include 'header.php';
?>
<div class="main">
  <div class="topbar">
    <h1>Dashboard</h1>
    <div class="topbar-right">
      <span><?php echo date('d F Y'); ?></span>
      <a href="../index.php" target="_blank" class="btn btn-outline btn-sm">Lihat Website</a>
    </div>
  </div>
  <div class="content">

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Ulasan Masuk</div>
        <span class="stat-val"><?php echo $jml_pesan; ?></span>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Layanan</div>
        <span class="stat-val"><?php echo $jml_layanan; ?></span>
      </div>
      <div class="stat-card">
        <div class="stat-label">Anggota Tim</div>
        <span class="stat-val"><?php echo $jml_tim; ?></span>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h2>Ulasan Terbaru</h2>
        <a href="pesan.php" class="btn btn-dark btn-sm">Lihat Semua</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($pesan_terbaru) === 0): ?>
            <tr><td colspan="4" style="text-align:center; color:#7a7372;">Belum ada ulasan masuk.</td></tr>
          <?php else: ?>
            <?php while ($p = mysqli_fetch_assoc($pesan_terbaru)): ?>
            <tr>
              <td><?php echo htmlspecialchars($p['nama']); ?></td>
              <td><?php echo htmlspecialchars($p['email']); ?></td>
              <td><?php echo htmlspecialchars(mb_substr($p['pesan'], 0, 60)).(mb_strlen($p['pesan'])>60?'…':''); ?></td>
              <td><?php echo date('d M Y H:i', strtotime($p['dikirim_pada'])); ?></td>
            </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
<?php include 'footer.php'; ?>
