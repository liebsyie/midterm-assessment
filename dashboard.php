<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: signin.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Nunito', sans-serif;
    background: #e8eaf0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
  }
  .card {
    background: #fff;
    border-radius: 24px;
    padding: 60px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    max-width: 500px;
    width: 90%;
  }
  .success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #6a11cb, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 36px;
  }
  h1 { font-size: 28px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px; }
  .method-badge {
    display: inline-block;
    background: linear-gradient(135deg, #6a11cb, #7c3aed);
    color: #fff;
    padding: 4px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin: 10px 0 20px;
  }
  p { color: #888; font-size: 14px; margin-bottom: 30px; }
  .btn {
    display: inline-block;
    padding: 12px 30px;
    border-radius: 50px;
    background: linear-gradient(135deg, #6a11cb, #7c3aed);
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
  }
  .injection-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 12px;
    padding: 16px;
    margin: 20px 0;
    text-align: left;
    font-size: 12px;
    color: #856404;
  }
  .injection-warning strong { display: block; margin-bottom: 6px; font-size: 13px; }
</style>
</head>
<body>
<div class="card">
  <div class="success-icon">✓</div>
  <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
  <div class="method-badge">Auth via: <?= htmlspecialchars($_SESSION['method']) ?></div>

  <?php if (strpos($_SESSION['user'], 'OR') !== false || $_SESSION['user'] === '' || $_SESSION['user'] === 'anonymous'): ?>
  <div class="injection-warning">
    <strong>💥 SQL INJECTION SUCCESSFUL!</strong>
    The system was bypassed using SQL injection. You logged in without valid credentials! 
    This proves why unsanitized queries are dangerous.
  </div>
  <?php endif; ?>

  <p>You have successfully authenticated using <strong><?= htmlspecialchars($_SESSION['method']) ?></strong>. 
  This page is only accessible to logged-in users.</p>

  <a href="signin.html" class="btn">🚪 Logout</a>

  <div style="margin-top:20px;">
    <a href="signin.html" style="color:#7c3aed;font-size:12px;font-weight:700;">← Back to Login</a>
  </div>
</div>
</body>
</html>
<?php session_destroy(); // Auto-logout for demo ?>
