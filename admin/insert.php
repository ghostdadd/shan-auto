<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
require_once __DIR__ . '/../db.php';

$brand = ($_POST['brand'] === 'other') ? $_POST['brand_custom'] : $_POST['brand'];
$model = $_POST['model'];
// Если год не передан, ставим текущий
$year = !empty($_POST['year']) ? $_POST['year'] : date("Y");
$price = $_POST['price'];
$engine = $_POST['engine_type'];
$power = $_POST['power_hp'];
$torque = $_POST['torque'];
$body = $_POST['body_type'];
$length = $_POST['length'];
$is_available = isset($_POST['is_available']) ? 1 : 0;

$image_name = 'default.jpg';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $upload_dir = __DIR__ . '/../assets/images/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
}

$sql = "INSERT INTO cars (brand, model, year, price, engine_type, power_hp, torque, body_type, length, image, is_available) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$brand, $model, $year, $price, $engine, $power, $torque, $body, $length, $image_name, $is_available]);

header("Location: index.php");