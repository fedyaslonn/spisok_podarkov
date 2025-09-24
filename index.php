<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM gifts ORDER BY created_at DESC");
$gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>🎁 Список подарков</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f9f6f0; }
        .card-header { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; }
        .status-not-bought { background-color: #fff3cd; border-left: 4px solid #ffc107; }
        .status-bought { background-color: #d4edda; border-left: 4px solid #28a745; }
        .gift-card { transition: transform 0.2s; }
        .gift-card:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .budget-badge { font-size: 1.1rem; font-weight: 600; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary"><i class="bi bi-gift"></i> Список подарков</h1>
        <a href="add.php" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Добавить подарок
        </a>
    </div>

    <?php if (empty($gifts)): ?>
        <div class="text-center py-5">
            <div class="display-6 text-muted mb-3">Список пуст</div>
            <p class="lead">Начните с добавления первого подарка!</p>
            <a href="add.php" class="btn btn-outline-primary">➕ Создать подарок</a>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($gifts as $gift): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card gift-card <?= $gift['status'] === 'не куплен' ? 'status-not-bought' : 'status-bought' ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($gift['title']) ?></h5>
                                <span class="badge <?= $gift['status'] === 'не куплен' ? 'bg-warning text-dark' : 'bg-success' ?>">
                                    <?= $gift['status'] === 'не куплен' ? 'Не куплен' : 'Куплен' ?>
                                </span>
                            </div>
                            <p class="text-muted mb-1"><i class="bi bi-person"></i> <strong>Для:</strong> <?= htmlspecialchars($gift['for_whom']) ?></p>
                            <p class="budget-badge text-primary mb-2">
                                <i class="bi bi-cash"></i> <?= number_format($gift['budget'], 2, ',', ' ') ?> ₽
                            </p>
                            <?php if (!empty($gift['description'])): ?>
                                <p class="card-text text-muted small"><?= htmlspecialchars($gift['description']) ?></p>
                            <?php endif; ?>
                            <div class="d-flex gap-2 mt-3">
                                <a href="edit.php?id=<?= $gift['id'] ?>" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <a href="update_status.php?id=<?= $gift['id'] ?>" 
                                   class="btn btn-sm <?= $gift['status'] === 'не куплен' ? 'btn-success' : 'btn-secondary' ?> flex-grow-1">
                                    <?php if ($gift['status'] === 'не куплен'): ?>
                                        <i class="bi bi-check-circle"></i> Купить
                                    <?php else: ?>
                                        <i class="bi bi-arrow-counterclockwise"></i> Отменить
                                    <?php endif; ?>
                                </a>
                                <a href="delete.php?id=<?= $gift['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Вы уверены, что хотите удалить этот подарок?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
