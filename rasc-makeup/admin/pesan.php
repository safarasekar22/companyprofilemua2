<?php
require 'auth.php';
require '../includes/koneksi.php';
$page_title = 'Ulasan Masuk';
$active = 'pesan';

// Delete
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pesan_masuk WHERE id = $id");
    header('Location: pesan.php?ok=hapus');
    exit;
}

$pesan_list = mysqli_query($koneksi, 'SELECT * FROM pesan_masuk ORDER BY dikirim_pada DESC');
include 'header.php';
?>
<div class="main">
  <div class="topbar">
    <h1>Ulasan Masuk</h1>
  </div>
  <div class="content">

    <?php if (isset($_GET['ok'])): ?>
      <div class="alert alert-ok">Pesan berhasil dihapus.</div>
    <?php endif; ?>

    <div class="card">
      <div class="card-head">
        <h2>Semua Pesan</h2>
        <span style="font-size:13px;color:#7a7372;"><?php echo mysqli_num_rows($pesan_list); ?> pesan</span>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Isi Pesan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($pesan_list) === 0): ?>
            <tr><td colspan="6" style="text-align:center; color:#7a7372; padding:32px;">Belum ada ulasan masuk.</td></tr>
          <?php else: ?>
            <?php $no = 1; while ($p = mysqli_fetch_assoc($pesan_list)): ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($p['nama']); ?></td>
              <td><a href="mailto:<?php echo htmlspecialchars($p['email']); ?>" style="color:#8c3b46;"><?php echo htmlspecialchars($p['email']); ?></a></td>
              <td>
                <div class="pesan-box"><?php echo htmlspecialchars($p['pesan']); ?></div>
              </td>
              <td style="white-space:nowrap;"><?php echo date('d M Y<\b\r>H:i', strtotime($p['dikirim_pada'])); ?></td>
              <td>
                <a href="pesan.php?hapus=<?php echo $p['id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus pesan dari <?php echo htmlspecialchars($p['nama']); ?>?')">
                  Hapus
                </a>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
<?php include 'footer.php'; ?>
