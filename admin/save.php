<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
require_once __DIR__ . '/../db.php';

$id = $_POST['id'];
$brand = ($_POST['brand'] === 'other') ? $_POST['brand_custom'] : $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$is_available = isset($_POST['is_available']) ? 1 : 0;

// Если загрузили новое фото
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/' . $image_name);
    $stmt = $pdo->prepare("UPDATE cars SET brand=?, model=?, price=?, is_available=?, image=? WHERE id=?");
    $stmt->execute([$brand, $model, $price, $is_available, $image_name, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE cars SET brand=?, model=?, price=?, is_available=? WHERE id=?");
    $stmt->execute([$brand, $model, $price, $is_available, $id]);
}

header("Location: index.php");