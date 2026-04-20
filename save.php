<?php
require "db.php";

$stmt = $pdo->prepare("
    INSERT INTO events (date, start_time, end_time, text, color)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $_POST["date"],
    $_POST["start_time"],
    $_POST["end_time"],
    $_POST["text"],
    $_POST["color"]
]);

echo json_encode(["status" => "ok"]);
?>