<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../db.php';

// Получаем ID из URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Запрос данных конкретной машины
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) {
    die("Машина не найдена!");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование: <?= htmlspecialchars($car['model']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; display: flex; justify-content: center; padding: 40px; }
        form { background: #1e293b; padding: 30px; border-radius: 16px; border: 1px solid #334155; width: 100%; max-width: 500px; }
        h2 { margin-top: 0; color: white; }
        input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px; border: 1px solid #334155; background: #0f172a; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 10px; }
        button:hover { background: #2563eb; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #94a3b8; text-decoration: none; }
    </style>
</head>
<body>
    <div style="width: 500px;">
        <a href="index.php" class="back-link">← Назад к списку</a>
        <form action="save.php" method="POST">
            <h2>Редактировать авто</h2>
            <input type="hidden" name="id" value="<?= $car['id'] ?>">
            
            <input type="text" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" placeholder="Бренд" required>
            <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" placeholder="Модель" required>
            <input type="number" name="price" value="<?= $car['price'] ?>" placeholder="Цена" required>
            
            <label><input type="checkbox" name="is_available" value="1" <?= $car['is_available'] ? 'checked' : '' ?>> В наличии</label>
            
            <input type="text" name="engine_type" value="<?= htmlspecialchars($car['engine_type'] ?? '') ?>" placeholder="Двигатель">
            <input type="number" name="power_hp" value="<?= $car['power_hp'] ?? '' ?>" placeholder="Мощность (л.с.)">
            <input type="number" name="torque" value="<?= $car['torque'] ?? '' ?>" placeholder="Крутящий момент">
            <input type="text" name="body_type" value="<?= htmlspecialchars($car['body_type'] ?? '') ?>" placeholder="Кузов">
            <input type="number" name="length" value="<?= $car['length'] ?? '' ?>" placeholder="Длина">
            
            <button type="submit">Сохранить изменения</button>
        </form>
    </div>
</body>
</html>