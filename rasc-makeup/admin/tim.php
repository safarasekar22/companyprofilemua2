<?php
require 'auth.php';
require '../includes/koneksi.php';
$page_title = 'Kelola Tim';
$active = 'tim';

$msg = '';
$msg_type = 'ok';

// DELETE
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tim WHERE id = $id");
    header('Location: tim.php?ok=hapus');
    exit;
}

// TAMBAH / EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;
    $nama    = trim($_POST['nama'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $urutan  = (int)($_POST['urutan'] ?? 0);
    $foto_lama = trim($_POST['foto_lama'] ?? '');

    $foto = $foto_lama;
    if (!empty($_FILES['foto']['name'])) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (in_array($ext, $allowed)) {
            $new_name = 'tim_' . time() . '.' . $ext;
            $dest = '../assets/img/team/' . $new_name;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) {
                $foto = $new_name;
            }
        }
    }

    if ($nama && $jabatan) {
        if ($id > 0) {
            $stmt = mysqli_prepare($koneksi, 'UPDATE tim SET nama=?, jabatan=?, foto=?, urutan=? WHERE id=?');
            mysqli_stmt_bind_param($stmt, 'sssii', $nama, $jabatan, $foto, $urutan, $id);
        } else {
            $stmt = mysqli_prepare($koneksi, 'INSERT INTO tim (nama, jabatan, foto, urutan) VALUES (?,?,?,?)');
            mysqli_stmt_bind_param($stmt, 'sssi', $nama, $jabatan, $foto, $urutan);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: tim.php?ok=' . ($id > 0 ? 'edit' : 'tambah'));
        exit;
    } else {
        $msg = 'Nama dan jabatan wajib diisi.';
        $msg_type = 'err';
    }
}

$edit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $res = mysqli_query($koneksi, 'SELECT * FROM tim WHERE id=' . (int)$_GET['edit']);
    $edit = mysqli_fetch_assoc($res);
}

$tim_list = mysqli_query($koneksi, 'SELECT * FROM tim ORDER BY urutan, id');
include 'header.php';
?>
<div class="main">
  <div class="topbar">
    <h1><?php echo $edit ? 'Edit Anggota Tim' : 'Kelola Tim'; ?></h1>
  </div>
  <div class="content">

    <?php if (isset($_GET['ok'])): ?>
      <div class="alert alert-ok">
        <?php echo $_GET['ok']==='hapus' ? 'Anggota tim berhasil dihapus.' : ($_GET['ok']==='edit' ? 'Data anggota berhasil diupdate.' : 'Anggota tim berhasil ditambahkan.'); ?>
      </div>
    <?php endif; ?>

    <?php if ($msg): ?>
      <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card" style="margin-bottom:28px;">
      <div class="card-head">
        <h2><?php echo $edit ? 'Edit: '.htmlspecialchars($edit['nama']) : 'Tambah Anggota Tim'; ?></h2>
        <?php if ($edit): ?><a href="tim.php" class="btn btn-outline btn-sm">+ Tambah Baru</a><?php endif; ?>
      </div>
      <div style="padding:24px;">
        <form method="post" enctype="multipart/form-data">
          <?php if ($edit): ?><input type="hidden" name="id" value="<?php echo $edit['id']; ?>"><?php endif; ?>
          <input type="hidden" name="foto_lama" value="<?php echo htmlspecialchars($edit['foto'] ?? ''); ?>">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($edit['nama'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="<?php echo htmlspecialchars($edit['jabatan'] ?? ''); ?>" required placeholder="contoh: Senior Bridal MUA">
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
            <button type="submit" class="btn btn-dark"><?php echo $edit ? 'Simpan Perubahan' : 'Tambah Anggota'; ?></button>
            <?php if ($edit): ?><a href="tim.php" class="btn btn-outline">Batal</a><?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- TABEL TIM -->
    <div class="card">
      <div class="card-head">
        <h2>Daftar Anggota Tim</h2>
        <span style="font-size:13px;color:#7a7372;"><?php echo mysqli_num_rows($tim_list); ?> anggota</span>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Foto</th>
            <th>Urutan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; while ($t = mysqli_fetch_assoc($tim_list)): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><strong><?php echo htmlspecialchars($t['nama']); ?></strong></td>
            <td><span class="badge badge-rose"><?php echo htmlspecialchars($t['jabatan']); ?></span></td>
            <td><?php echo $t['foto'] ? '<span style="font-size:12px;color:#7a7372;">'.htmlspecialchars($t['foto']).'</span>' : '<span style="color:#ccc;">—</span>'; ?></td>
            <td><?php echo $t['urutan']; ?></td>
            <td style="white-space:nowrap;">
              <a href="tim.php?edit=<?php echo $t['id']; ?>" class="btn btn-outline btn-sm">Edit</a>
              <a href="tim.php?hapus=<?php echo $t['id']; ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus <?php echo htmlspecialchars($t['nama']); ?> dari tim?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
<?php include 'footer.php'; ?>
