<?php

try {
    $pdo = new PDO(
        "mysql:host=mysql.railway.internal;port=3306;dbname=railway;charset=utf8mb4",
        "root",
        "jLxvSNdaYyBxdqIQPuFVzlZxrwnVeClu",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 3   // ←これ超重要（固まり防止）
        ]
    );
} catch (Exception $e) {
    die("DB接続エラー: " . $e->getMessage());
}

?>
