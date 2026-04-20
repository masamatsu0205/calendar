<?php
require "db.php";

$stmt = $pdo->prepare("
    UPDATE events
    SET date = ?, start_time = ?, end_time = ?, text = ?, color = ?
    WHERE id = ?
");

$stmt->execute([
    $_POST["date"],
    $_POST["start_time"],
    $_POST["end_time"],
    $_POST["text"],
    $_POST["color"],
    $_POST["id"]
]);

echo json_encode(["status" => "ok"]);
?>