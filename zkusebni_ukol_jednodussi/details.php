<?php
    require_once 'includes/db.php';

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
    <style>
        body {
            font-family: sans-serif;
            background: #f6f6f6;
            color: #333;
            margin: 40px auto;
            max-width: 900px;
        }

        .book-detail {
            display: flex;
            gap: 30px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .image-wrapper {
            flex: 0 0 240px;
            overflow: hidden;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease;
            display: block;
        }

        .image-wrapper:hover img {
            transform: scale(1.03);
        }

        .book-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .book-info h2 {
            margin: 0 0 20px;
            font-size: 26px;
        }

        .book-info p {
            margin: 6px 0;
            font-size: 16px;
        }

        .label {
            color: #666;
            margin-right: 6px;
        }

        .value {
            font-weight: 500;
            color: #111;
        }

        .back-link {
            margin-bottom: 25px;
            text-align: left;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-size: 15px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Zpět na přehled knih</a>
    </div>

    <div class="book-detail">
        <div class="image-wrapper">
            <img src="<?= htmlspecialchars($book['obalka_knihy'] ?: 'assets/img/default.png') ?>" alt="Obálka knihy">
        </div>
        <div class="book-info">
            <h2><?= htmlspecialchars($book['nazev']) ?></h2>
            <p><span class="label">Autor:</span><span class="value"><?= htmlspecialchars($book['autor']) ?></span></p>
            <p><span class="label">Žánr:</span><span class="value"><?= htmlspecialchars($book['zanr']) ?></span></p>
            <p><span class="label">Rok vydání:</span><span class="value"><?= htmlspecialchars($book['rok']) ?></span></p>
            <p><span class="label">Cena:</span><span class="value"><?= number_format($book['cena'], 2) ?> Kč</span></p>
            <p><span class="label">Hodnocení:</span><span class="value"><?= htmlspecialchars($book['hodnoceni']) ?> / 5</span></p>
        </div>
    </div>
</body>
</html>
