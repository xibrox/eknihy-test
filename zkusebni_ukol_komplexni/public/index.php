<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

$stmt = $pdo->query("SELECT id, nazev, autor, cena, obalka_knihy FROM knihy ORDER BY nazev");
$knihy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Katalog e-knih</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="header-actions">
        <?php if (is_logged_in()): ?>
            <a href="../admin/dashboard.php" class="button">Dashboard</a>
            <a href="../admin/logout.php" class="button button-secondary">Odhlásit se</a>
        <?php else: ?>
            <a href="../admin/login.php" class="button">Přihlásit se</a>
        <?php endif; ?>
    </div>
    
    <h1>Katalog e-knih</h1>
    
    <div class="main-actions">
        <button class="print-button" onclick="window.print()">Tisk</button>
    </div>
    
    <div class="grid">
        <?php foreach ($knihy as $kniha): ?>
            <a href="details.php?id=<?= $kniha['id'] ?>" class="card-link">
                <div class="card">
                    <div class="image-wrapper">
                        <?php
                        $src = (isset($kniha['obalka_knihy']) && str_starts_with($kniha['obalka_knihy'], 'assets/img/'))
                            ? '../' . htmlspecialchars($kniha['obalka_knihy'])
                            : '../assets/img/default.png';
                        ?>
                        <img src="<?= $src ?>" alt="Obálka knihy">
                    </div>
                    <h2><?= htmlspecialchars($kniha['nazev']) ?></h2>
                    <div class="info-row">
                        <span><?= htmlspecialchars($kniha['autor']) ?></span>
                        <span><?= number_format($kniha['cena'], 2) ?> Kč</span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</body>
</html>