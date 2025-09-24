<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $for_whom = trim($_POST['for_whom'] ?? '');
    $budget = trim($_POST['budget'] ?? '0');
    $description = trim($_POST['description'] ?? '');

    // Валидация
    if (empty($title) || empty($for_whom)) {
        $error = "Название и получатель обязательны.";
    } elseif (!is_numeric($budget) || $budget < 0) {
        $error = "Бюджет должен быть числом ≥ 0.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO gifts (title, description, for_whom, budget) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $for_whom, $budget]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>➕ Добавить подарок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-container { max-width: 600px; margin: 2rem auto; }
        .card { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: none; }
    </style>
</head>
<body>
<div class="form-container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0"><i class="bi bi-gift-fill"></i> Добавить подарок</h2>
        </div>
        <div class="card-body">
            <a href="index.php" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Назад к списку
            </a>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Название подарка <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required 
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Для кого <span class="text-danger">*</span></label>
                    <input type="text" name="for_whom" class="form-control" required 
                           value="<?= htmlspecialchars($_POST['for_whom'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Бюджет (₽) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="budget" class="form-control" required 
                           value="<?= htmlspecialchars($_POST['budget'] ?? '0') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Описание</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-plus-circle"></i> Сохранить подарок
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
