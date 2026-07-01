<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: admin/index.php');
    exit;
}

require 'includes/koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = mysqli_prepare($koneksi, 'SELECT id, password FROM users WHERE username = ?');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $username;
            header('Location: admin/index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Username dan password wajib diisi.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — RASC Makeup</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<style>
  .login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at 50% 30%, #f6e8e3 0%, #f7f1ec 70%);
    padding: 24px;
  }
  .login-box {
    background: #fff;
    border: 1px solid rgba(28,26,26,0.08);
    border-radius: 6px;
    padding: 48px 40px;
    width: 100%;
    max-width: 420px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(28,26,26,0.07);
  }
  .login-box img { margin: 0 auto 20px; }
  .login-box h1 { font-size: 26px; margin-bottom: 4px; }
  .login-box .sub { font-size: 13px; color: #7a7372; letter-spacing: 0.06em; margin-bottom: 32px; }
  .login-field { margin-bottom: 20px; text-align: left; }
  .login-field label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: #7a7372;
    margin-bottom: 8px;
  }
  .login-field input {
    width: 100%;
    border: 1px solid rgba(28,26,26,0.18);
    border-radius: 4px;
    padding: 12px 14px;
    font-family: 'Jost', sans-serif;
    font-size: 15px;
    color: #1c1a1a;
    outline: none;
    transition: border-color .2s;
    box-sizing: border-box;
  }
  .login-field input:focus { border-color: #8c3b46; }
  .login-btn {
    width: 100%;
    padding: 14px;
    background: #1c1a1a;
    color: #f7f1ec;
    border: none;
    border-radius: 999px;
    font-family: 'Jost', sans-serif;
    font-size: 13px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    cursor: pointer;
    margin-top: 8px;
    transition: background .25s;
  }
  .login-btn:hover { background: #8c3b46; }
  .login-error {
    background: #f4e3e3;
    color: #7a2c2c;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 13px;
    margin-bottom: 20px;
  }
  .back-link {
    display: block;
    margin-top: 22px;
    font-size: 13px;
    color: #8c3b46;
    letter-spacing: 0.04em;
  }
  .back-link:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="login-wrap">
  <div class="login-box">
    <img src="assets/logo.svg" alt="RASC Makeup" width="72" height="72">
    <h1>Admin Panel</h1>
    <p class="sub">RASC Makeup</p>

    <?php if ($error): ?>
      <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
      <div class="login-field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required autofocus>
      </div>
      <div class="login-field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
    <a href="index.php" class="back-link">← Kembali ke Website</a>
  </div>
</div>
</body>
</html>
