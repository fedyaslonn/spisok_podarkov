<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}

// Получаем текущий статус
$stmt = $pdo->prepare("SELECT status FROM gifts WHERE id = ?");
$stmt->execute([$id]);
$current = $stmt->fetchColumn();

$newStatus = ($current === 'не куплен') ? 'куплен' : 'не куплен';

$stmt = $pdo->prepare("UPDATE gifts SET status = ? WHERE id = ?");
$stmt->execute([$newStatus, $id]);

header("Location: index.php");
exit;
?>
