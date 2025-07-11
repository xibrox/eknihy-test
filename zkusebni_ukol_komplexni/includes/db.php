<?php
    $config = require __DIR__ . '/config.php';

    try {
        $pdo = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset=utf8mb4",
            $config['db']['user'],
            $config['db']['pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Chyba připojení k databázi: " . $e->getMessage());
    }
