<?php
require "db.php";

$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$_POST["id"]]);

echo json_encode(["status" => "ok"]);
?>