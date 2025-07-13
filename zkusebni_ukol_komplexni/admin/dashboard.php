<?php
require_once '../includes/auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin – Přehled</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin">
    <h1>Admin rozcestník</h1>
    <ul class="admin-list">
        <li><a href="add_book.php" class="button">Přidat novou knihu</a></li>
        <li><a href="import.php" class="button">Import z JSON</a></li>
        <li><a href="../public/index.php" class="button">Zpět na veřejný katalog</a></li>
        <li><a href="logout.php" class="button">Odhlásit se</a></li>
    </ul>
</body>
</html>