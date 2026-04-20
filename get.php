<?php
require "db.php";

$stmt = $pdo->query("SELECT * FROM events ORDER BY date, start_time");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows, JSON_UNESCAPED_UNICODE);
?>