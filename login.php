<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login($_POST['username'], $_POST['password'])) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Date invalide!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Logare</title>
</head>
<body>
  <h2>Autentificare</h2>
  <?php if (!empty($error)): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
  <form method="post">
    Username:<br><input type="text" name="username" required><br>
    Parolă:<br><input type="password" name="password" required><br><br>
    <button type="submit">Loghează-te</button>
  </form>
</body>
</html>
