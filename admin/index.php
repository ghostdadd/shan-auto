<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
require_once __DIR__ . '/../db.php';
$cars = $pdo->query("SELECT * FROM cars ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #1e293b; padding: 20px; border-right: 1px solid #334155; }
        .main-content { flex: 1; padding: 40px; }
        .card { background: #1e293b; padding: 25px; border-radius: 16px; border: 1px solid #334155; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; color: #94a3b8; padding: 10px; }
        td { padding: 15px; border-bottom: 1px solid #334155; }
        .btn { padding: 8px 12px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; font-size: 13px; }
        .btn-blue { background: #3b82f6; color: white; }
        .btn-red { background: #ef4444; color: white; margin-left: 5px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 style="color:white;">ШАН АВТО</h2>
        <a href="index.php" style="color:#3b82f6; text-decoration:none;">Автомобили</a><br><br>
        <a href="logout.php" style="color:#94a3b8; text-decoration:none;">Выход</a>
    </div>
    <div class="main-content">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1>Список авто</h1>
                <a href="add.php" class="btn btn-blue">+ Добавить</a>
            </div>
            <table>
                <tr><th>Модель</th><th>Цена</th><th>Действия</th></tr>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></td>
                    <td><?= $car['price'] ?> $</td>
                    <td>
                        <a href="edit.php?id=<?= $car['id'] ?>" class="btn btn-blue">Редактировать</a>
                        <a href="delete.php?id=<?= $car['id'] ?>" class="btn btn-red" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>