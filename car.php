<?php
require_once __DIR__ . '/db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();
if (!$car) die("Машина не найдена. <a href='index.php'>Вернуться назад</a>");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .hero { display: grid; grid-template-columns: 1fr 350px; gap: 40px; margin-bottom: 60px; }
        .photo-box { background: #1e293b; border-radius: 20px; overflow: hidden; }
        .photo-box img { width: 100%; display: block; }
        .price-card { background: #1e293b; padding: 30px; border-radius: 20px; height: fit-content; border: 1px solid #334155; }
        .price { font-size: 32px; font-weight: 800; color: #3b82f6; margin: 20px 0; }
        .btn-call { display: block; background: #3b82f6; color: white; padding: 15px; text-align: center; border-radius: 10px; text-decoration: none; font-weight: bold; }
        
        .specs-group { margin-bottom: 30px; }
        .specs-group h3 { color: #3b82f6; border-bottom: 1px solid #334155; padding-bottom: 10px; font-size: 1.2rem; }
        .specs-table { width: 100%; border-collapse: collapse; }
        .specs-table td { padding: 12px 0; border-bottom: 1px solid #1e293b; color: #94a3b8; }
        .specs-table td:last-child { text-align: right; color: #f8fafc; font-weight: 500; }
        
        /* Стили экспертов */
        .expert-card { background: #1e293b; padding: 25px; border-radius: 20px; display: flex; align-items: flex-start; gap: 20px; border: 1px solid #334155; }
        .expert-img { width: 80px; height: 80px; border-radius: 50%; border: 2px solid #3b82f6; object-fit: cover; flex-shrink: 0; }
        
        @media (max-width: 768px) { .hero { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <a href="index.php" style="color: #94a3b8; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Назад к каталогу</a>
    
    <div class="hero" style="margin-top: 20px;">
        <div class="photo-box">
            <img src="assets/images/<?= htmlspecialchars($car['image'] ?? 'default.jpg') ?>">
        </div>
        <div class="price-card">
<div style="margin-bottom: 15px;">
    <?php if (($car['is_available'] ?? 1) == 1): ?>
        <span style="background: #064e3b; color: #10b981; padding: 5px 12px; border-radius: 6px; font-size: 14px; border: 1px solid #10b981;">
            <i class="fa-solid fa-check-circle"></i> В наличии
        </span>
    <?php else: ?>
        <span style="background: #78350f; color: #f59e0b; padding: 5px 12px; border-radius: 6px; font-size: 14px; border: 1px solid #f59e0b;">
            <i class="fa-solid fa-clock"></i> Под заказ
        </span>
    <?php endif; ?>
</div>
            <h1 style="margin: 0;"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h1>
            <div class="price"><?= number_format((float)($car['price'] ?? 0), 0, '.', ' ') ?> $</div>
            <a href="#manager" class="btn-call">Связаться с менеджером</a>
        </div>
    </div>

    <h2 style="margin-bottom: 30px;">Технические характеристики</h2>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
        <div>
            <div class="specs-group">
                <h3>Двигатель</h3>
                <table class="specs-table">
                    <tr><td>Тип двигателя</td><td><?= htmlspecialchars($car['engine_type'] ?? '—') ?></td></tr>
                    <tr><td>Мощность</td><td><?= htmlspecialchars($car['power_hp'] ?? '—') ?> л.с.</td></tr>
                    <tr><td>Крутящий момент</td><td><?= htmlspecialchars($car['torque'] ?? '—') ?> нм</td></tr>
                </table>
            </div>
        </div>
        <div>
            <div class="specs-group">
                <h3>Габариты авто</h3>
                <table class="specs-table">
                    <tr><td>Кузов</td><td><?= htmlspecialchars($car['body_type'] ?? '—') ?></td></tr>
                    <tr><td>Длина</td><td><?= htmlspecialchars($car['length'] ?? '—') ?> мм</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div id="manager" style="margin-top: 60px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="expert-card">
                <img src="assets/images/dmitry.jpg" class="expert-img" alt="Дмитрий">
                <div>
                    <h3 style="margin: 0; color: white;">Дмитрий Баринов</h3>
                    <p style="color: #94a3b8; font-size: 14px; margin: 10px 0;">Специалист по подбору автомобилей «под ключ». Дмитрий глубоко анализирует рынок Китая.</p>
                    <div style="display: flex; gap: 15px;">
                        <a href="#"><i class="fa-brands fa-telegram" style="color: #3b82f6;"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp" style="color: #25d366;"></i></a>
                        <a href="#"><i class="fa-solid fa-phone" style="color: #a855f7;"></i></a>
                    </div>
                </div>
            </div>
            <div class="expert-card">
                <img src="assets/images/sergey.jpg" class="expert-img" alt="Сергей">
                <div>
                    <h3 style="margin: 0; color: white;">Сергей Сургунцев</h3>
                    <p style="color: #94a3b8; font-size: 14px; margin: 10px 0;">Эксперт по логистике и таможенному оформлению в РБ. Сергей берет на себя все аспекты.</p>
                    <div style="display: flex; gap: 15px;">
                        <a href="#"><i class="fa-brands fa-telegram" style="color: #3b82f6;"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp" style="color: #25d366;"></i></a>
                        <a href="#"><i class="fa-solid fa-phone" style="color: #a855f7;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>