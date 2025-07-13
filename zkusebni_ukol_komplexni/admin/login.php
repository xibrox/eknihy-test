<?php
require_once '../includes/auth.php';

$config = require_once '../includes/config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if ($password === $config['admin_password']) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Nesprávné heslo.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin přihlášení</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin">
    <div class="login-box">
        <h1>Přihlášení</h1>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="Zadejte heslo">
            <button type="submit">Přihlásit se</button>
        </form>
    </div>
</body>
</html>