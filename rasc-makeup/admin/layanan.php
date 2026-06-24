<?php
require 'auth.php';
require '../includes/koneksi.php';
$page_title = 'Kelola Layanan';
$active = 'layanan';

$msg = '';
$msg_type = 'ok';

// DELETE
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM layanan WHERE id = $id");
    header('Location: layanan.php?ok=hapus');
    exit;
}

// TAMBAH / EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;
    $nama  = trim($_POST['nama'] ?? '');
    $desk  = trim($_POST['deskripsi'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $urutan = (int)($_POST['urutan'] ?? 0);
    $foto_lama = trim($_POST['foto_lama'] ?? '');

    // Upload foto (opsional)
    $foto = $foto_lama;
    if (!empty($_FILES['foto']['name'])) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (in_array($ext, $allowed)) {
            $new_name = 'layanan_' . time() . '.' . $ext;
            $dest = '../assets/img/layanan/' . $new_name;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) {
                $foto = $new_name;
            }
        }
    }

    if ($nama && $desk && $harga) {
        if ($id > 0) {
            $stmt = mysqli_prepare($koneksi, 'UPDATE layanan SET nama=?, deskripsi=?, harga=?, foto=?, urutan=? WHERE id=?');
            mysqli_stmt_bind_param($stmt, 'ssssii', $nama, $desk, $harga, $foto, $urutan, $id);
        } else {
            $stmt = mysqli_prepare($koneksi, 'INSERT INTO layanan (nama, deskripsi, harga, foto, urutan) VALUES (?,?,?,?,?)');
            mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $desk, $harga, $foto, $urutan);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: layanan.php?ok=' . ($id > 0 ? 'edit' : 'tambah'));
        exit;
    } else {
        $msg = 'Nama, deskripsi, dan harga wajib diisi.';
        $msg_type = 'err';
    }
}

// Ambil data edit
$edit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $res = mysqli_query($koneksi, 'SELECT * FROM layanan WHERE id=' . (int)$_GET['edit']);
    $edit = mysqli_fetch_assoc($res);
}

$layanan_list = mysqli_query($koneksi, 'SELECT * FROM layanan ORDER BY urutan, id');
include 'header.php';
?>
<div class="main">
  <div class="topbar">
    <h1><?php echo $edit ? 'Edit Layanan' : 'Kelola Layanan'; ?></h1>
  </div>
  <div class="content">

    <?php if (isset($_GET['ok'])): ?>
      <div class="alert alert-ok">
        <?php echo $_GET['ok']==='hapus' ? 'Layanan berhasil dihapus.' : ($_GET['ok']==='edit' ? 'Layanan berhasil diupdate.' : 'Layanan berhasil ditambahkan.'); ?>
      </div>
    <?php endif; ?>

    <?php if ($msg): ?>
      <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <!-- FORM TAMBAH/EDIT -->
    <div class="card" style="margin-bottom:28px;">
      <div class="card-head">
        <h2><?php echo $edit ? 'Edit: '.htmlspecialchars($edit['nama']) : 'Tambah Layanan Baru'; ?></h2>
        <?php if ($edit): ?><a href="layanan.php" class="btn btn-outline btn-sm">+ Tambah Baru</a><?php endif; ?>
      </div>
      <div style="padding:24px;">
        <form method="post" enctype="multipart/form-data">
          <?php if ($edit): ?><input type="hidden" name="id" value="<?php echo $edit['id']; ?>"><?php endif; ?>
          <input type="hidden" name="foto_lama" value="<?php echo htmlspecialchars($edit['foto'] ?? ''); ?>">
          <div class="form-group">
            <label>Nama Layanan</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($edit['nama'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?php echo htmlspecialchars($edit['deskripsi'] ?? ''); ?></textarea>
          </div>
          <div class="form-group">
            <label>Harga (contoh: Mulai Rp 500.000)</label>
            <input type="text" name="harga" value="<?php echo htmlspecialchars($edit['harga'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="urutan" value="<?php echo htmlspecialchars($edit['urutan'] ?? 0); ?>" min="0">
          </div>
          <div class="form-group">
            <label>Foto (jpg/png/webp, opsional)</label>
            <input type="file" name="foto" accept="image/*">
            <?php if (!empty($edit['foto'])): ?>
              <small style="color:#7a7372;">Foto saat ini: <?php echo htmlspecialchars($edit['foto']); ?></small>
            <?php endif; ?>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-dark"><?php echo $edit ? 'Simpan Perubahan' : 'Tambah Layanan'; ?></button>
            <?php if ($edit): ?><a href="layanan.php" class="btn btn-outline">Batal</a><?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- TABEL LAYANAN -->
    <div class="card">
      <div class="card-head">
        <h2>Daftar Layanan</h2>
        <span style="font-size:13px;color:#7a7372;"><?php echo mysqli_num_rows($layanan_list); ?> layanan</span>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Urutan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; while ($l = mysqli_fetch_assoc($layanan_list)): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td>
              <strong><?php echo htmlspecialchars($l['nama']); ?></strong>
              <div style="font-size:12px;color:#7a7372;margin-top:3px;"><?php echo htmlspecialchars(mb_substr($l['deskripsi'],0,60)).'…'; ?></div>
            </td>
            <td><span class="badge badge-gold"><?php echo htmlspecialchars($l['harga']); ?></span></td>
            <td><?php echo $l['foto'] ? '<span class="badge badge-rose">'.htmlspecialchars($l['foto']).'</span>' : '<span style="color:#ccc;">—</span>'; ?></td>
            <td><?php echo $l['urutan']; ?></td>
            <td style="white-space:nowrap;">
              <a href="layanan.php?edit=<?php echo $l['id']; ?>" class="btn btn-outline btn-sm">Edit</a>
              <a href="layanan.php?hapus=<?php echo $l['id']; ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus layanan <?php echo htmlspecialchars($l['nama']); ?>?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
<?php include 'footer.php'; ?>
