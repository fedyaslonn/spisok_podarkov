<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM gifts WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>
