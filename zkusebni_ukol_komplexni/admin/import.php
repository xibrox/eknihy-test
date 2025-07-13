<?php
require_once '../includes/auth.php';
require_login();

require_once '../includes/db.php';

$jsonFile = __DIR__ . '/../books.json';

$importedCount = 0;
$errors = [];

if (!file_exists($jsonFile)) {
    $errors[] = "Soubor books.json nebyl nalezen.";
} else {
    $jsonContent = file_get_contents($jsonFile);
    $books = json_decode($jsonContent, true);

    if (!is_array($books)) {
        $errors[] = "Neplatný formát JSON.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO knihy (nazev, autor, zanr, rok, cena, hodnoceni, anotace, obalka_knihy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($books as $index => $book) {
            if (
                empty($book['nazev']) || empty($book['autor']) ||
                !isset($book['zanr']) || !isset($book['rok']) ||
                !isset($book['cena']) || !isset($book['hodnoceni'])
            ) {
                $errors[] = "Chybějící nebo neplatná data u knihy na pozici $index.";
                continue;
            }

            $nazev = trim($book['nazev']);
            $autor = trim($book['autor']);
            $zanr = trim($book['zanr']);
            $rok = (int)$book['rok'];
            $cena = (float)$book['cena'];
            $hodnoceni = (float)$book['hodnoceni'];
            $anotace = trim($book['anotace'] ?? '');
            $obalka = trim($book['obalka_knihy'] ?? '');

            try {
                $stmt->execute([$nazev, $autor, $zanr, $rok, $cena, $hodnoceni, $anotace, $obalka]);
                $importedCount++;
            } catch (Exception $e) {
                $errors[] = "Chyba při vkládání knihy '$nazev': " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Import knih z JSON</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head class="admin">
<body>
    <h1>Import knih z JSON</h1>

    <?php if ($importedCount > 0): ?>
        <div class="success">Bylo úspěšně importováno <?= $importedCount ?> knih.</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Chyby při importu:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <a href="dashboard.php" class="button">← Zpět na dashboard</a>
</body>
</html>
