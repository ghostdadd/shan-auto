<?php
require_once __DIR__ . '/db.php';
// Пагинация
$limit = 15; // Как ты просил: 15 объявлений на странице
$page = isset($_GET['page']) ? (max(1, (int)$_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Сортировка
$sort_map = ['price_asc' => 'price ASC', 'price_desc' => 'price DESC'];
$sort_query = $sort_map[$_GET['sort_by'] ?? ''] ?? 'views DESC';

// Получаем общее количество машин для расчета страниц
$total_cars = $pdo->query("SELECT COUNT(*) FROM cars")->fetchColumn();
$total_pages = ceil($total_cars / $limit);

// Запрос с LIMIT и OFFSET
$stmt = $pdo->prepare("SELECT * FROM cars ORDER BY $sort_query LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$cars = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шан авто | Электромобили из Китая в РБ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --dark-bg: #0f172a; --card-bg: #1e293b; --accent-blue: #3b82f6; --text-light: #f8fafc; --text-muted: #94a3b8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--dark-bg); color: var(--text-light); margin: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        header { background: #1e293b; border-bottom: 3px solid var(--accent-blue); padding: 20px 0; }
        .sorting-panel { margin: 40px 0 20px 0; background: var(--card-bg); padding: 15px 20px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
        .sorting-buttons a { padding: 8px 16px; background: #334155; color: var(--text-light); text-decoration: none; border-radius: 6px; margin-left: 10px; }
        .sorting-buttons a.active { background: var(--accent-blue); }
        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; margin-bottom: 40px; }
        .car-card { background: var(--card-bg); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; }
        .car-img-box { width: 100%; height: 220px; background: #000; }
        .car-img-box img { width: 100%; height: 100%; object-fit: cover; }
        .car-info { padding: 20px; flex-grow: 1; }
        .car-specs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 15px 0; padding: 15px 0; border-top: 1px solid #334155; border-bottom: 1px solid #334155; font-size: 14px; color: var(--text-muted); }
        .btn-connect { display: block; text-align: center; background: var(--accent-blue); color: white; padding: 12px; margin-top: 15px; border-radius: 6px; text-decoration: none; }
        
        /* Стили блока экспертов */
        .experts-section { background: #1e293b; padding: 40px; border-radius: 20px; margin: 40px 0; border: 1px solid #334155; display: flex; gap: 30px; flex-wrap: wrap; }
        .expert-card { flex: 1; display: flex; align-items: flex-start; gap: 20px; min-width: 300px; }
        .expert-img { width: 80px; height: 80px; border-radius: 50%; border: 2px solid #3b82f6; object-fit: cover; flex-shrink: 0; }
    </style>
</head>
<body>

<header>
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
        <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 15px;">
            <div style="background: #334155; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 2px dashed #475569;">Лого</div>
            <div>
                <h1 style="margin: 0; font-size: 28px;">ШАН АВТО</h1>
                <p style="margin: 0; font-size: 12px; color: #94a3b8; text-transform: uppercase;">Электромобили из Китая</p>
            </div>
        </a>
        <a href="tel:+375251234567" style="color: #fff; text-decoration: none; padding: 10px 20px; background: #0f172a; border-radius: 8px;">
            <i class="fa-solid fa-phone" style="color: #3b82f6;"></i> +375 (25) 123-45-67
        </a>
    </div>
</header>

<div class="container">
    <div class="sorting-panel">
        <div>Сортировать:</div>
        <div class="sorting-buttons">
            <?php $c = $_GET['sort_by'] ?? ''; ?>
            <a href="?" class="<?= $c == '' ? 'active' : '' ?>">Популярность</a>
            <a href="?sort_by=price_asc" class="<?= $c == 'price_asc' ? 'active' : '' ?>">Дешевые</a>
            <a href="?sort_by=price_desc" class="<?= $c == 'price_desc' ? 'active' : '' ?>">Дорогие</a>
        </div>
    </div>

    <main class="catalog-grid">
        <?php foreach($cars as $car): ?>
        <a href="car.php?id=<?= $car['id'] ?>" style="text-decoration: none; color: inherit;">
            <div class="car-card">
                <div class="car-img-box"><img src="assets/images/<?= htmlspecialchars($car['image'] ?? 'default.jpg') ?>"></div>
                <div class="car-info">
                    <h2><?= htmlspecialchars(($car['brand'] ?? '') . ' ' . ($car['model'] ?? '')) ?></h2>
                    <div class="car-specs">
                        <div><i class="fa-solid fa-battery-full"></i> <?= htmlspecialchars($car['battery_capacity'] ?? '0') ?> кВт·ч</div>
                        <div><i class="fa-solid fa-bolt"></i> <?= htmlspecialchars($car['power_hp'] ?? '0') ?> л.с.</div>
                    </div>
                    <div style="font-size: 20px; font-weight: bold;"><?= number_format((float)($car['price'] ?? 0), 0, '.', ' ') ?> $</div>
                    <div class="btn-connect">Подробнее</div> 
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </main>
<style>
    .pagination { display: flex; justify-content: center; gap: 10px; margin: 40px 0; }
    .pagination a { padding: 10px 18px; background: #1e293b; color: #fff; text-decoration: none; border-radius: 6px; border: 1px solid #334155; }
    .pagination a.active { background: #3b82f6; border-color: #3b82f6; }
</style>

<div class="pagination">
    <?php 
    $current_sort = $_GET['sort_by'] ?? '';
    for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>&sort_by=<?= $current_sort ?>" 
           class="<?= $i == $page ? 'active' : '' ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
    <section class="experts-section">
        <div class="expert-card">
            <img src="assets/images/dmitry.jpg" class="expert-img">
            <div>
                <h4 style="margin: 0; color: #fff;">Дмитрий Баринов</h4>
                <p style="font-size: 14px; color: #94a3b8; margin-bottom: 10px;">Специалист по подбору авто. Помогу выбрать лучшее решение для вас.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="https://t.me/твой_юзернейм" target="_blank" style="color: #229ED9; font-size: 20px;"><i class="fa-brands fa-telegram"></i></a>
                    <a href="https://wa.me/номер_телефона" target="_blank" style="color: #25D366; font-size: 20px;"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="viber://chat?number=номер" style="color: #7360F2; font-size: 20px;"><i class="fa-brands fa-viber"></i></a>
                </div>
            </div>
        </div>
        
        <div class="expert-card">
            <img src="assets/images/sergey.jpg" class="expert-img">
            <div>
                <h4 style="margin: 0; color: #fff;">Сергей Сургунцев</h4>
                <p style="font-size: 14px; color: #94a3b8; margin-bottom: 10px;">Эксперт по логистике. Сопровождаю сделку от Китая до выдачи ключей.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="https://t.me/твой_юзернейм" target="_blank" style="color: #229ED9; font-size: 20px;"><i class="fa-brands fa-telegram"></i></a>
                    <a href="https://wa.me/номер_телефона" target="_blank" style="color: #25D366; font-size: 20px;"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="viber://chat?number=номер" style="color: #7360F2; font-size: 20px;"><i class="fa-brands fa-viber"></i></a>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>