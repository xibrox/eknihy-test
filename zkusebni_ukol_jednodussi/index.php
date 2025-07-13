<?php
    require_once 'includes/db.php';

    $stmt = $pdo->query("SELECT * FROM knihy");
    $knihy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přehled e-knih</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px auto;
            max-width: 1000px;
            background: #f9f9f9;
            color: #333;
        }

        @media print {
            body {
                background: #fff !important;
                color: #000 !important;
                margin: 0;
                max-width: none;
            }

            .grid {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 0 !important;
                justify-content: flex-start !important;
            }

            .card-link {
                text-decoration: none;
                color: inherit;
                width: 33.3333%;
                box-sizing: border-box;
                display: flex;
                page-break-inside: avoid;
                align-items: stretch;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #aaa;
                page-break-inside: avoid;
                width: 100% !important;
                margin: 8px 8px 8px 0;
                min-height: 1px;
                display: flex;
                flex-direction: column;
                background: #fff;
            }

            .image-wrapper {
                width: 100%;
                margin: 0 auto 10px auto;
                display: block;
                position: static;
            }

            .card img {
                width: 100% !important;
                height: auto !important;
                object-fit: contain;
            }

            .card h2 {
                font-size: 18px;
                margin-top: 0;
                text-align: left;
            }

            .info-row {
                font-size: 15px;
                color: #000;
                display: flex;
                justify-content: space-between;
            }

            h1 {
                text-align: left;
                font-size: 28px;
                margin-bottom: 20px;
            }
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            width: 220px;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .image-wrapper {
            width: 100%;
            aspect-ratio: 3 / 4;
            overflow: hidden;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card h2 {
            font-size: 18px;
            margin: 10px 0 8px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Přehled e-knih</h1>
    <div class="grid">
        <?php foreach ($knihy as $kniha): ?>
            <a href="details.php?id=<?= $kniha['id'] ?>" class="card-link">
                <div class="card">
                    <div class="image-wrapper">
                        <img src="<?= htmlspecialchars($kniha['obalka_knihy'] ?: 'assets/img/default.png') ?>" alt="Obálka knihy">
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
