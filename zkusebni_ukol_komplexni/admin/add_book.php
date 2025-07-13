<?php
require_once '../includes/auth.php';
require_login();

require_once '../includes/db.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazev = trim($_POST['nazev'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $zanr = trim($_POST['zanr'] ?? '');
    $rok = (int)($_POST['rok'] ?? 0);
    $cena = (float)($_POST['cena'] ?? 0);
    $hodnoceni = (float)($_POST['hodnoceni'] ?? 0);
    $anotace = trim($_POST['anotace'] ?? '');
    $obalka = trim($_POST['obalka_knihy'] ?? '');

    if ($nazev === '') $errors[] = 'Název je povinný.';
    if ($autor === '') $errors[] = 'Autor je povinný.';
    if ($zanr === '') $errors[] = 'Žánr je povinný.';
    if ($rok < 1000 || $rok > intval(date('Y'))) $errors[] = 'Neplatný rok vydání.';
    if ($cena < 0) $errors[] = 'Cena musí být nezáporná.';
    if ($hodnoceni < 0 || $hodnoceni > 5) $errors[] = 'Hodnocení musí být mezi 0 a 5.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO knihy (nazev, autor, zanr, rok, cena, hodnoceni, anotace, obalka_knihy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nazev, $autor, $zanr, $rok, $cena, $hodnoceni, $anotace, $obalka]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidat novou knihu</title>
    <script src="../src/js/validation.js" defer></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin">
    <h1>Přidat novou knihu</h1>
    <?php if ($success): ?>
        <div class="message">Kniha byla úspěšně přidána.</div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nazev" placeholder="Název knihy" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="zanr" placeholder="Žánr">
        <input type="number" name="rok" placeholder="Rok vydání" required>
        <input type="number" step="0.01" name="cena" placeholder="Cena v Kč" required>
        <input type="number" step="0.1" name="hodnoceni" placeholder="Hodnocení (0–5)" required>
        <textarea name="anotace" placeholder="Anotace knihy"></textarea>
        <input type="text" name="obalka_knihy" placeholder="Cesta k obálce (např. assets/img/kniha.jpg)">
        <button type="submit">Přidat knihu</button>
    </form>
</body>
</html>
