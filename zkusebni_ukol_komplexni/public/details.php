<?php
require_once '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Neplatné ID knihy.";
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM knihy WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo "Kniha nebyla nalezena.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['nazev']) ?> – Detail knihy</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Zpět na katalog</a>
    </div>

    <div class="book-detail">
        <?php
        $src = (isset($book['obalka_knihy']) && str_starts_with($book['obalka_knihy'], 'assets/img/'))
            ? '../' . htmlspecialchars($book['obalka_knihy'])
            : '../assets/img/default.png';
        ?>
        <img src="<?= $src ?>" alt="Obálka knihy">
        <div class="book-info">
            <h1><?= htmlspecialchars($book['nazev']) ?></h1>
            <p><strong>Autor:</strong> <?= htmlspecialchars($book['autor']) ?></p>
            <p><strong>Žánr:</strong> <?= htmlspecialchars($book['zanr']) ?></p>
            <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['rok']) ?></p>
            <p><strong>Cena:</strong> <?= number_format($book['cena'], 2) ?> Kč</p>
            <p><strong>Hodnocení:</strong> <?= htmlspecialchars($book['hodnoceni']) ?> / 5</p>
            <p><strong>Anotace:</strong> <?= nl2br(htmlspecialchars($book['anotace'] ?? '')) ?></p>
        </div>
    </div>
</body>
</html>